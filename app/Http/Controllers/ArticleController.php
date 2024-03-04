<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status     = $request->get('status');
        $keyword    = $request->get('keyword') ? $request->get('keyword') : '';
        $category   = $request->get('c') ? $request->get('c') : '';

        if ($status) {
            // $articles = \App\Article::where('status', strtoupper($status))->where('title', 'LIKE', "%$keyword%")->paginate(10);
            $articles = Article::with('categories')
                ->whereHas('categories', function ($q) use ($category) {
                    $q->where('name', 'LIKE', "%$category%");
                })
                ->where('status', strtoupper($status))
                ->where('title', 'LIKE', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // $articles = \App\Article::with('categories')->where('title', 'LIKE', "%$keyword%")->paginate(10);
            $articles = Article::with('categories')
                ->whereHas('categories', function ($q) use ($category) {
                    $q->where('name', 'LIKE', "%$category%");
                })
                ->where('title', 'LIKE', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('article.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('article.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title'      => 'required|min:2|max:200'
        ])->validate();

        $new_articles               = new Article;
        $new_articles->title        = $request->get('title');
        $new_articles->slug         = Str::slug($request->get('title'), '-');
        $new_articles->content      = $request->get('content');
        $new_articles->create_by    = Auth::user()->id;
        $new_articles->status       = $request->get('save_action');
        $new_articles->save();

        // save in table article category
        $new_articles->categories()->attach($request->category);

        return redirect()->route('article.index')->with('success', 'Article successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('article.edit', ['article' => $article, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $article->title        = $request->get('title');
        $article->slug         = Str::slug($request->get('title'), '-');
        $article->content      = $request->get('content');
        $article->status       = $request->get('save_action');
        $article->update_by    = Auth::user()->id;

        $article->categories()->sync($request->get('categories'));

        $article->save();
        return redirect()->route('article.index')->with('success', 'Category successfully update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->forceDelete();

        return redirect()->route('article.index')->with('success', 'Article permanenly delete');
    }

    public function upload(Reques $request)
    {
        if ($request->hasFile('upload')) {
            // $originName = $request->file('upload')->getClientOriginalName();
            // $fileName   = pathinfo($originName, PATHINFO_FILENAME);
            // $extension  = $request->file('upload')->getClientOriginalExtension();
            // $fileName   = $fileName.'_'.time().'.'.$extension;

            // $request->file('upload')->move(public_path('images'), $fileName);

            // $CKEditorFuncNum = $request->input('CKEditorFuncNum');

            // $url = asset('images/'.$fileName); 
            // $msg = 'Image uploaded successfully'; 

            // $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            // @header('Content-type: text/html; charset=utf-8'); 

            // echo $response;

        }
    }
}
