@extends('layouts.app-admin') 

@section('title', 'Manajemen Lowongan Pekerjaan')

@section('content')
<div class="admin-job-container">
    
    <h2 style="font-size: 1.75rem; font-weight: 700; color: #333; margin-bottom: 20px;">Manajemen Lowongan Pekerjaan</h2>
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border: 1px solid #c3e6cb; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

   
   {{-- Tombol Tambah --}}
    <div style="text-align: right; margin-bottom: 15px;">
    <a href="{{ route('job.create') }}" style="background-color: #059669; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-block; transition: background-color 0.2s;">
        + Tambah Lowongan Baru
    </a>
    </div>

    {{-- KARTU KONTEN UTAMA --}}
    <div class="job-card-container">
        <div style="overflow-x: auto;">
            <table class="job-table">
                
                {{-- Header Tabel --}}
                <thead> 
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
                {{-- Isi Tabel --}}
                <tbody>
                    @forelse ($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->category->name ?? 'N/A' }}</td>
                            
                            {{-- Kolom Tipe --}}
                            <td>
                                <span class="status-badge" style="background-color: #e0f7fa; color: #00838f;">
                                    {{ strtoupper(str_replace('_', ' ', $job->employment_type)) }}
                                </span>
                            </td>
                            
                            {{-- Kolom Status --}}
                            <td>
                                <span class="status-badge 
                                    @if($job->status == 'open') status-open
                                    @elseif($job->status == 'closed') status-closed
                                    @else status-draft
                                    @endif">
                                    {{ strtoupper($job->status) }}
                                </span>
                            </td>
                            
                            <td>{{ $job->published_at ? $job->published_at->format('d M Y') : 'DRAFT' }}</td>
                            
                            {{-- Kolom Aksi --}}
                            <td>
                                <a href="{{ route('job.edit', $job->id) }}" class="action-link">Edit</a>
                                
                                <form action="{{ route('job.destroy', $job->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-delete-btn">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 40px 15px; text-align: center; font-size: 16px; color: #999; background-color: #fafafa;">
                                Belum ada lowongan pekerjaan yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="job-pagination">
            {{ $jobs->links() }}
        </div>
    </div>
</div>
@endsection