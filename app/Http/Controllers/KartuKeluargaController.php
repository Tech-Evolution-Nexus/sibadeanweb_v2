<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\KartuKeluargaModel;
use App\Models\MasyarakatModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KartuKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $kartuKeluarga = KartuKeluargaModel::orderBy("created_at", "desc")->get();

        $params["data"] = (object)[
            "kartu_keluarga" => $kartuKeluarga
        ];


        if (request()->ajax()) {
            return $this->dataTable($kartuKeluarga);
        }
        return view("admin.kartu-keluarga.index", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengaturan = auth()->user()->pengaturan();
        $params["data"] = (object)[
            "title" => "Tambah Kartu Keluarga",
            "action_form" => route("kartu-keluarga.store"),
            "method" => "POST",
            "data" => (object)[
                "no_kk" => "",
                "tanggal_kk" => "",
                "nik" => "",
                "nama" => "",
                "alamat" => "",
                "rt" => "",
                "rw" => "",
                "foto_kartu_keluarga" => "",
                "kode_pos" => $pengaturan->kode_pos,
                "kelurahan" => $pengaturan->kelurahan,
                "kecamatan" => $pengaturan->kecamatan,
                "kabupaten" => $pengaturan->kabupaten,
                "provinsi" => $pengaturan->provinsi,
            ]
        ];
        return view("admin.kartu-keluarga.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Validasi data menggunakan request() dan validasi bahasa Indonesia
        $validated = request()->validate([
            "no_kk" => "required|unique:kartu_keluarga,no_kk",
            // "tanggal_kk" => "required|date",
            "nama" => "required|min:3|max:50",
            "nik" => "required|digits:16|unique:masyarakat,nik",
            "alamat" => "required|max:255",
            "rt" => "required|numeric",
            "rw" => "required|numeric",
            "kelurahan" => "required|max:100",
            "kode_pos" => "required|numeric",
            "kabupaten" => "required|max:100",
            "provinsi" => "required|max:100",
            "kecamatan" => "required|max:100",
            "foto_kartu_keluarga" => "nullable|file|image|max:2024", // Validasi foto (optional)
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.unique' => 'Nomor KK sudah terdaftar.',
            // 'tanggal_kk.required' => 'Tanggal KK wajib diisi.',
            // 'tanggal_kk.date' => 'Tanggal KK harus dalam format tanggal yang valid.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama harus memiliki minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 50 karakter.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nik.min' => 'NIK harus terdiri dari minimal 16 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'rt.required' => 'RT wajib diisi.',
            'rt.numeric' => 'RT harus berupa angka.',
            'rw.required' => 'RW wajib diisi.',
            'rw.numeric' => 'RW harus berupa angka.',
            'kelurahan.required' => 'Kelurahan wajib diisi.',
            'kelurahan.max' => 'Kelurahan maksimal 100 karakter.',
            'kode_pos.required' => 'Kode pos wajib diisi.',
            'kode_pos.numeric' => 'Kode pos harus berupa angka.',
            'kabupaten.required' => 'Kabupaten wajib diisi.',
            'kabupaten.max' => 'Kabupaten maksimal 100 karakter.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'provinsi.max' => 'Provinsi maksimal 100 karakter.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.max' => 'Kecamatan maksimal 100 karakter.',
            'foto_kartu_keluarga.file' => 'File foto kartu keluarga harus berupa file.',
            'foto_kartu_keluarga.image' => 'File foto kartu keluarga harus berupa gambar.',
            'foto_kartu_keluarga.max' => 'Ukuran file foto kartu keluarga maksimal 2MB.',
        ]);

        // Menyimpan data kartu keluarga
        $dataKK = [
            'no_kk' => $validated['no_kk'],
            'alamat' => $validated['alamat'],
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            // 'kk_tgl' => $validated['tanggal_kk'],
        ];

        // Jika ada file foto kartu keluarga
        if (request()->hasFile('foto_kartu_keluarga')) {
            $file = request()->file('foto_kartu_keluarga');
            $randomName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kartu_keluarga', $randomName, ['disk' => 'private']);
            $dataKK['kk_gambar'] = $randomName;
        }

        // Menyimpan data kartu keluarga
        KartuKeluargaModel::create($dataKK);

        // Menyimpan data masyarakat
        MasyarakatModel::create([
            'nik' => $validated['nik'],
            'nama_lengkap' => $validated['nama'],
            'no_kk' => $validated['no_kk'],
            "status_keluarga" => "kk"
        ]);

        return redirect()->route('kartu-keluarga.index')->with('success', 'Kartu keluarga berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(KartuKeluargaModel $kartuKeluargaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengaturan = auth()->user()->pengaturan();
        $kartuKeluarga = KartuKeluargaModel::find($id);
        $masyarakat = $kartuKeluarga->kepalaKeluarga;

        $params["data"] = (object)[
            "title" => "Tambah Kartu Keluarga",
            "action_form" => route("kartu-keluarga.update", $id),
            "method" => "PUT",
            "data" => (object)[
                "no_kk" => $kartuKeluarga->no_kk,
                "tanggal_kk" => "",
                "nik" => $masyarakat->nik,
                "nama" => $masyarakat->nama_lengkap,
                "alamat" => $kartuKeluarga->alamat,
                "rt" => $kartuKeluarga->rt,
                "rw" => $kartuKeluarga->rw,
                "foto_kartu_keluarga" => url("/c/private-image?path=kartu_keluarga/$kartuKeluarga->kk_gambar"),
                "kode_pos" => $pengaturan->kode_pos,
                "kelurahan" => $pengaturan->kelurahan,
                "kecamatan" => $pengaturan->kecamatan,
                "kabupaten" => $pengaturan->kabupaten,
                "provinsi" => $pengaturan->provinsi,
            ]
        ];
        return view("admin.kartu-keluarga.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $masyarakat = KartuKeluargaModel::findOrFail($id)->kepalaKeluarga;
        // Validasi data menggunakan request()
        $validated = request()->validate([
            "no_kk" => "required|unique:kartu_keluarga,no_kk," . $id . ",no_kk",
            // "tanggal_kk" => "required|date",
            "nama" => "required|min:3|max:50",
            "nik" => "required|string|unique:masyarakat,nik," . $masyarakat->nik . ",nik" . "|min:16",
            "alamat" => "required|max:255",
            "rt" => "required|numeric",
            "rw" => "required|numeric",
            "kelurahan" => "required|max:100",
            "kode_pos" => "required|numeric",
            "kabupaten" => "required|max:100",
            "provinsi" => "required|max:100",
            "kecamatan" => "required|max:100",
            "foto_kartu_keluarga" => "nullable|file|image|max:2024", // Validasi foto (optional)
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.unique' => 'Nomor KK sudah terdaftar.',
            // 'tanggal_kk.required' => 'Tanggal KK wajib diisi.',
            // 'tanggal_kk.date' => 'Tanggal KK harus dalam format tanggal yang valid.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama harus memiliki minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 50 karakter.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nik.min' => 'NIK harus terdiri dari minimal 16 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'rt.required' => 'RT wajib diisi.',
            'rt.numeric' => 'RT harus berupa angka.',
            'rw.required' => 'RW wajib diisi.',
            'rw.numeric' => 'RW harus berupa angka.',
            'kelurahan.required' => 'Kelurahan wajib diisi.',
            'kelurahan.max' => 'Kelurahan maksimal 100 karakter.',
            'kode_pos.required' => 'Kode pos wajib diisi.',
            'kode_pos.numeric' => 'Kode pos harus berupa angka.',
            'kabupaten.required' => 'Kabupaten wajib diisi.',
            'kabupaten.max' => 'Kabupaten maksimal 100 karakter.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'provinsi.max' => 'Provinsi maksimal 100 karakter.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.max' => 'Kecamatan maksimal 100 karakter.',
            'foto_kartu_keluarga.file' => 'File foto kartu keluarga harus berupa file.',
            'foto_kartu_keluarga.image' => 'File foto kartu keluarga harus berupa gambar.',
            'foto_kartu_keluarga.max' => 'Ukuran file foto kartu keluarga maksimal 2MB.',
        ]);

        // Cari data kartu keluarga berdasarkan ID
        $dataKK = KartuKeluargaModel::findOrFail($id);
        // Menyimpan data kartu keluarga yang telah diperbarui
        $dataKK->no_kk = $validated['no_kk'];
        $dataKK->alamat = $validated['alamat'];
        $dataKK->rt = $validated['rt'];
        $dataKK->rw = $validated['rw'];
        // $dataKK->kk_tgl = $validated['tanggal_kk'];
        $oldImagePath = storage_path('app/private/kartu_keluarga/' . $dataKK->kk_gambar);
        // Jika ada file foto kartu keluarga baru
        if (request()->hasFile('foto_kartu_keluarga')) {
            // Menghapus gambar lama jika ada
            if ($dataKK->kk_gambar) {
                $oldImagePath = storage_path('app/private/kartu_keluarga/' . $dataKK->kk_gambar);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Menghapus file gambar lama
                }
            }

            // Menyimpan gambar yang baru
            $file = request()->file('foto_kartu_keluarga');
            $randomName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('kartu_keluarga', $randomName, ['disk' => 'private']);
            $dataKK->kk_gambar = $randomName;
        }

        // Menyimpan data kartu keluarga yang telah diperbarui
        $dataKK->save();

        // Menyimpan data masyarakat yang diperbarui
        $masyarakat = MasyarakatModel::where('no_kk', $validated['no_kk'])->first();
        if ($masyarakat) {
            $masyarakat->nik = $validated['nik'];
            $masyarakat->nama_lengkap = $validated['nama'];
            $masyarakat->save();
        }

        return redirect()->route('kartu-keluarga.index')->with('success', 'Kartu keluarga berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KartuKeluargaModel $kartuKeluargaModel)
    {
        //
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('kepala_keluarga', function ($row) {
                return $row->masyarakat()->where("status_keluarga", "=", "kk ")->pluck('nama_lengkap')->first();
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';

                $btn .= '<a href="' . route('kartu-keluarga.show', $row->no_kk) . '" class="btn-show"><i class="fa fa-info"></i></a>';
                $btn .= ' <a href="' . route('kartu-keluarga.edit', $row->no_kk) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $btn .= ' <form action="' . route('kartu-keluarga.destroy', $row->no_kk) . '" method="POST" style="display: inline;">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn-delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash"></i></button>';
                $btn .= '</form>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
