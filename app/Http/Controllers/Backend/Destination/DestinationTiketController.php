<?php

namespace App\Http\Controllers\Backend\Destination;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinationTiketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $destination = Destination::find($id);
            
        if ($destination->destination_ticket_id != '') {
            $tiket = DestinationTiket::find($destination->destination_ticket_id);
        } else {
            $tiket = new DestinationTiket;
            $tiket->tiket_domestik = 0;
            $tiket->tiket_manca = 0;
            $tiket->tiket_weekend = 0;
            $tiket->parkir_roda_dua = 0;
            $tiket->parkir_roda_empat = 0;
            $tiket->parkir_bus = 0;
            $tiket->status_kuota = 0;
            $tiket->limit_kuota = 0;
            $tiket->hari_libur = "";
            $tiket->save();

            $destination->destination_ticket_id = $tiket->id;
            $destination->save();
        }


        return view('backend/pages/destination/_tiket', compact('destination', 'tiket'));
    }

    public function update(Request $request, $id)
    {
        $tiket = DestinationTiket::findorfail($id);
        $tiket->tiket_domestik = $request->tiket_domestik;
        $tiket->tiket_manca = $request->tiket_manca;
        $tiket->tiket_weekend = $request->tiket_weekend;
        $tiket->parkir_roda_dua = $request->parkir_roda_dua;
        $tiket->parkir_roda_empat = $request->parkir_roda_empat;
        $tiket->parkir_bus = $request->parkir_bus;

        $tiket->save();

        // dd($tiket); 
        return redirect("admin/destination/" . $tiket->destination_ticket_id);
    }
}
