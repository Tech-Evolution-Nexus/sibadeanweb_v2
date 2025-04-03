@props(["title"])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(isset($title))
            {{ $title }} |
        @endif
        {{ config('app.name', 'SiBADEAN') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">

</head>

<body class=" antialiased">
    <x-loading />
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false,  message: '-',url:'-' }">
        @include('layouts.sidebar')

        <!-- Page Content -->
        <main class="w-full bg-white">
            @include('layouts.navigation')
            {{ $slot }}
        </main>

        <!-- Modal -->
        <x-modal :name="'delete'">
            <form :action="url" method="post" class="p-4">
                <h6 class="font-bold text-lg">Pemberitahuan</h6>
                @csrf
                @method("delete")
                <p x-text="message" class="text-lg"></p>
                <p class="text-slate-500 text-sm">Data akan dihapus secara permanent dan tidak dapat dipulihkan</p>
                <div class="flex md:justify-end flex-wrap-reverse gap-2 mt-10">
                    <button x-data x-on:click="$dispatch('close-modal',{name:'delete'})" type="button"
                        class="md:w-auto w-full px-4 py-2 bg-slate-200 rounded-md text-black">Batal</button>
                    <button type="submit"
                        class="md:w-auto w-full px-4 py-2 bg-red-500 rounded-md text-white">Hapus</button>
                </div>
            </form>
        </x-modal>

    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset("assets/js/datatable/datatable.js")}}"></script>
    <script src="{{asset("assets/js/datatable/tailwind.js")}}"></script>
    <script src="{{asset("assets/js/datatable/tailwind-all.js")}}"></script>

    <script type="importmap">
        {
                    "imports": {
                        "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
                        "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
                    }
                }
            </script>


            
    {{--
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
                                        "{no_surat}", "{nama}", "{nik}", "{tempat_lahir}", "{tanggal_lahir}",
                                        "{jenis_kelamin}", "{pekerjaan}", "{agama}", "{status_perkawinan}",
                                        "{kewarganegaraan}", "{pendidikan}", "{alamat}", "{rw}", "{nama_bapak}",
                                        "{nik_bapak}", "{tempat_lahir_bapak}", "{tanggal_lahir_bapak}", "{jenis_kelamin_bapak}",
                                        "{pekerjaan_bapak}", "{agama_bapak}", "{status_perkawinan_bapak}", "{kewarganegaraan_bapak}",
                                        "{pendidikan_bapak}", "{alamat_bapak}", "{nama_ibu}", "{nik_ibu}", "{tempat_lahir_ibu}",
                                        "{tanggal_lahir_ibu}", "{jenis_kelamin_ibu}", "{pekerjaan_ibu}", "{agama_ibu}",
                                        "{status_perkawinan_ibu}", "{kewarganegaraan_ibu}", "{pendidikan_ibu}", "{alamat_ibu}",
                                        "{rt}", "{kecamatan}", "{desa}", "{kabupaten}", "{tanggal_pengajuan}"
                                    ],
                                    minimumCharacters: 0
                                }
                            ]
                        }
                    }).catch(error => console.error(error));
                }

            }
        });
    </script> --}}

    {{--
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

        if (document.querySelector('.konten')) {
            ClassicEditor
                .create(document.querySelector('.konten'), {
                    plugins: [Mention, HtmlEmbed, Heading, Essentials, Paragraph, Bold, Italic, Font, Alignment, Image, ImageUpload, TableColumnResize, TableToolbar, Table, Indent, HorizontalLine, Underline],
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                    indentBlock: {
                        offset: 1,
                        unit: 'em'
                    },
                    toolbar: [
                        'undo', 'redo', '|', 'underline', 'htmlEmbed',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment', 'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', 'insertTable', 'imageUpload', '|',
                        'heading', 'indent', 'outdent', '|',
                        'code', 'codeBlock', '|',
                        'removeFormat', 'horizontalLine'
                    ],
                })
                .then(editor => {
                    window.editor = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script> --}}


    @if(isset($script))
        {{ $script }}
    @endif

    <script>
        const primary = "{{auth()->user()->pengaturan()->primary_color }}";
        document.documentElement.style.setProperty('--primary', primary);

        $(".preview-image").find("input[type=file]").on("change", function () {
            const file = this.files[0];
            const url = URL.createObjectURL(file);
            $(this).parent().find("img").attr("src", url)

        })


        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>

</body>

</html>
