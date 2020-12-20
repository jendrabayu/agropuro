  <div class="card">
    <div class="card-header">
      <h4>{{ $answers->count() }} JAWABAN / {{ $commentsTotal }} KOMENTAR</h4>
      <div class="card-header-action">
        <a data-collapse="#card_answer_collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
      </div>
    </div>
    <div class="card-body pt-0 collapse show" id="card_answer_collapse">
      @if (!$forum->is_solved)
        <div class="mb-5">
          <button data-toggle="collapse" data-target="#add_answer_collapse" aria-expanded="false"
            aria-controls="add_answer_collapse" class="btn btn-outline-primary">Berikan Jawaban</button>
          <form action="{{ route('forum.comment.store', $forum->slug) }}" method="post" class="mt-3 collapse"
            id="add_answer_collapse">
            @csrf
            <input type="hidden" name="is_answer" value="1">
            <div class="form-group mb-2">
              <input type="hidden" name="forum_id" value="{{ $forum->id }}">
              <textarea name="body" class="summernote"></textarea>
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      @endif

      @foreach ($answers as $answer)
        <div class="card">
          <div class="card-body">
            <div class="media">
              <img class="mr-3 rounded-circle" width="60" src="{{ Storage::url($answer->user->photo) }}"
                alt="Generic placeholder image">
              <div class="media-body">
                <p class="mb-0">{!! $answer->body !!}</p>
                <p class="mb-0 text-dark">
                  Dijawab {{ $answer->created_at->diffForHumans() }} oleh <span class="font-weight-bold">
                    {{ $answer->user->name }}</span>
                </p>
                <span>
                  @can('update', $answer)
                    <a href="{{ route('forum.comment.edit', $answer->id) }}">Ubah</a>
                    <div class="bullet"></div>
                  @endcan
                  @can('delete', $answer)
                    <form action="{{ route('forum.comment.destroy', $answer->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn_link text-danger">Hapus</button>
                    </form>
                  @endcan
                </span>

                <div class="card my-3">
                  @foreach ($answer->child as $comment)
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
                              <form action="{{ route('forum.comment.destroy', $comment->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn_link text-danger">Hapus</button>
                              </form>
                            @endcan
                          </span>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
                @if (!$forum->is_solved)
                  <form action="{{ route('forum.comment.store', $forum->slug) }}" method="post" class="mt-5">
                    @csrf
                    <h6 class="text-primary">Beri Komentar</h6>
                    <input type="hidden" name="forum_comment_id" value="{{ $answer->id }}">
                    <div class="form-group">
                      <textarea name="body" rows="3" class="h-100 form-control"></textarea>
                    </div>
                    <div class="form-group text-right">
                      <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
