<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasPrecosFixosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias_precos_fixos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('preco');
            
            $table->unsignedBigInteger('vaga_id');
            $table->foreign('vaga_id')->references('id')->on('vagas')->onDelete('cascade');
            
            $table->unsignedBigInteger('sub_categoria_id');
            $table->foreign('sub_categoria_id')->references('id')->on('sub_categoria_vagas')->onDelete('cascade');
           
            $table->unsignedBigInteger('sub_fixos_id');
            $table->foreign('sub_fixos_id')->references('id')->on('sub_fixos')->onDelete('cascade');
            
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
        Schema::dropIfExists('categorias_precos_fixos');
    }
}
