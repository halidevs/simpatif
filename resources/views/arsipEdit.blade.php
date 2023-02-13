@extends('layouts.app')

@section('title')
    Edit Berkas ({{ $data->box->nama .' - KK_'. $data->kode_klasifikasi . ' - THN_' . $data->tahun }})
@endsection
@section('upperbutton')
<a href="{{ Route('berkas.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-circle-left fa-sm text-white-50"></i> Kembali
</a>
@endsection
@section('content')
<hr class="divider mb-2" />
<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="embed-responsive-item">
            <iframe width="100%" height="600px" src="{{ asset('storage/berkas/'.$data->filename.'#toolbar=0') }}" class="embed-responsive-item" frameborder="0" style="overflow: hidden"></iframe>
        </div>
        <hr class="divider mb-2">
        <form action="/berkas/{{ $data->id }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-user border-0" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Arsip Ini ?')">
                <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</button>
        </form>
    </div>
    <div class="col-xl-6 col-md-6 mb-4">
        <form class="form" method="POST" action="{{ route('berkas.update', $data->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="box_id">NAMA BOX</label>
                <select class="form-control form-control-user" name="box_id" id="box_id">
                    @foreach ($box as $item)
                        <option value="{{ $item->id }}" 
                            {{ old("box_id") == $item->id ? "selected":"" }}
                            @if ($data->box->id == $item->id)
                                Selected
                            @endif
                            >{{ $item->nama }}</option>
                    @endforeach
                </select>
                @error('box_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="kode_klasifikasi">KODE KLASIFIKASI</label>
                        <input type="text" class="form-control form-control-user" name="kode_klasifikasi" id="kode_klasifikasi" aria-describedby="kode_klasifikasi" value="{{ $data->kode_klasifikasi }}">
                        @error('kode_klasifikasi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="indeks">INDEKS</label>
                        <input type="text" class="form-control form-control-user" name="indeks" id="indeks" aria-describedby="indeks" value="{{ $data->indeks }}">
                        @error('indeks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="tahun">TAHUN</label>
                        <select class="form-control form-control-user" name="tahun">
                            @foreach ($tahun as $item)
                                <option value="{{ $item }}" 
                                {{ old("tahun") == $item ? "selected":"" }}
                                @if ($data->tahun == $item)
                                    selected
                                @endif
                                >{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-group">
                        <label for="volume">VOLUME</label>
                        <input type="text" class="form-control form-control-user" name="volume" id="volume" aria-describedby="volume" value="{{ $data->volume }}">
                        @error('volume')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="uraian">URAIAN</label>
                <textarea class="form-control form-control-user" name="uraian" id="uraian" cols="30" rows="6">{{ $data->uraian }}</textarea>
                @error('uraian')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="keterangan">KETERANGAN</label>
                <textarea class="form-control form-control-user" name="keterangan" id="keterangan" cols="30" rows="4">{{ $data->keterangan }}</textarea>
                @error('keterangan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="filename">Upload Berkas</label>
                <input type="file" class="form-control" accept=".pdf" name="filename" id="filename" aria-describedby="filename" placeholder="Upload Berkas">
                {{-- old value --}}
                <input type="hidden" name="oldberkasfilename" value="{{ $data->filename }}">
            </div>
            <hr class="divider">
            <button type="submit" class="btn btn-primary btn-user btn-block">
                <i class="fas fa-cloud-upload-alt mr-3"></i> Update Berkas
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#box_id').select2();
        });
    </script>
@endsection
