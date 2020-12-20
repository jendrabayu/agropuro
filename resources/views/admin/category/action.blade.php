<div class="btn-group mb-3" role="group" aria-label="Basic example">
  <button data-url="{{ route('admin.category.update', $id) }}" type="button" class="btn btn-info btn-edit">Edit</button>
  <button data-url="{{ route('admin.category.destroy', $id) }}" type="button"
    class="btn btn-danger btn-delete">Hapus</button>
</div>
