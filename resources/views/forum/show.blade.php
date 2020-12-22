@extends('forum.skeleton')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="media border-bottom pb-3 mb-3">
            <img alt="image" class="mr-3 rounded-circle" width="70" src="{{ Storage::url($forum->user->photo) }}">
            <div class="media-body">
              <div class="media-right">
                @if ($forum->is_solved)
                  <span class="badge badge-success">Solved</span>
                @endif
              </div>
              <div class="media-title mb-1">
                <h4>{{ $forum->title }}</h4>
              </div>
              <div class="media-description text-muted mb-1">
                Ditanyakan {{ $forum->created_at->diffForHumans() }} oleh <span
                  class="font-weight-bold">{{ $forum->user->name }}</span>
              </div>
              <div class="forum_action_container">
                @can('update', $forum)
                  <a href="{{ route('forum.edit', $forum->slug) }}"
                    class="btn btn-icon icon-left btn-sm btn-outline-success rounded-pill">
                    <i class="fas fa-edit"></i>
                    Edit</a>
                @endcan

                @can('delete', $forum)
                  <a href="javascript:;" id="btn_delete_forum"
                    class="btn btn-icon icon-left btn-sm btn-outline-success rounded-pill">
                    <i class="fas fa-trash"></i>Hapus</a>
                @endcan

                @can('update', $forum)
                  <a href="javascript:;" id="btn_set_solved_forum"
                    class="btn btn-icon icon-left btn-sm btn-outline-success rounded-pill">
                    <i class="fa {{ $forum->is_solved === true ? 'fa-times' : 'fa-check' }} "></i>
                    {{ $forum->is_solved === true ? 'Buka Kembali' : 'Tandai Selesai' }}
                  </a>
                @endcan
              </div>
            </div>
          </div>
          <div class="forum_content">
            {!! $forum->body !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      @include('forum.sections.comments')
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      @include('forum.sections.answer')
    </div>
  </div>

  <form action="{{ route('forum.solved', $forum->slug) }}" method="POST" id="form_set_solved_forum" hidden>
    @csrf @method('PUT')
    <input type="hidden" name="is_solved" value="{{ $forum->is_solved === true ? 0 : 1 }}">
  </form>

  <form action="{{ route('forum.destroy', $forum->slug) }}" method="POST" id="form_delete_forum" hidden>
    @csrf @method('DELETE')
  </form>
@endsection

@push('js')
  <script>
    $(function() {
      $('#btn_delete_forum').click(function() {
        $('#form_delete_forum').submit();
      });

      $('#btn_set_solved_forum').click(function() {
        $('#form_set_solved_forum').submit();
      });
    })

  </script>
@endpush
