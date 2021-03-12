<?php

namespace App\Tests\ObjectMother;

use App\File\FileService;

class FileServiceObjectMother
{
    public static function createWithPublicUrl(string $publicUrl): FileService
    {
        return new FileService($publicUrl);
    }
}