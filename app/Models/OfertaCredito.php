<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OfertaCredito extends Model 
{
    protected $table = 'ofertas_credito';

    protected $fillable = [
        'consulta_credito_id','instituicao_financeira','modalidade_credito','valor_solicitado','valor_pagar','taxa_juros','quantidade_parcelas'					
    ];

    public function consultaCredito()
    {
        return $this->belongsToMany(ConsultaCredito::class);
    }

}
