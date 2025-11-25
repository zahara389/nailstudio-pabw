<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Nail Art Studio</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

    @if(session('success'))
    <div class="fixed top-5 right-5 bg-[#D8859D] text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-fade-in-up flex items-center gap-2">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
    @endif

    <header class="relative w-full min-h-screen flex items-center justify-center overflow-hidden" role="banner">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYXN0ZWwlMjBuYWlscyUyMHBsYW50fGVufDF8fHx8MTc2Mzk0NTY3OHww&ixlib=rb-4.1.0&q=80&w=1080" alt="Elegant nail art" class="w-full h-full object-cover">
            <div class="absolute inset-0 hero-overlay"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <div class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-white/50 animate-fade-in-up shadow-sm">
                <i data-lucide="sparkles" class="w-4 h-4 text-[#D8859D]"></i>
                <span class="text-sm tracking-wide text-gray-700 font-medium">Premium Nail Art Experience</span>
            </div>

            <h1 class="mb-6 animate-fade-in-up delay-100 font-serif text-4xl sm:text-6xl lg:text-7xl font-bold leading-tight text-[#1a1a1a]">
                Elevate Your Nails,<br />
                <span class="text-gradient-brand">Elevate Your Confidence</span>
            </h1>

            <p class="max-w-2xl mx-auto mb-10 animate-fade-in-up delay-200 text-base sm:text-lg lg:text-xl leading-relaxed text-gray-600">
                Discover the art of beautiful nails with our expert artists. 
                From classic elegance to bold statements, we bring your vision to life.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up delay-300">
                <button onclick="scrollToSection('booking')" class="group relative px-8 py-4 rounded-full overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#D8859D]/30 btn-shine min-w-[200px]" style="background: linear-gradient(135deg, #D8859D 0%, #AEC6CF 100%); box-shadow: 0 10px 25px rgba(216, 133, 157, 0.3);">
                    <span class="relative z-10 flex items-center justify-center gap-2 text-white font-semibold">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                        Book Appointment
                    </span>
                </button>

                <button onclick="scrollToSection('top-products')" class="group px-8 py-4 rounded-full backdrop-blur-md transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-[#AEC6CF]/50 min-w-[200px] border-2 border-[#AEC6CF] bg-white/50 text-[#1a1a1a] hover:bg-white hover:border-[#D8859D] hover:text-[#D8859D]">
                    <span class="flex items-center justify-center gap-2 font-semibold">
                        <i data-lucide="sparkles" class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300"></i>
                        Explore Designs
                    </span>
                </button>
            </div>

            <div class="mt-16 flex flex-wrap items-center justify-center gap-8 animate-fade-in-up delay-400">
                <div class="text-center">
                    <div class="mb-1 font-serif text-3xl font-bold text-[#D8859D]">500+</div>
                    <div class="text-sm text-gray-500 uppercase tracking-wider">Happy Clients</div>
                </div>
                <div class="hidden sm:block w-px h-12 bg-gray-300 opacity-50"></div>
                <div class="text-center">
                    <div class="mb-1 font-serif text-3xl font-bold text-[#AEC6CF]">15+</div>
                    <div class="text-sm text-gray-500 uppercase tracking-wider">Years Experience</div>
                </div>
                <div class="hidden sm:block w-px h-12 bg-gray-300 opacity-50"></div>
                <div class="text-center">
                    <div class="mb-1 font-serif text-3xl font-bold text-[#D8859D]">100%</div>
                    <div class="text-sm text-gray-500 uppercase tracking-wider">Satisfaction</div>
                </div>
            </div>
        </div>
    </header>

    <section id="top-products" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: var(--off-white);">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="mb-4 text-3xl md:text-4xl font-serif font-bold text-[#1a1a1a]">Top Products</h2>
                <p class="text-gray-600 text-lg">Our best-selling nail care essentials</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="product-card bg-white rounded-xl overflow-hidden shadow-lg border border-gray-50 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1608571899793-a1c0c27a7555?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjdXRpY2xlJTIwb2lsJTIwYm90dGxlfGVufDF8fHx8MTc2Mzg4NTgwOHww&ixlib=rb-4.1.0&q=80&w=1080" alt="Cuticle Oil" class="product-image w-full h-full object-cover transition-transform duration-300">
                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-semibold shadow-sm" style="background-color: var(--soft-pink); color: #fff;">Bestseller</span>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-semibold text-[#1a1a1a]">Cuticle Oil</h3>
                        <p class="font-semibold text-lg" style="color: var(--soft-pink)">$24.99</p>
                        <button class="add-to-cart-btn mt-4 w-full py-2 rounded-lg border-2 border-[#D8859D] text-[#D8859D] transition-all duration-300 font-medium">Add to Cart</button>
                    </div>
                </div>
                <div class="product-card bg-white rounded-xl overflow-hidden shadow-lg border border-gray-50 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1667242197579-10b000f004da?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwcG9saXNoJTIwY29sbGVjdGlvbnxlbnwxfHx8fDE3NjM3OTA5MzF8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Premium Nail Polish" class="product-image w-full h-full object-cover transition-transform duration-300">
                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-semibold shadow-sm" style="background-color: var(--soft-pink); color: #fff;">Bestseller</span>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-semibold text-[#1a1a1a]">Premium Nail Polish</h3>
                        <p class="font-semibold text-lg" style="color: var(--soft-pink)">$18.99</p>
                        <button class="add-to-cart-btn mt-4 w-full py-2 rounded-lg border-2 border-[#D8859D] text-[#D8859D] transition-all duration-300 font-medium">Add to Cart</button>
                    </div>
                </div>
                <div class="product-card bg-white rounded-xl overflow-hidden shadow-lg border border-gray-50 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer">
                    <div class="relative h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1617614207953-9beba84738a0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoYW5kJTIwY3JlYW0lMjBjb3NtZXRpY3xlbnwxfHx8fDE3NjM4ODU4MDl8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Luxury Hand Cream" class="product-image w-full h-full object-cover transition-transform duration-300">
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-semibold text-[#1a1a1a]">Luxury Hand Cream</h3>
                        <p class="font-semibold text-lg" style="color: var(--soft-pink)">$29.99</p>
                        <button class="add-to-cart-btn mt-4 w-full py-2 rounded-lg border-2 border-[#D8859D] text-[#D8859D] transition-all duration-300 font-medium">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="categories" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="mb-4 text-3xl md:text-4xl font-serif font-bold text-[#1a1a1a]">Product Categories</h2>
                <p class="text-gray-600 text-lg">Explore our curated collections</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="category-card group relative rounded-xl overflow-hidden shadow-lg cursor-pointer transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="relative h-72">
                        <img src="https://images.unsplash.com/photo-1659391542239-9648f307c0b1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxnZWwlMjBuYWlsJTIwcG9saXNofGVufDF8fHx8MTc2Mzg2ODE4M3ww&ixlib=rb-4.1.0&q=80&w=1080" alt="Gel Polish" class="category-image w-full h-full object-cover transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="category-icon w-12 h-12 rounded-full flex items-center justify-center mb-3 transition-transform duration-300" style="background-color: var(--soft-pink)">
                                <i data-lucide="sparkles" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-white mb-1 text-xl font-bold">Gel Polish</h3>
                            <p class="text-white/80 text-sm font-medium">Long-lasting shine</p>
                        </div>
                    </div>
                </div>
                <div class="category-card group relative rounded-xl overflow-hidden shadow-lg cursor-pointer transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="relative h-72">
                        <img src="https://images.unsplash.com/photo-1619607536077-220f62b03d10?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwYXJ0JTIwdG9vbHN8ZW58MXx8fHwxNzYzODg1ODA5fDA&ixlib=rb-4.1.0&q=80&w=1080" alt="Nail Art Tools" class="category-image w-full h-full object-cover transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="category-icon w-12 h-12 rounded-full flex items-center justify-center mb-3 transition-transform duration-300" style="background-color: var(--soft-blue)">
                                <i data-lucide="brush" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-white mb-1 text-xl font-bold">Nail Art Tools</h3>
                            <p class="text-white/80 text-sm font-medium">Professional equipment</p>
                        </div>
                    </div>
                </div>
                <div class="category-card group relative rounded-xl overflow-hidden shadow-lg cursor-pointer transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="relative h-72">
                        <img src="https://images.unsplash.com/photo-1616815432742-0233fc9621ad?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwY2FyZSUyMHByb2R1Y3RzfGVufDF8fHx8MTc2Mzg4NTgwOXww&ixlib=rb-4.1.0&q=80&w=1080" alt="Nail Care" class="category-image w-full h-full object-cover transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="category-icon w-12 h-12 rounded-full flex items-center justify-center mb-3 transition-transform duration-300" style="background-color: var(--soft-pink)">
                                <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-white mb-1 text-xl font-bold">Nail Care</h3>
                            <p class="text-white/80 text-sm font-medium">Essential treatments</p>
                        </div>
                    </div>
                </div>
                <div class="category-card group relative rounded-xl overflow-hidden shadow-lg cursor-pointer transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="relative h-72">
                        <img src="https://images.unsplash.com/photo-1743594788846-d3fcfe0055d2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiZWF1dHklMjBhY2Nlc3Nvcmllc3xlbnwxfHx8fDE3NjM4ODU4MTB8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Accessories" class="category-image w-full h-full object-cover transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="category-icon w-12 h-12 rounded-full flex items-center justify-center mb-3 transition-transform duration-300" style="background-color: var(--soft-blue)">
                                <i data-lucide="gem" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-white mb-1 text-xl font-bold">Accessories</h3>
                            <p class="text-white/80 text-sm font-medium">Beauty essentials</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking-promo" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: var(--off-white);">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 bg-[#FFE4E9]">
                            <i data-lucide="calendar-heart" class="w-8 h-8 text-[#D8859D]"></i>
                        </div>
                        
                        <h2 class="mb-4 text-3xl font-serif font-bold text-[#1a1a1a]">Ready for a Transformation?</h2>
                        <p class="text-gray-600 mb-6">
                            Manjakan diri Anda dengan perawatan kuku terbaik di kelasnya. Terapis profesional kami siap mewujudkan kuku impian Anda.
                        </p>
                        
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-[#D8859D]"></div>
                                <span class="text-gray-700">Terapis berpengalaman & tersertifikasi</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-[#D8859D]"></div>
                                <span class="text-gray-700">Alat steril & higienis (Medical Grade)</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-[#D8859D]"></div>
                                <span class="text-gray-700">Garansi kepuasan pelanggan 100%</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="scrollToSection('booking')" class="px-8 py-3 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg font-medium text-white shadow-md" style="background-color: var(--soft-pink);">
                                Book Appointment Now
                            </button>
                            <button class="px-6 py-3 rounded-lg border-2 transition-all duration-300 hover:shadow-md flex items-center justify-center gap-2 font-medium" style="border-color: var(--soft-blue); color: var(--soft-blue);">
                                <i data-lucide="info" class="w-5 h-5"></i>
                                View Service Menu
                            </button>
                        </div>
                    </div>

                    <div class="hidden md:block relative" style="background: linear-gradient(135deg, #D8859D 0%, #AEC6CF 100%);">
                        <div class="absolute inset-0 flex items-center justify-center p-12">
                            <div class="text-center text-white">
                                <div class="mb-6"><p style="font-size: 4rem; line-height: 1;">💅</p></div>
                                <h3 class="text-white mb-4 text-2xl font-bold">Our Signature Services</h3>
                                <div class="space-y-3 text-left bg-white/20 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                                    <div class="text-white font-medium">• Classic & Gel Manicure</div>
                                    <div class="text-white font-medium">• Custom Nail Art Design</div>
                                    <div class="text-white font-medium">• Spa Pedicure Treatment</div>
                                    <div class="text-white font-medium">• Nail Extension & Repair</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="booking" class="py-16 px-4 sm:px-6 lg:px-8" style="background-color: var(--off-white);">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="mb-4 text-3xl md:text-4xl font-serif font-bold text-[#1a1a1a]">Book Your Appointment</h2>
                <p class="text-gray-600 text-lg">Schedule your nail care session with our expert artists</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-50">
                <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                    @csrf @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="flex items-center gap-2 mb-2 text-gray-700 font-medium">
                            <i data-lucide="calendar" class="w-5 h-5 text-[#D8859D]"></i>
                            Select Service
                        </label>
                        <select name="service" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#D8859D] transition-all bg-white text-gray-700">
                            <option value="">Choose a service...</option>
                            <option value="Classic Manicure">Classic Manicure</option>
                            <option value="Gel Manicure">Gel Manicure</option>
                            <option value="Nail Art Design">Nail Art Design</option>
                            <option value="Pedicure">Pedicure</option>
                            <option value="Nail Extension">Nail Extension</option>
                            <option value="Nail Care Treatment">Nail Care Treatment</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="flex items-center gap-2 mb-2 text-gray-700 font-medium">
                                <i data-lucide="calendar" class="w-5 h-5 text-[#D8859D]"></i>
                                Select Date
                            </label>
                            <input type="date" name="date" id="bookingDate" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#D8859D] transition-all text-gray-700">
                        </div>

                        <div>
                            <label class="flex items-center gap-2 mb-2 text-gray-700 font-medium">
                                <i data-lucide="clock" class="w-5 h-5 text-[#D8859D]"></i>
                                Select Time
                            </label>
                            <select name="time" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#D8859D] transition-all bg-white text-gray-700">
                                <option value="">Choose a time...</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="13:00">01:00 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="16:00">04:00 PM</option>
                                <option value="17:00">05:00 PM</option>
                                <option value="18:00">06:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="flex items-center gap-2 mb-2 text-gray-700 font-medium">
                                <i data-lucide="user" class="w-5 h-5 text-[#D8859D]"></i>
                                Your Name
                            </label>
                            <input type="text" name="name" required placeholder="Enter your full name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#D8859D] transition-all text-gray-700">
                        </div>

                        <div>
                            <label class="flex items-center gap-2 mb-2 text-gray-700 font-medium">
                                <i data-lucide="phone" class="w-5 h-5 text-[#D8859D]"></i>
                                Phone Number
                            </label>
                            <input type="tel" name="phone" required placeholder="Enter your phone number" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#D8859D] transition-all text-gray-700">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-lg font-bold text-white shadow-md" style="background-color: var(--soft-pink);">
                        Confirm Booking
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section id="team" class="py-20 px-6" style="background: linear-gradient(to bottom right, #FDFBFD, #E8F4F8);">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-block px-4 py-2 bg-white rounded-full text-[#D8859D] mb-4 font-medium shadow-sm border border-gray-100">
                    💅 Meet Our Team
                </div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900">Our Expert Nail Artists</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Tim profesional kami siap memberikan pengalaman nail art terbaik dengan keahlian dan dedikasi tinggi
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-50">
                    <div class="relative pt-8 pb-4 bg-gradient-to-br from-[#FFE4E9] to-[#E8F4F8]">
                        <div class="relative w-40 h-40 mx-auto">
                            <div class="absolute inset-0 rounded-full bg-white/30 animate-pulse"></div>
                            <div class="absolute inset-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                <img src="https://images.unsplash.com/photo-1649589244330-09ca58e4fa64?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwcm9mZXNzaW9uYWwlMjB3b21hbiUyMHBvcnRyYWl0fGVufDF8fHx8MTc2MzYyOTkxNHww&ixlib=rb-4.1.0&q=80&w=1080" alt="Jessica Kim" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        </div>
                        <div class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-md">
                            <i data-lucide="award" class="text-[#D8859D] w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="p-6 text-center space-y-4">
                        <div>
                            <h3 class="text-gray-900 mb-1 text-xl font-bold">Jessica Kim</h3>
                            <p class="text-[#AEC6CF] font-semibold">Lead Nail Artist</p>
                        </div>
                        <p class="text-gray-600 text-sm">8 tahun pengalaman dalam nail art dengan spesialisasi Korean nail design dan gel techniques.</p>
                        <div class="flex flex-wrap gap-2 justify-center pt-2">
                            <span class="px-3 py-1 bg-[#FFE4E9] text-gray-700 rounded-full text-xs flex items-center gap-1 font-medium"><i data-lucide="star" class="text-[#D8859D] w-3 h-3"></i> Korean Art</span>
                            <span class="px-3 py-1 bg-[#E8F4F8] text-gray-700 rounded-full text-xs flex items-center gap-1 font-medium"><i data-lucide="star" class="text-[#AEC6CF] w-3 h-3"></i> Gel Nails</span>
                        </div>
                    </div>
                </div>
                <div class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-50">
                    <div class="relative pt-8 pb-4 bg-gradient-to-br from-[#FFE4E9] to-[#E8F4F8]">
                        <div class="relative w-40 h-40 mx-auto">
                            <div class="absolute inset-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                <img src="https://images.unsplash.com/photo-1653130029149-9109b115ab9a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiZWF1dHklMjBzYWxvbiUyMHByb2Zlc3Npb25hbHxlbnwxfHx8fDE3NjM2Njk3OTN8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Amanda Chen" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center space-y-4">
                        <div>
                            <h3 class="text-gray-900 mb-1 text-xl font-bold">Amanda Chen</h3>
                            <p class="text-[#AEC6CF] font-semibold">Senior Nail Technician</p>
                        </div>
                        <p class="text-gray-600 text-sm">6 tahun berpengalaman dengan sertifikasi internasional dalam nail care dan manicure pedicure.</p>
                        <div class="flex flex-wrap gap-2 justify-center pt-2">
                            <span class="px-3 py-1 bg-[#FFE4E9] text-gray-700 rounded-full text-xs flex items-center gap-1 font-medium"><i data-lucide="star" class="text-[#D8859D] w-3 h-3"></i> Extensions</span>
                            <span class="px-3 py-1 bg-[#E8F4F8] text-gray-700 rounded-full text-xs flex items-center gap-1 font-medium"><i data-lucide="star" class="text-[#AEC6CF] w-3 h-3"></i> Nail Care</span>
                        </div>
                    </div>
                </div>
                <div class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-50">
                    <div class="relative pt-8 pb-4 bg-gradient-to-br from-[#FFE4E9] to-[#E8F4F8]">
                        <div class="relative w-40 h-40 mx-auto">
                            <div class="absolute inset-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                <img src="https://images.unsplash.com/photo-1668191174012-7d5a78e454a5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxlbGVnYW50JTIwd29tYW4lMjBwb3J0cmFpdHxlbnwxfHx8fDE3NjM2OTYyMDN8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Sophie Laurent" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center space-y-4">
                        <div>
                            <h3 class="text-gray-900 mb-1 text-xl font-bold">Sophie Laurent</h3>
                            <p class="text-[#AEC6CF] font-semibold">Nail Art Specialist</p>
                        </div>
                        <p class="text-gray-600 text-sm">5 tahun mengkreasikan nail art custom dengan detail halus dan desain yang unik dan trendy.</p>
                        <div class="flex flex-wrap gap-2 justify-center pt-2">
                            <span class="px-3 py-1 bg-[#FFE4E9] text-gray-700 rounded-full text-xs flex items-center gap-1 font-medium"><i data-lucide="star" class="text-[#D8859D] w-3 h-3"></i> Custom Art</span>
                            <span class="px-3 py-1 bg-[#E8F4F8] text-gray-700 rounded-full text-xs flex items-center gap-1 font-medium"><i data-lucide="star" class="text-[#AEC6CF] w-3 h-3"></i> 3D Designs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="careers" class="py-20 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-block px-4 py-2 bg-[#FDFBFD] border border-[#FFE4E9] rounded-full text-[#D8859D] mb-4 font-medium">
                    💼 Join Our Team
                </div>
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900">Career Opportunities</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Bergabunglah dengan tim kami dan berkembang bersama dalam industri beauty yang dinamis dan kreatif
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="space-y-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#FFE4E9] to-[#E8F4F8] rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="briefcase" class="text-[#D8859D] w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 mb-2 text-xl font-bold">Nail Artist Junior</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-[#FFE4E9] rounded-full text-sm text-[#D8859D] flex items-center gap-1 shadow-sm font-medium"><i data-lucide="clock" class="w-3 h-3"></i> Full-time</span>
                                <span class="px-3 py-1 bg-[#E8F4F8] rounded-full text-sm text-[#AEC6CF] flex items-center gap-1 shadow-sm font-medium"><i data-lucide="map-pin" class="w-3 h-3"></i> Jakarta Selatan</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">Mencari nail artist berbakat dengan passion di bidang nail art. Pengalaman minimal 1 tahun dengan teknik dasar gel, manicure, dan pedicure.</p>
                    <button class="w-full py-3 bg-white text-gray-800 rounded-xl border border-gray-200 hover:border-[#D8859D] hover:text-[#D8859D] transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-md group-hover:scale-105 font-semibold">
                        Apply Now <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
                <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="space-y-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#FFE4E9] to-[#E8F4F8] rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="briefcase" class="text-[#D8859D] w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 mb-2 text-xl font-bold">Receptionist</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-[#FFE4E9] rounded-full text-sm text-[#D8859D] flex items-center gap-1 shadow-sm font-medium"><i data-lucide="clock" class="w-3 h-3"></i> Full-time</span>
                                <span class="px-3 py-1 bg-[#E8F4F8] rounded-full text-sm text-[#AEC6CF] flex items-center gap-1 shadow-sm font-medium"><i data-lucide="map-pin" class="w-3 h-3"></i> Jakarta Selatan</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">Bertanggung jawab dalam mengelola jadwal appointment, customer service, dan operasional front desk dengan attitude yang ramah dan profesional.</p>
                    <button class="w-full py-3 bg-white text-gray-800 rounded-xl border border-gray-200 hover:border-[#D8859D] hover:text-[#D8859D] transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-md group-hover:scale-105 font-semibold">
                        Apply Now <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
                <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="space-y-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#FFE4E9] to-[#E8F4F8] rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="briefcase" class="text-[#D8859D] w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-900 mb-2 text-xl font-bold">Content Creator</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-[#FFE4E9] rounded-full text-sm text-[#D8859D] flex items-center gap-1 shadow-sm font-medium"><i data-lucide="clock" class="w-3 h-3"></i> Part-time</span>
                                <span class="px-3 py-1 bg-[#E8F4F8] rounded-full text-sm text-[#AEC6CF] flex items-center gap-1 shadow-sm font-medium"><i data-lucide="map-pin" class="w-3 h-3"></i> Hybrid</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">Membuat konten kreatif untuk social media, fotografi nail art, dan video tutorial. Passion di beauty industry dan familiar dengan Instagram/TikTok.</p>
                    <button class="w-full py-3 bg-white text-gray-800 rounded-xl border border-gray-200 hover:border-[#D8859D] hover:text-[#D8859D] transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-md group-hover:scale-105 font-semibold">
                        Apply Now <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-600 mb-4 text-lg">Tidak menemukan posisi yang sesuai? Kirim CV Anda ke:</p>
                <a href="mailto:careers@nailsstudio.com" class="inline-block px-8 py-4 bg-gradient-to-r from-[#D8859D] to-[#AEC6CF] text-white rounded-full hover:shadow-lg hover:scale-105 transition-all duration-300 font-bold">
                    careers@nailsstudio.com
                </a>
            </div>
        </div>
    </section>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Smooth Scroll Function
        function scrollToSection(id) {
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Date Input Min Value (Today)
        const dateInput = document.getElementById('bookingDate');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }
    </script>
</body>
</html>