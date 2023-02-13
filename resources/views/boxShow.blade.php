@extends('layouts.app')

@section('title')
    Detail Arsip Vital Box {{ $box->id }} ({{ $box->nama }})
@endsection
@section('upperbutton')
<a href="{{ Route('box.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-circle-left fa-sm text-white-50"></i> Kembali
</a>
@endsection
@section('content')
<hr class="divider mb-5" />
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <table class="table" id="boxBerkasTable">
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
<input type="hidden" id="databoxUrl" name="databoxUrl" value="{{ route('databoxDetail', $box->id) }}">

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
            $('#boxBerkasTable').DataTable({
                ordering: true,
                serverSide: true,
                processing: true,
                ajax: {
                    'url' : $('#databoxUrl').val(),
                },
                columns: [
                    {data: 'id', name: 'id', width: '10px', orderable: false, searchable: false},
                    {data: 'box_id', name: 'box_id', orderable: false, searchable: false },
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