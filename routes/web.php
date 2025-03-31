<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RastreioController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/rastreio/{id}', [RastreioController::class, 'show'])->name('rastreio.show');


Route::get('/email', function () {
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
    ];

    $dadosFicticios = [
        'name' => 'Ana Souza',
        'trackingCode' => 'BR'.strtoupper(Str::random(2)).rand(100000000, 999999999).'BR',
        'statuses' => $statuses,
        'currentStatusKey' => 'pacote_trafego_interrompido', // Altere aqui para testar diferentes status
        'currentStatus' => $statuses['pacote_trafego_interrompido']
    ];

    return view('emails.tracking_code', $dadosFicticios);
});