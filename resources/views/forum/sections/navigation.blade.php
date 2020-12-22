<div class="card">
  <div class="list-group">
    <a href="{{ route('forum.create') }}"
      class="{{ set_active('forum/create') }} list-group-item list-group-item-action d-flex justify-content-between">
      <span>Buat Forum Baru</span>
      <span><i class="fas fa-plus"></i></span>
    </a>
    <a href="{{ route('forum.index', ['filter' => 'my']) }}"
      class="{{ request()->filter === 'my' ? 'active' : '' }} list-group-item list-group-item-action d-flex justify-content-between"><span>Forum
        Saya</span><span>
        <i class="fas fa-comment"></i></span> </a>

    <a href="{{ route('forum.index') }}"
      class="{{ request()->is('forum') && is_null(request()->filter) && is_null(request()->q) ? 'active' : '' }} list-group-item list-group-item-action d-flex justify-content-between"><span>Semua
        Forum</span>
      <span> <i class="fas fa-comments"></i></span>
    </a>
    <a href="{{ route('forum.index', ['filter' => 'popular']) }}"
      class="{{ request()->is('forum') && request()->filter === 'popular' ? 'active' : '' }} list-group-item list-group-item-action d-flex justify-content-between"><span>Forum
        Terpopuler</span><span><i class="fas fa-fire"></i></span> </a>

    <a href="{{ route('forum.index', ['filter' => 'emptyanswer']) }}"
      class="{{ request()->filter === 'emptyanswer' ? 'active' : '' }} list-group-item list-group-item-action d-flex justify-content-between"><span>
        Belum Ada Jawaban</span> <span><i class="fas fa-comment-dots"></i></span> </a>

    <a href="{{ route('forum.index', ['filter' => 'solved']) }}"
      class="{{ request()->filter === 'solved' ? 'active' : '' }} list-group-item list-group-item-action d-flex justify-content-between"><span>
        Terjawab</span> <span><i class="fas fa-check"></i></span> </a>
  </div>
</div>
