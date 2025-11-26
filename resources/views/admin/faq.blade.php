@extends('layouts.app') 

@section('title', 'FAQ - Nail Art Studio')

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Frequently Asked Questions</h1>
        <p class="text-muted">Halo, {{ $nama_user }}! Ada yang bisa kami bantu?</p>
    </div>

    {{-- 1. SEARCH BAR --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <form action="{{ url('/faq') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari pertanyaan..." value="{{ $search }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    @if($search)
                        <a href="{{ url('/faq') }}" class="btn btn-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- 2. ALERT SUKSES / ERROR --}}
    @if($success)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $success }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error_msg)
                    <li>{{ $error_msg }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 3. DAFTAR FAQ (ACCORDION) --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($faqs->count() > 0)
                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                    <strong>{{ $faq->question }}</strong>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning text-center">
                    Pertanyaan yang Anda cari tidak ditemukan.
                </div>
            @endif
        </div>
    </div>

    {{-- 4. FORM AJUKAN PERTANYAAN --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Punya pertanyaan lain?</h4>
                    <p class="text-muted small">Tanyakan kepada kami, admin akan segera menjawabnya.</p>
                    
                    <form action="{{ url('/faq') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="member_question" class="form-label">Pertanyaan Anda</label>
                            <textarea class="form-control" id="member_question" name="member_question" rows="3" placeholder="Tulis pertanyaan Anda di sini..." required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark">Kirim Pertanyaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection