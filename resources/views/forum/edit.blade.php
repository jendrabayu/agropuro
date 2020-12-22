@extends('forum.skeleton')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Edit Forum</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('forum.update', $forum->slug) }}" method="POST" id="form_create_forum">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label>Judul <code>*</code></label>
          <input type="text" class="form-control" tabindex="1" autofocus name="title" value="{{ $forum->title }}">
        </div>

        <div class="form-group">
          <label>Kategori <code>*</code></label>
          <select class="form-control select2" tabindex="2" name="forum_category_id">
            <option value="" selected disabled>--Pilih Kategori--</option>
            @foreach ($categories as $id => $name)
              <option {{ $id === $forum->forum_category_id ? 'selected' : '' }} value="{{ $id }}">
                {{ $name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Isi <code>*</code></label>
          <textarea class="summernote" tabindex="3" name="body">{{ $forum->body }}</textarea>
        </div>

        <div class="form-group text-right">
          <a href="{{ url()->previous() }}" class="btn btn-warning mr-2">Kembali</a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

      </form>
    </div>
  </div>
@endsection
