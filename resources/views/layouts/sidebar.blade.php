<aside class=" md:min-w-[300px] md:sticky md:left-0 min-w-full h-screen  fixed top-0   z-10 md:bg-gray-100 transition-all flex flex-col bg-slate-200" :class="{'left-[-100%]': ! sidebarOpen, 'left-0': sidebarOpen }">
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

    <div class=" px-4 ">
        <div class="flex gap-2 items-center bg-gray-200 w-full p-2 rounded-md">
            <img src="{{asset("assets/image/".auth()->user()->avatar)}}" alt="profile image" class="w-[50px] h-[50px] rounded-full bg-gray-200">
            <div class="">
                <span class="text-base block">{{auth()->user()->name}}</span>
                <span class="text-sm text-slate-600">{{auth()->user()->role}}</span>
            </div>
        </div>
    </div>

    <div class="flex px-4 py-4  flex-col flex-grow justify-between">
        <ul class=" ">
            <li>
                <!-- <span class="text-lg text-gray-600 block mb-2">Dashboard</span> -->
                <a href="{{route("dashboard")}}" class="block   px-4 py-2 {{request()->is('c/*/dashboard') ? 'bg-[var(--primary)] text-white' : 'text-slate-700 md:hover:bg-white/80'}} transition-all  rounded-md text-base flex items-center gap-2"><i class="fa w-[30px] fa-border-all text-lg"></i> Dashboard</a>
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