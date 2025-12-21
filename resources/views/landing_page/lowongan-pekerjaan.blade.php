@php
/**
 * ==================== 1. OLAH DATA (AMAN & SEKALI SAJA) ====================
 */
$jobs_data = $jobs->map(function ($job) {
    $requirements = [];

    if (!empty($job->requirements)) {
        $decoded = json_decode($job->requirements, true);

        if (is_array($decoded)) {
            $requirements = $decoded;
        } else {
            $requirements = array_filter(
                array_map('trim', explode(',', $job->requirements))
            );
        }
    }

    return [
        'id' => $job->id,
        'title' => $job->title,
        'type' => strtoupper(str_replace('_', ' ', $job->employment_type)),
        'location' => $job->location,
        'description' => $job->description,
        'requirements' => array_values($requirements),
    ];
})->toArray();
@endphp

{{-- ==================== 2. HTML SECTION ==================== --}}
<section id="careers" class="career-section">
    <div class="max-w-7xl mx-auto">

        <div class="career-header text-center mb-12">
            <div class="career-badge mb-3">💼 Join Our Team</div>
            <h2 class="section-title font-serif">Career Opportunities</h2>
            <p class="section-subtitle mt-3">
                Bergabunglah dengan tim kami dan berkembang bersama dalam industri beauty
            </p>
        </div>

        <div
            id="jobs-grid"
            class="career-jobs-grid grid md:grid-cols-2 lg:grid-cols-3 gap-6"
        ></div>

        <div class="career-cta-text text-center mt-16">
            <p class="text-gray-600 mb-4 text-lg">
                Tidak menemukan posisi yang sesuai? Kirim CV Anda ke:
            </p>
            <a href="mailto:nailartstudio@gmail.com" class="career-cta-btn">
                nailartstudio@gmail.com
            </a>
        </div>

    </div>
</section>

{{-- ==================== 3. JAVASCRIPT ==================== --}}
@push('scripts')
<script>
const jobs = @json($jobs_data);

function createJobCard(job) {
    const card = document.createElement('div');
    card.className = 'career-job-card group';

    card.innerHTML = `
        <div class="career-icon-box">
            <i data-lucide="briefcase"></i>
        </div>

        <h3 class="career-job-title">${job.title}</h3>

        <div class="career-chips-group">
            <span class="career-chip career-chip-clock">
                <i data-lucide="clock"></i>
                <span>${job.type}</span>
            </span>
            <span class="career-chip career-chip-map">
                <i data-lucide="map-pin"></i>
                <span>${job.location}</span>
            </span>
        </div>

        <p class="career-description">${job.description}</p>

        <div class="career-requirements">
            <div class="career-req-title">Requirements:</div>
            <ul class="career-req-list">
                ${
                    job.requirements.length
                        ? job.requirements.map(req => `
                            <li class="career-req-list-item">
                                <span class="career-req-check">✓</span>
                                <span>${req}</span>
                            </li>
                        `).join('')
                        : `<li class="career-req-list-item">No specific requirements</li>`
                }
            </ul>
        </div>

        <a href="/apply/${job.id}" class="career-apply-btn">
            Apply Now <i data-lucide="arrow-right"></i>
        </a>
    `;

    return card;
}

document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('jobs-grid');
    if (!grid) return;

    if (!jobs.length) {
        grid.innerHTML = `
            <p class="col-span-full text-center text-gray-500 text-lg py-10">
                Saat ini belum ada lowongan pekerjaan.
            </p>
        `;
        return;
    }

    jobs.forEach(job => {
        grid.appendChild(createJobCard(job));
    });

    window.lucide?.createIcons();
});
</script>
@endpush
