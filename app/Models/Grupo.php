<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Cliente;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = [ 'nome' ];

    /**
     * Carrega os clientes do grupo
     */
    public function Clientes(): HasMany
    {
        return $this->hasMany(Cliente::class);
    }
}
