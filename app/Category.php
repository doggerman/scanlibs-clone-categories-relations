<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    public static function create_category() {}

}
