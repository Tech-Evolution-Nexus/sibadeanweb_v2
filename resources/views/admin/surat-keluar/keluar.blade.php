<x-app-layout :title="'Surat Keluar'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Surat Keluar</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Surat Keluar</h1>
                <a href="{{route("surat-keluar.create")}}"
                    class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah Surat Keluar</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="card overflow-x-auto">
            <table id="pengajuan-surat" class="w-full">
                <thead>
                    <th>No</th>
                    <th>Judul</th>
                    {{-- <th>File</th> --}}
                    <th>Tanggal Acara</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>


    <x-modal :name="'preview'" :maxWidth="'2xl'" >
        <iframe :src="previewPdf" id="frame" width="100%" height="600px" frameborder="0"></iframe>
       <button class='px-4 py-2 border bg-white fixed top-5 left-5'
                            x-data
                            x-on:click="$dispatch('close-modal', {name: 'preview'}); previewPdf = '{$path}'">
                            <i class='fa fa-close'></i>
        </button>
    </x-modal>
    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $('#pengajuan-surat').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('surat-keluar.index') }}",
                    columnDefs: [{
                        width: 200,
                        targets: 3
                    }],
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    // {
                    //     data: 'nama_file',
                    //     name: 'nama_file'
                    // },
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
