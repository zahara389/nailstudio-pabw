
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
            if (jobsGrid && Array.isArray(window.jobs)) {
                window.jobs.forEach(job => {
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

      



    
        // Catatan: JavaScript tetap sama, tetapi sekarang ia mengandalkan ID dan kelas CSS baru.

        // --- MOCK DATA & CONFIGURATION ---
        // Placeholder image untuk kategori
        const mockCategories = [
            // Gambar Gel Polishes (Menggunakan emoji 💅 untuk representasi visual)
            { name: 'Gel Polishes Collection', url: '#', img: 'https://placehold.co/40x40/f06292/ffffff?text=%F0%9F%92%85', alt: 'Gel Polish Bottle' },
            // Gambar Nail Art Kits (Menggunakan emoji ✨ untuk representasi visual)
            { name: 'Nail Art Stamper Kits', url: '#', img: 'https://placehold.co/40x40/f48fb1/ffffff?text=%E2%9C%A8', alt: 'Nail Art Kit' },
            // Gambar Pro Tools (Menggunakan emoji 🔧 untuk representasi visual)
            { name: 'Pro Tools & Accessories', url: '#', img: 'https://placehold.co/40x40/e91e63/ffffff?text=%F0%9F%94%A7', alt: 'Manicure Tools' },
            // Gambar Pedicure (Menggunakan emoji 👣 untuk representasi visual)
            { name: 'Pedicure & Foot Care', url: '#', img: 'https://placehold.co/40x40/d81b60/ffffff?text=%F0%9F%91%A3', alt: 'Pedicure Set' },
        ];
        
        const MOCK_FAV_COUNT = 0; 
        const MOCK_IS_LOGGED_IN = true;
        
        const url = (path) => '#';
        const route = (name) => '#';

        // --- DOM ELEMENTS ---
        const categoryModal = document.getElementById('category-modal');
        const cartModal = document.getElementById('cart-modal');
        const universalBackdrop = document.getElementById('universal-modal-backdrop');
        const favBadge = document.getElementById('favorite-badge');
        const cartBtn = document.getElementById('cart-btn');
        const bodyElement = document.getElementById('ns-body');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
        const currencyFormatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

        // --- MESSAGE HANDLER (Replaces alert()) ---
        function showMessage(text) {
            const box = document.getElementById('message-box');
            box.innerText = text;
            box.classList.remove('ns-opacity-0', 'ns-pointer-events-none');
            box.classList.add('ns-opacity-100');
            setTimeout(() => {
                box.classList.remove('ns-opacity-100');
                box.classList.add('ns-opacity-0');
                setTimeout(() => {
                    box.classList.add('ns-pointer-events-none');
                }, 300);
            }, 3000);
        }

        // --- MODAL LOGIC ---
        function openCategoryModal() {
            closeCartModal(false); 
            categoryModal.classList.add('open');
            universalBackdrop.classList.add('active');
            bodyElement.style.overflow = 'hidden';
        }
        
        function closeCategoryModal(closeBackdrop = true) {
            categoryModal.classList.remove('open');
            if (closeBackdrop && !cartModal.classList.contains('open')) {
                universalBackdrop.classList.remove('active');
                bodyElement.style.overflow = '';
            }
        }
        
        function openCartModal() {
            closeCategoryModal(false); 
            cartModal.classList.add('open');
            universalBackdrop.classList.add('active');
            bodyElement.style.overflow = 'hidden';
            loadCartModal(); 
        }

        function closeCartModal(closeBackdrop = true) {
            cartModal.classList.remove('open');
            if (closeBackdrop && !categoryModal.classList.contains('open')) {
                universalBackdrop.classList.remove('active');
                bodyElement.style.overflow = '';
            }
        }

        function closeAllModals() {
            closeCategoryModal();
            closeCartModal();
        }

        // --- DATA & CONTENT DISPLAY ---

        function initCategoryMenu() {
            const list = document.getElementById('category-list');
            list.innerHTML = mockCategories.map(cat => `
                <a href="${cat.url}" class="ns-block">
                    <li class="ns-category-item">
                        <span class="ns-category-name">${cat.name}</span>
                        <div class="ns-category-img-container">
                            <img
                                src="${cat.img}"
                                alt="${cat.alt}"
                                class="ns-category-img"
                            />
                        </div>
                    </li>
                </a>
            `).join('');
        }

        function loadCartModal() {
            const badge = document.getElementById('cart-count-badge');
            if (!badge) {
                return;
            }

            const countFromServer = parseInt(badge.dataset.cartCount || badge.textContent || '0', 10);
            badge.dataset.cartCount = countFromServer;
            updateCartBadge(countFromServer);
        }

        function getCartItemElement(id) {
            return document.querySelector(`[data-cart-item="${id}"]`);
        }

        function clampQuantity(value, max) {
            const numeric = parseInt(value, 10);
            const safeValue = Number.isNaN(numeric) ? 1 : numeric;
            return Math.min(Math.max(safeValue, 1), max);
        }

        function syncCartRow(itemEl, quantity) {
            if (!itemEl) {
                return;
            }

            const input = itemEl.querySelector('[data-cart-qty-input]');
            if (input) {
                input.value = quantity;
            }

            const label = itemEl.querySelector('[data-cart-quantity-label]');
            if (label) {
                const category = itemEl.dataset.cartCategory ?? label.textContent.split('•')[0].trim();
                label.textContent = `${category} • Qty ${quantity}`;
            }

            const unitPrice = parseFloat(itemEl.dataset.cartUnitPrice || '0');
            const lineTotal = itemEl.querySelector('[data-cart-line-total]');
            if (lineTotal) {
                lineTotal.textContent = currencyFormatter.format(unitPrice * quantity);
            }

            itemEl.dataset.cartQuantity = quantity;
        }

        function updateMiniCartTotals(cartData) {
            if (!cartData) {
                return;
            }

            if (typeof cartData.count !== 'undefined') {
                updateCartBadge(cartData.count);
            }

            if (typeof cartData.subtotal !== 'undefined') {
                const subtotalTarget = document.querySelector('[data-cart-subtotal]');
                if (subtotalTarget) {
                    subtotalTarget.textContent = currencyFormatter.format(cartData.subtotal);
                    subtotalTarget.dataset.cartSubtotal = cartData.subtotal;
                }
            }
        }

        function refreshNavbarComponent() {
            if (window.Livewire?.dispatch) {
                window.Livewire.dispatch('cart-updated');
            } else if (window.Livewire?.emit) {
                window.Livewire.emit('cart-updated');
            }
        }

        async function mutateCart(itemEl, url, method, payload, fallbackMessage) {
            if (!url) {
                return;
            }

            try {
                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                };

                if (payload) {
                    headers['Content-Type'] = 'application/json';
                }

                const response = await fetch(url, {
                    method,
                    headers,
                    credentials: 'same-origin',
                    body: payload ? JSON.stringify(payload) : null,
                });

                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    throw new Error(data.message || 'Gagal memperbarui keranjang.');
                }

                if (method === 'DELETE' && itemEl) {
                    itemEl.remove();
                }

                updateMiniCartTotals(data.cart);
                showMessage(data.message || fallbackMessage || 'Keranjang diperbarui.');
                refreshNavbarComponent();
            } catch (error) {
                showMessage(error.message || 'Terjadi kesalahan saat memproses keranjang.');
                if (itemEl) {
                    itemEl.classList.remove('ns-cart-item--pending');
                }
            }
        }

        async function updateCartQuantity(id, requestedQty) {
            const itemEl = getCartItemElement(id);
            if (!itemEl) {
                return;
            }

            const maxQty = parseInt(itemEl.dataset.cartMax || '99', 10);
            const nextQty = clampQuantity(requestedQty, maxQty);

            if (Number(requestedQty) !== nextQty) {
                showMessage(nextQty >= maxQty ? 'Jumlah melebihi stok yang tersedia.' : 'Jumlah minimal adalah 1.');
            }

            syncCartRow(itemEl, nextQty);
            await mutateCart(
                itemEl,
                itemEl.dataset.cartUpdateUrl,
                'PATCH',
                { quantity: nextQty },
                'Jumlah produk di keranjang diperbarui.'
            );
        }

        function cartPlus(id) {
            const itemEl = getCartItemElement(id);
            if (!itemEl) {
                return;
            }

            const current = parseInt(itemEl.dataset.cartQuantity || '1', 10);
            const maxQty = parseInt(itemEl.dataset.cartMax || '99', 10);

            if (current >= maxQty) {
                showMessage('Jumlah melebihi stok yang tersedia.');
                return;
            }

            updateCartQuantity(id, current + 1);
        }

        function cartMinus(id) {
            const itemEl = getCartItemElement(id);
            if (!itemEl) {
                return;
            }

            const current = parseInt(itemEl.dataset.cartQuantity || '1', 10);

            if (current <= 1) {
                showMessage('Jumlah minimal adalah 1.');
                return;
            }

            updateCartQuantity(id, current - 1);
        }

        function cartQty(id, qty) {
            updateCartQuantity(id, qty);
        }

        function cartDelete(id) {
            const itemEl = getCartItemElement(id);
            if (!itemEl) {
                return;
            }

            itemEl.classList.add('ns-cart-item--pending');
            mutateCart(itemEl, itemEl.dataset.cartDeleteUrl, 'DELETE', null, 'Produk dihapus dari keranjang.');
        }
        
        function updateCartBadge(count) {
            const badge = document.getElementById('cart-count-badge');
            if (!badge) {
                return;
            }

            badge.dataset.cartCount = count;
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }

        // --- ACTION HANDLERS ---
        function handleSearch(event) {
            event.preventDefault();
            const query = document.getElementById("searchInput").value.trim();
            if (query.length < 2) {
                showMessage("Mohon ketik minimal 2 karakter untuk pencarian.");
                return;
            }
            showMessage(`Simulasi: Mencari "${query}". Fitur dinonaktifkan.`);
        }

        function showCheckoutMessage() { closeCartModal(); showMessage('Simulasi: Redirect ke Checkout dinonaktifkan untuk tampilan ini.'); }
        function showViewCartMessage() { closeCartModal(); showMessage('Simulasi: Redirect ke Cart Page dinonaktifkan untuk tampilan ini.'); }
        function showFavoritesMessage() { showMessage('Simulasi: Redirect ke Wishlist dinonaktifkan. Jumlah Wishlist: 0'); }

        // --- INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', function() {
            
            favBadge.textContent = MOCK_FAV_COUNT;
            favBadge.style.display = MOCK_FAV_COUNT > 0 ? 'flex' : 'none';

            initCategoryMenu();
            loadCartModal(); 

            cartBtn.addEventListener('click', function(e) {
                openCartModal();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeAllModals();
                }
            });
        });
 