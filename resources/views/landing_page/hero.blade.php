<!-- resources/views/landing_page/hero.blade.php -->
<header class="hero-section" role="banner">
    <div class="hero-image-wrapper">
        <img 
            src="https://images.unsplash.com/photo-1599316329891-19df7fa9580d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxuYWlsJTIwYXJ0JTIwbWFuaWN1cmUlMjBlbGVnYW50fGVufDF8fHx8MTc2Mzg4MjcyMnww&ixlib=rb-4.1.0&q=80&w=1080" 
            alt="Elegant nail art manicure showcasing intricate designs" 
            class="hero-image"
        >
        <div class="hero-overlay"></div>
    </div>

    <div class="hero-content">
        <div class="decorative-badge animate-fade-in-up">
            <i data-lucide="sparkles" class="w-4 h-4"></i>
            <span class="text-sm tracking-wide font-medium">
                Premium Nail Art studio
            </span>
        </div>

        <h1 class="main-headline font-serif animate-fade-in-up delay-100">
            Elevate Your Nails,<br />
            <span> Elevate Your Confidence </span>
        </h1>

        <p class="subheadline animate-fade-in-up delay-200">
            Discover the art of beautiful nails with our expert artists. 
            From classic elegance to bold statements, we bring your vision to life 
            with precision, care, and creativity.
        </p>

        <div class="cta-group sm-flex-row animate-fade-in-up delay-300">
            <button onclick="scrollToSection('booking')" class="cta-button cta-primary btn-shine">
                <span class="relative z-10 flex items-center justify-center gap-2 text-white font-semibold">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    Book Appointment
                </span>
            </button>
            <button onclick="scrollToSection('top-products')" class="cta-button cta-secondary">
                <span class="flex items-center justify-center gap-2 font-semibold">
                    <i data-lucide="sparkles" class="w-5 h-5 transition-transform duration-300"></i>
                    Explore Designs
                </span>
            </button>
        </div>

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

    <div class="scroll-indicator" onclick="scrollToSection('top-products')">
        <div class="w-6 h-10 rounded-full border-2 border-gray-400/30 flex items-start justify-center p-2">
            <div class="scroll-dot"></div>
        </div>
    </div>
</header>
