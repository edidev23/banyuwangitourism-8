<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\News;
use App\Models\NewsTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class NewsController extends Controller
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
        $news = DB::table('news')
            ->join('news_translation', 'news.id', '=', 'news_translation.news_id')
            ->where('news_translation.language_id', 'ID')
            ->orderBy("created_at", "desc")
            ->get();

        return view('backend/pages/news/view', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');
        return view('backend/pages/news/add', compact('lang'));
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
        $d = new News;

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['text' . $l->id] = 'required';
        }
        $data_validation['category'] = 'required';
        $data_validation['sumber'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/news/create')->withErrors($validator)->withInput();
        } else {
            // save news
            $d->category = $request->category;
            $d->sumber = $request->sumber;
            $d->foto = $request->foto;
            $d->save();
            // save news translation
            foreach ($lang as $l) {
                $t = new NewsTranslation;
                $t->title = $request->input('title' . $l->id);
                $t->slug = Str::slug($request->input('title' . $l->id));
                $t->text = $request->input('text' . $l->id);
                $t->news_id = $d->id;
                $t->language_id = $l->id;
                $t->save();
            }

            // toast('Your Post as been submited!', 'success')->autoClose(2000);

            if ($request->btn_save == "save_add_another") {
                return redirect('admin/news/create');
            } else {
                return redirect('admin/news');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        return view('backend/pages/news/edit', compact('lang', 'news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $lang = Language::where('status', 1)->get()->sortBy('created_at');

        foreach ($lang as $l) {
            $data_validation['title' . $l->id] = 'required';
            $data_validation['text' . $l->id] = 'required';
        }
        $data_validation['category'] = 'required';
        $data_validation['sumber'] = 'required';

        $validator = Validator::make($request->all(), $data_validation);

        // Check validation failure
        if ($validator->fails()) {
            // alert()->error('Error', 'Check all your input');
            return redirect('admin/news/' . $news->id . '/edit')->withErrors($validator)->withInput();
        } else {
            // save news
            $news->category = $request->category;
            $news->sumber = $request->sumber;
            $news->foto = $request->foto;
            $news->save();
            // save news translation
            foreach ($lang as $l) {

                $translation_id = $request->input('news_translation_id' . $l->id);

                if (isset($translation_id)) {
                    $t = NewsTranslation::findorfail($translation_id);
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->text = $request->input('text' . $l->id);
                    $t->news_id = $news->id;
                    $t->language_id = $l->id;
                    $t->save();
                } else {
                    $t = new NewsTranslation;
                    $t->title = $request->input('title' . $l->id);
                    $t->slug = Str::slug($request->input('title' . $l->id));
                    $t->text = $request->input('text' . $l->id);
                    $t->news_id = $news->id;
                    $t->language_id = $l->id;
                    $t->save();
                }
            }

            // toast('Your Post as been updated!', 'success')->autoClose(2000);
            return redirect('admin/news');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $newsTranslation = NewsTranslation::where('news_id', $news->id);
        if ($newsTranslation) {
            $newsTranslation->delete();
        }

        // delete image
        if ($news->foto != '' && file_exists(public_path('upload/news/') . $news->foto)) {
            unlink(public_path('upload/news/large/') . $news->foto);
            unlink(public_path('upload/news/') . $news->foto);
        }
        $news->delete();

        // toast('Your Post as been deleted!', 'success')->autoClose(2000);
        return redirect('admin/news');
    }

    public function upload(Request $request)
    {
        if ($request->news_id) {
            $news = News::findorfail($request->news_id);

            if ($news->foto != '' && file_exists(public_path('upload/news/') . $news->foto)) {
                unlink(public_path('upload/news/large/') . $news->foto);
                unlink(public_path('upload/news/') . $news->foto);

                $news->foto = "";
                $news->save();
            }
        }

        $upload_path = public_path('upload/news/large/');
        $upload_path2 = public_path('upload/news/');

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
