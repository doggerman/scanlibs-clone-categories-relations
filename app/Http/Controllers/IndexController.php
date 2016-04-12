<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp\Client; 
use App\Page;
use App\Category;
use App\PageCategory;
use App\Tag;
use App\PageTag;
use DB;
use Cache;


class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() { 

        $pages = Page::all();
        foreach ($pages as $page) {
            $id = $page->id;

            $categories = DB::select( DB::raw("
            SELECT DISTINCT categories.name, categories.id FROM categories 
            INNER JOIN page_category ON categories.id=name_id
            INNER JOIN pages ON page_id = pages.id
            WHERE pages.id = :id
            "), array('id' => $id,));

            $tags = DB::select( DB::raw("
            SELECT DISTINCT tags.name, tags.id FROM tags 
            INNER JOIN page_tag ON tags.id=name_id
            INNER JOIN pages ON page_id = pages.id
            WHERE pages.id = :id
            "), array('id' => $id,));

            $p[] = array($page->id, $page->title, $page->selected, $page->star, $categories, $tags); 
            // kd($p);
        }

        
            // $leads = json_decode($p, true);
            // kd($p);        

        $taglist = Tag::all();
        $categorylist = Category::all();
        return view('content', [

            'taglist' => $taglist,
            'categorylist'=> $categorylist,
            'posts' => $p
            ]);
    }


}
