<?php

namespace App\Exports;

use App\Models\Arsip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ArsipExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    function __construct($from, $to) {
        $this->from = $from;
        $this->to = $to;
    }

    public function headings(): array {
        return [
            "ID_BERKAS","NAMA_BOX", "KODE_KLASIFIKASI", "INDEKS", "URAIAN", "TAHUN", "VOLUME", "KETERANGAN"
        ];
    }

    public function collection()
    {
        if($this->from == 0 && $this->to != 0)
        {
            // Query Jika input Tahun-From Tidak Terisi
            return Arsip::where('tahun', '<=', $this->to)->get()->makeHidden(['filename','created_at','updated_at']);
        }
        elseif($this->to == 0 && $this->from != 0)
        {
            // Jika Hanya Input Tahun-To Tidak Terisi
            return Arsip::where('tahun', '>=', $this->from)->get()->makeHidden(['filename','created_at','updated_at']);
        }
        elseif($this->from == 0 && $this->to == 0)
        {
            // Jika Kedua input Tahun-FROM dan Tahun-To Tidak Terisi
            return Arsip::all()->makeHidden(['filename','created_at','updated_at']);
        }else{
            // Jika Seluruh Input Terisi
            return Arsip::whereBetween('tahun', [$this->from, $this->to])->get()->makeHidden(['filename','created_at','updated_at']);
        }
    }
    public function map($arsip): array
    {
        return [
            $arsip->id,
            $arsip->box->nama,
            $arsip->kode_klasifikasi,
            $arsip->indeks,
            $arsip->uraian,
            $arsip->tahun,
            $arsip->volume,
            $arsip->keterangan,
        ];
    }
}
