<x-app-layout :title="'Surat Keluar'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Surat Keluar</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Surat Keluar</h1>
                <a href="{{route("surat-keluar.create")}}" class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah Surat Keluar</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <table id="pengajuan-surat" class="w-full">
            <thead>
                <th>No</th>
                <th>Title</th>
                <th>File</th>
                <th>Exp Date</th>
                <th>Aksi</th>
            </thead>
        </table>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#pengajuan-surat').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('surat-keluar.index') }}",
                    columnDefs: [{
                        width: 200,
                        targets: 4
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'nama_file',
                            name: 'nama_file'
                        },
                        {
                            data: 'exp_date',
                            name: 'exp_date'
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