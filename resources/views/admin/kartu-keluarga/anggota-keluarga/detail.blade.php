<x-app-layout :title="'Anggota Keluarga'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-6">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("kartu-keluarga.index")}}">Kartu
                    keluarga</a> / <a href="{{route("anggota-keluarga.index", [$no_kk])}}"
                    class="hover:underline ">Anggota Keluarga</a> / <span
                    class="hover:underline text-gray-700 font-semibold">Anggota Keluarga</>
            </div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Detail Anggota Keluarga</h1>
            </div>
        </div>
        <a href="{{route("anggota-keluarga.index", [$no_kk])}}"
            class="bg-gray-100 hover:bg-gray-300 mb-4  text-gray-800 font-medium px-4 py-2 rounded-md inline-block">Kembali</a>
        <div class="card ">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Detail Warga</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm text-gray-700">
                <div><span class="font-semibold">NIK : </span> {{ $nik }}</div>
                <div><span class="font-semibold">No KK : </span> {{ $no_kk }}</div>
                <div><span class="font-semibold">Nama Lengkap : </span> {{ $nama_lengkap }}</div>
                <div><span class="font-semibold">Jenis Kelamin : </span> {{ $jenis_kelamin }}</div>
                <div><span class="font-semibold">Tempat, Tanggal Lahir : </span> {{ $tempat_lahir }},
                    {{ $tanggal_lahir }}
                </div>
                <div><span class="font-semibold">Agama : </span> {{ $agama }}</div>
                <div><span class="font-semibold">Pendidikan : </span> {{ $pendidikan }}</div>
                <div><span class="font-semibold">Pekerjaan : </span> {{ $pekerjaan }}</div>
                <div><span class="font-semibold">Golongan Darah : </span> {{ $golongan_darah }}</div>
                <div><span class="font-semibold">Status Perkawinan : </span> {{ $status_perkawinan }}</div>
                <div><span class="font-semibold">Tanggal Perkawinan : </span> {{ $tanggal_perkawinan }}</div>
                <div><span class="font-semibold">Status Keluarga : </span> {{ $status_keluarga }}</div>
                <div><span class="font-semibold">Kewarganegaraan : </span> {{ $kewarganegaraan }}</div>
                <div><span class="font-semibold">No Paspor : </span> {{ $no_paspor }}</div>
                <div><span class="font-semibold">No KITAP : </span> {{ $no_kitap }}</div>
                <div><span class="font-semibold">Nama Ayah : </span> {{ $nama_ayah }}</div>
                <div><span class="font-semibold">Nama Ibu : </span> {{ $nama_ibu }}</div>
            </div>
        </div>


    </div>
</x-app-layout>
