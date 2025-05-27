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
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'Nama Surat' => $item->nama_surat,
                'Nama Masyarakat' => $item->nama_masyarakat,
                'RT' => $item->rt,
                'RW' => $item->rw,
                'Status' => $item->status,
                'Tanggal Pengajuan' => $item->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Surat',
            'Nama Masyarakat',
            'RT',
            'RW',
            'Status',
            'Tanggal Pengajuan',
        ];
    }
}
