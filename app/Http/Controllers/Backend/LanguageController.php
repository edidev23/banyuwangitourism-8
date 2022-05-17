<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
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
        $language = Language::all()->sortBy('created_at');

        return view('backend/pages/language/view', compact('language'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend/pages/language/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $d = new Language;

        $this->validate($request, [
            'id'      => 'required|unique:language,id,' . $d['id'],
            'name'      => 'required'
        ]);

        $d->id = $request->id;
        $d->name = $request->name;
        $d->save();

        // toast('Your Post as been submited!', 'success')->autoClose(2000);

        if ($request->btn_save == "save_add_another") {
            return redirect('admin/language/create');
        } else {
            return redirect('admin/language');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('backend/pages/language/edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $this->validate($request, [
            'name'      => 'required'
        ]);

        $language->name = $request->name;
        $language->save();

        // toast('Your Post as been updated!', 'success')->autoClose(2000);
        return redirect('admin/language');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        if ($language->id == "ID") {
            // toast('Your Language is main content, and cannot deleted!', 'error');
        } else {
            $language->delete();
            // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        }
        return redirect('admin/language');
    }

    public function status($id, $status)
    {

        $language = Language::findorfail($id);
        $language->status = $status;

        if ($language->id == "ID") {
            // toast('Your Language is main content, and cannot off!', 'error');
        } else {
            $language->save();
            // toast('Your Post as been updated!', 'success')->autoClose(2000);
        }

        return redirect('admin/language');
    }
}
