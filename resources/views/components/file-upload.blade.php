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
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result;
                    };
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
    <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>

    <!-- Dropzone style box -->
    <div
        class="relative flex flex-col items-center overflow-hidden justify-center  rounded-lg px-4  text-center cursor-pointer  transition h-44 "
        :class="previewUrl ? 'border-transparent bg-gray-900' : 'border-gray-300 hover:border-blue-500 border-2 border-dashed'"
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

        <!-- Icon -->
        <svg x-show="!previewUrl" class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 16.5V8a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v8.5M16 12l-4-4m0 0l-4 4m4-4v12" />
        </svg>
        <p x-show="!previewUrl" class="text-sm text-gray-600" x-show="fileName || defaultImage" x-text="fileName || 'Klik untuk memilih file'"></p>
        <div
        x-show="previewUrl"
        class="absolute inset-0 w-full h-10 px-4 z-10 flex justify-between items-center py-2
               bg-gradient-to-b from-green-400 to-transparent backdrop-blur-sm"
    >

       <span x-text="fileName || (previewUrl ? previewUrl.split('/').pop() : '')" class="text-white text-xs"></span>

    <button
                type="button"
                class="bg-white border border-gray-300 rounded-full p-1 hover:bg-red-100 "
                @click.stop="removeFile"
            >
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
</div>
        <template x-if="previewUrl">
            <div class=" relative h-full">
                <img :src="previewUrl" alt="Preview" class="w-36 h-full object-contain rounded border" />

            </div>
        </template>
    </div>
</div>
