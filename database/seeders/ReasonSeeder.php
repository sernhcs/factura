<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            ['name' => 'Ajuste por inventario', 'type' => 1],
            ['name' => 'Venta', 'type' => 2],
            ['name' => 'Devolución de cliente', 'type' => 2],
            ['name' => 'Produccion terminada', 'type' => 1],
            ['name' => 'Ajuste de Inventario Positivo', 'type' => 1],
            ['name' => 'Ajuste de Inventario Negativo', 'type' => 2],
            // Razones para salida
            ['name' => 'Consumo interno', 'type' => 2],
            ['name' => 'Merma', 'type' => 2],
            ['name' => 'Caducidad ', 'type' => 2],
            ['name' => 'Muestra gratis', 'type' => 2],
            ['name' => 'Donación', 'type' => 2],
        ];
   
        foreach ($reasons as $reason) {
            \App\Models\Reason::create($reason);
        }
    }
}
