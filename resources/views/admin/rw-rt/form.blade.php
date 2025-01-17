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

            @php
            $options = [];
            foreach($data->masyarakat as $masyarakat){
            $options[$masyarakat->nik] = "$masyarakat->nama_lengkap - $masyarakat->nik";
            }
            @endphp
            <div class="grid md:grid-cols-2 grid-cols-1 gap-x-4 gap-y-2">
                <div class=" md:col-span-2">
                    <x-input-label for="nik" :value="__('NIK')" />
                    <x-select data-placeholder="Cari berdasarkan nama atau NIK" data-allow-clear="true" :options="$options" class=" select2 block mt-1 w-full" name="nik" />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class=" ">
                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                    <x-text-input type="text" disabled class="block mt-1 w-full bg-slate-100" placeholder="-" name="nama_lengkap" id="nama_lengkap" />
                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class=" ">
                    <x-input-label for="alamat" :value="__('AlaRmat')" />
                    <x-text-input type="text" disabled class="block mt-1 w-full bg-slate-100" placeholder="-" name="alamat" id="alamat" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class=" ">
                    <x-input-label for="rw" :value="__('RW')" />
                    <x-text-input type="text" disabled class="block mt-1 w-full bg-slate-100" placeholder="-" name="rw" id="rw" />
                    <x-input-error :messages="$errors->get('rw')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class=" ">
                    <x-input-label for="rt" :value="__('RT')" />
                    <x-text-input type="text" disabled class="block mt-1 w-full bg-slate-100" placeholder="-" name="rt" id="rt" />
                    <x-input-error :messages="$errors->get('rt')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class=" ">
                    <x-input-label for="masa_jabatan_awal" :value="__('Masa Jabatan Awal')" />
                    <x-text-input type="date" class="block mt-1 w-full " placeholder="-" name="masa_jabatan_awal" id="masa_jabatan_awal" required />
                    <x-input-error :messages="$errors->get('masa_jabatan_awal')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class=" ">
                    <x-input-label for="masa_jabatan_akhir" :value="__('Masa Jabatan Akhir')" />
                    <x-text-input type="date" class="block mt-1 w-full " placeholder="masa_jabatan_akhir" name="masa_jabatan_akhir" id="masa_jabatan_akhir" required />
                    <x-input-error :messages="$errors->get('masa_jabatan_akhir')" class="mt-2 text-red-500 text-xs" />
                </div>
            </div>
            <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                <a href="{{route("kartu-keluarga.index")}}" class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900 ">Kembali</a>
                <button type="submit" class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white ">Simpan</button>
            </div>
        </form>

    </div>



    <x-slot name="script">
        <script>
            $('.select2').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const data = @json($data);

                const masyarakatTerpilih = data.masyarakat.find(e => selectedOption.val() == e.nik)
                const namaLengkap = masyarakatTerpilih.nama_lengkap;
                const alamat = masyarakatTerpilih.kartu_keluarga.alamat;
                const rw = masyarakatTerpilih.kartu_keluarga.rw;
                const rt = masyarakatTerpilih.kartu_keluarga.rt;

                // Set values to inputs
                $('#nama_lengkap').val(namaLengkap || '-');
                $('#alamat').val(alamat || '-');
                $('#rw').val(rw || '-');
                $('#rt').val(rt || '-');
            });

            $('.select2').val('{{$data->data->nik}}').trigger('change');
        </script>
    </x-slot>
</x-app-layout>