<?php

namespace App\Services;

use Image;

class PhotoService
{
    public function storePhoto($photo)
    {

        $filename = time() . '.' . $photo->getClientOriginalExtension();

        Image::make($photo)->resize(300, 300)->save(public_path('/images/avatar/' . $filename));

        return $filename;
    }
}
