@extends('layouts.dashboard')

@section('title', 'Kategori')

@section('content')
  <div class="section-header">
    <h1>Kategori Produk</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Kategori Produk</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Daftar Kategori Produk</h4>
            <div class="card-header-action">
              <button id="btn-add" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus mr-2"></i>Tambah
                Kategori
                Baru</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-striped w-100 text-center table-bordered']) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
@endsection

@section('modal')
  <div class="modal fade" tabindex="-1" role="dialog" id="modal-category" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" id="form-category">
            @csrf
            @method('POST')
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
              <label>Gambar</label>
              <div id="image-preview" class="image-preview">
                <label for="image-upload" id="image-label">Pilih Gambar</label>
                <input type="file" name="image" id="image-upload" />
              </div>

              <div id="img-section" class="mt-3">

              </div>
            </div>

            <div class="form-group text-right">
              <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary" id="btn-submit">Simpan</button>
            </div>
          </form>
        </div>
        <div class="modal-footer bg-whitesmoke br">
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{ $dataTable->scripts() }}
  <script src="{{ asset('assets/modules/upload-preview/js/jquery.uploadPreview.min.js') }}"></script>
@endpush


@push('js')
  <script>
    $(document).ready(function() {
      $.uploadPreview({
        input_field: "#image-upload",
        preview_box: "#image-preview",
        label_field: "#image-label",
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false,
        success_callback: null
      });

      const axios = window.axios;
      axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
      const categoryTable = window.LaravelDataTables["category-table"];
      const categoryForm = $('#form-category');
      const categoryModal = $('#modal-category');

      //delete category
      $('#category-table tbody').on('click', '.btn-delete', function() {
        Swal.fire({
          title: 'Apakah Anda Yakin?',
          text: "Menghapus kategori akan menghapus semua produk yang berkaitan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
        }).then(result => {
          if (result.isConfirmed) {
            showLoading(true);
            axios.delete($(this).data('url'))
              .then(resp => {
                if (resp.data.success) {
                  Swal.fire({
                    icon: 'success',
                    title: resp.data.message,
                    showConfirmButton: false,
                    timer: 1000
                  });
                  categoryTable.ajax.reload();
                }
              })
              .catch(err => {
                Swal.fire({
                  icon: 'error',
                  html: err,
                  confirmButtonColor: '#fc544b'
                });
              });
          }
        });
      });

      $('#btn-add').on('click', function() {
        categoryForm.prop('action', "{{ route('admin.category.store') }}");
        $('input[name=_method]').val('POST');
        $('.modal-title').text('Tambah Kategori Baru');
        categoryModal.modal('toggle');
      });

      $('#category-table tbody').on('click', '.btn-edit', function() {
        let data = categoryTable.row($(this).parents('tr')).data();
        categoryForm.prop('action', $(this).data('url'));
        fillCategoryForm(data);
        $('input[name=_method]').val('PUT');
        $('.modal-title').text('Edit Kategori');
        categoryModal.modal('toggle');
      });

      //save and edit
      $('#btn-submit').on('click', function() {
        let formData = new FormData();
        formData.append('name', $('input[name=name]').val());
        formData.append('_method', $('input[name=_method]').val());
        let imageData = $('input[name=image]').prop('files')[0];
        if (imageData) {
          formData.append('image', imageData);
        }
        categoryModal.modal('toggle');
        showLoading(true);
        axios.post(categoryForm.prop('action'), formData)
          .then(res => {
            if (res.data.message) {
              Swal.fire({
                icon: 'success',
                title: res.data.message,
                showConfirmButton: false,
                timer: 1000
              });
              categoryTable.ajax.reload();
            }
          })
          .catch(err => {
            Swal.fire({
              icon: 'error',
              html: err.response.data.errors ? generateHtmlError(err.response.data.errors) :
                `<p class="text-danger">${error.response.statusText}</p>`,
              confirmButtonColor: '#fc544b'
            });
          });
      });

      categoryModal.on('hide.bs.modal', function() {
        $('input[name=name]').val('');
        $('input[name=image]').val('');
        $('#image-preview').prop('style', '');
        $('#img-section').empty();
      });

      categoryForm.submit(function(e) {
        e.preventDefault()
      });

      function fillCategoryForm(data) {
        $('input[name=name]').val(data.name);
        $('<label></label>', {
          text: 'Gambar Saat Ini'
        }).appendTo('#img-section')

        $('<div></div>', {
          class: 'image-preview'
        }).append(
          $('<img />', {
            class: 'img-fluid',
            src: data.image_path,
          })).appendTo('#img-section');
      }

      function generateHtmlError(errors) {
        const keys = Object.keys(errors);
        let html = '';
        keys.forEach(function(key) {
          errors[key].forEach(function(value) {
            html += `<li class="text-danger">${value}</li>`;
          });
        });
        return $('<ul></ul>', {
          class: 'list-unstyled'
        }).append(html);
      }

      function showLoading(loading) {
        if (typeof loading === 'boolean') {
          if (loading === true) {
            Swal.fire({
              title: 'Tunggu Sebentar...',
              allowOutsideClick: false,
              showConfirmButton: false,
              willOpen: function() {
                Swal.showLoading();
              },
            });
          } else if (loading === false) {
            Swal.close();
          }
        }
      }

    });

  </script>
@endpush
