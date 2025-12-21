@extends('layouts.app')

@section('title', 'Tentang Nails Studio | Nail Salon Premium Bandung')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink-custom: #FFADBD;
            --rose-custom-light: #FFC0CB;
        }

        .font-serif-title {
            font-family: 'Playfair Display', serif;
        }

        .bg-pink-custom {
            background-color: var(--pink-custom);
        }

        .text-pink-custom {
            color: var(--pink-custom);
        }

        .from-pink-custom {
            --tw-gradient-from: var(--pink-custom) var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(255 173 189 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }

        .to-pink-custom {
            --tw-gradient-to: var(--pink-custom) var(--tw-gradient-to-position);
        }

        .fill-pink-custom {
            fill: var(--pink-custom);
        }

        .hover-shadow-pink-custom:hover {
            box-shadow: 0 20px 25px -5px rgba(255, 173, 189, 0.4);
        }

        .hero-bg-grid {
            position: absolute; inset: 0;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 32px 32px; opacity: 0.3;
            mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
            z-index: 0; pointer-events: none;
        }

        .hero-glow {
            position: absolute; top: -120px; left: 50%; transform: translateX(-50%);
            width: 700px; height: 500px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
            filter: blur(80px); z-index: 0; pointer-events: none;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
        }
    </style>
@endpush

@section('content')
<div class="w-full bg-white">
    {{-- 1. HERO SECTION --}}
    <section class="relative py-24 px-6 lg:px-12 overflow-hidden">
        <div class="hero-bg-grid"></div>
        <div class="hero-glow"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-pink-100/80 backdrop-blur-sm rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-pink-custom fill-pink-custom"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="text-xs text-pink-700 font-medium tracking-wide">Premium Nail Studio Bandung</span>
                    </div>
                    
                    {{-- Ukuran Judul Hero Diperkecil ke text-4xl --}}
                    <h3 class="text-4xl lg:text-5xl tracking-tight text-gray-900 mb-6 font-serif-title font-extrabold leading-tight">
                        Tentang
                        <span class="block bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">
                             Nails Studio
                        </span>
                    </h3>
                    
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                         Nails Studio adalah nail salon premium yang telah melayani ribuan pelanggan sejak tahun 2015. 
                        Kami menghadirkan pengalaman nail care yang berbeda - kombinasi sempurna antara seni, kenyamanan, dan profesionalisme.
                    </p>

                    <p class="text-base text-gray-600 mb-8 leading-relaxed">
                        Berlokasi strategis di pusat kota Bandung, studio kami dirancang dengan konsep modern minimalis yang nyaman. Kami berkomitmen memberikan hasil terbaik untuk Anda.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('landing.index') }}#booking" class="group px-8 py-3 bg-pink-custom text-white rounded-full hover-shadow-pink-custom hover:scale-105 transition-all flex items-center gap-2 font-bold shadow-lg text-decoration-none">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                            Book Appointment
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="#studio-gallery" class="px-8 py-3 bg-white border-2 border-pink-200 text-gray-900 rounded-full hover:border-pink-custom hover:shadow-lg transition-all font-bold text-decoration-none">
                            Lihat Gallery
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-300 to-rose-400 rounded-[3rem] rotate-3 opacity-30"></div>
                    <div class="relative rounded-[3rem] overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1619607146034-5a05296c8f9a?auto=format&fit=crop&q=80&w=1080" alt="Nails Studio Interior" class="w-full aspect-[4/5] object-cover" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. STUDIO GALLERY --}}
    <section id="studio-gallery" class="py-24 px-6 lg:px-12 bg-white content-wrapper">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                {{-- Ukuran Judul Section Diperkecil ke text-3xl --}}
                <h3 class="text-3xl lg:text-4xl tracking-tight text-gray-900 mb-4 font-serif-title font-extrabold">
                    Studio <span class="bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">Kami</span>
                </h3>
                <p class="text-lg text-gray-600">Ruang yang dirancang untuk kenyamanan maksimal Anda</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div class="relative h-80 rounded-3xl overflow-hidden group shadow-lg">
                    <img src="https://images.unsplash.com/photo-1619607146034-5a05296c8f9a?auto=format&fit=crop&q=80&w=1000" alt="Studio Interior" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-8">
                        <div class="text-white">
                            <h3 class="text-xl font-bold mb-1 font-serif-title">Treatment Area</h3>
                            <p class="text-sm text-white/80">12 premium treatment chairs</p>
                        </div>
                    </div>
                </div>

                <div class="relative h-80 rounded-3xl overflow-hidden group shadow-lg">
                    <img src="https://images.unsplash.com/photo-1626379501846-0df4067b8bb9?auto=format&fit=crop&q=80&w=1000" alt="Treatment Chair" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-8">
                        <div class="text-white">
                            <h3 class="text-xl font-bold mb-1 font-serif-title">Luxury Seating</h3>
                            <p class="text-sm text-white/80">Comfortable massage chairs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. WHY CHOOSE US --}}
    <section class="py-24 px-6 lg:px-12 bg-gradient-to-br from-pink-50 via-white to-rose-50 content-wrapper">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h3 class="text-3xl lg:text-4xl tracking-tight text-gray-900 mb-4 font-serif-title font-extrabold">
                    Kenapa Pilih <span class="bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent"> Nails Studio?</span>
                </h3>
                <p class="text-lg text-gray-600">Kami lebih dari sekedar nail salon biasa</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                @php
                    $features = [
                        ['icon' => 'sparkles', 'title' => 'Teknologi Terkini', 'desc' => 'Menggunakan peralatan terbaru.'],
                        ['icon' => 'award', 'title' => 'Artist Bersertifikat', 'desc' => 'Tim profesional bersertifikat.'],
                        ['icon' => 'heart', 'title' => 'Hygiene & Safety', 'desc' => 'Sterilisasi UV standar medis.'],
                        ['icon' => 'check-circle', 'title' => 'Hasil Maksimal', 'desc' => 'Jaminan kepuasan pelanggan.']
                    ];
                @endphp

                @foreach($features as $f)
                <div class="group p-8 rounded-3xl bg-white border border-pink-100 hover:shadow-2xl hover:shadow-pink-custom/10 hover:-translate-y-2 transition-all duration-300 text-center">
                    <div class="w-14 h-14 bg-gradient-to-r from-pink-custom to-rose-200 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:rotate-6 transition-all shadow-md">
                        <i data-lucide="{{ $f['icon'] }}" class="text-white w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 font-serif-title">{{ $f['title'] }}</h3>
                    <p class="text-gray-600 text-xs leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 5. LOCATION --}}
    <section class="py-24 px-6 lg:px-12 bg-white content-wrapper">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-3xl lg:text-4xl tracking-tight text-gray-900 mb-4 font-serif-title font-extrabold">
                    Kunjungi <span class="bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">Studio Kami</span>
                </h3>
                <p class="text-lg text-gray-600">Kami siap melayani Anda dengan sepenuh hati</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <div class="h-[400px] rounded-[2rem] overflow-hidden shadow-xl border-4 border-pink-50 relative">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15865.023473117466!2d106.8184!3d-6.2237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3fb49023533%3A0xe54497793d937a0!2sGrand%20Indonesia!5e0!3m2!1sen!2sid!4v17000000000004" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

                <div class="space-y-6">
                    <div class="relative h-48 rounded-[2rem] overflow-hidden shadow-lg group bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1560750588-73207b1ef5b8?auto=format&fit=crop&q=80&w=1000" 
                             alt="Studio suasana" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700"
                             onerror="this.onerror=null; this.src='https://placehold.co/1000x640/FFADBD/FFFFFF?text=Luxe+Nails+Studio';" />
                        
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center text-white">
                            <h3 class="text-2xl font-serif-title font-bold drop-shadow-lg">Nails Studio</h3>
                        </div>
                    </div>

                    <div class="p-6 rounded-[2rem] bg-gradient-to-br from-pink-50 to-white border border-pink-100 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-pink-custom to-rose-300 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md text-white">
                                <i data-lucide="map-pin" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1 font-serif-title">Alamat</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    Jl. Telekomunikasi No. 1, Terusan Buah Batu, Bandung, Jawa Barat 40257
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 rounded-[2rem] bg-white border border-pink-100 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-pink-custom to-rose-300 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md text-white">
                                <i data-lucide="clock" class="w-6 h-6"></i>
                            </div>
                            <div class="w-full">
                                <h3 class="text-lg font-bold text-gray-900 mb-3 font-serif-title">Jam Operasional</h3>
                                <div class="space-y-2 text-sm text-gray-600 font-medium">
                                    <div class="flex justify-between border-b border-pink-50 pb-1"><span>Senin - Jumat</span> <span class="text-pink-custom font-bold">09:00 - 20:00</span></div>
                                    <div class="flex justify-between border-b border-pink-50 pb-1"><span>Sabtu</span> <span class="text-pink-custom font-bold">10:00 - 21:00</span></div>
                                    <div class="flex justify-between"><span>Minggu</span> <span class="text-pink-custom font-bold">10:00 - 18:00</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. FINAL CTA --}}
    <section class="py-24 px-6 lg:px-12 bg-gradient-to-br from-pink-50 via-white to-rose-50 text-center content-wrapper">
        <div class="max-w-4xl mx-auto">
            <h3 class="text-4xl lg:text-4xl tracking-tight text-gray-900 mb-6 font-serif-title font-extrabold leading-tight">
                Siap Untuk Tampil <span class="text-pink-custom block md:inline">Lebih Percaya Diri?</span>
            </h3>
            <p class="text-lg text-gray-600 mb-10">Bergabunglah dengan ribuan pelanggan puas kami. Book appointment sekarang!</p>
            
            <div class="flex flex-wrap gap-4 justify-center items-center">
                <a href="{{ route('landing.index') }}#booking" class="group px-10 py-3 bg-pink-custom text-white rounded-full hover:shadow-xl hover:scale-105 transition-all font-bold text-lg flex items-center gap-2 text-decoration-none shadow-lg">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                        Book Appointment
                    </span>
                </a>

                <a href="https://wa.me/6285847255010?text=Halo%20Nails%20Studio%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20perawatan%20kuku." 
                   target="_blank" 
                   class="px-10 py-3 bg-white border-2 border-pink-200 text-gray-900 rounded-full hover:border-pink-400 hover:shadow-lg transition-all font-bold text-lg text-decoration-none flex items-center gap-2">
                    <i data-lucide="phone" class="w-5 h-5 text-pink-500"></i>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </section>
</div>
@endsection