@extends('forum.skeleton')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Buat Forum Baru</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('forum.store') }}" method="POST" id="form_create_forum">
        @csrf

        <div class="form-group">
          <label>Judul <code>*</code> </label>
          <input type="text" class="form-control" tabindex="1" name="title" value="{{ old('title') }}">
        </div>

        <div class="form-group">
          <label>Kategori <code>*</code> </label>
          <select class="form-control select2" name="forum_category_id">
            <option selected disabled>--Pilih Kategori--</option>
            @foreach ($categories as $id => $name)
              <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Isi <code>*</code> </label>
          <textarea class="summernote" name="body">{{ old('body') }}</textarea>
        </div>

        <div class="form-group text-right">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
@endsection
