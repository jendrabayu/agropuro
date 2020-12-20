<div class="card">
  <div class="card-header">
    <h4>{{ $comments->count() }} KOMENTAR</h4>
    <div class="card-header-action">
      <a data-collapse="#card_comment_collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
    </div>
  </div>
  <div class="card-body pt-0 collapse show" id="card_comment_collapse">
    <ul class="list-group">
      @foreach ($comments as $comment)
        <li class="card">
          <div class="card-body">
            <div class="media">
              <img class="mr-3 rounded-circle" width="60" src="{{ Storage::url($comment->user->photo) }}"
                alt="Generic placeholder image">
              <div class="media-body">
                <p class="mb-0">{{ $comment->body }}</p>
                <p class="mb-0 text-dark">
                  Dikomentari {{ $comment->created_at->diffForHumans() }} oleh <span class="font-weight-bold">
                    {{ $comment->user->name }}</span>
                </p>
                <span>
                  @can('update', $comment)
                    <a href="{{ route('forum.comment.edit', $comment->id) }}">Ubah</a>
                    <div class="bullet"></div>
                  @endcan
                  @can('delete', $comment)
                    <form action="{{ route('forum.comment.destroy', $comment->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn_link text-danger">Hapus</button>
                    </form>
                  @endcan
                </span>
              </div>
            </div>
          </div>
        </li>
      @endforeach
    </ul>

    @if (!$forum->is_solved)
      <div class="mt-3">
        <button data-toggle="collapse" data-target="#add_comment_collapse" aria-expanded="false"
          aria-controls="add_comment_collapse" class="btn btn-outline-primary">Buat Komentar</button>
        <form action="{{ route('forum.comment.store', $forum->slug) }}" method="post" class="mt-3 collapse"
          id="add_comment_collapse">
          @csrf
          <div class="form-group mb-2">
            <input type="hidden" name="forum_id" value="{{ $forum->id }}">
            <textarea name="body" rows="2" class="form-control h-100"></textarea>
          </div>
          <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
          </div>
        </form>
      </div>
    @endif
  </div>
</div>
