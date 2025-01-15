<x-app-layout>

    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("kartu-keluarga.index")}}">Kartu keluarga</a> / Tambah</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">{{$data->title}}</h1>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <form action="<?= $data->action_form ?>" method="POST" class="" enctype="multipart/form-data">
            @csrf
            @method($data->method)
            <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                <h6 class="font-medium md:col-span-2 text-lg ">Informasi Kartu Keluarga</h6>
                <input type="hidden" name="id_masyarakat">

                <div class=" ms-md-3">
                    <x-input-label for="no_kk" :value="__('Nomor Kartu Keluarga')" />
                    <x-text-input :value="old('no_kk', $data->data->no_kk)" maxlength="16" minlength="16" type="text" class="only-number block mt-1 w-full" placeholder="Nomor Kartu Keluarga" name="no_kk" id="no_kk" required />

                    <x-input-error :messages="$errors->get('no_kk')" class="mt-2 text-red-500 text-xs" />
                </div>

                <!-- <div class=" mb-2">
                    <x-input-label for="tanggal_kk" :value="__('Tanggal KK')" />
                    <x-text-input :value="old('tanggal_kk', $data->data->tanggal_kk)" type="date" class="block mt-1 w-full" placeholder="tanggal_kk" name="tanggal_kk" id="tanggal_kk" required />
                    <x-input-error :messages="$errors->get('tanggal_kk')" class="mt-2 text-red-500 text-xs" />
                </div> -->
                <div class=" mb-2">
                    <x-input-label for="alamat" :value="__('Alamat')" />
                    <x-text-input :value="old('alamat', $data->data->alamat)" type="text" class="block mt-1 w-full" placeholder="Alamat Lengkap" name="alamat" id="alamat" required />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class=" mb-2 ms-md-3">
                    <x-input-label for="rt" :value="__('RT')" />
                    <x-text-input :value="old('rt', $data->data->rt)" maxlength="2" type="text" class="only-number block mt-1 w-full" placeholder="Nomor RT" name="rt" id="rt" required />
                    <x-input-error :messages="$errors->get('rt')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class=" mb-2">
                    <x-input-label for="rw" :value="__('RW')" />
                    <x-text-input :value="old('rw', $data->data->rw)" maxlength="2" type="text" class="only-number block mt-1 w-full" placeholder="Nomor RW" name="rw" id="rw" required />
                    <x-input-error :messages="$errors->get('rw')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class=" mb-2">
                    <x-input-label for="foto_kartu_keluarga" :value="__('Foto Kartu Keluarga')" />
                    <label class="image-upload rounded mt-2 flex flex-col justify-center items-center border-dashed border p-4 cursor-pointer aspect-video relative">
                        <img src="{{$data->data->foto_kartu_keluarga ? $data->data->foto_kartu_keluarga:asset('assets/image/default-2.png')}}" class="absolute inset-0 w-full h-full object-cover" alt="">
                        <input :value="old('foto_kartu_keluarga', $data->data->foto_kartu_keluarga)" type="file" class="hidden image-upload-file" accept="image/*" placeholder="foto_kartu_keluarga" name="foto_kartu_keluarga" id="foto_kartu_keluarga">
                        <i class="fa fa-image fs-1 text-gray-500"></i>
                        <span class="text-gray-500">Upload File</span>
                    </label>
                    <x-input-error :messages="$errors->get('foto_kartu_keluarga')" class="mt-2 text-red-500 text-xs" />
                </div>

                <h6 class="font-medium md:col-span-2  text-lg">Informasi Kepala Keluarga</h6>

                <div class="">
                    <div class=" mb-2 ms-md-3">
                        <x-input-label for="nik" :value="__('NIK Kepala Keluarga')" />
                        <x-text-input :value="old('nik', $data->data->nik)" maxlength="16" minlength="16" type="text" class="only-number block mt-1 w-full" placeholder="NIK Kepala Keluarga" name="nik" id="nik" required />
                        <x-input-error :messages="$errors->get('nik')" class="mt-2 text-red-500 text-xs" />
                    </div>
                </div>

                <div class=" mb-2 ms-md-3">
                    <x-input-label for="nama" :value="__('Nama Lengkap')" />
                    <x-text-input :value="old('nama', $data->data->nama)" type="text" class="block mt-1 w-full" placeholder="Nama Lengkap" name="nama" id="nama" required />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2 text-red-500 text-xs" />
                </div>



                <h6 class="font-medium mb-2  text-lg md:col-span-2">Informasi Wilayah</h6>

                <div class=" mb-2 ms-md-3">
                    <x-input-label for="kelurahan" :value="__('Kelurahan')" />
                    <x-text-input :value="old('kelurahan', $data->data->kelurahan)" readonly type="text" class="bg-gray-100 form-control block w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Kelurahan" name="kelurahan" id="kelurahan" required />
                </div>

                <div>
                    <div class=" mb-2">
                        <x-input-label for="kode_pos" :value="__('Kode Pos')" />
                        <x-text-input :value="old('kode_pos', $data->data->kode_pos)" maxlength="5" minlength="5" readonly type="text" class="bg-gray-100 form-control block w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="kode_pos" name="kode_pos" id="kode_pos" required />
                    </div>
                </div>

                <div>
                    <div class=" mb-2 ms-md-3">
                        <x-input-label for="kabupaten" :value="__('Kabupaten')" />
                        <x-text-input :value="old('kabupaten', $data->data->kabupaten)" readonly type="text" class="bg-gray-100 form-control block w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="kabupaten" name="kabupaten" id="kabupaten" required />
                    </div>
                </div>

                <div>
                    <div class=" mb-2">
                        <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                        <x-text-input :value=" old('kecamatan', $data->data->kecamatan)" readonly type="text" class="bg-gray-100 form-control block w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="kecamatan" name="kecamatan" id="kecamatan" required />
                    </div>
                </div>

                <div>
                    <div class=" mb-2 ms-md-3">
                        <x-input-label for="provinsi" :value="__('Provinsi')" />
                        <x-text-input :value="old('provinsi', $data->data->provinsi)" readonly type="text" class="bg-gray-100 form-control block w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Provinsi" name="provinsi" id="provinsi" required />
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