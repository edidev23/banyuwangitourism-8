<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Handcraft;
use App\Models\HandcraftTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;

class HandcraftController extends Controller
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
        $handcraft = DB::table('handcraft')
            ->join('handcraft_translation', 'handcraft.id', '=', 'handcraft_translation.handcraft_id')
            ->where('handcraft_translation.language_id', 'ID')
            ->get();

        return view('backend/pages/handcraft/view', compact('handcraft'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        return view('backend/pages/handcraft/add', compact('lang'));
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
        $d = new Handcraft;

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['description' . $l->id] = 'required';
            $data_validation['address' . $l->id] = 'required';
        }
        $data_validation['lat'] = 'required';
        $data_validation['lng'] = 'required';
        $data_validation['hp'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/handcraft/create')->withErrors($validator)->withInput();
        } else {
            // save handcraft
            $d->lat = $request->lat;
            $d->lng = $request->lng;
            $d->hp = $request->hp;
            $d->price = input_angka($request->price);
            $d->foto = $request->foto;
            $d->website = $request->website;
            $d->youtube = $request->youtube;
            $d->instagram = $request->instagram;
            $d->save();
            // save handcraft translation
            foreach ($lang as $l) {
                $t = new HandcraftTranslation;
                $t->title = $request->input('title' . $l->id);
                $t->slug = Str::slug($request->input('title' . $l->id));
                $t->description = $request->input('description' . $l->id);
                $t->address = $request->input('address' . $l->id);
                $t->handcraft_id = $d->id;
                $t->language_id = $l->id;
                $t->save();
            }

            // toast('Your Post as been submited!', 'success')->autoClose(2000);

            if ($request->btn_save == "save_add_another") {
                return redirect('admin/handcraft/create');
            } else {
                return redirect('admin/handcraft');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Handcraft  $handcraft
     * @return \Illuminate\Http\Response
     */
    public function show(Handcraft $handcraft)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Handcraft  $handcraft
     * @return \Illuminate\Http\Response
     */
    public function edit(Handcraft $handcraft)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        return view('backend/pages/handcraft/edit', compact('lang', 'handcraft'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Handcraft  $handcraft
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Handcraft $handcraft)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['description' . $l->id] = 'required';
            $data_validation['address' . $l->id] = 'required';
        }
        $data_validation['lat'] = 'required';
        $data_validation['lng'] = 'required';
        $data_validation['hp'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('handcraft/' . $handcraft->id . '/edit')->withErrors($validator)->withInput();
        } else {
            // save handcraft
            $handcraft->lat = $request->lat;
            $handcraft->lng = $request->lng;
            $handcraft->hp = $request->hp;
            $handcraft->price = input_angka($request->price);
            $handcraft->foto = $request->foto;
            $handcraft->website = $request->website;
            $handcraft->youtube = $request->youtube;
            $handcraft->instagram = $request->instagram;
            $handcraft->save();
            // save handcraft translation
            foreach ($lang as $l) {

                $translation_id = $request->input('handcraft_translation_id' . $l->id);

                if (isset($translation_id)) {
                    $t = HandcraftTranslation::findorfail($translation_id);
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->handcraft_id = $handcraft->id;
                    $t->language_id = $l->id;
                    $t->save();
                } else {
                    $t = new HandcraftTranslation;
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->handcraft_id = $handcraft->id;
                    $t->language_id = $l->id;
                    $t->save();
                }
            }

            // toast('Your Post as been updated!', 'success')->autoClose(2000);
            return redirect('admin/handcraft');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Handcraft  $handcraft
     * @return \Illuminate\Http\Response
     */
    public function destroy(Handcraft $handcraft)
    {
        $handcraftTranslation = HandcraftTranslation::where('handcraft_id', $handcraft->id);
        if ($handcraftTranslation) {
            $handcraftTranslation->delete();
        }

        // delete image
        if ($handcraft->foto != '' && file_exists(public_path('upload/handcraft/') . $handcraft->foto)) {
            unlink(public_path('upload/handcraft/') . $handcraft->foto);
            unlink(public_path('upload/handcraft/large/') . $handcraft->foto);
        }
        $handcraft->delete();

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/handcraft');
    }

    public function upload(Request $request)
    {
        if ($request->handcraft_id) {
            $handcraft = Handcraft::findorfail($request->handcraft_id);

            if ($handcraft->foto != '' && file_exists(public_path('upload/handcraft/') . $handcraft->foto)) {
                unlink(public_path('upload/handcraft/large/') . $handcraft->foto);
                unlink(public_path('upload/handcraft/') . $handcraft->foto);

                $handcraft->foto = "";
                $handcraft->save();
            }
        }

        $upload_path = public_path('upload/handcraft/large/');
        $upload_path2 = public_path('upload/handcraft/');

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
}
