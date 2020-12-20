<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\DataTables\Admin\CategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\Admin\CategoryDataTable $categoryDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('admin.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $validated = $this->validate($request, [
            'name' => ['min:3', 'required', 'max:50', 'string', 'unique:categories,name'],
            'image' => ['nullable', 'max:1000', 'mimes:jpg,png,jpeg']
        ]);

        if ($request->has('image')) {
            $image = $request->file('image')->store('images/category', 'public');
        } else {
            $image = 'images/category/dummy.jpg';
        }

        $validated['slug'] = Str::slug($request->name) . '-' . uniqid();
        $validated['image'] = $image;

        $category = $category->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menambahkan Kategori Baru',
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $this->validate($request, [
            'name' => ['min:3', 'required', 'max:30', 'string', 'unique:categories,name,' . $category->id],
            'image' => ['nullable', 'max:1000', 'mimes:jpg,png,jpeg']
        ]);

        if ($request->has('image')) {
            $image = $request->file('image')->store('images/category', 'public');
        } else {
            $image = $category->image;
        }

        $validated['slug'] = Str::slug($request->name) . '-' . uniqid();
        $validated['image'] = $image;
        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Berhasil Diperbarui',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Kategori Berhasil Dihapus',
        ], 200);
    }
}
