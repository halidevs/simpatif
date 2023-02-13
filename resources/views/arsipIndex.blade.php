@extends('layouts.app')

@section('title')
    Data Berkas
@endsection
@section('upperbutton')
<a href="{{ route('berkas.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Tambah Berkas
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
        <table class="table" id="berkasTable">
            <thead>
                <tr>
                    <th>Id Berkas</th>
                    <th>Nama Box (id)</th>
                    <th>kode_klasifikasi</th>
                    <th>Indeks</th>
                    <th>uraian</th>
                    <th>Tahun</th>
                    <th>Volume</th>
                    <th>Keterangan</th>
                    <th>File</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<input type="hidden" id="databerkasUrl" name="databerkasUrl" value="{{ route('databerkas') }}">

<div class="modal fade" id="viewberkas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Berkas</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body embed-responsive-item">
                <iframe width="100%" height="700px" src="#" class="embed-responsive-item" frameborder="0" style="overflow: hidden"></iframe>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                <a class="btn btn-primary" id="downloadberkas" href="#" download>Download</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#berkasTable').DataTable({
                ordering: true,
                serverSide: true,
                processing: true,
                ajax: {
                    'url' : $('#databerkasUrl').val(),
                },
                columns: [
                    {data: 'id', name: 'id', width: '10px', orderable: false, searchable: false},
                    {data: 'box_id', name: 'box_id'},
                    {data: 'kode_klasifikasi', name:'kode_klasifikasi'},
                    {data: 'indeks', name:'indeks', width: '10px'},
                    {data: 'uraian', name:'uraian', orderable: false, searchable: false},
                    {data: 'tahun', name:'tahun'},
                    {data: 'volume', name:'volume', width: '10px'},
                    {data: 'keterangan', name:'keterangan', orderable: false},
                    {data: 'filename', name: 'filename',width: '150px', orderable: false, searchable: false },
                ],
                columnDefs: [],
            });

            $('#viewberkas').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var file = button.data('file')
                var nama = button.data('nama') 
                var modal = $(this)
                modal.find('.modal-title').text('File Berkas : ' + nama)
                modal.find('.modal-body iframe').attr('src', file+'#toolbar=0')
                modal.find('.modal-footer #downloadberkas').attr('href', file)
            })
        });
    </script>
@endsection