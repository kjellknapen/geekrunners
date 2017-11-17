<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminPassword extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'password'
    ];
}
