<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Tanda Tangan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>



    <form method="post" action="{{ route('profile.ttd') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            {{-- <x-input-label for="ttd" :value="__('Name')" /> --}}
            <x-file-upload id="ttd" name="ttd" :label="'Tanda Tangan'" :defaultImage="$user->ttd ? route('private.image', ['path' => $user->ttd]) : 'https://dummyimage.com/80x80/f2f2f2/555555&text=No+Image'" class="mt-1 block w-full" required autofocus
                autocomplete="ttd" />
            <x-input-error class="mt-2" :messages="$errors->get('ttd')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'ttd-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
