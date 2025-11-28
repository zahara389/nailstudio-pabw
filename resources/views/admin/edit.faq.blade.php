@extends('layouts.app-admin')

@section('content')
<div class="head-title">
    <div class="left">
        <h1>Edit FAQ</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('admin.faq.index') }}">FAQ Message</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li class="active">Edit FAQ</li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Edit Pertanyaan & Jawaban</h3>
        </div>

        <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pertanyaan --}}
            <div class="form-group mt-3">
                <label class="mb-2 fw-bold">Pertanyaan</label>
                <textarea name="question" class="form-control" rows="3" required>{{ old('question', $faq->question) }}</textarea>

                @error('question')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Jawaban Admin --}}
            <div class="form-group mt-3">
                <label class="mb-2 fw-bold">Jawaban</label>
                <textarea name="answer" class="form-control" rows="5">{{ old('answer', $faq->answer) }}</textarea>

                @error('answer')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- STATUS - otomatis di controller, jadi tidak usah input --}}

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Update</button>
                <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
