<?php

namespace App\Http\Controllers;

use App\Models\GeoparkDestination;
use App\Models\ProdukPpkm;
use Illuminate\Support\Facades\DB;

class FrontEndController extends Controller
{

    public function index()
    {
        $culinary = DB::table('culinary')
            ->join('culinary_translation', 'culinary.id', '=', 'culinary_translation.culinary_id')
            ->where('culinary_translation.language_id', 'ID')
            ->take(5)->orderBy('created_at', 'desc')
            ->get();

        // $handcraft = DB::table('handcraft')
        //     ->join('handcraft_translation', 'handcraft.id', '=', 'handcraft_translation.handcraft_id')
        //     ->where('handcraft_translation.language_id', 'ID')
        //     ->take(5)->orderBy('created_at', 'desc')
        //     ->get();
        $produk_ppkm = ProdukPpkm::take(2)->orderBy('created_at', 'desc')->get();

        $destination = DB::table('destination')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', 'ID')
            ->where('destination.publish', 1)
            ->take(6)->orderBy('top')
            ->get();

        $datenow = Date('Y-m-d');
        $events = DB::table('festival')
            ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
            ->where('festival_translation.language_id', 'ID')
            ->where('festival.event_date_from', '>', $datenow)
            ->take(6)->orderBy('event_date_from')
            ->get();

        $news = DB::table('news')
            ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
            ->where('news_translation.language_id', 'ID')
            ->take(6)->orderBy('created_at', 'desc')
            ->get();

        return view('frontend/dashboard', compact('culinary', 'produk_ppkm', 'destination', 'events', 'news'));
    }

    public function festival()
    {
        // $events = DB::table('festival')
        //     ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
        //     ->where('festival_translation.language_id', 'ID')
        //     ->get()->sortBy('event_date_from');
        // return view('frontend/festival', compact('events'));

        return view('frontend/festival');
    }

    public function detail_festival($slug)
    {
        $event = DB::table('festival')
            ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
            ->where('festival_translation.language_id', 'ID')
            ->where('festival_translation.slug', $slug)
            ->first();

        if (!$event) {
            return redirect('festival');
        }

        return view('frontend/festival-detail', compact('event'));
    }

    public function destination()
    {
        $destination = DB::table('destination')
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination.publish', 1)
            ->where('destination_translation.language_id', 'ID')
            ->where('destination_category_translation.language_id', 'ID')
            ->get();

        return view('frontend/destination', compact('destination'));
    }

    public function detail_destination($slug)
    {
        $destination = DB::table('destination')
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', 'ID')
            ->where('destination_translation.slug', $slug)
            ->where('destination_category_translation.language_id', 'ID')
            ->first();

        if (!$destination) {
            return redirect('destination');
        }

        return view('frontend/destination-detail', compact('destination'));
    }

    public function culinary()
    {
        $culinary = DB::table('culinary')
            ->join('culinary_translation', 'culinary.id', '=', 'culinary_translation.culinary_id')
            ->where('culinary_translation.language_id', 'ID')
            ->get()->sortByDesc('created_at');

        return view('frontend/culinary', compact('culinary'));
    }

    public function detail_culinary($slug)
    {
        $culinary = DB::table('culinary')
            ->join('culinary_translation', 'culinary.id', '=', 'culinary_translation.culinary_id')
            ->where('culinary_translation.language_id', 'ID')
            ->where('culinary_translation.slug', $slug)
            ->first();

        if (!$culinary) {
            return redirect('culinary');
        }
        return view('frontend/culinary-detail', compact('culinary'));
    }

    public function handcraft()
    {
        $handcraft = DB::table('handcraft')
            ->join('handcraft_translation', 'handcraft.id', '=', 'handcraft_translation.handcraft_id')
            ->where('handcraft_translation.language_id', 'ID')
            ->get()->sortByDesc('created_at');


        return view('frontend/handcraft', compact('handcraft'));
    }

    public function detail_handcraft($slug)
    {
        $handcraft = DB::table('handcraft')
            ->join('handcraft_translation', 'handcraft.id', '=', 'handcraft_translation.handcraft_id')
            ->where('handcraft_translation.language_id', 'ID')
            ->where('handcraft_translation.slug', $slug)
            ->first();

        if (!$handcraft) {
            return redirect('handcraft');
        }
        return view('frontend/handcraft-detail', compact('handcraft'));
    }

    public function news()
    {
        $news = DB::table('news')
            ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
            ->where('news_translation.language_id', 'ID')
            ->get()->sortByDesc('created_at');

        return view('frontend/news', compact('news'));
    }

    public function detail_news($slug)
    {
        $news = DB::table('news')
            ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
            ->where('news_translation.language_id', 'ID')
            ->take(3)
            ->get()->sortByDesc('created_at');

        $news_detail = DB::table('news')
            ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
            ->where('news_translation.language_id', 'ID')
            ->where('news_translation.slug', $slug)
            ->first();

        if (!$news) {
            return redirect('news');
        }

        return view('frontend/news-detail', compact('news', 'news_detail'));
    }

    public function get_apps()
    {

        return view('frontend/get-apps');
    }

    public function produk_ppkm()
    {
        // $produk_ppkm = ProdukPpkm::all();
        return view("frontend/produk_ppkm");
    }

    public function geopark()
    {
        $destination = GeoparkDestination::orderBy('title', 'asc')
        ->get();
        return view('frontend/geopark-destination', compact("destination"));
    }

    public function detail_geopark($slug)
    {
        $destination = GeoparkDestination::where("slug", $slug)->first();
        return view('frontend/geopark-destination-detail', compact("destination"));
    }
}
