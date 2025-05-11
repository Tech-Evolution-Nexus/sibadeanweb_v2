<?php

namespace App\Http\Controllers;

use App\Models\FiturUtama;
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
            'nama_website' => 'required|string|max:20',
            'judul_home' => 'required|string|max:20',
            'deskripsi_home' => 'required|string|max:150',
            'hero_image' => 'required|nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'about_image' => 'required|nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'judul_tentang' => 'required|string|max:20',
            'judul_fitur' => 'required|string|max:20',
            'deskripsi_tentang' => 'required|string|max:150',
            'deskripsi_fitur' => 'required|string|max:150',
            'title_fitur_1' => 'required|string|max:25',
            'title_fitur_2' => 'required|string|max:25',
            'title_fitur_3' => 'required|string|max:25',
            'title_fitur_4' => 'required|string|max:25',
            'imge_fitur_1' => 'required|nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'imge_fitur_2' => 'required|nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'imge_fitur_3' => 'required|nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'imge_fitur_4' => 'required|nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'desc_fitur_1' => 'required|string|max:150',
            'desc_fitur_2' => 'required|string|max:150',
            'desc_fitur_3' => 'required|string|max:150',
            'desc_fitur_4' => 'required|string|max:150',
            'video_url' => 'required|string|',
        ], [
            'nama_website.required' => 'Nama Website harus diisi',
            'nama_website.string' => 'Nama Website harus berupa huruf dan angka',
            'nama_website.max' => 'Nama Website tidak boleh lebih dari 20 karakter',
            'judul_home.required' => 'Judul Home harus diisi',
            'judul_home.string' => 'Judul Home harus berupa huruf dan angka',
            'judul_home.max' => 'Judul Home tidak boleh lebih dari 20 karakter',
            'deskripsi_home.required' => 'Deskripsi Home harus diisi',
            'deskripsi_home.string' => 'Deskripsi Home harus berupa huruf dan angka',
            'deskripsi_home.max' => 'Deskripsi Home tidak boleh lebih dari 150 karakter',
            'hero_image.required' => 'Hero Image harus diisi',
            'hero_image.image' => 'File harus berupa gambar.',
            'hero_image.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'hero_image.max' => 'File tidak boleh lebih dari 2MB.',
            'about_image.required' => 'About Image harus diisi',
            'about_image.image' => 'File harus berupa gambar.',
            'about_image.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'about_image.max' => 'File tidak boleh lebih dari 2MB.',
            'judul_tentang.required' => 'Judul Tentang harus diisi',
            'judul_tentang.string' => 'Judul Tentang harus berupa huruf dan angka',
            'judul_tentang.max' => 'Judul Tentang tidak boleh lebih dari 20 karakter',
            'deskripsi_tentang.max' => 'deskripsi_home tidak boleh lebih dari 150 karakter.',
            'deskripsi_fitur.max' => 'Kecamatan tidak boleh lebih dari 150 karakter.',
            'judul_fitur.required' => 'Judul Fitur harus diisi',
            'judul_fitur.string' => 'Judul Fitur harus berupa huruf dan angka',
            'judul_fitur.max' => 'Judul Fitur tidak boleh lebih dari 20 karakter',
            'title_fitur_1.required' => 'Title Fitur 1 harus diisi',
            'title_fitur_1.string' => 'Title Fitur 1 harus berupa huruf dan angka',
            'title_fitur_1.max' => 'Title Fitur 1 tidak boleh lebih dari 25 karakter',
            'title_fitur_2.required' => 'Title Fitur 2 harus diisi',
            'title_fitur_2.string' => 'Title Fitur 2 harus berupa huruf dan angka',
            'title_fitur_2.max' => 'Title Fitur 2 tidak boleh lebih dari 25 karakter',
            'title_fitur_3.required' => 'Title Fitur 3 harus diisi',
            'title_fitur_3.string' => 'Title Fitur 3 harus berupa huruf dan angka',
            'title_fitur_3.max' => 'Title Fitur 3 tidak boleh lebih dari 25 karakter',
            'title_fitur_4.required' => 'Title Fitur 4 harus diisi',
            'title_fitur_4.string' => 'Title Fitur 4 harus berupa huruf dan angka',
            'title_fitur_4.max' => 'Title Fitur 4 tidak boleh lebih dari 25 karakter',
            'imge_fitur_1.required' => 'Imge Fitur 1 harus diisi',
            'imge_fitur_1.image' => 'File harus berupa gambar.',
            'imge_fitur_1.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_1.max' => 'File tidak boleh lebih dari 2MB.',
            'imge_fitur_2.required' => 'Imge Fitur 2 harus diisi',
            'imge_fitur_2.image' => 'File harus berupa gambar.',
            'imge_fitur_2.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_2.max' => 'File tidak boleh lebih dari 2MB.',
            'imge_fitur_3.required' => 'Imge Fitur 3 harus diisi',
            'imge_fitur_3.image' => 'File harus berupa gambar.',
            'imge_fitur_3.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_3.max' => 'File tidak boleh lebih dari 2MB.',
            'imge_fitur_4.required' => 'Imge Fitur 4 harus diisi',
            'imge_fitur_4.image' => 'File harus berupa gambar.',
            'imge_fitur_4.mimes' => 'File harus memiliki format: webp, jpeg, png, jpg, gif, atau svg.',
            'imge_fitur_4.max' => 'File tidak boleh lebih dari 2MB.',
            'desc_fitur_1.required' => 'Deskripsi Fitur 1 harus diisi',
            'desc_fitur_1.string' => 'Deskripsi Fitur 1 harus berupa huruf dan angka',
            'desc_fitur_1.max' => 'Deskripsi Fitur 1 tidak boleh lebih dari 150 karakter',
            'desc_fitur_2.required' => 'Deskripsi Fitur 2 harus diisi',
            'desc_fitur_2.string' => 'Deskripsi Fitur 2 harus berupa huruf dan angka',
            'desc_fitur_2.max' => 'Deskripsi Fitur 2 tidak boleh lebih dari 150 karakter',
            'desc_fitur_3.required' => 'Deskripsi Fitur 3 harus diisi',
            'desc_fitur_3.string' => 'Deskripsi Fitur 3 harus berupa huruf dan angka',
            'desc_fitur_3.max' => 'Deskripsi Fitur 3 tidak boleh lebih dari 150 karakter',
            'desc_fitur_4.required' => 'Deskripsi Fitur 4 harus diisi',
            'desc_fitur_4.string' => 'Deskripsi Fitur 4 harus berupa huruf dan angka',
            'desc_fitur_4.max' => 'Deskripsi Fitur 4 tidak boleh lebih dari 150 karakter',
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


            FiturUtama::where("landing_id",$id)->delete();

            FiturUtama::create([
                "title" =>request()->title_fitur_1,
                "icon" => request()->img_fitur_1,
                "description" => request()->desc_fitur_1,
                "landing_id" => $id

            ]);

            FiturUtama::create([
                "title" => request()->title_fitur_2,
                "icon" => request()->img_fitur_2,
                "description" => request()->desc_fitur_2,
                "landing_id" => $id

            ]);

            FiturUtama::create([
                "title" => request()->title_fitur_3,
                "icon" => request()->img_fitur_3,
                "description" => request()->desc_fitur_3,
                "landing_id" => $id

            ]);

            FiturUtama::create([
                "title" => request()->title_fitur_4,
                "icon" => request()->img_fitur_4,
                "description" => request()->desc_fitur_4,
                "landing_id" => $id

            ]);

            $tentang->update($dataUpdate);
            return redirect()->back()->with("success", "tentang berhasil diubah");
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "tentang gagal diubah");
        }
    }
}
