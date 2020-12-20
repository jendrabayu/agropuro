<div class="btn-group mb-3" role="group" aria-label="Basic example">
  <a href="{{ route('admin.product.edit', $id) }}" type="button" class="btn btn-info btn-edit">Edit</a>
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
    aria-haspopup="true" aria-expanded="false">
    Lainnya
  </button>
  <div class="dropdown-menu">
    @if ($diarsipkan === false && $stok > 0)
      <a href="{{ route('product.show', [$id, $slug]) }}" class="dropdown-item" target="_blank">Tampilan Produk</a>
    @endif
    @if ($diarsipkan === true)
      <a href="#" class="dropdown-item btn-unarchived"
        data-url="{{ route('admin.product.set_archived', $id) }}">Tampilkan</a>
    @endif
    @if ($diarsipkan === false)
      <a href="#" class="dropdown-item btn-archived"
        data-url="{{ route('admin.product.set_archived', $id) }}">Arsipkan</a>
    @endif
    <a href="#" class="dropdown-item btn-delete" data-url="{{ route('admin.product.destroy', $id) }}">Hapus</a>
  </div>
</div>
