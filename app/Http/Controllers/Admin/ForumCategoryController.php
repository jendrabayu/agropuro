<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ForumCategoryDataTable;
use App\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;

class ForumCategoryController extends Controller
{
    /**
     * 
     * @param \App\DataTables\Admin\ForumCategoryDataTable $forumCategoryDataTable
     */
    public function index(ForumCategoryDataTable $forumCategoryDataTable)
    {
        return $forumCategoryDataTable->render('admin.forum-category.index');
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $validated =  $this->validate($request, ['name' => ['required', 'unique:forum_categories', 'max:50']]);
        $validated['slug'] = Str::slug($request->name);

        ForumCategory::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menambahkan Kategori Baru',
        ], 201);
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     */
    public function update(Request $request, $id)
    {
        $forumCategory = ForumCategory::query()->findOrFail($id);

        $validated = $this->validate($request, ['name' => ['required', 'unique:forum_categories,name,' . $forumCategory->id, 'max:30']]);
        $validated['slug'] = Str::slug($request->name);

        $forumCategory->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Berhasil Diperbarui',
        ], 200);
    }


    /**
     * 
     * @param int $id
     */
    public function destroy($id)
    {
        $forumCategory = ForumCategory::query()->findOrFail($id);
        $forumCategory->delete();
        return response()->json([
            'success' => true,
            'message' => 'Kategori Berhasil Dihapus',
        ], 200);
    }
}
