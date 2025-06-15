<header class="py-10 fixed w-full top-0 z-50 transition-all duration-300"
    :class="{'bg-white shadow-lg': open,'bg-[--primary] py-5 shadow-sm': scroll}" x-data="{ open: false ,scroll :false}"
    x-init="window.addEventListener('scroll', () => { scroll = window.pageYOffset > 100 })">
    <!-- <header class="py-4 fixed w-full top-0 shadow-sm z-50 bg-[--primary]" x-data="{ open: false }"> -->
    <div class="container mx-auto flex justify-between items-center px-4">
        <!-- Logo -->
        <a href="/" class="text-lg">
            <img class="rounded-md w-24"
                src="{{ asset('assets/' . (Helpers::pengaturan()->logo_horizontal ? "/logos/" . Helpers::pengaturan()->logo_horizontal : "image/default-2.png")) }}"
                alt="Logo">
        </a>

        <!-- Desktop Navigation -->
        <!-- <nav class="hidden md:flex">
            <ul class="flex gap-10">
                <li><a class="text-sm text-gray-100 hover:text-white" href="/beranda">Beranda</a></li>
                <li><a class="text-sm text-gray-100 hover:text-white" href="/esurat-mobile">E-Surat Mobile</a></li>
                <li><a class="text-sm text-gray-100 hover:text-white" href="/berita">Berita</a></li>
            </ul>
        </nav> -->
        <nav class="hidden md:flex">
            <ul class="flex gap-10">
                <li><a class="text-sm text-gray-700 hover:text-gray-800"
                        :class="{'text-white hover:text-white': scroll}" href="/">Beranda</a></li>
                <li><a class="text-sm text-gray-700 hover:text-gray-800"
                        :class="{'text-white hover:text-white': scroll}" href="/esurat-mobile">E-Surat Mobile</a></li>
                <li><a class="text-sm text-gray-700 hover:text-gray-800"
                        :class="{'text-white hover:text-white': scroll}" href="/berita">Berita</a></li>
                @if (auth()->check())
                    <li><a class="text-sm text-gray-700 hover:text-gray-800"
                            :class="{'text-white hover:text-white': scroll}" href="/c/admin/dashboard">Dashboard</a></li>
                @else
                    <li><a class="text-sm text-gray-700 hover:text-gray-800"
                            :class="{'text-white hover:text-white': scroll}" href="/login">Login</a></li>
                @endif
            </ul>
        </nav>

        <!-- Hamburger Button -->
        <button @click="open = !open" class="md:hidden focus:outline-none" aria-label="Toggle Menu">
            <svg x-show="!open" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
            <svg x-show="open" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <nav x-show="open" x-transition class="absolute top-full left-0 w-full h-screen bg-white shadow-md md:hidden">
        <ul class="flex flex-col gap-4 p-4">
            <li><a class="block text-sm text-gray-600 hover:text-gray-900" href="/">Beranda</a></li>
            <li><a class="block text-sm text-gray-600 hover:text-gray-900" href="/download">E-Surat Mobile</a></li>
            <li><a class="block text-sm text-gray-600 hover:text-gray-900" href="/berita">Berita</a></li>
            @if (auth()->check())
                <li><a class="block text-sm text-gray-600 hover:text-gray-900" href="/c/admin/dashboard">Dashboard</a></li>
            @else
                <li><a class="block text-sm text-gray-600 hover:text-gray-900" href="/login">Login</a></li>
            @endif
        </ul>
    </nav>
</header>
