<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Carrier;
use App\Models\OrderTrackingHistory;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrackingCodeMail;
use App\Mail\TrackingUpdateMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendTrackingCodes extends Command
{
    protected $signature = 'send:tracking-codes {--test : Modo teste - não envia realmente emails}';

    protected $description = 'Envia emails de rastreio e atualizações para clientes';

    public function handle()
    {
        $today = Carbon::today();
        $initialEmailsSent = 0;
        $updateEmailsSent = 0;
        $isTestMode = $this->option('test');

        // 1. Processa emails iniciais dos carriers
        $carriers = Carrier::whereNull('email_sent_at')
            ->whereDate('created_at', '<=', $today)
            ->get();

        if ($carriers->isNotEmpty()) {
            $this->info("Processando {$carriers->count()} emails iniciais...");
            $bar = $this->output->createProgressBar($carriers->count());

            foreach ($carriers as $carrier) {
                    if (!$isTestMode) {
                        try {
                            $this->sendInitialEmail($carrier);
                            $carrier->update(['email_sent_at' => now()]);
                            $initialEmailsSent++;
                            
                            Log::info("Email inicial enviado para {$carrier->email}", [
                                'carrier_id' => $carrier->id,
                                'tracking_code' => $carrier->tracking_code
                            ]);
                        } catch (\Exception $e) {
                            Log::error("Falha ao enviar email inicial para {$carrier->email}", [
                                'error' => $e->getMessage(),
                                'carrier_id' => $carrier->id
                            ]);
                        }
                    } else {
                        $this->info("[TESTE] Email seria enviado para: {$carrier->email}");
                        $initialEmailsSent++;
                    }
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
        }

        // 2. Processa atualizações de tracking
        $trackingHistory = OrderTrackingHistory::with('carrier')
            ->whereNull('email_sent_at')
            ->whereDate('created_at', '<=', $today)
            ->whereHas('carrier', function($query) {
                $query->whereNotNull('email');
            })
            ->get();

        if ($trackingHistory->isNotEmpty()) {
            $this->info("Processando {$trackingHistory->count()} atualizações...");
            $bar = $this->output->createProgressBar($trackingHistory->count());

            foreach ($trackingHistory as $history) {
                    if (!$isTestMode) {
                        try {
                            $this->sendUpdateEmail($history);
                            $history->update(['email_sent_at' => now()]);
                            $updateEmailsSent++;
                            
                            Log::info("Email de atualização enviado para {$history->carrier->email}", [
                                'history_id' => $history->id,
                                'status' => $history->status
                            ]);
                        } catch (\Exception $e) {
                            Log::error("Falha ao enviar email de atualização", [
                                'error' => $e->getMessage(),
                                'history_id' => $history->id
                            ]);
                        }
                    } else {
                        $this->info("[TESTE] Atualização seria enviada para: {$history->carrier->email}");
                        $updateEmailsSent++;
                    }
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
        }

        $this->info("Processamento completo!");
        $this->info("Emails iniciais enviados: {$initialEmailsSent}");
        $this->info("Atualizações enviadas: {$updateEmailsSent}");
    }


    protected function hasValidHistoryEmail(OrderTrackingHistory $history)
    {
        $email = $history->carrier->email ?? null;
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function sendInitialEmail(Carrier $carrier)
    {
        Mail::to($carrier->email)->send(new TrackingCodeMail(
            $carrier->tracking_code,
            $carrier->customer ?? 'Cliente', // Garante fallback
        ));
    }


    protected function sendUpdateEmail(OrderTrackingHistory $history)
{
    $carrier = $history->carrier;
    
    if (!$carrier || !$carrier->email) {
        Log::error("Carrier ou email não encontrado para histórico", ['history_id' => $history->id]);
        return;
    }

    // Obter todos os status históricos até o atual
    $allStatuses = OrderTrackingHistory::where('carrier_id', $history->carrier_id)
        ->where('created_at', '<=', $history->created_at) // Apenas até o status atual
        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function ($item) {
            $statusTitles = [
                'pacote_coleta' => 'Coleta iniciada',
                'pacote_emitido' => 'Pacote emitido',
                'pacote_movimentacao' => 'Em transporte',
                'pacote_chegou_transportadora' => 'Chegou ao centro',
                'pacote_outra_unidade' => 'Rumo à entrega',
                'pacote_trafego_interrompido' => 'Tráfego interrompido',
                'pacote_saiu_entrega' => 'Saiu para entrega',
                'pacote_entrega_nao_efetuada' => 'Entrega não realizada',
                'pacote_entregue' => 'Entregue'
            ];
            
            return [
                'title' => $statusTitles[$item->type] ?? $item->status,
                'type' => $item->type,
                'status' => $item->status,
                'description' => $item->description,
                'location' => $item->location,
                'date' => $item->created_at->format('d/m/Y H:i')
            ];
        });

    // O índice atual será sempre o último, já que filtramos apenas até o atual
    $currentStatusIndex = $allStatuses->count() - 1;

    Mail::to($carrier->email)->send(new TrackingUpdateMail(
        $carrier->tracking_code,
        $carrier->customer ?? 'Cliente',
        $history->status ?? 'Status não informado',
        $history->description ?? 'Descrição não disponível',
        $history->created_at->format('d/m/Y H:i'),
        $allStatuses->toArray(),
        $currentStatusIndex,
        $history->location ?? 'Local não informado'
    ));
}

}