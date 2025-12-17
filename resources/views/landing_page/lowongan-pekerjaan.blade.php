@php
/**
 * 1. Bagian PHP: Memastikan Data diolah sekali.
 * Data $jobs_data hanya berisi 1 array untuk setiap lowongan.
 */
$jobs_data = $jobs->map(function ($job) {
    $req = [];
    if (!empty($job->requirements)) {
        // Logika parsing yang robust
        $decoded = json_decode($job->requirements, true);
        if (is_array($decoded)) {
            $req = $decoded;
        } else {
            $req = array_filter(array_map('trim', explode(',', $job->requirements)));
        }
    }

    return [
        'id' => $job->id, // PENTING: ID ini digunakan untuk link Apply Now
        'title' => $job->title,
        'type' => strtoupper(str_replace('_', ' ', $job->employment_type)),
        'location' => $job->location,
        'description' => $job->description,
        'requirements' => array_values($req),
    ];
})->toArray();
@endphp

{{-- 
==================== 2. Struktur HTML Static ====================
================================================================
--}}
<section id="careers" class="career-section">
    <div class="max-w-7xl mx-auto">
        <div class="career-header">
            <div class="career-badge">💼 Join Our Team</div>
            <h2 class="section-title font-serif career-title">Career Opportunities</h2>
            <p class="section-subtitle career-subtitle">
                Bergabunglah dengan tim kami dan berkembang bersama dalam industri beauty yang dinamis dan kreatif
            </p>
        </div>

        {{-- Jaringan Lowongan (Container) --}}
        <div id="jobs-grid" class="career-jobs-grid">
            {{-- Elemen ini harus KOSONG dari Job Card HTML Statis --}}
        </div>

        <div class="career-cta-text">
            <p class="text-gray-600 mb-4 text-lg">
                Tidak menemukan posisi yang sesuai? Kirim CV Anda ke:
            </p>
            <a href="mailto:nailartstudio@gmail.com" class="career-cta-btn">nailartstudio@gmail.com</a>
        </div>
    </div>
</section>

{{-- ==================== 3. JavaScript untuk Rendering (DIUBAH TOTAL) ==================== --}}
@push('scripts')
<script>
    const jobs = @json($jobs_data); 

    function createJobCard(job) {
        const card = document.createElement('div');
        card.className = 'career-job-card group';

        const iconBox = document.createElement('div');
        iconBox.className = 'career-icon-box group-hover:scale-110';
        iconBox.innerHTML = '<i data-lucide="briefcase"></i>';

        const titleH3 = document.createElement('h3');
        titleH3.className = 'career-job-title';
        titleH3.textContent = job.title;

        const tagsDiv = document.createElement('div');
        tagsDiv.className = 'career-chips-group';

        const typeTag = document.createElement('span');
        typeTag.className = 'career-chip career-chip-clock';
        typeTag.innerHTML = `<i data-lucide="clock"></i> <span>${job.type}</span>`;

        const locationTag = document.createElement('span');
        locationTag.className = 'career-chip career-chip-map';
        locationTag.innerHTML = `<i data-lucide="map-pin"></i> <span>${job.location}</span>`;

        tagsDiv.appendChild(typeTag);
        tagsDiv.appendChild(locationTag);

        const descriptionP = document.createElement('p');
        descriptionP.className = 'career-description';
        descriptionP.textContent = job.description;

        const reqDiv = document.createElement('div');
        reqDiv.className = 'career-requirements';

        const reqTitle = document.createElement('div');
        reqTitle.className = 'career-req-title';
        reqTitle.textContent = 'Requirements:';

        const reqList = document.createElement('ul');
        reqList.className = 'career-req-list';

        if (Array.isArray(job.requirements) && job.requirements.length > 0) {
            job.requirements.forEach(req => {
                const li = document.createElement('li');
                li.className = 'career-req-list-item';

                const checkIcon = document.createElement('span');
                checkIcon.className = 'career-req-check';
                checkIcon.textContent = '✓';

                const textSpan = document.createElement('span');
                textSpan.textContent = req.trim(); 

                li.appendChild(checkIcon);
                li.appendChild(textSpan);
                reqList.appendChild(li);
            });
        } else {
            const li = document.createElement('li');
            li.className = 'career-req-list-item';
            li.textContent = 'No specific requirements';
            reqList.appendChild(li);
        }

        reqDiv.appendChild(reqTitle);
        reqDiv.appendChild(reqList);

        // ⭐ MODIFIKASI: Mengganti mailto dengan link route Laravel /apply/{jobId}
        const applyButton = document.createElement('a');
        applyButton.href = `/apply/${job.id}`; // Mengarahkan ke route GET /apply/ID
        applyButton.className = 'career-apply-btn flex items-center justify-center gap-2 group-hover:scale-105';
        applyButton.innerHTML = `Apply Now <i data-lucide="arrow-right"></i>`;

        card.appendChild(iconBox);
        card.appendChild(titleH3);
        card.appendChild(tagsDiv);
        card.appendChild(descriptionP);
        card.appendChild(reqDiv);
        card.appendChild(applyButton);

        return card;
    }

    // ⭐ LIVEWIRE HOOK: Menggantikan DOMContentLoaded untuk mencegah duplikasi rendering
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('element.initialized', ({ component, el }) => {
            // Hanya target elemen jobs-grid pada render pertama
            if (el.id === 'jobs-grid' && !el.hasAttribute('data-rendered')) {
                const jobsGrid = el;

                // Baris Anti-Duplikasi: Membersihkan konten grid
                jobsGrid.innerHTML = ''; 

                if (jobs && jobs.length > 0) {
                    jobs.forEach(job => {
                        const card = createJobCard(job);
                        jobsGrid.appendChild(card);
                    });
                } else {
                    jobsGrid.innerHTML = '<p class="text-center col-span-full text-gray-500 text-lg py-10">Saat ini belum ada lowongan pekerjaan yang dibuka.</p>';
                }
                
                // Tandai elemen sudah dirender
                el.setAttribute('data-rendered', 'true');

                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            }
        });
    } else {
        // Fallback jika tidak menggunakan Livewire, tapi tetap gunakan DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            const jobsGrid = document.getElementById('jobs-grid');
            if (jobsGrid) {
                jobsGrid.innerHTML = ''; 
                if (jobs && jobs.length > 0) {
                    jobs.forEach(job => {
                        jobsGrid.appendChild(createJobCard(job));
                    });
                }
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            }
        });
    }
</script>
@endpush