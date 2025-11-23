<?php

namespace Database\Seeders;

use App\Models\Identity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identities=[
            'Sin docuemnto',
            'DNI',
            'Carnet de extranjería',
            'RUC',
            'Pasaporte',
        ];  
        foreach($identities as $identity){
            Identity::create(
                ['name'=>$identity
            ]);
        }
    }
}
