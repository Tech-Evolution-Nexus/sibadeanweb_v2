@extends("layouts.frontend.front")

@section("content")
<section class="bg-gray-50 py-16">
    <div class="container min-h-screen flex justify-start md:mt-28 mt-24 flex-col">
        <div class="text-center">
            <h6 class="text-md font-semibold text-gray-600">{{config('app.name')}}</h6>
            <h1 class="text-4xl font-bold mb-4 text-gray-800">Bikin Surat Lebih Mudah dan Cepat</h1>
            <p class="text-sm max-w-4xl mx-auto text-gray-600">
                Aplikasi pengelolaan surat kelurahan yang memudahkan warga dalam pembuatan dan pengajuan surat secara digital.
                Hemat waktu, efisien, dan tanpa ribet!
            </p>
            <div class="mt-6">
                <a href="#ajukan" class="px-6 py-3 bg-[--primary] rounded-md text-white inline-block shadow-md hover:bg-opacity-80 transition-all cursor-pointer">
                    Ajukan Surat Sekarang
                </a>
                <a href="#fitur" class="px-6 py-3 bg-gray-200 rounded-md text-gray-700 inline-block ml-3 hover:bg-gray-300 transition-all cursor-pointer">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            <img src="{{ asset("assets/image/hero.png") }}" class="md:max-w-3xl rounded-md mx-auto mt-10 drop-shadow-lg" alt="">
        </div>
    </div>
</section>

<section id="tentang" class="py-16 bg-white">
    <div class="container grid md:grid-cols-2 grid-cols-1 gap-10 items-center">
        <img src="{{ asset('assets/image/badean.jpg') }}" class="rounded-lg shadow-lg w-full object-cover" alt="Desa Badean">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Tentang Desa Badean</h2>
            <p class="text-gray-600 mt-4 text-sm">
                Desa Badean adalah desa yang terletak di wilayah strategis dengan berbagai potensi sumber daya alam dan budaya. Dengan adanya sistem digitalisasi surat, Desa Badean kini lebih modern dan efisien dalam pelayanan administrasi kepada masyarakat.
            </p>
        </div>
    </div>
</section>

<section id="fitur" class="py-16">
    <div class="container">
        <h1 class="text-4xl font-bold text-center mb-4">Fitur Utama</h1>
        <p class="text-sm md:max-w-4xl mx-auto text-center text-gray-600">
            Kelola surat-menyurat dengan lebih cepat, mudah, dan efisien!
            Aplikasi ini dirancang untuk membantu warga membuat, mengirim, dan mengelola surat secara digital tanpa ribet.
        </p>
        <div class="grid md:grid-cols-2 grid-cols-1 gap-6 max-w-5xl mx-auto mt-6">
            @foreach($fitur as $item)
            <article class="border rounded-md p-6 text-center shadow-sm hover:shadow-lg transition-all bg-white">
                <img class="w-24 mx-auto mb-3" src="{{ asset('assets/image/'.$item->icon) }}" alt="{{ $item->nama }}">
                <h6 class="text-lg font-semibold text-gray-800">{{ $item->nama }}</h6>
                <p class="text-sm text-gray-600 mt-2">{{ $item->deskripsi }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<section id="demo" class="py-16 bg-gray-50">
    <div class="container text-center">
        <h1 class="text-4xl font-bold mb-4 text-gray-800">Demo Aplikasi</h1>
        <p class="text-sm md:max-w-4xl mx-auto text-gray-600">
            Lihat bagaimana E-Surat Badean bekerja! Tonton video demo atau coba langsung aplikasi ini.
        </p>
        <div class="mt-6">
            <iframe class="w-full max-w-3xl mx-auto h-64 md:h-96 shadow-md rounded-md" src="https://www.youtube.com/embed/video_id" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="container">
        <h2 class="text-3xl font-bold text-center text-gray-800">Pertanyaan Umum</h2>
        <div class="max-w-4xl mx-auto mt-6">
            @foreach($faq as $item)
            <details class="border-b py-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">{{ $item->pertanyaan }}</summary>
                <p class="text-sm text-gray-600 mt-2">{{ $item->jawaban }}</p>
            </details>
            @endforeach
        </div>
    </div>
</section>
<section id="demo" class="py-16 bg-gray-50">
    <div class="container text-center">
        <h2 class="text-3xl font-bold text-gray-800">Unduh Aplikasi Mobile</h2>
        <p class="text-gray-600 mt-4 text-sm max-w-3xl mx-auto">
            Nikmati kemudahan akses dalam genggaman Anda! Unduh aplikasi E-Surat Badean untuk pengalaman yang lebih cepat dan nyaman.
        </p>
        <div class="flex justify-center gap-6 mt-6">
            <a href="#" class="px-6 py-3 bg-black text-white rounded-md flex items-center gap-2 shadow-md hover:bg-opacity-80 transition-all">
                <img src="{{ asset('assets/image/playstore.png') }}" class="w-6"> Google Play
            </a>
            <a href="#" class="px-6 py-3 bg-black text-white rounded-md flex items-center gap-2 shadow-md hover:bg-opacity-80 transition-all">
                <div class="fa fa-download"></div> Unduh
            </a>
        </div>
    </div>
</section>
<script>
    const primary = "{{$pengaturan->primary_color }}";
    document.documentElement.style.setProperty('--primary', primary);
</script>
@endsection
