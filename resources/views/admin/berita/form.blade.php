<x-app-layout :title="$data->title">

    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("kartu-keluarga.index")}}">Kartu
                    keluarga</a> / {{$data->title}}</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">{{$data->title}}</h1>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <form action="<?= $data->action_form ?>" method="POST" class="" enctype="multipart/form-data">
            @csrf
            @method($data->method)
            <div class="grid md:grid-cols-2 grid-cols-1 gap-2 gap-x-4">

                <div class="mb-2">
                    {{-- <x-input-label for="gambar" :value="__('Gambar Berita')" /> --}}
                    {{-- <label
                        class="image-upload rounded mt-2 flex flex-col justify-center items-center border-dashed border p-4 cursor-pointer aspect-video relative">
                        <img src="{{$data->data->gambar ? $data->data->gambar : asset('assets/image/default-2.png')}}"
                            class="absolute inset-0 w-full h-full object-cover" alt="">
                        <input :value="`<?= old('gambar', $data->data->gambar ?? '') ?>`" type="file"
                            class="hidden image-upload-file" accept="image/*" placeholder="gambar" name="gambar"
                            id="gambar">
                        <i class="fa fa-image fs-1 text-gray-500"></i>
                        <span class="text-gray-500">Upload File</span>
                    </label> --}}
                    <x-file-upload :name="'gambar'" :label="'Cover'"
                        :defaultImage="$data->data->gambar ? $data->data->gambar : asset('assets/image/default-2.png')" />
                    <x-input-error :messages="$errors->get('gambar')" class="mt-2 text-red-500 text-xs" />
                </div>


            </div>

            <div class="mb-2 ms-md-3">
                <x-input-label for="judul" :value="__('judul')" />
                <x-text-input name="judul" id="judul" class="block mt-1 w-full"
                    :value=" old('judul', $data->data->judul) " type="text" placeholder="judul" />
                <x-input-error :messages="$errors->get('judul')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-2 ms-md-3">
                <x-input-label for="slug" :value="__('slug')" />
                <x-text-input name="slug" id="slug" type="text" class="block mt-1 w-full"
                    :value="old('slug', $data->data->slug) " placeholder="slug" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-2 ms-md-3">
                <x-input-label for="keterangan" :value="__('keterangan')" />
                <textarea name="keterangan" id="keterangan"
                    class="block mt-1 w-full">{{ old('keterangan', $data->data->keterangan) }}</textarea>
                <x-input-error :messages="$errors->get('keterangan')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-2 ms-md-3">
                <x-input-label for="konten" :value="__('konten')" />
                <textarea name="konten" id="konten"
                    class="block mt-1 w-full">{{ old('konten', $data->data->konten) }}</textarea>
                <x-input-error :messages="$errors->get('konten')" class="mt-2 text-red-500 text-xs" />
            </div>
            <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                <a href="{{route("berita.index")}}"
                    class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900 ">Kembali</a>
                <button type="submit"
                    class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white ">Simpan</button>
            </div>
        </form>

    </div>
    @slot("script")
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
    <script type="module">
        document.addEventListener("DOMContentLoaded", function () {
            const kontenEditor = document.querySelector("#konten");
            const keteranganEditor = document.querySelector("#keterangan");

            if (kontenEditor) {
                ClassicEditor.create(kontenEditor).catch(error => console.error(error));
            }

            if (keteranganEditor) {
                ClassicEditor.create(keteranganEditor).catch(error => console.error(error));
            }
        });
    </script>
    @endslot
</x-app-layout>
