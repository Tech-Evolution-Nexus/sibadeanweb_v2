@extends("layouts.frontend.front")

@section("content")
<section class="">
    <div class="container min-h-screen flex justify-start md:mt-28 mt-24 flex-col">
        <div class="text-center">
            <h6 class="text-md ">E-SURAT BADEAN </h6>
            <h1 class="text-4xl font-bold mb-4 ">Bikin Surat Lebih mudah dan Cepat</h1>
            <p class="text-sm max-w-4xl mx-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim a perspiciatis earum exercitationem et est qui quidem voluptatibus iusto excepturi! Enim a perspiciatis earum exercitationem et est qui quidem voluptatibus iusto excepturi!</p>
            <a class="px-4 py-2 bg-[--primary] rounded-md text-white inline-block mt-6 cursor-pointer ">Download app</a>

            <img src="{{ asset("assets/image/hero.png") }}" class="md:max-w-3xl rounded-md mx-auto mt-10  drop-shadow-lg" alt="">
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h1 class="text-4xl font-bold text-center mb-4">Fitur Utama </h1>
        <p class="text-sm md:max-w-4xl mx-auto text-center">
            Kelola surat-menyurat dengan lebih cepat, mudah, dan efisien! Aplikasi kami dirancang untuk membantu Anda membuat, mengirim, dan mengelola surat secara digital tanpa ribet. Dengan berbagai fitur canggih, Anda dapat memastikan setiap dokumen tersusun rapi, terkirim tepat waktu, dan tetap aman
        </p>
        <div class="grid md:grid-cols-2 grid-cols-1 gap-6 max-w-4xl mx-auto mt-6">
            <article class="border rounded-md p-6 text-center shadow-sm hover:shadow-lg transition-all">
                <img class="w-40 mx-auto mb-3" src="{{ asset('assets/image/approval.webp') }}" alt="Surat Cepat">
                <h6 class="text-lg font-semibold">Kecepatan Penyetujuan Surat</h6>
                <p class="text-sm text-gray-600 mt-2">Proses persetujuan surat lebih cepat dengan sistem otomatis yang efisien.</p>
            </article>
            <article class="border rounded-md p-6 text-center shadow-sm hover:shadow-lg transition-all">
                <img class="w-40 mx-auto mb-3" src="{{ asset('assets/image/letter-animate.webp') }}" alt="Tracking Real-Time">
                <h6 class="text-lg font-semibold">Lacak Surat Secara Real-Time</h6>
                <p class="text-sm text-gray-600 mt-2">Pantau status surat Anda dari pengajuan hingga diterima dengan transparansi penuh.</p>
            </article>
            <article class="border rounded-md p-6 text-center shadow-sm hover:shadow-lg transition-all">
                <img class="w-40 mx-auto mb-3" src="{{ asset('assets/image/secure.webp') }}" alt="Keamanan Data">
                <h6 class="text-lg font-semibold">Keamanan Data Terjamin</h6>
                <p class="text-sm text-gray-600 mt-2">Setiap surat terenkripsi dengan standar keamanan tinggi untuk menjaga kerahasiaan dokumen.</p>
            </article>
            <article class="border rounded-md p-6 text-center shadow-sm hover:shadow-lg transition-all">
                <img class="w-40 mx-auto mb-3" src="{{ asset('assets/image/cloud.webp') }}" alt="Akses Mudah">
                <h6 class="text-lg font-semibold">Akses dari Mana Saja</h6>
                <p class="text-sm text-gray-600 mt-2">Kelola dan akses surat kapan saja, di perangkat apa pun dengan sistem berbasis cloud.</p>
            </article>
        </div>

    </div>
</section>
<script>
    const primary = "{{$pengaturan->primary_color }}";
    document.documentElement.style.setProperty('--primary', primary);
</script>
@endsection
