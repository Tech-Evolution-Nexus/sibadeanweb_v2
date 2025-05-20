<x-app-layout :title="$data->title">
    <div class="md:px-12 px-6 md:py-10 py-5">

        <!-- Breadcrumb & Title -->
        <div class="mb-8">
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
            <!-- Detail Card -->
            <div class=" p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-gray-700 text-sm">

                    @php
                        $customFields = $data->pengajuan->fieldValues;
                        $formatFields = [];
                        foreach ($customFields as $field) {
                            $formatFields[strtoupper($field->fields->nama_field)] = $field->value;
                        }
                        $fields = [
                            'Nama Surat' => $data->pengajuan->surat->nama_surat ?? "-",
                            'No Surat' => $data->pengajuan->nomor_surat ?? "-",
                            'Keterangan' => $data->pengajuan->keterangan ?? "-",
                            'Nama' => $data->pengajuan->masyarakat->nama_lengkap ?? "-",
                            'Jenis Kelamin' => $data->pengajuan->masyarakat->jenis_kelamin ?? "-",
                            'NIK' => $data->pengajuan->masyarakat->nik ?? "-",
                            'No KK' => $data->pengajuan->masyarakat->no_kk ?? "-",
                            'Alamat' => $data->pengajuan->masyarakat->kartuKeluarga->alamat ?? "-",
                            'No HP' => $data->pengajuan->masyarakat->user->no_telepon ?? "-",
                            'Agama' => str_replace("_", " ", $data->pengajuan->masyarakat->agama) ?? "-",
                            'Pekerjaan' => $data->pengajuan->masyarakat->pekerjaan ?? "-",
                            'Tanggal Pengajuan' => Helpers::formatDate($data->pengajuan->created_at, true),
                        ];
                    @endphp

                    @foreach ($fields as $label => $value)
                        <div class="flex flex-col">
                            <span class="text-gray-500">{{ $label }}</span>
                            <span class="font-medium text-gray-900">{{ $value }}</span>
                        </div>
                    @endforeach
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                            @foreach ($data->pengajuan->lampiran as $lampiran)
                                <div class="flex flex-col ">
                                    <span class="text-gray-500">{{ $lampiran->nama_lampiran }}</span>
                                    <img class="w-full object-contain aspect-video"
                                        src="{{route("private.image")}}?path={{ $lampiran->pivot->gambar }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div>
                <form action="{{ $data->action_form }}" method="POST" class="mt-6 flex gap-3">
                    @csrf
                    <a href="{{ route('pengajuan-surat.index') }}"
                        class="bg-gray-100 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-md ">
                        Kembali
                    </a>
                    <button type="submit"
                        class="{{($data->pengajuan->status == "selesai" || $data->pengajuan->status == "di_tolak_rw" || $data->pengajuan->status == "di_tolak_rt" ? "hidden" : "") }} bg-[--primary] hover:bg-[--primary] text-white  px-4 py-2 rounded-md ">
                        Setujui
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
