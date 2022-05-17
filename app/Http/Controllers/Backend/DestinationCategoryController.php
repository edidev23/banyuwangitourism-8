<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\DestinationCategory;
use App\Models\DestinationCategoryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DestinationCategoryController extends Controller
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
        $destination_category = DB::table('destination_category')
            ->join('destination_category_translation', 'destination_category.id', '=', 'destination_category_translation.destination_category_id')
            ->where('destination_category_translation.language_id', 'ID')
            ->get();

        return view('backend/pages/destination-category/view', compact('destination_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        return view('backend/pages/destination-category/add', compact('lang'));
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
        $d = new DestinationCategory;

        foreach ($lang as $l) {
            $data_validation['name' . $l->id] = 'required';
        }
        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // toast('Check all your input!', 'error');
            return redirect('admin/destination-category/create')->withErrors($validator)->withInput();
        } else {
            // save category
            $d->save();
            // save category translation
            foreach ($lang as $l) {
                $t = new DestinationCategoryTranslation;
                $t->name = $request->input('name' . $l->id);
                $t->slug = Str::slug($request->input('name' . $l->id));
                $t->destination_category_id = $d->id;
                $t->language_id = $l->id;
                $t->save();
            }

            // toast('Your Post as been submited!', 'success')->autoClose(2000);

            if ($request->btn_save == "save_add_another") {
                return redirect('admin/destination-category/create');
            } else {
                return redirect('admin/destination-category');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DestinationCategory  $destinationCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DestinationCategory $destinationCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DestinationCategory  $destinationCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(DestinationCategory $destinationCategory)
    {
        // dd($destinationCategory->destinationCategoryTranslation);
        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        return view('backend/pages/destination-category/edit', compact('destinationCategory', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DestinationCategory  $destinationCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DestinationCategory $destinationCategory)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        foreach ($lang as $l) {
            $data_validation['name' . $l->id] = 'required';
        }
        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // toast('Check all your input!', 'error');
            return redirect('admin/destination-category/create')->withErrors($validator)->withInput();
        } else {
            // save category
            $destinationCategory->save();
            // save category translation
            foreach ($lang as $l) {
                $translation_id = $request->input('destination_category_translation_id' . $l->id);

                if (isset($translation_id)) {
                    $t = DestinationCategoryTranslation::findorfail($translation_id);
                    $t->name = $request->input('name' . $l->id);
                    $t->slug = Str::slug($request->input('name' . $l->id));
                    $t->destination_category_id = $destinationCategory->id;
                    $t->language_id = $l->id;
                    $t->save();
                } else {
                    // insert new
                    $t = new DestinationCategoryTranslation;
                    $t->name = $request->input('name' . $l->id);
                    $t->slug = Str::slug($request->input('name' . $l->id));
                    $t->destination_category_id = $destinationCategory->id;
                    $t->language_id = $l->id;
                    $t->save();
                }
            }

            // toast('Your Post as been updated!', 'success')->autoClose(2000);

            return redirect('admin/destination-category');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DestinationCategory  $destinationCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestinationCategory $destinationCategory)
    {
        $destinationCategoryTranslation = DestinationCategoryTranslation::where('destination_category_id', $destinationCategory->id);
        if ($destinationCategoryTranslation) {
            $destinationCategoryTranslation->delete();
        }
        $destinationCategory->delete();

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/destination-category');
    }
}
