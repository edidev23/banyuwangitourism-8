<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DestinationOffline;
use App\Models\DestinationTiket;
use App\Models\AdminEtax;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DestinationOfflineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->lang = "ID";
        $this->orderBy = "asc";
        $this->lat = -8.2209216;
        $this->lng = 114.3657042;
    }

    public function listDestination(Request $request)
    {
        $lang = $request->lang ? $request->lang : $this->lang;
        $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;

        $list_wisata = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination.id",
                "destination.email_admin"
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->join('destination_ticket', 'destination_ticket.id', '=', 'destination.destination_ticket_id')
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang)
            ->orderBy('destination_translation.title', $orderBy)
            ->get();

        return response()->json($list_wisata);
    }

    public function detailDestination($email, Request $request)
    {
        $lang = $request->lang ? $request->lang : $this->lang;

        $detail_wisata = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_translation.description",
                "destination_translation.address",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination_ticket.*",
                "destination.*"
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->join('destination_ticket', 'destination_ticket.id', '=', 'destination.destination_ticket_id')
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang)
            ->where('destination.email_admin', $email)
            ->first();

        if (!$detail_wisata) {
            return response()->json([
                "status" => false,
                "message" => "Data tidak ditemukan"
            ], 400);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail Destinasi",
            "data" => $detail_wisata,
        ], 200);
    }

    public function getDataAdmin($email)
    {
        $admin_etax = AdminEtax::where("email", $email)->first();

        if (!$admin_etax) {
            return response()->json([
                "status" => false,
                "message" => "Data tidak ditemukan"
            ], 400);
        }

        return response()->json([
            "status" => true,
            "message" => "Data Admin Etax",
            "data" => $admin_etax,
        ]);
    }

    public function requestAdmin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'destination_id' => 'required',
            'email' => 'email|required|unique:admin_etax,email',
            'nama' => 'required',
            'alamat' => 'required',
            'no_whatsapp' => 'required',
            'status' => 'required|in:REQUEST,ACCEPT,REJECT',
            // 'foto' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->messages()
            ], 404);
        }

        $destination = \App\Models\Destination::find($request->destination_id);
        if (!$destination) {
            return response()->json([
                "status" => false,
                "message" => "Destinasi tidak ditemukan"
            ], 400);
        }

        $admin_etax = new AdminEtax();
        $admin_etax->nama = $request->nama;
        $admin_etax->email = $request->email;
        $admin_etax->alamat = $request->alamat;
        $admin_etax->no_whatsapp = $request->no_whatsapp;
        $admin_etax->destination_id = $request->destination_id;
        $admin_etax->status = $request->status;

        try {
            $admin_etax->save();

            return response()->json([
                "status" => true,
                "message" => "Pengajuan admin etax berhasil",
                "data" => $admin_etax,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Pengajuan gagal"
            ]);
        }
    }

    public function getByDate(Request $request, $destination_id)
    {
        $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;

        if ($request->tanggal != "") {
            $tanggal = $request->tanggal ? $request->tanggal : date("Y-m-d");

            $tiket = DB::table('destination_offline')
                ->select('*')
                ->where('destination_id', $destination_id)
                ->whereDate('created_at', '=', $tanggal)
                ->orderBy('created_at', $orderBy)
                ->get();
        } else {
            $year = $request->tahun ? $request->tahun : date("Y");
            $month = $request->bulan ? $request->bulan : date("m");

            $tiket = DB::table('destination_offline')
                ->select('*')
                ->where('destination_id', $destination_id)
                ->whereMonth('created_at', '=', $month)
                ->whereYear('created_at', '=', $year)
                ->orderBy('created_at',  $orderBy)
                ->get();
        }


        return response()->json($tiket, 200);
    }

    public function booking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice' => 'required',
            'destination_id' => 'required',
            'created_at' => 'required',
            'jns_tiket' => 'required|in:DOMESTIK,MANCA,WEEKEND',
            'jml_orang' => 'required|numeric',
            'jns_kendaraan' => 'required|in:JALAN,MOTOR,MOBIL,BUS',
            'jml_kendaraan' => 'required|numeric',
            'harga_tiket' => 'required|numeric',
            'harga_parkir' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->messages()
            ], 404);
        }

        $destination = \App\Models\Destination::find($request->destination_id);
        if (!$destination) {
            return response()->json([
                "status" => false,
                "message" => "Destinasi tidak ditemukan"
            ], 400);
        }

        // check invoice same
        $invoice = \App\Models\DestinationOffline::where("invoice", $request->invoice)->first();
        if ($invoice) {
            return response()->json([
                "error" => false,
                "message" => "Tiket berhasil di booking",
                "data" => $invoice,
            ], 200);
        }

        $booking = new DestinationOffline();
        $booking->destination_id = $request->destination_id;
        $booking->created_at = $request->created_at;
        $booking->invoice = $request->invoice;

        $booking->jns_tiket = $request->jns_tiket;
        $booking->jml_orang = $request->jml_orang;
        $booking->harga_tiket = $request->harga_tiket;
        $booking->jns_kendaraan = $request->jns_kendaraan;
        $booking->jml_kendaraan = $request->jml_kendaraan;
        $booking->harga_parkir = $request->harga_parkir;

        $booking->total_tiket = $request->jml_orang * $request->harga_tiket;
        $booking->total_parkir = $request->jml_kendaraan * $request->harga_parkir;

        $booking->total = ($request->jml_orang * $request->harga_tiket) + ($request->jml_kendaraan * $request->harga_parkir);

        try {
            $booking->save();

            return response()->json([
                "error" => false,
                "message" => "Tiket berhasil di booking",
                "data" => $booking,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => true,
                "message" => "Transaksi gagal"
            ]);
        }
    }

    public function getHargaTiket($destination_id)
    {
        $destination = \App\Models\Destination::find($destination_id);
        if (!$destination) {
            return response()->json([
                "status" => false,
                "message" => "Destinasi tidak ditemukan"
            ], 400);
        }

        $tiket = DB::table('destination_ticket')
            ->select("destination_ticket.*")
            ->join('destination', 'destination.destination_ticket_id', '=', 'destination_ticket.id')
            ->where('destination.id', $destination_id)
            ->first();

        if ($tiket) { } else {
            $tiket = new DestinationTiket();
            $tiket->tiket_domestik = 0;
            $tiket->tiket_manca = 0;
            $tiket->tiket_weekend = 0;
            $tiket->parkir_roda_dua = 0;
            $tiket->parkir_roda_empat = 0;
            $tiket->parkir_bus = 0;

            $tiket->save();

            $destination->destination_ticket_id = $tiket->id;
            $destination->save();
        }

        return response()->json([
            "status" => true,
            "message" => "Harga tiket destinasi",
            "data" => $tiket,
        ]);
    }

    public function updateTiket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination_id' => 'required',
            'tiket_domestik' => 'required|numeric',
            'tiket_manca' => 'required|numeric',
            'tiket_weekend' => 'required|numeric',
            'parkir_roda_dua' => 'required|numeric',
            'parkir_roda_empat' => 'required|numeric',
            'parkir_bus' => 'required|numeric',
            'updated_at' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->messages()
            ], 404);
        }

        $destination = \App\Models\Destination::find($request->destination_id);
        if (!$destination) {
            return response()->json([
                "status" => false,
                "message" => "Destinasi tidak ditemukan"
            ], 400);
        }

        $destinationTiket = \App\Models\DestinationTiket::find($destination->destination_ticket_id);

        if (!$destinationTiket) {
            return response()->json([
                "status" => false,
                "message" => "Data tidak ditemukan"
            ], 400);
        } else {
            $destinationTiket->tiket_domestik = $request->tiket_domestik;
            $destinationTiket->tiket_manca = $request->tiket_manca;
            $destinationTiket->tiket_weekend = $request->tiket_weekend;
            $destinationTiket->parkir_roda_dua = $request->parkir_roda_dua;
            $destinationTiket->parkir_roda_empat = $request->parkir_roda_empat;
            $destinationTiket->parkir_bus = $request->parkir_bus;
        }

        try {
            $destinationTiket->save();

            return response()->json([
                "status" => true,
                "message" => "Harga tiket berhasil di update",
                "data" => $destinationTiket,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Gagal Menyimpan data!"
            ]);
        }
    }
}
