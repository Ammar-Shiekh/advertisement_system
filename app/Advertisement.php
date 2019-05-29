<?php

namespace App;

use App\Classes\Property;
use App\Events\AdvertisementAdded;
use App\Events\AdvertisementRemoved;
use App\Helpers\PhotosHelper;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    public function devices() {
        return $this->belongsToMany('App\Device', 'device_advertisements')->withPivot(['id', 'duration']);
    }

    public static function getProperties()
    {
        return [
            new Property('ID', null, function($item){ return $item->id; }),
            new Property('Photo', 'thumbnail-image', function($item){
                return PhotosHelper::getPhotoPath('advertisement', $item->id);
            }),
            new Property('Created', null, function($item){ return $item->created_at->diffForhumans(); }),
            new Property('Updated', null, function($item){ return $item->updated_at->diffForhumans(); }),
            new Property('Edit', 'hyperlink', function($item){
                return ['link'=>route('advertisements.edit', $item->id), 'text'=>'Edit'];
            }),
        ];
    }

    public static function getAdminProperties()
    {
        return [
            new Property('ID', null, function($item){ return $item->id; }),
            new Property('Photo', 'thumbnail-image', function($item){
                return PhotosHelper::getPhotoPath('advertisement', $item->id);
            }),
            new Property('Created', null, function($item){ return $item->created_at->diffForhumans(); }),
            new Property('Updated', null, function($item){ return $item->updated_at->diffForhumans(); }),
            new Property('Delete', 'delete-button', function($item) {
                return ['action'=>'AdvertisementsController@adminDestroy', 'id'=>$item->id];
            })
        ];
    }
}
