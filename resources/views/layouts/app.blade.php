<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(isset($title))
        {{ $title }}
        @endif
        {{ config('app.name', 'SiBADEAN') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" antialiased">
    <x-loading />
    <div class="min-h-screen  flex" x-data="{sidebarOpen : false}">
        @include('layouts.sidebar')
        <!-- Page Content -->
        <main class="w-full bg-white">
            @include('layouts.navigation')
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{asset("assets/js/datatable/datatable.js")}}"></script>
    <script src="{{asset("assets/js/datatable/tailwind.js")}}"></script>
    <script src="{{asset("assets/js/datatable/tailwind-all.js")}}"></script>



    @if(isset($script))
    {{ $script }}
    @endif

    <script>
        const primary = "{{auth()->user()->pengaturan()->primary_color }}";
        document.documentElement.style.setProperty('--primary', primary);

        $(".preview-image").find("input[type=file]").on("change", function() {
            const file = this.files[0];
            const url = URL.createObjectURL(file);
            $(this).parent().find("img").attr("src", url)

        })
    </script>

</body>

</html>