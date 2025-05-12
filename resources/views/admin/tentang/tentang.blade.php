<x-app-layout>
    <div class="bg-white shadow rounded p-6">
        <div class="container mx-auto">
            <form action="{{ url('/admin/tentang/' . $value->id) }}" method="post">
                @csrf
                @method('POST')

                <h5 class="text-xl font-bold text-gray-800 mb-4">Edit Halaman Landing Page</h5>

                <h6 class="text-lg font-semibold    text-gray-700 mt-6 mb-2">- Section Home</h6>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_website" class="block text-sm font-medium text-gray-700">Nama Website:</label>
                        <input type="text" value="{{ $value->nama_website }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="nama_website" name="nama_website">
                    </div>
                    <div>
                        <label for="judul_home" class="block text-sm font-medium text-gray-700">Judul Halaman Home:</label>
                        <input type="text" value="{{ $value->hero_title }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="judul_home" name="judul_home">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="deskripsi_home" class="block text-sm font-medium text-gray-700">Deskripsi Halaman Home:</label>
                    <textarea id="deskripsi_home" name="deskripsi_home" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->hero_description }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class=" mb-2 mt-4">
                        <x-file-upload :name="'hero_img'" :label="'Gambar Home'"
                        :defaultImage="$value->hero_img ? asset($value->hero_img) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('hero_img')" class="mt-2 text-red-500 text-xs" />
                    </div>
                    <div class=" mb-2 mt-4">
                        <x-file-upload :name="'about_img'" :label="'Gambar Kelurahan'"
                        :defaultImage="$value->about_img ? asset($value->about_img) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('about_img')" class="mt-2 text-red-500 text-xs" />
                    </div>
                </div>

                </div>

                <h6 class="text-lg font-semibold text-gray-700 mt-6 mb-2">- Section Tentang</h6>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="judul_tentang" class="block text-sm font-medium text-gray-700">Judul Halaman Tentang:</label>
                        <input type="text" value="{{ $value->about_title }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="judul_tentang" name="judul_tentang">
                    </div>
                    <div>
                        <label for="judul_fitur" class="block text-sm font-medium text-gray-700">Judul Fitur:</label>
                        <input type="text" value="{{ $value->about_title }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="judul_fitur" name="judul_fitur">
                    </div>
                    <div>
                        <label for="deskripsi_tentang" class="block text-sm font-medium text-gray-700">Deskripsi Tentang Badean:</label>
                        <textarea id="deskripsi_tentang" name="deskripsi_tentang" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->about_description }}</textarea>
                    </div>

                    <div>
                        <label for="deskripsi_fitur" class="block text-sm font-medium text-gray-700">Deskripsi Fitur:</label>
                        <textarea id="deskripsi_fitur" name="deskripsi_fitur" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->about_description }}</textarea>
                    </div>
                        <div class=" mb-2 mt-4">
                        <label for="title_fitur_1" class="block text-sm font-medium text-gray-700">Judul Fitur 1:</label>
                        <input type="text" value="{{ $value->title_fitur_1}}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="title_fitur_1" name="title_fitur_1">
                        <x-file-upload :name="'img_fitur_1'" :label="'Gambar Fitur 1'"
                        :defaultImage="$value->img_fitur_1 ? asset($value->img_fitur_1) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('img_fitur_1')" class="mt-2 text-red-500 text-xs" />
                        <label for="desc_fitur_1" class="block text-sm font-medium text-gray-700">Deskripsi Fitur 1:</label>
                        <textarea id="desc_fitur_1" name="desc_fitur_1" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->desc_fitur_1 }}</textarea>
                    </div>
                    <div class=" mb-2 mt-4">
                        <label for="title_fitur_2" class="block text-sm font-medium text-gray-700">Judul Fitur 2:</label>
                        <input type="text" value="{{ $value->title_fitur_2}}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="title_fitur_2" name="title_fitur_2">
                        <x-file-upload :name="'img_fitur_2'" :label="'Gambar Fitur 2'"
                        :defaultImage="$value->img_fitur_2 ? asset($value->img_fitur_2) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('img_fitur_2')" class="mt-2 text-red-500 text-xs" />
                        <label for="desc_fitur_2" class="block text-sm font-medium text-gray-700">Deskripsi Fitur 2:</label>
                        <textarea id="desc_fitur_2" name="desc_fitur_2" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->desc_fitur_2 }}</textarea>
                    </div>
                    <div class=" mb-2 mt-4">
                        <label for="title_fitur_3" class="block text-sm font-medium text-gray-700">Judul Fitur 3:</label>
                        <input type="text" value="{{ $value->title_fitur_3}}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="title_fitur_3" name="title_fitur_3">
                        <x-file-upload :name="'img_fitur_3'" :label="'Gambar Fitur 3'"
                        :defaultImage="$value->img_fitur_3 ? asset($value->img_fitur_3) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('img_fitur_3')" class="mt-2 text-red-500 text-xs" />
                        <label for="desc_fitur_3" class="block text-sm font-medium text-gray-700">Deskripsi Fitur 3:</label>
                        <textarea id="desc_fitur_3" name="desc_fitur_3" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->desc_fitur_3 }}</textarea>
                    </div>
                    <div class=" mb-2 mt-4">
                        <label for="title_fitur_4" class="block text-sm font-medium text-gray-700">Judul Fitur 4:</label>
                        <input type="text" value="{{ $value->title_fitur_4}}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="title_fitur_4" name="title_fitur_4">
                        <x-file-upload :name="'img_fitur_4'" :label="'Gambar Fitur 4'"
                        :defaultImage="$value->img_fitur_4 ? asset($value->img_fitur_4) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('img_fitur_4')" class="mt-2 text-red-500 text-xs" />
                        <label for="desc_fitur_4" class="block text-sm font-medium text-gray-700">Deskripsi Fitur 4:</label>
                        <textarea id="desc_fitur_4" name="desc_fitur_4" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->desc_fitur_4 }}</textarea>
                    </div>
                    {{-- <div>
                        <label for="link_download" class="block text-sm font-medium text-gray-700">Link Download Aplikasi:</label>
                        <input type="text" value="{{ $value->link_download }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="link_download" name="link_download">
                    </div> --}}
                    <div class="md:col-span-2">
                        <label for="video_url" class="block text-sm font-medium text-gray-700">Video:</label>
                        <input type="text" value="{{ $value->demo_url }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="video_url" name="video_url">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="tentang_aplikasi" class="block text-sm font-medium text-gray-700">Tentang Aplikasi:</label>
                    <textarea id="tentang_aplikasi" name="tentang_aplikasi" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->tentang_aplikasi }}</textarea>
                </div>

                <h6 class="text-lg font-semibold text-gray-700 mt-6 mb-2">- Section Footer</h6>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email_kelurahan" class="block text-sm font-medium text-gray-700">Email Kelurahan:</label>
                        <input type="text" value="{{ $value->email_kelurahan }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="email_kelurahan" name="email_kelurahan">
                    </div>
                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">No Telp:</label>
                        <input type="text" value="{{ $value->no_telp }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200" id="no_telp" name="no_telp">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="alamat_kelurahan" class="block text-sm font-medium text-gray-700">Alamat Kelurahan:</label>
                    <textarea id="alamat_kelurahan" name="alamat_kelurahan" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">{{ $value->alamat_kelurahan }}</textarea>
                </div>

                <div class="mt-6 text-right">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>






<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

{{-- toast cdn --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- jquery cdn --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
