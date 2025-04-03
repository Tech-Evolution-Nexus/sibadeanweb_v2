<x-app-layout :title="'Format Surat'">

    <style>
        .no-bootstrap,
        .no-bootstrap * {
            all: revert;
            font-size: 7px;
            line-height: 1.2;
            max-height: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview,
        .preview * {
            all: revert;
            font-size: 16px;
            line-height: 1.2;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview img {
            display: none;
        }
    </style>

    <!--start yang perlu diubah -->
    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Format Surat</div>
        </div>

        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="p-4">
            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                @foreach ($surat as $formatSurat)
                    <div class="overflow-hidden">
                        <article class="bg-white rounded-lg shadow-md h-full">
                            <div class="p-4">
                                <div class="no-bootstrap">
                                    {!! $formatSurat->format_surat !!}
                                </div>

                                <h6 class="mt-4 font-bold">{{ $formatSurat->nama_surat }}</h6>
                                <div class="flex mt-4 gap-2">
                                    <a href="{{ route('format-surat.edit', $formatSurat->id) }}"
                                        class="px-3 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                                        title="Ubah">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button class="px-3 py-2 bg-green-500 text-white rounded-md hover:bg-green-600" x-data
                                        title="Preview"
                                        @click="$dispatch('open-modal',{name: 'preview-{{ $formatSurat->id }}'})">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </article>

                        <x-modal :name="'preview-' . $formatSurat->id" focusable>
                            <div class="p-6">
                                <h2 class="text-lg font-medium">Preview Surat</h2>
                                <div class="mt-4 preview">
                                    {!! $formatSurat->format_surat !!}
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        Tutup
                                    </x-secondary-button>
                                </div>
                            </div>
                        </x-modal>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</x-app-layout>
