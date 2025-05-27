@extends('layouts.frontend.front')

@section('content')
    <section class="py-16 relative mt-8">
        <div class="container mx-auto ">
            <div class="grid md:grid-cols-6 grid-cols-1 md:gap-10 gap-6">
                <div class="md:col-span-4">
                    <div class="text-center">
                        <h1 class="text-2xl mt-4 font-semibold text-center">{{ $berita->judul }}</h1>
                        <span class="text-gray-500 text-sm">{{ Helpers::formatDate($berita->created_at, true) }}</span>
                    </div>
                    <img src="{{ asset($berita->gambar) }}" alt="{{ $berita->judul }}"
                        class="w-full mx-auto object-cover aspect-video rounded-md my-6">
                    <p class="prose lg:prose-base max-w-full">{!! $berita->konten !!}</p>

                </div>
                <div class="md:col-span-2 ">
                    <div class="flex flex-col gap-4 items-start">
                        @foreach ($beritaTerbaru as $bt)
                            <a href="/berita/{{ $bt->slug }}">
                                <article class="flex gap-4  items-start ">
                                    <img src="{{url("/c/private-image?path=$bt->gambar") }}" alt="{{ $bt->judul }}"
                                        class="w-40 mx-auto aspect-video object-cover rounded-md ">
                                    <div class="">
                                        <h3 class="text-lg mb-4 font-semibold line-clamp-3">{{ $bt->judul }}</h3>
                                        <span
                                            class="text-gray-500 text-sm">{{ Helpers::formatDate($bt->created_at, true) }}</span>
                                    </div>
                                </article>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        const primary = "{{ Helpers::pengaturan()->primary_color }}";
        document.documentElement.style.setProperty('--primary', primary);
    </script>
@endsection
