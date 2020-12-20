<div class="card ">
  <div class="list-group">
    @foreach (\App\ForumCategory::withCount('forums as total_forum')->get() as $category)
      <a href="{{ route('forum.index', [
          'filter' => request()->filter,
          'category' => $category->slug,
      ]) }}"
        class="{{ request()->is('forum') && request()->category === $category->slug ? 'active' : '' }} list-group-item list-group-item-action d-flex justify-content-between">
        <span>{{ $category->name }}</span>
        <span>{{ $category->total_forum }}</span>
      </a>
    @endforeach
  </div>
</div>
