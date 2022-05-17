<?php

namespace App\Http\Controllers\Api;

use App\Models\Destination;
use App\Models\DestinationTiket;
use App\Models\DestinationBooking;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserBanyuwangitourism;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Midtrans\Config;
use Midtrans\Snap;

class DestinationController extends Controller
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

    public function index(Request $request)
    {
        $base_url = url("/");
        $thumbnail = asset("upload/destination");
        $banner = asset("upload/destination/large");

        $lang = $request->lang ? $request->lang : $this->lang;
        $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;

        $lat = $request->lat ? $request->lat : $this->lat;
        $lng = $request->lng ? $request->lng : $this->lng;

        $category_id = $request->category ? $request->category : "default";
        $limit = $request->limit ? $request->limit : "all";

        $destination_category = DB::table('destination_category')
            ->select(
                "destination_category.id",
                "destination_category_translation.name as category"
            )
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->where('destination_category_translation.language_id', $lang)
            ->get();

        $wisata_popular = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_translation.description",
                "destination_translation.address",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination.*",
                DB::raw("( 6371 * acos(cos(radians($lat)) * cos(radians(destination.lat)) * cos(radians(destination.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(destination.lat ))) ) AS distance")
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination.publish', 1)
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang)
            ->orderBy('top', "desc")
            ->take(6)
            ->get();

        $query_terdekat = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_translation.description",
                "destination_translation.address",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination.*",
                DB::raw("( 6371 * acos(cos(radians($lat)) * cos(radians(destination.lat)) * cos(radians(destination.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(destination.lat ))) ) AS distance")
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination.publish', 1)
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang);

        if ($category_id == "default" && $limit == "all") {
            // default
            $wisata_terdekat = $query_terdekat
                ->orderBy('distance', $orderBy)
                ->orderBy('top', "desc")
                ->get();
        } else if ($category_id != "default" && $limit == "all") {
            // by category
            $wisata_terdekat = $query_terdekat
                ->where('destination_category.id', $category_id)
                ->orderBy('distance', $orderBy)
                ->orderBy('top', "desc")
                ->get();
        } else if ($category_id == "default" && $limit != "all") {
            // without category
            $wisata_terdekat = $query_terdekat
                ->orderBy('distance', $orderBy)
                ->orderBy('top', "desc")
                ->take($limit)
                ->get();
        } else {
            // by category
            $wisata_terdekat = $query_terdekat
                ->where('destination_category.id', $category_id)
                ->orderBy('distance', $orderBy)
                ->orderBy('top', "desc")
                ->get();
        }

        return response()->json([
            "category_wisata" => $destination_category,
            "wisata_popular" => $wisata_popular,
            "wisata_terdekat" => $wisata_terdekat,
            "settings" => [
                "base_url" => $base_url,
                "thumbnail" => $thumbnail,
                "banner" => $banner,
            ]
        ], 200);
    }

    public function search(Request $request)
    {
        $lang = $request->lang ? $request->lang : $this->lang;
        $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;

        $lat = $request->lat ? $request->lat : $this->lat;
        $lng = $request->lng ? $request->lng : $this->lng;

        $keyword = $request->keyword ? $request->keyword : "";

        $result = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_translation.description",
                "destination_translation.address",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination.*",
                "destination.id as id",
                DB::raw("( 6371 * acos(cos(radians($lat)) * cos(radians(destination.lat)) * cos(radians(destination.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(destination.lat ))) ) AS distance")
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where(function ($query) use ($keyword) {
                $query->where('destination_translation.title', 'like', '%' . $keyword . '%');
                $query->orwhere('destination_translation.address', 'like', '%' . $keyword . '%');
                $query->orwhere('destination_category_translation.name', 'like', '%' . $keyword . '%');
            })
            ->where('destination.publish', 1)
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang)
            ->orderBy('destination_translation.title', $orderBy)
            ->get();

        return response()->json($result, 200);
    }

    public function detail($id, Request $request)
    {
        $lang = $request->lang ? $request->lang : $this->lang;

        $lat = $request->lat ? $request->lat : $this->lat;
        $lng = $request->lng ? $request->lng : $this->lng;

        $detail_wisata = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_translation.description",
                "destination_translation.address",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination.*",
                DB::raw("( 6371 * acos(cos(radians($lat)) * cos(radians(destination.lat)) * cos(radians(destination.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(destination.lat ))) ) AS distance")
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang)
            ->where('destination.id', $id)
            ->first();

        return response()->json($detail_wisata, 200);
    }

    public function tiketDestination($id)
    {
        $destination = Destination::find($id);
        $tiket = DestinationTiket::find($destination->destination_ticket_id);

        return response()->json($tiket, 200);
    }

    public function testIndex(Request $request)
    {
        $base_url = url("/");
        $thumbnail = asset("upload/destination");
        $banner = asset("upload/destination/large");

        $lang = $request->lang ? $request->lang : $this->lang;
        $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;

        $lat = $request->lat ? $request->lat : $this->lat;
        $lng = $request->lng ? $request->lng : $this->lng;

        $destination_category = DB::table('destination_category')
            ->select(
                "destination_category.id",
                "destination_category_translation.name as category"
            )
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->where('destination_category_translation.language_id', $lang)
            ->get();
        $category_id = $request->category ? $request->category : $destination_category[0]->id;

        $wisata_popular = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_translation.description",
                "destination_translation.address",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination.*",
                "destination_ticket.*",
                "destination.id as id",
                DB::raw("( 6371 * acos(cos(radians($lat)) * cos(radians(destination.lat)) * cos(radians(destination.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(destination.lat ))) ) AS distance")
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->join('destination_ticket', 'destination.destination_ticket_id', '=', 'destination_ticket.id')
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang)
            ->orderBy('top', "desc")
            ->take(6)
            ->get();

        $wisata_terdekat = DB::table('destination')
            ->select(
                "destination_translation.title",
                "destination_translation.slug",
                "destination_translation.description",
                "destination_translation.address",
                "destination_category_translation.name as category",
                "destination_category_translation.slug as code_category",
                "destination.*",
                "destination_ticket.*",
                "destination.id as id",
                DB::raw("( 6371 * acos(cos(radians($lat)) * cos(radians(destination.lat)) * cos(radians(destination.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(destination.lat ))) ) AS distance")
            )
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->join('destination_ticket', 'destination.destination_ticket_id', '=', 'destination_ticket.id')
            ->where('destination_translation.language_id', $lang)
            ->where('destination_category_translation.language_id', $lang)
            ->where('destination_category.id', $category_id)
            ->orderBy('distance', $orderBy)
            ->get();

        return response()->json([
            "category_wisata" => $destination_category,
            "wisata_popular" => $wisata_popular,
            "wisata_terdekat" => $wisata_terdekat,
            "settings" => [
                "base_url" => $base_url,
                "thumbnail" => $thumbnail,
                "banner" => $banner,
            ]
        ], 200);
    }

    // booking by user
    public function bookingByUser($id)
    {
        // $booking = DestinationBooking::where("user_id", $id)->orderBy('tgl_booking', 'desc')->orderBy('created_at', 'desc')->get();

        $booking = DB::table('destination_booking')
            ->select(
                "destination_booking.*",
                "destination.foto",
                "destination.hp",
                "destination.lat",
                "destination.lng",
                "destination.jumlah_rating",
                "destination.rating_score",
                "destination.verified",
                "destination.top",
                "destination_translation.title",
                "destination_translation.description",
                "destination_translation.address"
            )
            ->join('destination', 'destination.id', '=', 'destination_booking.destination_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', $this->lang)
            ->where('destination_booking.user_id', $id)
            ->get();



        return response()->json(
            $booking,
            200
        );
    }
    public function booking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination_id' => 'required',
            'tgl_booking' => 'required|date_format:d-m-Y|after:yesterday',
            'jns_tiket' => 'required|in:DOMESTIK,MANCA,WEEKEND',
            'jml_orang' => 'required|numeric',
            'jns_kendaraan' => 'required|in:JALAN,MOTOR,MOBIL,BUS',
            'jml_kendaraan' => 'required|numeric',
            'harga_tiket' => 'required|numeric',
            'harga_parkir' => 'required|numeric',
            'status' => 'required|in:PENDING,SUCCESS,CANCELED,FAILED',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'kota' => 'required|string|max:100',
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

        $booking = new DestinationBooking();
        $booking->destination_id = $request->destination_id;
        $booking->tgl_booking = \Carbon\Carbon::parse($request->tgl_booking)->format('Y-m-d');

        $booking->invoice = $this->generateCodeInvoice();

        $booking->jns_tiket = $request->jns_tiket;
        $booking->jml_orang = $request->jml_orang;
        $booking->harga_tiket = $request->harga_tiket;

        $booking->jns_kendaraan = $request->jns_kendaraan;
        $booking->jml_kendaraan = $request->jml_kendaraan;
        $booking->harga_parkir = $request->harga_parkir;

        $booking->total_tiket = $request->jml_orang * $request->harga_tiket;
        $booking->total_parkir = $request->jml_kendaraan * $request->harga_parkir;

        $booking->total = ($request->jml_orang * $request->harga_tiket) + ($request->jml_kendaraan * $request->harga_parkir);
        $booking->status = $request->status;
        $booking->payment_url = "";

        // data user
        $user = UserBanyuwangitourism::where("email", $request->email)->first();

        if ($user) {
            $booking->user_id = $user->id;
        } else {
            $user = new UserBanyuwangitourism;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->kota = $request->kota;
            $user->save();

            $booking->user_id = $user->id;
        }

        $booking->save();

        //CONFIG MIDTRANS
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $midtrans = [
            "transaction_details" => [
                "order_id" => $booking->id,
                "gross_amount" => (int) $booking->total
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email' => $user->email,
            ],
            'enabled_payments' => [
                'gopay', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        try {
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $booking->payment_url = $paymentUrl;
            $booking->save();

            return response()->json([
                "status" => true,
                "message" => "Tiket berhasil di booking",
                "data" => $booking,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Transaksi gagal"
            ]);
        }
    }

    function generateCodeInvoice()
    {
        $code = Str::random(8);
        if ($this->codeInvoiceExists($code)) {
            return $this->generateCodeInvoice();
        }

        return $code;
    }

    function codeInvoiceExists($code)
    {
        return DestinationBooking::where("invoice", $code)->exists();
    }
}
