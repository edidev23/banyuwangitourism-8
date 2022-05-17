<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\GeoparkDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;

class GeoparkDestinationController extends Controller
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
        $destination = GeoparkDestination::all();

        return view('backend/pages/geopark-destination/view', compact('destination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend/pages/geopark-destination/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $d = new GeoparkDestination();

        $data_validation['title'] = 'required';
        $data_validation['description'] = 'required';
        $data_validation['text'] = 'required';
        $data_validation['image'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/geopark-destination/create')->withErrors($validator)->withInput();
        } else {
            // save destination
            $d->title = $request->title;
            $d->slug = Str::slug($request->title);
            $d->description = $request->description;
            $d->text = $request->text;
            $d->foto = $request->foto;
            $d->save();
            // toast('Your Post as been submited!', 'success')->autoClose(2000);

            if ($request->btn_save == "save_add_another") {
                return redirect('admin/geopark-destination/create');
            } else {
                return redirect('admin/geopark-destination');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function edit(GeoparkDestination $geopark_destination)
    {
        return view('backend/pages/geopark-destination/edit', compact('geopark_destination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeoparkDestination $geopark_destination)
    {
        $data_validation['title'] = 'required';
        $data_validation['description'] = 'required';
        $data_validation['text'] = 'required';
        $data_validation['foto'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/geopark-destination/' . $geopark_destination->id . '/edit')->withErrors($validator)->withInput();
        } else {
            // save destination
            $geopark_destination->title = $request->title;
            $geopark_destination->description = $request->description;
            $geopark_destination->text = $request->text;
            $geopark_destination->foto = $request->foto;
            $geopark_destination->save();
            // toast('Your Post as been updated!', 'success')->autoClose(2000);
            return redirect('admin/geopark-destination');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeoparkDestination $geopark_destination)
    {
        // delete image
        if ($geopark_destination->foto != '' && file_exists(public_path('upload/destination/') . $geopark_destination->foto)) {
            unlink(public_path('upload/geopark-destination/large/') . $geopark_destination->foto);
            unlink(public_path('upload/geopark-destination/') . $geopark_destination->foto);
        }
        $geopark_destination->delete();

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/geopark-destination');
    }

    public function upload(Request $request)
    {
        if ($request->id) {
            $destination = GeoparkDestination::findorfail($request->id);

            if ($destination->foto != '' && file_exists(public_path('upload/destination/') . $destination->foto)) {
                unlink(public_path('upload/geopark-destination/large/') . $destination->foto);
                unlink(public_path('upload/geopark-destination/') . $destination->foto);

                $destination->foto = "";
                $destination->save();
            }
        }

        $upload_path = public_path('upload/geopark-destination/large/');
        $upload_path2 = public_path('upload/geopark-destination/');

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
}
