<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('estabelecimento');
            $table->string('responsavel');
            $table->integer('qtdDiasDeGravacao');
            $table->integer('possuiCamerasExtras');
            $table->integer('quantidadeCamerasExtras');
            $table->integer('quantosPaineisSinalizados');
            $table->float('distanciaCentroControle');
            $table->float('distanciaEntreParques');
            $table->integer('qtdEntradas');
            $table->integer('qtdSaidas');
            $table->integer('camerasExtrasLPR');
            $table->integer('quantidadeCamerasExtrasLPR');
            $table->integer('qtdAcessosExternos');
            $table->integer('camerasLPR');
            $table->integer('quantidadeCamerasLPR');
            $table->integer('qtdTotensFindYorCar');
            $table->integer('aplicativoParkEyes');
            $table->integer('apiAplicativoCliente');
            $table->integer('apiParaTotens');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propostas');
    }
}
