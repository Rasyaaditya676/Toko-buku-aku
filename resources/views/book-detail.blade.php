@extends('layouts.app')

@section('title', $book->title . ' - PustakaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8">
        <a href="{{ route('landing') }}" class="hover:text-indigo-600 transition">Katalog Buku</a>
        <i class="fa-solid fa-angle-right text-[10px]"></i>
        <a href="{{ route('landing', ['category' => $book->category->slug ?? '']) }}" class="hover:text-indigo-600 transition">{{ $book->category->name ?? 'Kategori' }}</a>
        <i class="fa-solid fa-angle-right text-[10px]"></i>
        <span class="text-slate-700 font-bold truncate max-w-xs">{{ $book->title }}</span>
    </nav>

    <!-- Book Detail Grid -->
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden mb-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 p-6 sm:p-10">
            <!-- Col 1: Book Image (4 cols) -->
            <div class="md:col-span-4 flex flex-col items-center">
                <div class="w-full max-w-sm rounded-2xl overflow-hidden shadow-lg border border-slate-100 relative group bg-slate-100 aspect-[3/4]">
                    <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 left-3">
                        <span class="bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $book->category->name ?? 'Umum' }}
                        </span>
                    </div>
                </div>

                <!-- Guarantee Badges under image -->
                <div class="grid grid-cols-2 gap-3 w-full max-w-sm mt-6 text-xs text-slate-500">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-shield-check text-emerald-500 text-base"></i>
                        <span>100% Produk Original</span>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-indigo-500 text-base"></i>
                        <span>Pembayaran Online Praktis</span>
                    </div>
                </div>
            </div>

            <!-- Col 2: Book Info & Purchase Form (8 cols) -->
            <div class="md:col-span-8 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-md uppercase tracking-wider">
                                {{ $book->category->name ?? 'Buku' }}
                            </span>
                            @if($book->stock > 0)
                                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-md">
                                    <i class="fa-solid fa-check-circle mr-1"></i> Stok Tersedia ({{ $book->stock }} buku)
                                </span>
                            @else
                                <span class="text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1 rounded-md">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Stok Habis
                                </span>
                            @endif
                        </div>

                        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight">
                            {{ $book->title }}
                        </h1>

                        <p class="text-sm text-slate-500">
                            Penulis / Pengarang: <span class="font-bold text-slate-800">{{ $book->author }}</span>
                        </p>
                    </div>

                    <!-- Price Card -->
                    <div class="bg-slate-50 rounded-2xl p-4 sm:p-5 border border-slate-100 flex items-baseline gap-3">
                        <span class="text-3xl font-extrabold text-indigo-600">{{ $book->formatted_price }}</span>
                        <span class="text-xs text-slate-400">Harga resmi & sudah termasuk pajak</span>
                    </div>

                    <!-- Meta Details -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs bg-slate-50/60 p-4 rounded-2xl border border-slate-100">
                        <div>
                            <span class="block text-slate-400">Penerbit</span>
                            <span class="font-bold text-slate-700">{{ $book->publisher ?? 'Gramedia / Mitra Penerbit' }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400">ISBN</span>
                            <span class="font-bold text-slate-700">{{ $book->isbn ?? '978-602-xxx-xxx' }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400">Metode Pembayaran</span>
                            <span class="font-bold text-indigo-700">Pembayaran Online (Transfer / QRIS)</span>
                        </div>
                    </div>

                    <!-- Synopsis / Description -->
                    <div class="space-y-2 pt-2">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Sinopsis & Deskripsi Buku</h3>
                        <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                            {{ $book->description ?? 'Belum ada deskripsi lengkap untuk buku ini.' }}
                        </p>
                    </div>
                </div>

                <!-- Purchase Action Controls -->
                <div class="pt-6 border-t border-slate-100">
                    @if($book->stock > 0)
                        @auth
                            @if(Auth::user()->isAdmin())
                                <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-4 flex items-center justify-between">
                                    <span class="text-xs text-indigo-800 font-semibold">Anda sedang masuk sebagai Administrator</span>
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="bg-indigo-600 text-white text-xs font-bold px-4 py-2 rounded-xl">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Buku Ini
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('cart.add', $book->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                                        <!-- Quantity Control -->
                                        <div class="flex items-center border border-slate-200 rounded-2xl p-1 bg-slate-50 w-fit">
                                            <button type="button" onclick="decrementQty()" class="w-10 h-10 rounded-xl bg-white hover:bg-slate-100 flex items-center justify-center text-slate-700 font-bold transition shadow-sm">
                                                <i class="fa-solid fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $book->stock }}" 
                                                class="w-16 text-center bg-transparent text-sm font-bold text-slate-800 outline-none">
                                            <button type="button" onclick="incrementQty({{ $book->stock }})" class="w-10 h-10 rounded-xl bg-white hover:bg-slate-100 flex items-center justify-center text-slate-700 font-bold transition shadow-sm">
                                                <i class="fa-solid fa-plus text-xs"></i>
                                            </button>
                                        </div>

                                        <!-- Add to Cart Button -->
                                        <button type="submit" name="action" value="add_cart" class="flex-1 py-3.5 px-6 rounded-2xl font-bold text-sm bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition flex items-center justify-center gap-2 border border-indigo-200/80">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            <span>Tambah ke Keranjang</span>
                                        </button>

                                        <!-- Direct Buy (Checkout) -->
                                        <button type="submit" name="action" value="buy_now" class="flex-1 py-3.5 px-6 rounded-2xl font-bold text-sm bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-lg shadow-indigo-100 hover:shadow-indigo-200 flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-credit-card"></i>
                                            <span>Beli Sekarang</span>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <span class="text-xs text-slate-600 font-medium text-center sm:text-left">
                                    Silakan masuk ke akun Anda untuk memasukkan buku ke dalam keranjang atau membeli secara online.
                                </span>
                                <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-6 py-3 rounded-xl transition shrink-0 shadow-md">
                                    <i class="fa-solid fa-arrow-right-to-bracket mr-1.5"></i> Masuk Sekarang
                                </a>
                            </div>
                        @endauth
                    @else
                        <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl p-4 text-xs font-semibold text-center">
                            Maaf, stok buku ini saat ini sedang habis. Silakan hubungi admin untuk informasi cetak ulang.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Books in the same category -->
    @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-extrabold text-slate-900">Buku Terkait Lainnya</h3>
                <a href="{{ route('landing', ['category' => $book->category->slug ?? '']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                    Lihat Kategori Ini &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedBooks as $rBook)
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="h-48 overflow-hidden bg-slate-100">
                                <img src="{{ $rBook->image_url }}" alt="{{ $rBook->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4 space-y-1">
                                <h4 class="font-bold text-slate-900 text-sm line-clamp-1 group-hover:text-indigo-600 transition">{{ $rBook->title }}</h4>
                                <p class="text-xs text-slate-400">{{ $rBook->author }}</p>
                                <p class="text-indigo-600 font-extrabold text-sm pt-1">{{ $rBook->formatted_price }}</p>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ route('books.detail', $rBook->id) }}" class="block text-center w-full py-2 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 text-xs font-bold rounded-xl transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function decrementQty() {
        const input = document.getElementById('quantity');
        let val = parseInt(input.value) || 1;
        if (val > 1) {
            input.value = val - 1;
        }
    }

    function incrementQty(max) {
        const input = document.getElementById('quantity');
        let val = parseInt(input.value) || 1;
        if (val < max) {
            input.value = val + 1;
        }
    }
</script>
@endsection
