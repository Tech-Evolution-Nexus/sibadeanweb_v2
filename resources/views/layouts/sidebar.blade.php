<<<<<<< Updated upstream
<<<<<<< Updated upstream
<aside class=" md:min-w-[300px] md:sticky md:left-0 min-w-full h-screen  fixed top-0   z-10 md:bg-gray-100 transition-all flex flex-col bg-slate-200" :class="{'left-[-100%]': ! sidebarOpen, 'left-0': sidebarOpen }">
=======
<aside class=" md:min-w-[300px] md:sticky md:left-0 min-w-full h-screen overflow-auto  fixed top-0 shadow-lg  z-10  transition-all  flex flex-col bg-white" :class="{'left-[-100%]': ! sidebarOpen, 'left-0': sidebarOpen }">
>>>>>>> Stashed changes
=======
<aside class=" md:min-w-[300px] md:sticky md:left-0 min-w-full h-screen overflow-auto  fixed top-0 shadow-lg  z-10  transition-all  flex flex-col bg-white" :class="{'left-[-100%]': ! sidebarOpen, 'left-0': sidebarOpen }">
>>>>>>> Stashed changes
    <div class="logo p-4 flex justify-between">
        <a href="{{ route('dashboard') }}">
            <img src="{{asset(auth()->user()->pengaturan()->logo_horizontal? "assets/logos/".auth()->user()->pengaturan()->logo_horizontal:"image/default-2.png" )}}" alt="" class="h-[40px]">
        </a>
        <button @click="sidebarOpen = ! sidebarOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- <div class=" px-4 ">
        <div class="flex gap-2 items-center bg-gray-200 w-full p-2 rounded-md">
            <img src="{{asset("assets/image/".auth()->user()->avatar)}}" alt="profile image" class="w-[50px] h-[50px] rounded-full bg-gray-200">
            <div class="">
                <span class="text-base block">{{auth()->user()->name}}</span>
                <span class="text-sm text-slate-600">{{auth()->user()->role}}</span>
            </div>
        </div>
    </div> --}}

