<x-app-layout>


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Kartu keluarga</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Kartu Keluarga</h1>
                <a href="{{route("kartu-keluarga.create")}}" class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah KK</a>
            </div>
        </div>
        <table id="kartuKeluarga">
            <thead>
                <th>No</th>
                <th>No KK</th>
                <th>RT</th>
                <th>RW</th>
                <th>Kepala Keluarga</th>
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
                    ajax: "{{ route('kartu-keluarga.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'No'
                        },
                        {
                            data: 'no_kk',
                            name: 'No KK'
                        },
                        {
                            data: 'rt',
                            name: 'RT'
                        },
                        {
                            data: 'rw',
                            name: 'RW'
                        },
                        {
                            data: 'nama_lengkap',
                            name: 'Kepala Keluarga'
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