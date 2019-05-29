<?php

namespace App;

use App\Classes\Property;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function devices() {
        return $this->belongsToMany('App\Device', 'user_devices')->withPivot(['id']);
    }

    public function advertisements() {
        return $this->hasMany('App\Advertisement', 'publisher_id');
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public static function getProperties()
    {
        return [
            new Property('ID', null, function($item){ return $item->id; }),
            new Property('Email', null, function($item){ return $item->email; }),
            new Property('Name', null, function($item){ return $item->name; }),
            new Property('Action', 'hyperlink', function($item){
                return [
                    'link'=>route('dashboard.publishers.editPermissions', $item->id),
                    'text'=>'Update permissions'
                ];
            }),
        ];
    }
}
