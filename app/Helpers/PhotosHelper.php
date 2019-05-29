<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
class PhotosHelper
{
    const DIRECTORY = 'images';

    const SUB_DIRECTORIES = [
        'advertisement' => 'advertisements',
    ];

    public static function savePhoto($file, string $type, string $file_name) {
        $file->move(self::getPhotoDirectoryPath($type), $file_name . '.jpg');
    }

    public static function removePhoto(string $type, string $file_name) {
        File::delete([self::getPhotoPath($type, $file_name)]);
    }

    public static function getPhotoPath(string $type, string $file_name) {
        return self::getPhotoDirectoryPath($type) . DIRECTORY_SEPARATOR . $file_name . '.jpg';
    }

    public static function getPhotoURL(string $type, string $file_name) {
        return url(self::getPhotoPreURL($type) . '/' . $file_name . '.jpg');
    }

    private static function getPhotoDirectoryPath(string $type) {
        return self::DIRECTORY . DIRECTORY_SEPARATOR . self::SUB_DIRECTORIES[$type];
    }

    public static function getPhotoPreURL(string $type) {
        return url('/' . self::DIRECTORY . '/' . self::SUB_DIRECTORIES[$type]);
    }
}