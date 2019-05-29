<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'device_id'
    ];
}
