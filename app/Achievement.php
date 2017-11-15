<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'description',
        'img'
    ];
}