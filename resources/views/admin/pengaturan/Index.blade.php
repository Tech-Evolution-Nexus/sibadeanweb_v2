<x-app-layout>
    <div class="md:px-12 px-6 md:py-4 py-2">
        <div class="mb-10">
            <div class="text-sm">Dashboard / Pengaturan</div>
            <h1 class="text-2xl font-bold">Pengaturan</h1>
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
                                <x-input-label for="logo" :value="'Logo'" />
                                <label class="w-full md:w-[100px] aspect-video preview-image mt-1">
                                    <input type="file" accept="image/*" name="logo" class="hidden">
                                    <img class="rounded-md" src="{{ asset('assets/'.($pengaturan->logo?"/logos/$pengaturan->logo":"image/default-2.png")) }}" alt="">
                                </label>
                                <x-input-error :message="$errors->first('logo')" />
                            </div>
                            <div class="flex flex-col mb-4 ">
                                <x-input-label for="logo_horizontal" :value="__('Logo Horizontal')" />
                                <label class="w-full md:w-[100px] aspect-video preview-image mt-1">
                                    <input type="file" accept="image/*" name="logo_horizontal" class="hidden">
                                    <img class="rounded-md" src="{{ asset('assets/'.($pengaturan->logo?"/logos/$pengaturan->logo_horizontal":"image/default-2.png")) }}" alt="">
                                </label>
                                <x-input-error :message="$errors->first('logo_horizontal')" />
                            </div>
                        </div>
                        <div class="flex flex-col mb-4">
                            <x-input-label for="aktif-rw" :value="__('Aktifkan RW')" />
                            <label for="aktif-rw" class="flex items-center space-x-2 mt-1">
                                <input value="1" {{ $pengaturan->hasRw ? 'checked' : '' }} type="checkbox" id="aktif-rw" name="hasRw" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>
                        <div class="flex flex-col mb-4">
                            <x-input-label for="primary_color" :value="__('Warna Primary')" />
                            <div class="flex items-center space-x-2 border rounded-md border-gray-300 ps-2 py-1 mt-1">
                                <input value="{{ old('primary_color', $pengaturan->primary_color) }}" type="color" id="primary_color" name="primary_color" class="w-10 h-10 p-0 m-0 border-none appearance-none  border-r border-gray-100 rounded-full">
                                <input value="{{ old('primary_color', $pengaturan->primary_color) }}" type="text" id="primary_color_text" placeholder="#FFFFFF" class="w-[10ch] py-1 px-2 border-0 focus:outline-none">
                            </div>
                            <x-input-error :message="$errors->first('primary_color')" />
                        </div>
                        <div class="flex flex-col">
                            <x-input-label for="secondary_color" :value="__('Warna Secondary')" />
                            <div class="flex items-center space-x-2 border rounded-md border-gray-300 ps-2 py-1 mt-1">
                                <input value="{{ old('secondary_color', $pengaturan->secondary_color) }}" type="color" id="secondary_color" name="secondary_color" class="w-10 h-10 p-0 m-0 border-none appearance-none  border-r border-gray-100 rounded-full">
                                <input value="{{ old('secondary_color', $pengaturan->secondary_color) }}" type="text" id="secondary_color_text" placeholder="#FFFFFF" class="w-[10ch] py-1 px-2 border-none rounded-r-md focus:outline-none">
                            </div>
                            <x-input-error :message="$errors->first('secondary_color')" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col">
                            <x-input-label for="kelurahan" :value="'Kelurahan'" />
                            <x-text-input :value="old('kelurahan', $pengaturan->kelurahan)" type="text" class="mt-1 block w-full" placeholder="Bataan" name="kelurahan" id="kelurahan" required />
                            <x-input-error :message="$errors->first('kelurahan')" />
                        </div>
                        <div class="flex flex-col">
                            <x-input-label for="kode_pos" :value="__('Kode Pos')" />
                            <x-text-input :value="old('kode_pos', $pengaturan->kode_pos)" type="text" class="mt-1 block w-full" placeholder="68281" maxlength="5" minlength="5" name="kode_pos" id="kode_pos" required />
                            <x-input-error :message="$errors->first('kode_pos')" />
                        </div>
                        <div class="flex flex-col">
                            <x-input-label for="kabupaten" :value="'Kabupaten'" />
                            <x-text-input :value="old('kabupaten', $pengaturan->kabupaten)" type="text" class="mt-1 block w-full" placeholder="Bondowoso" name="kabupaten" id="kabupaten" required />
                            <x-input-error :message="$errors->first('kabupaten')" />
                        </div>
                        <div class="flex flex-col">
                            <x-input-label for="kecamatan" :value="'Kecamatan'" />
                            <x-text-input :value="old('kecamatan', $pengaturan->kecamatan)" type="text" class="mt-1 block w-full" placeholder="Tenggarang" name="kecamatan" id="kecamatan" required />
                            <x-input-error :message="$errors->first('kecamatan')" />
                        </div>
                        <div class="flex flex-col">
                            <x-input-label for="provinsi" :value="'Provinsi'" />
                            <x-text-input :value="old('provinsi', $pengaturan->provinsi)" type="text" class="mt-1 block w-full" placeholder="Jawa Timur" name="provinsi" id="provinsi" required />
                            <x-input-error :message="$errors->first('provinsi')" />
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