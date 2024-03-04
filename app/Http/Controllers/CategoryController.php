<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('category.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            'name'          => 'required|min:2|max:20|unique:categories',
            'description'   => 'required',
            'image'         => 'required',
        ])->validate();

        $new_category = new Category();
        $new_category->name         = strtoupper($request->get('name'));
        $new_category->description  = $request->get('description');
        $new_category->create_by    = strval(Auth::user()->id);
        $new_category->slug         = Str::slug($request->get('name'));

        if ($request->file('image')) {
            $nama_file = time() . "_" . $request->file('image')->getClientOriginalName();
            $image_path = $request->file('image')->move('category_image', $nama_file);
            $new_category->image = $nama_file;
        }

        $new_category->save();
        return redirect()->route('category.index')->with('success', 'Category successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $category = \App\Category::findOrFail($id);
        $category = Category::findOrFail($id);
        return view('category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:20',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // tambahkan validasi untuk file gambar
        ]);

        // Temukan kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Set nilai atribut kategori berdasarkan data yang diterima dari request
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];
        $category->slug = Str::slug($validatedData['name']);


        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image) {
                Storage::delete('category_image/' . $category->image);
            }

            // Simpan gambar yang baru diunggah
            $imagePath = $request->file('image')->store('category_image');
            $category->image = $imagePath;
        }

        // Update atribut lainnya
        $category->update_by = Auth::id();

        // Simpan perubahan pada kategori
        $category->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Category successfully updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // $category->articles()->sync([]);
        if ($category->image) {
            File::delete('category_image/' . $category->image);
        }
        $category->forceDelete();

        return redirect()->route('category.index')->with('success', 'Category successfully deleted.');
    }

    public function restore($id)
    {
        $category = \App\Category::withTrashed()->findOrFail($id);
        $category->restore();
    }

    public function deletePermanent($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            File::delete('category_image/' . $category->image);
        }
        $category->forceDelete();

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted.');
    }

    // ajax select2
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');
        $categories = Category::where('name', 'Like', "%$keyword%")->get();
        return $categories;
    }
}