<?php

namespace App\Http\Controllers\Backend\Destination;

use App\Http\Controllers\Controller;
use App\Models\DestinationBooking;
use App\Models\DestinationOffline;
use App\Models\GwdPrice;
use App\Models\GwdTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinationBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->lang = "ID";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_booking = DestinationBooking::orderBy('tgl_booking', 'desc')->orderBy('created_at', 'desc')->get();

        return view('backend/pages/destination/_booking', compact('data_booking'));
    }

    public function allBookingOffline(Request $request)
    {
        $created = $request->created ? $request->created : date("Y-m-d");

        $data_booking = DB::table('destination_offline')
            ->select("destination.id", 'destination_translation.title', DB::raw('sum(jml_orang) as jml_orang'), DB::raw('sum(jml_kendaraan) as jml_kendaraan'), DB::raw('sum(total_tiket) as total_tiket'), DB::raw('sum(total_parkir) as total_parkir'))

            ->join('destination', 'destination.id', '=', 'destination_offline.destination_id')
            ->join('destination_translation', 'destination_offline.destination_id', '=', 'destination_translation.destination_id')
            ->whereDate('destination_offline.created_at', $created)
            ->where('destination_translation.language_id', $this->lang)
            ->groupBy("destination.id", "destination_translation.title")
            ->orderBy("destination_offline.created_at", "desc")->get();

        return view('backend/pages/destination/_booking-offline', compact('data_booking', 'created'));
    }

    public function dataTiketOffline()
    {
        $data_booking = DestinationOffline::orderBy('created_at', 'desc')->get();

        $data_booking = DB::table('destination_offline')
            ->select("destination_offline.*", 'destination_translation.title as destinasi')
            ->join('destination', 'destination.id', '=', 'destination_offline.destination_id')
            ->join('destination_translation', 'destination_offline.destination_id', '=', 'destination_translation.destination_id')
            ->orderBy("destination_offline.created_at", "desc")->get();

        return view('backend/pages/admin-etax/data-tiket', compact('data_booking'));
    }

    public function deleteTiketOffline($id)
    {
        $tiket = DestinationOffline::findorfail($id);
        $tiket->delete();

        return redirect('admin/list-tiket');
    }

    public function allBookingGwd(Request $request)
    {
        $month = $request->month ? $request->month : date("m");

        $dataPerDay = DB::select(DB::raw("SELECT DATE(created_at) tanggal, sum(jml_orang) as jml_pengunjung, sum(total) as total_tiket FROM t_gwd WHERE MONTH(created_at)='$month' GROUP BY DATE(created_at)"));;

        $response = [];
        foreach ($dataPerDay as $day) {

            $data_booking = DB::table('t_gwd')
                ->select("*")
                ->whereDate('created_at', $day->tanggal)->get();

            $jmlTabuhan = 0;
            $jmlGlassBottom = 0;
            $jmlMandiBola = 0;
            $jmlKano = 0;

            $tiketTabuhan = 0;
            $tiketGlassBottom = 0;
            $tiketMandiBola = 0;
            $tiketKano = 0;

            foreach ($data_booking as $item) {
                if ($item->jns_tiket == "TABUHAN") {
                    $tiketTabuhan = $tiketTabuhan + $item->total;
                    $jmlTabuhan = $jmlTabuhan + $item->jml_orang;
                } else if ($item->jns_tiket == "WAHANA") {

                    if ($item->sub_tiket == "GLASS BOTTOM") {
                        $tiketGlassBottom = $tiketGlassBottom + $item->total;
                        $jmlGlassBottom = $jmlGlassBottom + $item->jml_orang;
                    } else if ($item->sub_tiket == "MANDI BOLA") {
                        $tiketMandiBola = $tiketMandiBola + $item->total;
                        $jmlMandiBola = $jmlMandiBola + $item->jml_orang;
                    } else if ($item->sub_tiket == "KANO") {
                        $tiketKano = $tiketKano + $item->total;
                        $jmlKano = $jmlKano + $item->jml_orang;
                    }
                }
            }

            $response[] = [
                "tanggal" => $day->tanggal,
                "jml_pengunjung" => $day->jml_pengunjung,
                "total_tiket" => $day->total_tiket,
                "jml_tabuhan" => $jmlTabuhan,
                "jml_glass_bottom" => $jmlGlassBottom,
                "jml_mandi_bola" => $jmlMandiBola,
                "jml_kano" => $jmlKano,
                "tiket_tabuhan" => $tiketTabuhan,
                "tiket_glass_bottom" => $tiketGlassBottom,
                "tiket_mandi_bola" => $tiketMandiBola,
                "tiket_kano" => $tiketKano
            ];
        }

        $dataReturn = [
            "tiket" => $response,
            "bulan" => $month
        ];

        $dataReturn = (object) $dataReturn;


        return view('backend/pages/destination/_booking-gwd')->with(compact('dataReturn'));;
    }

    public function listTiketGwd(Request $request)
    {
        $all_tiket = GwdTicket::all();

        return view("backend/pages/destination/_booking-gwd-list-tiket", compact("all_tiket"));
    }

    public function deleteTiketGwd($id)
    {
        $tiket = GwdTicket::findorfail($id);

        $tiket->delete();

        return redirect('admin/booking-gwd/list-tiket');
    }

    public function hargaTiketGwd()
    {
        $tiket =  GwdPrice::findOrFail(1);
        return view('backend/pages/destination/_setting-harga-gwd', compact('tiket'));
    }

    public function saveHargaTiketGwd(Request $request)
    {
        $hargaTiket =  GwdPrice::findOrFail(1);
        $hargaTiket->tiket_tabuhan = $request->tiket_tabuhan;
        $hargaTiket->tiket_glass_bottom = $request->tiket_glass_bottom;
        $hargaTiket->tiket_mandi_bola = $request->tiket_mandi_bola;
        $hargaTiket->tiket_kano = $request->tiket_kano;

        $hargaTiket->save();

        return redirect('admin/harga-tiket-gwd');
    }

    // for pimpinan
    public function laporanGwdPimpinan(Request $request)
    {
        $month = $request->month ? $request->month : date("m");

        $dataPerDay = DB::select(DB::raw("SELECT DATE(created_at) tanggal, sum(jml_orang) as jml_pengunjung, sum(total) as total_tiket FROM t_gwd WHERE MONTH(created_at)='$month' GROUP BY DATE(created_at)"));;

        $response = [];
        foreach ($dataPerDay as $day) {

            $data_booking = DB::table('t_gwd')
                ->select("*")
                ->whereDate('created_at', $day->tanggal)->get();

            $jmlTabuhan = 0;
            $jmlGlassBottom = 0;
            $jmlMandiBola = 0;
            $jmlKano = 0;

            $tiketTabuhan = 0;
            $tiketGlassBottom = 0;
            $tiketMandiBola = 0;
            $tiketKano = 0;

            foreach ($data_booking as $item) {
                if ($item->jns_tiket == "TABUHAN") {
                    $tiketTabuhan = $tiketTabuhan + $item->total;
                    $jmlTabuhan = $jmlTabuhan + $item->jml_orang;
                } else if ($item->jns_tiket == "WAHANA") {

                    if ($item->sub_tiket == "GLASS BOTTOM") {
                        $tiketGlassBottom = $tiketGlassBottom + $item->total;
                        $jmlGlassBottom = $jmlGlassBottom + $item->jml_orang;
                    } else if ($item->sub_tiket == "MANDI BOLA") {
                        $tiketMandiBola = $tiketMandiBola + $item->total;
                        $jmlMandiBola = $jmlMandiBola + $item->jml_orang;
                    } else if ($item->sub_tiket == "KANO") {
                        $tiketKano = $tiketKano + $item->total;
                        $jmlKano = $jmlKano + $item->jml_orang;
                    }
                }
            }

            $response[] = [
                "tanggal" => $day->tanggal,
                "jml_pengunjung" => $day->jml_pengunjung,
                "total_tiket" => $day->total_tiket,
                "jml_tabuhan" => $jmlTabuhan,
                "jml_glass_bottom" => $jmlGlassBottom,
                "jml_mandi_bola" => $jmlMandiBola,
                "jml_kano" => $jmlKano,
                "tiket_tabuhan" => $tiketTabuhan,
                "tiket_glass_bottom" => $tiketGlassBottom,
                "tiket_mandi_bola" => $tiketMandiBola,
                "tiket_kano" => $tiketKano
            ];
        }

        $dataReturn = [
            "tiket" => $response,
            "bulan" => $month
        ];

        $dataReturn = (object) $dataReturn;


        return view('backend/pages/destination/laporan/_booking-gwd-pimpinan')->with(compact('dataReturn'));;
    }
}
