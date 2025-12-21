@extends('layouts.app')

@section('title', 'Metode Pembayaran - Nails Studio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <style>
        :root {
            --primary: #db2777; 
            --primary-dark: #be185d;
            --bg-page: #f8fafc;
            --bg-surface: #ffffff;
            --text-heading: #0f172a;
            --text-body: #64748b;
            --border: #e2e8f0;
            --card-gradient: linear-gradient(135deg, #0f172a 0%, #331022 100%);
            --radius-md: 12px;
            --radius-lg: 24px;
            --shadow-subtle: 0 10px 30px -10px rgba(0,0,0,0.05);
            --shadow-hover: 0 20px 40px -10px rgba(219, 39, 119, 0.1);
        }

        /* --- Aesthetic Hero Improvements --- */
        .hero-section {
            background: radial-gradient(circle at 0% 0%, rgba(219, 39, 119, 0.03) 0%, transparent 40%),
                        radial-gradient(circle at 100% 100%, rgba(219, 39, 119, 0.03) 0%, transparent 40%);
            position: relative;
        }

        .hero-bg-grid {
            position: absolute; inset: 0;
            background-image: radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
            background-size: 32px 32px; opacity: 0.3;
            mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            z-index: 0;
        }

        .floating-blob {
            position: absolute; width: 400px; height: 400px;
            background: var(--primary); filter: blur(100px);
            opacity: 0.08; border-radius: 50%; z-index: 0; animation: float 15s infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(60px, 40px) scale(1.1); }
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 20px; background: white;
            color: var(--primary); border-radius: 100px; font-size: 0.8rem;
            font-weight: 700; margin-bottom: 2.5rem; border: 1px solid var(--border);
            box-shadow: var(--shadow-subtle);
            position: relative; z-index: 10;
        }

        /* --- Logo Payment Hover Effect --- */
        .partner-logo {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: grayscale(80%);
            opacity: 0.7;
            cursor: pointer;
        }

        .partner-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.15);
        }

        /* --- Payment Grid --- */
        .icon-circle {
            width: 56px; height: 56px; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.5rem; background-color: #fce7f3; color: #db2777;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .option-card {
            transition: all 0.3s ease; border: 1px solid var(--border);
            border-radius: 28px; background: white;
        }

        .option-card:hover {
            transform: translateY(-10px); border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .option-card:hover .icon-circle {
            transform: scale(1.1) rotate(8deg); background-color: var(--primary); color: #ffffff;
        }

        /* --- Bank Cards --- */
        .luxe-card {
            background: var(--card-gradient); border-radius: var(--radius-lg);
            padding: 2rem; color: white; position: relative; overflow: hidden;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2);
            min-height: 200px; display: flex; flex-direction: column; justify-content: space-between;
        }

        .rek-number { font-family: 'Space Mono', monospace; font-size: 1.4rem; font-weight: 700; letter-spacing: 1px; }

        .btn-copy-card {
            background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 12px; border-radius: 10px; font-size: 0.75rem; font-weight: 600;
            backdrop-filter: blur(4px); transition: 0.3s; color: white;
        }

        .btn-copy-card:hover { background: rgba(255, 255, 255, 0.2); }

        .step-pill {
            width: 28px; height: 28px; background: var(--primary); color: white;
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 800;
        }

        /* --- Modal Styling --- */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(10px); z-index: 2000;
            opacity: 0; visibility: hidden; transition: 0.3s;
            display: flex; align-items: center; justify-content: center; padding: 1.5rem;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-box { transform: scale(0.9); transition: 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); background: white; border-radius: 32px; width: 100%; max-width: 400px; padding: 2.5rem; }
        .modal-overlay.active .modal-box { transform: scale(1); }

        .toast {
            position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) translateY(100px);
            background: #0f172a; color: white; padding: 10px 20px; border-radius: 50px;
            font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;
            opacity: 0; transition: 0.4s; z-index: 3000; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .toast.active { opacity: 1; transform: translateX(-50%) translateY(0); }
    </style>
@endpush

