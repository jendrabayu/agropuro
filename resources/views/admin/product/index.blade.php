@extends('layouts.dashboard')

@section('title', 'Produk')

@section('content')
  <div class="section-header">
    <h1>Produk</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Produk</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Produk</h4>
            <div class="card-header-action">
              <a href="{{ route('admin.product.create') }}" class="btn btn-icon icon-left btn-primary"><i
                  class="fa fa-plus mr-2"></i>Tambah Produk Baru</a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100']) }}
              </div>
            </div>
          </div>
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
    $(document).ready(function() {
      const axios = window.axios;
      axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
      const productTable = window.LaravelDataTables["product-table"];

      $('#product-table tbody').on('click', '.btn-archived', function(e) {
        e.preventDefault();
        showLoading(true);
        axios.post($(this).data('url'), {
            diarsipkan: true,
            _method: 'PUT'
          })
          .then(response => {
            if (response.data.success) {
              Swal.fire({
                icon: 'success',
                title: response.data.message,
                showConfirmButton: false,
                timer: 1000
              })
              productTable.ajax.reload();
            }
          })
          .catch(error => {
            Swal.fire({
              icon: 'error',
              title: error,
              timer: 1000
            })
          });
      });

      $('#product-table tbody').on('click', '.btn-unarchived', function(e) {
        e.preventDefault();
        showLoading(true);
        axios.post($(this).data('url'), {
            diarsipkan: false,
            _method: 'PUT'
          })
          .then(response => {
            if (response.data.success) {
              Swal.fire({
                icon: 'success',
                title: response.data.message,
                showConfirmButton: false,
                timer: 1000
              })
              productTable.ajax.reload();
            }
          })
          .catch(error => {
            Swal.fire({
              icon: 'error',
              title: error,
              timer: 1000
            })
          });
      });

      $('#product-table tbody').on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const data = productTable.row($(this).parents('tr')).data();
        Swal.fire({
          icon: 'warning',
          title: 'Hapus Produk?',
          text: `Produk dengan nama ${data.nama} akan dihapus!`,
          confirmButtonText: 'Hapus',
          confirmButtonColor: 'red',
          cancelButtonText: 'Batal',
          showCancelButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            showLoading(true);
            axios.delete($(this).data('url'))
              .then(response => {
                Swal.fire({
                  icon: 'success',
                  title: response.data.message,
                  showConfirmButton: false,
                  timer: 1000
                })
                productTable.ajax.reload();
              })
              .catch(error => {
                Swal.fire({
                  icon: 'error',
                  title: error,
                  timer: 1000
                });
              });
          }
        })
      });

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
