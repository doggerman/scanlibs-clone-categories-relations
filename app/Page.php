<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;
use App\Category;

class Page extends Model
{
    protected $table = 'pages';
    public $timestamps = true;

    public static function get_pages() {}

}
