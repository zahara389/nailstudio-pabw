<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApiController extends Controller
{
    // GET /api/jobs
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Job::where('status', 'open')->get()
        ]);
    }

    // GET /api/jobs/{id}
    public function show($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['success' => false], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $job
        ]);
    }

    // POST /api/jobs/apply
    public function apply(Request $request)
    {
        $request->validate([
            'job_id'      => 'required|exists:jobs,id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:20',
            'description' => 'required|string',
            'cv_file'     => 'required|file|mimes:pdf|max:5048',
        ]);

        $file = $request->file('cv_file');
        $filename = $file->getClientOriginalName();
        $file->storeAs('cvs', $filename, 'public');

        $application = JobApplication::create([
            'job_id'         => $request->job_id,
            'applicant_name' => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'description'    => $request->description,
            'cv_filename'    => $filename,
            'status'         => 'new',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim',
            'data' => $application
        ], 201);
    }

    // GET /api/jobs/{jobId}/applications
    public function applications($jobId)
    {
        $applications = JobApplication::where('job_id', $jobId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pelamar',
            'data' => $applications
        ]);
    }
}
