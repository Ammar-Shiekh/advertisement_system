<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceAdvertisement extends Model
{
    protected $fillable = [
        'device_id', 'advertisement_id', 'duration'
    ];
}
