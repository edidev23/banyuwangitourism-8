<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Hotline;
use App\Models\Handcraft;
use App\Models\Culinary;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['hotline'] = Hotline::count();
        $data['handcraft'] = Handcraft::count();
        $data['culinary'] = Culinary::count();
        
        $year = date('Y');
        $data['bulan'] = array(
            [ "id" => 1, "nama" => "Januari" ],
            [ "id" => 2, "nama" => "Februari" ],
            [ "id" => 3, "nama" => "Maret" ],
            [ "id" => 4, "nama" => "April" ],
            [ "id" => 5, "nama" => "Mei" ],
            [ "id" => 6, "nama" => "Juni" ],
            [ "id" => 7, "nama" => "Juli" ],
            [ "id" => 8, "nama" => "Agustus" ],
            [ "id" => 9, "nama" => "September" ],
            [ "id" => 10, "nama" => "Oktober" ],
            [ "id" => 11, "nama" => "Nopember" ],
            [ "id" => 12, "nama" => "Desember" ]
        );
            
        $data['festival'] = DB::select(DB::raw("SELECT MONTH(event_date_from) bulan, COUNT(*) total FROM festival WHERE YEAR(event_date_from)=$year GROUP BY MONTH(event_date_from)"));

        $data['news'] = DB::select(DB::raw("SELECT MONTH(created_at) bulan, COUNT(*) total FROM news WHERE YEAR(created_at)=$year GROUP BY MONTH(created_at)"));

        $data['destination'] = DB::select(DB::raw("SELECT destination_category_id category, COUNT(*) total FROM destination  GROUP BY destination_category_id"));

        $data['destination_category'] = DB::table('destination_category')
        ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
        ->where('destination_category_translation.language_id', 'ID')
        ->get();

        // dd($data);
        return view('backend/pages/dashboard/view', compact('data'));
    }
}
