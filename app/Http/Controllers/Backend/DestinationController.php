<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminEtax;
use App\Models\Destination;
use App\Models\DestinationBooking;
use App\Models\DestinationOffline;
use App\Models\DestinationTiket;
use App\Models\DestinationTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;

class DestinationController extends Controller
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
        $destination = DB::table('destination')
            ->join('destination_category', 'destination_category.id', '=', 'destination.destination_category_id')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->join('destination_translation', 'destination.id', '=', 'destination_translation.destination_id')
            ->where('destination_translation.language_id', 'ID')
            ->where('destination_category_translation.language_id', 'ID')
            ->get()->sortBy('title');

        return view('backend/pages/destination/view', compact('destination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = DB::table('destination_category')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->where('destination_category_translation.language_id', 'ID')
            ->get();

        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        return view('backend/pages/destination/add', compact('lang', 'category'));
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
        $d = new Destination;

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['description' . $l->id] = 'required';
            $data_validation['address' . $l->id] = 'required';
        }
        $data_validation['lat'] = 'required';
        $data_validation['lng'] = 'required';
        $data_validation['destination_category_id'] = 'required';
        $data_validation['hp'] = 'required';
        $data_validation['verified'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/destination/create')->withErrors($validator)->withInput();
        } else {
            // save destination
            $d->lat = $request->lat;
            $d->lng = $request->lng;
            $d->destination_category_id = $request->destination_category_id;
            $d->hp = $request->hp;
            $d->verified = $request->verified;
            $d->view_360 = $request->view_360;
            $d->foto = $request->foto;
            $d->publish = 0;

            $data_kuota = DestinationTiket::take(1)->first();

            // save tiket
            $tiket = new DestinationTiket;
            $tiket->tiket_domestik = 0;
            $tiket->tiket_manca = 0;
            $tiket->tiket_weekend = 0;
            $tiket->parkir_roda_dua = 0;
            $tiket->parkir_roda_empat = 0;
            $tiket->parkir_bus = 0;
            $tiket->status_kuota = $data_kuota->status_kuota;
            $tiket->limit_kuota = $data_kuota->limit_kuota;
            $tiket->hari_libur = $data_kuota->hari_libur;
            $tiket->save();

            $d->destination_ticket_id = $tiket->id;
            $d->save();
            // save destination translation
            foreach ($lang as $l) {
                $t = new DestinationTranslation;
                $t->title = $request->input('title' . $l->id);
                $t->slug = Str::slug($request->input('title' . $l->id));
                $t->description = $request->input('description' . $l->id);
                $t->address = $request->input('address' . $l->id);
                $t->destination_id = $d->id;
                $t->language_id = $l->id;
                $t->save();
            }

            // toast('Your Post as been submited!', 'success')->autoClose(2000);

            if ($request->btn_save == "save_add_another") {
                return redirect('admin/destination/create');
            } else {
                return redirect('admin/destination');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function show(Destination $destination)
    {
        return view('tes-map');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function edit(Destination $destination)
    {
        $category = DB::table('destination_category')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->where('destination_category_translation.language_id', 'ID')
            ->get();

        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        return view('backend/pages/destination/edit', compact('category', 'lang', 'destination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destination $destination)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['description' . $l->id] = 'required';
            $data_validation['address' . $l->id] = 'required';
        }
        $data_validation['lat'] = 'required';
        $data_validation['lng'] = 'required';
        $data_validation['destination_category_id'] = 'required';
        $data_validation['hp'] = 'required';
        $data_validation['verified'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('destination/' . $destination->id . '/edit')->withErrors($validator)->withInput();
        } else {
            // save destination
            $destination->lat = $request->lat;
            $destination->lng = $request->lng;
            $destination->destination_category_id = $request->destination_category_id;
            $destination->hp = $request->hp;
            $destination->verified = $request->verified;
            $destination->view_360 = $request->view_360;
            $destination->foto = $request->foto;
            $destination->save();
            // save destination translation
            foreach ($lang as $l) {

                $translation_id = $request->input('destination_translation_id' . $l->id);

                if (isset($translation_id)) {
                    $t = DestinationTranslation::findorfail($translation_id);
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->destination_id = $destination->id;
                    $t->language_id = $l->id;
                    $t->save();
                } else {
                    $t = new DestinationTranslation;
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->destination_id = $destination->id;
                    $t->language_id = $l->id;
                    $t->save();
                }
            }

            // toast('Your Post as been updated!', 'success')->autoClose(2000);
            return redirect('admin/destination');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $destination)
    {
        $destinationOffline = DestinationOffline::where('destination_id', $destination->id)->first();
        $destinationBooking = DestinationBooking::where('destination_id', $destination->id)->first();

        // tidak boleh dihapus
        if ($destinationOffline || $destinationBooking || $destination->email_admin != "") {
            return redirect('admin/destination');
        }

        $destinationTranslation = DestinationTranslation::where('destination_id', $destination->id);
        $destinationTiket = DestinationTiket::where('id', $destination->destination_ticket_id);
        $adminEtax = AdminEtax::where('destination_id', $destination->id);


        // delete image
        if ($destination->foto != '' && file_exists(public_path('upload/destination/') . $destination->foto)) {
            unlink(public_path('upload/destination/large/') . $destination->foto);
            unlink(public_path('upload/destination/') . $destination->foto);
        }

        if ($destinationTranslation && $destinationTiket && $adminEtax && $destination) {
            $destinationTranslation->delete();
            $adminEtax->delete();
            $destination->delete();
            $destinationTiket->delete();
        }

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/destination');
    }

    public function upload(Request $request)
    {
        if ($request->destination_id) {
            $destination = Destination::findorfail($request->destination_id);

            if ($destination->foto != '' && file_exists(public_path('upload/destination/') . $destination->foto)) {
                unlink(public_path('upload/destination/large/') . $destination->foto);
                unlink(public_path('upload/destination/') . $destination->foto);

                $destination->foto = "";
                $destination->save();
            }
        }

        $upload_path = public_path('upload/destination/large/');
        $upload_path2 = public_path('upload/destination/');

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
        $imgkecil->fit(450, 300);
        $imgkecil->save();

        return response()->json(['success' => 'success', 'filename' => $file_name]);
    }

    public function status($id, $status)
    {
        $destination = Destination::findorfail($id);

        $destination->publish = $status;
        $destination->save();

        return redirect('admin/destination');
    }
}
