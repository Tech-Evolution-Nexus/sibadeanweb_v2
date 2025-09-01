<x-app-layout :title="$data->title">
    <style>
        .no-bootstrap,
        .no-bootstrap * {
            all: revert;
            font-size: 7px;
            line-height: 1.2;
            max-height: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview,
        .preview * {
            all: revert;
            font-size: 16px;
            line-height: 1.2;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview img {
            display: none;
        }
    </style>
    <div class="md:px-12 px-6 md:py-10 py-5">

        <!-- Breadcrumb & Title -->
        <div class="mb-6">
            <nav class="text-sm text-gray-500 mb-1">
                Dashboard /
                <a href="{{ route('pengajuan-surat.index') }}" class="hover:underline ">
                    Surat Masuk
                </a> /
                <span class="text-gray-700 font-semibold">{{ $data->title }}</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-800">{{ $data->title }}</h1>
        </div>

        <!-- Alerts -->
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <a href="{{ route('pengajuan-surat.index') }}"
            class="bg-gray-100 hover:bg-gray-300 inline-block mb-4 text-gray-800  font-medium px-4 py-2 rounded-md ">
            Kembali
        </a>
        <div class="card bg-white rounded-lg shadow-sm p-6 mb-4">
            <h2 class="text-lg font-semibold mb-6">Timeline Status Pengajuan</h2>

            <div class="flex items-center justify-center overflow-x-auto space-x-4 ">
                @foreach ($data->pengajuan->histori as $index => $histori)
                <!-- Titik pertama -->
                <div class="flex flex-col  items-center relative ">
                    <!-- Circle -->
                    <div class="w-5 h-5 bg-blue-600 rounded-full border-4 border-white z-10"></div>
                    <!-- Box bawah -->
                    <div class="mt-2 bg-blue-100 p-3 rounded shadow text-center w-40">
                        <p class="text-sm font-semibold text-grey-600">
                            {{Helpers::formatStatusPengajuan($histori->status_pengajuan) }}
                        </p>
                        <p class="text-xs text-grey-600 mt-1">{{ Helpers::formatDate($histori->created_at) }}</p>
                    </div>
                    @if (!$loop->last)
                    <div class="h-1 bg-gray-200 rounded-sm   w-[163%] absolute top-2 left-[60%]">
                    </div>
                    @endif
                </div>

                @if (!$loop->last)
                <div class="h-1  flex-1 max-w-[100px]" style="min-width: 40px;"></div>
                @endif
                @endforeach
            </div>
        </div>


        <div class="card">
            @php
            $canRespond = !in_array($data->pengajuan->status, ['selesai', 'di_tolak_rw', 'di_tolak_rt', 'di_tolak_lurah']);
            @endphp

            <form action="{{ $data->action_form }}" method="POST" x-data="{ alasan: '', error: '' }">
                @csrf

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-gray-700 text-sm">
                        @php
                        $customFields = $data->pengajuan->fieldValues;
                        $formatFields = [];
                        foreach ($customFields as $field) {
                        $formatFields[strtoupper($field->fields->nama_field)] = $field->value;
                        }
                        $fields = [
                        'Nama Surat' => $data->pengajuan->surat->nama_surat ?? "-",
                        'Nama' => $data->pengajuan->masyarakat->nama_lengkap ?? "-",
                        'No Surat' => $data->pengajuan->nomor_surat ?? "-",
                        'Keterangan' => $data->pengajuan->keterangan ?? "-",
                        ...$formatFields,
                        'Jenis Kelamin' => $data->pengajuan->masyarakat->jenis_kelamin ?? "-",
                        'NIK' => $data->pengajuan->masyarakat->nik ?? "-",
                        'No KK' => $data->pengajuan->masyarakat->no_kk ?? "-",
                        'Alamat' => $data->pengajuan->masyarakat->kartuKeluarga->alamat ?? "-",
                        'No HP' => $data->pengajuan->masyarakat->user->no_telepon ?? "-",
                        'Agama' => str_replace("_", " ", $data->pengajuan->masyarakat->agama) ?? "-",
                        'Pekerjaan' => $data->pengajuan->masyarakat->pekerjaan ?? "-",
                        'Tanggal Pengajuan' => Helpers::formatDate($data->pengajuan->created_at, true),
                        'Gambar Kartu Keluarga' => $data->pengajuan->masyarakat->kartuKeluarga->kk_gambar ?? "-",
                        'Gambar Kartu Tanda Penduduk' => $data->pengajuan->masyarakat->ktp_gambar ?? "-",


                        ];
                        @endphp

                        @foreach ($fields as $label => $value)
                        @php
                        $editable = in_array($label, ['Keterangan', 'No Surat']);
                        @endphp

                        <div
                            class="flex flex-col {{ $editable && !in_array($data->pengajuan->status, ["selesai", "di_tolak_lurah"]) ? 'col-span-2' : '' }}">
                            <label class="text-gray-500 mb-1">{{ $label }}</label>
                            @if (in_array($label, ['Gambar Kartu Keluarga', 'Gambar Kartu Tanda Penduduk']) && $value !== "-")
                            <img class="w-full object-contain aspect-video rounded-md border"
                                src="{{ route('private.image') }}?path={{ $value }}"
                                alt="{{ $label }}">
                            @elseif ($editable && !in_array($data->pengajuan->status, ['selesai', 'di_tolak_lurah']))
                            @if ($label === 'Keterangan')
                            <textarea name="keterangan"
                                class="border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ $value }}</textarea>
                            <small class="text-xs mt-1">Lakukan penyesuaian keterangan pengajuan sesuai standar kelurahan</small>
                            @else
                            <x-text-input type="hidden" name="nomor_surat" value="{{ $value }}" class="w-full" />
                            <span class="font-medium text-gray-900">{{ $value }}</span>
                            @endif
                            @else
                            <span class="font-medium text-gray-900">{{ $value }}</span>
                            @endif

                        </div>
                        @endforeach

                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                                @foreach ($data->pengajuan->lampiran as $lampiran)
                                   <div class="flex flex-col">
                                        <span class="text-gray-500">{{ $lampiran->nama_lampiran }}</span>
                                        <img x-data
                                            x-on:click="previewImage = '{{ route('private.image') }}?path={{ $lampiran->pivot->gambar }}';message = '{{$lampiran->nama_lampiran}}';$dispatch('open-modal', { name: 'preview', previewImage: previewImage });"
                                            class="w-full object-contain aspect-video"
                                            src="{{ route('private.image') }}?path={{ $lampiran->pivot->gambar }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Actions -->
                <div class="mt-6">
                    @if ($canRespond)
                    <button type="button" @click="$dispatch('open-modal', { name: 'ditolak' })"
                        class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-md">
                        Tolak
                    </button>
                    <button type="submit" name="status" value="selesai"
                        class="bg-[--primary] hover:bg-[--primary] text-white px-4 py-2 rounded-md">
                        Setujui
                    </button>
                    @endif
                </div>

                <!-- Modal: Pratinjau Surat -->
                <x-modal name="preview" :maxWidth="'custom'" :maxWidthCustom="'sm:max-w-4xl'">
                    <div class="p-4">
                        <h6 class="font-bold text-lg" x-text="message"></h6>
                        {{-- {!! $data->pengajuan->surat->format_surat !!} --}}
                        <img :src="previewImage" alt="">
                        <div class="flex md:justify-end flex-wrap-reverse gap-4 mt-10">
                            <button type="button" @click="$dispatch('close-modal', { name: 'preview' })"
                                class="md:w-auto w-full px-4 py-2 bg-slate-200 text-black rounded-md">Tutup</button>
                        </div>
                    </div>
                </x-modal>

                <!-- Modal: Penolakan -->
                <x-modal name="ditolak" x-data="{ alasan: '', error: '' }">
                    <div class="p-4">
                        <h6 class="font-bold text-lg mb-4">Konfirmasi Penolakan</h6>
                        <x-input-label for="keterangan_ditolak" value="Alasan Penolakan" />
                        <textarea x-model="alasan" name="keterangan_ditolak" id="keterangan_ditolak" rows="4"
                            class="mt-2 w-full rounded-md px-4 py-2 shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Tuliskan alasan mengapa pengajuan surat ini ditolak..."></textarea>
                        <p x-show="error" class="text-red-500 text-sm mt-1" x-text="error"></p>

                        <div class="flex justify-end flex-wrap-reverse gap-4 mt-6">
                            <button type="button" @click="$dispatch('close-modal', { name: 'ditolak' })"
                                class="w-full md:w-auto px-4 py-2 bg-slate-200 text-black rounded-md">Batal</button>
                            <button name="status" value="di_tolak_lurah" type="button" @click.prevent="
                if (!alasan.trim()) {
                    error = 'Alasan penolakan wajib diisi.';
                } else {
                    error = '';
                    $el.closest('form').submit();
                }
            " class="w-full md:w-auto px-4 py-2 bg-red-500 text-white rounded-md">
                                Tolak Pengajuan
                            </button>
                        </div>
                    </div>
                </x-modal>
            </form>

        </div>
    </div>
</x-app-layout>