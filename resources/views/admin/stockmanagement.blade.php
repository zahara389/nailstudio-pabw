@extends('layouts.app-admin') {{-- Ganti dengan nama layout utama Anda --}}


@section('styles')
<style>

    body, html, .card, .table, .modal-content, input, button, select {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
        letter-spacing: 0.01em;
    }

    /* Card Container (Menggantikan .stock-management-page) */
    .stock-management-page-bs {
        margin-top: 32px;
        margin-bottom: 32px;
        max-width: 1100px;
        margin-left: auto;
        margin-right: auto;
    }

    .card.shadow-sm {
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.07) !important;
    }
    
    .card-title {
        font-weight: 600;
        color: #2d2d2d;
        letter-spacing: 0.5px;
        margin-bottom: 18px;
    }

    /* Header Tabel Kustom */
    .table-custom-header th {
        background-color: #f3f4f6; /* Warna Header Tabel */
        color: #89193d; /* Warna teks Header Tabel (sesuai screenshot) */
        font-weight: 700;
        padding: 14px 18px;
        border-top: 1px solid #e5e7eb;
    }
    .table-hover tbody tr:hover {
        background-color: #f3f4f6;
    }
    .table-hover td {
         padding: 14px 18px;
         font-size: 15px;
    }

    /* Filter/Search Bar Styling */
    .filter-label {
        font-size: 15px;
        font-weight: 500;
        color: #89193d;
        margin-right: 4px;
        letter-spacing: 0.01em;
        white-space: nowrap; /* Agar tidak pindah baris */
    }
    .filter-input-bs {
        padding: 8px 14px;
        border-radius: 7px;
        border: 1.5px solid #e5e7eb;
        background-color: #f9fafb;
    }
    .filter-input-bs:focus {
        border-color: #89193d;
        box-shadow: 0 2px 8px rgba(137,25,61,0.07);
    }
    .filter-select-bs {
        padding: 8px 12px;
        border-radius: 7px;
        border: 1.5px solid #e5e7eb;
        background-color: #f3f4f6;
        min-width: 150px;
    }
    .filter-select-bs:focus {
        border-color: #89193d;
        box-shadow: 0 2px 8px rgba(137,25,61,0.07);
    }
    
    /* Badge/Status Styling (menggantikan badge-status) */
    .badge-published-bs, .badge-low-bs, .badge-draft-bs {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        min-width: 90px;
    }

    .badge-published-bs {
        background-color: #e6fbe9 !important; /* Hijau muda */
        color: #28a745 !important; /* Teks Hijau Tua */
    }
    .badge-low-bs {
        background-color: #fffbe6 !important; /* Kuning muda */
        color: #ffc107 !important; /* Teks Kuning Tua */
    }
    .badge-draft-bs {
        background-color: #f3f4f6 !important; /* Abu-abu muda */
        color: #6c757d !important; /* Teks Abu-abu */
    }

    /* Button styles - Menggantikan btn-soft-yellow/green */
    .btn-tambah-stock-bs, .btn-edit-harga-bs {
        display: inline-block;
        min-width: 120px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        padding: 10px 12px;
        margin: 0 auto;
        text-align: center;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-tambah-stock-bs {
        color: #b45309; 
        background-color: #fef9c3; 
        border: 1.5px solid #fde68a; 
        box-shadow: 0 2px 8px rgba(253,230,138,0.10);
    }
    .btn-tambah-stock-bs:hover {
        background-color: #fde68a;
        color: #a16207;
        border-color: #facc15;
    }

    .btn-edit-harga-bs {
        color: #047857; 
        background-color: #d1fae5; 
        border: 1.5px solid #6ee7b7; 
        box-shadow: 0 2px 8px rgba(16,185,129,0.10);
    }
    .btn-edit-harga-bs:hover {
        background-color: #6ee7b7;
        color: #065f46;
        border-color: #34d399;
    }

    /* Modal Styling */
    .modal-content-custom {
        border-radius: 18px; /* Lebih rounded dari default BS5 */
        box-shadow: 0 8px 40px rgba(0,0,0,0.18);
        padding: 10px 0; /* Padding vertikal di modal-content */
    }
    .modal-header .btn-close {
        font-size: 1.5rem;
        margin: 0;
        padding: 0;
    }
    .modal-header {
        padding: 1rem 1.5rem 0.5rem 1.5rem;
    }
    .modal-body {
        padding: 0 1.5rem 1.5rem 1.5rem;
    }
    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #89193d;
        text-align: center;
        letter-spacing: 0.5px;
        flex-grow: 1; /* Agar judul di tengah */
    }

    /* Tombol Save Modal */
    .tw-btn-yellow {
        background-color: #fde68a !important; 
        color: #b45309 !important; 
        border: 1.5px solid #facc15 !important; 
        font-weight: 600 !important;
        padding: 12px 28px !important;
        box-shadow: 0 2px 8px rgba(253,230,138,0.10) !important;
    }
    .tw-btn-green {
        background-color: #6ee7b7 !important; 
        color: #065f46 !important; 
        border: 1.5px solid #34d399 !important; 
        font-weight: 600 !important;
        padding: 12px 28px !important;
        box-shadow: 0 2px 8px rgba(16,185,129,0.10) !important;
    }

    /* Input Plus/Minus (tetap butuh CSS kustom) */
    .input-plusminus-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .input-plusminus-group input[type="number"] {
        width: 70px;
        text-align: center;
        font-size: 16px;
        padding: 8px 0;
        margin: 0 2px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    .btn-minus, .btn-plus {
        /* ... CSS yang sama dari kode Anda ... */
        background: #f3f4f6; color: #444; border: 1.5px solid #e5e7eb; border-radius: 6px; width: 36px; height: 36px;
        font-size: 20px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; user-select: none;
    }
    .btn-minus:hover, .btn-plus:hover {
        background: #fde68a; border-color: #facc15; color: #b45309;
    }
    .input-disabled {
        background: #f3f4f6 !important;
        color: #888;
    }
</style>
@endsection

@section('content')

{{-- Breadcrumb dan Judul --}}
<main class="container-fluid p-0">
    <div class="head-title">
        <div class="left">
            <h1>Management Stock & Harga</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('transaction.history') }}">Management Stock & Harga</a></li>
            </ul>
        </div>
    </div>
