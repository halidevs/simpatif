@extends('layouts.app')

@section('title')
    Input Data BOX
@endsection
@section('upperbutton')
<a href="{{ Route('box.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-circle-left fa-sm text-white-50"></i> Kembali
</a>
@endsection
@section('content')
<hr class="divider mb-5" />
<div class="row">
    <div class="col-xl-8 col-md-8 mb-4">
        <form class="form" method="POST" action="{{ route('box.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control form-control-user" name="nama" id="nama" aria-describedby="nama" placeholder="Nama Box . . .">
            </div>
            <hr class="divider">
            <button type="submit" class="btn btn-primary btn-user btn-block">
                <i class="fas fa-plus-square"></i> Tambah Data
            </button>
        </form>
    </div>
</div>

@endsection
