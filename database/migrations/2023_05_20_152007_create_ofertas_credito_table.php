<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertasCreditoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas_credito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_credito_id');
            $table->string('instituicao_financeira');
            $table->string('modalidade_credito');
            $table->decimal('valor_solicitado', 10, 2);
            $table->decimal('valor_pagar', 10, 2);
            $table->decimal('taxa_juros', 5, 2);
            $table->integer('quantidade_parcelas');
            $table->timestamps();

            $table->foreign('consulta_credito_id')->references('id')->on('consulta_credito')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ofertas_credito');
    }
}
