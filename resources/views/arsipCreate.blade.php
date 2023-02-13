@extends('layouts.app')

@section('title')
    Input Berkas
@endsection
@section('upperbutton')
<a href="{{ Route('home') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-circle-left fa-sm text-white-50"></i> Kembali
</a>
@endsection
@section('content')
<hr class="divider mb-2" />
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <form class="form" method="POST" action="{{ route('berkas.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="box_id">NAMA BOX</label>
                <select class="form-control form-control-user" name="box_id" id="box_id">
                    @foreach ($box as $item)
                        <option value="{{ $item->id }}" {{ old("box_id") == $item->id ? "selected":"" }}>{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="kode_klasifikasi">KODE KLASIFIKASI</label>
                        <input type="text" class="form-control form-control-user" name="kode_klasifikasi" id="kode_klasifikasi" aria-describedby="kode_klasifikasi" placeholder="kode_klasifikasi">
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="indeks">INDEKS</label>
                        <input type="text" class="form-control form-control-user" name="indeks" id="indeks" aria-describedby="indeks" placeholder="indeks">
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="tahun">TAHUN</label>
                        <select class="form-control form-control-user" name="tahun">
                            @foreach ($tahun as $item)
                                <option value="{{ $item }}" {{ old("tahun") == $item ? "selected":"" }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="volume">VOLUME</label>
                        <input type="text" class="form-control form-control-user" name="volume" id="volume" aria-describedby="volume" placeholder="volume">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="uraian">URAIAN</label>
                <textarea class="form-control form-control-user" name="uraian" id="uraian" cols="30" rows="6" placeholder="Uraian"></textarea>
            </div>
            <div class="form-group">
                <label for="keterangan">KETERANGAN</label>
                <textarea class="form-control form-control-user" name="keterangan" id="keterangan" cols="30" rows="4" placeholder="keterangan"></textarea>
            </div>
            <div class="form-group">
                <label for="filename">Upload Berkas</label>
                <input type="file" class="form-control" accept=".pdf" name="filename" id="filename" aria-describedby="filename" placeholder="Upload Berkas">
            </div>
            <hr class="divider">
            <button type="submit" class="btn btn-primary btn-user btn-block">
                <i class="fas fa-cloud-upload-alt mr-3"></i> Simpan Berkas
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" defer>
        $(document).ready(function () {
            $('#box_id').select2();
        });
    </script>
@endsection
