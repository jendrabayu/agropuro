<ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
  @foreach ($forums as $forum)
    <li class="media">
      <img alt="{{ $forum->title }}" class="mr-3 rounded-circle" width="70"
        src="{{ Storage::url($forum->user->photo) }}">
      <div class="media-body">
        <div class="media-right">
          @if ($forum->is_solved)
            <span class="badge badge-success">Solved</span>
          @endif
        </div>
        <div class="media-title">
          <h5>{{ Str::limit($forum->title, 150) }}</h5>
        </div>
        <div class="media-description text-black-50">
          Ditanyakan oleh <span class="font-weight-bold">{{ $forum->user->name }}</span>
          {{ $forum->created_at->diffForHumans() }} <span class="bullet"></span>
          <span><i class="far fa-comments"></i> {{ $forum->forumComments->count() }} Tanggapan</span>
        </div>
        <div class="media-links mt-0">
          <a class="text-primary" href="{{ route('forum.show', $forum->slug) }}">Lihat</a>
          @can('update', $forum)
            <div class="bullet"></div>
            <a href="{{ route('forum.edit', $forum->slug) }}">Ubah</a>
          @endcan
          @can('delete', $forum)
            <div class="bullet"></div>
            <form action="{{ route('forum.destroy', $forum->slug) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn_link text-danger">Hapus</button>
            </form>
          @endcan
        </div>
      </div>
    </li>
  @endforeach
</ul>
