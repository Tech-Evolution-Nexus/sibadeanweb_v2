<x-app-layout :title="'Pengajuan surat'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / pengajuan-surat</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">pengajuan-surat</h1>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <table id="pengajuan-surat" class="w-full">
            <thead>
                <th>No</th>
                <th>Nama surat</th>
                <th>Nama masyarakat</th>
                <th>RT</th>
                <th>RW</th>
                <th>Tanggal pengajuan</th>
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
                    ajax: "{{ route('pengajuan-surat.index') }}",
                    columnDefs: [{
                        width: 200,
                        targets: 5
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nama_surat',
                            name: 'nama_surat'
                        },
                        {
                            data: 'nama_masyarakat',
                            name: 'nama_masyarakat'
                        },
                        {
                            data: 'rt',
                            name: 'rt'
                        },
                        {
                            data: 'rw',
                            name: 'rw'
                        },

                        {
                            data: 'created_at',
                            name: 'created_at'
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