</main>

<div class="stock-management-page-bs">
    {{-- Menggunakan Card Bootstrap sebagai container utama --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h2 class="card-title h4">Daftar Produk</h2>
            
            {{-- Filter Bar (Menggunakan Grid BS5) --}}
            <div class="row g-3 mb-2 align-items-end">
                {{-- Search Input --}}
                <div class="col-md-3 col-sm-4">
                    {{-- Input dikustom agar lebar penuh di kolomnya --}}
                    <input type="text" id="searchInput" placeholder="Cari produk..." class="form-control filter-input-bs">
                </div>
                {{-- Label Filter (Sembunyikan di ukuran kecil agar lebih rapi) --}}
                <div class="col-auto d-none d-lg-block">
                    <span class="filter-label">Filter berdasarkan:</span>
                </div>
                {{-- Filter Kategori --}}
                <div class="col-md-2.5 col-sm-auto">
                    <select id="filterCategory" class="form-select filter-select-bs">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ htmlspecialchars($cat) }}">{{ htmlspecialchars($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Filter Status --}}
                <div class="col-md-2.5 col-sm-auto">
                    <select id="filterStatus" class="form-select filter-select-bs">
                        <option value="">Semua Status</option>
                        @foreach ($statuses as $stat)
                            <option value="{{ htmlspecialchars($stat) }}">{{ htmlspecialchars(ucwords($stat)) }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Urutkan Stock --}}
                <div class="col-md-2.5 col-sm-auto">
                    <select id="filterStock" class="form-select filter-select-bs">
                        <option value="">Urutkan Stock</option>
                        <option value="desc">Stock Terbanyak</option>
                        <option value="asc">Stock Terdikit</option>
                    </select>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="table-responsive">
                <table id="stockTable" class="table table-hover align-middle">
                    <thead class="table-custom-header">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stock</th>
                            <th>Harga</th>
                            <th>Diskon (%)</th>
                            <th>Status</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan Blade loop @foreach --}}
                        @foreach ($products as $row)
                            @php
                                // Logic untuk menentukan kelas badge
                                $badge_class = '';
                                if ($row['status'] === 'published') {
                                    $badge_class = 'badge-published-bs';
                                } elseif ($row['status'] === 'low stock') {
                                    $badge_class = 'badge-low-bs';
                                } else {
                                    $badge_class = 'badge-draft-bs';
                                }

                                // Fungsi sederhana format rupiah (sebaiknya di helper atau method)
                                $formatRupiah = fn($angka) => 'Rp' . number_format($angka, 0, ',', '.');
                            @endphp
                            <tr data-id="{{ $row['id_product'] }}"
                                data-stock="{{ $row['stock'] }}"
                                data-price="{{ $row['price'] }}"
                                data-discount="{{ $row['discount'] }}">
                                <td>{{ htmlspecialchars($row['namaproduct']) }}</td>
                                <td>{{ htmlspecialchars($row['category']) }}</td>
                                <td class="td-stock">{{ htmlspecialchars($row['stock']) }}</td>
                                <td class="td-price">{{ $formatRupiah($row['price']) }}</td>
                                <td class="td-discount">{{ htmlspecialchars($row['discount']) }}%</td>
                                <td>
                                    <span class="badge {{ $badge_class }}">
                                        {{ htmlspecialchars(ucwords($row['status'])) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-tambah-stock-bs"
                                        data-bs-toggle="modal" data-bs-target="#tambahStockModal"
                                        data-id="{{ $row['id_product'] }}"
                                        data-nama="{{ htmlspecialchars($row['namaproduct']) }}"
                                        data-stock="{{ $row['stock'] }}">
                                        Tambah Stock
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-edit-harga-bs"
                                        data-bs-toggle="modal" data-bs-target="#editHargaModal"
                                        data-id="{{ $row['id_product'] }}"
                                        data-nama="{{ htmlspecialchars($row['namaproduct']) }}"
                                        data-price="{{ $row['price'] }}"
                                        data-discount="{{ $row['discount'] }}">
                                        Ubah Harga
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination (Menggunakan komponen Pagination Bootstrap) --}}
            <div class="d-flex justify-content-center mt-4">
                @if ($totalPages > 1)
                    <nav aria-label="Pagination Produk">
                        <ul class="pagination mb-0">
                            {{-- Previous Page Link --}}
                            <li class="page-item @if($page <= 1) disabled @endif">
                                <a class="page-link" href="?page={{ $page - 1 }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span> Prev
                                </a>
                            </li>
                            {{-- Pagination Links --}}
                            @for ($i = 1; $i <= $totalPages; $i++)
                                <li class="page-item @if($i == $page) active @endif">
                                    <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                </li>
                            @endfor
                            {{-- Next Page Link --}}
                            <li class="page-item @if($page >= $totalPages) disabled @endif">
                                <a class="page-link" href="?page={{ $page + 1 }}" aria-label="Next">
                                    Next <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- ---------------------------------------------------------------------- --}}
{{-- MODAL TAMBAH STOCK (Bootstrap 5) --}}
{{-- ---------------------------------------------------------------------- --}}
<div class="modal fade" id="tambahStockModal" tabindex="-1" aria-labelledby="tambahStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="tambahStockModalLabel">Tambah Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pb-3 px-4">
                <form id="tambahStockForm" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id_product" id="modal_id_product_stock">
                    <input type="hidden" name="tambah_stock" value="1"> {{-- Flag untuk backend PHP --}}

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" id="modal_nama_stock" disabled class="form-control input-disabled">
                    </div>
                    <div class="mb-3">
                        <label for="modal_add_stock" class="form-label">Jumlah Tambah Stock</label>
                        <div class="input-plusminus-group">
                            <button type="button" class="btn-minus" id="btnMinusStock">-</button>
                            <input type="number" name="add_stock" id="modal_add_stock" min="1" required value="1" class="form-control">
                            <button type="button" class="btn-plus" id="btnPlusStock">+</button>
                        </div>
                    </div>
                    {{-- Tombol Submit menggunakan kelas kustom untuk tampilan --}}
                    <button type="submit" class="btn btn-warning tw-btn-yellow w-100 mt-2">Tambah</button>
                </form>
                <div id="modalMsgStock" class="mt-3 text-center small text-success"></div>
            </div>
        </div>
    </div>
