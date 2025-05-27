<x-app-layout :title="'Pengajuan surat'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Pengajuan Surat</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Pengajuan Surat</h1>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="card overflow-x-auto">
            @if (request()->status == 'selesai')
            <div class="mb-4">
                <a href="{{ route('pengajuan-surat.export') }}"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow">
                    Export ke Excel
                </a>
            </div>
            @endif
            <table id="pengajuan-surat" class="w-full">
                <thead>
                    <th>No</th>
                    <th>Nama surat</th>
                    <th>Nama masyarakat</th>
                    <th>RT</th>
                    <th>RW</th>
                    <th>Status</th>
                    <th>Tanggal pengajuan</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#pengajuan-surat').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "",
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
                            data: 'status',
                            name: 'status'
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