<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegraPerguntaVariavelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regra_pergunta_variavels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pergunta_id');
            $table->foreign('pergunta_id')->references('id')->on('perguntas')->onDelete('cascade');
            $table->unsignedBigInteger('variavel_id');
            $table->foreign('variavel_id')->references('id')->on('variavels')->onDelete('cascade');
            $table->string('regra_de_negocio');
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
        Schema::dropIfExists('regra_pergunta_variavels');
    }
}
