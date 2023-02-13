@extends('layouts.app')

@section('title')
    Box Data
@endsection
@section('upperbutton')
<a href="{{ route('box.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Tambah Data
</a>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success !!! </strong> | {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <hr class="divider mb-5" />
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Box</th>
                    <th>Jumlah Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<input type="hidden" id="databoxUrl" name="databoxUrl" value="{{ route('databox') }}">
@endsection

@section('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#table').DataTable({
                ordering: true,
                serverSide: true,
                processing: true,
                ajax: {
                    'url' :  $('#databoxUrl').val(),
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false},
                    {data: 'nama', name:'nama', orderable: false,},
                    {data: 'arsip', name: 'arsip', orderable: false, searchable: false },
                    {data: 'Action', name:'Action', orderable: false, searchable: false},
                ],
                columnDefs: []
            });
        });
    </script>
@endsection