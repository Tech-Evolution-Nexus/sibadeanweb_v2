<?php

namespace App\Http\Controllers;

use App\Models\PengaturanModel;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{

    public function index()
    {
        $pengaturan = PengaturanModel::first();
        return view("admin.pengaturan.pengaturan", ["pengaturan" => $pengaturan]);
    }




    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'hasRw' => 'nullable|boolean',
            'primary_color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'kelurahan' => 'required|string|max:50',
            'kode_pos' => 'required|digits:5',
            'kabupaten' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'provinsi' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar logo
            'logo_horizontal' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar logo horizontal
        ], [
            'hasRw.boolean' => 'Aktifkan RW harus berupa true atau false.',
            'primary_color.required' => 'Warna Primary wajib diisi.',
            'primary_color.size' => 'Warna Primary harus tepat 7 karakter.',
            'primary_color.regex' => 'Format Warna Primary tidak valid.',
            'secondary_color.required' => 'Warna Secondary wajib diisi.',
            'secondary_color.size' => 'Warna Secondary harus tepat 7 karakter.',
            'secondary_color.regex' => 'Format Warna Secondary tidak valid.',
            'kelurahan.required' => 'Kelurahan wajib diisi.',
            'kelurahan.max' => 'Kelurahan tidak boleh lebih dari 50 karakter.',
            'kode_pos.required' => 'Kode Pos wajib diisi.',
            'kode_pos.digits' => 'Kode Pos harus terdiri dari 5 angka.',
            'kabupaten.required' => 'Kabupaten wajib diisi.',
            'kabupaten.max' => 'Kabupaten tidak boleh lebih dari 50 karakter.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.max' => 'Kecamatan tidak boleh lebih dari 50 karakter.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'provinsi.max' => 'Provinsi tidak boleh lebih dari 50 karakter.',
            'logo.image' => 'Logo harus berupa file gambar.',
            'logo.mimes' => 'Logo harus memiliki format: jpeg, png, jpg, gif, atau svg.',
            'logo.max' => 'Logo tidak boleh lebih dari 2MB.',
            'logo_horizontal.image' => 'Logo Horizontal harus berupa file gambar.',
            'logo_horizontal.mimes' => 'Logo Horizontal harus memiliki format: jpeg, png, jpg, gif, atau svg.',
            'logo_horizontal.max' => 'Logo Horizontal tidak boleh lebih dari 2MB.',
        ]);

        try {
            $dataUpdate = [];
            $pengaturan = PengaturanModel::find($id);
            if (!$pengaturan) {
                return redirect()->back()->with("error", "Pengaturan tidak ditemukan");
            }

            if ($request->hasFile('logo')) {
                if ($pengaturan->logo && file_exists(public_path('assets/logos/' . $pengaturan->logo))) {
                    unlink(public_path('assets/logos/' . $pengaturan->logo));
                }
                $imageName = uniqid() . '.' . $request->logo->extension();
                $request->file('logo')->move(public_path('assets/logos'), $imageName);
                $dataUpdate['logo'] = $imageName;
            }

            // Hapus gambar logo horizontal lama jika ada logo baru yang diunggah
            if ($request->hasFile('logo_horizontal')) {
                if ($pengaturan->logo_horizontal && file_exists(public_path('assets/logos/' . $pengaturan->logo_horizontal))) {
                    unlink(public_path('assets/logos/' . $pengaturan->logo_horizontal));
                }
                $imageName = uniqid() . '.' . $request->logo_horizontal->extension();
                $request->file('logo_horizontal')->move(public_path('assets/logos'), $imageName);
                $dataUpdate['logo_horizontal'] = $imageName;
            }
            $dataUpdate = array_merge($dataUpdate, [
                "hasRw" => request()->hasRw,
                "primary_color" => request()->primary_color,
                "secondary_color" => request()->secondary_color,
                "kelurahan" => request()->kelurahan,
                "kode_pos" => request()->kode_pos,
                "kabupaten" => request()->kabupaten,
                "kecamatan" => request()->kecamatan,
                "provinsi" => request()->provinsi
            ]);

            $pengaturan->update($dataUpdate);
            return redirect()->back()->with("success", "Pengaturan berhasil diubah");
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Pengaturan gagal diubah");
        }
    }
}
