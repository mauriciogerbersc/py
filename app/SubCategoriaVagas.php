<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoriaVagas extends Model
{
    function vaga() {
        return $this->belongsTo("App\Vagas");
    }
}
