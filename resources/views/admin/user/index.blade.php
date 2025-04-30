<x-app-layout :title="'User'">
    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / User</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">User</h1>
                <a href="{{ route('users.create') }}"
                    class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah User</a>
            </div>
        </div>

        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="card overflow-x-auto">
            <table id="userTable" class="w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Masa Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $('#userTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('users.index') }}",
                    columnDefs: [{
                        width: 200,
                        targets: 6
                    }],
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name', name: 'Nama' },
                        { data: 'email', name: 'Email' },
                        { data: 'role', name: 'Role' },
                        { data: 'status', name: 'Status' },
                        {
                            data: 'masa_jabatan',
                            name: 'Masa Jabatan',
                            render: function (data, type, row) {
                                return row.masa_jabatan_mulai + ' - ' + row.masa_jabatan_selesai;
                            }
                        },
                        { data: 'action', name: 'Aksi', orderable: false, searchable: false },
                    ]
                });
            });
        </script>
    </x-slot>
</x-app-layout>
