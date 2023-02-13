@extends('layouts.app')

@section('title')
    Generate & Export Arsip Data
@endsection
@section('upperbutton')
<a href="{{ route('home') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-hand-point-left fa-sm text-white-50"></i> Back To Dashboard
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
<hr class="divider mb-4" />
<div class="row justify-content-center">
        <div class="col-xl-8 col-md-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Report Generator</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('exportFilter') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-xl-3 col-md-3">
                                <label for="inputState">Dari Tahun</label>
                                <select id="inputState" class="form-control" name="from">
                                    <option selected value="0">Pilih tahun...</option>
                                    @foreach ($year as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xl-3 col-md-3">
                                <label for="tahunto">Sampai Tahun</label>
                                <select id="tahunto" class="form-control" name="to">
                                    <option value="0" selected>Pilih Tahun...</option>
                                    {{-- @foreach ($year as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group col-xl-3 col-md-3">
                                <label for="dokumen">Tipe Dokumen</label>
                                <select id="dokumen" class="form-control" name="dokumen">
                                    <option value="xlsx" selected>Pilih Tipe Dokumen . . .</option>
                                    @foreach ($export as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xl-3 col-md-3">
                                <label for="generate">Generate</label>
                                <button type="submit" id="generate" class="btn btn-block btn-primary"> <i class="fas fa-cogs mr-2"></i> Generate Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

@endsection

@section('scripts')
    <script type="module">
        $(document).ready(function () {
            $('select[name=from]').change(function() { 
                $('#tahunto').html('<option value="0" selected >Pilih tahun . . .</option>')
                var now = new Date().getFullYear()
                var before = $('select[name=from]').val()
                var tahunselanjutnya = []
                for (let i = now; i >= before; i--) {
                    tahunselanjutnya.push(i);
                }
                tahunselanjutnya.forEach(element => {
                    $('#tahunto').append('<option value="'+ element +'">'+element+'</option>')
                });
                
            });
        });
    </script>
@endsection