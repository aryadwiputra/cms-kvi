<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abouts = About::get();
        // dd($abouts);
        return view('landing.about.index', ['abouts' => $abouts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('landing.about.edit', ['about' => $about]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        Validator::make($request->all(), [
            'caption'     => 'required|min:15',
        ])->validate();

        $about->caption         = $request->get('caption');

        if ($request->file('image')) {
            // if($about->image && file_exists(storage_path('app/public/'.$about->image))){
            //     \Storage::delete('public/'.$about->image);
            // }

            if ($about->image) {
                File::delete('about_image/' . $about->image);
            }

            // $new_image = $request->file('image')->store('about_image', 'public');
            $nama_file = time() . "_" . $request->file('image')->getClientOriginalName();
            $new_image = $request->file('image')->move('about_image', $nama_file);
            $about->image = $nama_file;
        }

        $about->save();

        return redirect()->route('admin.abouts.index')->with('success', 'Data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        //
    }
}