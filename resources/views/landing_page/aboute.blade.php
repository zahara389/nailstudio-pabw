<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Luxe Nails Studio | Nail Salon Premium Jakarta</title>
    <!-- Load Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Inter (Sans-serif, for body) and Playfair Display (Serif, for titles) fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    
    <script>
        // Customizing Tailwind to include Playfair Display for titles and a custom pink color
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        'serif-title': ['"Playfair Display"', 'serif'], 
                    },
                    // MENDIFINISIKAN WARNA PINK KUSTOM: #FFADBD
                    colors: {
                        'pink-custom': '#FFADBD', 
                        // Tambahkan warna lain yang dekat untuk gradient jika diperlukan
                        'rose-custom-light': '#FFC0CB', // Sedikit lebih terang dari custom pink
                    },
                }
            }
        }
    </script>
    
    <style>
        /* Ensure Inter is the base body font, Playfair will be applied via class */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <div class="min-h-screen bg-white">
        <!-- Hero Section -->
        <section class="relative py-32 px-6 lg:px-12 overflow-hidden">
            <!-- Background effects -->
            <div class="absolute inset-0 bg-gradient-to-br from-pink-50 via-white to-rose-50"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-pink-300/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-pink-100/80 backdrop-blur-sm rounded-full mb-6">
                            <!-- Star Icon SVG -->
                            <!-- DIPERBARUI: Menggunakan text-pink-custom -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <span class="text-sm text-pink-700">Premium Nail Studio Jakarta</span>
                        </div>
                        
                        <!-- H1 Gradient: Menggunakan pink-custom sebagai titik akhir gradien -->
                        <h1 class="text-6xl lg:text-7xl tracking-tight text-gray-900 mb-6 font-serif-title font-extrabold">
                            Tentang
                            <span class="block bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">
                                Luxe Nails
                            </span>
                        </h1>
                        
                        <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                            Luxe Nails Studio adalah nail salon premium yang telah melayani ribuan pelanggan sejak tahun 2015. 
                            Kami menghadirkan pengalaman nail care yang berbeda - kombinasi sempurna antara seni, 
                            kenyamanan, dan profesionalisme.
                        </p>

                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Berlokasi strategis di pusat kota Jakarta, studio kami dirancang dengan konsep modern 
                            minimalis yang nyaman dan Instagrammable. Dengan tim nail artist bersertifikat 
                            internasional dan produk premium, kami berkomitmen memberikan hasil terbaik untuk Anda.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <!-- Button Primary: BOOK APPOINTMENT (Mengarahkan ke bagian CTA di bawah) -->
                            <a href="#cta-section" class="group px-8 py-4 bg-pink-custom text-white rounded-full hover:shadow-xl hover:shadow-pink-custom/40 hover:scale-105 transition-all flex items-center gap-2">
                                Book Appointment
                                <!-- ArrowRight Icon SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                            <!-- Button Secondary: LIHAT GALLERY (Menunjuk ke gambar galeri) -->
                            <a href="#studio-gallery" class="px-8 py-4 bg-white border-2 border-pink-200 text-gray-900 rounded-full hover:border-pink-custom hover:shadow-lg transition-all">
                                Lihat Gallery
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <!-- Gradient latar belakang gambar: pink-300 ke rose-400 (dibiarkan karena pink-custom solid) -->
                        <div class="absolute inset-0 bg-gradient-to-br from-pink-300 to-rose-400 rounded-[3rem] rotate-3"></div>
                        <div class="relative rounded-[3rem] overflow-hidden shadow-2xl">
                            <!-- Image with Fallback equivalent -->
                            <img
                                src="https://images.unsplash.com/photo-1619607146034-5a05296c8f9a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwc2Fsb24lMjBpbnRlcmlvcnxlbnwxfHx8fDE3NjU3MDA5MTB8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                                alt="Luxe Nails Studio Interior"
                                class="w-full aspect-[4/5] object-cover"
                                onerror="this.onerror=null; this.src='https://placehold.co/1080x1350/ffc0cb/333333?text=Studio+Interior';"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Studio Gallery (Diberi ID untuk anchor link) -->
        <section id="studio-gallery" class="py-32 px-6 lg:px-12 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <!-- H2 Gradient: Menggunakan pink-custom sebagai titik akhir gradien -->
                    <h2 class="text-5xl lg:text-6xl tracking-tight text-gray-900 mb-6 font-serif-title font-extrabold">
                        Studio <span class="bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">Kami</span>
                    </h2>
                    <p class="text-xl text-gray-600">Ruang yang dirancang untuk kenyamanan maksimal Anda</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <!-- Gallery Items here (no color change) -->
                    <div class="relative h-96 rounded-3xl overflow-hidden group">
                        <img
                            src="https://images.unsplash.com/photo-1619607146034-5a05296c8f9a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwc2Fsb24lMjBpbnRlcmlvcnxlbnwxfHx8fDE3NjU3MDA5MTB8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                            alt="Studio Interior"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onerror="this.onerror=null; this.src='https://placehold.co/1080x900/ffc0cb/333333?text=Treatment+Area';"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-8 left-8 text-white">
                            <h3 class="text-2xl mb-2">Treatment Area</h3>
                            <p class="text-white/80">12 premium treatment chairs</p>
                        </div>
                    </div>

                    <div class="relative h-96 rounded-3xl overflow-hidden group">
                        <img
                            src="https://images.unsplash.com/photo-1626379501846-0df4067b8bb9?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxiZWF1dHklMjBzYWxvbiUyMGdoYWlyfGVufDF8fHx8MTc2NTcwMDkxMXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                            alt="Treatment Chair"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onerror="this.onerror=null; this.src='https://placehold.co/1080x900/ffc0cb/333333?text=Luxury+Seating';"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-8 left-8 text-white">
                            <h3 class="text-2xl mb-2">Luxury Seating</h3>
                            <p class="text-white/80">Comfortable massage chairs</p>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="relative h-72 rounded-3xl overflow-hidden group">
                        <img
                            src="https://images.unsplash.com/photo-1643968704781-df3b260df6a7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwdGVjaG5pY2lhbiUyMHdvcmtpbmd8ZW58MXx8fHwxNzY1NzAwOTExfDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                            alt="Nail Artist Working"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onerror="this.onerror=null; this.src='https://placehold.co/1080x720/ffc0cb/333333?text=Expert+Artists';"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-xl">Expert Artists</h3>
                        </div>
                    </div>

                    <div class="relative h-72 rounded-3xl overflow-hidden group">
                        <img
                            src="https://images.unsplash.com/photo-1764448726322-2abd2bdd6c68?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxtYW5pY3VyZSUyMHNlcnZpY2V8ZW58MXx8fHwxNzY1NzAwOTExfDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                            alt="Manicure Service"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onerror="this.onerror=null; this.src='https://placehold.co/1080x720/ffc0cb/333333?text=Premium+Service';"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-xl">Premium Service</h3>
                        </div>
                    </div>

                    <div class="relative h-72 rounded-3xl overflow-hidden group">
                        <img
                            src="https://images.unsplash.com/photo-1762331979387-f9fadbc6ef59?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxwaW5rJTIwbmFpbHMlMjBtb2Rlcm58ZW58MXx8fHwxNzY1NzAwNDY5fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                            alt="Nail Art"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onerror="this.onerror=null; this.src='https://placehold.co/1080x720/ffc0cb/333333?text=Beautiful+Results';"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-xl">Beautiful Results</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="py-32 px-6 lg:px-12 bg-gradient-to-br from-pink-50 via-white to-rose-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-20">
                    <!-- H2 Gradient: Menggunakan pink-custom sebagai titik akhir gradien -->
                    <h2 class="text-5xl lg:text-6xl tracking-tight text-gray-900 mb-6 font-serif-title font-extrabold">
                        Kenapa Pilih <span class="bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">Luxe Nails?</span>
                    </h2>
                    <p class="text-xl text-gray-600">Kami lebih dari sekedar nail salon biasa</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mb-16">
                    <!-- Item 1: Teknologi Terkini (Sparkles) - GRADIENT SOFT -->
                    <div class="group p-10 rounded-3xl bg-white border border-pink-100 hover:shadow-2xl hover:shadow-pink-custom/10 hover:-translate-y-2 transition-all duration-300">
                        <!-- GRADIENT ICON: Menggunakan pink-custom dan rose-custom-light -->
                        <div class="w-16 h-16 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all">
                            <!-- Sparkles Icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white"><path d="M9.9 5.2l-2.6 7.4-4.8 2.3c-.9.4-1.2 1.4-.8 2.3.4.9 1.4 1.2 2.3.8l4.8-2.3 2.6-7.4c.2-.6-.1-1.3-.7-1.5-.6-.2-1.3.1-1.5.7z"/><path d="M19 20l2-2"/><path d="M19 14l2 2"/><path d="M14 20l2-2"/><path d="M14 14l2 2"/></svg>
                        </div>
                        <h3 class="text-2xl text-gray-900 mb-4">Teknologi Terkini</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">Menggunakan peralatan dan produk nail care terbaru dan tercanggih dari brand internasional terpercaya</p>
                    </div>

                    <!-- Item 2: Nail Artist Bersertifikat (Award) - GRADIENT SOFT -->
                    <div class="group p-10 rounded-3xl bg-white border border-pink-100 hover:shadow-2xl hover:shadow-pink-custom/10 hover:-translate-y-2 transition-all duration-300">
                        <!-- GRADIENT ICON: Menggunakan pink-custom dan rose-custom-light -->
                        <div class="w-16 h-16 bg-gradient-to-r from-rose-custom-light to-pink-custom rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all">
                            <!-- Award Icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white"><path d="m15.4 3.3-3.6 5.5-5.9-1.3c-.9-.2-1.8.2-2.1.8-.3.6-.1 1.4.3 1.9l4.5 5.5-3.6 4.9c-.6.8-.2 2 .5 2.5.7.5 1.6.3 2.3-.2l4.8-4.5 5.8 2.2c.9.3 1.9-.1 2.2-.9.3-.7.1-1.6-.4-2.2l-4.5-5.5 3.6-4.9c.5-.7.3-1.8-.2-2.3-.6-.5-1.5-.4-2.2.1z"/></svg>
                        </div>
                        <h3 class="text-2xl text-gray-900 mb-4">Nail Artist Bersertifikat</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">Tim profesional dengan sertifikasi internasional dan pengalaman lebih dari 5 tahun di industri nail care</p>
                    </div>
                    
                    <!-- Item 3: Hygiene & Safety First (Heart) - GRADIENT SOFT -->
                    <div class="group p-10 rounded-3xl bg-white border border-pink-100 hover:shadow-2xl hover:shadow-pink-custom/10 hover:-translate-y-2 transition-all duration-300">
                        <!-- GRADIENT ICON: Menggunakan pink-custom dan rose-custom-light -->
                        <div class="w-16 h-16 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all">
                            <!-- Heart Icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 1.03-4.5 2-1.5-1.03-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        </div>
                        <h3 class="text-2xl text-gray-900 mb-4">Hygiene & Safety First</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">Sterilisasi tools dengan UV sterilizer, penggunaan tools disposable, dan sanitasi rutin setiap hari</p>
                    </div>

                    <!-- Item 4: Hasil Maksimal (Target) - GRADIENT SOFT -->
                    <div class="group p-10 rounded-3xl bg-white border border-pink-100 hover:shadow-2xl hover:shadow-pink-custom/10 hover:-translate-y-2 transition-all duration-300">
                        <!-- GRADIENT ICON: Menggunakan pink-custom dan rose-custom-light -->
                        <div class="w-16 h-16 bg-gradient-to-r from-rose-custom-light to-pink-custom rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all">
                            <!-- Target Icon SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m22 12-2 0"/><path d="m4 12 2 0"/><path d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4z"/></svg>
                        </div>
                        <h3 class="text-2xl text-gray-900 mb-4">Hasil Maksimal</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">Guarantee satisfaction - jika Anda tidak puas, kami akan perbaiki gratis dalam 48 jam pertama</p>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="p-10 lg:p-12 rounded-3xl bg-white border border-pink-100">
                    <h3 class="text-3xl text-gray-900 mb-8">Fasilitas Premium Kami:</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Facility List - BULLET COLOR SOFT (pink-custom) -->
                        <div class="flex items-start gap-4">
                            <div class="w-2 h-2 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-full mt-2 flex-shrink-0"></div>
                            <p class="text-gray-700 text-lg">12 Premium Treatment Chairs dengan pijat otomatis</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-2 h-2 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-full mt-2 flex-shrink-0"></div>
                            <p class="text-gray-700 text-lg">Private VIP Room untuk treatment eksklusif</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-2 h-2 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-full mt-2 flex-shrink-0"></div>
                            <p class="text-gray-700 text-lg">Free WiFi & Refreshments (kopi, teh, snacks)</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-2 h-2 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-full mt-2 flex-shrink-0"></div>
                            <p class="text-gray-700 text-lg">Nail Polish Collection 500+ warna & brand premium</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-2 h-2 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-full mt-2 flex-shrink-0"></div>
                            <p class="text-gray-700 text-lg">Spa Pedicure dengan jacuzzi individual</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-2 h-2 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-full mt-2 flex-shrink-0"></div>
                            <p class="text-gray-700 text-lg">Cozy Waiting Area dengan majalah & entertainment</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Services -->
        <section class="py-32 px-6 lg:px-12 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-20">
                    <!-- H2 Gradient: Menggunakan pink-custom sebagai titik akhir gradien -->
                    <h2 class="text-5xl lg:text-6xl tracking-tight mb-6 font-serif-title font-extrabold">
                        Layanan <span class="bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">Kami</span>
                    </h2>
                    <p class="text-xl text-gray-300">Treatment lengkap untuk kebutuhan nail care Anda</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Service Category 1: Manicure -->
                    <div class="p-8 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all">
                        <h3 class="text-2xl mb-6 bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">
                            Manicure
                        </h3>
                        <ul class="space-y-3">
                            <!-- Star Icon: DIPERBARUI ke text-pink-custom -->
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Classic Manicure</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Gel Manicure</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Acrylic Extension</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Nail Art Design</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Service Category 2: Pedicure -->
                    <div class="p-8 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all">
                        <h3 class="text-2xl mb-6 bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">
                            Pedicure
                        </h3>
                        <ul class="space-y-3">
                            <!-- Star Icon: DIPERBARUI ke text-pink-custom -->
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Spa Pedicure</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Gel Pedicure</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Callus Treatment</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Service Category 3: Special Treatment -->
                    <div class="p-8 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all">
                        <h3 class="text-2xl mb-6 bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">
                            Special Treatment
                        </h3>
                        <ul class="space-y-3">
                            <!-- Star Icon: DIPERBARUI ke text-pink-custom -->
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Paraffin Therapy</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Hand & Foot Massage</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Cuticle Care</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-pink-custom fill-pink-custom flex-shrink-0"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Nail Repair</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- TOMBOL 'Lihat Semua Layanan & Harga' DIHAPUS DARI SINI -->

            </div>
        </section>

        <!-- Location & Contact -->
        <section class="py-32 px-6 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <!-- H2 Gradient: Menggunakan pink-custom sebagai titik akhir gradien -->
                    <h2 class="text-5xl lg:text-6xl tracking-tight text-gray-900 mb-6 font-serif-title font-extrabold">
                        Kunjungi <span class="bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">Studio Kami</span>
                    </h2>
                    <p class="text-xl text-gray-600">Kami siap melayani Anda dengan sepenuh hati</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12">
                    
                    <!-- Kiri: Google Map Embed (Telkom University, Bandung) -->
                    <div class="h-96 rounded-3xl overflow-hidden shadow-xl border-4 border-pink-100">
                        <!-- Google Maps Embed Link untuk Telkom University, Bandung -->
                        <iframe 
                            src="https://maps.google.com/maps?q=Telkom%20University%2C%20Bandung&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Google Maps Lokasi Telkom University">
                        </iframe>
                    </div>

                    <!-- Kanan: Contact Info dengan Gambar di atas -->
                    <div class="space-y-6">
                        <!-- Gambar Studio -->
                        <div class="relative h-64 rounded-3xl overflow-hidden shadow-lg">
                            <img
                                src="https://images.unsplash.com/photo-1617450700147-3ce94220b299?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHw0fHxuYWlsJTIwYXJ0aXN0JTIwYm91dGlxdWV8ZW58MHx8fHwxNzA3NzQ1MTc0fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                                alt="Nail Artist dan suasana studio"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.src='https://placehold.co/1080x640/FFADBD/FFFFFF?text=Luxe+Nails+Studio+Interior';"
                            />
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                <p class="text-white text-3xl font-serif-title font-bold">Luxe Nails Studio</p>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <!-- Catatan: Alamat teks diselaraskan ke Bandung. -->
                        <div class="p-8 rounded-3xl bg-gradient-to-br from-pink-50 to-white border border-pink-100">
                            <div class="flex items-start gap-6">
                                <!-- GRADIENT ICON: Menggunakan pink-custom dan rose-custom-light -->
                                <div class="w-14 h-14 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <!-- MapPin Icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl text-gray-900 mb-2">Alamat</h3>
                                    <p class="text-gray-600 text-lg leading-relaxed">
                                        Jl. Telekomunikasi No. 1<br />
                                        Terusan Buah Batu, Bandung 40257<br />
                                        (Dekat Gerbang Utama Telkom University)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="p-8 rounded-3xl bg-gradient-to-br from-pink-50 to-white border border-pink-100">
                            <div class="flex items-start gap-6">
                                <!-- GRADIENT ICON: Menggunakan pink-custom dan rose-custom-light -->
                                <div class="w-14 h-14 bg-gradient-to-r from-pink-custom to-rose-custom-light rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <!-- Clock Icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl text-gray-900 mb-3">Jam Operasional</h3>
                                    <div class="space-y-2 text-gray-600">
                                        <div class="flex justify-between">
                                            <span>Senin - Jumat</span>
                                            <!-- DIPERBARUI ke text-pink-custom -->
                                            <span class="text-pink-custom">09:00 - 20:00</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Sabtu</span>
                                            <!-- DIPERBARUI ke text-pink-custom -->
                                            <span class="text-pink-custom">10:00 - 21:00</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Minggu</span>
                                            <!-- DIPERBARUI ke text-pink-custom -->
                                            <span class="text-pink-custom">10:00 - 18:00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA (Diberi ID untuk anchor link) -->
        <section id="cta-section" class="py-32 px-6 lg:px-12 bg-gradient-to-br from-pink-50 via-white to-rose-50">
            <div class="max-w-4xl mx-auto text-center">
                <!-- H2 Gradient: Menggunakan pink-custom sebagai titik akhir gradien -->
                <h2 class="text-5xl tracking-tight text-gray-900 mb-6 font-serif-title font-extrabold">
                    Siap Untuk Tampil
                    <span class="block bg-gradient-to-r from-pink-300 to-pink-custom bg-clip-text text-transparent">
                        Lebih Percaya Diri?
                    </span>
                </h2>
                <p class="text-xl text-gray-600 mb-10">
                    Bergabunglah dengan ribuan pelanggan puas kami. Book appointment sekarang dan rasakan 
                    pengalaman nail care yang berbeda!
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <!-- Button Primary: BOOK SEKARANG (Menunjuk ke WhatsApp) -->
                    <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20membuat%20janji%20temu%20di%20Luxe%20Nails%20Studio." target="_blank" class="group px-8 py-4 bg-pink-custom text-white rounded-full hover:shadow-xl hover:shadow-pink-custom/40 hover:scale-105 transition-all flex items-center gap-2">
                        Book Sekarang
                        <!-- ArrowRight Icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                    <!-- Button Secondary: CHAT WHATSAPP (Menunjuk ke WhatsApp) -->
                    <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20Anda." target="_blank" class="px-8 py-4 bg-white border-2 border-pink-200 text-gray-900 rounded-full hover:border-pink-400 hover:shadow-lg transition-all">
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </section>
    </div>

</body>
</html>