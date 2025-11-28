<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Nail Art Studio</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Diperlukan untuk framework default) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

</head>
<body>

    <!-- HERO SECTION -->
    <header class="hero-section" role="banner">
        
        <!-- Background Image -->
        <div class="hero-image-wrapper">
            <img 
                src="https://images.unsplash.com/photo-1599316329891-19df7fa9580d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxuYWlsJTIwYXJ0JTIwbWFuaWN1cmUlMjBlbGVnYW50fGVufDF8fHx8MTc2Mzg4MjcyMnww&ixlib=rb-4.1.0&q=80&w=1080" 
                alt="Elegant nail art manicure showcasing intricate designs" 
                class="hero-image"
            >
            <!-- Gradient Overlay -->
            <div class="hero-overlay"></div>
        </div>

        <!-- Hero Content -->
        <div class="hero-content">
            
            <!-- Decorative Badge -->
            <div class="decorative-badge animate-fade-in-up">
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                <span class="text-sm tracking-wide font-medium">
                    Premium Nail Art Experience
                </span>
            </div>

            <!-- Main Headline -->
            <h1 class="main-headline font-serif animate-fade-in-up delay-100">
                Elevate Your Nails,<br />
                <span>
                    Elevate Your Confidence
                </span>
            </h1>

            <!-- Subheadline -->
            <p class="subheadline animate-fade-in-up delay-200">
                Discover the art of beautiful nails with our expert artists. 
                From classic elegance to bold statements, we bring your vision to life 
                with precision, care, and creativity.
            </p>

            <!-- CTA Buttons -->
            <div class="cta-group sm-flex-row animate-fade-in-up delay-300">
                
                <!-- Primary CTA -->
                <button onclick="scrollToSection('booking-promo')" class="cta-button cta-primary btn-shine">
                    <span class="relative z-10 flex items-center justify-center gap-2 text-white font-semibold">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                        Book Appointment
                    </span>
                </button>

                <!-- Secondary CTA -->
                <button onclick="scrollToSection('top-products')" class="cta-button cta-secondary">
                    <span class="flex items-center justify-center gap-2 font-semibold">
                        <i data-lucide="sparkles" class="w-5 h-5 transition-transform duration-300"></i>
                        Explore Designs
                    </span>
                </button>
            </div>

            <!-- Trust Indicators -->
            <div class="trust-indicator-group animate-fade-in-up delay-400">
                <div class="text-center">
                    <div class="trust-value font-serif">500+</div>
                    <div class="trust-label">Happy Clients</div>
                </div>
                
                <div class="hidden sm:block indicator-divider"></div>
                
                <div class="text-center">
                    <div class="trust-value font-serif">15+</div>
                    <div class="trust-label">Years Experience</div>
                </div>
                
                <div class="hidden sm:block indicator-divider"></div>
                
                <div class="text-center">
                    <div class="trust-value font-serif">100%</div>
                    <div class="trust-label">Satisfaction</div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator" onclick="scrollToSection('top-products')">
            <div class="w-6 h-10 rounded-full border-2 border-gray-400/30 flex items-start justify-center p-2">
                <div class="scroll-dot"></div>
            </div>
        </div>
    </header>

    <!-- TOP PRODUCTS SECTION -->
    <section id="top-products" class="section-padding product-section">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="section-header">
                <h2 class="section-title font-serif">Top Products</h2>
                <p class="section-subtitle">
                    Our best-selling nail care essentials
                </p>
            </div>

            <!-- Products Grid -->
            <div class="grid-3-cols md-grid-3-cols">
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1608571899793-a1c0c27a7555?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxjdXRpY2xlJTIwb2lsJTIwYm90dGxlfGVufDF8fHx8MTc2Mzg4NTgwOHww&ixlib=rb-4.1.0&q=80&w=1080" alt="Cuticle Oil" class="product-image">
                        <span class="bestseller-badge">Bestseller</span>
                    </div>
                    <div class="product-info">
                        <h3 class="mb-2 text-xl font-semibold text-[#1a1a1a]">Cuticle Oil</h3>
                        <p class="product-price">$24.99</p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
                <!-- Product 2 -->
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1667242197579-10b000f004da?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxuYWlsJTIwcG9saXNoJTIwY29sbGVjdGlvbnxlbnwxfHx8fDE3NjM3OTA5MzF8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Premium Nail Polish" class="product-image">
                        <span class="bestseller-badge">Bestseller</span>
                    </div>
                    <div class="product-info">
                        <h3 class="mb-2 text-xl font-semibold text-[#1a1a1a]">Premium Nail Polish</h3>
                        <p class="product-price">$18.99</p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1617614207953-9beba84738a0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxjoYW5kJTIwY3JlYW0lMjBjb3NtZXRpY3xlbnwxfHx8fDE3NjM4ODU4MDl8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Luxury Hand Cream" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="mb-2 text-xl font-semibold text-[#1a1a1a]">Luxury Hand Cream</h3>
                        <p class="product-price">$29.99</p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCT CATEGORIES SECTION -->
    <section id="categories" class="section-padding bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="section-header">
                <h2 class="section-title font-serif">Product Categories</h2>
                <p class="section-subtitle">Explore our curated collections</p>
            </div>

            <div class="grid-4-cols sm-grid-2-cols lg-grid-4-cols">
                <!-- Category 1 -->
                <div class="category-card">
                    <div class="relative h-full">
                        <img src="https://images.unsplash.com/photo-1659391542239-9648f307c0b1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxnZWwlMjBuYWlsJTIwcG9saXNofGVufDF8fHx8MTc2Mzg2ODE4M3ww&ixlib=rb-4.1.0&q=80&w=1080" alt="Gel Polish" class="category-image">
                        <div class="category-overlay"></div>
                        <div class="category-content">
                            <div class="category-icon-wrapper icon-pink">
                                <i data-lucide="sparkles" class="w-6 h-6 text-[#030213]"></i>
                            </div>
                            <h3 class="category-title">Gel Polish</h3>
                            <p class="category-subtitle">Long-lasting shine</p>
                        </div>
                    </div>
                </div>
                <!-- Category 2 -->
                <div class="category-card">
                    <div class="relative h-full">
                        <img src="https://images.unsplash.com/photo-1619607536077-220f62b03d10?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxuYWlsJTIwYXJ0JTIwdG9vbHNfGVufDF8fHx8MTc2Mzg4NTgwOXww&ixlib=rb-4.1.0&q=80&w=1080" alt="Nail Art Tools" class="category-image">
                        <div class="category-overlay"></div>
                        <div class="category-content">
                            <div class="category-icon-wrapper icon-blue">
                                <i data-lucide="brush" class="w-6 h-6 text-[#030213]"></i>
                            </div>
                            <h3 class="category-title">Nail Art Tools</h3>
                            <p class="category-subtitle">Professional equipment</p>
                        </div>
                    </div>
                </div>
                <!-- Category 3 -->
                <div class="category-card">
                    <div class="relative h-full">
                        <img src="https://images.unsplash.com/photo-1616815432742-0233fc9621ad?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxuYWlsJTIwY2FyZSUyMHByb2R1Y3RzfGVufDF8fHx8MTc2Mzg4NTgwOXww&ixlib=rb-4.1.0&q=80&w=1080" alt="Nail Care" class="category-image">
                        <div class="category-overlay"></div>
                        <div class="category-content">
                            <div class="category-icon-wrapper icon-pink">
                                <i data-lucide="heart" class="w-6 h-6 text-[#030213]"></i>
                            </div>
                            <h3 class="category-title">Nail Care</h3>
                            <p class="category-subtitle">Essential treatments</p>
                        </div>
                    </div>
                </div>
                <!-- Category 4 -->
                <div class="category-card">
                    <div class="relative h-full">
                        <img src="https://images.unsplash.com/photo-1743594788846-d3fcfe0055d2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxiZWF1dHklMjBhY2Nlc3Nvcmllc3xlbnwxfHx8fDE3NjM4ODU4MTB8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Accessories" class="category-image">
                        <div class="category-overlay"></div>
                        <div class="category-content">
                            <div class="category-icon-wrapper icon-blue">
                                <i data-lucide="gem" class="w-6 h-6 text-[#030213]"></i>
                            </div>
                            <h3 class="category-title">Accessories</h3>
                            <p class="category-subtitle">Beauty essentials</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- BOOKING PROMOTION SECTION (RE-INSERTED) -->
    <section id="booking-promo" class="promo-section">
        <div class="max-w-5xl mx-auto promo-container">
            <div class="promo-card">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Left Side - Content -->
                    <div class="promo-content">
                        <div class="promo-icon-box">
                            <i data-lucide="calendar-heart"></i>
                        </div>
                        
                        <h2 class="promo-headline font-serif">Ready for a Transformation?</h2>
                        <p class="text-gray-600 mb-6">
                            Manjakan diri Anda dengan perawatan kuku terbaik di kelasnya. Terapis profesional kami siap mewujudkan kuku impian Anda.
                        </p>
                        
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3 promo-list-item">
                                <div class="promo-list-dot"></div>
                                <span class="text-gray-700">Terapis berpengalaman & tersertifikasi</span>
                            </div>
                            <div class="flex items-center gap-3 promo-list-item">
                                <div class="promo-list-dot"></div>
                                <span class="text-gray-700">Alat steril & higienis (Medical Grade)</span>
                            </div>
                            <div class="flex items-center gap-3 promo-list-item">
                                <div class="promo-list-dot"></div>
                                <span class="text-gray-700">Garansi kepuasan pelanggan 100%</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="scrollToSection('booking')" class="promo-btn-primary">
                                Book Appointment Now
                            </button>
                            
                            <button class="promo-btn-secondary">
                                <i data-lucide="info" class="w-5 h-5"></i>
                                View Service Menu
                            </button>
                        </div>
                    </div>

                    <!-- Right Side - Image/Background -->
                    <div class="promo-bg-gradient">
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
    
    <!-- BOOKING FORM SECTION -->
    <section id="booking" class="section-padding product-section">
        <div class="booking-container">
            <div class="section-header">
                <h2 class="section-title font-serif">Book Your Appointment</h2>
                <p class="section-subtitle">
                    Schedule your nail care session with our expert artists
                </p>
            </div>

            <div class="booking-form-wrapper">
                <form id="bookingForm" class="space-y-6">
                    <!-- Service Selection -->
                    <div>
                        <label class="form-label">
                            <i data-lucide="calendar" class="form-icon"></i>
                            Select Service
                        </label>
                        <select name="service" required class="form-select">
                            <option value="">Choose a service...</option>
                            <option value="Classic Manicure">Classic Manicure</option>
                            <option value="Gel Manicure">Gel Manicure</option>
                            <option value="Nail Art Design">Nail Art Design</option>
                            <option value="Pedicure">Pedicure</option>
                            <option value="Nail Extension">Nail Extension</option>
                            <option value="Nail Care Treatment">Nail Care Treatment</option>
                        </select>
                    </div>

                    <div class="grid-3-cols md-grid-2-cols">
                        <!-- Date Selection -->
                        <div>
                            <label class="form-label">
                                <i data-lucide="calendar" class="form-icon"></i>
                                Select Date
                            </label>
                            <input type="date" name="date" id="bookingDate" required class="form-input">
                        </div>

                        <!-- Time Selection -->
                        <div>
                            <label class="form-label">
                                <i data-lucide="clock" class="form-icon"></i>
                                Select Time
                            </label>
                            <select name="time" required class="form-select">
                                <option value="">Choose a time...</option>
                                <option value="09:00 AM">09:00 AM</option>
                                <option value="10:00 AM">10:00 AM</option>
                                <option value="11:00 AM">11:00 AM</option>
                                <option value="12:00 PM">12:00 PM</option>
                                <option value="01:00 PM">01:00 PM</option>
                                <option value="02:00 PM">02:00 PM</option>
                                <option value="03:00 PM">03:00 PM</option>
                                <option value="04:00 PM">04:00 PM</option>
                                <option value="05:00 PM">05:00 PM</option>
                                <option value="06:00 PM">06:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid-3-cols md-grid-2-cols">
                        <!-- Name -->
                        <div>
                            <label class="form-label">
                                <i data-lucide="user" class="form-icon"></i>
                                Your Name
                            </label>
                            <input type="text" name="name" required placeholder="Enter your full name" class="form-input">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="form-label">
                                <i data-lucide="phone" class="form-icon"></i>
                                Phone Number
                            </label>
                            <input type="tel" name="phone" required placeholder="Enter your phone number" class="form-input">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-button">
                        Confirm Booking
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- MEET OUR TEAM SECTION -->
    <section id="team" class="section-padding team-section-bg">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="section-header space-y-4">
                <div class="team-header-badge">
                    💅 Meet Our Team
                </div>
                <h2 class="section-title font-serif">Our Expert Nail Artists</h2>
                <p class="section-subtitle max-w-2xl mx-auto">
                    Tim profesional kami siap memberikan pengalaman nail art terbaik dengan keahlian dan dedikasi tinggi
                </p>
            </div>

            <!-- Team Grid -->
            <div class="grid-3-cols md-grid-3-cols">
                
                <!-- Member 1: Jessica Kim -->
                <div class="team-card">
                    <!-- Photo Container -->
                    <div class="team-photo-area">
                        <div class="relative w-40 h-40 mx-auto team-photo-wrapper">
                            <!-- Decorative rings -->
                            <div class="team-photo-ring-1 animate-pulse"></div>
                            
                            <!-- White Frame (Ring 2 equivalent) -->
                            <div class="team-photo-frame"></div>

                            <!-- Photo -->
                            <div class="team-photo-inner">
                                <img 
                                    src="https://images.unsplash.com/photo-1649589244330-09ca58e4fa64?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxjoHJvZmVzc2lvbmFsJTIwd29tYW4lMjBwb3J0cmFpdHxlbnwxfHx8fDE3NjM2Mjk5MTR8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                    alt="Jessica Kim" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>

                        <!-- Award badge -->
                        <div class="award-badge">
                            <i data-lucide="award" class="award-icon"></i>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="team-info">
                        <div>
                            <h3 class="team-name">Jessica Kim</h3>
                            <p class="team-role">Lead Nail Artist</p>
                        </div>
                        
                        <p class="team-description mt-4">
                            8 tahun pengalaman dalam nail art dengan spesialisasi Korean nail design dan gel techniques.
                        </p>

                        <!-- Specialties -->
                        <div class="specialties-group mt-4">
                            <span class="specialty-tag">
                                <i data-lucide="star" class="specialty-icon"></i>
                                Korean Art
                            </span>
                            <span class="specialty-tag">
                                <i data-lucide="star" class="specialty-icon"></i>
                                Gel Nails
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Member 2: Amanda Chen -->
                <div class="team-card">
                    <div class="team-photo-area">
                        <div class="relative w-40 h-40 mx-auto team-photo-wrapper">
                            <div class="team-photo-ring-1 animate-pulse"></div>
                            <div class="team-photo-frame"></div>
                            <div class="team-photo-inner">
                                <img 
                                    src="https://images.unsplash.com/photo-1653130029149-9109b115ab9a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxiZWF1dHklMjBzYWxvbiUyMHByb2Zlc3Npb25hbHxlbnwxfHx8fDE3NjM2Njk3OTN8MA&ixlib=rb-4.1.0&q=80&utm_source=figma&utm_medium=referral" 
                                    alt="Amanda Chen" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>
                        <div class="award-badge">
                            <i data-lucide="award" class="award-icon"></i>
                        </div>
                    </div>
                    <div class="team-info">
                        <div>
                            <h3 class="team-name">Amanda Chen</h3>
                            <p class="team-role">Senior Nail Technician</p>
                        </div>
                        <p class="team-description mt-4">
                            6 tahun berpengalaman dengan sertifikasi internasional dalam nail care dan manicure pedicure.
                        </p>
                        <div class="specialties-group mt-4">
                            <span class="specialty-tag">
                                <i data-lucide="star" class="specialty-icon"></i>
                                Extensions
                            </span>
                            <span class="specialty-tag">
                                <i data-lucide="star" class="specialty-icon"></i>
                                Nail Care
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Member 3: Sophie Laurent -->
                <div class="team-card">
                    <div class="team-photo-area">
                        <div class="relative w-40 h-40 mx-auto team-photo-wrapper">
                            <div class="team-photo-ring-1 animate-pulse"></div>
                            <div class="team-photo-frame"></div>
                            <div class="team-photo-inner">
                                <img 
                                    src="https://images.unsplash.com/photo-1668191174012-7d5a78e454a5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxlbGVnYW50JTIwd29tYW4lMjBwb3J0cmFpdHxlbnwxfHx8fDE3NjM2OTYyMDN8MA&ixlib=rb-4.1.0&q=80&utm_source=figma&utm_medium=referral" 
                                    alt="Sophie Laurent" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>
                        <div class="award-badge">
                            <i data-lucide="award" class="award-icon"></i>
                        </div>
                    </div>
                    <div class="team-info">
                        <div>
                            <h3 class="team-name">Sophie Laurent</h3>
                            <p class="team-role">Nail Art Specialist</p>
                        </div>
                        <p class="team-description mt-4">
                            5 tahun mengkreasikan nail art custom dengan detail halus dan desain yang unik dan trendy.
                        </p>
                        <div class="specialties-group mt-4">
                            <span class="specialty-tag">
                                <i data-lucide="star" class="specialty-icon"></i>
                                Custom Art
                            </span>
                            <span class="specialty-tag">
                                <i data-lucide="star" class="specialty-icon"></i>
                                3D Designs
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CAREERS SECTION -->
    <section id="careers" class="career-section">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="career-header">
                <div class="career-badge">
                    💼 Join Our Team
                </div>
                <h2 class="section-title font-serif career-title">Career Opportunities</h2>
                <p class="section-subtitle career-subtitle">
                    Bergabunglah dengan tim kami dan berkembang bersama dalam industri beauty yang dinamis dan kreatif
                </p>
            </div>

            <!-- Jobs Grid Container -->
            <div id="jobs-grid" class="career-jobs-grid">
                <!-- Job cards will be inserted here by JavaScript -->
            </div>

            <!-- CTA Footer -->
            <div class="career-cta-text">
                <p class="text-gray-600 mb-4 text-lg">
                    Tidak menemukan posisi yang sesuai? Kirim CV Anda ke:
                </p>
                <a 
                    href="mailto:careers@nailsstudio.com"
                    class="career-cta-btn"
                >
                    careers@nailsstudio.com
                </a>
            </div>
        </div>
    </section>

    <script>
        // Data Lowongan Kerja
        const jobs = [
            {
                id: 1,
                title: 'Nail Artist Junior',
                type: 'Full-time',
                location: 'Jakarta Selatan',
                description: 'Mencari nail artist berbakat dengan passion di bidang nail art. Pengalaman minimal 1 tahun dengan teknik dasar gel, manicure, dan pedicure.',
                requirements: ['Min. 1 tahun pengalaman', 'Menguasai teknik gel nails', 'Kreatif dan detail-oriented']
            },
            {
                id: 2,
                title: 'Receptionist',
                type: 'Full-time',
                location: 'Jakarta Selatan',
                description: 'Bertanggung jawab dalam mengelola jadwal appointment, customer service, dan operasional front desk dengan attitude yang ramah dan profesional.',
                requirements: ['Pengalaman customer service', 'Komunikasi baik', 'Mampu multitasking']
            },
            {
                id: 3,
                title: 'Content Creator',
                type: 'Part-time',
                location: 'Hybrid',
                description: 'Membuat konten kreatif untuk social media, fotografi nail art, dan video tutorial. Passion di beauty industry dan familiar dengan Instagram/TikTok.',
                requirements: ['Portfolio konten beauty', 'Editing foto & video', 'Update trend social media']
            }
        ];

        // Fungsi untuk membuat HTML job card
        function createJobCard(job) {
            const card = document.createElement('div');
            card.className = 'career-job-card group'; 

            // Icon Box
            const iconBox = document.createElement('div');
            iconBox.className = 'career-icon-box group-hover:scale-110';
            iconBox.innerHTML = '<i data-lucide="briefcase"></i>'; 
            
            // Title 
            const titleH3 = document.createElement('h3');
            titleH3.className = 'career-job-title';
            titleH3.textContent = job.title;

            // Tags
            const tagsDiv = document.createElement('div');
            tagsDiv.className = 'career-chips-group';

            // Type Tag
            const typeTag = document.createElement('span');
            typeTag.className = 'career-chip career-chip-clock';
            typeTag.innerHTML = <i data-lucide="clock" class="career-chip-clock"></i> <span>${job.type}</span>;
            
            // Location Tag
            const locationTag = document.createElement('span');
            locationTag.className = 'career-chip career-chip-map';
            locationTag.innerHTML = <i data-lucide="map-pin" class="career-chip-map"></i> <span>${job.location}</span>;

            tagsDiv.appendChild(typeTag);
            tagsDiv.appendChild(locationTag);
            
            // Description
            const descriptionP = document.createElement('p');
            descriptionP.className = 'career-description';
            descriptionP.textContent = job.description;

            // Requirements
            const reqDiv = document.createElement('div');
            reqDiv.className = 'career-requirements';

            const reqTitle = document.createElement('div');
            reqTitle.className = 'career-req-title';
            reqTitle.textContent = 'Requirements:';
            
            const reqList = document.createElement('ul');
            reqList.className = 'career-req-list';
            
            job.requirements.forEach(req => {
                const li = document.createElement('li');
                li.className = 'career-req-list-item'; 
                
                const checkIcon = document.createElement('span');
                checkIcon.className = 'career-req-check';
                checkIcon.textContent = '✓';

                const textSpan = document.createElement('span');
                textSpan.textContent = req;
                
                li.appendChild(checkIcon);
                li.appendChild(textSpan);
                reqList.appendChild(li);
            });
            
            reqDiv.appendChild(reqTitle);
            reqDiv.appendChild(reqList);

            // Apply Button
            const applyButton = document.createElement('button');
            applyButton.className = 'career-apply-btn flex items-center justify-center gap-2 group-hover:scale-105';
            applyButton.innerHTML = Apply Now <i data-lucide="arrow-right"></i>;

            card.appendChild(iconBox);
            card.appendChild(titleH3);
            card.appendChild(tagsDiv);
            card.appendChild(descriptionP);
            card.appendChild(reqDiv);
            card.appendChild(applyButton);

            return card;
        }

        // Fungsi utama untuk inisialisasi
        window.onload = function () {
            // 1. Initialize Lucide Icons for static content
            lucide.createIcons();
            
            // 2. Render Job Cards
            const jobsGrid = document.getElementById('jobs-grid');
            if (jobsGrid) {
                jobs.forEach(job => {
                    const card = createJobCard(job);
                    jobsGrid.appendChild(card);
                });
            }
            
            // 3. Re-initialize Lucide Icons after adding new dynamic elements
            lucide.createIcons();
        };


        // Smooth Scroll Function (dipertahankan dari kode sebelumnya)
        function scrollToSection(id) {
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                console.log(Section ${id} not found in this demo.);
            }
        }

        // Date Input Min Value (Today)
        const dateInput = document.getElementById('bookingDate');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }

        // Handle Form Submission (dipertahankan dari kode sebelumnya)
        const form = document.getElementById('bookingForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                
                const confirmationMessage = Booking confirmed for ${data.name}!\nService: ${data.service}\nDate: ${data.date} at ${data.time}\nWe will contact you at ${data.phone} shortly.;
                console.log(confirmationMessage);
                alert(confirmationMessage); 
                
                form.reset();
            });
        }
    </script>
</body>
</html>