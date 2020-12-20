<?php

namespace App\Http\Controllers;

use App\Forum;
use App\ForumComment;
use Illuminate\Http\Request;

class ForumCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Forum $forum
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Forum $forum)
    {
        $this->authorize('create', ForumComment::class);

        $validated = $this->validate($request, [
            'body' => ['required', 'string', 'min:5'],
            'is_answer' => ['nullable', 'boolean'],
            'forum_comment_id' => ['nullable', 'integer', 'exists:forum_comments,id']
        ], [], [
            'body' => $request->forum_comment_id ? 'isi jawaban' : 'isi komentar'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['forum_id'] = $forum->id;

        $comment = ForumComment::create($validated);
        return back()->with('info', 'Berhasil Menambahkan ' . ($comment->is_answer ? 'Jawaban' : 'Komentar'));
    }

    public function edit(ForumComment $forumComment)
    {
        $this->authorize('update', $forumComment);

        return view('forum.edit-comment', [
            'comment' => $forumComment,
        ]);
    }

    public function update(Request $request, ForumComment $forumComment)
    {
        $this->authorize('update', $forumComment);

        $request->validate([
            'body' => ['required', 'string', 'min:5'],
        ]);

        $forumComment->update($request->all());
        return redirect()->route('forum.show', $forumComment->forum->slug)->with('info', ($forumComment->is_answer ? 'Jawaban' : 'Komentar') . ' Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumComment $forumComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumComment $forumComment)
    {
        $this->authorize('delete', $forumComment);

        $forumComment->delete();
        return back()->with('info', ($forumComment->is_answer ? 'Jawaban' : 'Komentar') . ' Berhasil Dihapus');
    }
}
