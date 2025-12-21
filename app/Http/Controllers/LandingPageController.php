<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Visitor; 
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    
    public function index()
    {
       
        Visitor::firstOrCreate([
            'ip_address' => request()->ip(),
            'visit_date' => now()->toDateString(),
        ]);

        
        $jobs = Job::where('status', 'open')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->orderBy('published_at', 'desc')
                    ->get();
        
        return view('landing_page.index', compact('jobs')); 
    }
}