@section('content')
<main>
    <section class="hero-section relative bg-white border-b border-gray-100 pt-40 pb-28 overflow-hidden text-center">
        <div class="hero-bg-grid"></div>
        <div class="floating-blob" style="top: -10%; left: -5%;"></div>
        <div class="floating-blob" style="bottom: -10%; right: -5%; background: #6366f1; opacity: 0.05;"></div>
        
        <div class="container mx-auto relative z-10 px-4">
            <div class="hero-badge mx-auto">
                <i data-lucide="shield-check" class="w-4 h-4"></i> Official Payment Gateway Nails Studio
            </div>
            
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-8 tracking-tighter leading-tight">
                Transaksi Aman, <br>
                <span style="color:var(--primary); background: linear-gradient(120deg, #db2777 0%, #be185d 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Cantik Maksimal.</span>
            </h1>

            <p class="text-slate-500 text-lg md:text-xl max-w-2xl mx-auto mb-16 font-medium leading-relaxed">
                Kami menyediakan berbagai pilihan metode pembayaran yang praktis dan aman untuk memastikan pengalaman reservasi Anda tetap menyenangkan.
            </p>
            
            <div class="flex justify-center items-center gap-8 md:gap-16 flex-wrap relative z-10">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="partner-logo h-10">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="partner-logo h-7">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="partner-logo h-9">
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay" class="partner-logo h-7">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="Dana" class="partner-logo h-8">
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50/50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-24">
                <div class="option-card p-8 cursor-pointer group" onclick="openModal('modal-qris')">
                    <div class="icon-circle"><i data-lucide="qr-code"></i></div>
                    <h3 class="font-bold text-xl mb-2 text-slate-900">QRIS</h3>
                    <p class="text-sm text-slate-500 font-medium leading-snug">Scan & Bayar instan via aplikasi apapun.</p>
                </div>
                <div class="option-card p-8 cursor-pointer group" onclick="openModal('modal-cc')">
                    <div class="icon-circle"><i data-lucide="credit-card"></i></div>
                    <h3 class="font-bold text-xl mb-2 text-slate-900">Cards</h3>
                    <p class="text-sm text-slate-500 font-medium leading-snug">Debit & Kredit (Visa / Mastercard).</p>
                </div>
                <div class="option-card p-8 cursor-pointer group" onclick="openModal('modal-ewallet')">
                    <div class="icon-circle"><i data-lucide="wallet"></i></div>
                    <h3 class="font-bold text-xl mb-2 text-slate-900">E-Wallet</h3>
                    <p class="text-sm text-slate-500 font-medium leading-snug">Gopay, OVO, Dana, ShopeePay.</p>
                </div>
                <div class="option-card p-8 cursor-pointer group" onclick="openModal('modal-cash')">
                    <div class="icon-circle"><i data-lucide="banknote"></i></div>
                    <h3 class="font-bold text-xl mb-2 text-slate-900">Tunai</h3>
                    <p class="text-sm text-slate-500 font-medium leading-snug">Lakukan pembayaran di kasir studio.</p>
                </div>
                <div class="option-card p-8 cursor-pointer group" onclick="openModal('modal-transfer')">
                    <div class="icon-circle"><i data-lucide="landmark"></i></div>
                    <h3 class="font-bold text-xl mb-2 text-slate-900">Transfer</h3>
                    <p class="text-sm text-slate-500 font-medium leading-snug">Transfer manual via BCA / Mandiri.</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <div class="space-y-12">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Cara Pembayaran</h2>
                        <p class="text-slate-500 font-medium mb-10">Ikuti 3 langkah mudah berikut ini:</p>
                        <div class="space-y-8">
                            <div class="flex gap-6">
                                <div class="step-pill shrink-0">01</div>
                                <div>
                                    <h5 class="font-bold text-slate-900 mb-1">Pilih Metode</h5>
                                    <p class="text-sm text-slate-500 leading-relaxed">Klik salah satu kartu di atas untuk melihat instruksi pembayaran.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="step-pill shrink-0">02</div>
                                <div>
                                    <h5 class="font-bold text-slate-900 mb-1">Selesaikan Transaksi</h5>
                                    <p class="text-sm text-slate-500 leading-relaxed">Bayar sesuai nominal yang tertera pada invoice Anda.</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="step-pill shrink-0">03</div>
                                <div>
                                    <h5 class="font-bold text-slate-900 mb-1">Konfirmasi Pembayaran</h5>
                                    <p class="text-sm text-slate-500 leading-relaxed">Sistem akan memverifikasi atau kirim bukti bayar ke admin.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-4 bg-white border border-slate-200 p-6 rounded-2xl">
                        <div class="flex items-center gap-3"><i data-lucide="lock" class="text-slate-400 w-5 h-5"></i><span class="text-[10px] font-black uppercase tracking-widest text-slate-400">SSL Encrypted</span></div>
                        <div class="flex items-center gap-3"><i data-lucide="verified" class="text-green-500 w-5 h-5"></i><span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Verified Hub</span></div>
                        <div class="flex items-center gap-3"><i data-lucide="refresh-cw" class="text-pink-500 w-5 h-5"></i><span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Real-time Pay</span></div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="luxe-card">
                        <div class="flex justify-between items-start"><div class="text-2xl font-black italic tracking-tighter">BCA</div><div class="chip"></div></div>
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-6"><span class="rek-number" id="rek-bca">1234 5678 9012</span><button class="btn-copy-card" onclick="copyText('rek-bca')">Salin No</button></div>
                            <div><p class="text-[10px] uppercase tracking-widest opacity-50 font-bold mb-1">Account Holder</p><p class="font-bold tracking-widest">NAILS STUDIO</p></div>
                        </div>
                    </div>
                    <div class="luxe-card" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 100%);">
                        <div class="flex justify-between items-start"><div class="text-2xl font-black italic tracking-tighter">MANDIRI</div><div class="chip"></div></div>
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-6"><span class="rek-number" id="rek-mandiri">0987 6543 2109</span><button class="btn-copy-card" onclick="copyText('rek-mandiri')">Salin No</button></div>
                            <div><p class="text-[10px] uppercase tracking-widest opacity-50 font-bold mb-1">Account Holder</p><p class="font-bold tracking-widest">NAILS STUDIO</p></div>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200 p-6 rounded-2xl flex items-center gap-4 transition-all hover:border-green-400 hover:shadow-lg">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center shrink-0"><i data-lucide="message-circle" class="w-6 h-6"></i></div>
                        <div><h6 class="font-bold text-slate-900 text-sm">Butuh bantuan bayar?</h6><p class="text-xs text-slate-500">Hubungi admin WhatsApp kami (24/7)</p></div>
                        <a href="https://wa.me/6285847255010?text=Halo%20Admin%20Nails%20Studio,%20saya%20butuh%20bantuan%20terkait%20pembayaran." target="_blank" class="ml-auto bg-green-500 text-white px-4 py-2 rounded-lg font-bold text-xs hover:bg-green-600 transition-colors">Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- MODALS --}}
{{-- Modal QRIS --}}
<div id="modal-qris" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-qris')">
    <div class="modal-box text-center">
        <div class="flex justify-center mb-6"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-8"></div>
        <div class="bg-slate-50 p-6 rounded-3xl mb-6 inline-block border border-slate-100"><img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=NailsStudioPayment" alt="QR Code" class="mx-auto rounded-xl"></div>
        <h3 class="text-xl font-bold text-slate-900 mb-2">Scan QRIS</h3>
        <p class="text-slate-500 text-sm mb-8">Scan kode di atas dengan e-wallet favorit Anda.</p>
        <button onclick="closeModal('modal-qris')" class="w-full bg-pink-600 text-white py-4 rounded-2xl font-bold">Tutup</button>
    </div>
