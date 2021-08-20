<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Banners;

class Banners extends Model
{
    public static function getBanners()
    {
        $getBanners = Banners::where('status', 1)->get()->toArray();
        return $getBanners;
    }
}
