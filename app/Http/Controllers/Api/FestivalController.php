<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Festival;

class FestivalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $bulan)
    {
        $lang = $request->lang ? $request->lang : 'ID';
        $orderBy = $request->orderBy ? $request->orderBy : 'DESC';
        $bulan = $bulan ? $bulan : date('m');
        $year = $request->year ? $request->year : date('Y');

        // return response()->json($bulan);

        if ($bulan == 'all') {

            $response = DB::table('festival')
                ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
                ->where('festival_translation.language_id', $lang)
                ->whereYear('event_date_from', $year)
                ->orderby('event_date_from', $orderBy)
                ->get();
        } else {

            $response = DB::table('festival')
                ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
                ->where('festival_translation.language_id', $lang)
                ->whereMonth('event_date_from', $bulan)
                ->whereYear('event_date_from', $year)
                ->orderby('event_date_from', $orderBy)
                ->get();
        }

        return response()->json($response, 200);
    }

    public function detail(Request $request, $slug)
    {
        $lang = $request->lang ? $request->lang : 'ID';

        $response['data'] = DB::table('festival')
            ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
            ->where('festival_translation.language_id', $lang)
            ->where('festival_translation.slug', $slug)
            ->get();

        return response()->json($response, 200);
    }

    public function festivalCount(Request $request)
    {
        $year = $request->year ? $request->year : date('Y');

        $dataByMonth = DB::select(DB::raw("SELECT MONTH(event_date_from) bulan, COUNT(*) total FROM festival WHERE YEAR(event_date_from)=$year GROUP BY MONTH(event_date_from)"));;

        $response = [];

        foreach($dataByMonth as $d) {

            $dataFestival = DB::table('festival')
            ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
            ->where('festival_translation.language_id', 'ID')
            ->where('festival.best_festival', 1)
            ->whereMonth('festival.event_date_from', $d->bulan)
            ->whereYear('festival.event_date_from', $year)
            ->first();

            if($dataFestival) {
                $response[] = [
                    "bulan" => $d->bulan,
                    "bulan_string" => bulanString($d->bulan),
                    "tahun" => $year,
                    "nama_festival" => $dataFestival ? $dataFestival->title : null,
                    "foto"      => $dataFestival ? $dataFestival->foto : null,
                    "total"=> $d->total
                ];
            } else {
                $response[] = [
                    "bulan" => $d->bulan,
                    "bulan_string" => bulanString($d->bulan),
                    "tahun" => $year,
                    "nama_festival" => "Festival Bln " . bulanString($d->bulan),
                    "foto"      => "",
                    "total"=> $d->total
                ];
            }
        }

        return response()->json($response, 200);
    }
}
