<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengajuanSuratExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
        // dd($this->data);
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'No Surat' => $item->nomor_surat,
                'Nama Surat' => $item->surat->nama_surat,
                'Nama Masyarakat' => $item->masyarakat->nama_lengkap,
                'RT' => $item->masyarakat->kartuKeluarga->rt,
                'RW' => $item->masyarakat->kartuKeluarga->rw,
                'Status' => $item->status,
                'Tanggal Pengajuan' => $item->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No Surat',
            'Nama Surat',
            'Nama Masyarakat',
            'RT',
            'RW',
            'Status',
            'Tanggal Pengajuan',
        ];
    }
}
