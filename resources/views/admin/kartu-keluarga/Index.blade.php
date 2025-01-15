<x-app-layout>


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Kartu keluarga</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Kartu Keluarga</h1>
                <a href="{{route("kartu-keluarga.create")}}" class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah KK</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <table id="kartuKeluarga" class="w-full">
            <thead>
                <th>No</th>
                <th>No KK</th>
                <th>Kepala Keluarga</th>
                <th>RT</th>
                <th>RW</th>
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
                    columnDefs: [{
                        width: 200,
                        targets: 5
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'no_kk',
                            name: 'No KK'
                        },
                        {
                            data: 'kepala_keluarga',
                            name: 'Kepala Keluarga'
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