<x-app-layout :title="$data->title">

    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("surat.index")}}">Kartu
                    keluarga</a> / {{$data->title}}</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">{{$data->title}}</h1>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <form action="<?= $data->action_form ?>" method="POST" class="card" enctype="multipart/form-data">
            @csrf
            @method($data->method)
            <div class="">
                <div class="mb-2">
                    {{-- <x-input-label for="gambar" :value="__('Gambar Surat')" />
                    <label
                        class="image-upload rounded mt-2 flex flex-col justify-center items-center border-dashed border p-4 cursor-pointer aspect-video relative">
                        <img src="{{$data->data->gambar ? $data->data->gambar:asset('assets/image/default-2.png')}}"
                            class="absolute inset-0 w-full h-full object-cover" alt="">
                        <input :value="old('gambar', $data->data->gambar)" type="file" class="hidden image-upload-file"
                            accept="image/*" placeholder="gambar" name="gambar" id="gambar">
                        <i class="fa fa-image fs-1 text-gray-500"></i>
                        <span class="text-gray-500">Upload File</span>
                    </label> --}}

                    <x-file-upload :name="'gambar'" :label="'Gambar'" :defaultImage="$data->data->gambar ? $data->data->gambar : asset('assets/image/default-2.png')" />
                    <x-input-error :messages="$errors->get('gambar')" class="mt-2 text-red-500 text-xs" />


                    <div class=" mb-2 ms-md-3">
                        <x-input-label for="nama_surat" :value="__('Nama Surat')" />
                        <x-text-input :value="old('nama_surat', $data->data->nama_surat)" type="text"
                            class="block mt-1 w-full" placeholder="Nama Surat" name="nama_surat" id="nama_surat"
                            required />
                        <x-input-error :messages="$errors->get('nama_surat')" class="mt-2 text-red-500 text-xs" />
                    </div>
                </div>

            </div>
            <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                <a href="{{route("surat.index")}}"
                    class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900 ">Kembali</a>
                <button type="submit"
                    class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white ">Simpan</button>
            </div>
        </form>

    </div>

</x-app-layout>
