@extends('layouts.app')

@section('title', 'Keranjang Belanja | Nail Studio')

@section('body-class', 'gradient-bg min-h-screen')

@section('content')
    <section class="bg-gradient-to-b from-white/70 to-pink-50/30 py-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="flex flex-col gap-2 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-400">Keranjang Anda</p>
                <h1 class="text-3xl font-semibold text-gray-900">Sentuhan akhir sebelum checkout</h1>
                <p class="text-sm text-gray-500">Pastikan pilihanmu sudah tepat sebelum menuju pembayaran.</p>
            </div>

            @if (session('success'))
                <div class="mt-6 rounded-3xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('alert'))
                <div class="mt-6 rounded-3xl border border-rose-100 bg-rose-50 px-6 py-4 text-sm text-rose-700">
                    {{ session('alert') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-3xl border border-rose-100 bg-rose-50 px-6 py-4 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($isEmpty)
                <div class="mt-10 rounded-[2rem] border border-dashed border-pink-200 bg-white/80 p-12 text-center shadow-lg shadow-pink-100">
                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-pink-50 text-pink-400">
                        <i data-lucide="shopping-bag" class="h-10 w-10"></i>
                    </div>
                    <h2 class="mt-6 text-2xl font-semibold text-gray-900">Keranjang masih kosong</h2>
                    <p class="mt-2 text-sm text-gray-500">Mulai tambahkan koleksi nail art favoritmu dan rasakan pengalaman perawatan yang personal.</p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-pink-500 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-pink-200 transition hover:bg-pink-600">
                        Jelajahi Produk
                    </a>
                </div>
            @else
                <div class="mt-12 grid gap-8 lg:grid-cols-12">
                    <div class="space-y-6 lg:col-span-8">
                        @foreach ($items as $item)
                            @php
                                $product = $item->product;
                                $imageUrl = $product->image_url ?? 'https://via.placeholder.com/320x320?text=Nail+Art';
                                $maxQuantity = $product->stock ?? $item->quantity;
                            @endphp
                            <article class="flex flex-col gap-6 rounded-[2rem] bg-white/90 p-6 shadow-xl shadow-pink-100/60 ring-1 ring-white/70" data-cart-item>
                                <div class="flex flex-col gap-4 md:flex-row">
                                    <div class="aspect-square w-full max-w-[140px] overflow-hidden rounded-2xl bg-pink-50">
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name ?? 'Produk' }}" class="h-full w-full object-cover" />
                                    </div>
                                    <div class="flex flex-1 flex-col justify-between gap-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center justify-between gap-4">
                                                <div>
                                                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-pink-400">{{ $product->category_label ?? 'Signature' }}</p>
                                                    <h2 class="text-lg font-semibold text-gray-900">{{ $product->name ?? 'Produk Nail Studio' }}</h2>
                                                </div>
                                                <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-full bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-500 transition hover:bg-rose-100">Hapus</button>
                                                </form>
                                            </div>
                                            <p class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($product->description ?? 'Deskripsi belum tersedia.', 120) }}</p>
                                        </div>

                                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                            <form method="POST" action="{{ route('cart.items.update', $item) }}" class="flex flex-col gap-3 md:flex-row md:items-center" data-cart-item-form>
                                                @csrf
                                                @method('PATCH')
                                                <div class="inline-flex items-center gap-1 rounded-full border border-gray-200/80 px-3 py-1.5">
                                                    <button type="button" class="h-7 w-7 rounded-full text-sm font-semibold text-gray-500 transition hover:text-pink-500" data-action="decrement">-</button>
                                                    <input
                                                        type="number"
                                                        name="quantity"
                                                        value="{{ $item->quantity }}"
                                                        min="1"
                                                        max="{{ max(1, $maxQuantity) }}"
                                                        class="h-7 w-12 border-0 bg-transparent text-center text-sm font-semibold text-gray-900 focus:outline-none"
                                                        data-quantity-input
                                                    />
                                                    <button type="button" class="h-7 w-7 rounded-full text-sm font-semibold text-gray-500 transition hover:text-pink-500" data-action="increment">+</button>
                                                </div>
                                                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-gray-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-gray-800">Perbarui</button>
                                            </form>
                                            <div class="text-right">
                                                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Subtotal</p>
                                                <p class="text-2xl font-semibold text-pink-500" data-line-total data-unit-price="{{ $item->unit_price }}">Rp {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}</p>
                                                <p class="text-xs text-gray-400">Stok tersedia: {{ max(0, $maxQuantity) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <aside class="flex flex-col gap-6 rounded-[2rem] bg-white/95 p-8 shadow-xl shadow-pink-100/70 ring-1 ring-white/70 lg:col-span-4">
                        <div class="space-y-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-400">Ringkasan</p>
                            <h3 class="text-2xl font-semibold text-gray-900">Total Keranjang</h3>
                        </div>
                        <dl class="space-y-4 text-sm text-gray-500" data-cart-summary data-subtotal="{{ $subtotal }}">
                            <div class="flex items-center justify-between">
                                <dt>Subtotal</dt>
                                <dd class="text-base font-semibold text-gray-900" data-summary-subtotal>Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt>Estimasi Ongkir</dt>
                                <dd class="text-base font-semibold text-gray-400">Akan dihitung saat checkout</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-dashed border-gray-200 pt-4">
                                <dt class="text-sm font-semibold text-gray-400">Total</dt>
                                <dd class="text-2xl font-semibold text-pink-500" data-summary-total>Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        <a href="{{ route('cart.checkout') }}" class="mt-4 inline-flex items-center justify-center rounded-full bg-pink-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-pink-200 transition hover:bg-pink-600">
                            Lanjutkan ke Checkout
                        </a>
                        <p class="text-xs text-gray-400">Pembayaran aman menggunakan Midtrans sandbox.</p>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-cart-item]').forEach(function (itemCard) {
            const form = itemCard.querySelector('[data-cart-item-form]');
            const input = form?.querySelector('[data-quantity-input]');
            const subtotalEl = itemCard.querySelector('[data-line-total]');
            const summaryEl = document.querySelector('[data-cart-summary]');
            const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

            if (!form || !input || !subtotalEl) {
                return;
            }

            const clampValue = (value) => {
                const min = parseInt(input.min || '1', 10);
                const max = parseInt(input.max || value, 10);
                return Math.min(Math.max(value, min), max);
            };

            const updateLineTotal = () => {
                const unitPrice = parseFloat(subtotalEl.dataset.unitPrice || '0');
                const quantity = parseInt(input.value || '1', 10);
                const subtotal = unitPrice * quantity;
                subtotalEl.textContent = formatter.format(subtotal);
                recalcSummary();
            };

            const recalcSummary = () => {
                if (!summaryEl) {
                    return;
                }

                const allLineTotals = Array.from(document.querySelectorAll('[data-line-total]'));
                const total = allLineTotals.reduce((sum, line) => {
                    const raw = line.textContent.replace(/[^0-9]/g, '');
                    return sum + parseInt(raw || '0', 10);
                }, 0);

                const subtotalTarget = summaryEl.querySelector('[data-summary-subtotal]');
                const totalTarget = summaryEl.querySelector('[data-summary-total]');

                if (subtotalTarget) {
                    subtotalTarget.textContent = formatter.format(total);
                }

                if (totalTarget) {
                    totalTarget.textContent = formatter.format(total);
                }
            };

            form.querySelectorAll('[data-action]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const current = parseInt(input.value || '1', 10);
                    const next = clampValue(button.dataset.action === 'increment' ? current + 1 : current - 1);
                    input.value = next;
                    updateLineTotal();
                });
            });

            input.addEventListener('input', function () {
                const parsed = parseInt(input.value || '1', 10);
                input.value = clampValue(Number.isNaN(parsed) ? 1 : parsed);
                updateLineTotal();
            });
        });
    </script>
@endpush
