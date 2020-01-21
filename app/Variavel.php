<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variavel extends Model
{
    function categoria() {
        return $this->belongsTo("App\Categoria");
    }
}
