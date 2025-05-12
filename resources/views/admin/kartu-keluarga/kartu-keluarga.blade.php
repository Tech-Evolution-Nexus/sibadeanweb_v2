<x-app-layout :title="'Kartu Keluarga'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Kartu keluarga</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">Kartu Keluarga</h1>
                <button x-data x-on:click="$dispatch('open-modal',{name:'import'})"
                    class="px-4 py-2 bg-green-600 rounded-md text-white ms-auto me-2">Import</button>
                <a href="{{route("kartu-keluarga.create")}}"
                    class="px-4 py-2 bg-[--primary] rounded-md text-white ">Tambah KK</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :autoHide="false" :status="'error'" :message="session('error')" />

        <div class="card overflow-x-auto">
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
    </div>


    <x-modal :name="'import'">
        <form action="{{ route('import.masyarakat') }}" method="POST" enctype="multipart/form-data"
            class="p-6 space-y-4">
            @csrf

            <h2 class="text-xl font-semibold text-gray-800">Import Data Masyarakat</h2>

            <div class="text-sm text-gray-600">
                <p>Silakan gunakan template berikut untuk mengisi data:</p>
                <a href="{{ asset('template_excel/masyarakat.xlsx') }}"
                    class="text-blue-600 underline hover:text-blue-800">
                    📥 Download Template Excel
                </a>
            </div>

            <div class="text-sm text-red-600 bg-red-50 p-3 rounded-md border border-red-200">
                ⚠️ Proses ini akan menambahkan data baru. Pastikan format dan nilai kolom sesuai template.
            </div>

            <div>
                <label for="importFile" class="block text-sm font-medium text-gray-700">Pilih File Excel</label>
                <input type="file" name="importFile" id="importFile" accept=".xls,.xlsx" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm file:bg-[--primary] file:text-white file:px-3 file:py-1 file:border-0">
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <button type="button" x-data x-on:click="$dispatch('close-modal', { name: 'import' })"
                    class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 rounded-md bg-[--primary] text-white hover:bg-opacity-90 transition">
                    Import
                </button>
            </div>
        </form>
    </x-modal>


    <x-slot name="script">
        <script>
            $(document).ready(function () {
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
