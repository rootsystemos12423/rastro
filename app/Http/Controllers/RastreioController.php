<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrier;
use App\Models\OrderTrackingHistory;
use App\Models\Order;
use App\Mail\TrackingCodeMail;
use Illuminate\Support\Facades\Mail;

class RastreioController extends Controller
{
    public function show($id){

        $pedido = Carrier::where('tracking_code', $id)->first();

        return view('rastreio', compact('pedido', 'id'));
    }

    public function reciveOrder(Request $request)
    {
        // Receber os dados do webhook
        $data = $request->json()->all();

        if (empty($data['resource']['address']) || empty($data['resource']['address']['city'])) {
            return response()->json([
                'error' => 'Dados do endereço inválidos.'
            ], 200); // Status 200, com mensagem de erro
        }

        $cpf = Carrier::where('taxacao_payment_link', $data['resource']['customer']['doc'])->first();

        if ($cpf) {
            return response()->json(['error' => 'Pedido Ja Cadastrado'], 200);
        }
        
        // Validar se os dados do webhook estão corretos
        if (empty($data['resource']['address']) || empty($data['resource']['address']['city'])) {
            return response()->json(['error' => 'Dados do endereço inválidos.'], 200);
        }

        $randomCode = $this->generateRandomCode();

        // Criar o pedido (order)
        $carrier = Carrier::create([
            'name' => 'Jadlog',
            'tracking_code' => $randomCode,
            'taxacao_payment_link' => $data['resource']['customer']['doc'],
        ]);

        // Criar o pedido (order)
        $order = Order::create([
            'address' => json_encode($data['resource']['address']),
            'delivery_date' => now()->addDays(35), // Prazo de entrega definido para 35 dias a partir de hoje
        ]);

        $randomStates = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 
            'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 
            'RR', 'SC', 'SP', 'SE', 'TO',
        ];
        
        // Gerar um array de estados aleatórios
        $numberOfStates = 10; // Quantidade de estados desejados
        $randomStateArray = [];
        
        for ($i = 0; $i < $numberOfStates; $i++) {
            $randomStateArray[] = $randomStates[array_rand($randomStates)];
        }
        

        $stateAbbreviation = substr($data['resource']['address']['uf'], 0, 2);

        // Simular o cálculo do trajeto
        $routeDetails = $this->GenerateRoute(
            $order->id, 
            $data['resource']['address']['uf'], // Apenas o estado de início
            $randomStateArray[array_rand($randomStateArray)],
            $carrier // Um estado aleatório como destino
        );
        

        $email = $data['resource']['customer']['email'];

        $nome = $data['resource']['customer']['first_name'];

        Mail::to($email)->send(new TrackingCodeMail($carrier->tracking_code, $nome));

        // Retornar o sucesso com detalhes do trajeto
        return response()->json([
            'order_id' => $order->id,
            'delivery_date' => $order->delivery_date,
            'route' => $routeDetails,
        ]);


    }

    /**
     * Simulação do cálculo do trajeto (tempo estimado para a entrega)
     */
    private function GenerateRoute($orderId, $endState, $startState, $carrier)
{
    // Definindo os status fictícios do trajeto
    $statuses = [
        'pacote_coleta' => [
            'subtitle' => 'Coleta iniciada',
            'description' => 'O pacote foi coletado e está a caminho do centro de distribuição.'
        ],
        'pacote_emitido' => [
            'subtitle' => 'Pacote emitido',
            'description' => 'O pacote foi emitido e registrado na transportadora, aguardando movimentação.'
        ],
        'pacote_movimentacao' => [
            'subtitle' => 'Movimentação em andamento',
            'description' => 'O pacote está em rota e sendo transportado para o destino final.'
        ],
        'pacote_chegou_transportadora' => [
            'subtitle' => 'Chegada ao hub',
            'description' => 'O pacote chegou ao hub de distribuição e está sendo preparado para a próxima etapa.'
        ],
        'pacote_outra_unidade' => [
            'subtitle' => 'Rumo à entrega',
            'description' => 'O pacote está em outra unidade e será preparado para a entrega final.'
        ],
        'pacote_trafego_interrompido' => [
            'subtitle' => 'Tráfego interrompido',
            'description' => 'Houve um atraso devido a algum tipo de interrupção no tráfego ou outros fatores externos.'
        ],
        'pacote_saiu_entrega' => [
            'subtitle' => 'Saída para entrega',
            'description' => 'O pacote foi liberado para entrega e está a caminho do endereço do destinatário.'
        ],
        'pacote_entrega_nao_efetuada' => [
            'subtitle' => 'Entrega não realizada',
            'description' => 'Infelizmente, a entrega não pôde ser realizada. O pacote será redirecionado para nova tentativa.'
        ],
        'pacote_entregue' => [
            'subtitle' => 'Pacote entregue',
            'description' => 'O pacote foi entregue com sucesso no endereço do destinatário.'
        ],
    ];
    

    // Gerando o trajeto com status para cada parada
    $currentStep = 0;
    $statusDate = now(); // Data inicial para as paradas

    // Garantir que o loop não ultrapasse o número de status disponíveis
    foreach ($statuses as $statusKey => $statusData) {
        // Gerar número aleatório de 4 dígitos
        $randomNumber = rand(1000, 9999);

        // Gerar localização dinâmica
        $location = ($statusKey === 'pacote_coleta') 
        ? "{$startState} {$randomNumber} BR" 
        : (
            in_array($statusKey, ['pacote_entregue', 'pacote_saiu_entrega', 'pacote_entrega_nao_efetuada']) 
            ? "{$endState} {$randomNumber} BR" 
            : "{$startState} {$randomNumber} BR"
        );
    
        OrderTrackingHistory::create([
            'carrier_id' => $carrier->id, // Defina o carrier_id conforme necessário
            'type' => $statusKey, // A chave do array vai para 'type'
            'status' => $statusData['subtitle'], // O subtítulo vai para 'status'
            'description' => $statusData['description'], // A descrição vai para 'description'
            'location' => $location, // Localização gerada dinamicamente
            'created_at' => $statusDate, // Data de criação
            'updated_at' => $statusDate, // Data de atualização
        ]);

        // Incrementar o tempo para o próximo status
        $statusDate = $statusDate->addDays(rand(1, 5)) // Incrementa de 1 a 5 dias
        ->setTime(rand(9, 17), rand(0, 59), rand(0, 59)); // Hora entre 9:00 e 17:00, com minutos e segundos aleatórios

    }
}

    
function generateRandomCode() {
    // Gera 3 letras aleatórias para as duas primeiras partes
    $part1 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4));
    $part2 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
    // Gera 2 letras aleatórias para a terceira parte
    $part3 = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
    // Gera 3 números aleatórios para a parte final
    $numbers = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
    
    // Combina todas as partes no formato desejado
    return $part1 . $part2 . $part3 . $numbers;
}
    

}
