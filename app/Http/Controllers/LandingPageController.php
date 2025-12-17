<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    //Mengambil data dan menampilkan view utama Landing Page tu
    public function index()
    {
        // 1. Ambil data Lowongan jobs
        $jobs = Job::where('status', 'open')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->orderBy('published_at', 'desc')
                    ->get();
        
        return view('landing_page.index', compact('jobs')); 
    }
}