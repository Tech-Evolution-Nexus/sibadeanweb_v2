<?php

namespace App\Http\Controllers;

use App\Models\FiturUtama;
use App\Models\Landing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TentangController extends Controller
{
    public function index()
    {
        $tentang = Landing::first();
        return view('admin.tentang.tentang', ["value" => $tentang]);
        // dd($tentang);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'judul_home' => 'required|string',
            'deskripsi_home' => 'required|string|max:255',
            'hero_image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'about_image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'judul_tentang' => 'required|string',
            // 'judul_fitur' => 'required|string',
            'deskripsi_tentang' => 'required|string|max:255',
            // 'deskripsi_fitur' => 'required|string|max:255',
            'title_fitur_1' => 'required|string',
            'title_fitur_2' => 'required|string',
            'title_fitur_3' => 'required|string',
            'title_fitur_4' => 'required|string',
            'imge_fitur_1' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'imge_fitur_2' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'imge_fitur_3' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'imge_fitur_4' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'desc_fitur_1' => 'required|string|max:255',
            'desc_fitur_2' => 'required|string|max:255',
            'desc_fitur_3' => 'required|string|max:255',
            'desc_fitur_4' => 'required|string|max:255',
            'video_url' => 'required|string|',
        ], [
            'judul_home.required' => 'Judul Home harus diisi',
            'judul_home.string' => 'Judul Home harus berupa huruf dan angka',
            'deskripsi_home.required' => 'Deskripsi Home harus diisi',
            'deskripsi_home.string' => 'Deskripsi Home harus berupa huruf dan angka',
            'deskripsi_home.max' => 'Deskripsi Home tidak boleh lebih dari 255 karakter',
            'hero_image.image' => 'File harus berupa gambar.',
            'hero_image.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'hero_image.max' => 'File tidak boleh lebih dari 2MB.',
            'about_image.image' => 'File harus berupa gambar.',
            'about_image.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'about_image.max' => 'File tidak boleh lebih dari 2MB.',
            'judul_tentang.required' => 'Judul Tentang harus diisi',
            'judul_tentang.string' => 'Judul Tentang harus berupa huruf dan angka',
            'deskripsi_tentang.max' => 'deskripsi_home tidak boleh lebih dari 255 karakter.',
            // 'judul_fitur.required' => 'Judul Fitur harus diisi',
            // 'judul_fitur.string' => 'Judul Fitur harus berupa huruf dan angka',
            // 'deskripsi_fitur.required' => 'Deskripsi Fitur tidak boleh kosong',
            // 'deskripsi_fitur.string' => 'Deskripsi Fitur harus berupa huruf dan angka',
            // 'deskripsi_fitur.max' => 'Deskripsi Fitur tidak boleh lebih dari 255 karakter.',
            'title_fitur_1.required' => 'Title Fitur 1 harus diisi',
            'title_fitur_1.string' => 'Title Fitur 1 harus berupa huruf dan angka',
            'title_fitur_2.required' => 'Title Fitur 2 harus diisi',
            'title_fitur_2.string' => 'Title Fitur 2 harus berupa huruf dan angka',
            'title_fitur_3.required' => 'Title Fitur 3 harus diisi',
            'title_fitur_3.string' => 'Title Fitur 3 harus berupa huruf dan angka',
            'title_fitur_4.required' => 'Title Fitur 4 harus diisi',
            'title_fitur_4.string' => 'Title Fitur 4 harus berupa huruf dan angka',
            'imge_fitur_1.image' => 'File harus berupa gambar.',
            'imge_fitur_1.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_1.max' => 'File tidak boleh lebih dari 2MB.',
            'imge_fitur_2.image' => 'File harus berupa gambar.',
            'imge_fitur_2.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_2.max' => 'File tidak boleh lebih dari 2MB.',
            'imge_fitur_3.image' => 'File harus berupa gambar.',
            'imge_fitur_3.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_3.max' => 'File tidak boleh lebih dari 2MB.',
            'imge_fitur_4.image' => 'File harus berupa gambar.',
            'imge_fitur_4.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_4.max' => 'File tidak boleh lebih dari 2MB.',
            'desc_fitur_1.required' => 'Deskripsi Fitur 1 harus diisi',
            'desc_fitur_1.string' => 'Deskripsi Fitur 1 harus berupa huruf dan angka',
            'desc_fitur_1.max' => 'Deskripsi Fitur 1 tidak boleh lebih dari 255 karakter',
            'desc_fitur_2.required' => 'Deskripsi Fitur 2 harus diisi',
            'desc_fitur_2.string' => 'Deskripsi Fitur 2 harus berupa huruf dan angka',
            'desc_fitur_2.max' => 'Deskripsi Fitur 2 tidak boleh lebih dari 255 karakter',
            'desc_fitur_3.required' => 'Deskripsi Fitur 3 harus diisi',
            'desc_fitur_3.string' => 'Deskripsi Fitur 3 harus berupa huruf dan angka',
            'desc_fitur_3.max' => 'Deskripsi Fitur 3 tidak boleh lebih dari 255 karakter',
            'desc_fitur_4.required' => 'Deskripsi Fitur 4 harus diisi',
            'desc_fitur_4.string' => 'Deskripsi Fitur 4 harus berupa huruf dan angka',
            'desc_fitur_4.max' => 'Deskripsi Fitur 4 tidak boleh lebih dari 255 karakter',
        ]);

        // dd($validatedData);
        DB::beginTransaction();
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
                "hero_title" => request()->judul_home,
                "hero_description" => request()->deskripsi_home,
                "hero_img" => request()->hero_image,
                "about_img" => request()->about_image,
                "about_title" => request()->judul_tentang,
                "about_description" => request()->deskripsi_tentang,
                "demo_url" => request()->video_url
                // "mobile_link" => request()->download_here
            ]);

            // dd($dataUpdate);

            $semuaFitur =  FiturUtama::where("landing_id", $id)->get();

            FiturUtama::where("landing_id", $id)->delete();

            // dd($semuaFitur);
            // Looping untuk fitur 1 sampai 4
            for ($i = 1; $i <= 4; $i++) {
                $titleKey = "title_fitur_$i";
                $descKey = "desc_fitur_$i";
                $imgKey = "img_fitur_$i";
                $iconName = $semuaFitur[($i - 1)]->icon;

                if ($request->hasFile($imgKey)) {
                    // Jika sebelumnya ada gambar dan file-nya ada di server, hapus
                    if ($tentang->$imgKey && file_exists(public_path('assets/images/' . $tentang->$imgKey))) {
                        unlink(public_path('assets/images/' . $tentang->$imgKey));
                    }

                    // Generate nama unik dan simpan gambar
                    $iconName = uniqid() . '.' . $request->file($imgKey)->extension();
                    $request->file($imgKey)->move(public_path('assets/images'), $iconName);
                }

                // dd($iconName);

                // Simpan data ke tabel fitur
                FiturUtama::create([
                    "title" => $request->$titleKey,
                    "icon" => $iconName, // fallback ke input lama jika tidak upload ulang
                    "description" => $request->$descKey,
                    "landing_id" => $id
                ]);
            }

            // dd($dataUpdate, $tentang);
            $tentang->update($dataUpdate);
            DB::commit();
            return redirect()->back()->with("success", "tentang berhasil diubah");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with("error", "tentang gagal diubah");
        }
    }
}
