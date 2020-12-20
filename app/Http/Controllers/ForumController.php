<?php

namespace App\Http\Controllers;

use App\Forum;
use App\ForumCategory;
use App\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $forums = Forum::query();
    $contentTitle = '<h4>Semua Forum</h4>';

    if ($request->has('filter')) {
      switch ($request->get('filter')) {
        case 'my':
          if (!auth()->check())  return  redirect()->route('login');
          $forums->where('user_id', auth()->id());
          $contentTitle = '<h4>Forum Saya</h4>';
          break;

        case 'emptyanswer':
          $forums->where('is_solved', false)->withCount(['forumComments' => function ($q) {
            $q->where('is_answer', true);
          }])->having('forum_comments_count', '=', 0);
          $contentTitle = '<h4>Belum Ada Jawaban</h4>';
          break;

        case 'popular':
          $forums->withCount('forumComments')->orderByDesc('forum_comments_count');
          $contentTitle = '<h4>Terpopuler</h4>';
          break;

        case 'solved':
          $forums->where('is_solved', true);
          $contentTitle = '<h4>Terjawab</h4>';
          break;

        default:
          abort(404, 'Forum Tidak Ditemukan');
          break;
      }
    }

    if ($request->has('category')) {
      $categoryName = ForumCategory::where('slug', $request->category)->firstOrFail()->name;
      $contentTitle = $contentTitle . '<p class="text-dark m-0"> Kategori: ' . $categoryName . '</p>';
      $forums->whereHas('forumCategory', function ($q) use ($request) {
        $q->where('slug', $request->get('category'));
      });
    }

    $forums = $forums->latest()->paginate(5);
    return view('forum.index', compact('forums', 'contentTitle'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('forum.create', [
      'categories' => ForumCategory::all()->pluck('name', 'id')
    ]);
  }

  /**
   * Store a newly created resource in storage.
   * 
   * @param \Illuminate\Http\Request
   * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $validated = $this->validate($request, [
      'title' => ['required', 'min:5', 'max:255', 'string'],
      'body' => ['required', 'string'],
      'forum_category_id' => ['required', 'integer', 'exists:forum_categories,id']
    ], [], [
      'title' => 'judul',
      'body' => 'isi',
      'forum_category_id' => 'kategori'
    ]);

    $validated['user_id'] = auth()->id();
    $validated['slug'] = Str::slug($request->title . uniqid() . (Forum::query()->latest()->first()->id + 1));

    $forum = Forum::create($validated);

    return redirect()->route('forum.show', $forum->slug)->with('info', 'Berhasil Membuat Forum Baru');
  }

  /**
   * Display the specified resource.
   * 
   * @param App\Forum $forum
   * @return \Illuminate\View\View
   */
  public function show(Forum $forum)
  {

    $comments = $forum->forumComments()->where('is_answer', false)->whereNull('forum_comment_id')->get();
    $answers = $forum->forumComments()->where('is_answer', true)->get();
    $commentsTotal = $forum->forumComments()->whereNotNull('forum_comment_id')->count();

    return view('forum.show', compact('forum', 'comments', 'answers', 'commentsTotal'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Forum $forum)
  {
    $this->authorize('update', $forum);

    $categories = ForumCategory::all()->pluck('name', 'id');
    return view('forum.edit', compact('categories', 'forum'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Forum  $forum
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Forum $forum)
  {
    $this->authorize('update', $forum);

    $validated = $this->validate($request, [
      'title' => ['required', 'min:5', 'max:200', 'string'],
      'body' => ['required', 'string'],
      'forum_category_id' => ['required', 'integer', 'exists:forum_categories,id']
    ], [], [
      'title' => 'judul',
      'body' => 'isi',
      'forum_category_id' => 'kategori'
    ]);

    $validated['user_id'] = auth()->id();
    $validated['slug'] = Str::slug($request->title . uniqid() . (Forum::query()->latest()->first()->id + 1));

    return redirect()->route('forum.show', $forum->slug)->with('info', 'Forum Anda Berhasil Diperbarui');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Forum $forum
   * @return \Illuminate\Http\Response
   */
  public function destroy(Forum $forum)
  {
    $this->authorize('delete', $forum);

    $forum->delete();
    return redirect()->route('forum.index')->with('info', 'Forum Anda Berhasil Dihapus');
  }

  /**
   * Update the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Forum  $forum
   * @return \Illuminate\Http\Response
   */
  public function solved(Request $request, Forum $forum)
  {
    $this->authorize('solved', $forum);

    $request->validate(['is_solved' => ['required', 'boolean']]);
    $forum->update($request->all());

    return back()->with('info', $forum->is_solved ? 'Sudah Menemukan Jawaban' : 'Forum Dibuka Kembali');
  }
}
