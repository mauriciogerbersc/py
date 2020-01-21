<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosProvisao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_provisao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ncm');
            $table->string('produto');
            $table->float('preco');
            $table->float('aliquota_imposto_importacao');
            $table->string('descricao');
            $table->float('aliquotaIPI');
            $table->float('aliquotaPIS');
            $table->float('aliquotaICMS');
            $table->float('aliquotaConfis');
            $table->integer('categoriaProduto');
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
        Schema::dropIfExists('produtos_provisao');
    }
}
