@extends('layouts.app')

@section('title', 'Checkout Pesanan - PustakaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
        <a href="{{ route('landing') }}" class="hover:text-indigo-600 transition">Katalog Buku</a>
        <i class="fa-solid fa-angle-right text-[10px]"></i>
        <a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition">Keranjang Belanja</a>
        <i class="fa-solid fa-angle-right text-[10px]"></i>
        <span class="text-slate-700 font-bold">Formulir Checkout & Pembayaran</span>
    </nav>

    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">Checkout & Konfirmasi Pesanan</h1>
        <p class="text-xs text-slate-400 mt-1">Lengkapi alamat pengiriman dan pilih metode pembayaran favorit Anda</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Col 1: Delivery Details & Payment Method (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- 1. Alamat Pengiriman -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                            1
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">Alamat Pengiriman Buku</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Penerima -->
                        <div>
                            <label for="recipient_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Penerima Paket</label>
                            <input type="text" name="recipient_name" id="recipient_name" 
                                value="{{ old('recipient_name', $user->name) }}" required
                                placeholder="Nama lengkap penerima"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>

                        <!-- No. Telepon / WA -->
                        <div>
                            <label for="recipient_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. Telepon / WhatsApp Aktif</label>
                            <input type="text" name="recipient_phone" id="recipient_phone" 
                                value="{{ old('recipient_phone', $user->phone) }}" required
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label for="shipping_address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap (Nama Jalan, No. Rumah, RT/RW, Patokan)</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" required
                            placeholder="Contoh: Jl. Melati No. 15, RT 02/RW 04, Kel. Kebayoran, dekat Masjid Al-Falah"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">{{ old('shipping_address', $user->address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kota / Kabupaten -->
                        <div>
                            <label for="city" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kota / Kabupaten</label>
                            <input type="text" name="city" id="city" 
                                value="{{ old('city', 'Jakarta Selatan') }}" required
                                placeholder="Kota tujuan"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <label for="postal_code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Pos</label>
                            <input type="text" name="postal_code" id="postal_code" 
                                value="{{ old('postal_code', '12150') }}"
                                placeholder="Contoh: 12150"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>
                    </div>

                    <!-- Catatan Pengiriman -->
                    <div>
                        <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan untuk Kurir (Opsional)</label>
                        <input type="text" name="notes" id="notes" 
                            value="{{ old('notes') }}"
                            placeholder="Contoh: Tolong hubungi sebelum tiba atau titip di pos security"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                    </div>
                </div>

                <!-- 2. Pilihan Metode Pembayaran Online -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                            2
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Pilihan Metode Pembayaran Online</h2>
                            <p class="text-xs text-slate-400">Pilih opsi pembayaran transfer atau QRIS yang Anda inginkan</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <!-- OPSI 1: Transfer Bank BCA (Default) -->
                        <label class="relative flex items-start gap-4 p-5 rounded-2xl border-2 border-indigo-600 bg-indigo-50/30 cursor-pointer transition hover:bg-indigo-50/50">
                            <input type="radio" name="payment_method" value="Transfer Bank (BCA)" checked
                                class="mt-1 w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                            <div class="space-y-1 flex-grow">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-slate-900 text-sm">Transfer Bank BCA</span>
                                    <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                                        Rekomendasi
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600">
                                    No. Rekening: <strong class="text-indigo-900 font-bold">882-019-4821</strong> a/n PT PustakaKita Indonesia
                                </p>
                                <p class="text-[11px] text-slate-400">Verifikasi otomatis &ndash; proses pengemasan langsung dimulai setelah transfer.</p>
                            </div>
                            <div class="text-2xl text-indigo-600 shrink-0">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                        </label>

                        <!-- OPSI 2: Transfer Bank Mandiri -->
                        <label class="relative flex items-start gap-4 p-4 rounded-2xl border border-slate-200 hover:border-indigo-300 cursor-pointer transition">
                            <input type="radio" name="payment_method" value="Transfer Bank (Mandiri)" 
                                class="mt-1 w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                            <div class="space-y-1 flex-grow">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-800 text-sm">Transfer Bank Mandiri</span>
                                </div>
                                <p class="text-xs text-slate-500">
                                    No. Rekening: <strong class="text-slate-800">137-00-9821-4455</strong> a/n PustakaKita Store
                                </p>
                            </div>
                            <div class="text-xl text-slate-400 shrink-0">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                        </label>

                        <!-- OPSI 3: QRIS / E-Wallet -->
                        <label class="relative flex items-start gap-4 p-4 rounded-2xl border border-slate-200 hover:border-indigo-300 cursor-pointer transition">
                            <input type="radio" name="payment_method" value="QRIS / E-Wallet" 
                                class="mt-1 w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                            <div class="space-y-1 flex-grow">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-800 text-sm">QRIS / E-Wallet (GoPay, OVO, ShopeePay, DANA)</span>
                                </div>
                                <p class="text-xs text-slate-500">
                                    Scan kode QRIS instan yang muncul setelah konfirmasi pesanan.
                                </p>
                            </div>
                            <div class="text-xl text-slate-400 shrink-0">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Col 2: Order Review & Total (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xl shadow-slate-100 space-y-6 sticky top-28">
                    <h3 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-4">
                        Ringkasan Belanja
                    </h3>

                    <!-- List of items to be purchased -->
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        @foreach($carts as $cart)
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-16 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-100">
                                    <img src="{{ $cart->book->image_url }}" alt="{{ $cart->book->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0 flex-grow text-xs space-y-0.5">
                                    <h4 class="font-bold text-slate-800 truncate">{{ $cart->book->title }}</h4>
                                    <p class="text-slate-400">{{ $cart->quantity }} &times; {{ $cart->book->formatted_price }}</p>
                                    <p class="font-bold text-indigo-600">{{ $cart->formatted_subtotal }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Price Calculations -->
                    <div class="space-y-2.5 pt-4 border-t border-slate-100 text-xs">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Subtotal Buku</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Ongkos Kirim (Flat Kurir)</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="font-extrabold text-slate-900">Total Tagihan</span>
                            <span class="font-black text-indigo-600 text-xl">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl text-sm transition shadow-lg shadow-indigo-100 hover:shadow-indigo-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Konfirmasi &amp; Bayar Pesanan Online</span>
                    </button>

                    <p class="text-center text-[11px] text-slate-400">
                        Dengan membuat pesanan, Anda menyetujui syarat & ketentuan pengiriman toko buku PustakaKita.
                    </p>
                </div>
            </div>

        </div>

    </form>

</div>
@endsection
