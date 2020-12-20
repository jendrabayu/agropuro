@extends('layouts.dashboard')

@section('title', 'Rekening Bank')

@section('content')
  <div class="section-header">
    <h1>Rekening Bank</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Rekening Bank</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        @include('includes.bs-alert')
        <div class="card card-primary">
          <div class="card-header">
            <h4>Rekening Bank</h4>
            <div class="card-header-action">
              <button id="btn-add" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus mr-2"></i>Tambah
                Rekening Baru</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              {{ $dataTable->table(['class' => 'table table-striped w-100 text-center table-bordered ']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
  <div class="modal fade" tabindex="-1" role="dialog" id="rekening-modal" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="rekening-form">
            @method('POST')
            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" class="form-control" name="nama_bank">
            </div>
            <div class="form-group">
              <label>Atas Nama</label>
              <input type="text" class="form-control" name="atas_nama">
            </div>
            <div class="form-group">
              <label>Nomor Rekening</label>
              <input type="text" class="form-control" name="no_rekening">
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{ $dataTable->scripts() }}

  <script>
    $(document).ready(function() {
      const axios = window.axios;
      axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
      const rekeningTable = window.LaravelDataTables["bankaccount-table"];
      const rekeningModal = $('#rekening-modal');
      const rekeningForm = $('#rekening-form');

      $('#btn-add').on('click', function() {
        $('.modal-title').text('Tambah Rekening Toko Baru');
        rekeningForm.prop('action', "{{ route('admin.bank-account.store') }}");
        $('input[name=_method]').val('POST');
        rekeningModal.modal('toggle');
      });


      $('#bankaccount-table tbody').on('click', '.btn-edit', function() {
        let data = rekeningTable.row($(this).parents('tr')).data();
        $('input[name=nama_bank]').val(data.nama_bank);
        $('input[name=atas_nama]').val(data.atas_nama);
        $('input[name=no_rekening]').val(data.no_rekening);
        $('.modal-title').text('Edit Rekening')
        $('input[name=_method]').val('PUT');
        rekeningForm.prop('action', $(this).data('url'));
        rekeningModal.modal('toggle');
      });

      rekeningForm.submit(function(e) {
        e.preventDefault();
        const data = {
          nama_bank: $('input[name=nama_bank]').val(),
          atas_nama: $('input[name=atas_nama]').val(),
          no_rekening: $('input[name=no_rekening]').val(),
          _method: $('input[name=_method]').val()
        };
        rekeningModal.modal('toggle');
        showLoading(true);
        axios.post(rekeningForm.prop('action'), data)
          .then(res => {
            if (res.data.message) {
              Swal.fire({
                icon: 'success',
                title: res.data.message,
                showConfirmButton: false,
                timer: 1000
              });
              rekeningTable.ajax.reload();
            }
          })
          .catch(err => {
            Swal.fire({
              icon: 'error',
              html: err.response.data.errors ? generateHtmlError(err.response.data.errors) :
                `<p class="text-danger">${err.response.statusText}</p>`,
              confirmButtonColor: '#fc544b'
            });
          })
      });


      $('#bankaccount-table tbody').on('click', '.btn-delete', function() {
        Swal.fire({
          title: 'Apakah Anda Yakin?',
          text: "Menhapus Rekening!",
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
                  rekeningTable.ajax.reload();
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


      $('#rekening-modal').on('hide.bs.modal', function() {
        $('#rekening-form input[name=nama_bank]').val('');
        $('#rekening-form input[name=atas_nama]').val('');
        $('#rekening-form input[name=no_rekening]').val('');
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
    });

  </script>
@endpush
