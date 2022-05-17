<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProdukPpkm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Intervention\Image\ImageManagerStatic as Image;

class ProdukPpkmController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk_ppkm = ProdukPpkm::all();
        return view("backend/pages/produk_ppkm/view", compact("produk_ppkm"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend/pages/produk_ppkm/add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $d = new ProdukPpkm;

        $this->validate($request, [
            // 'id'      => 'required|unique:language,id,' . $d['id'],
            'name'      => 'required',
            'category'      => 'required',
            'description'      => 'required',
            'whatsapp'      => 'required',
            'foto'      => 'required',
            'address'      => 'required',
            'lat'      => 'required',
            'lng'      => 'required',
        ]);

        $d->name = $request->name;
        $d->category = $request->category;
        $d->description = $request->description;
        $d->address = $request->address;
        $d->lat = $request->lat;
        $d->lng = $request->lng;
        $d->website = $request->website;
        $d->whatsapp = $request->whatsapp;
        $d->instagram = $request->instagram;
        $d->facebook = $request->facebook;
        $d->foto = $request->foto;

        $d->save();

        // toast('Your Post as been submited!', 'success')->autoClose(2000);

        if ($request->btn_save == "save_add_another") {
            return redirect('admin/produk_ppkm/create');
        } else {
            return redirect('admin/produk_ppkm');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdukPpkm  $produkPpkm
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukPpkm $produkPpkm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdukPpkm  $produkPpkm
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdukPpkm $produk_ppkm)
    {
        return view("backend/pages/produk_ppkm/edit", compact("produk_ppkm"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdukPpkm  $produkPpkm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdukPpkm $produk_ppkm)
    {
        $this->validate($request, [
            'category'      => 'required',
            'description'      => 'required',
            'whatsapp'      => 'required',
            'foto'      => 'required',
            'address'      => 'required',
            'lat'      => 'required',
            'lng'      => 'required',
        ]);

        $produk_ppkm->name = $request->name;
        $produk_ppkm->category = $request->category;
        $produk_ppkm->description = $request->description;
        $produk_ppkm->address = $request->address;
        $produk_ppkm->lat = $request->lat;
        $produk_ppkm->lng = $request->lng;
        $produk_ppkm->whatsapp = $request->whatsapp;
        $produk_ppkm->website = $request->website;
        $produk_ppkm->instagram = $request->instagram;
        $produk_ppkm->facebook = $request->facebook;
        $produk_ppkm->foto = $request->foto;
        $produk_ppkm->save();

        // toast('Your Post as been updated!', 'success')->autoClose(2000);
        return redirect('admin/produk_ppkm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdukPpkm  $produkPpkm
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukPpkm $produk_ppkm)
    {
        // delete image
        if ($produk_ppkm->foto != '' && file_exists(public_path('upload/produk_ppkm/') . $produk_ppkm->foto)) {
            unlink(public_path('upload/produk_ppkm/') . $produk_ppkm->foto);
            unlink(public_path('upload/produk_ppkm/large/') . $produk_ppkm->foto);
        }
        $produk_ppkm->delete();

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/produk_ppkm');
    }

    public function upload(Request $request)
    {
        if ($request->produk_id) {
            $produk_ppkm = ProdukPpkm::findorfail($request->produk_id);

            if ($produk_ppkm->foto != '' && file_exists(public_path('upload/produk_ppkm/') . $produk_ppkm->foto)) {
                unlink(public_path('upload/produk_ppkm/large/') . $produk_ppkm->foto);
                unlink(public_path('upload/produk_ppkm/') . $produk_ppkm->foto);

                $produk_ppkm->foto = "";
                $produk_ppkm->save();
            }
        }

        $upload_path = public_path('upload/produk_ppkm/large/');
        $upload_path2 = public_path('upload/produk_ppkm/');

        $image_parts = explode(";base64,", $request->image);
        $image_base64 = base64_decode($image_parts[1]);

        $file_name = uniqid() . '.jpg';
        $file_large = $upload_path . $file_name;

        // image besar
        file_put_contents($file_large, $image_base64);
        // image kecil
        copy($file_large, $upload_path2 . $file_name);

        // 580 * 700
        // cut image
        $imgkecil = Image::make($upload_path2 . $file_name);
        $imgkecil->fit(335, 400);
        $imgkecil->save();

        return response()->json(['success' => 'success', 'filename' => $file_name]);
    }
}
