<section id="booking-promo" class="promo-section">
    <div class="max-w-5xl mx-auto promo-container">
        <div class="promo-card">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="promo-content">
                    <div class="promo-icon-box">
                        <i data-lucide="calendar-heart"></i>
                    </div>
                    
                    <h2 class="promo-headline font-serif">Ready for Your Nail Glow-Up?</h2>
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
                            Book Your Slot Now!
                        </button>
                        
                        <button class="promo-btn-secondary">
                            <i data-lucide="info" class="w-5 h-5"></i>
                            Check Our Service Menu
                        </button>
                    </div>
                </div>

                <div class="promo-bg-gradient">
                    <div class="absolute inset-0 flex items-center justify-center p-12">
                        <div class="text-center text-white">
                            <div class="mb-6"><p style="font-size: 4rem; line-height: 1;">💅</p></div>
                            <h3 class="text-white mb-4 text-2xl font-bold">Our Signature Services</h3>
                            <div class="space-y-3 text-left bg-white/20 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                                <div class="text-white font-medium">• Manikur Klasik & Gel</div>
                                <div class="text-white font-medium">• Desain Nail Art Custom</div>
                                <div class="text-white font-medium">• Perawatan Pedikur Spa</div>
                                <div class="text-white font-medium">• Sambung & Perbaikan Kuku</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="booking" class="section-padding product-section">
    <div class="booking-container max-w-3xl mx-auto">
        <div class="section-header text-center">
            <h2 class="section-title font-serif">Book Your Appointment</h2>
            <p class="section-subtitle">
                Schedule your nail care session with our expert artists
            </p>
        </div>

        <div class="booking-form-wrapper bg-white shadow-xl rounded-lg p-8">
            
            {{-- NOTIFIKASI SUKSES (DIPERCANTIK) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl relative mb-6 flex items-start gap-4" role="alert">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600 mt-0.5"></i>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Booking Berhasil! 🎉</h3>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                @csrf 
                
                {{-- VALIDATION ERRORS --}}
                @if ($errors->any())
                    <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded mb-4">
                        <ul class="list-disc list-inside text-sm pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div>
                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">
                        <i data-lucide="map-pin" class="form-icon"></i>
                        Pilih Lokasi Studio
                    </label>
                    <select name="location" required class="form-select w-full border-gray-300 rounded-md shadow-sm p-2">
                        <option value="">Choose a Location...</option>
                        <option value="Cabang_Jakarta_Selatan" {{ old('location') == 'Cabang_Jakarta_Selatan' ? 'selected' : '' }}>📍 Cabang Jakarta Selatan (Kebayoran)</option>
                        <option value="Cabang_Bandung" {{ old('location') == 'Cabang_Bandung' ? 'selected' : '' }}>📍 Cabang Bandung (Riau Area)</option>
                        <option value="Home_Service" {{ old('location') == 'Home_Service' ? 'selected' : '' }}>🏠 Home Service (Area Jabodetabek)</option>
                    </select>
                </div>

                <div>
                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">
                        <i data-lucide="scissors" class="form-icon"></i>
                        Pilih Servis
                    </label>
                    <select name="service" required class="form-select w-full border-gray-300 rounded-md shadow-sm p-2">
                        <option value="">Choose a service...</option>
                        <option value="Classic Manicure" {{ old('service') == 'Classic Manicure' ? 'selected' : '' }}>Classic Manicure</option>
                        <option value="Gel Manicure" {{ old('service') == 'Gel Manicure' ? 'selected' : '' }}>Gel Manicure</option>
                        <option value="Pedicure" {{ old('service') == 'Pedicure' ? 'selected' : '' }}>Pedicure</option>
                        <option value="Nail_Art_Custom" {{ old('service') == 'Nail_Art_Custom' ? 'selected' : '' }}>Custom Nail Art</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label block text-sm font-medium text-gray-700 mb-1">
                            <i data-lucide="calendar" class="form-icon"></i>
                            Pilih Tanggal
                        </label>
                        <input type="date" name="date" id="bookingDate" required class="form-input w-full border-gray-300 rounded-md shadow-sm p-2" value="{{ old('date') }}">
                    </div>

                    <div>
                        <label class="form-label block text-sm font-medium text-gray-700 mb-1">
                            <i data-lucide="clock" class="form-icon"></i>
                            Pilih Waktu
                        </label>
                        <select name="time" required class="form-select w-full border-gray-300 rounded-md shadow-sm p-2">
                            <option value="">Pilih jam...</option>
                            <option value="10:00" {{ old('time') == '10:00' ? 'selected' : '' }}>10:00 WIB</option>
                            <option value="12:00" {{ old('time') == '12:00' ? 'selected' : '' }}>12:00 WIB</option>
                            <option value="14:00" {{ old('time') == '14:00' ? 'selected' : '' }}>14:00 WIB</option>
                            <option value="16:00" {{ old('time') == '16:00' ? 'selected' : '' }}>16:00 WIB</option>
                            <option value="18:00" {{ old('time') == '18:00' ? 'selected' : '' }}>18:00 WIB</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label block text-sm font-medium text-gray-700 mb-1">
                            <i data-lucide="user" class="form-icon"></i>
                            Nama Lengkap Anda
                        </label>
                        <input type="text" name="customer_name" required placeholder="Masukkan nama lengkap Anda" class="form-input w-full border-gray-300 rounded-md shadow-sm p-2" value="{{ old('customer_name') }}">
                    </div>

                <div>
    <label class="form-label block text-sm font-medium text-gray-700 mb-1">
        <i data-lucide="phone" class="form-icon"></i>
        No. WA Aktif
    </label>
    <input type="tel" 
           name="customer_phone" 
           required 
           placeholder="Wajib untuk konfirmasi!" 
           class="form-input w-full border-gray-300 rounded-md shadow-sm p-2" 
           value="{{ old('customer_phone') }}"
           
           {{-- Batasan sisi KLIEN (Browser): Hanya angka 9-15 digit --}}
           pattern="[0-9]{9,15}" 
           title="Nomor telepon hanya boleh berisi angka (9 sampai 15 digit)">
</div>
                </div>
                
                <div>
                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">
                        <i data-lucide="mail" class="form-icon"></i>
                        Email Anda
                    </label>
                    <input type="email" name="customer_email" required placeholder="Masukkan email Anda" class="form-input w-full border-gray-300 rounded-md shadow-sm p-2" value="{{ old('customer_email') }}">
                </div>
                
                <div>
                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">
                        <i data-lucide="message-square" class="form-icon"></i>
                        Notes / Request Khusus (Opsional)
                    </label>
                    <textarea name="notes" rows="3" placeholder="Contoh: Mau Nail Art untuk wedding / Mau bawa design referensi sendiri." class="form-input w-full border-gray-300 rounded-md shadow-sm p-2">{{ old('notes') }}</textarea>
                </div>

                <div class="p-4 bg-pink-50 border-l-4 border-pink-500 text-sm text-gray-700 rounded-md">
                    <p class="font-bold mb-1">FYI (For Your Information):</p>
                    <p>Detail lokasi studio, total biaya, dan konfirmasi akhir akan kami kirimkan via WhatsApp setelah Anda submit form ini. Jangan khawatir!</p>
                </div>

                <div class="flex items-center pt-2">
                    <input id="agreement" name="agreement" type="checkbox" required class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                    <label for="agreement" class="ml-2 block text-sm text-gray-900">
                        I agree to the <a href="#cancellation_policy" class="text-pink-600 font-medium hover:underline">Cancellation Policy & T&C</a>.
                    </label>
                </div>

                <button type="submit" class="submit-button w-full text-white font-bold py-2 px-4 rounded-md transition duration-150" style="background-color: #ff80bf;">
                    Confirm & Send Booking
                </button>
                
                <p class="text-xs text-center text-gray-500 mt-4">
                    Your data is safe with us. We only use it for appointment confirmation. <a href="#privacy" class="text-pink-600 hover:underline font-medium">Check Privacy Policy.</a>
                </p>
            </form>
        </div>
    </div>
    @if (session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

</section>