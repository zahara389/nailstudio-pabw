<nav>
    <i class='bx bx-menu'  ></i> {{-- Ini adalah ikon menu untuk toggle sidebar --}}
    
    {{-- START: Search Bar --}}
    <form action="#" class="search">
        <div class="form-input">
            <input type="search" placeholder="Search..." />
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </form>
    {{-- END: Search Bar --}}
    
    {{-- Ikon Notifikasi dan Profil --}}
    <a href="#" class="notification">
        <i class='bx bxs-bell' ></i>
        <span class="num">10</span>
    </a>
    <a href="#" class="profile">
        <img src="{{ asset('images/profile.jpg') }}"> 
    </a>
</nav>