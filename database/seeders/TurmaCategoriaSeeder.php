<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TurmaCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create("pt_BR");
            DB::table('turma_categoria')->insert(
                [
                    [
                        'nome' => "Técnico",
                        'sigla' => "TEC",
                    ],
                    [
                        'nome' => "Graduação",
                        'sigla' => "GRA",
                    ],
                    [
                        'nome' => "Especialização",
                        'sigla' => "ESP",
                    ],
                    [
                        'nome' => "Mestrado",
                        'sigla' => "MES",
                    ],
                    [
                        'nome' => "Douturado",
                        'sigla' => "DR",
                    ],
                    [
                        'nome' => "Pós-Douturado",
                        'sigla' => "PHD",
                    ],
                    [
                        'nome' => "Profissionalizante",
                        'sigla' => "FIC",
                    ]
                ]

            );
    }
}
