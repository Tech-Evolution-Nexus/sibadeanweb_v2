<x-app-layout :title="$data->title">

    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("kartu-keluarga.index")}}">Kartu keluarga</a> / <a class="hover:underline" href="{{route("anggota-keluarga.index",$data->no_kk)}}">Anggota keluarga</a> / {{$data->title}}</div>
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

                <h6 class="font-bold md:col-span-2  text-lg ">Informasi Diri</h6>

                <div class="md:col-span-2">
                    <x-input-label for="nik" :value="__('NIK')" />
                    <x-text-input :value="old('nik', $data->data->nik)" maxlength="16" minlength="16" type="text" class="only-number block mt-1 w-full" placeholder="NIK" name="nik" id="nik" required />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                    <x-text-input :value="old('nama_lengkap', $data->data->nama_lengkap)" type="text" class=" block mt-1 w-full" placeholder="Nama Lengkap" name="nama_lengkap" id="nama_lengkap" required />
                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                    <x-select
                        name="jenis_kelamin"
                        id="jenis_kelamin"
                        class="block mt-1 w-full"
                        :options="['Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan']"
                        value="{{ old('jenis_kelamin', $data->data->jenis_kelamin) }}" required />

                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                    <x-text-input :value="old('tempat_lahir', $data->data->tempat_lahir)" type="text" class=" block mt-1 w-full" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" required />
                    <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                    <x-text-input :value="old('tanggal_lahir', $data->data->tanggal_lahir)" type="date" class=" block mt-1 w-full" placeholder="Tempat Lahir" name="tanggal_lahir" id="tanggal_lahir" required />
                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="agama" :value="__('Agama')" />
                    <x-select
                        name="agama"
                        id="agama"
                        class="block mt-1 w-full"
                        :options="['islam'=>'Islam', 'kristen_protestan'=>'Kristen Protestan' , 'kristen_katolik'=>'Kristen Katolik' , 'hindu'=>'Hindu' , 'buddha'=>'Buddha' , 'konghucu'=>'Konghucu' , 'lainnya'=>'Lainnya' ]"
                        value="{{ old('agama', $data->data->agama) }}" required />

                    <x-input-error :messages="$errors->get('agama')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="">
                    <x-input-label for="pendidikan" :value="__('Pendidikan')" />
                    <x-select
                        name="pendidikan"
                        id="pendidikan"
                        class="block mt-1 w-full"
                        :options="[
                                        'Diploma III/S.Muda' => 'Diploma III/S.Muda',
                                        'Tidak/Belum Sekolah' => 'Tidak/Belum Sekolah',
                                        'Belum Tamat SD/Sederajat' => 'Belum Tamat SD/Sederajat',
                                        'Tamat SD/Sederajat' => 'Tamat SD/Sederajat',
                                        'SLTP/Sederajat' => 'SLTP/Sederajat',
                                        'SLTA/Sederajat' => 'SLTA/Sederajat',
                                        'Diploma I/II' => 'Diploma I/II',
                                        'Diploma IV/Strata I' => 'Diploma IV/Strata I',
                                        'Strata II' => 'Strata II',
                                        'Strata III' => 'Strata III'
                                    ]"

                        value="{{ old('pendidikan', $data->data->pendidikan) }}" required />

                    <x-input-error :messages="$errors->get('pendidikan')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="pekerjaan" :value="__('Pekerjaan')" />
                    <x-text-input :value="old('pekerjaan', $data->data->pekerjaan)" type="text" class=" block mt-1 w-full" placeholder="Tempat Lahir" name="pekerjaan" id="pekerjaan" required />
                    <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2 text-red-500 text-xs" />
                </div>

                <h6 class="font-bold md:col-span-2  text-lg mt-4">Informasi Status dan Identitas
                </h6>
                <div class="">
                    <x-input-label for="golongan_darah" :value="__('Golongan Darah')" />
                    <x-select
                        name="golongan_darah"
                        id="golongan_darah"
                        class="block mt-1 w-full"
                        :options="['A+'=>'A+', 'A-'=>'A-' , 'B+'=>'B+' , 'B-'=>'B-' , 'AB+'=>'AB+' , 'AB-'=>'AB-' , 'O+'=>'O+' , 'O-'=>'O-' ]"
                        value="{{ old('golongan_darah', $data->data->golongan_darah) }}" required />

                    <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="status_perkawinan" :value="__('Status Perkawinan')" />
                    <x-select
                        name="status_perkawinan"
                        id="status_perkawinan"
                        class="block mt-1 w-full"
                        :options="['belum_menikah'=>'Belum Menikah', 'menikah'=>'Menikah' , 'cerai_hidup'=>'Cerai Hidup' , 'cerai_mati'=>'Cerai Mati' , 'duda'=>'Duda' , 'janda'=>'Janda' ]"
                        value="{{ old('status_perkawinan', $data->data->status_perkawinan) }}" required />

                    <x-input-error :messages="$errors->get('status_perkawinan')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="tanggal_perkawinan" :value="__('Tanggal Perkawinan')" />
                    <x-text-input :value="old('tanggal_perkawinan', $data->data->tanggal_perkawinan)" type="date" class=" block mt-1 w-full" placeholder="Tanggal perkawinan" name="tanggal_perkawinan" id="tanggal_perkawinan" />
                    <x-input-error :messages="$errors->get('tanggal_perkawinan')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="">
                    @php
                    $statusKeluargaArr = $data->data->hasKK ?[ 'istri'=>'Istri' , 'anak'=>'Anak' , 'wali'=>'Wali' ]:['kk'=>'Kepala Keluarga', 'istri'=>'Istri' , 'anak'=>'Anak' , 'wali'=>'Wali' ];
                    @endphp
                    <x-input-label for="status_keluarga" :value="__('Status Keluarga')" />

                    <x-select
                        name="status_keluarga"
                        id="status_keluarga"
                        class="block mt-1 w-full"
                        :options="$statusKeluargaArr"
                        value="{{ old('status_keluarga', $data->data->status_keluarga) }}" required />

                    <x-input-error :messages="$errors->get('status_keluarga')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="kewarganegaraan" :value="__('Kewarganegaraan')" />
                    <x-select
                        name="kewarganegaraan"
                        id="kewarganegaraan"
                        class="block mt-1 w-full"
                        :options="['WNI'=>'WNI', 'WNA'=>'WNA']"
                        value="{{ old('kewarganegaraan', $data->data->kewarganegaraan) }}" required />

                    <x-input-error :messages="$errors->get('kewarganegaraan')" class="mt-2 text-red-500 text-xs" />
                </div>
                <h6 class="font-bold md:col-span-2  text-lg mt-4">Dokumen Identitas Tambahan

                </h6>
                <div class="">
                    <x-input-label for="no_paspor" :value="__('No Paspor')" />
                    <x-text-input :value="old('no_paspor', $data->data->no_paspor)" type="text" class=" block mt-1 w-full" placeholder="No paspor" name="no_paspor" id="no_paspor" />
                    <x-input-error :messages="$errors->get('no_paspor')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="no_kitap" :value="__('No Kitap')" />
                    <x-text-input :value="old('no_kitap', $data->data->no_kitap)" type="text" class=" block mt-1 w-full" placeholder="No Kitap" name="no_kitap" id="no_kitap" />
                    <x-input-error :messages="$errors->get('no_kitap')" class="mt-2 text-red-500 text-xs" />
                </div>
                <h6 class="font-bold md:col-span-2  text-lg mt-4">Informasi Keluarga
                </h6>
                <div class="">
                    <x-input-label for="nama_ayah" :value="__('Nama Ayah')" />
                    <x-text-input :value="old('nama_ayah', $data->data->nama_ayah)" type="text" class=" block mt-1 w-full" placeholder="Nama Ibu" name="nama_ayah" id="nama_ayah" required />
                    <x-input-error :messages="$errors->get('nama_ayah')" class="mt-2 text-red-500 text-xs" />
                </div>
                <div class="">
                    <x-input-label for="nama_ibu" :value="__('Nama Ibu')" />
                    <x-text-input :value="old('nama_ibu', $data->data->nama_ibu)" type="text" class=" block mt-1 w-full" placeholder="Nama Ibu" name="nama_ibu" id="nama_ibu" required />
                    <x-input-error :messages="$errors->get('nama_ibu')" class="mt-2 text-red-500 text-xs" />
                </div>
            </div>
            <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                <a href="{{route("kartu-keluarga.index")}}" class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900 ">Kembali</a>
                <button type="submit" class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white ">Simpan</button>
            </div>
        </form>


    </div>

</x-app-layout>