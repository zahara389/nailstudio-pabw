@extends('layouts.app')

@section('title', 'Customer Service | Nails Studio Bandung')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --pink-primary: #FF8FAB;
            --pink-soft: #FDF2F8;
        }

        body { font-family: 'Inter', sans-serif; }
        .font-serif-title { font-family: 'Playfair Display', serif; }

        .hero-bg-grid {
            position: absolute; inset: 0;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 32px 32px; opacity: 0.2;
            mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
            z-index: 0; pointer-events: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.5s ease-out forwards; }
        
        .faq-button:hover .faq-icon { color: var(--pink-primary); }
    </style>
@endpush

@section('content')
<div class="w-full bg-white overflow-x-hidden">
    {{-- 1. HERO SECTION --}}
    <section class="relative py-16 lg:py-24 overflow-hidden border-b border-gray-50">
        <div class="hero-bg-grid"></div>
        
        <div class="relative z-10 max-w-6xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                <div class="w-full lg:w-1/2 order-2 lg:order-1 animate-fadeIn">
                    <div class="text-xs tracking-widest text-[#FF8FAB] mb-4 font-bold uppercase">Customer Service & Help Center</div>
                    
                    <h3 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-[1.1] mb-6 tracking-tight font-serif-title">
                        Beauty is not only <br/>
                        in the <span class="text-[#FF8FAB] relative inline-block">
                            Face
                            <svg class="absolute w-full h-3 -bottom-1 left-0 text-[#FF8FAB] opacity-30" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                            </svg>
                        </span>, but a Light <br/>
                        in the <span class="italic font-serif font-normal">Nails.</span>
                    </h3>
                    
                    <p class="text-gray-500 text-lg mb-8 leading-relaxed max-w-lg">
                        Butuh bantuan atau punya pertanyaan khusus? Tim Customer Service kami siap membantu Anda mendapatkan perawatan kuku terbaik.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="#faq" class="px-8 py-4 bg-[#FF8FAB] text-white rounded-xl hover:bg-[#F472B6] transition-all duration-300 font-bold text-sm shadow-lg shadow-pink-100 flex items-center gap-2 text-decoration-none">
                            LIHAT FAQ
                        </a>
                        <a href="https://wa.me/6285847255010" target="_blank" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 rounded-xl hover:border-[#FF8FAB] hover:text-[#FF8FAB] transition-all duration-300 font-bold text-sm text-decoration-none flex items-center gap-2">
                            CHAT WHATSAPP
                        </a>
                    </div>
                </div>

                {{-- Hero Image --}}
                <div class="w-full lg:w-5/12 order-1 lg:order-2 relative">
                    <div class="relative z-10">
                        <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&q=80&w=600" 
                             class="w-full h-[400px] lg:h-[480px] object-cover rounded-2xl shadow-2xl border-8 border-white" />
                        
                        <div class="absolute -bottom-6 -left-6 bg-white p-5 rounded-xl shadow-xl hidden md:block border border-gray-50">
                            <div class="flex items-center justify-between mb-2 gap-8">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">CS Status</span>
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            </div>
                            <p class="font-bold text-gray-900 text-base mb-0">Online</p>
                            <p class="text-[11px] text-gray-500">Fast Response Today</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. GALLERY STUDIO --}}
    <section id="gallery" class="py-16 md:py-24 bg-[#FDF2F8]">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start mb-16">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?auto=format&fit=crop&q=80&w=800"
                         class="w-full rounded-2xl object-cover h-[500px] shadow-2xl" />
                    
                    <div class="absolute -bottom-8 left-4 right-4 md:left-8 md:right-8 bg-[#FF8FAB] text-white p-6 md:p-8 rounded-2xl shadow-xl z-20">
                        <p class="mb-2 font-bold text-lg leading-snug">"Kepuasan Anda adalah Prioritas Kami!"</p>
                        <p class="text-sm text-white/80 leading-relaxed">Jangan ragu untuk menanyakan desain kuku impian Anda kepada teknisi profesional kami.</p>
                    </div>
                </div>

                <div class="lg:pt-0 pt-8">
                    <div class="text-xs tracking-widest text-[#FF8FAB] mb-4 font-bold uppercase">Gallery Studio</div>
                    <h3 class="mb-8 text-3xl md:text-4xl font-bold text-gray-900 font-serif-title">
                        <span class="text-[#FF8FAB]">Visual</span> & Suasana Studio
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1560750588-73207b1ef5b8?auto=format&fit=crop&q=80&w=400" class="rounded-xl shadow-md h-40 w-full object-cover">
                        <img src="https://images.unsplash.com/photo-1626379501846-0df4067b8bb9?auto=format&fit=crop&q=80&w=400" class="rounded-xl shadow-md h-40 w-full object-cover">
                        <img src="https://images.unsplash.com/photo-1643968704781-df3b260df6a7?auto=format&fit=crop&q=80&w=400" class="rounded-xl shadow-md h-40 w-full object-cover">
                        <img src="https://images.unsplash.com/photo-1522337660859-02fbefca4702?auto=format&fit=crop&q=80&w=400" class="rounded-xl shadow-md h-40 w-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. FAQ & CONTACT FORM (Customer Service Center) --}}
    <section id="faq" class="py-16 md:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-start">
                <div>
                    <div class="text-xs tracking-widest text-[#FF8FAB] mb-4 font-bold uppercase">FAQ Center</div>
                    <h3 class="mb-8 text-3xl md:text-4xl font-bold text-gray-900 font-serif-title">
                        Sering Ditanyakan
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach([
                            "Berapa lama proses pengerjaan Nail Art?",
                            "Apakah saya perlu booking terlebih dahulu?",
                            "Berapa lama ketahanan Gel Polish?",
                            "Apakah produk yang digunakan aman?"
                        ] as $faq)
                        <div class="border-b border-gray-100 pb-4">
                            <button class="w-full faq-button flex items-center justify-between text-left text-sm font-semibold text-gray-800 transition-colors py-2">
                                <span>{{ $faq }}</span>
                                <i data-lucide="chevron-down" class="faq-icon w-4 h-4 text-gray-400"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-2xl shadow-gray-100/50">
                    <div class="bg-[#FDF2F8] text-[#FF8FAB] py-2 px-4 rounded-lg inline-block mb-8 font-semibold text-xs tracking-wide uppercase">
                        Hubungi Support
                    </div>
                    <form action="#" class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" class="w-full border-b border-gray-100 pb-2 text-sm focus:outline-none focus:border-[#FF8FAB] transition-colors bg-transparent">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest">Pesan Anda</label>
                            <textarea rows="2" class="w-full border-b border-gray-100 pb-2 text-sm focus:outline-none focus:border-[#FF8FAB] transition-colors bg-transparent resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-[#FF8FAB] text-white py-4 px-8 rounded-xl hover:bg-[#F472B6] transition-all duration-300 font-bold text-xs tracking-widest shadow-lg shadow-pink-100">
                            KIRIM PESAN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection