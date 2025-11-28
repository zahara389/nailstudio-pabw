<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\User;

class FaqMessageController extends Controller
{
    
    public function index()
    {
        $faqs = Faq::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.faq', compact('faqs'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'question' => 'required|string|min:5',
        ]);

        Faq::create([
            'user_id' => $request->user_id,
            'question' => $request->question,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

   
    public function show($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq_show', compact('faq'));
    }

    
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.edit.faq', compact('faq'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|min:5',
            'answer' => 'nullable|string|min:3',
        ]);

        $faq = Faq::findOrFail($id);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->answer ? 'answered' : 'pending',
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }

   
    public function submitAnswer(Request $request)
    {
        $request->validate([
            'faq_id' => 'required|integer',
            'answer' => 'required|string|min:5',
        ]);

        $faq = Faq::findOrFail($request->faq_id);

        $faq->update([
            'answer' => $request->answer,
            'status' => 'answered',
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'Jawaban berhasil dipublish.');
    }
}
