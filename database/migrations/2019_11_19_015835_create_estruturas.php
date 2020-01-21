<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstruturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estruturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomeParque');
            $table->integer('qtdVagasInternas');
            $table->integer('qtdVagasExternas');
            $table->float('alturaSistema');
            $table->float('alturaPeDireito');
            $table->integer('parqueCentralizado');
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
        Schema::dropIfExists('estruturas');
    }
}
