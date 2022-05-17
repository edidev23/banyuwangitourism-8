<?php

namespace App\Http\Controllers\Backend\Destination;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DestinationUserController extends Controller
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
        $detail = DB::table('destination')
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', 'ID')
            ->where('destination_category_translation.language_id', 'ID')
            ->where('destination.id', $id)
            ->first();

        return view('backend/pages/destination/_user', compact('detail'));
    }

}