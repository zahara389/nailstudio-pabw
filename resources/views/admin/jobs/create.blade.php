@extends('layouts.app-admin')

@section('title', 'Tambah Lowongan Pekerjaan')

@section('content')
<div class="admin-job-container">

    <h2 style="font-size: 1.75rem; font-weight: 700; color: #333; margin-bottom: 20px;">
        Tambah Lowongan Baru
    </h2>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div style="background:#fee2e2; color:#b91c1c; padding:12px; border-radius:6px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('job.store') }}" method="POST" class="admin-form">
        @csrf

        {{-- Judul --}}
        <div class="form-group">
            <label>Judul Lowongan</label>
            <input type="text" name="title" class="form-input" required>
        </div>

        {{-- Deskripsi --}}
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-input" rows="5" required></textarea>
        </div>

        {{-- Persyaratan --}}
        <div class="form-group">
            <label>Persyaratan (Format JSON Array)</label>
            <textarea name="requirements" class="form-input" rows="4" 
                placeholder='["Minimal 1 tahun pengalaman", "Menguasai teknik gel nails"]'></textarea>
        </div>

        {{-- Kategori --}}
        <div class="form-group">
            <label>Kategori</label>
            <select name="job_category_id" class="form-input" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tipe Pekerjaan --}}
        <div class="form-group">
            <label>Tipe Pekerjaan</label>
            <select name="employment_type" class="form-input" required>
                <option value="full_time">Full-time</option>
                <option value="part_time">Part-time</option>
                <option value="internship">Internship</option>
            </select>
        </div>

        {{-- Lokasi --}}
        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="location" class="form-input" required>
        </div>

        {{-- Gaji --}}
        <div class="form-group">
            <label>Rentang Gaji (Opsional)</label>
            <input type="text" name="salary_range" class="form-input">
        </div>

        {{-- Status --}}
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-input" required>
                <option value="draft">Draft</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
        </div>

        {{-- Tanggal Terbit --}}
        <div class="form-group">
            <label>Tanggal Terbit</label>
            <input type="date" name="published_at" class="form-input">
        </div>

        {{-- Tanggal Expired --}}
        <div class="form-group">
            <label>Tanggal Expired</label>
            <input type="date" name="expires_at" class="form-input">
        </div>

        <button class="btn-primary">Simpan</button>
    </form>

</div>
@endsection
