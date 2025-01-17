<x-app-layout :title="'Kartu Keluarga'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / RW</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">RW</h1>
                <a href="{{route("rw.create")}}" class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah RW</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <table id="rw" class="w-full">
            <thead>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>RW</th>
                <th>Aksi</th>
            </thead>
        </table>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#rw').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('rw.index') }}",
                    columnDefs: [{
                        width: 200,
                        targets: 4
                    }, {
                        width: 200,
                        targets: 1
                    }, {
                        width: 50,
                        targets: 0
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'nama_lengkap',
                            name: 'Nama Lengkap'
                        },
                        {
                            data: 'rw',
                            name: 'RW'
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