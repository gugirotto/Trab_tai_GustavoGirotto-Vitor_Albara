<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table='usuario';
    protected $primaryKey = 'id';
    protected $fillable = ["email", "name", "password"];

    public function logiserviço()
        {
            return $this->hasOne(Serviço::class, 'usuario_id', 'id');
        }

        public function loginveiculo()
    {
        return $this->hasMany(Veiculo::class, 'usuario_id', 'id');
    }
   
}
