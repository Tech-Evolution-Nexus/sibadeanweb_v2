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
        $rules = [
            'judul_home' => 'required|string',
            'deskripsi_home' => 'required|string',
            'hero_img' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'about_image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'judul_tentang' => 'required|string',
            'deskripsi_tentang' => 'required|string',
            'video_url' => 'required|string',

            'title' => 'required|array|min:1',
            'title.*' => 'required|string',

            'desc' => 'required|array|min:1',
            'desc.*' => 'required|string|max:255',

            'imge' => 'nullable|array',
            'imge.*' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'app_type' => 'required|in:upload,custom',
            'app_file' => 'required_if:app_type,upload|file|max:153600', // 150MB dalam kilobyte
            'app_url' => 'required_if:app_type,custom|url',
        ];
        $messages = [
            'judul_home.required' => 'Judul Home harus diisi',
            'deskripsi_home.required' => 'Deskripsi Home harus diisi',
            'judul_tentang.required' => 'Judul Tentang harus diisi',
            'deskripsi_tentang.required' => 'Deskripsi Tentang harus diisi',
            'video_url.required' => 'URL Video harus diisi',

            'title.required' => 'Minimal satu fitur harus diisi',
            'title.*.required' => 'Title fitur tidak boleh kosong',
            'title.*.string' => 'Title fitur harus berupa teks',

            'desc.required' => 'Minimal satu deskripsi fitur harus diisi',
            'desc.*.required' => 'Deskripsi fitur tidak boleh kosong',
            'desc.*.string' => 'Deskripsi fitur harus berupa teks',
            'desc.*.max' => 'Deskripsi fitur tidak boleh lebih dari 255 karakter',

            'imge.*.image' => 'File harus berupa gambar',
            'imge.*.mimes' => 'Format gambar tidak valid. Hanya: webp, jpeg, png, jpg, gif, svg',
            'imge.*.max' => 'Ukuran gambar maksimal 2MB',
            'app_type.required' => 'Tipe aplikasi harus dipilih',
            'app_file.required_if' => 'File aplikasi wajib diupload',
            //    'app_file.mimetypes' => 'File harus berformat APK atau IPA.',
            'app_file.max' => 'Ukuran file maksimal 150MB',
            'app_url.required_if' => 'URL aplikasi wajib diisi jika memilih custom',
            'app_url.url' => 'URL aplikasi tidak valid',
        ];
        $validated = $request->validate($rules, $messages);


        // dd($validatedData);
        DB::beginTransaction();
        try {
            $dataUpdate = [];
            $tentang = Landing::find($id);
            if (!$tentang) {
                return redirect()->back()->with("error", "tentang tidak ditemukan");
            }

            $dataUpdate = array_merge($dataUpdate, [
                "hero_title" => request()->judul_home,
                "hero_description" => request()->deskripsi_home,
                "about_title" => request()->judul_tentang,
                "about_description" => request()->deskripsi_tentang,
                "demo_url" => request()->video_url
            ]);
            if ($request->hasFile('hero_img')) {
                if ($tentang->hero_img && file_exists(public_path('assets/images/' . $tentang->hero_img))) {
                    unlink(public_path('assets/images/' . $tentang->hero_img));
                }
                $imageName = uniqid() . '.' . $request->hero_img->extension();
                $request->file('hero_img')->move(public_path('assets/images'), $imageName);
                $dataUpdate['hero_img'] = "assets/images/$imageName";
            }

            // Hapus about_image lama jika ada logo baru yang diunggah
            if ($request->hasFile('about_image')) {
                if ($tentang->about_image && file_exists(public_path('assets/images/' . $tentang->about_image))) {
                    unlink(public_path('assets/images/' . $tentang->about_image));
                }
                $imageName = uniqid() . '.' . $request->about_image->extension();
                $request->file('about_image')->move(public_path('assets/images'), $imageName);
                $dataUpdate['about_image'] = "assets/images/$imageName";
            }
            if ($request->app_type === 'upload') {
                if ($request->hasFile('app_file')) {
                    // Hapus file lama jika ada
                    if ($tentang->app_url && file_exists(public_path($tentang->app_url))) {
                        unlink(public_path($tentang->app_url));
                    }

                    // Ambil ekstensi dan simpan dengan nama unik + ekstensi asli
                    $file = $request->file('app_file');
                    $ext = $file->getClientOriginalExtension(); // Contoh: apk
                    $fileName = 'sibadean.' . $ext;

                    // Simpan file ke storage/app/public/apps
                    $file->storeAs('apps', $fileName, 'public');

                    // Simpan path untuk bisa diakses publik
                    $dataUpdate['mobile_link'] = 'storage/apps/' . $fileName;
                    $dataUpdate['app_type'] = 'upload';
                }
            } elseif ($request->app_type === 'custom') {
                $dataUpdate['mobile_link'] = $request->app_url;
                $dataUpdate['app_type'] = 'custom';
            }

            // dd($dataUpdate);

            $semuaFitur = FiturUtama::where("landing_id", $id)->get();

            FiturUtama::where("landing_id", $id)->delete();

            // dd($semuaFitur);
            // Looping untuk fitur 1 sampai 4
            foreach ($request->title as $i => $title) {
                $desc = $request->desc[$i] ?? '';
                $imgFile = $request->file('imge')[$i] ?? null;
                $oldIcon = $semuaFitur[$i]->icon ?? null;

                // Hapus gambar lama jika ada file baru
                if ($imgFile && $oldIcon && file_exists(public_path('assets/images/' . $oldIcon))) {
                    unlink(public_path('assets/images/' . $oldIcon));
                }

                // Simpan gambar baru jika ada
                $iconName = $oldIcon;
                if ($imgFile) {
                    $iconName = uniqid() . '.' . $imgFile->getClientOriginalExtension();
                    $imgFile->move(public_path('assets/images'), $iconName);
                    $iconName = "assets/images/$iconName";
                }

                // Simpan ke database
                FiturUtama::create([
                    "title" => $title,
                    "icon" => $iconName,
                    "description" => $desc,
                    "landing_id" => $id,
                ]);
            }


            $tentang->update($dataUpdate);

            DB::commit();
            return redirect()->back()->with("success", "tentang berhasil diubah");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with("error", "tentang gagal diubah");
        }
    }
}
