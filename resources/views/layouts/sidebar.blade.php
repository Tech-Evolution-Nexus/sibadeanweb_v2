<aside class=" md:min-w-[300px] md:sticky md:left-0 min-w-full h-screen overflow-auto   fixed top-0 border-r  z-10  transition-all  flex flex-col bg-white hide-scroll" :class="{'left-[-100%]': ! sidebarOpen, 'left-0': sidebarOpen }">
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
        <span class="text-sm block">{{auth()->user()->name}}</span>
        <span class="text-sm text-slate-600">{{auth()->user()->role}}</span>
    </div>
    </div>
    </div> --}}




    <div class="flex px-4 py-4 gap-2  flex-col flex-grow justify-between">
        <ul class="">
            <li class="fi-sidebar-item-label flex-1 my-2 truncate text-sm font-medium text-primary-600 dark:text-primary-400">
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("dashboard")}}" class="block   px-2 py-1 {{request()->is('c/*/dashboard') ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}} transition-all   rounded-md text-sm flex items-center gap-2"><i class="fa w-[30px] fa-border-all text-lg"></i> Dashboard</a>
            </li>
            {{-- <hr class="block mt-6 mb-2 border-slate-300"> --}}
            <li class="fi-sidebar-item-label flex-1 my-2 truncate text-sm font-medium text-primary-600 dark:text-primary-400" x-data="{ isCollapse: true }">
                <div @click="isCollapse = !isCollapse" class="flex justify-between items-center text-gray-800 transition-all">
                    <div class="   px-2 py-1  transition-all   rounded-md text-sm flex items-center gap-2"><i class="fa w-[30px] fa-envelope text-lg"></i> Surat Masuk</div>
                    <i class="fa transition-transform duration-300" :class="{'fa-chevron-down': isCollapse, 'fa-chevron-up': !isCollapse}"></i>
                </div>
                <!-- Dropdown dengan animasi height -->
                <ul class="overflow-hidden transition-all duration-300 ease-in-out px-4"
                    :class="isCollapse ? 'max-h-[500px] opacity-100 mt-4' : 'max-h-0 opacity-0'">
                    <li>
                        <a href="{{ route('pengajuan-surat.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium {{request()->routeIs("pengajuan-surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <div class="">
                                <i class="fa fa-circle {{request()->routeIs("pengajuan-surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Menunggu Persetujuan
                            </div>
                            <span class=" items-center rounded-md bg-gray[--primary] px-2 py-1 text-xs font-medium text-[--primary] ring-1 ring-[--primary] ring-inset ms-auto {{Helpers::getCountPengajuan()->countMenungguPengajuan ? "inline-flex":"hidden"}}">{{Helpers::getCountPengajuan()->countMenungguPengajuan}}</span>

                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pengajuan-surat-rt.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium {{request()->routeIs("pengajuan-surat-rt.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("pengajuan-surat-rt.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Disetujui Rt
                        </a>
                    </li>
                </ul>
            </li>
            <li class="fi-sidebar-item-label flex-1 my-2 truncate text-sm font-medium text-primary-600 dark:text-primary-400">
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("surat-keluar.index")}}" class="block   px-2 py-1 {{request()->is('c/*/surat-keluar') ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}} transition-all   rounded-md text-sm flex items-center gap-2"><i class="fa w-[30px] fa-envelope text-lg"></i> Surat Keluar</a>
            </li>

            {{-- <hr class="block mt-6 mb-2 border-slate-300"> --}}
            <li class="mt-6 mb-6 cursor-pointer" x-data="{ isCollapse: true }">
                <!-- Header -->
                <div @click="isCollapse = !isCollapse" class="flex justify-between items-center text-gray-800 transition-all">
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
                        <a href="{{ route('lampiran.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("lampiran.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle text-gray-400 text-[6px] w-6"></i>Lampiran
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('format-surat.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("format-surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("format-surat.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> Format Surat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("faq.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle {{request()->routeIs("faq.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-gray-400'}} text-[6px] w-6"></i> FAQ
                        </a>
                    </li>
                </ul>
            </li>
            <li class="mt-6 mb-6 cursor-pointer" x-data="{ isCollapse: true }">
                <!-- Header -->
                <div @click="isCollapse = !isCollapse" class="flex justify-between items-center text-gray-800 transition-all">
                    <span class="text-sm font-medium">Pengaturan</span>
                    <i class="fa transition-transform duration-300" :class="{'fa-chevron-down': isCollapse, 'fa-chevron-up': !isCollapse}"></i>
                </div>

                <!-- Dropdown dengan animasi height -->
                <ul class="overflow-hidden transition-all duration-300 ease-in-out mt-4"
                    :class="isCollapse ? 'max-h-[500px] opacity-100' : 'max-h-0 opacity-0'">
                    <li>
                        <a href="{{ route('petugas.index') }}"
                            class="flex  px-2 py-2 rounded-md text-sm  items-center gap-2  hover:bg-gray-100 transition-all font-medium  {{request()->routeIs("petugas.index") ? 'text-[var(--primary)] bg-gray-100' : 'text-slate-700 md:hover:bg-gray-100'}}">
                            <i class="fa fa-circle text-gray-400 text-[6px] w-6"></i> Petugas
                        </a>
                    </li>
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
            </li>


        </ul>
    </div>
</aside>