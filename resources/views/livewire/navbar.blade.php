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
                <a href="#" class="ns-nav-link ns-link-justify"><div class="ns-link-content"><i class="far fa-credit-card ns-icon-lg-centered"></i> Payment Options</div><i class="fas fa-plus ns-icon-plus"></i></a>
                <a href="#" class="ns-nav-link ns-link-justify"><div class="ns-link-content"><i class="far fa-question-circle ns-icon-lg-centered"></i> Customer Service</div><i class="fas fa-plus ns-icon-plus"></i></a>
                <a href="#" class="ns-nav-link ns-link-justify"><div class="ns-link-content"><i class="far fa-smile ns-icon-lg-centered"></i> About Us</div><i class="fas fa-plus ns-icon-plus"></i></a>
            </nav>
        </div>
    </div>

    <div id="cart-modal">
        <div class="ns-modal-cart-header">
            <h2 class="ns-text-xl-semibold">Your Cart</h2>
            <button onclick="closeCartModal()" class="ns-close-btn" aria-label="Close cart"><i class="fas fa-times"></i></button>
        </div>
        <div class="ns-cart-body" id="cart-items-modal"><p class="ns-cart-empty-message">Your cart is empty.</p></div>
        <div id="ns-cart-footer">
            <div class="ns-cart-subtotal"><span>Subtotal:</span><span id="cart-subtotal" class="ns-text-pink-600">$0.00</span></div>
            <button onclick="showCheckoutMessage()" class="ns-btn ns-btn-primary ns-mb-2">Proceed to Checkout</button>
            <button onclick="showViewCartMessage()" class="ns-btn ns-btn-secondary">View Cart Page</button>
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
                    <button aria-label="Cart" id="cart-btn" class="ns-icon-button ns-icon-button-lg"><i class="fas fa-shopping-bag"></i><span id="cart-count-badge" class="ns-badge">0</span></button>
                    <a href="#" id="profile-link" class="ns-icon-button ns-icon-button-lg" aria-label="Account"><i class="far fa-user ns-icon-button-lg"></i></a>
        </div>
    </header>

    <div id="message-box" class="ns-message-box">
        </div>
    
</div>