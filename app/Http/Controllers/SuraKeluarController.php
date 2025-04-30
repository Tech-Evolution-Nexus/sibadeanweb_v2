<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluarModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuraKeluarController extends Controller
{
    public function index()
    {
        $suratkeluar = SuratKeluarModel::get();
        $params["data"] = (object)[
            "suratkeluar" => $suratkeluar
        ];

        if (request()->ajax()) {
            return $this->dataTable($suratkeluar);
        }
        return view("admin.surat-keluar.keluar", $params);
    }
    public function create()
    {
        $params["data"] = (object)[
            "title" => "Tambah surat keluar",
            "action_form" => route("surat-keluar.store"),
            "method" => "POST",
            "data" => (object)[
                "title" => "",
                "nama_file" => "",
                "exp_date" => "",
            ]
        ];
        return view("admin.surat-keluar.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validated = request()->validate([
            "title" => "required|min:3|max:50",
            "nama_file" => "required|file|mimes:pdf|max:2024",
            "exp_date" => "required|date",
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.min' => 'Judul minimal harus 3 karakter.',
            'title.max' => 'Judul maksimal 50 karakter.',

            'nama_file.required' => 'File surat wajib diunggah.',
            'nama_file.file' => 'File tidak valid.',
            'nama_file.mimes' => 'File harus berupa PDF.',
            'nama_file.max' => 'Ukuran file maksimal 2MB.',

            'exp_date.required' => 'Tanggal kedaluwarsa wajib diisi.',
            'exp_date.date' => 'Format tanggal tidak valid.',
        ]);

        // Proses simpan data surat
        $dataSurat = [
            "title" => $validated['title'],
            "exp_date" => $validated['exp_date'],
        ];

        // Simpan file PDF (nama_file)
        if (request()->hasFile('nama_file')) {
            $pdfFile = request()->file('nama_file');
            $pdfName = uniqid() . '.' . $pdfFile->getClientOriginalExtension();
            $pdfFile->storeAs('surat-keluar', $pdfName, ['disk' => 'private']);
            $dataSurat['nama_file'] = $pdfName;
        }

        // Simpan ke database
        SuratKeluarModel::create($dataSurat);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('surat-keluar.index')->with('success', 'Surat berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(SuratKeluarModel $SuratKeluarModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $surat = SuratKeluarModel::find($id);
        // $gambar = $surat->gambar ? url("/c/private-image?path=surat/$surat->gambar") : asset("assets/image/default-2.png");
        $params["data"] = (object)[
            "title" => "Ubah Surat",
            "action_form" => route("surat-keluar.update", $id),
            "method" => "PUT",
            "data" => (object)[
                "title" => $surat->title,
                "nama_file" => $surat->nama_file,
                "exp_date" =>  $surat->exp_date,
            ]
        ];
        // dd($params);
        return view("admin.surat-keluar.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $validated = request()->validate([
            "title" => "required|min:3|max:50",
            "nama_file" => "nullable|file|mimes:pdf|max:2024",
            "exp_date" => "required|date",
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.min' => 'Judul minimal harus 3 karakter.',
            'title.max' => 'Judul maksimal 50 karakter.',

            'nama_file.file' => 'File tidak valid.',
            'nama_file.mimes' => 'File harus berupa PDF.',
            'nama_file.max' => 'Ukuran file maksimal 2MB.',

            'exp_date.required' => 'Tanggal kedaluwarsa wajib diisi.',
            'exp_date.date' => 'Format tanggal tidak valid.',
        ]);

        try {
            $surat = SuratKeluarModel::findOrFail($id);
            $surat->title = $validated['title'];
            $surat->exp_date = $validated['exp_date'];

            if (request()->hasFile('nama_file')) {
                // Hapus file lama jika ada
                if ($surat->nama_file && $surat->nama_file !== 'default.pdf') {
                    $oldPath = storage_path('app/private/surat-keluar' . $surat->nama_file);
                    if (file_exists($oldPath)) unlink($oldPath);
                }

                // Upload file baru
                $file = request()->file('nama_file');
                $randomName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('surat-keluar', $randomName, ['disk' => 'private']);
                $surat->nama_file = $randomName;
            }

            $surat->save();
            return redirect()->route('surat-keluar.index')->with('success', 'Surat Keluar berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Surat Keluar gagal diperbarui: ' . $th->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $surat = SuratKeluarModel::findOrFail($id);
        if ($surat->nama_file && $surat->nama_file !== 'default.pdf') {
            $filePath = storage_path('app/private/surat-keluar/' . $surat->nama_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $surat->delete();
        // dd($surat);
        return redirect()->back()->with('success', 'Surat Keluar berhasil diperbarui');
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $path = "/c/private-image?path=surat-keluar/$row->nama_file";
                // Tombol preview PDF
                $btn .= "<button class='btn-show'
                            x-data
                            x-on:click=\"\$dispatch('open-modal', {name: 'preview'}); previewPdf = '{$path}'\">
                            <i class='fa fa-eye'></i>
                         </button>";

                // Tombol edit
                $btn .= ' <a href="' . route('surat-keluar.edit', $row->id) . '" class="btn-edit">
                            <i class="fa fa-pencil"></i>
                         </a>';

                // Tombol hapus
                $message = "Apakah anda yakin menghapus data {$row->title}?";
                $btn .= "<button class='btn-delete'
                            x-data
                            x-on:click=\"\$dispatch('open-modal', {name: 'delete'}); message = '{$message}'; url = '" . route("surat-keluar.destroy", $row->id) . "'\">
                            <i class='fa fa-trash'></i>
                         </button>";

                $btn .= '</div>';

                return $btn;

            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
    public function download($filename)
    {
        $path = storage_path("app/private/surat-keluar/" . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
}
