<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Login;
class Carro extends Model
{
    protected $table='veiculo';
    protected $primaryKey = 'id';
    protected $fillable = ["marca", "modelo", "placa","nome_arquivo"];
    public function loginveiculo()
    {
        return $this->belongsTo(Login::class, 'usuario_id', 'id');
    }
}
