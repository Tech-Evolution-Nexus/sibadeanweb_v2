<x-app-layout :title="'Anggota Keluarga'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("kartu-keluarga.index")}}">Kartu keluarga</a> / Anggota Keluarga</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Anggota Keluarga</h1>
                <a href="{{route("anggota-keluarga.create",$data->no_kk)}}" class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah </a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <table id="kartuKeluarga" class="w-full">
            <thead>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>Status Keluarga</th>
                <th>Aksi</th>
            </thead>
        </table>

    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#kartuKeluarga').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('anggota-keluarga.index',$data->no_kk) }}",
                    columnDefs: [{
                        width: 200,
                        targets: 4
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nik',
                            name: 'Nik'
                        },
                        {
                            data: 'nama_lengkap',
                            name: 'Nama Lengkap'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'Jenis Kelamin'
                        },
                        {
                            data: 'status_keluarga',
                            name: 'Status Keluarga'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        </script>
    </x-slot>
</x-app-layout>