<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Sementara: controller ini dibuat untuk melengkapi route yang sudah ada.
     * UI/fitur job applications belum dibuat di project.
     */

    public function index()
    {
        abort(501, 'Fitur job applications belum tersedia.');
    }

    public function create()
    {
        abort(501, 'Fitur job applications belum tersedia.');
    }

    public function store(Request $request): RedirectResponse
    {
        abort(501, 'Fitur job applications belum tersedia.');
    }

    public function show(int|string $id)
    {
        abort(501, 'Fitur job applications belum tersedia.');
    }

    public function edit(int|string $id)
    {
        abort(501, 'Fitur job applications belum tersedia.');
    }

    public function update(Request $request, int|string $id): RedirectResponse
    {
        abort(501, 'Fitur job applications belum tersedia.');
    }

    public function destroy(int|string $id): RedirectResponse
    {
        abort(501, 'Fitur job applications belum tersedia.');
    }
}
