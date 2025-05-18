<?php

namespace App\Http\Controllers;

use App\Models\BeritaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $berita = BeritaModel::orderBy("created_at", "desc")->get();
        $params["data"] = (object) [
            "berita" => $berita
        ];


        if (request()->ajax()) {
            return $this->dataTable($berita);
        }
        return view("admin.berita.berita", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $params["data"] = (object) [
            "title" => "Tambah Berita",
            "action_form" => route("berita.store"),
            "method" => "POST",
            "data" => (object) [
                "judul" => "",
                "slug" => "",
                "keterangan" => "",
                "konten" => "",
                "gambar" => "",
            ]
        ];
        return view("admin.berita.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Validasi data menggunakan request() dan validasi bahasa Indonesia
        $validated = request()->validate([
            "judul" => "required|min:3",
            "slug" => "required|min:3|unique:berita,slug",
            "keterangan" => "required|min:3",
            "konten" => "required|min:3",
            "gambar" => "required|file|image|max:2024",
        ]);

        $dataBerita = [
            'judul' => $validated['judul'],
            'slug' => $validated['slug'],
            'keterangan' => $validated['keterangan'],
            'konten' => $validated['konten'],
        ];

        if (request()->hasFile('gambar')) {
            $file = request()->file('gambar');
            $randomName = 'berita/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('berita', $randomName, ['disk' => 'private']);
            $dataBerita['gambar'] = $randomName;
        }

        // Menyimpan data kartu keluarga
        BeritaModel::create($dataBerita);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(BeritaModel $BeritaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $berita = BeritaModel::find($id);

        $fotoBerita = $berita->gambar ? url("/c/private-image?path=berita/$berita->gambar") : asset("assets/image/default-2.png");
        $params["data"] = (object) [
            "title" => "Ubah Berita",
            "action_form" => route("berita.update", $id),
            "method" => "PUT",
            "data" => (object) [
                "judul" => $berita->judul,
                "slug" => $berita->slug,
                "keterangan" => $berita->keterangan,
                "konten" => $berita->konten,
                "gambar" => $fotoBerita,


            ]
        ];
        return view("admin.berita.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {

        $validated = request()->validate(
            [

                "judul" => "required|min:3|unique:berita,judul,$id",
                "slug" => "required|min:3|unique:berita,slug,$id",
                "keterangan" => "required|min:3",
                "konten" => "required|min:3",
                "gambar" => "required|file|image|max:2024", // Validasi foto (optional)
            ]
        );

        try {
            // Cari data kartu keluarga berdasarkan ID
            $dataBerita = BeritaModel::findOrFail($id);
            // Menyimpan data kartu keluarga yang telah diperbarui
            $dataBerita->judul = $validated['judul'];
            $dataBerita->slug = $validated['slug'];
            $dataBerita->keterangan = $validated['keterangan'];
            $dataBerita->konten = $validated['konten'];
            // $dataBerita->kk_tgl = $validated['tanggal_kk'];
            $oldImagePath = storage_path('app/private/berita/' . $dataBerita->gambar);
            // Jika ada file foto kartu keluarga baru
            if (request()->hasFile('gambar')) {
                // Menghapus gambar lama jika ada
                if ($dataBerita->gambar) {
                    $oldImagePath = storage_path('app/private/berita/' . $dataBerita->gambar);
                    if (file_exists($oldImagePath) && $dataBerita->gambar != "default-2.png") {
                        unlink($oldImagePath); // Menghapus file gambar lama
                    }
                }

                // Menyimpan gambar yang baru
                $file = request()->file('gambar');
                $randomName = 'berita/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('berita', $randomName, ['disk' => 'private']);
                $dataBerita->gambar = $randomName;
            }

            // Menyimpan data kartu keluarga yang telah diperbarui
            $dataBerita->save();

            return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Berita gagal diperbarui');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $BeritaModel = BeritaModel::findOrFail($id);
        $oldImagePath = storage_path('app/private/berita/' . $BeritaModel->gambar);
        // dd($oldImagePath);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath); // Menghapus file gambar lama
        }
        $BeritaModel->delete();
        return redirect()->back()->with('success', 'Berita berhasil dihapus');
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gambar', function ($surat) {
                $gambarUrl = $surat->gambar
                    ? url("/c/private-image?path=berita/$surat->gambar")
                    : asset("assets/image/default-2.png");

                return '<img src="' . $gambarUrl . '" alt="Gambar Surat" width="50">';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= ' <a href="' . route('berita.edit', $row->id) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin menghapus data {$row->judul}?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("berita.destroy", $row->id) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
