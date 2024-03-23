<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Grupo;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [ 'grupo_id', 'nome', 'cnpj', 'data_fundacao' ];

    /**
     * Carrega o grupo do cliente
     */
    public function Grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }
}
