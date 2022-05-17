<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class UsersController extends Controller
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
        $user = User::all();

        return view('backend/pages/user/view', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend/pages/user/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $d = new User;

        $this->validate($request, [
            'email'     => 'required|unique:users,email,' . $d['id'],
            'role'  => 'required',
            'password'  => 'required|min:6'
        ]);

        $d->name = $request->name;
        $d->email = $request->email;
        $d->role = $request->role;
        $d->status = 1;
        $d->password = bcrypt($request->password);
        $d->foto = $request->foto;
        $d->save();

        // toast('Your data as been submited!', 'success')->autoClose(2000);

        if ($request->btn_save == "save_add_another") {
            return redirect('admin/users/create');
        } else {
            return redirect('admin/users');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('backend/pages/user/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'email'     => 'required|unique:users,email,' . $user['id'],
            'role'      => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = 1;
        $user->foto = $request->foto;
        $user->save();

        // toast('Your Data as been updated!', 'success')->autoClose(2000);
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // delete image
        if ($user->foto != '' && file_exists(public_path('upload/user/') . $user->foto)) {
            unlink(public_path('upload/user/') . $user->foto);
            unlink(public_path('upload/user/large/') . $user->foto);
        }

        $user->delete();
        // toast('Your Post as been deleted!', 'success')->autoClose(2000);

        return redirect('admin/users');
    }

    public function upload(Request $request)
    {
        if ($request->user_id) {
            $user = User::findorfail($request->user_id);

            if ($user->foto != '' && file_exists(public_path('upload/user/') . $user->foto)) {
                unlink(public_path('upload/user/large/') . $user->foto);
                unlink(public_path('upload/user/') . $user->foto);

                $user->foto = "";
                $user->save();
            }
        }

        $upload_path = public_path('upload/user/large/');
        $upload_path2 = public_path('upload/user/');

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
        $imgkecil->fit(150, 150);
        $imgkecil->save();

        return response()->json(['success' => 'success', 'filename' => $file_name]);
    }

    public function change_password()
    {
        return view('backend/pages/user/change-password');
    }

    public function update_password(Request $request, User $user)
    {
        $this->validate($request, [
            // 'old_password' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);

        //Change Password
        $user->password = bcrypt($request->password);
        $user->status = 1;
        $user->save();

        // toast('Your Data as been updated!', 'success')->autoClose(2000);
        return redirect('admin/users/change-password');
    }
}
