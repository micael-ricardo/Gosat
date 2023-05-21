<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ConsultaCredito extends Model 
{
    protected $table = 'consulta_credito';

    protected $fillable = [
        'cpf',
    ];

    public function OfertaCredito()
    {
        return $this->belongsToMany(OfertaCredito::class);
    }

}
