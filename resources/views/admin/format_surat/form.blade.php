<x-app-layout :title="'Format Surat'">

    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Format Surat</div>
        </div>

        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />
        <!--start yang perlu diubah -->
        <div class="flex-grow-1 ">
            <div class="p-4">

                <form action="{{ $data->action_form }}" method="post" class="card" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf
                    <div class="p-6">
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Format</label>
                            <input disabled value="{{ old('nama', $data->surat->nama_surat) }}" type="text" name="nama"
                                id="nama"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 disabled:bg-gray-100">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600 capitalize">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 ">
                            <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                            <textarea name="format_surat" id="konten"
                                class="konten w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">{{ old('konten', $data->surat->format_surat) }}</textarea>
                            @error('format_surat')
                                <p class="mt-1 text-sm text-red-600 capitalize">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-[--primary] text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-[--primary] focus:ring-opacity-50">
                                Simpan
                            </button>
                            <a href="{{ route('format-surat.index') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                                Kembali
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>



        @slot("script")


        <script type="module">
            import {
                ClassicEditor,
                Essentials,
                Paragraph,
                Bold,
                Italic,
                Font,
                Alignment,
                Image,
                ImageUpload,
                Table,
                TableToolbar,
                Heading,
                Indent,
                HorizontalLine,
                Underline,
                HtmlEmbed,
                Mention,
                TableColumnResize,
            } from 'ckeditor5';

            document.addEventListener("DOMContentLoaded", function () {
                if (document.querySelector('.konten')) {
                    const kontenEditor = document.querySelector("#konten");
                    const fields = @json($data->fields);
                    if (kontenEditor) {
                        ClassicEditor.create(kontenEditor, {
                            plugins: [Mention, HtmlEmbed, Heading, Essentials, Paragraph, Bold, Italic, Font, Alignment, Image, ImageUpload, TableColumnResize, TableToolbar, Table, Indent, HorizontalLine, Underline],
                            toolbar: [
                                'undo', 'redo', '|', 'bold', 'italic', 'underline', '|',
                                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                                'alignment', 'bulletedList', 'numberedList', '|',
                                'link', 'blockQuote', 'insertTable', 'imageUpload', '|',
                                'heading', 'indent', 'outdent', '|',
                                'removeFormat', 'horizontalLine'
                            ],
                            mention: {
                                feeds: [
                                    {
                                        marker: "{",
                                        feed: [
                                            fields,
                                            "{nama_surat},{no_surat}", "{nama}", "{nik}", "{tempat_lahir}", "{tanggal_lahir}",
                                            "{jenis_kelamin}", "{pekerjaan}", "{agama}", "{status_perkawinan}",
                                            "{kewarganegaraan}", "{pendidikan}", "{alamat}", "{rw}", "{nama_bapak}",
                                            "{nik_bapak}", "{tempat_lahir_bapak}", "{tanggal_lahir_bapak}", "{jenis_kelamin_bapak}",
                                            "{pekerjaan_bapak}", "{agama_bapak}", "{status_perkawinan_bapak}", "{kewarganegaraan_bapak}",
                                            "{pendidikan_bapak}", "{alamat_bapak}", "{nama_ibu}", "{nik_ibu}", "{tempat_lahir_ibu}",
                                            "{tanggal_lahir_ibu}", "{jenis_kelamin_ibu}", "{pekerjaan_ibu}", "{agama_ibu}",
                                            "{status_perkawinan_ibu}", "{kewarganegaraan_ibu}", "{pendidikan_ibu}", "{alamat_ibu}",
                                            "{rt}", "{kecamatan}", "{desa}", "{kabupaten}", "{tanggal_pengajuan}", "{nama_lurah}", "{nip_lurah}", "{jabatan_lurah}",
                                        ],
                                        minimumCharacters: 0
                                    }
                                ]
                            }
                        }).catch(error => console.error(error));
                    }

                }
            });
        </script>

        @endslot


</x-app-layout>
