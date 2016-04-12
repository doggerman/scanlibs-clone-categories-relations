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


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) { 

        $tag = Tag::find($id);

        $pages = DB::select( DB::raw("
            SELECT DISTINCT pages.id, pages.title, pages.selected, pages.star FROM pages 
            INNER JOIN page_tag ON pages.id=page_id
            INNER JOIN tags ON name_id = tags.id
            WHERE tags.id = :id
            "), array('id' => $id,));

        foreach ($pages as $page) {
            $id = $page->id;

            $categories = DB::select( DB::raw("
            SELECT DISTINCT categories.name, categories.id FROM categories 
            INNER JOIN page_category ON categories.id=name_id
            INNER JOIN pages ON page_id = pages.id
            WHERE pages.id = :id
            "), array('id' => $id,));

            $p[] = array($page->id, $page->title, $page->selected, $page->star, $categories);
        }

        $taglist = Tag::all();
        $categorylist = Category::all();
        return view('tag', [
            'tag' => $tag,
            'taglist' => $taglist,
            'categorylist'=> $categorylist,
            'posts' => $p
            ]);
    }


}
