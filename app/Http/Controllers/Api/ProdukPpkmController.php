<?php

namespace App\Http\Controllers\Api;

use App\Models\ProdukPpkm;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukPpkmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk_ppkm = ProdukPpkm::orderBy("created_at", "desc")->get();

        return response()->json($produk_ppkm, 200);
    }

    public function getAll(Request $request)
    {
        $category = $request->category ? $request->category : "makanan";
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $keyword = $request->has('keyword') ? $request->get('keyword') : '';

        $produk_ppkm = DB::table("produk_ppkm")
        ->where("category", $category)
        ->Where('name', 'like', '%' . $keyword . '%')
        ->paginate($limit);

        return response()->json($produk_ppkm, 200);
    }
}
