<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $response = "Welcome to api Banyuwangi tourism v1";

        return response()->json($response, 200);
    }

    public function home(Request $request)
    {
        $lang = $request->lang ? $request->lang : 'ID';

        $datenow = Date('Y-m-d');

        $response['festival'] = DB::table('festival')
                ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
                ->where('festival_translation.language_id', $lang)
                ->where('festival.event_date_from', '>', $datenow)
                ->take(6)
                ->orderBy('event_date_from')
                ->get();

        $response['news'] = DB::table('news')
                ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
                ->where('news_translation.language_id', $lang)
                ->take(6)
                ->orderBy('created_at', 'desc')
                ->get();

        return response()->json($response, 200);
    }
}
