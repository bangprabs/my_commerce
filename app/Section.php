<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public static function sections()
    {
        $getSection = Section::with('categories')->where('status', 1)->get();
        return $getSection;
    }

    public function categories()
    {
        return $this->hasMany('App\Category', 'section_id')->where(['parent_id' => 'ROOT', 'status' => 1])->with('subcategories');
    }
}
