<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Warehouse;
use Faker\Factory as Faker;

class GenerateWarehouses extends Command
{
    protected $signature = 'generate:warehouses {quantity=50}';
    protected $description = 'Gera Warehouses aleatórios para o Brasil inteiro';


    public function handle()
{
    // Configuração inicial
    $faker = Faker::create('pt_BR'); // Localização em português do Brasil
    $quantity = $this->argument('quantity'); // Quantidade de hubs a criar
    $states = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

    $this->info("Gerando $quantity Warehouses aleatórios para o Brasil...");

    // Garante que sejam gerados pelo menos 2 hubs para cada estado
    foreach ($states as $state) {
        // Cria pelo menos 1 hubs por estado
        for ($i = 0; $i < 1; $i++) {
            // Seleciona uma cidade aleatória
            $city = $faker->city;

            // Gera o endereço aleatório
            $address = $faker->streetAddress . ", " . $city . " - " . $state;

            // Gera coordenadas geográficas (latitude e longitude)
            $latitude = $faker->latitude(-33.75, 5.26); // Latitude do Brasil
            $longitude = $faker->longitude(-73.99, -34.79); // Longitude do Brasil

            $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Cria o registro na tabela 'hubs'
            Warehouse::create([
                'name' => $state . $randomNumber . 'BR',
                'address' => $address,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'state' => $state,
                'city' => $city,
            ]);
        }
    }

    $this->info("Warehouses gerados com sucesso!");
}

}
