<x-app-layout :title="'Surat'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Surat</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Surat</h1>
                <a href="{{route("surat.create")}}"
                    class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah Surat</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="card overflow-x-auto">
            <table id="surat" class="w-full">
                <thead>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Surat</th>
                    <th>Aksi</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $('#surat').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('surat.index') }}",
                    columnDefs: [{
                        width: 200,
                        targets: 3
                    }],
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar'
                    },
                    {
                        data: 'nama_surat',
                        name: 'nama_surat'
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
