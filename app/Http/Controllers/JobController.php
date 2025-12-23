<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobApplication; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage; 
use App\Models\User; 

class JobController extends Controller
{
    // Menampilkan halaman lowongan publik
    public function publicIndex()
    {
        $jobs = Job::where('status', 'open')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('published_at', 'desc')
            ->get();

        return view('landing_page.lowongan-pekerjaan', compact('jobs')); 
    }

    // Menampilkan detail lowongan publik
    public function show(Job $job)
    {
        if (
            $job->status !== 'open' ||
            $job->published_at === null ||
            $job->published_at > now() ||
            ($job->expires_at !== null && $job->expires_at < now())
        ) {
            abort(404);
        }

        return view('landing_page.lowongan-pekerjaan.show', compact('job'));
    }

    // PUBLIC ACCESS 
    public function showApplicationForm($jobId)
    {
        $job = Job::where('id', $jobId)
                  ->where('status', 'open')
                  ->firstOrFail();

        return view('landing_page.form-lowongan', compact('jobId', 'job'));
    }

    public function storeApplication(Request $request)
    {
        // 1. Validasi Data 
        $request->validate([
            'job_id'      => 'required|exists:jobs,id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:20',
            'description' => 'required|string',
            'cv_file'     => 'required|file|mimes:pdf|max:5048', 
        ]);

        $cvPath = null;
        
        try {
            // ================== PERUBAHAN INTI ==================
            // Simpan CV dengan NAMA FILE ASLI (TANPA HASH)
            $cvFile = $request->file('cv_file');
            $originalName = $cvFile->getClientOriginalName();
            $cvPath = $cvFile->storeAs('cvs', $originalName, 'public');
            // ====================================================

            // 3. Simpan Data Lamaran 
            JobApplication::create([
                'job_id'         => $request->job_id,
                'user_id'        => auth()->check() ? auth()->id() : null, 
                'applicant_name' => $request->name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'description'    => $request->description,
                'cv_filename'    => $cvPath, 
            ]);

            return redirect('/')
                ->with('success', 'Lamaran Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.');

        } catch (\Exception $e) {

            if ($cvPath) {
                Storage::disk('public')->delete($cvPath);
            }

            Log::error("Job Application Final Store Failed: " . $e->getMessage()); 

            return back()
                ->withInput()
                ->with('error', 'Gagal! Kesalahan saat menyimpan data.');
        }
    }

    // ================= ADMIN =================

    public function index()
    {
        $jobs = Job::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }
    
    public function create()
    {
        $categories = JobCategory::all();
        return view('admin.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'salary_range' => 'nullable|string',
            'status' => 'required|in:draft,open,closed', 
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
        ]);

        Job::create($validated);

        return redirect()->route('job.index')
            ->with('success', 'Lowongan berhasil ditambahkan!');
    }

    public function showAdmin($id)
    {
        $job = Job::with('category')->findOrFail($id);
        return view('admin.jobs.show', compact('job'));
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $categories = JobCategory::all();

        return view('admin.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'salary_range' => 'nullable|string',
            'status' => 'required|in:draft,open,closed', 
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date', 
        ]);

        $job->update($validated);

        return redirect()->route('job.index')
            ->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Job::findOrFail($id)->delete();

        return redirect()->route('job.index')
            ->with('success', 'Lowongan berhasil dihapus!');
    }
}
