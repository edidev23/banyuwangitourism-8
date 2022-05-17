<?php

namespace App\Http\Controllers\Api;

use App\Models\UserBanyuwangitourism;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = UserBanyuwangitourism::orderBy("created_at", "desc")->get();

        return response()->json($user, 200);
    }

    public function userById($id)
    {
        $user = UserBanyuwangitourism::find($id);

        return response()->json($user, 200);
    }

    public function userByEmail($email)
    {
        $user = UserBanyuwangitourism::where("email", $email)->first();

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|unique:user_banyuwangitourism',
            'kota' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->messages()
            ], 404);
        }

        $user = new UserBanyuwangitourism();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->kota = $request->kota;
        $user->save();

        return response()->json([
            "status" => true,
            "message" => "User berhasil ditambah",
            "data" => $user,
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|unique:user_banyuwangitourism,email,' . $id,
            'kota' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->messages()
            ], 404);
        }

        $user = UserBanyuwangitourism::find($id);

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "User Tidak ditemukan"
            ], 400);
        } else {
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->kota = $request->kota;
            $user->save();
        }


        return response()->json([
            "status" => true,
            "message" => "User berhasil ditambah",
            "data" => $user,
        ]);
    }
}
