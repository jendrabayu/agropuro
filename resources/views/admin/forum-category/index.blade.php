@extends('layouts.dashboard')

@section('content')
  <section class="section-header">
    <h1>Kategori</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.forum-category.index') }}">Forum</a>
      </div>
      <div class="breadcrumb-item">Kategori Forum</div>
    </div>
  </section>

  <section class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Kategori Forum</h4>
            <div class="card-header-action">
              <button id="btn_add" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus mr-2"></i>Tambah
                Kategori Forum
                Baru</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              {{ $dataTable->table(['class' => 'table table-striped w-100 text-center table-bordered']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


@section('modal')
  <div class="modal fade" data-backdrop="static" id="modal_category" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="form_category">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{ $dataTable->scripts() }}
@endpush

@push('js')
  <script>
    $(document).ready(() => {

      const modalCategory = $('#modal_category');
      const formCategory = $('#modal_category #form_category');
      const modalTitle = $('#modal_category .modal-title');
      const tableCategory = window.LaravelDataTables["forum-category-table"];
      const axios = window.axios;
      axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

      $('#btn_add').click(() => {
        formCategory.prop('action', "{{ route('admin.forum-category.store') }}");
        formCategory.prop('method', 'POST');
        modalTitle.text('Tambah Kategori Forum Baru');
        modalCategory.modal('show');
      });

      $('#forum-category-table tbody').on('click', '.btn_edit', function() {
        const data = tableCategory.row($(this).parents('tr')).data();
        $('#modal_category #form_category input[name=name]').val(data.name)
        formCategory.prop('action', $(this).data('url'));
        formCategory.prop('method', 'PUT');
        modalTitle.text('Edit Kategori Forum');
        modalCategory.modal('show');
      });

      $('#forum-category-table tbody').on('click', '.btn_delete', function() {
        const data = tableCategory.row($(this).parents('tr')).data();
        Swal.fire({
          titleText: 'Hapus Forum Kategori?',
          icon: 'warning',
          text: 'Forum Kategori yang dihapus tidak bisa dikembalikan!',
          showCancelButton: true,
          cancelButtonText: 'Batal',
          confirmButtonText: 'Hapus',
          confirmButtonColor: 'red',
        }).then(result => {
          if (result.isConfirmed) {
            showLoading(true);
            axios.delete($(this).data('url'))
              .then(response => {
                const data = response.data;
                if (data.success) {
                  Swal.fire({
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1000
                  });
                  tableCategory.ajax.reload();
                }
              })
              .catch(error => {
                Swal.fire({
                  icon: 'error',
                  html: `<p class="text-danger">${error.response.statusText}</p>`,
                  confirmButtonColor: '#fc544b'
                });
              })
          }
        });
      });

      formCategory.submit(function(e) {
        e.preventDefault();
        const config = {
          data: {
            name: $('#modal_category #form_category input[name=name]').val()
          },
          method: $(this).attr('method'),
          url: $(this).attr('action')
        };
        modalCategory.modal('hide');
        showLoading(true);
        axios(config)
          .then(response => {
            const data = response.data;
            console.log(data);
            if (data.success) {
              Swal.fire({
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 1000
              });
              tableCategory.ajax.reload();
            }
          })
          .catch(error => {
            const errors = error.response.data.errors;
            Swal.fire({
              icon: 'error',
              html: errors ? generateHtmlError(errors) :
                `<p class="text-danger">${error.response.statusText}</p>`,
              confirmButtonColor: '#fc544b'
            });
          });
      });


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

      $('#modal_category').on('hidden.bs.modal', e => {
        $('#modal_category #form_category input[name=name]').val('')
      })

    });

  </script>
@endpush
