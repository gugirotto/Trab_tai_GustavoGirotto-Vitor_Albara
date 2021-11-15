<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Login;

    class Serviço extends Model
    {
        protected $table = 'servico';
        protected $primaryKey = 'id';

        protected $fillable = ["mecanico", "placa", "nome", 'horario','nome_arquivo'];
        public function loginserviço()
        {
            return $this->belongsTo(Login::class, 'usuario_id', 'id');
        }
        public function mecanicoserviço()
        {
            return $this->belongsTo(Mecanico::class, 'mecanico_id', 'id');
        }
        public function manyuser(){
            return $this->belongsToMany(Login::class,'servico','usuario_id', 'id');
        }
        public function manymec(){
            return $this->belongsToMany(Mecanico::class,'servico','mecanico_id', 'id');
        }

    }
