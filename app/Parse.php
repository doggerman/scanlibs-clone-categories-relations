<?php
namespace App;
use GuzzleHttp\Client; 
use App\Page;
use DB;
use App\Tag;
use App\PageTag;
use App\Category;
use App\PageCategory;



class Parse {

    public static function curlPage($url) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );
        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
    return $header;}

    public static function get_pages() {
        $client = new Client([
            'base_uri' => 'http://scanlibs.com/',
            'http_errors' => false
            ]);
        $res = $client->get('/');
        $i = 1; 
        $a = [];
        while ($res->getStatusCode() == 200) {
        $body = $res->getBody();
        $html = \phpQuery::newDocument($body);
        $html = $html->find('article');     
        foreach ($html as $el) {
                $pq = pq($el);
                $title = $pq->find('h1.entry-title > a')->text();
                $link = $pq->find('h1.entry-title > a')->attr('href');
                $a[] = [ $title, $link ];
                $id = Page::update_page($title, $link);}
            $res = $client->get('page/'. $i);
            $i = $i + 1;}
        return $a;}

    public static function update_page() {        
        $client = new Client([
            'base_uri' => 'http://scanlibs.com/',
            'http_errors' => false
            ]);        
        $pages = DB::select(DB::raw('select DISTINCT link, id FROM pages'));
        foreach ($pages as $page) {
            $link = $page->link;
            $post = Page::where('link', '=', $link)->first();
            $slug = parse_url($link);
            $res = $client->get($slug['path']);
            $body = $res->getBody();
            $html = \phpQuery::newDocument($body);
            $a = $html->find('.cat-links')->html();
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
            $categories = [];
            if(preg_match_all("/$regexp/siU", $a, $matches, PREG_SET_ORDER)) {
                foreach($matches as $match) {
                  $u['url'] = $match[2];
                  $u['title'] = $match[3];
                  $categories[] = $u;}}
            $a = $html->find('article .tagcloud')->html();
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
            $tags = [];
            if(preg_match_all("/$regexp/siU", $a, $matches, PREG_SET_ORDER)) {
                foreach($matches as $match) {
                  $u['url'] = $match[2];
                  $u['title'] = $match[3];
                  $tags[] = $u;}}
            $description = $html->find('.entry-content')->html();
            Page::update_page($post->id, $description, $categories, $tags);}}    

    public static function add_categories() {
        $categories = DB::select(DB::raw('SELECT DISTINCT name, link FROM page_category'));    
        foreach ($categories as $cat) {
            Category::create_category($cat->name, $cat->link);}}

    public static function add_tags() {
        $tags = DB::select(DB::raw('SELECT DISTINCT name, link FROM page_tag'));    
        foreach ($tags as $tag) {
            Tag::create_tag($tag->name, $tag->link);}}

    public static function update_category_id() {
        $page_category = PageCategory::all();
        foreach ($page_category as $pc) {
            $category = Category::where('name', '=', $pc->name)->first();
            PageCategory::where('name', '=', $pc->name)
                ->update(['name_id' => $category->id]);}

    public static function update_tag_id() {
        $page_tag = PageTag::all();
        foreach ($page_tag as $pt) {
            $tag = Tag::where('name', '=', $pt->name)->first();
            PageTag::where('name', '=', $pt->name)
                ->update(['name_id' => $tag->id]);}


} 