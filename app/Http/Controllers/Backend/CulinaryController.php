<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Culinary;
use App\Models\CulinaryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class CulinaryController extends Controller
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
        $culinary = DB::table('culinary')
            ->join('culinary_translation', 'culinary.id', '=', 'culinary_translation.culinary_id')
            ->where('culinary_translation.language_id', 'ID')
            ->get();

        return view('backend/pages/culinary/view', compact('culinary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        return view('backend/pages/culinary/add', compact('lang'));
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
        $d = new Culinary;

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
            return redirect('admin/culinary/create')->withErrors($validator)->withInput();
        } else {
            // save culinary
            $d->lat = $request->lat;
            $d->lng = $request->lng;
            $d->hp = $request->hp;
            $d->price = input_angka($request->price);
            $d->foto = $request->foto;
            $d->save();
            // save culinary translation
            foreach ($lang as $l) {
                $t = new CulinaryTranslation;
                $t->title = $request->input('title' . $l->id);
                $t->slug = Str::slug($request->input('title' . $l->id));
                $t->description = $request->input('description' . $l->id);
                $t->address = $request->input('address' . $l->id);
                $t->culinary_id = $d->id;
                $t->language_id = $l->id;
                $t->save();
            }

            // toast('Your Post as been submited!', 'success')->autoClose(2000);

            if ($request->btn_save == "save_add_another") {
                return redirect('admin/culinary/create');
            } else {
                return redirect('admin/culinary');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Culinary  $culinary
     * @return \Illuminate\Http\Response
     */
    public function show(Culinary $culinary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Culinary  $culinary
     * @return \Illuminate\Http\Response
     */
    public function edit(Culinary $culinary)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        return view('backend/pages/culinary/edit', compact('lang', 'culinary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Culinary  $culinary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Culinary $culinary)
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
            return redirect('admin/culinary/' . $culinary->id . '/edit')->withErrors($validator)->withInput();
        } else {
            // save culinary
            $culinary->lat = $request->lat;
            $culinary->lng = $request->lng;
            $culinary->hp = $request->hp;
            $culinary->price = input_angka($request->price);
            $culinary->foto = $request->foto;
            $culinary->save();
            // save culinary translation
            foreach ($lang as $l) {

                $translation_id = $request->input('culinary_translation_id' . $l->id);

                if (isset($translation_id)) {
                    $t = CulinaryTranslation::findorfail($translation_id);
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->culinary_id = $culinary->id;
                    $t->language_id = $l->id;
                    $t->save();
                } else {
                    $t = new CulinaryTranslation;
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->description = $request->input('description' . $l->id);
                    $t->address = $request->input('address' . $l->id);
                    $t->culinary_id = $culinary->id;
                    $t->language_id = $l->id;
                    $t->save();
                }
            }

            // toast('Your Post as been updated!', 'success')->autoClose(2000);
            return redirect('admin/culinary');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Culinary  $culinary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Culinary $culinary)
    {
        $culinaryTranslation = CulinaryTranslation::where('culinary_id', $culinary->id);
        if ($culinaryTranslation) {
            $culinaryTranslation->delete();
        }

        // delete image
        if ($culinary->foto != '' && file_exists(public_path('upload/culinary/') . $culinary->foto)) {
            unlink(public_path('upload/culinary/large/') . $culinary->foto);
            unlink(public_path('upload/culinary/') . $culinary->foto);
        }
        $culinary->delete();

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/culinary');
    }

    public function upload(Request $request)
    {
        if ($request->culinary_id) {
            $culinary = Culinary::findorfail($request->culinary_id);

            if ($culinary->foto != '' && file_exists(public_path('upload/culinary/') . $culinary->foto)) {
                unlink(public_path('upload/culinary/large/') . $culinary->foto);
                unlink(public_path('upload/culinary/') . $culinary->foto);

                $culinary->foto = "";
                $culinary->save();
            }
        }

        $upload_path = public_path('upload/culinary/large/');
        $upload_path2 = public_path('upload/culinary/');

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
