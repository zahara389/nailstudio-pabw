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