</div>

{{-- Modal Cards --}}
<div id="modal-cc" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-cc')">
    <div class="modal-box">
        <h3 class="text-2xl font-bold text-slate-900 mb-4">Kartu Kredit/Debit</h3>
        <ul class="text-sm text-slate-600 space-y-3 mb-8">
            <li>1. Masukkan data kartu di checkout.</li>
            <li>2. Verifikasi kode OTP bank.</li>
            <li>3. Pembayaran otomatis terverifikasi.</li>
        </ul>
        <button onclick="closeModal('modal-cc')" class="w-full bg-pink-600 text-white py-4 rounded-2xl font-bold">Mengerti</button>
    </div>
</div>

{{-- Modal E-Wallet --}}
<div id="modal-ewallet" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-ewallet')">
    <div class="modal-box">
        <h3 class="text-2xl font-bold text-slate-900 mb-4">E-Wallet</h3>
        <p class="text-sm text-slate-600 mb-6">Pilih layanan (GoPay/ShopeePay/OVO) dan konfirmasi notifikasi yang muncul di ponsel Anda.</p>
        <button onclick="closeModal('modal-ewallet')" class="w-full bg-pink-600 text-white py-4 rounded-2xl font-bold">Tutup</button>
    </div>
</div>

{{-- Modal Tunai --}}
<div id="modal-cash" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-cash')">
    <div class="modal-box text-center">
        <h3 class="text-2xl font-bold text-slate-900 mb-4">Pembayaran Tunai</h3>
        <p class="text-sm text-slate-600 mb-8">Silakan bayar langsung di kasir studio kami setelah perawatan selesai.</p>
        <button onclick="closeModal('modal-cash')" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold">Oke</button>
    </div>
</div>

{{-- Modal Transfer --}}
<div id="modal-transfer" class="modal-overlay" onclick="if(event.target===this) closeModal('modal-transfer')">
    <div class="modal-box">
        <h3 class="text-2xl font-bold text-slate-900 mb-4">Transfer Manual</h3>
        <p class="text-sm text-slate-600 mb-6">Transfer ke rekening BCA/Mandiri kami, lalu kirim bukti transaksi ke admin WhatsApp.</p>
        <button onclick="closeModal('modal-transfer')" class="w-full bg-pink-600 text-white py-4 rounded-2xl font-bold">Selesai</button>
    </div>
</div>

<div id="toast" class="toast"><i data-lucide="check-circle" class="text-green-400 w-5 h-5"></i><span>Berhasil disalin!</span></div>
@endsection

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow = ''; }
    function copyText(id) {
        const text = document.getElementById(id).innerText.replace(/\s/g, '');
        navigator.clipboard.writeText(text).then(() => {
            const t = document.getElementById('toast'); t.classList.add('active');
            setTimeout(() => t.classList.remove('active'), 2500);
        });
    }
    document.addEventListener('DOMContentLoaded', () => { if (window.lucide) lucide.createIcons(); });
</script>
@endpush