</div>

{{-- ---------------------------------------------------------------------- --}}
{{-- MODAL EDIT HARGA (Bootstrap 5) --}}
{{-- ---------------------------------------------------------------------- --}}
<div class="modal fade" id="editHargaModal" tabindex="-1" aria-labelledby="editHargaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="editHargaModalLabel">Edit Harga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pb-3 px-4">
                <form id="editHargaForm" autocomplete="off">
                    @csrf 
                    <input type="hidden" name="id_product" id="modal_id_product_harga">
                    <input type="hidden" name="edit_harga" value="1"> {{-- Flag untuk backend PHP --}}
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" id="modal_nama_harga" disabled class="form-control input-disabled">
                    </div>
                    <div class="mb-3">
                        <label for="modal_price_edit" class="form-label">Harga Baru (Rp)</label>
                        <input type="number" name="price" id="modal_price_edit" min="0" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="modal_discount_edit" class="form-label">Diskon (%)</label>
                        <input type="number" name="discount" id="modal_discount_edit" min="0" max="100" required class="form-control">
                    </div>
                    {{-- Tombol Submit menggunakan kelas kustom untuk tampilan --}}
                    <button type="submit" class="btn btn-success tw-btn-green w-100 mt-2">Simpan</button>
                </form>
                <div id="modalMsgHarga" class="mt-3 text-center small text-success"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- Script asli Anda dipertahankan, namun disederhanakan untuk Bootstrap 5 --}}
