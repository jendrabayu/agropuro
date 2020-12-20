@extends('forum.skeleton')

@section('section_header')
  <h1>Forum</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="{{ route('forum.index') }}">Forum</a>
    </div>
    <div class="breadcrumb-item">Edit {{ $comment->is_answer ? 'Jawaban' : 'Komentar' }}</div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Edit {{ $comment->is_answer ? 'Jawaban' : 'Komentar' }}</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('forum.comment.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="">Isi</label>
          @if ($comment->is_answer)
            <textarea class="summernote" name="body">{{ $comment->body }}</textarea>
          @else
            <textarea name="body" class="h-100 form-control" rows="10">{{ $comment->body }}</textarea>
          @endif
        </div>

        <div class="form-group text-right">
          <a href="{{ url()->previous() }}" class="btn btn-warning mr-1">Kembali</a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

      </form>
    </div>
  </div>
@endsection
