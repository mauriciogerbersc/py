<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function variavels() {
        return $this->hasMany('App\Variavel');
    }
}
