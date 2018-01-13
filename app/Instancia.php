<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instancia extends Model
{
    protected $fillable = ['nome','email','telefone','mensalidade'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'instancias';
}
