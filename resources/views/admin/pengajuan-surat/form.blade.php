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

        <div class="card">
            <!-- Detail Card -->
            <div class=" p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-gray-700 text-sm">

                    @php
                        $fields = [
                            'Nama Surat' => $data->pengajuan->surat->nama_surat ?? "-",
                            'No Surat' => $data->pengajuan->nomor_surat ?? "-",
                            'Nama' => $data->pengajuan->masyarakat->nama_lengkap ?? "-",
                            'Jenis Kelamin' => $data->pengajuan->masyarakat->jenis_kelamin ?? "-",
                            'NIK' => $data->pengajuan->masyarakat->nik ?? "-",
                            'No KK' => $data->pengajuan->masyarakat->no_kk ?? "-",
                            'Alamat' => $data->pengajuan->masyarakat->kartuKeluarga->alamat ?? "-",
                            'No HP' => $data->pengajuan->masyarakat->user->no_telepon ?? "-",
                            'Agama' => $data->pengajuan->masyarakat->agama ?? "-",
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
                                    <img class="w-full object-cover aspect-video"
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
