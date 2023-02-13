@extends('layouts.app')

@section('title')
    Edit BOX <span class="text-primary text-bold">{{ $box->nama }} ({{ $box->id }})</span>
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
        <form class="form" method="POST" action="{{ route('box.update', $box->id) }}">
            @method('PUT')
            @csrf
            <div class="form-group">
                <input type="text" class="form-control form-control-user" name="nama" id="nama" aria-describedby="nama" value="{{ $box->nama }}">
            </div>
            <hr class="divider">
            <button type="submit" class="btn btn-success btn-user btn-block">
                <i class="fas fa-edit"></i> Edit Data
            </button>
        </form>
    </div>
</div>


@endsection
