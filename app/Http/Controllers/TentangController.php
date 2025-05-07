<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    public function index(){
        $tentang = Landing::first();
        return view('admin.tentang.tentang', ["value" => $tentang]);
        // dd($tentang);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_website' => 'string',
            'judul_home' => 'string',
            'deskripsi_home' => 'string',
            'hero_image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'about_image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'judul_tentang' => 'string',
            'judul_fitur' => 'string',
            'deskripsi_tentang' => 'string|max:150',
            'deskripsi_fitur' => 'string|max:150',
            'video_url' => 'string',
        ], [
            'hero_image.image' => 'File harus berupa gambar.',
            'hero_image.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'hero_image.max' => 'File tidak boleh lebih dari 2MB.',
            'about_image.image' => 'File harus berupa gambar.',
            'about_image.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'about_image.max' => 'File tidak boleh lebih dari 2MB.',
            'deskripsi_tentang.max' => 'deskripsi_home tidak boleh lebih dari 150 karakter.',
            'deskripsi_fitur.max' => 'Kecamatan tidak boleh lebih dari 150 karakter.',
        ]);

        try {
            $dataUpdate = [];
            $tentang = Landing::find($id);
            if (!$tentang) {
                return redirect()->back()->with("error", "tentang tidak ditemukan");
            }

            if ($request->hasFile('hero_image')) {
                if ($tentang->hero_image && file_exists(public_path('assets/images/' . $tentang->hero_image))) {
                    unlink(public_path('assets/images/' . $tentang->hero_image));
                }
                $imageName = uniqid() . '.' . $request->hero_image->extension();
                $request->file('hero_image')->move(public_path('assets/images'), $imageName);
                $dataUpdate['hero_image'] = $imageName;
            }

            // Hapus about_image lama jika ada logo baru yang diunggah
            if ($request->hasFile('about_image')) {
                if ($tentang->about_image && file_exists(public_path('assets/images/' . $tentang->about_image))) {
                    unlink(public_path('assets/images/' . $tentang->about_image));
                }
                $imageName = uniqid() . '.' . $request->about_image->extension();
                $request->file('about_image')->move(public_path('assets/images'), $imageName);
                $dataUpdate['about_image'] = $imageName;
            }
            $dataUpdate = array_merge($dataUpdate, [
                // "nama_website" => request()->hasRw,
                "judul_home" => request()->hero_title,
                "deskripsi_home" => request()->hero_description,
                "hero_image" => request()->hero_img,
                "about_image" => request()->about_img,
                "judul_tentang" => request()->about_title,
                "deskripsi_tentang" => request()->about_description,
                "video_url" => request()->demo_url
            ]);

            $tentang->update($dataUpdate);
            return redirect()->back()->with("success", "tentang berhasil diubah");
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "tentang gagal diubah");
        }
    }
}
