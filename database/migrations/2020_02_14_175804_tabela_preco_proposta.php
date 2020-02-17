<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TabelaPrecoProposta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tabela_precos_proposta', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('proposta_id');
            $table->foreign('proposta_id')->references('id')->on('propostas')->onDelete('cascade');
           
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
        Schema::dropIfExists('tabela_precos_proposta');
    }
}
