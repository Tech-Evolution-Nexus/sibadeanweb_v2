<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)"
    x-show="show"
    x-transition:leave="transition-opacity duration-500 ease-out"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="bg-white flex items-center h-full w-full flex-col justify-center fixed z-[999]">
    <!-- Logo -->
    <img src="{{ asset('assets/logos/'.Helpers::pengaturan()->logo_horizontal) }}" alt="Logo" class="mb-4 w-[150px]">

    <!-- Spinner menggunakan Tailwind CSS -->
    <div class="loading flex items-center gap-4">
        <!-- Loader Spinner -->
        <div class="loader border-t-4 border-solid  border-gray-300 rounded-full w-10 h-10 animate-spin border-t-[--primary]"></div>
        <span>Loading...</span>
    </div>
</div>

<!-- Styling tambahan -->
<style>
    /* Custom Tailwind CSS spinner */
    .loader {
        border-width: 4px;
        border-top-width: 4px;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Animasi untuk putar */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>