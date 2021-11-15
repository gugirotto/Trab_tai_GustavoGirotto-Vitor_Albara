<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\models\Login;

use Faker\Factory as Faker;

class VeiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create("pt_BR");
        $usuaros = Login::all();
		$ids = array();
		
		foreach($usuaros as $p){
			array_push($ids, $p->id);
		}
		
		for($i = 0; $i < 20; $i++){
			
			DB::table('veiculo')->insert([
                'marca' => $faker->word,
                'modelo' => $faker->word,
                'placa' => $faker->word,
                'tipo' => 'carro',
				'usuario_id' => $ids[array_rand($ids, 1)],
			]);
		}
    }
       
}
