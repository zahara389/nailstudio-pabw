<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Premium Nail Art Studio')</title>

    {{-- GLOBAL CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">

    @livewireStyles
    @stack('styles')
</head>

<body id="ns-body" class="@yield('body-class', '')">

    {{-- NAVBAR --}}
    <livewire:navbar />

    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <livewire:footer />

    @stack('scripts')

    @livewireScripts

    <script src="{{ asset('js/landing_page_logic.js') }}"></script>

    <script>
        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) lucide.createIcons();
        });
    </script>

    {{-- POPUP SUKSES / ERROR --}}
    @if (session('alert'))
        <script>
            alert("{{ session('alert') }}");
        </script>
    @endif

    {{-- POPUP -> REDIRECT LOGIN --}}
    @if (session('alert_login'))
        <script>
            alert("{{ session('alert_login') }}");
            window.location.href = "{{ route('login') }}";
        </script>
    @endif

</body>
</html>
