@extends('layouts.app')

@section('title')
    Edit User Administrator
@endsection
@section('upperbutton')
<a href="{{ Route('home') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-circle-left fa-sm text-white-50"></i> Kembali
</a>
@endsection
@section('content')
<hr class="divider mb-5" />
<div class="row">
    <div class="col-xl-8 col-md-8 mb-4">
        <form class="form" method="POST" action="{{ route('admin.update', $data->id) }}">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">Nama Admin</label>
                <input type="text" class="form-control form-control-user" name="name" id="name" aria-describedby="name" value="{{ $data->name }}">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control form-control-user" name="username" id="username" aria-describedby="username" value="{{ $data->username }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control form-control-user" name="email" id="email" aria-describedby="email" value="{{ $data->email }}">
            </div>
            <div class="form-group">
                <label for="status">Role Admin</label>
                <select class="form-control form-control-user" name="status" id="status">
                    <option value="admin" 
                        @if ($data->status == 'admin')
                            selected
                        @endif
                    >Admin</option>
                    <option value="superadmin" 
                        @if ($data->status == 'superadmin')
                            selected
                        @endif
                    >Superadmin</option>
                    <option value="supervisor"
                        @if ($data->status == 'supervisor')
                            selected
                        @endif
                    >Supervisor (Kepala Dinas)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Pasword</label>
                <input type="password" class="form-control form-control-user" name="password" id="password"  value="{{ $data->password }}">
            </div>
            <hr class="divider">
            <button type="submit" class="btn btn-primary btn-user btn-block">
                <i class="fas fa-plus-square"></i> Tambah Admin
            </button>
        </form>
    </div>
</div>

@endsection
