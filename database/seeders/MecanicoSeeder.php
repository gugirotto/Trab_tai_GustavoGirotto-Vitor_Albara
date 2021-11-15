<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MecanicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create("pt_BR");
        foreach (\range(1, 10) as $index) {
            DB::table('mecanico')->insert([
                'nome' => $faker->lastName,
                'cpf' => $faker->randomNumber($nbDigits = 9, $strict = false),
            ]);
        }
    }
}
