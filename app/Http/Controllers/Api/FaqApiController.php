<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqApiController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('status', 'answered')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar FAQ',
            'data' => $faqs
        ]);
    }
}
