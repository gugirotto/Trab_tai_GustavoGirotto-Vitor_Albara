<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\models\Serviço;

use Faker\Factory as Faker;

class ServiçoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create("pt_BR");
        $servicos = Serviço::all();
		$ids = array();
		
		foreach($servicos as $p){
			array_push($ids, $p->id);
		}
		
		for($i = 0; $i < 20; $i++){
			
			DB::table('servico')->insert([
                'usuario_id' => '1',
                'horario' => $faker->date,
                'placa' => $faker->word,
                'mecanico_id' => '1',
			]);
		}
    }
       
}
