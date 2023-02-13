<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;
use DataTables;

class BoxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (auth()->user()->status != 'superadmin'){
            abort(403);
        }
        return view('boxIndex');
    }

    public function create()
    {
        if (auth()->user()->status != 'superadmin'){
            abort(403);
        }
        return view('boxCreate');
    }

    public function store(Request $request)
    {
        Box::create($request->except('_token', 'submit'));
        return redirect()->route('box.index')->with("success", "Data Box Baru Berhasil di Input");
    }

    public function show(Box $box)
    {
        if (auth()->user()->status != 'superadmin'){
            abort(403);
        }
        return view('boxShow', [
            'box' => $box,
        ]);

    }

    public function edit(Box $box)
    {
        if (auth()->user()->status != 'superadmin'){
            abort(403);
        }
        return view('boxEdit', [
            'box' => $box,
        ]);
    }

    public function update(Request $request, Box $box)
    {
        $box = Box::findOrFail($box->id);
        $box->nama = $request->nama;
        $box->save();
        return redirect()->route('box.index')->with('success', 'Data Box Berhasil Di Update !');
    }

    public function destroy(Box $box)
    {
        $box = Box::findOrFail($box->id);
        $box->delete();
        return redirect()->route('box.index')->with('success', 'Data Berhasil di Hapus !!');
    }

    public function Databox()
    {
        $query = Box::orderBy('id', 'asc');
        return DataTables::of($query)
                            ->addIndexColumn()
                            ->addColumn('arsip', function($data){
                                return $data->arsip->count()." Berkas";
                            })
                            ->addColumn('Action', function($data){
                                return '<a href="/box/'.$data->id.'" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-info-circle fa-sm text-white-50"></i> Detail</a> | <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="/box/'.$data->id.'/edit"><i class="fas fa-pen-square fa-sm text-white-50"></i> Edit</a> | <form action="/box/'.$data->id.'" method="post" class="d-inline"> '.method_field("delete").' '. csrf_field() .' <button type="submit" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm border-0" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Box '.$data->nama.' ?\')"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</button></form>';
                            })
                            ->rawColumns(['Action'])
                            ->make(true);
    }

    public function DataboxDetail($id){
        $box = Box::findOrFail($id);
        $query = $box->arsip;
        return DataTables::of($query)
                            ->addColumn('id',function($data){
                                return $data->id;
                            })
                            ->addColumn('box_id',function($data){
                                return $data->box->nama." (".$data->box_id.")";
                            })
                            ->addColumn('kode_klasifikasi',function($data){
                                return str($data->kode_klasifikasi);
                            })
                            ->addColumn('indeks',function($data){
                                return $data->indeks;
                            })
                            ->addColumn('uraian',function($data){
                                return $data->uraian;
                            })
                            ->addColumn('tahun',function($data){
                                return str($data->tahun);
                            })
                            ->addColumn('volume',function($data){
                                return $data->volume;
                            })
                            ->addColumn('keterangan:',function($data){
                                return $data->keterangan;
                            })
                            ->addColumn('filename', function($data){
                                return '<button class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#viewberkas" data-nama="'.$data->box->nama.' (KK-'.$data->kode_klasifikasi.'-TH'.$data->tahun.')" data-file="'.asset('storage/berkas/'.$data->filename).'"><i class="fas fa-download fa-sm text-white-50"></i> File Berkas</button>';
                            })
                            ->rawColumns(['filename'])
                            ->make(true);
    }
}
