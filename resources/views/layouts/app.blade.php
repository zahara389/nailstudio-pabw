<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Premium Nail Art Studio')</title>

    {{-- Fonts & Core Scripts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    {{-- Global Styles --}}
    <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    
    @livewireStyles
    @stack('styles') {{-- Tempat CSS Khusus Halaman --}}
</head>

<body id="ns-body" class="@yield('body-class', '')">

    <livewire:navbar />

    {{-- Bagian ini akan diisi oleh konten dari halaman payment --}}
    <main>
        @yield('content')
    </main>

    <livewire:footer />

    @livewireScripts
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/landing_page_logic.js') }}"></script>
    
    @stack('scripts') {{-- Tempat Script Khusus Halaman --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) lucide.createIcons();
        });
    </script>

    {{-- Alert Sessions --}}
    @if (session('alert'))
        <script>alert("{{ session('alert') }}");</script>
    @endif
</body>
</html>