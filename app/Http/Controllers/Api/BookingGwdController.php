<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GwdTicket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookingGwdController extends Controller
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
    }

    public function getByDate(Request $request)
    {
        $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;

        if ($request->tanggal != "") {
            $tanggal = $request->tanggal ? $request->tanggal : date("Y-m-d");

            $tiket = DB::table('t_gwd')
                ->select('*')
                ->whereDate('created_at', '=', $tanggal)
                ->orderBy('created_at', $orderBy)
                ->get();
        } else {
            $year = $request->tahun ? $request->tahun : date("Y");
            $month = $request->bulan ? $request->bulan : date("m");

            $tiket = DB::table('t_gwd')
                ->select('*')
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
            'created_at' => 'required',
            'jns_tiket' => 'required|in:TABUHAN,WAHANA',
            'sub_tiket' => '',
            'jml_orang' => 'required|numeric',
            'harga_tiket' => 'required|numeric',
            'email_admin' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->messages()
            ], 404);
        }

        // check invoice same
        $invoice = \App\Models\GwdTicket::where("invoice", $request->invoice)->first();
        if ($invoice) {
            return response()->json([
                "error" => false,
                "message" => "Tiket berhasil di booking",
                "data" => $invoice,
            ], 200);
        }

        $booking = new GwdTicket();
        $booking->created_at = $request->created_at;
        $booking->invoice = $request->invoice;

        $booking->jns_tiket = $request->jns_tiket;
        $booking->sub_tiket = $request->sub_tiket;
        $booking->jml_orang = $request->jml_orang;
        $booking->harga_tiket = $request->harga_tiket;
        $booking->email_admin = $request->email_admin;

        $booking->total = $request->jml_orang * $request->harga_tiket;

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

    public function getHargaTiket($email_admin)
    {
        // tambahkan manual admin etax gwd
        $listEmail = [
            "est23.edi@gmail.com",
            "edidev23@gmail.com",
            "dinaasiska13@gmail.com",
            "bwixwisata@gmail.com",
            "islandtabuhan@gmail.com"
        ];

        $terdaftar = false;
        foreach($listEmail as $email) {

            if($email == $email_admin) {
                $terdaftar = true;
            }
        }

        if($terdaftar == false) {
            return response()->json([
                "status" => false,
                "message" => "Email anda belum terdaftar sebagai admin. Hubungi Admin Aplikasi untuk mendapatkan akses !"
            ], 401);
        }

        
        $tiket = \App\Models\GwdPrice::find(1);

        return response()->json([
            "status" => true,
            "message" => "Harga tiket Grand Watu Dodol",
            "data" => $tiket,
        ]);
    }
}
