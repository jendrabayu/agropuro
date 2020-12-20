{{ $nama }}
<br>
@if ($stok === 0)
  <span class="badge badge-danger py-1 px-2">Stok Habis</span>
@endif

@if ($diarsipkan === true)
  <span class="badge badge-dark py-1 px-2">Diarsipkan</span>
@endif
