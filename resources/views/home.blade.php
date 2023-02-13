@extends('layouts.app')

@section('title')
    Dashboard
@endsection
@section('upperbutton')
<a href="{{ route('exportIndex') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-cog fa-sm text-white-50"></i> Generate Report
</a>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <h3 class="text-center my-auto font-weight-bold text-primary">Sistem Informasi Database Ijazah Siswa</h3>
        <h3 class="text-center my-auto font-weight-bold text-primary">Dinas Pendidikan dan Kebudayaan Kabupaten Konawe</h3>
        <hr class="divider" />
    </div>
</div>
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
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            TOTAL BOX </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalbox }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-school fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            TOTAL ARSIP TERSIMPAN</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalarsip }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-copy fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
