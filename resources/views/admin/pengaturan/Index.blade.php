<x-app-layout>
    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Pengaturan</div>
            <h1 class="text-2xl">Pengaturan</h1>
        </div>

        <div class="max-w-full">
            <!-- Alert Messages -->


            <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
            <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />


            <!-- Form -->
            <form action="{{ route('setting.update', $pengaturan->id) }}" class="border p-6 rounded-lg bg-white mt-6" method="POST" enctype="multipart/form-data">
                @method("put")
                @csrf
                <div class="grid md:grid-cols-2 grid-cols-1 gap-6">
                    <div>
                        <div class="grid md:grid-cols-2 grid-cols-1 gap-10">
                            <div class="flex flex-col mb-4">
                                <label class="text-gray-700 mb-2">Logo</label>
                                <label class="w-full md:w-[100px] aspect-video preview-image">
                                    <input type="file" accept="image/*" name="logo" class="hidden">
                                    <img class="rounded-md" src="{{ asset('assets/'.($pengaturan->logo?"/logos/$pengaturan->logo":"image/default-2.png")) }}" alt="">
                                </label>
                                @error('logo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col mb-4">
                                <label class="text-gray-700 mb-2">Logo Horizontal</label>
                                <label class="w-full md:w-[100px] aspect-video preview-image">
                                    <input type="file" accept="image/*" name="logo_horizontal" class="hidden">
                                    <img class="rounded-md" src="{{ asset('assets/'.($pengaturan->logo?"/logos/$pengaturan->logo_horizontal":"image/default-2.png")) }}" alt="">
                                </label>
                                @error('logo_horizontal')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label class="text-gray-700 mb-2">Aktifkan RW</label>
                            <label for="aktif-rw" class="flex items-center space-x-2">
                                <input value="1" {{ $pengaturan->hasRw ? 'checked' : '' }} type="checkbox" id="aktif-rw" name="hasRw" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label for="primary_color" class="mb-2 text-gray-700">Warna Primary</label>
                            <div class="flex items-center space-x-2 border rounded-md border-gray-300 ps-2 py-1">
                                <input value="{{ old('primary_color', $pengaturan->primary_color) }}" type="color" id="primary_color" name="primary_color" class="w-10 h-10 p-0 m-0 border-none appearance-none bg-gray-100 border-r border-gray-100 rounded-full">
                                <input value="{{ old('primary_color', $pengaturan->primary_color) }}" type="text" id="primary_color_text" placeholder="#FFFFFF" class="w-[10ch] py-1 px-2 border-0 focus:outline-none">
                            </div>
                            @error('primary_color')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="secondary_color" class="mb-2 text-gray-700">Warna Secondary</label>
                            <div class="flex items-center space-x-2 border rounded-md border-gray-300 ps-2 py-1">
                                <input value="{{ old('secondary_color', $pengaturan->secondary_color) }}" type="color" id="secondary_color" name="secondary_color" class="w-10 h-10 p-0 m-0 border-none appearance-none bg-gray-100 border-r border-gray-100 rounded-full">
                                <input value="{{ old('secondary_color', $pengaturan->secondary_color) }}" type="text" id="secondary_color_text" placeholder="#FFFFFF" class="w-[10ch] py-1 px-2 border-none rounded-r-md focus:outline-none">
                            </div>
                            @error('secondary_color')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col">
                            <label for="kelurahan" class="mb-2 text-gray-700">Kelurahan</label>
                            <input type="text" value="{{ old('kelurahan', $pengaturan->kelurahan) }}" placeholder="Bataan" name="kelurahan" class="py-2 px-4 w-full rounded-md focus:outline-none border border-gray-300">
                            @error('kelurahan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="kode_pos" class="mb-2 text-gray-700">Kode Pos</label>
                            <input type="text" value="{{ old('kode_pos', $pengaturan->kode_pos) }}" placeholder="68281" maxlength="5" minlength="5" name="kode_pos" class="py-2 px-4 w-full rounded-md focus:outline-none border border-gray-300">
                            @error('kode_pos')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="kabupaten" class="mb-2 text-gray-700">Kabupaten</label>
                            <input type="text" value="{{ old('kabupaten', $pengaturan->kabupaten) }}" placeholder="Bondowoso" name="kabupaten" class="py-2 px-4 w-full rounded-md focus:outline-none border border-gray-300">
                            @error('kabupaten')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="kecamatan" class="mb-2 text-gray-700">Kecamatan</label>
                            <input type="text" value="{{ old('kecamatan', $pengaturan->kecamatan) }}" placeholder="Tenggarang" name="kecamatan" class="py-2 px-4 w-full rounded-md focus:outline-none border border-gray-300">
                            @error('kecamatan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="provinsi" class="mb-2 text-gray-700">Provinsi</label>
                            <input type="text" value="{{ old('provinsi', $pengaturan->provinsi) }}" placeholder="Jawa Timur" name="provinsi" class="py-2 px-4 w-full rounded-md focus:outline-none border border-gray-300">
                            @error('provinsi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-right mt-10">
                    <button type="submit" class="px-4 py-2 bg-[--primary] text-white rounded-md focus:outline-none">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function syncColorInputs(colorInputId, textInputId) {
            const colorInput = document.getElementById(colorInputId);
            const textInput = document.getElementById(textInputId);

            colorInput.addEventListener('input', () => {
                textInput.value = colorInput.value.toUpperCase();
            });

            textInput.addEventListener('input', () => {
                const value = textInput.value;
                if (value.length <= 7 && /^#[0-9A-Fa-f]*$/.test(value)) {
                    colorInput.value = value.length === 7 ? value : colorInput.value;
                }
            });

            textInput.addEventListener('input', () => {
                if (textInput.value.length > 7) {
                    textInput.value = textInput.value.slice(0, 7);
                }
            });
        }

        syncColorInputs('primary_color', 'primary_color_text');
        syncColorInputs('secondary_color', 'secondary_color_text');
    </script>
</x-app-layout>