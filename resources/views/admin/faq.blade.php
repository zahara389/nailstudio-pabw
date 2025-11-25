@extends('layouts.app-admin') 

@section('content')
<div class="head-title">
    <div class="left">
        <h1>FAQ Message</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route('admin.faq.index') }}">FAQ</a></li>
        </ul>
    </div>
</div>

<div class="faq-questions">
    <h2>Pertanyaan Member</h2>
    
    {{-- Pesan Sukses (Menggantikan echo $_SESSION['success']) --}}
    @if ($success)
        <div class='alert-success'>{{ $success }}</div>
    @endif
    
    @forelse ($faqs as $faq)
        <div class='faq-box'>
            <div class='faq-question'><b>Pertanyaan:</b> {{ htmlspecialchars($faq['question']) }}</div>
            <div class='faq-meta'><small>Dari user_id: {{ $faq['user_id'] }} | Status: {{ $faq['status'] }}</small></div>
            
            @if ($faq['status'] == 'answered')
                {{-- Jika sudah dijawab --}}
                <div class='faq-answer'><b>Jawaban Admin:</b><br>{!! nl2br(htmlspecialchars($faq['answer'])) !!}</div>
            @else
                {{-- Form jawaban untuk admin --}}
                <form method="post" action="{{ route('admin.faq.submit') }}" class="faq-answer-form">
                    @csrf 
                    <input type="hidden" name="faq_id" value="{{ $faq['id'] }}">
                    <textarea name="answer" rows="2" required placeholder="Tulis jawaban admin..."></textarea>
                    <button type="submit">Publish Jawaban</button>
                </form>
            @endif
        </div>
    @empty
        <div>Tidak ada pertanyaan dari member.</div>
    @endforelse
</div>
@endsection

{{-- Pindahkan CSS Inline ke styles section --}}
@section('styles')
<style>
.faq-questions { margin: 32px 0; }
.faq-box { border: 1px solid #eee; padding: 16px 20px; margin-bottom: 20px; border-radius: 8px; background: #fff; }
.faq-question { font-size: 1.1em; margin-bottom: 6px; }
.faq-meta { color: #888; font-size: .9em; margin-bottom: 10px; }
.faq-answer { background: #f9f9f9; border-radius: 5px; padding: 10px; margin-top: 8px; }
.faq-answer-form textarea { width: 100%; padding: 8px; border-radius: 6px; margin-bottom: 8px; border: 1px solid #ccc;}
.faq-answer-form button { background: #8B1D3B; color: #fff; border: none; border-radius: 5px; padding: 7px 16px; cursor: pointer; }
.alert-success { background: #d0ffd8; border: 1px solid #96d8a8; padding: 8px 16px; border-radius: 6px; margin-bottom: 18px; color: #276b3d;}
/* Tambahkan styles untuk alert-danger jika ada */
</style>
@endsection
