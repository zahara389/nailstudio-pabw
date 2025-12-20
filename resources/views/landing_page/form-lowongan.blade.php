@extends('layouts.app')

@section('title', 'Form Lamaran Kerja')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-pink: #FFADBD;
        --primary-hover: #e69ba9;
        --soft-pink: #fff0f3;
        --lavender: #d8b4fe;
    }

    body { font-family: 'Inter', sans-serif; }
    .font-serif { font-family: 'Playfair Display', serif; }

    .glass-card {
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,173,189,.25);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-pink);
        box-shadow: 0 0 0 3px rgba(255,173,189,.25);
    }

    .custom-upload {
        border: 2px dashed #cbd5e1;
        transition: .25s;
    }

    .custom-upload:hover {
        border-color: var(--primary-pink);
        background: var(--soft-pink);
    }

    .btn-primary {
        background: var(--primary-pink);
        transition: .3s;
    }

    .btn-primary:hover {
        background: var(--primary-hover);
        transform: scale(1.02);
        box-shadow: 0 12px 30px rgba(255,173,189,.45);
    }
</style>

<div class="min-h-screen py-10 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">

        {{-- HEADER --}}
        <header class="text-center mb-12">
            <h1 class="font-serif text-5xl italic mb-3">Join Our Team</h1>

            @if(isset($job))
                <h2 class="text-lg text-[#FFADBD] font-medium uppercase tracking-wide mb-2">
                    Melamar untuk posisi: {{ $job->title }}
                </h2>
            @endif

            <div class="w-20 h-1 bg-[#FFADBD] mx-auto mb-4"></div>

            <p class="text-gray-500 max-w-xl mx-auto">
                Ciptakan karya seni di ujung jari bersama nail art studio terbaik
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- LEFT --}}
            <div class="lg:col-span-5 space-y-6">
                <img src="https://images.unsplash.com/photo-1610992015732-2449b76344bc?w=800&q=80"
                     class="rounded-2xl shadow-xl h-72 w-full object-cover">

                <div class="p-6 rounded-2xl bg-gradient-to-br from-pink-50 to-purple-50 border">
                    <h3 class="font-serif text-xl mb-4">Kenapa Bergabung?</h3>
                    <ul class="space-y-2 text-gray-700 text-sm">
                        <li>• Lingkungan kerja kreatif & supportif</li>
                        <li>• Pelatihan & pengembangan skill</li>
                        <li>• Kompensasi kompetitif & bonus</li>
                        <li>• Produk premium kelas dunia</li>
                    </ul>
                </div>
            </div>

            {{-- RIGHT : FORM --}}
            <div class="lg:col-span-7">
                <div class="glass-card rounded-2xl shadow-xl overflow-hidden">

                    <div class="bg-gradient-to-r from-[#FFADBD]/10 to-[#D8B4FE]/10 px-6 py-4 border-b">
                        <h2 class="text-xl font-semibold">Form Lamaran Kerja</h2>
                        <p class="text-sm text-gray-500">Lengkapi data diri Anda</p>
                    </div>

                    <form method="POST"
                          action="{{ route('job.submit') }}"
                          enctype="multipart/form-data"
                          class="p-6 space-y-4">

                        @csrf
                        <input type="hidden" name="job_id" value="{{ $jobId ?? '' }}">

                        {{-- NAMA + TELEPON --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-input w-full px-3 py-2.5 rounded-lg bg-gray-50 border"
                                       required>
                                @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="text-sm font-semibold">Nomor Telepon *</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                       class="form-input w-full px-3 py-2.5 rounded-lg bg-gray-50 border"
                                       required>
                                @error('phone') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label class="text-sm font-semibold">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-input w-full px-3 py-2.5 rounded-lg bg-gray-50 border"
                                   required>
                            @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

                        {{-- CV --}}
                        <div>
                            <label class="text-sm font-semibold">Upload CV (PDF) *</label>
                            <label class="custom-upload flex items-center justify-center gap-3 px-4 py-4 rounded-lg cursor-pointer mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span id="file-label" class="text-sm text-gray-600">
                                    Klik untuk pilih file
                                </span>
                                <input type="file" name="cv_file" accept=".pdf"
                                       class="hidden" onchange="updateFileName(this)" required>
                            </label>
                            @error('cv_file') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

                        {{-- DESKRIPSI --}}
                        <div>
                            <label class="text-sm font-semibold">Deskripsi Diri *</label>
                            <textarea name="description" rows="3"
                                      class="form-input w-full px-3 py-2.5 rounded-lg bg-gray-50 border"
                                      required>{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit"
                                class="btn-primary w-full text-white font-semibold py-3 rounded-xl">
                            Kirim Lamaran
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const label = document.getElementById('file-label');
    if (input.files.length > 0) {
        label.innerText = input.files[0].name;
        label.classList.add('text-pink-500');
    }
}
</script>
@endsection
