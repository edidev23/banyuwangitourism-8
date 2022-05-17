<?php

namespace App\Http\Controllers\Backend\FestivalBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Festival;
use App\Models\TicketPrice;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $festival = DB::table('festival')
            ->select('festival.id', 'festival_translation.title', 'festival.fee', 'festival.kuota', 'festival.location', 'festival.event_date_from', 'festival.event_date_to')
            ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
            ->where('festival_translation.language_id', 'ID')
            ->get()->sortBy('event_date_from');

        return view('backend/pages/festival-booking/price/view', compact('festival'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $festival = Festival::findorfail($id);

        return view('backend/pages/festival-booking/price/edit', compact('festival'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $price_adult = TicketPrice::findorfail($request->id_adult);
        $price_adult->price = $request->adult;
        $price_adult->save();

        $price_child = TicketPrice::findorfail($request->id_child);
        $price_child->price = $request->child;
        $price_child->save();

        // jika belum ada data
        $festival = Festival::findorfail($id);
        if (count($festival->ticketPrice) < 1) {
            $price_adult = new TicketPrice;
            $price_adult->type = 'adult';
            $price_adult->price = 0;
            $price_adult->festival_id = $id;
            $price_adult->save();

            $price_child = new TicketPrice;
            $price_child->type = 'child';
            $price_child->price = 0;
            $price_child->festival_id = $id;
            $price_child->save();
        }

        return redirect('admin/festival-booking/price');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fee($id, $fee)
    {
        $festival = Festival::findorfail($id);
        $festival->fee = $fee;
        $festival->save();

        if (count($festival->ticketPrice) < 1 && $fee == 'pay') {
            $price_adult = new TicketPrice;
            $price_adult->type = 'adult';
            $price_adult->price = 0;
            $price_adult->festival_id = $id;
            $price_adult->save();

            $price_child = new TicketPrice;
            $price_child->type = 'child';
            $price_child->price = 0;
            $price_child->festival_id = $id;
            $price_child->save();
        }

        return redirect('admin/festival-booking/price');
    }
}
