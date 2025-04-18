<x-app-layout :title="$data->title">

    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("kartu-keluarga.index")}}">Kartu keluarga</a> / {{$data->title}}</div>
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
                <h6 class="font-bold  md:col-span-2 text-lg ">Informasi Surat Keluar</h6>
                <input type="hidden" name="id_masyarakat" value="{{ $data->data->id_masyarakat ?? '' }}">
                <div class="mb-2">
                    <x-input-label for="nama_file" :value="__('File Surat (PDF)')" />

                    @if($data->data->nama_file)
                    <p class="mb-2 text-sm">
                        <a href="{{ route('surat-keluar.download', $data->data->nama_file) }}" class="text-blue-500 underline" target="_blank">
                            📄 Lihat File PDF
                        </a>
                    </p>
                    @endif

                    <input type="file" name="nama_file" id="nama_file" accept="application/pdf" class="block w-full border border-gray-300 rounded px-3 py-2">
                    <x-input-error :messages="$errors->get('nama_file')" class="mt-2 text-red-500 text-xs" />
                </div>
                @if ($errors->any())
                <pre>{{ var_dump($errors->all()) }}</pre>
                @endif
                <div>
                    <div class=" ms-md-3">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input :value="old('title', $data->data->title)" maxlength="70" minlength="3" type="text" class="only-number block mt-1 w-full" placeholder="Title" name="title" id="title" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <div class=" mb-2">
                        <x-input-label for="exp_date" :value="__('Expierd Date')" />
                        <x-text-input :value="old('exp_date',  \Carbon\Carbon::parse($data->data->exp_date)->format('Y-m-d'))" type="date" class="block mt-1 w-full" name="exp_date" id="exp_date" required />
                        <x-input-error :messages="$errors->get('exp_date')" class="mt-2 text-red-500 text-xs" />
                    </div>
                </div>


            </div>
            <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                <a href="{{route("kartu-keluarga.index")}}" class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900 ">Kembali</a>
                <button type="submit" class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white ">Simpan</button>
            </div>
        </form>

    </div>

</x-app-layout>