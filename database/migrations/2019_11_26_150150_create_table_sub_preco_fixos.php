<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSubPrecoFixos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_precos_fixos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('preco');
            $table->integer('categoria_fixo_id');
            $table->unsignedBigInteger('sub_fixo_id');
            $table->foreign('sub_fixo_id')->references('id')->on('sub_fixos')->onDelete('cascade');
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
        Schema::dropIfExists('sub_precos_fixos');
    }
}
