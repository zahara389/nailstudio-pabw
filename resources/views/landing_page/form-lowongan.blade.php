@extends('layouts.app')

@section('title', 'Form Lamaran Kerja')

@section('content')
    <title>Form Lamaran Kerja</title>
    
    <link rel="stylesheet" href="{{ asset('styles.css') }}"> 
    <script defer src="{{ asset('script.js') }}"></script>
    
    <style>
        /* CSS MINIMAL UNTUK DEMO FORM - JIKA STYLES.CSS HILANG */
        .container { max-width: 1200px; margin: 40px auto; padding: 20px; }
        .grid-container { display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; }
        .card { padding: 20px; border: 1px solid #eee; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 15px; }
        .required { color: red; }
        input[type="text"], input[type="email"], input[type="tel"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 100px; }
        .submit-btn { padding: 10px 20px; background-color: #f7a8b8; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .submit-btn:hover { background-color: #e68fa3; }
        .success-message { display: none; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px; margin-bottom: 20px; text-align: center; }
        .nail-image { width: 100%; height: auto; border-radius: 6px; }
        .benefit-item { display: flex; align-items: center; margin-bottom: 10px; }
        .dot { width: 8px; height: 8px; background-color: #f7a8b8; border-radius: 50%; margin-right: 10px; }
        .file-name { font-size: 14px; color: #666; margin-top: 5px; }
        .error-message { color: red; font-size: 12px; margin-top: 5px; }
    </style>
</head>
    <div class="container">
        <div class="header-section">
            <h1 class="main-title">Join Our Team</h1>
            @if(isset($job))
                <h2 style="color: #f7a8b8;">Melamar untuk posisi: {{ $job->title }}</h2>
            @endif
            <p class="subtitle">
                Ciptakan karya seni di ujung jari bersama nail art studio terbaik
            </p>
        </div>

        <div class="grid-container">
            <div class="image-section">
                <div class="card image-card">
                    <img src="https://images.unsplash.com/photo-1610992015732-2449b76344bc?w=800&q=80" alt="Nail Art Studio" class="nail-image">
                </div>
                <div class="card benefits-card">
                    <div class="card-header"><h2 class="card-title">Kenapa Bergabung dengan Kami?</h2></div>
                    <div class="card-content">
                        <div class="benefit-item"><div class="dot"></div><p>Lingkungan kerja yang kreatif dan supportif</p></div>
                        <div class="benefit-item"><div class="dot"></div><p>Pelatihan dan pengembangan skill berkelanjutan</p></div>
                        <div class="benefit-item"><div class="dot"></div><p>Kompensasi yang kompetitif</p></div>
                        <div class="benefit-item"><div class="dot"></div><p>Kesempatan berkarya dengan produk premium</p></div>
                    </div>
                </div>
            </div>

            <div class="form-section card">
                <div class="card-header form-header">
                    <h2 class="form-title">Form Lamaran Kerja</h2>
                    <p class="form-description">Isi form di bawah ini dengan lengkap dan benar</p>
                </div>
                <div class="card-content">
                    {{-- Pesan Sukses/Error dari Controller --}}
                    @if (session('success'))
                        <div class="success-message" style="display:block;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <h3>Terima Kasih!</h3>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="success-message" style="display:block; background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;">
                            <h3>Gagal!</h3>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    <form id="job-form" class="form" method="POST" action="{{ route('job.submit') }}" enctype="multipart/form-data">
                        @csrf 

                        <input type="hidden" name="job_id" value="{{ $jobId ?? '' }}"> 
                        
                        {{-- Validasi job_id hilang --}}
                        @error('job_id') <p class="error-message">Lowongan tidak valid atau hilang. Silakan kembali ke halaman utama.</p> @enderror

                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
                            @error('name') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                            @error('email') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Nomor Telepon <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" placeholder="08xx xxxx xxxx" value="{{ old('phone') }}" required>
                            @error('phone') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Kotak upload CV --}}
                    <div class="form-group">
                        <label for="cv">Upload CV <span class="required">*</span></label>
                        <div class="cv-box">
                            <input type="file" id="cv" name="cv_file" accept=".pdf" required>
                        </div>
                        <p id="file-name" class="file-name">Pilih file CV (PDF)</p>
                        @error('cv_file') <p class="error-message">{{ $message }}</p> @enderror
                    </div>
                        
                        <div class="form-group">
                            <label for="description">Deskripsi Diri <span class="required">*</span></label>
                            <textarea id="description" name="description" placeholder="Ceritakan tentang diri Anda..." required>{{ old('description') }}</textarea>
                            @error('description') <p class="error-message">{{ $message }}</p> @enderror
                        </div>
                        
                        <button type="submit" class="submit-btn">Kirim Lamaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Script untuk menampilkan nama file yang dipilih (Asumsi ini tidak ada di script.js) --}}
    <script>
        document.getElementById('cv').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file CV (PDF)';
            document.getElementById('file-name').textContent = fileName;
        });
        
        // Asumsi logic success message sudah ditangani oleh Controller/Blade session.
    </script>
</body>
</html>
@endsection