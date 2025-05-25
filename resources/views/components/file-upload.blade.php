@props([
    'name' => 'file',
    'label' => 'Upload File',
    'accept' => 'image/*',
    'defaultImage' => '',
])

<div
    x-data="{
        fileName: '',
        previewUrl: '{{ $defaultImage }}',
        isImage: '{{ Str::startsWith($accept, 'image') ? 'true' : 'false' }}' === 'true',
        updatePreview(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                if (this.isImage && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => this.previewUrl = e.target.result;
                    reader.readAsDataURL(file);
                } else {
                    this.previewUrl = null;
                }
            }
        },
        removeFile() {
            this.previewUrl = null;
            this.fileName = '';
            $refs.input.value = null;
        }
    }"
    class="space-y-2"
>
    <label class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>

    <div
        class="relative flex flex-col items-center justify-center px-4 py-6 border-2 border-dashed rounded-lg transition-all cursor-pointer hover:border-blue-400 focus-within:outline-none"
        :class="previewUrl ? 'bg-gray-100 border-transparent' : 'border-gray-300'"
        @click="$refs.input.click()"
    >
        <input
            x-ref="input"
            type="file"
            id="{{ $name }}"
            name="{{ $name }}"
            accept="{{ $accept }}"
            class="hidden"
            @change="updatePreview"
        >

        <!-- Placeholder (icon + text) -->
        <template x-if="!previewUrl">
            <div class="flex flex-col items-center text-gray-500">
                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 16.5V8a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v8.5M16 12l-4-4m0 0l-4 4m4-4v12"/>
                </svg>
                <p class="text-sm">
                    <span x-text="fileName || 'Klik atau seret file ke sini'"></span>
                </p>
            </div>
        </template>

        <!-- Preview Image -->
        <template x-if="previewUrl">
            <div class="relative w-full h-44">
                <img :src="previewUrl" alt="Preview"
                     class="w-full h-full object-contain rounded border shadow" />
                <div class="absolute top-0 right-0 m-1">
                    <button
                        type="button"
                        class="bg-white p-1 rounded-full border hover:bg-red-100 shadow"
                        @click.stop="removeFile"
                    >
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="absolute bottom-0 left-0 right-0 px-2 py-1 bg-black bg-opacity-40 text-white text-xs text-center truncate">
                    <span x-text="fileName || previewUrl.split('/').pop()"></span>
                </div>
            </div>
        </template>
    </div>
</div>
