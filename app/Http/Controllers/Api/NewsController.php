<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $request->lang ? $request->lang : 'ID';
        $orderBy = $request->orderBy ? $request->orderBy : 'asc';
        $kategori = $request->category ? $request->category : 'lokal';

        $response = DB::table('news')
            ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
            ->where('news_translation.language_id', $lang)->orderBy('title', $orderBy)
            ->where('news.category', $kategori)
            ->get();

        return response()->json($response, 200);
    }

    public function listNews(Request $request) {
        $kategori = $request->kategori ? $request->kategori : "lokal";

        $response = DB::table('news')
            ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
            ->where('news_translation.language_id', "ID")
            ->where('news.category', $kategori)
            ->orderBy('created_at', "desc")
            ->get();

        return response()->json($response, 200);
    }

    
}
