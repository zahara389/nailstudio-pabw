<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- Menggunakan @yield untuk title, default jika tidak didefinisikan --}}
    <title>@yield('title', 'Premium Nail Art Studio')</title>
    
    {{-- ================================================= --}}
    {{-- ASET GLOBAL & CSS --}}
    {{-- ================================================= --}}
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script> 
    
    <script src="https://unpkg.com/lucide@latest"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    
    {{-- Custom CSS Anda --}}
    <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}"> {{-- Opsional: Tambahkan jika Anda memiliki CSS footer terpisah --}}
    
    {{-- ✅ LIVEWIRE STYLE: Wajib di dalam <head> --}}
    @livewireStyles 
</head>
<body id="ns-body">

    {{-- ================================================= --}}
    {{-- 🌐 NAVBAR LIVEWIRE (Komponen Fragment) --}}
    {{-- ================================================= --}}
    <livewire:navbar />
    
    <main>
        {{-- ✅ @yield('content'): Konten spesifik dari halaman turunan --}}
        @yield('content') 
    </main>

    {{-- ================================================= --}}
    {{-- 👣 FOOTER LIVEWIRE (Komponen Fragment) --}}
    {{-- ================================================= --}}
    <livewire:footer />

    {{-- Memanggil Scripts Khusus dari halaman turunan (@push('scripts')) --}}
    @stack('scripts')

    {{-- ================================================= --}}
    {{-- SCRIPTS GLOBAL --}}
    {{-- ================================================= --}}
    
    {{-- ✅ LIVEWIRE SCRIPTS: Wajib sebelum penutup </body> --}}
    @livewireScripts

    {{-- Skrip JS Global & Kustom --}}
    <script src="{{ asset('js/nama_file_js_anda.js') }}"></script> 
    
    <script>
        // Smooth Scroll Function (global)
        function scrollToSection(id) {
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi ikon Lucide
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>