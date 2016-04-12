<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class Tag extends Model
{
    protected $table = 'tags';
    public $timestamps = false;

    public static function create_tag() {}

}
