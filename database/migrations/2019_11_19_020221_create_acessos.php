<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcessos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acessos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomeAcesso');
            $table->integer('qtdLinhasPaineis');
            $table->integer('distanciaProximo');
            $table->unsignedBigInteger('proposta_id');
            $table->foreign('proposta_id')->references('id')->on('propostas')->onDelete('cascade');
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
        Schema::dropIfExists('acessos');
    }
}
