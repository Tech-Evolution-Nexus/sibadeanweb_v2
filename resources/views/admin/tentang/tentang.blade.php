<x-app-layout>
    <div class="bg-white shadow rounded p-6">
        <div class="container mx-auto">
            <form action="{{ route('tentang.update', $value->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h5 class="text-xl font-bold text-gray-800 mb-4">Edit Halaman Landing Page</h5>

                <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
                <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />
                <h6 class="text-lg font-semibold    text-gray-700 mt-6 mb-2">- Section Home</h6>
                <div>
                    {{-- <div>
                        <label for="nama_website" class="block text-sm font-medium text-gray-700">Nama Website:</label>
                        <input type="text" value="{{ $value->nama_website }}" class="mt-1 block w-full "
                            id="nama_website" name="nama_website">
                    </div> --}}
                    <div>
                        <label for="judul_home" class="block text-sm font-medium text-gray-700">Judul Halaman
                            Home:</label>
                        <x-text-input type="text" value="{{ $value->hero_title }}" class="mt-1 block w-full "
                            id="judul_home" name="judul_home" />
                    </div>
                </div>
                <div class="mt-4">
                    <label for="deskripsi_home" class="block text-sm font-medium text-gray-700">Deskripsi Halaman
                        Home:</label>
                    <textarea id="deskripsi_home" name="deskripsi_home" rows="4"
                        class="mt-1 block w-full px-4 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500  rounded-md shadow-sm">{{ $value->hero_description }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class=" mb-2 mt-4">
                        <x-file-upload :name="'hero_img'" :label="'Gambar Home'" :defaultImage="$value->hero_img ? asset($value->hero_img) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('hero_img')" class="mt-2 text-red-500 text-xs" />
                    </div>
                    <div class=" mb-2 mt-4">
                        <x-file-upload :name="'about_img'" :label="'Gambar Kelurahan'" :defaultImage="$value->about_img ? asset($value->about_img) : asset('assets/image/default-2.png')" />
                        <x-input-error :messages="$errors->get('about_img')" class="mt-2 text-red-500 text-xs" />
                    </div>
                </div>

        </div>

        <h6 class="text-lg font-semibold text-gray-700 mt-6 mb-2">- Section Tentang</h6>
        <div>
            <div>
                <label for="judul_tentang" class="block text-sm font-medium text-gray-700">Judul Halaman
                    Tentang:</label>
                <x-text-input type="text" value="{{ $value->about_title }}" class="mt-4 block w-full "
                    id="judul_tentang" name="judul_tentang" />
            </div>
            {{-- <div>
                <label for="judul_fitur" class="block text-sm font-medium text-gray-700">Judul Fitur:</label>
                <input type="text" value="{{ $value->judul_fitur }}" class="mt-1 block w-full " id="judul_fitur"
                    name="judul_fitur">
            </div> --}}
            <div>
                <label for="deskripsi_tentang" class="block text-sm font-medium text-gray-700">Deskripsi Tentang
                    Badean:</label>
                <textarea id="deskripsi_tentang" name="deskripsi_tentang" rows="4"
                    class="mt-1 block w-full px-4 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500  rounded-md shadow-sm">{{ $value->about_description }}</textarea>
            </div>

            {{-- <div>
                <label for="deskripsi_fitur" class="block text-sm font-medium text-gray-700">Deskripsi Fitur:</label>
                <textarea id="deskripsi_fitur" name="deskripsi_fitur" rows="4"
                    class="mt-1 block w-full ">{{ $value->deskripsi_fitur }}</textarea>
            </div> --}}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($value->fiturUtama as $i => $fu)
                <div class="mb-2 mt-4">
                    {{-- Judul --}}
                    <div class="mb-2">
                        <label for="title_{{ $i }}" class="block text-sm font-medium text-gray-700">
                            Judul Fitur {{ $i + 1 }}:
                        </label>
                        <x-text-input type="text" id="title_{{ $i }}" name="title[]"
                            value="{{ old('title.' . $i, $fu->title) }}" class="mt-1 block w-full " />
                        @error("title.$i")
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="mb-2"> <x-file-upload :name="'imge[' . $i . ']'" :label="'Gambar Fitur ' . ($i + 1)"
                            :defaultImage="$fu->icon ? asset($fu->icon) : asset('assets/image/default-2.png')" />
                        @error("imge.$i")
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-2">
                        <label for="desc_{{ $i }}" class="block text-sm font-medium text-gray-700 mt-2">
                            Deskripsi Fitur {{ $i + 1 }}:
                        </label>
                        <textarea id="desc_{{ $i }}" name="desc[]" rows="4"
                            class="mt-1 block w-full px-4 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500  rounded-md shadow-sm">{{ old('desc.' . $i, $fu->description) }}</textarea>
                        @error("desc.$i")
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endforeach


            {{-- <div>
                <label for="link_download" class="block text-sm font-medium text-gray-700">Link Download
                    Aplikasi:</label>
                <input type="text" value="{{ $value->link_download }}" class="mt-1 block w-full " id="link_download"
                    name="link_download">
            </div> --}}
            <div class="md:col-span-2 ">
                <label for="video_url" class="block text-sm font-medium text-gray-700">Video:</label>
                <x-text-input type="text" value="{{ $value->demo_url }}" class="mt-1 block w-full " id="video_url"
                    name="video_url" />
            </div>
            <div class="md:col-span-2">
                <label for="app_type" class="block text-sm font-medium text-gray-700">App :</label>
                <x-select id="app_type" name="app_type" class="block mt-1 w-full" onchange="toggleAppInput(this)"
                    :options="['upload' => 'upload', 'custom' => 'custom']" />
            </div>

            {{-- Jika upload --}}
            <div class="md:col-span-2" id="upload_section"
                style="{{ $value->app_type == 'upload' ? '' : 'display:none;' }}">
                {{-- <label class="block text-sm font-medium text-gray-700"></label> --}}
                <x-file-upload :name="'app_file'" accept=".apk,.ipa" :label="'Upload Aplikasi Android/iOS'" />
                <x-input-error :messages="$errors->get('app_file')" class="mt-2 text-red-500 text-xs" />
            </div>

            {{-- Jika custom --}}
            <div class="md:col-span-2" id="custom_section"
                style="{{ $value->app_type == 'custom' ? '' : 'display:none;' }}">
                <label for="app_url" class="block text-sm font-medium text-gray-700">Custom URL:</label>
                <x-text-input type="text" value="{{ $value->mobile_link }}" class="mt-1 block w-full" id="app_url"
                    name="app_url" />
            </div>
        </div>

        <div class="mt-6 text-right">
            <button type="submit"
                class="bg-[--primary] hover:opacity-90 text-white font-semibold py-2 px-4 rounded shadow">
                Simpan
            </button>
        </div>
        </form>
    </div>
    </div>
</x-app-layout>






<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

{{-- toast cdn --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- jquery cdn --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
    function toggleAppInput(select) {
        const uploadSection = document.getElementById('upload_section');
        const customSection = document.getElementById('custom_section');

        if (select.value === 'upload') {
            uploadSection.style.display = 'block';
            customSection.style.display = 'none';
        } else {
            uploadSection.style.display = 'none';
            customSection.style.display = 'block';
        }
    }

    // Auto-trigger saat halaman pertama kali dibuka (optional safety)
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('app_type');
        toggleAppInput(select);
    });
</script>
