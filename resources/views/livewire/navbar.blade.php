<div id="livewire-navbar-wrapper">

    <div class="top-info-bar no-scrollbar">
        FREE shipping and FREE gift when you spend over $75*
    </div>

    <div id="universal-modal-backdrop" onclick="closeAllModals()"></div>

    <div id="category-modal" role="dialog" aria-modal="true" aria-labelledby="category-modal-title">
        <div class="modal-header">
            <h2 id="category-modal-title">Shop Categories & Menu</h2>
            <button onclick="closeCategoryModal()" id="close-category-btn" aria-label="Close category menu">
                <i class="fas fa-times ns-icon-xl"></i>
            </button>
        </div>
        <div class="modal-body">
            <ul id="category-list" class="ns-category-list-container"></ul>
            <nav id="ns-nav-menu">
                            <a href="#" class="ns-nav-link"><i class="far fa-user ns-icon-lg-centered"></i> Sign in</a>
                <a href="#" class="ns-nav-link"><i class="far fa-heart ns-icon-lg-centered"></i> Wishlist</a>
                <a href="{{ route('payment.index') }}" 
   onclick="closeCategoryModal()" 
   class="ns-nav-link ns-link-justify">
    <div class="ns-link-content">
        <i class="far fa-credit-card ns-icon-lg-centered"></i> 
        Payment Options
    </div>
    <i class="fas fa-chevron-right"></i>
</a>
                <a href="{{ route('about') }}" class="ns-nav-link ns-link-justify">
    <div class="ns-link-content">
        <i class="far fa-question-circle ns-icon-lg-centered"></i> 
        Customer Service
    </div>
    <i class="fas fa-plus ns-icon-plus"></i>
</a>
                {{-- LINK KE HALAMAN ABOUT US --}}
<a href="{{ route('about.index') }}" onclick="closeCategoryModal()" class="ns-nav-link ns-link-justify">
    <div class="ns-link-content">
        <i class="far fa-smile ns-icon-lg-centered"></i> 
        About Us
    </div>
    <i class="fas fa-chevron-right ns-icon-plus" style="font-size: 0.8rem; opacity: 0.5;"></i>
</a>
            </nav>
        </div>
    </div>

    <div id="cart-modal">
        <div class="ns-modal-cart-header">
            <h2 class="ns-text-xl-semibold">Your Cart</h2>
            <button onclick="closeCartModal()" class="ns-close-btn" aria-label="Close cart"><i class="fas fa-times"></i></button>
        </div>
        <div class="ns-cart-body" id="cart-items-modal">
            @if (empty($cartItems))
                <p class="ns-cart-empty-message">Keranjang Anda masih kosong.</p>
            @else
                <div class="ns-cart-items-wrapper">
                    @foreach ($cartItems as $item)
                        <div
                            class="ns-cart-item-row"
                            data-cart-item="{{ $item['id'] }}"
                            data-cart-max="{{ $item['max_quantity'] }}"
                            data-cart-update-url="{{ route('cart.items.update', $item['id']) }}"
                            data-cart-delete-url="{{ route('cart.items.destroy', $item['id']) }}"
                            data-cart-unit-price="{{ $item['unit_price'] }}"
                            data-cart-category="{{ $item['category_label'] }}"
                            data-cart-quantity="{{ $item['quantity'] }}"
                            style="padding:0.75rem 0; border-bottom:1px solid #f3f4f6;"
                        >
                            <div style="display:flex; gap:0.75rem; align-items:center;">
                                <div style="width:64px; height:64px; border-radius:0.75rem; overflow:hidden; background:#fdf2f8; flex-shrink:0;">
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['product_name'] }}" style="width:100%; height:100%; object-fit:cover;" />
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <p style="font-size:0.9rem; font-weight:600; color:#111827; margin:0;">{{ $item['product_name'] }}</p>
                                    <p style="font-size:0.75rem; color:#6b7280; margin:0.15rem 0 0;" data-cart-quantity-label>{{ $item['category_label'] }} • Qty {{ $item['quantity'] }}</p>
                                </div>
                                <div style="font-size:0.9rem; font-weight:600; color:#ec4899; text-align:right;" data-cart-line-total>Rp {{ number_format($item['line_total'], 0, ',', '.') }}</div>
                            </div>

                            <div style="display:flex; align-items:center; justify-content:space-between; gap:0.75rem; margin-top:0.65rem;">
                                <div style="display:inline-flex; align-items:center; gap:0.35rem; background:#f9fafb; border-radius:999px; padding:0.2rem 0.6rem;">
                                    <button type="button" class="ns-qty-btn" onclick="cartMinus({{ $item['id'] }})" aria-label="Kurangi">-</button>
                                    <input
                                        type="number"
                                        min="1"
                                        max="{{ $item['max_quantity'] }}"
                                        value="{{ $item['quantity'] }}"
                                        data-cart-qty-input
                                        onchange="cartQty({{ $item['id'] }}, this.value)"
                                        style="width:48px; border:0; background:transparent; text-align:center; font-weight:600; color:#111827;"
                                    />
                                    <button type="button" class="ns-qty-btn" onclick="cartPlus({{ $item['id'] }})" aria-label="Tambah">+</button>
                                </div>

                                <button type="button" class="ns-remove-btn" onclick="cartDelete({{ $item['id'] }})">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div id="ns-cart-footer">
            <div class="ns-cart-subtotal"><span>Subtotal:</span><span id="cart-subtotal" class="ns-text-pink-600" data-cart-subtotal="{{ $cartSubtotal }}">Rp {{ number_format($cartSubtotal, 0, ',', '.') }}</span></div>
            <a href="{{ route('cart.checkout') }}" class="ns-btn ns-btn-primary ns-mb-2 text-center">Proceed to Checkout</a>
            <a href="{{ route('cart.index') }}" class="ns-btn ns-btn-secondary text-center">View Cart Page</a>
        </div>
    </div>

    <header class="main-header" id="ns-header">
        <div id="ns-header-left">
            <button aria-label="Open menu" id="open-menu-btn" onclick="openCategoryModal()"><i class="fas fa-bars ns-icon-xl"></i></button>
            <a href="#" id="ns-logo">Nails Studio</a>
        </div>
            
        <div id="ns-header-right">
                    <form id="searchForm" onsubmit="handleSearch(event)" class="ns-search-form">
                <button type="submit" class="ns-search-btn"><i class="fas fa-search ns-icon-search"></i></button>
                <input type="search" id="searchInput" name="q" placeholder="Search products ..." class="ns-search-input" aria-label="Search products and brands" required minlength="2"/>
            </form>
                    <button aria-label="Favorites" class="ns-icon-button ns-icon-button-lg" onclick="showFavoritesMessage()"><i class="far fa-heart"></i><span id="favorite-badge" class="ns-badge">0</span></button>
                    <button aria-label="Cart" id="cart-btn" class="ns-icon-button ns-icon-button-lg"><i class="fas fa-shopping-bag"></i><span id="cart-count-badge" class="ns-badge" data-cart-count="{{ $cartItemCount }}" @if($cartItemCount < 1) style="display:none;" @endif>{{ $cartItemCount }}</span></button>
                    <a href="#" id="profile-link" class="ns-icon-button ns-icon-button-lg" aria-label="Account"><i class="far fa-user ns-icon-button-lg"></i></a>
        </div>
    </header>

    <div id="message-box" class="ns-message-box">
        </div>
    
</div>