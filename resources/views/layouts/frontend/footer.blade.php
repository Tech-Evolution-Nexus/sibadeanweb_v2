<footer class="border-t">
    <div class="container py-10">
        <div class="grid md:grid-cols-2 grid-cols-1 items-end gap-4">
            <div class="">
                <h6 class="text-2xl"><img class="rounded-md w-24" src="{{ asset('assets/'.($pengaturan->logo_horizontal?"/logos/$pengaturan->logo_horizontal":"image/default-2.png")) }}" alt="Logo"></h6>
                <p class="text-sm mt-2">Aplikasi pengelolaan surat kelurahan yang memudahkan warga dalam pembuatan dan pengajuan surat secara digital. Hemat waktu, efisien, dan tanpa ribet!

                </p>
            </div>
            <span class="ms-auto text-sm">
                <i class="fa fa-copyright"></i> {{ date("Y") }} {{ config('app.name') }}
            </span>
        </div>
        <ul class="flex gap-10 mt-4 justify-end">
            <li><a class="text-sm text-gray-600 hover:text-gray-900" href="/beranda">Beranda</a></li>
            <li><a class="text-sm text-gray-600 hover:text-gray-900" href="/esurat-mobile">E-Surat Mobile</a></li>
            <li><a class="text-sm text-gray-600 hover:text-gray-900" href="/berita">Berita</a></li>
        </ul>
    </div>
</footer>
