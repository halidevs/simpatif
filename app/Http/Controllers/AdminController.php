<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (auth()->user()->status != 'superadmin' ){
            abort(403);
        }
        $data = User::all();
        // dd($data);
        if($request->ajax()){
            // $query = User::orderBy('id', 'asc');
            return DataTables::of($data)
                                ->addIndexColumn()
                                ->addColumn('Nama', function($data){
                                    return $data->name;
                                })
                                ->addColumn('Email', function($data){
                                    return $data->email;
                                })
                                ->addColumn('Username', function($data){
                                    return $data->username;
                                })
                                ->addColumn('Role', function($data){
                                    return $data->status;
                                })
                                ->addColumn('Action', function($data){
                                    return '<a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="/admin/'.$data->id.'/edit"><i class="fas fa-pen-square fa-sm text-white-50"></i> Edit</a> | <form action="/admin/'.$data->id.'/delete" method="post" class="d-inline"> '.method_field("delete").' '. csrf_field() .' <button type="submit" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm border-0" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus User Dengan Nama '.$data->name.' ?\')"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</button></form>';
                                })
                                ->rawColumns(['Action'])
                                ->make(true);
        }

        $data = User::all();
        return view('adminIndex', [
            'data' => $data,
        ]);
    }

    public function create()
    {
        if (auth()->user()->status != 'superadmin'){
            abort(403);
        }
        return view('adminCreate');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:admin,superadmin,supervisor',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
		]);
        
        $admin = new User;
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->status = $request->status;
        
        $admin->save();
        return redirect()->route('admin.index')->with('success', 'User Admin Baru Telah Dibuat !!');
    }

    public function edit($admin)
    {
        $admin = User::findOrFail($admin);
        $isSuperadmin = auth()->user()->status;
        switch ($isSuperadmin) {
            case 'superadmin':
                return view('adminEdit', [
                    'data' => $admin,
                ]);
                break;
            case 'admin':
                if(auth()->user()->id != $admin->id){
                    abort(403);
                }else{
                    return view('adminEdit', [
                        'data' => $admin,
                    ]);
                }
                break;
            case 'supervisor':
                if(auth()->user()->id != $admin->id){
                    abort(403);
                }else{
                    return view('adminEdit', [
                        'data' => $admin,
                    ]);
                }
                break;
            default:
                return view('adminEdit', [
                    'data' => $admin,
                ]);
                break;
        }
    }

    public function update(Request $request, $admin)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:admin,superadmin,supervisor',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
		]);
        $newpass = Hash::make($request->password);

        $admin = User::findOrFail($admin);
        // dd($admin->password);
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->status = $request->status;

        if($admin->password != $newpass){
            $admin->password = $newpass;
        }
        $admin->save();
        return redirect()->route('admin.index')->with('success', 'Data User Admin Berhasil Di Update !!');
    }

    public function destroy($admin)
    {
        $admin = User::findOrFail($admin);
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'User Admin Berhasil Di Hapus !!!');
    }

}
