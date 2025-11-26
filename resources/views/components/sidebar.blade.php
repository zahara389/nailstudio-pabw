
<section id="sidebar">
    <a href="{{ url('/') }}" class="brand" style="background-color: white;">
        <img src="{{ asset('images/logonails.png')}}" width=75 height=75 ></img>
    </a>
   <ul class="side-menu top">
        <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Admin Dashboard</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
            <a href="{{ route('product.index') }}">
                <i class='bx bxs-shopping-bag-alt' ></i>
                <span class="text">Product</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('analytics.index') ? 'active' : '' }}">
            <a href="{{ route('analytics.index') }}">
                <i class='bx bxs-chart' ></i> 
                <span class="text">Analytics</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.faq.index') ? 'active' : '' }}">
            <a href="{{ route('admin.faq.index') }}">
                <i class='bx bxs-message-dots' ></i> 
                <span class="text">FAQ Message</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('transaction.history') ? 'active' : '' }}">
            <a href="{{ route('transaction.history') }}">
                <i class='bx bxs-time' ></i> 
                <span class="text">Transaction History</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('stock.index') ? 'active' : '' }}">
            <a href="{{ route('stock.index') }}">
                <i class='bx bxs-adjust' ></i> 
                <span class="text">Management Stock & Harga</span>
            </a>
        </li>
        {{-- Tambahkan link menu lainnya di sini --}}
    </ul>
    <ul class="side-menu">
        <li>
            <a href="{{ route('logout') }}" class="logout">
                <i class='bx bxs-log-out-circle' ></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>

</section>
