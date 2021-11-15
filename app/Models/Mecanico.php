<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecanico extends Model
{
    protected $table='mecanico';
    protected $primaryKey = 'id';
    protected $fillable = ['cpf', 'nome_arquivo'];
    public function many(){
        return $this->belongsToMany(Serviço::class,'servico','mecanico_id', 'id');
    }
}

