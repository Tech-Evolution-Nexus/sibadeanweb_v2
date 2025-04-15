<x-app-layout :title="$data->title">

    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("pengajuan-surat.index")}}">Surat Masuk</a> / {{$data->title}}</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">{{$data->title}}</h1>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

    <div class="grid grid-cols-2">
        <span>
            Nama
        </span>
        <span>
            Sagita
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            Alamat
        </span>
        <span>
            Tapen
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            No KK
        </span>
        <span>
            123445678
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            NIK
        </span>
        <span>
            123456789
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            No Surat
        </span>
        <span>
            001
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            Nama Surat
        </span>
        <span>
            Surat Kekayaan
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            Tanggal Pengajuan
        </span>
        <span>
            2024-12-30
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            Jenis Kelamin
        </span>
        <span>
            Perempuan
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            Agama
        </span>
        <span>
            Islam
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
           Pekerjaan
        </span>
        <span>
            PNS
        </span>
    </div>
    <div class="grid grid-cols-2">
        <span>
            No HP
        </span>
        <span>
            085-335-809-393
        </span>
    </div>
</div>
<form action="{{ $data->action_form }}" method="post">
    @csrf
<button>
        Setujui
    </button>
</form>

    </div>

</x-app-layout>