@extends('layouts.app-admin') 

@section('title', 'Edit Lowongan: ' . $job->title)

@section('content')
<div class="main-content p-6 bg-gray-100 min-h-screen">

    <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Lowongan Pekerjaan: {{ $job->title }}</h2>
    
    <div class="card bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('job.update', $job->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ERROR ALERT --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 p-4 mb-4 rounded">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- GRID 2 KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="form-group">
                    <label for="title" class="form-label">Judul Pekerjaan *</label>
                    <input type="text" name="title" id="title" class="form-input"
                           value="{{ old('title', $job->title) }}" required>
                </div>
            </div>

            {{-- GRID 3 KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="form-group">
                    <label for="job_category_id" class="form-label">Kategori *</label>
                    <select name="job_category_id" id="job_category_id" class="form-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('job_category_id', $job->job_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="employment_type" class="form-label">Tipe Pekerjaan *</label>
                    <select name="employment_type" id="employment_type" class="form-input" required>
                        <option value="full_time" {{ $job->employment_type == 'full_time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part_time" {{ $job->employment_type == 'part_time' ? 'selected' : '' }}>Part-time</option>
                        <option value="internship" {{ $job->employment_type == 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Lokasi *</label>
                    <input type="text" name="location" id="location" class="form-input"
                           value="{{ old('location', $job->location) }}" required>
                </div>
            </div>

            {{-- GRID 3 KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="form-group">
                    <label for="salary_range" class="form-label">Rentang Gaji (Opsional)</label>
                    <input type="text" name="salary_range" id="salary_range" class="form-input"
                           value="{{ old('salary_range', $job->salary_range) }}">
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select name="status" id="status" class="form-input" required>
                        <option value="draft" {{ $job->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="open" {{ $job->status == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ $job->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="published_at" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="published_at" id="published_at" class="form-input"
                           value="{{ old('published_at', $job->published_at ? $job->published_at->format('Y-m-d') : '') }}">
                </div>
            </div>

            {{-- GRID 1 KOLOM - EXPIRES AT --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="form-group">
                    <label for="expires_at" class="form-label">Tanggal Expired</label>
                    <input type="date" name="expires_at" id="expires_at" class="form-input"
                           value="{{ old('expires_at', $job->expires_at ? $job->expires_at->format('Y-m-d') : '') }}">
                </div>
            </div>

            {{-- DESKRIPSI --}}
            <div class="form-group mb-6">
                <label for="description" class="form-label">Deskripsi Pekerjaan *</label>
                <textarea name="description" id="description" rows="5" class="form-input" required>{{ old('description', $job->description) }}</textarea>
            </div>

            {{-- REQUIREMENTS --}}
            <div class="form-group mb-6">
                <label for="requirements" class="form-label">Persyaratan (Format JSON Array)</label>
                <textarea name="requirements" id="requirements" rows="3" class="form-input"
                          placeholder='["Min. 1 tahun pengalaman", "Menguasai teknik gel nails"]'>{{ old('requirements', $job->requirements) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Gunakan format JSON array string seperti contoh.</p>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <a href="{{ route('job.index') }}" class="btn-secondary mr-3">Batal</a>
                <button type="submit" class="btn-danger">Perbarui Lowongan</button>
            </div>

        </form>
    </div>
</div>
@endsection
