<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Box;
use Illuminate\Http\Request;
use App\Exports\ArsipExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DataTables;
use PDF;
use View;

class ArsipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // ini jadi pageview Searching 
        $berkas = Arsip::orderBy('id', 'asc');
        return view('arsipIndex');
    }

    public function create()
    {
        if (auth()->user()->status == 'supervisor' ){
            abort(403);
        }

        // Halaman Input Berkas 
        $box = Box::all();
        $year = [];
        $now = date("Y");
        $start = $now - 15;
        for ($i=$now; $i >= $start ; $i--) { 
            $year[] = $i;
        }
        return view('arsipCreate', [
            'box' => $box,
            'tahun' => $year,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'box_id' => 'required|integer',
            'kode_klasifikasi' => 'required|integer',
            'indeks' => 'required|integer',
            'uraian' => 'required',
            'tahun' => 'required|integer',
            'volume' => 'required|integer',
			'filename' => 'required|mimes:pdf',
			'keterangan' => 'required',
		]);
        
        $berkas = $request->file('filename');
        $nama_berkas = $request->box_id.'_'.$request->kode_klasifikasi.'_'.$request->tahun.'_'.uniqid().'.'.$berkas->extension();
        $berkas->storeAs('berkas', $nama_berkas, ['disk' => 'public']);

        $b = new Arsip;
        $b->box_id = $request->box_id;
        $b->kode_klasifikasi = $request->kode_klasifikasi;
        $b->indeks = $request->indeks;
        $b->uraian = $request->uraian;
        $b->tahun = $request->tahun;
        $b->volume = $request->volume;
        $b->keterangan = $request->keterangan;
        $b->filename = $nama_berkas;
        $b->save();

        return redirect()->route('home')->with('success', 'Berkas Baru Berhasil Di tambahkan !!');
    }

    public function show(Arsip $arsip)
    {
        // Nothing To Show
    }

    public function edit($berkas)
    {
        if (auth()->user()->status != 'superadmin'){
            abort(403);
        }

        $data = Arsip::findOrFail($berkas);
        $box = Box::all();
        $year = [];
        $now = date("Y");
        $start = $now - 15;
        for ($i=$now; $i >= $start ; $i--) { 
            $year[] = $i;
        }
        return view('arsipEdit', [
            'box' => $box,
            'data' => $data,
            'tahun' => $year,
        ]);
    }

    public function update(Request $request, $berka)
    {
        // oldberkasfilename
        $this->validate($request, [
            'box_id' => 'required|integer',
            'kode_klasifikasi' => 'required|integer',
            'indeks' => 'required|integer',
            'uraian' => 'required',
            'tahun' => 'required|integer',
            'volume' => 'required|integer',
            'filename' => 'mimes:pdf',
			'oldberkasfilename' => 'required',
			'keterangan' => 'required',
		]);

        if($request->filename){
            $path = 'public/berkas/'.$request->oldberkasfilename;
            if(Storage::exists($path)){
                Storage::delete($path);
            }
            $berkas = $request->file('filename');
            $nama_berkas = $request->box_id.'_'.$request->kode_klasifikasi.'_'.$request->tahun.'_'.uniqid().'.'.$berkas->extension();
            $berkas->storeAs('berkas', $nama_berkas, ['disk' => 'public']);
        }else{ 
            $nama_berkas = $request->oldberkasfilename;
        }
        
        $berkas = Arsip::findOrFail($berka);
        $berkas->kode_klasifikasi = $request->kode_klasifikasi;
        $berkas->indeks = $request->indeks;
        $berkas->uraian = $request->uraian;
        $berkas->tahun = $request->tahun;
        $berkas->volume = $request->volume;
        $berkas->keterangan = $request->keterangan;
        $berkas->filename = $nama_berkas;
        $berkas->save();

        return redirect()->route('berkas.index')->with('success', 'Data Berkas Berhasil Di Edit !!');
        

    }

    public function destroy(Arsip $berka)
    {
        $berkas = Arsip::findOrFail($berka->id);
        $path = 'public/berkas/'.$berka->filename;
        if(Storage::exists($path)){
            Storage::delete($path);
        }
        $berkas->delete();
        return redirect()->route('berkas.index')->with('success', 'Data dan Arsip Digital Telah Terhapus Permanen Dari Database !');
    }

    public function Databerkas()
    {
        $query = Arsip::all();
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
                                if (auth()->user()->status == 'superadmin'){
                                    return '<button class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#viewberkas" data-nama="'.$data->box->nama.' (KK-'.$data->kode_klasifikasi.'-TH'.$data->tahun.')" data-file="'.asset('storage/berkas/'.$data->filename).'"><i class="fas fa-download fa-sm text-white-50"></i> File Berkas</button> <a href="berkas/'.$data->id.'/edit" class="d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i></a>';
                                }else{
                                    return '<button class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#viewberkas" data-nama="'.$data->box->nama.' (KK-'.$data->kode_klasifikasi.'-TH'.$data->tahun.')" data-file="'.asset('storage/berkas/'.$data->filename).'"><i class="fas fa-download fa-sm text-white-50"></i> File Berkas</button>';
                                }
                            })
                            ->rawColumns(['filename'])
                            ->make(true);
    }

    public function exportIndex(){
        $y = Arsip::orderBy('tahun', 'asc')->first();
        $tahun_terlama = $y->tahun;
        $year = [];
        $now = date("Y");
        // $start = $tahun_terlama;
        for ($i=$now; $i >= $tahun_terlama ; $i--) { 
            $year[] = $i;
        }
        $export = [
            'xlsx' => 'Microsoft Excel',
            'docx' => 'Microsoft Word',
            'pdf' => 'PDF',
        ];
        return view('exportIndex', [
            'year' => $year,
            'export' => $export,
        ]);
    }

    public function exportFilter(Request $request)
    {
        $this->validate($request, [
            'from' => 'integer',
            'to' => 'integer',
            'dokumen' => 'required',
		]);

        $arsip_terlama = Arsip::orderBy('tahun', 'asc')->first();
        if($request->from == 0 && $request->to != 0)
        {
            // Query Jika input Tahun-From Tidak Terisi
            $nama = 'Arsip_Ijazah_Sampai_Tahun'.$request->to.'';
            $judul = 'ARSIP IJAZAH SISWA SAMPAI TAHUN '.$request->to;
            $from = $arsip_terlama->tahun;
            $to = $request->to;
        }
        elseif($request->from != 0 && $request->to == 0 )
        {
            // Jika Hanya Input Tahun-To Tidak Terisi
            $nama = 'Arsip_Ijazah_Tahun_'.$request->from.'-'.date("Y");
            $from = $request->from;
            $to = date('Y');
        }
        elseif($request->from == 0 && $request->to == 0)
        {
            // Jika Kedua input Tahun-FROM dan Tahun-To Tidak Terisi
            $nama = 'Arsip_Ijazah_ALL_(generate_at_'.date("Y").')';
            $judul = 'ARSIP IJAZAH SISWA PERIODE TAHUN '.$arsip_terlama->tahun.' - '.date('Y');
            $from = $arsip_terlama->tahun;
            $to = date("Y");
        }else{
            // Jika Seluruh Input Terisi
            $nama = 'Arsip_Ijazah_(tahun '.$request->from.'-'.$request->to.')';
            $judul = 'ARSIP IJAZAH SISWA PERIODE TAHUN '.$request->from.' - '.$request->to;
            $from = $request->from;
            $to = $request->to;
        }

        switch ($request->dokumen) {
            case 'xlsx':
                return Excel::download(new ArsipExport($from, $to), $nama.'.xlsx');
                break;
            case 'docx':
                // return 'Berkas Dokumen Ms.Word Sedang Disiapkan';
                $headers = array(
                    "Content-type" => "application/vnd.ms-word",
                    "Orientation" => "Landscape",
                    "Content-Disposition"=>"attachment;Filename=".$nama.".doc",
                );
                if($from == 0 && $to != 0)
                {
                    // Query Jika input Tahun-From Tidak Terisi
                    $datadocs = Arsip::where('tahun', '<=', $to)->get()->makeHidden(['filename','created_at','updated_at']);
                }
                elseif($to == 0 && $from != 0)
                {
                    // Query Jika Hanya Input Tahun-To Tidak Terisi
                    $datadocs = Arsip::where('tahun', '>=', $from)->get()->makeHidden(['filename','created_at','updated_at']);
                }
                elseif($from == 0 && $to == 0)
                {
                    // Query Jika Kedua input Tahun-FROM dan Tahun-To Tidak Terisi
                    $datadocs = Arsip::all()->makeHidden(['filename','created_at','updated_at']);
                }else{
                    // Query Jika Seluruh Input Terisi
                    $datadocs = Arsip::whereBetween('tahun', [$from, $to])->get()->makeHidden(['filename','created_at','updated_at']);
                }

                $view = View('pdfExport', [
                    'data' => $datadocs,
                    'Judul' => $judul,
                ]);
                return response()->make($view, 200, $headers);
                break;
            case 'pdf':
                if($from == 0 && $to != 0)
                {
                    // Query Jika input Tahun-From Tidak Terisi
                    $datapdf = Arsip::where('tahun', '<=', $to)->get()->makeHidden(['filename','created_at','updated_at']);
                }
                elseif($to == 0 && $from != 0)
                {
                    // Query Jika Hanya Input Tahun-To Tidak Terisi
                    $datapdf = Arsip::where('tahun', '>=', $from)->get()->makeHidden(['filename','created_at','updated_at']);
                }
                elseif($from == 0 && $to == 0)
                {
                    // Query Jika Kedua input Tahun-FROM dan Tahun-To Tidak Terisi
                    $datapdf = Arsip::all()->makeHidden(['filename','created_at','updated_at']);
                }else{
                    // Query Jika Seluruh Input Terisi
                    $datapdf = Arsip::whereBetween('tahun', [$from, $to])->get()->makeHidden(['filename','created_at','updated_at']);
                }
                view()->share([
                    'data' => $datapdf,
                    'Judul' => $judul,
                ]);
                $pdf = PDF::loadview('pdfExport')->setPaper('a4', 'landscape');
                return $pdf->download($nama.'.pdf');
                break;
            default:
                return Excel::download(new ArsipExport($from, $to), $nama);
                break;
        }
    }
}
