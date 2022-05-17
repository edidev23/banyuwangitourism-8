<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Festival;
use App\Models\FestivalTranslation;
use App\Models\Language;
use App\Models\TicketPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;

class FestivalController extends Controller
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
    public function index()
    {
        $festival = DB::table('festival')
            ->join('festival_translation', 'festival.id', '=', 'festival_translation.festival_id')
            ->where('festival_translation.language_id', 'ID')
            ->get()->sortBy('event_date_from');

        return view('backend/pages/festival/view', compact('festival'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        return view('backend/pages/festival/add', compact('lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        $d = new Festival;

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['description' . $l->id] = 'required';
            $data_validation['address' . $l->id] = 'required';
        }
        $data_validation['lat'] = 'required';
        $data_validation['lng'] = 'required';
        $data_validation['location'] = 'required';
        $data_validation['event_date_from'] = 'required';
        $data_validation['event_date_to'] = 'required';
        $data_validation['fee'] = 'required';
        $data_validation['kuota'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/festival/create')->withErrors($validator)->withInput();
        } else {
            // save festival
            $d->lat = $request->lat;
            $d->lng = $request->lng;
            $d->location = $request->location;
            $d->event_date_from = $request->event_date_from;
            $d->event_date_to = $request->event_date_to;
            $d->fee = $request->fee;
            $d->kuota = $request->kuota;
            $d->url = $request->url;
            $d->youtube = $request->youtube;
            $d->foto = $request->foto;
            $d->save();
            // save festival translation
            foreach ($lang as $l) {
                $t = new FestivalTranslation;
                $t->title = $request->input('title' . $l->id);
                $t->slug = Str::slug($request->input('title' . $l->id));
                $t->description = $request->input('description' . $l->id);
                $t->address = $request->input('address' . $l->id);
                $t->festival_id = $d->id;
                $t->language_id = $l->id;
                $t->save();
            }

            // toast('Your Post as been submited!', 'success')->autoClose(2000);

            if ($request->btn_save == "save_add_another") {
                return redirect('admin/festival/create');
            } else {
                return redirect('admin/festival');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Festival  $festival
     * @return \Illuminate\Http\Response
     */
    public function show(Festival $festival)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Festival  $festival
     * @return \Illuminate\Http\Response
     */
    public function edit(Festival $festival)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        return view('backend/pages/festival/edit', compact('lang', 'festival'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Festival  $festival
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Festival $festival)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['description' . $l->id] = 'required';
            $data_validation['address' . $l->id] = 'required';
        }
        $data_validation['lat'] = 'required';
        $data_validation['lng'] = 'required';
        $data_validation['location'] = 'required';
        $data_validation['event_date_from'] = 'required';
        $data_validation['event_date_to'] = 'required';
        $data_validation['fee'] = 'required';
        $data_validation['kuota'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/festival/' . $festival->id . '/edit')->withErrors($validator)->withInput();
        } else {
            // save destination
            $festival->lat = $request->lat;
            $festival->lng = $request->lng;
            $festival->location = $request->location;
            $festival->event_date_from = $request->event_date_from;
            $festival->event_date_to = $request->event_date_to;
            $festival->fee = $request->fee;
            $festival->kuota = $request->kuota;
            $festival->url = $request->url;
            $festival->youtube = $request->youtube;
            $festival->foto = $request->foto;
            $festival->save();
            // save festival translation
            foreach ($lang as $l) {

                $translation_id = $request->input('festival_translation_id' . $l->id);

                if (isset($translation_id)) {
                    $t = FestivalTranslation::findorfail($translation_id);
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->festival_id = $festival->id;
                    $t->language_id = $l->id;
                    $t->save();
                } else {
                    $t = new FestivalTranslation;
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->festival_id = $festival->id;
                    $t->language_id = $l->id;
                    $t->save();
                }
            }

            // toast('Your Post as been updated!', 'success')->autoClose(2000);
            return redirect('admin/festival');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Festival  $festival
     * @return \Illuminate\Http\Response
     */
    public function destroy(Festival $festival)
    {
        $festivalTranslation = FestivalTranslation::where('festival_id', $festival->id);
        if ($festivalTranslation) {
            $festivalTranslation->delete();
        }
        $ticketPrice = TicketPrice::where('festival_id', $festival->id);
        if ($ticketPrice) {
            $ticketPrice->delete();
        }

        // delete image
        if ($festival->foto != '' && file_exists(public_path('upload/festival/') . $festival->foto)) {
            unlink(public_path('upload/festival/large/') . $festival->foto);
            unlink(public_path('upload/festival/') . $festival->foto);
        }
        $festival->delete();

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/festival');
    }

    public function upload(Request $request)
    {
        if ($request->festival_id) {
            $festival = Festival::findorfail($request->festival_id);

            if ($festival->foto != '' && file_exists(public_path('upload/festival/') . $festival->foto)) {
                unlink(public_path('upload/festival/large/') . $festival->foto);
                unlink(public_path('upload/festival/') . $festival->foto);

                $festival->foto = "";
                $festival->save();
            }
        }

        $upload_path = public_path('upload/festival/large/');
        $upload_path2 = public_path('upload/festival/');

        $image_parts = explode(";base64,", $request->image);
        $image_base64 = base64_decode($image_parts[1]);

        $file_name = uniqid() . '.jpg';
        $file_large = $upload_path . $file_name;

        // image besar
        file_put_contents($file_large, $image_base64);
        // image kecil
        copy($file_large, $upload_path2 . $file_name);

        // cut image
        $imgkecil = Image::make($upload_path2 . $file_name);
        $imgkecil->fit(400, 300);
        $imgkecil->save();

        return response()->json(['success' => 'success', 'filename' => $file_name]);
    }

    public function changeBestFestival($id, $status) {

        $festival = Festival::findorfail($id);

        $month = date("m",strtotime($festival->event_date_from));
        $year = date("Y",strtotime($festival->event_date_from));

        DB::table('festival')->whereMonth('event_date_from',$month)->whereYear('event_date_from',$year)->update(
            array(
            'best_festival'=> 0,
            )
        );

        $festival->best_festival = 1;
        $festival->save();
        
        return redirect('admin/festival');

    }
}
