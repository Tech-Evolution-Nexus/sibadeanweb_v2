<x-app-layout :title="'Berita'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / FAQ</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">FAQ</h1>
                <a href="{{route("faq.create")}}" class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah
                    faq</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="overflow-x-auto card">
            <table id="berita" class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Pertanyaan</th>
                        <th class="px-4 py-2">Jawaban</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Data rows go here -->
                </tbody>
            </table>
        </div>

        <x-slot name="script">
            <script>
                $(document).ready(function () {
                    $('#berita').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('faq.index') }}",
                        columnDefs: [{
                            width: 200,
                            targets: 3
                        }],
                        columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'question',
                            name: 'question'
                        },
                        {
                            data: 'answer',
                            name: 'answer'
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
