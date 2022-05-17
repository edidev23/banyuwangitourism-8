<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Hotline;
use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;

class HotlineController extends Controller
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
        $hotline = Hotline::all()->sortByDesc('created_at');

        return view('backend/pages/hotline/view', compact('hotline'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend/pages/hotline/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $d = new Hotline;

        $this->validate($request, [
            'category'      => 'required',
            'category_name'      => 'required',
            'name'      => 'required',
            'address'      => 'required',
            'phone'      => 'required',
        ]);

        $d->category = $request->category;
        $d->category_name = $request->category_name;
        $d->name = $request->name;
        $d->address = $request->address;
        $d->phone = $request->phone;
        $d->foto = $request->foto;
        $d->save();

        // toast('Your Post as been submited!', 'success')->autoClose(2000);

        if ($request->btn_save == "save_add_another") {
            return redirect('admin/hotline/create');
        } else {
            return redirect('admin/hotline');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotline  $hotline
     * @return \Illuminate\Http\Response
     */
    public function show(Hotline $hotline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotline  $hotline
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotline $hotline)
    {
        return view('backend/pages/hotline/edit', compact('hotline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotline  $hotline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotline $hotline)
    {
        $this->validate($request, [
            'category'      => 'required',
            'category_name'      => 'required',
            'name'      => 'required',
            'address'      => 'required',
            'phone'      => 'required',
        ]);

        $hotline->category = $request->category;
        $hotline->category_name = $request->category_name;
        $hotline->name = $request->name;
        $hotline->address = $request->address;
        $hotline->phone = $request->phone;
        $hotline->foto = $request->foto;
        $hotline->save();

        // toast('Your Post as been updated!', 'success')->autoClose(2000);
        return redirect('admin/hotline');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotline  $hotline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotline $hotline)
    {
        // delete image
        if ($hotline->foto != '' && file_exists(public_path('upload/hotline/') . $hotline->foto)) {
            unlink(public_path('upload/hotline/') . $hotline->foto);
            unlink(public_path('upload/hotline/large/') . $hotline->foto);
        }

        $hotline->delete();
        // toast('Your Post as been deleted!', 'success')->autoClose(2000);

        return redirect('admin/hotline');
    }

    public function upload(Request $request)
    {
        if ($request->hotline_id) {
            $hotline = Hotline::findorfail($request->hotline_id);

            if ($hotline->foto != '' && file_exists(public_path('upload/hotline/') . $hotline->foto)) {
                unlink(public_path('upload/hotline/large/') . $hotline->foto);
                unlink(public_path('upload/hotline/') . $hotline->foto);

                $hotline->foto = "";
                $hotline->save();
            }
        }

        $upload_path = public_path('upload/hotline/large/');
        $upload_path2 = public_path('upload/hotline/');

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
