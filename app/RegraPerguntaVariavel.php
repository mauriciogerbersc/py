<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegraPerguntaVariavel extends Model
{
    function categoria() {
        return $this->belongsTo("App\Categoria");
    }
}
