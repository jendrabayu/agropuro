   <div class="btn-group mb-3" role="group" aria-label="Basic example">
     <button type="button" data-url="{{ route('admin.forum-category.update', $id) }}"
       class="btn btn-info btn_edit">Edit</button>
     <button type="button" data-url="{{ route('admin.forum-category.destroy', $id) }}"
       class="btn btn-danger btn_delete">Hapus</button>
   </div>
