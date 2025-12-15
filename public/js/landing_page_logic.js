
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
        
        let mockCartItems = []; 
        const MOCK_FAV_COUNT = 0; 
        const MOCK_IS_LOGGED_IN = true;
        
        const url = (path) => '#';
        const route = (name) => '#';

        // --- DOM ELEMENTS ---
        const categoryModal = document.getElementById('category-modal');
        const cartModal = document.getElementById('cart-modal');
        const universalBackdrop = document.getElementById('universal-modal-backdrop');
        const cartCountBadge = document.getElementById('cart-count-badge');
        const favBadge = document.getElementById('favorite-badge');
        const cartItemsContainer = document.getElementById('cart-items-modal');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartBtn = document.getElementById('cart-btn');
        const bodyElement = document.getElementById('ns-body');

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
            let total = 0;
            const cartHtml = mockCartItems.length === 0 
                ? '<p class="ns-cart-empty-message">Your cart is empty.</p>'
                : ''; 

            cartItemsContainer.innerHTML = cartHtml;
            cartSubtotal.textContent = `$${total.toFixed(2)}`;
            updateCartBadge(mockCartItems.length);
        }
        
        function cartPlus(id) { showMessage("Simulasi: Fitur penambahan kuantitas dinonaktifkan untuk tampilan ini."); }
        function cartMinus(id) { showMessage("Simulasi: Fitur pengurangan kuantitas dinonaktifkan untuk tampilan ini."); }
        function cartQty(id, qty) { showMessage("Simulasi: Fitur update kuantitas dinonaktifkan untuk tampilan ini."); }
        function cartDelete(id) { showMessage("Simulasi: Fitur hapus item dinonaktifkan untuk tampilan ini."); }
        
        function updateCartBadge(count) {
            cartCountBadge.textContent = count;
            cartCountBadge.style.display = count > 0 ? 'flex' : 'none';
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
 