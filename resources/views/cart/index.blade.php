@extends('layouts.app')

@section('title', 'Keranjang Belanja - PustakaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">Keranjang Belanja</h1>
            <p class="text-xs text-slate-400 mt-1">Periksa kembali daftar buku yang ingin Anda pesan sebelum melanjutkan ke pembayaran</p>
        </div>

        @if($carts->isNotEmpty())
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh isi keranjang?')">
                @csrf
                <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 flex items-center gap-1.5 px-3 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 transition">
                    <i class="fa-regular fa-trash-can"></i> Kosongkan Keranjang
                </button>
            </form>
        @endif
    </div>

    @if($carts->isEmpty())
        <!-- Empty Cart State -->
        <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm max-w-xl mx-auto space-y-5">
            <div class="w-20 h-20 bg-indigo-50 text-indigo-500 rounded-3xl flex items-center justify-center mx-auto text-3xl shadow-inner">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-lg font-bold text-slate-800">Keranjang Belanja Anda Masih Kosong</h3>
                <p class="text-xs text-slate-400 leading-relaxed max-w-sm mx-auto">
                    Anda belum memasukkan buku apa pun ke dalam keranjang. Jelajahi katalog buku kami sekarang dan temukan bacaan favorit Anda!
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-6 py-3.5 rounded-xl transition shadow-lg shadow-indigo-100">
                    <i class="fa-solid fa-compass"></i> Jelajahi Katalog Buku
                </a>
            </div>
        </div>
    @else
        <!-- Cart Items & Summary Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Col 1: Cart Items Table (8 cols) -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-extrabold text-slate-800">Daftar Buku ({{ $carts->count() }} item)</span>
                    <a href="{{ route('landing') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                        <i class="fa-solid fa-plus text-[10px]"></i> Tambah Buku Lain
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($carts as $cart)
                        <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 group">
                            <!-- Book Info -->
                            <div class="flex items-center gap-4 flex-grow min-w-0">
                                <a href="{{ route('books.detail', $cart->book_id) }}" class="w-16 h-22 rounded-xl overflow-hidden bg-slate-100 shrink-0 shadow-sm border border-slate-100">
                                    <img src="{{ $cart->book->image_url }}" alt="{{ $cart->book->title }}" class="w-full h-full object-cover">
                                </a>
                                <div class="space-y-1 min-w-0">
                                    <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded uppercase">
                                        {{ $cart->book->category->name ?? 'Buku' }}
                                    </span>
                                    <h4 class="font-bold text-slate-900 text-sm truncate group-hover:text-indigo-600 transition">
                                        <a href="{{ route('books.detail', $cart->book_id) }}">{{ $cart->book->title }}</a>
                                    </h4>
                                    <p class="text-xs text-slate-400">Oleh {{ $cart->book->author }}</p>
                                    <p class="text-xs font-bold text-indigo-600 sm:hidden">{{ $cart->book->formatted_price }}</p>
                                </div>
                            </div>

                            <!-- Quantity Controls & Subtotal -->
                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto shrink-0 pt-2 sm:pt-0 border-t sm:border-0 border-slate-50">
                                <!-- Unit Price (Desktop) -->
                                <div class="hidden sm:block text-right">
                                    <span class="text-xs text-slate-400 block">Harga Satuan</span>
                                    <span class="text-xs font-bold text-slate-700">{{ $cart->book->formatted_price }}</span>
                                </div>

                                <!-- Quantity Form -->
                                <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex items-center border border-slate-200 rounded-xl p-0.5 bg-slate-50">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="quantity" value="{{ max(1, $cart->quantity - 1) }}" 
                                        class="w-7 h-7 rounded-lg bg-white hover:bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs shadow-sm transition {{ $cart->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-minus text-[10px]"></i>
                                    </button>
                                    <span class="w-10 text-center font-bold text-xs text-slate-800">{{ $cart->quantity }}</span>
                                    <button type="submit" name="quantity" value="{{ $cart->quantity + 1 }}" 
                                        class="w-7 h-7 rounded-lg bg-white hover:bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs shadow-sm transition {{ $cart->quantity >= $cart->book->stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $cart->quantity >= $cart->book->stock ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                    </button>
                                </form>

                                <!-- Subtotal -->
                                <div class="text-right min-w-[90px]">
                                    <span class="text-xs text-slate-400 block sm:hidden">Total Item</span>
                                    <span class="text-sm font-extrabold text-indigo-600">{{ $cart->formatted_subtotal }}</span>
                                </div>

                                <!-- Delete Action -->
                                <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus dari keranjang">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Col 2: Order Summary Box (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xl shadow-slate-100 space-y-6">
                    <h3 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-4">
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Subtotal Buku ({{ $carts->sum('quantity') }} eks)</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center justify-between text-slate-600">
                            <span class="flex items-center gap-1">
                                <span>Estimasi Ongkos Kirim</span>
                                <i class="fa-solid fa-circle-question text-[10px] text-slate-400" title="Tarif flat standar kurir express"></i>
                            </span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="font-bold text-slate-900">Total Pembayaran</span>
                            <span class="font-black text-indigo-600 text-lg">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Online Payment Highlight Callout -->
                    <div class="bg-indigo-50 border border-indigo-200/80 rounded-2xl p-4 space-y-1.5 text-xs text-indigo-950">
                        <div class="font-bold flex items-center gap-2 text-indigo-800">
                            <i class="fa-solid fa-credit-card text-indigo-600"></i>
                            <span>Pembayaran Online Tersedia</span>
                        </div>
                        <p class="text-indigo-700 leading-relaxed text-[11px]">
                            Mendukung Transfer Bank (BCA &amp; Mandiri) serta QRIS / E-Wallet (GoPay, OVO, ShopeePay, DANA) dengan verifikasi cepat &amp; aman.
                        </p>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('checkout.index') }}" class="w-full py-4 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl text-sm transition shadow-lg shadow-indigo-100 hover:shadow-indigo-200 flex items-center justify-center gap-2">
                        <span>Lanjut ke Checkout</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>

                    <!-- Safe Shopping Guarantee -->
                    <div class="text-center text-[11px] text-slate-400 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-lock text-emerald-500"></i>
                        <span>Transaksi Aman & Terpercaya &bull; Garansi 100% Asli</span>
                    </div>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
