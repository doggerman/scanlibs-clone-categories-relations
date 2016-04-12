<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp\Client; 
use App\Page;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selected(Request $request) {		
		$id = $request->id;
		$id = (int)$id;
		$page = Page::find($id);
		if ($page->selected == 'Y') {
			$page->selected = 'N';}
		else if ($page->selected == 'N') {
			$page->selected = 'Y';}
		$page->save();
		return $page->selected;    	
    }

    public function star(Request $request) {
		$id = $request->id;
		$id = (int)$id;
		$page = Page::find($id);
		if ($page->star == 'Y') {
			$page->star = 'N';}
		else if ($page->star == 'N') {
			$page->star = 'Y';}
		$page->save();			
    	return $page->star;
    }


}
