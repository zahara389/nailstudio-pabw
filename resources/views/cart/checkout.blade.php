@extends('layouts.app')

@section('title', 'Checkout | Nail Studio')

@section('body-class', 'gradient-bg min-h-screen')

@section('content')
    <section class="bg-gradient-to-b from-white via-pink-50/60 to-white py-16">
        <div class="mx-auto max-w-5xl px-4">
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-400">Langkah Terakhir</p>
                <h1 class="mt-2 text-3xl font-semibold text-gray-900">Checkout & Pembayaran</h1>
                <p class="mt-2 text-sm text-gray-500">Isi detailmu dan selesaikan pembayaran melalui Midtrans sandbox.</p>
            </div>

            @if (session('alert'))
                <div class="mt-6 rounded-3xl border border-rose-100 bg-rose-50 px-6 py-4 text-sm text-rose-700">
                    {{ session('alert') }}
                </div>
            @endif

            <div class="mt-12 grid gap-8 lg:grid-cols-12">
                <div class="space-y-6 rounded-[2rem] bg-white/95 p-8 shadow-xl shadow-pink-100/70 ring-1 ring-white/70 lg:col-span-7">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-400">Informasi Pemesan</p>
                        <h2 class="text-2xl font-semibold text-gray-900">Detail Kontak</h2>
                    </div>
                    <form action="{{ route('cart.checkout.process') }}" method="POST" class="space-y-5" data-checkout-form>
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <label class="flex flex-col gap-2 text-sm font-medium text-gray-600">
                                Nama Lengkap
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="rounded-2xl border border-gray-200/80 px-4 py-3 text-sm text-gray-900 focus:border-pink-400 focus:outline-none">
                            </label>
                            <label class="flex flex-col gap-2 text-sm font-medium text-gray-600">
                                Email
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="rounded-2xl border border-gray-200/80 px-4 py-3 text-sm text-gray-900 focus:border-pink-400 focus:outline-none">
                            </label>
                            <label class="flex flex-col gap-2 text-sm font-medium text-gray-600">
                                Nomor Telepon
                                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required class="rounded-2xl border border-gray-200/80 px-4 py-3 text-sm text-gray-900 focus:border-pink-400 focus:outline-none">
                            </label>
                            <label class="flex flex-col gap-2 text-sm font-medium text-gray-600">
                                Kota / Area
                                <input type="text" name="address" value="{{ old('address') }}" placeholder="Contoh: Bandung, Jawa Barat" required class="rounded-2xl border border-gray-200/80 px-4 py-3 text-sm text-gray-900 focus:border-pink-400 focus:outline-none">
                            </label>
                        </div>
                        <label class="flex flex-col gap-2 text-sm font-medium text-gray-600">
                            Catatan Tambahan (opsional)
                            <textarea name="notes" rows="3" placeholder="Tulis preferensi warna atau waktu pengiriman" class="rounded-2xl border border-gray-200/80 px-4 py-3 text-sm text-gray-900 focus:border-pink-400 focus:outline-none">{{ old('notes') }}</textarea>
                        </label>

                        <div class="rounded-2xl bg-amber-50 px-4 py-3 text-sm text-amber-700">
                            Pastikan data sesuai sebelum melanjutkan. Pembayaran diproses menggunakan Midtrans Snap (Sandbox) sehingga aman dan terenkripsi.
                        </div>

                        <div data-checkout-message class="text-sm font-semibold text-rose-500"></div>

                        <button type="submit" data-checkout-submit class="inline-flex w-full items-center justify-center rounded-full bg-pink-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-pink-200 transition hover:bg-pink-600 focus:outline-none">
                            Bayar melalui Midtrans
                        </button>
                    </form>
                </div>

                <aside class="space-y-6 rounded-[2rem] bg-white/95 p-8 shadow-xl shadow-pink-100/70 ring-1 ring-white/70 lg:col-span-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-400">Ringkasan Pesanan</p>
                        <h2 class="text-2xl font-semibold text-gray-900">{{ $items->count() }} item</h2>
                    </div>
                    <div class="space-y-4 divide-y divide-gray-100">
                        @foreach ($items as $item)
                            <div class="flex items-start justify-between gap-4 pt-4 first:pt-0">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $item->product->name ?? 'Produk Nail Studio' }}</p>
                                    <p class="text-xs text-gray-400">Qty {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                    <dl class="space-y-4 text-sm text-gray-500">
                        <div class="flex items-center justify-between">
                            <dt>Subtotal</dt>
                            <dd class="text-base font-semibold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>Ongkir</dt>
                            <dd class="text-base font-semibold text-gray-400">Dihitung setelah pembayaran</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-dashed border-gray-200 pt-4">
                            <dt class="text-sm font-semibold text-gray-400">Total</dt>
                            <dd class="text-2xl font-semibold text-pink-500">Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                    <p class="text-xs text-gray-400">Dengan menekan tombol bayar, Anda akan diarahkan ke popup Snap Midtrans sandbox.</p>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    <script>
        (function () {
            const form = document.querySelector('[data-checkout-form]');
            const submitButton = form?.querySelector('[data-checkout-submit]');
            const messageBox = document.querySelector('[data-checkout-message]');

            if (!form || !submitButton) {
                return;
            }

            const showMessage = (message, isError = true) => {
                if (messageBox) {
                    messageBox.textContent = message || '';
                    messageBox.classList.toggle('text-emerald-600', !isError);
                    messageBox.classList.toggle('text-rose-500', isError);
                }
            };

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                if (!window.snap) {
                    showMessage('Integrasi Midtrans belum siap. Pastikan client key sudah terpasang.');
                    return;
                }

                submitButton.disabled = true;
                submitButton.textContent = 'Memproses...';
                showMessage('');

                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal memproses checkout.');
                    }

                    window.snap.pay(data.snap_token, {
                        onSuccess: function () {
                            showMessage('Pembayaran berhasil! Mengarahkan ke riwayat transaksi...', false);
                            window.location.href = "{{ route('transaction.history') }}";
                        },
                        onPending: function () {
                            showMessage('Pembayaran dalam proses. Kamu bisa melihat statusnya di riwayat transaksi.', false);
                            window.location.href = "{{ route('transaction.history') }}";
                        },
                        onError: function () {
                            showMessage('Pembayaran gagal. Silakan coba lagi atau gunakan metode lain.');
                        },
                        onClose: function () {
                            showMessage('Popup pembayaran ditutup sebelum selesai.');
                            submitButton.disabled = false;
                            submitButton.textContent = 'Bayar melalui Midtrans';
                        },
                    });
                } catch (error) {
                    showMessage(error.message || 'Terjadi kesalahan tidak terduga.');
                    submitButton.disabled = false;
                    submitButton.textContent = 'Bayar melalui Midtrans';
                }
            });
        })();
    </script>
@endpush
