@extends("layouts.frontend.front")

@section("content")<section class="py-16 relative">
        <div class="container mx-auto text-center mt-8">
            <div class="bg-[--primary] rounded-lg p-8 shadow-lg">
                <h1 class="text-white text-4xl font-bold">Berita Terbaru</h1>
                <p class="text-white  mt-2 ">Tetap update dengan berita terkini seputar Kelurahan Badean</p>
            </div>
        </div>
    </section>

    <section class="py-16 relative">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
                @foreach ($berita as $b)
                    <article class="border rounded-lg overflow-hidden  transition-all duration-500  hover:shadow-xl">
                        <a href="/berita/{{ $b->slug }}">
                            <img src="{{ url("/c/private-image?path=$b->gambar") }}" class="w-full aspect-video object-cover"
                                alt="{{ $b->judul }}">
                            <div class="p-4">
                                <h6 class="text-lg font-semibold text-gray-900">{{ $b->judul }}</h6>
                                <p class="text-gray-600 text-sm mt-1 line-clamp-2">{!! $b->keterangan  !!}</p>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>


    <script>
        const primary = "{{Helpers::pengaturan()->primary_color }}";
        document.documentElement.style.setProperty('--primary', primary);
    </script>
@endsection
