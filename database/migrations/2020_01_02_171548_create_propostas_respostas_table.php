<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas_respostas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campo');
            $table->integer('pergunta_id');
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
        Schema::dropIfExists('propostas_respostas');
    }
}