<<<<<<< Updated upstream
<<<<<<< Updated upstream
    <div class="flex px-4 py-4  flex-col flex-grow justify-between">
        <ul class=" ">
            <li>
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("dashboard")}}" class="block   px-4 py-2 {{request()->is('c/*/dashboard') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2"><i class="fa w-[30px] fa-border-all text-lg"></i> Dashboard</a>
            </li>
            <hr class="block mt-6 mb-2 border-slate-300">
            <li>
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("pengajuan-surat.index")}}" class="block   px-4 py-2 {{request()->is("c/*/pengajuan-surat") ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2"><i class="fa w-[30px] fa-border-all text-lg"></i> Surat Masuk</a>
            </li>
            <li>
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("pengajuan-surat.index")}}" class="block   px-4 py-2 {{request()->is(route("pengajuan-surat.index")) ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2"><i class="fa w-[30px] fa-border-all text-lg"></i> Surat Keluar</a>
            </li>
            <hr class="block mt-6 mb-2 border-slate-300">
            <li>
                <span class="text-lg text-gray-600 block mb-2">Master Data</span>
                <ul>
                    <li>
                        <a href="{{route("rw.index")}}" class="block  px-4 py-2 {{request()->is('c/*/rw*') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2 "><i class="fa w-[30px] fa-users text-lg"></i> RT & RW</a>
                    </li>
                    <li>
                        <a href="{{route("kartu-keluarga.index")}}" class="block  px-4 py-2 {{request()->is('c/*/kartu-keluarga*') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2 "><i class="fa w-[30px] fa-list text-lg"></i> Kartu Keluarga</a>
                    </li>
                    <li>
                        <a href="{{route("users.index")}}" class="block  px-4 py-2 {{request()->is('c/*/users*') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2 "><i class="fa w-[30px] fa-users text-lg"></i> Users</a>
                    </li>
                    <li>
                        <a href="{{route("surat.index")}}" class="block  px-4 py-2 {{request()->is('c/*/surat*') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2 "><i class="fa w-[30px] fa-envelope text-lg"></i> Surat</a>
                    </li>
                    <li>
                        <a href="{{route("berita.index")}}" class="block  px-4 py-2 {{request()->is('c/*/berita*') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2 "><i class="fa w-[30px] fa-newspaper text-lg"></i> Berita</a>
                    </li>
                </ul>
            </li>
            <hr class="block mt-6 mb-2 border-slate-300">

            <li>
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("setting.index")}}" class="block   px-4 py-2 {{request()->is('c/*/setting') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80 '}} transition-all  rounded-md text-base flex items-center gap-2"><i class="fa w-[30px] fa-gear text-lg"></i> Pengaturan</a>
=======
    <div class="flex px-4 py-4 gap-2  flex-col flex-grow justify-between">
        <ul class="">
            <li class="fi-sidebar-item-label flex-1 my-2 truncate text-sm font-medium text-primary-600 dark:text-primary-400">
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
=======
    <div class="flex px-4 py-4 gap-2  flex-col flex-grow justify-between">
        <ul class="">
            <li class="fi-sidebar-item-label flex-1 my-2 truncate text-sm font-medium text-primary-600 dark:text-primary-400">
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
>>>>>>> Stashed changes
                <a href="{{route("dashboard")}}" class="block   px-2 py-1 {{request()->is('c/*/dashboard') ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}} transition-all   rounded-md text-sm flex items-center gap-2"><i class="fa w-[30px] fa-border-all text-lg"></i> Dashboard</a>
            </li>
            {{-- <hr class="block mt-6 mb-2 border-slate-300"> --}}
            <li class="fi-sidebar-item-label flex-1 my-2 truncate text-sm font-medium text-primary-600 dark:text-primary-400">
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("pengajuan-surat.index")}}" class="block   px-2 py-1 {{request()->is('c/*/pengajuan-surat') ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}} transition-all   rounded-md text-sm flex items-center gap-2"><i class="fa w-[30px] fa-envelope text-lg"></i> Surat Masuk</a>
            </li>
            <li class="fi-sidebar-item-label flex-1 my-2 truncate text-sm font-medium text-primary-600 dark:text-primary-400">
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("pengajuan-surat.index")}}" class="block   px-2 py-1 {{request()->is('c/*/pengajuan-surat') ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}} transition-all   rounded-md text-sm flex items-center gap-2"><i class="fa w-[30px] fa-envelope text-lg"></i> Surat Keluar</a>
            </li>

            {{-- <hr class="block mt-6 mb-2 border-slate-300"> --}}
            <li class="mt-6 mb-6 cursor-pointer" x-data="{ isCollapse: true }">
                <!-- Header -->
                <div @click="isCollapse = !isCollapse" class="flex justify-between items-center text-gray-400 hover:text-gray-800 transition-all">
                    <span class="text-sm font-medium ">Master Data</span>
                    <i class="fa transition-transform duration-300" :class="{'fa-chevron-down': isCollapse, 'fa-chevron-up': !isCollapse}"></i>
                </div>

                <!-- Dropdown dengan animasi height -->
                <ul class="overflow-hidden transition-all duration-300 ease-in-out "
                    :class="isCollapse ? 'max-h-[500px] opacity-100 mt-4' : 'max-h-0 opacity-0'">

                    <li>
                        <a href="{{ route('rw.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium {{request()->routeIs("rw.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("rw.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> RT & RW
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kartu-keluarga.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium {{request()->routeIs("kartu-keluarga.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("kartu-keluarga.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Kartu Keluarga
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium {{request()->routeIs("users.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("users.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surat.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Surat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('berita.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("berita.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("berita.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Berita
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('format-surat.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("format-surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("format-surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Format Surat
                        </a>
                    </li>
                </ul>
            </li>
            <li class="mt-6 mb-6 cursor-pointer" x-data="{ isCollapse: true }">
                <!-- Header -->
                <div @click="isCollapse = !isCollapse" class="flex justify-between items-center text-gray-400 hover:text-gray-800 transition-all">
                    <span class="text-sm font-medium">Pengaturan</span>
                    <i class="fa transition-transform duration-300" :class="{'fa-chevron-down': isCollapse, 'fa-chevron-up': !isCollapse}"></i>
                </div>
                <!-- Dropdown dengan animasi height -->
                <ul class="overflow-hidden transition-all duration-300 ease-in-out mt-4"
                    :class="isCollapse ? 'max-h-[500px] opacity-100' : 'max-h-0 opacity-0'">

                    <li>
                        <a href="{{ route('setting.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("setting.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle text-gray-400 text-[6px] w-6"></i> Tampilan
                        </a>
                    </li>
                    <li>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class=" flex text-start  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium w-full "><i class="fa fa-circle text-gray-400 text-[6px] w-6"></i> Logout</button>

                        </form>
                    </li>
                </ul>
>>>>>>> Stashed changes
            </li>
        </ul>
        <ul>
            <li>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class=" md:shadow-sm px-4 py-2 text-slate-700 md:bg-white/80 bg-gray-100  transition-all  rounded-md text-base flex w-full items-center gap-2 "><i class="fa w-[30px] fa-arrow-right-from-bracket  text-lg"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
</aside>