<script>
    // Fungsi untuk format angka (disarankan menggunakan JavaScript bawaan atau library)
    function formatNumberToIDR(number) {
        return Number(number).toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tambahStockModalEl = document.getElementById('tambahStockModal');
        const editHargaModalEl = document.getElementById('editHargaModal');
        
        // 1. Logic Modal: Ambil data dari tombol saat modal dibuka
        if (tambahStockModalEl) {
            tambahStockModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                
                document.getElementById('modal_id_product_stock').value = id;
                document.getElementById('modal_nama_stock').value = nama;
                document.getElementById('modal_add_stock').value = 1;
                document.getElementById('modalMsgStock').textContent = '';
                document.getElementById('tambahStockForm').action = '{{ url("stock_management.php") }}'; // Ganti dengan URL/Route Laravel Anda
            });
        }

        if (editHargaModalEl) {
            editHargaModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const price = button.getAttribute('data-price');
                const discount = button.getAttribute('data-discount');
                
                document.getElementById('modal_id_product_harga').value = id;
                document.getElementById('modal_nama_harga').value = nama;
                document.getElementById('modal_price_edit').value = price;
                document.getElementById('modal_discount_edit').value = discount;
                document.getElementById('modalMsgHarga').textContent = '';
                document.getElementById('editHargaForm').action = '{{ url("stock_management.php") }}'; // Ganti dengan URL/Route Laravel Anda
            });
        }

        // 2. Logic AJAX (dipertahankan dari kode PHP lama, namun diubah agar kompatibel dengan Laravel Route jika perlu)
        document.getElementById('tambahStockForm').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('modal_id_product_stock').value;
            const add_stock = document.getElementById('modal_add_stock').value;
            const formData = new FormData(this);
            
            fetch(this.action, { // Menggunakan action form
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                const msgElement = document.getElementById('modalMsgStock');
                if (data.success) {
                    msgElement.textContent = 'Stock berhasil ditambah!';
                    const row = document.querySelector('tr[data-id="'+id+'"]');
                    if (row) {
                        const stockTd = row.querySelector('.td-stock');
                        stockTd.textContent = parseInt(stockTd.textContent) + parseInt(add_stock);
                    }
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(tambahStockModalEl);
                        modal.hide();
                    }, 900);
                } else {
                    msgElement.textContent = 'Gagal menambah stock.';
                }
            });
        };

        document.getElementById('editHargaForm').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('modal_id_product_harga').value;
            const price = document.getElementById('modal_price_edit').value;
            const discount = document.getElementById('modal_discount_edit').value;
            const formData = new FormData(this);
            
            fetch(this.action, { // Menggunakan action form
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                const msgElement = document.getElementById('modalMsgHarga');
                if (data.success) {
                    msgElement.textContent = 'Harga berhasil diupdate!';
                    const row = document.querySelector('tr[data-id="'+id+'"]');
                    if (row) {
                        row.querySelector('.td-price').textContent = 'Rp' + formatNumberToIDR(price);
                        row.querySelector('.td-discount').textContent = discount + '%';
                    }
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(editHargaModalEl);
                        modal.hide();
                    }, 900);
                } else {
                    msgElement.textContent = 'Gagal memperbarui harga.';
                    console.error(data.error);
                }
            });
        };

        // 3. Logic Plus Minus Stock (dipertahankan)
        var minusBtn = document.getElementById('btnMinusStock');
        var plusBtn = document.getElementById('btnPlusStock');
        var stockInput = document.getElementById('modal_add_stock');
        if (minusBtn && plusBtn && stockInput) {
            minusBtn.onclick = function() {
                let val = parseInt(stockInput.value) || 1;
                if (val > 1) stockInput.value = val - 1;
            };
            plusBtn.onclick = function() {
                let val = parseInt(stockInput.value) || 1;
                stockInput.value = val + 1;
            };
        }

        // 4. Logic Filter & Search (dipertahankan)
        var searchInput = document.getElementById('searchInput');
        var filterCategory = document.getElementById('filterCategory');
        var filterStatus = document.getElementById('filterStatus');
        var filterStock = document.getElementById('filterStock');
        var table = document.getElementById('stockTable');
        var tbody = table.querySelector('tbody');

        function filterTable() {
            var searchVal = searchInput.value.toLowerCase();
            var catVal = filterCategory.value;
            var statVal = filterStatus.value;
            var trs = Array.from(tbody.querySelectorAll('tr'));

            trs.forEach(function(tr) {
                var nama = tr.querySelector('td') ? tr.querySelector('td').textContent.toLowerCase() : '';
                var cat = tr.children[1] ? tr.children[1].textContent : '';
                
                var show = true;
                if (searchVal && nama.indexOf(searchVal) === -1) show = false;
                if (catVal && cat !== catVal) show = false;
                
                // Cek status menggunakan teks badge
                if (statVal) {
                    const statusSpan = tr.children[5].querySelector('.badge');
                    if (statusSpan) {
                         const statusText = statusSpan.textContent.toLowerCase().trim();
                         if (statVal && statusText !== statVal.toLowerCase()) show = false;
                    } else {
                        show = false; // Sembunyikan jika badge tidak ada
                    }
                }

                tr.style.display = show ? '' : 'none';
            });

            // Stock sorting
            if (filterStock.value) {
                var rows = trs.filter(function(tr) { return tr.style.display !== 'none'; });
                rows.sort(function(a, b) {
                    var stockA = parseInt(a.querySelector('.td-stock').textContent) || 0;
                    var stockB = parseInt(b.querySelector('.td-stock').textContent) || 0;
                    return filterStock.value === 'desc' ? stockB - stockA : stockA - stockB;
                });
                rows.forEach(function(tr) { tbody.appendChild(tr); });
            }
        }

        if (searchInput) searchInput.addEventListener('keyup', filterTable);
        if (filterCategory) filterCategory.addEventListener('change', filterTable);
        if (filterStatus) filterStatus.addEventListener('change', filterTable);
        if (filterStock) filterStock.addEventListener('change', filterTable);
    });
</script>
@endsection