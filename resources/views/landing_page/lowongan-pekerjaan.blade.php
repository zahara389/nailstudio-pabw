<?php

$jobs = [
    [
        'id' => 1,
        'title' => 'Nail Artist Junior',
        'type' => 'Full-time',
        'location' => 'Jakarta Selatan',
        'description' => 'Mencari nail artist berbakat dengan passion di bidang nail art. Pengalaman minimal 1 tahun dengan teknik dasar gel, manicure, dan pedicure.',
        'requirements' => ['Min. 1 tahun pengalaman', 'Menguasai teknik gel nails', 'Kreatif dan detail-oriented']
    ],
    [
        'id' => 2,
        'title' => 'Receptionist',
        'type' => 'Full-time',
        'location' => 'Jakarta Selatan',
        'description' => 'Bertanggung jawab dalam mengelola jadwal appointment, customer service, dan operasional front desk dengan attitude yang ramah dan profesional.',
        'requirements' => ['Pengalaman customer service', 'Komunikasi baik', 'Mampu multitasking']
    ],
    [
        'id' => 3,
        'title' => 'Content Creator',
        'type' => 'Part-time',
        'location' => 'Hybrid',
        'description' => 'Membuat konten kreatif untuk social media, fotografi nail art, dan video tutorial. Passion di beauty industry dan familiar dengan Instagram/TikTok.',
        'requirements' => ['Portfolio konten beauty', 'Editing foto & video', 'Update trend social media']
    ]
];
?>
<!-- CAREERS SECTION -->
    <section id="careers" class="career-section">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="career-header">
                <div class="career-badge">
                    💼 Join Our Team
                </div>
                <h2 class="section-title font-serif career-title">Career Opportunities</h2>
                <p class="section-subtitle career-subtitle">
                    Bergabunglah dengan tim kami dan berkembang bersama dalam industri beauty yang dinamis dan kreatif
                </p>
            </div>

            <!-- Jobs Grid Container -->
            <div id="jobs-grid" class="career-jobs-grid">
                
            </div>

            <!-- CTA Footer -->
            <div class="career-cta-text">
                <p class="text-gray-600 mb-4 text-lg">
                    Tidak menemukan posisi yang sesuai? Kirim CV Anda ke:
                </p>
                <a 
                    href="mailto:careers@nailsstudio.com"
                    class="career-cta-btn"
                >
                    nailartstudio@gmail.com
                </a>
            </div>
        </div>
    </section>
    <script>
        
        // Fungsi untuk membuat HTML job card
        function createJobCard(job) {
            const card = document.createElement('div');
            card.className = 'career-job-card group'; 

            // Icon Box
            const iconBox = document.createElement('div');
            iconBox.className = 'career-icon-box group-hover:scale-110';
            iconBox.innerHTML = '<i data-lucide="briefcase"></i>'; 
            
            // Title 
            const titleH3 = document.createElement('h3');
            titleH3.className = 'career-job-title';
            titleH3.textContent = job.title;

            // Tags
            const tagsDiv = document.createElement('div');
            tagsDiv.className = 'career-chips-group';

            // Type Tag
            const typeTag = document.createElement('span');
            typeTag.className = 'career-chip career-chip-clock';
            typeTag.innerHTML = `<i data-lucide="clock" class="career-chip-clock"></i> <span>${job.type}</span>`;
            
            // Location Tag
            const locationTag = document.createElement('span');
            locationTag.className = 'career-chip career-chip-map';
            locationTag.innerHTML = `<i data-lucide="map-pin" class="career-chip-map"></i> <span>${job.location}</span>`;

            tagsDiv.appendChild(typeTag);
            tagsDiv.appendChild(locationTag);
            
            // Description
            const descriptionP = document.createElement('p');
            descriptionP.className = 'career-description';
            descriptionP.textContent = job.description;

            // Requirements
            const reqDiv = document.createElement('div');
            reqDiv.className = 'career-requirements';

            const reqTitle = document.createElement('div');
            reqTitle.className = 'career-req-title';
            reqTitle.textContent = 'Requirements:';
            
            const reqList = document.createElement('ul');
            reqList.className = 'career-req-list';
            
            job.requirements.forEach(req => {
                const li = document.createElement('li');
                li.className = 'career-req-list-item'; 
                
                const checkIcon = document.createElement('span');
                checkIcon.className = 'career-req-check';
                checkIcon.textContent = '✓';

                const textSpan = document.createElement('span');
                textSpan.textContent = req;
                
                li.appendChild(checkIcon);
                li.appendChild(textSpan);
                reqList.appendChild(li);
            });
            
            reqDiv.appendChild(reqTitle);
            reqDiv.appendChild(reqList);

            // Apply Button
            const applyButton = document.createElement('button');
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

        // Fungsi utama untuk inisialisasi
        window.onload = function () {
            // 1. Initialize Lucide Icons for static content
            lucide.createIcons();
            
            // 2. Render Job Cards
            const jobsGrid = document.getElementById('jobs-grid');
            if (jobsGrid) {
                jobs.forEach(job => {
                    const card = createJobCard(job);
                    jobsGrid.appendChild(card);
                });
            }
            
            // 3. Re-initialize Lucide Icons after adding new dynamic elements
            lucide.createIcons();
        };


        // Smooth Scroll Function (dipertahankan dari kode sebelumnya)
        function scrollToSection(id) {
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                console.log(`Section ${id} not found in this demo.`);
            }
        }

        // Date Input Min Value (Today)
        const dateInput = document.getElementById('bookingDate');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }
        </script>