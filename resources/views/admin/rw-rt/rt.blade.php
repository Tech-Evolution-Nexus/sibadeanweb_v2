<x-app-layout :title="'RT'">


    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / <a class="hover:underline" href="{{route("rw.index")}}">RW</a> / RT</div>
            <div class="flex">
                <h1 class="text-2xl font-bold">RT</h1>
                <a href="{{route("rt.create",$data->rw)}}" class="px-4 py-2 bg-[--primary] rounded-md text-white ms-auto">Tambah RW</a>
            </div>
        </div>
        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <table id="rw" class="w-full">
            <thead>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Ketua RT</th>
                <th>RW</th>
                <th>Masa Jabatan</th>
                <th>Aksi</th>
            </thead>
        </table>
    </div>
    <x-modal :name="'updateStatus'">
        <form :action="url" method="post" class="p-4">
            <h6 class="font-bold text-lg">Pemberitahuan</h6>
            @csrf
            @method("delete")
            <p x-text="message" class="text-lg"></p>
            <p class="text-slate-500 text-sm">Perubahan akan mengubah status ketua rt menjadi masyarakat</p>
            <div class="flex md:justify-end flex-wrap-reverse gap-2 mt-10">
                <button x-data x-on:click="$dispatch('close-modal',{name:'updateStatus'})" type="button" class="md:w-auto w-full px-4 py-2 bg-slate-200 rounded-md text-black">Batal</button>
                <button type="submit" class="md:w-auto w-full px-4 py-2 bg-red-500 rounded-md text-white">Hapus</button>
            </div>
        </form>
    </x-modal>
    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#rw').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('rt.index',$data->rw) }}",
                    columnDefs: [{
                        width: 200,
                        targets: 4
                    }, {
                        width: 200,
                        targets: 1
                    }, {
                        width: 50,
                        targets: 0
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'nama_lengkap',
                            name: 'Nama Lengkap'
                        },
                        {
                            data: 'rt',
                            name: 'RW'
                        },
                        {
                            data: 'rw',
                            name: 'RW'
                        },
                        {
                            data: 'masa_jabatan',
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