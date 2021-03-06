<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vagas extends Model
{
    public function subcategoria() {
        return $this->hasMany('App\SubCategoriaVagas');
    }

    public function subcategoriaFixos() {
        return $this->hasMany('App\SubCategoriaFixos');
    }
}