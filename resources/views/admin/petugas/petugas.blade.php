<x-app-layout :title="'Petugas'">
    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Petugas</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Petugas</h1>
                <a href="{{ route('petugas.create') }}"
                    class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah Petugas</a>
            </div>
        </div>

        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="card overflow-x-auto">
            <table id="userTable" class="w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nip</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#userTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('petugas.index') }}",
                    columnDefs: [{
                        width: 200,
                        targets: 6
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'petugas.nip',
                            name: 'petugas.nip'
                        },
                        {
                            data: 'petugas.nama',
                            name: 'petugas.nama'
                        },
                        {
                            data: 'email',
                            name: 'Email'
                        },
                        {
                            data: 'role',
                            name: 'Role'
                        },
                        {
                            data: 'status',
                            name: 'Status'
                        },
                        {
                            data: 'action',
                            name: 'Aksi',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        </script>
    </x-slot>
</x-app-layout>