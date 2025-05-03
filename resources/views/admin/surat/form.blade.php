<x-app-layout :title="$data->title">
    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">
                Dashboard /
                <a class="hover:underline" href="{{ route('surat.index') }}">Kartu keluarga</a> /
                {{ $data->title }}
            </div>
            <div class="flex">
                <h1 class="text-2xl font-bold">{{ $data->title }}</h1>
            </div>
        </div>

        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <div class="mb-4"
            x-data='{
             lampiranFields: @json($data->data->lampiranFields) ,
             pendukungFields: @json($data->data->pendukungFields) ,
            addPendukung() { this.pendukungFields.push("") },
            removePendukung(index) { if (this.pendukungFields.length > 1) this.pendukungFields.splice(index, 1) },

                addLampiran() {
            this.lampiranFields.push(""); // Add empty field
            },
            removeLampiran(index) {
                if (this.lampiranFields.length > 1) {
                    this.lampiranFields.splice(index, 1); // Remove selected field
                }
            }
    }'>


            <form action="{{ $data->action_form }}" method="POST" class="card" enctype="multipart/form-data">
                @csrf
                @method($data->method)

                <!-- Informasi Surat -->
                <div class="mb-6">
                    <h6 class="font-bold text-lg mb-2">Informasi Surat</h6>

                    <x-file-upload
                        :name="'gambar'"
                        :label="'Gambar'"
                        :defaultImage="$data->data->gambar ?? asset('assets/image/default-2.png')" />

                    <x-input-error :messages="$errors->get('gambar')" class="mt-2 text-red-500 text-xs" />

                    <div class="mt-4">
                        <x-input-label for="nama_surat" :value="'Nama Surat'" />
                        <x-text-input
                            name="nama_surat"
                            id="nama_surat"
                            type="text"
                            :value="old('nama_surat', $data->data->nama_surat)"
                            class="block mt-1 w-full"
                            placeholder="Nama Surat"
                            required />
                        <x-input-error :messages="$errors->get('nama_surat')" class="mt-2 text-red-500 text-xs" />
                    </div>
                </div>

                <!-- Informasi Data Pendukung -->
                <div class="my-6">
                    <h6 class="font-bold text-lg mb-2">Informasi Data Pendukung</h6>

                    <div class="flex justify-between items-center mb-2">
                        <label class="block font-medium text-sm text-gray-700">Data Pendukung</label>
                        <button type="button" @click="addPendukung"
                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">+</button>
                    </div>

                    <template x-if="pendukungFields.length === 0">
                        <div class="mb-3">
                            <label class="block text-sm text-gray-600 mb-1">Nama Data Pendukung #1</label>
                            <div class="flex gap-2">
                                <input type="text"
                                    class="border rounded px-3 py-2 w-full"
                                    :name="'pendukungFields[0]'"
                                    x-model="pendukungFields[0]"
                                    placeholder="Masukkan Data Pendukung" />
                            </div>
                        </div>
                    </template>

                    <template x-for="(field, index) in pendukungFields" :key="index">
                        <div class="mb-3">
                            <label class="block text-sm text-gray-600 mb-1"
                                x-text="'Nama Data Pendukung #' + (index + 1)">
                            </label>
                            <div class="flex gap-2">
                                <input type="text"
                                    class="border rounded px-3 py-2 w-full"
                                    :name="'pendukungFields[' + index + ']'"
                                    x-model="pendukungFields[index]"
                                    placeholder="Masukkan Data Pendukung" />
                                <button type="button"
                                    @click="removePendukung(index)"
                                    class="bg-red-500 text-white px-3 rounded hover:bg-red-600"
                                    x-show="pendukungFields.length > 1">Hapus</button>
                            </div>
                        </div>
                    </template>

                    @error('nama_field')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lampiran Pendukung -->
                <div class="my-6">
                    <h6 class="font-bold text-lg mb-2">Lampiran Pendukung</h6>

                    <div class="flex justify-between items-center mb-2">
                        <label class="block font-medium text-sm text-gray-700">Data Lampiran</label>
                        <button type="button" @click="addLampiran"
                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">+</button>
                    </div>

                    <template x-if="lampiranFields.length === 0">
                        <div class="mb-3">
                            <label class="block text-sm text-gray-600 mb-1">Lampiran #1</label>
                            <div class="flex gap-2">
                                <select class="border rounded px-3 py-2 w-full"
                                    :name="'lampiranFields[0]'"
                                    x-model="lampiranFields[0]">
                                    <option value="">-- Pilih Lampiran --</option>
                                    @foreach ($lampiranList as $lampiran)
                                    <option value="{{ $lampiran->id }}">{{ $lampiran->nama_lampiran }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </template>

                    <template x-for="(field, index) in lampiranFields" :key="index">
                        <div class="mb-3">
                            <label class="block text-sm text-gray-600 mb-1" x-text="'Lampiran #' + (index + 1)"></label>
                            <div class="flex gap-2">
                                <select :name="'lampiranFields[' + index + ']'" x-model="lampiranFields[index]" class="border rounded px-3 py-2 w-full">
                                    <option value="">-- Pilih Lampiran --</option>
                                    @foreach ($lampiranList as $lampiran)
                                    <option value="{{ $lampiran->id }}">
                                        {{ $lampiran->nama_lampiran }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="button" @click="removeLampiran(index)" class="bg-red-500 text-white px-3 rounded hover:bg-red-600" x-show="lampiranFields.length > 1">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                    @error('nama_field')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                    <a href="{{ route('surat.index') }}"
                        class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900">
                        Kembali
                    </a>
                    <button type="submit"
                        class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>