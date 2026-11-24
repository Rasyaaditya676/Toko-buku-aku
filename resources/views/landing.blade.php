@extends('layouts.app')

@section('title', 'PustakaKita - Toko Buku Online Modern & Terpercaya')

@section('content')
<!-- Hero Section Modern with Integrated Search -->
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900 text-white pt-16 pb-28 px-4">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:20px_20px]"></div>
    
    <div class="max-w-4xl mx-auto text-center space-y-6 relative z-10">
        <span class="inline-flex items-center gap-2 bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase">
            <i class="fa-solid fa-sparkles text-amber-400"></i> Platform Buku Terlengkap &middot; Garansi 100% Original
        </span>

        <h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight leading-tight">
            Temukan Inspirasi Terbaik di <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-sky-300 to-violet-300">PustakaKita</span>
        </h1>

        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed">
            Jelajahi ribuan judul buku favorit, dari karya sastra legendaris hingga buku pengembangan diri terpopuler. Kini dengan metode <strong>Pembayaran Online Cepat &amp; Praktis</strong> (Transfer Bank &amp; QRIS).
        </p>

        <!-- Search Bar Form (Pencarian Buku) -->
        <div class="pt-4 max-w-2xl mx-auto">
            <form action="{{ route('landing') }}" method="GET" class="relative flex items-center bg-white p-2 rounded-2xl shadow-2xl shadow-indigo-950/60 border border-white/20">
                <div class="pl-4 pr-2 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari judul buku, nama pengarang, atau penerbit..." 
                    class="w-full py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none bg-transparent">
                
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                @if(request('search'))
                    <a href="{{ route('landing') }}" class="p-2 text-slate-400 hover:text-rose-500 transition mr-1" title="Hapus pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-xl transition shadow-md shadow-indigo-600/30 shrink-0 flex items-center gap-2">
                    <span>Cari Buku</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Main Catalog Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20 pb-24">

    <!-- Categories Filter Bar -->
    <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-xl shadow-slate-200/50 border border-slate-100 mb-8 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 leading-tight">Pilih Kategori Buku</h3>
                    <p class="text-xs text-slate-400">Filter buku berdasarkan minat dan bidang favorit Anda</p>
                </div>
            </div>

            <!-- Sorting Dropdown -->
            <form action="{{ route('landing') }}" method="GET" class="flex items-center gap-2 self-start md:self-auto">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <label for="sort" class="text-xs font-semibold text-slate-500 whitespace-nowrap">Urutkan:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-medium rounded-xl px-3 py-2 outline-none focus:border-indigo-500">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul: A &rarr; Z</option>
                </select>
            </form>
        </div>

        <!-- Category Badges / Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
            <a href="{{ route('landing', array_merge(request()->except(['category', 'page']))) }}" 
                class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition {{ !request('category') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Kategori ({{ $categories->sum('books_count') }})
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('landing', array_merge(request()->except(['page']), ['category' => $cat->slug])) }}" 
                    class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ request('category') === $cat->slug ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <span>{{ $cat->name }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ request('category') === $cat->slug ? 'bg-indigo-700 text-white' : 'bg-slate-200 text-slate-500' }}">{{ $cat->books_count }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Active Search/Filter Info -->
    @if(request('search') || request('category'))
        <div class="mb-6 flex items-center justify-between bg-indigo-50/60 border border-indigo-100 rounded-2xl px-5 py-3 text-xs text-indigo-900">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-filter text-indigo-600"></i>
                <span>Menampilkan hasil untuk: 
                    @if(request('search'))
                        kata kunci <strong>"{{ request('search') }}"</strong>
                    @endif
                    @if(request('category'))
                        kategori <strong>"{{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}"</strong>
                    @endif
                    ({{ $books->total() }} buku ditemukan)
                </span>
            </div>
            <a href="{{ route('landing') }}" class="font-bold text-rose-600 hover:text-rose-800 flex items-center gap-1">
                <i class="fa-solid fa-rotate-left"></i> Reset Filter
            </a>
        </div>
    @endif

    <!-- Books Grid Catalog -->
    @if($books->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm space-y-4">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Tidak Ada Buku yang Ditemukan</h3>
            <p class="text-xs text-slate-400 max-w-md mx-auto">
                Coba gunakan kata kunci lain atau pilih kategori yang berbeda untuk menemukan buku yang Anda cari.
            </p>
            <div class="pt-2">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Semua Katalog
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative h-64 overflow-hidden bg-slate-100">
                            <a href="{{ route('books.detail', $book->id) }}" class="block w-full h-full">
                                <img src="{{ $book->image_url }}" alt="{{ $book->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-3 left-3">
                                @if($book->stock > 0)
                                    <span class="bg-emerald-500/95 backdrop-blur-md text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow-sm">
                                        Stok: {{ $book->stock }}
                                    </span>
                                @else
                                    <span class="bg-rose-500 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow-sm">
                                        Habis
                                    </span>
                                @endif
                            </div>

                            <!-- Online Pay Available Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                    <i class="fa-solid fa-credit-card mr-1"></i> Online Pay
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 space-y-2">
                            <!-- Category Name -->
                            <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-md">
                                {{ $book->category->name ?? 'Umum' }}
                            </span>

                            <!-- Title -->
                            <h3 class="font-bold text-slate-900 text-base line-clamp-1 group-hover:text-indigo-600 transition">
                                <a href="{{ route('books.detail', $book->id) }}">{{ $book->title }}</a>
                            </h3>

                            <!-- Author -->
                            <p class="text-xs text-slate-400 line-clamp-1">
                                Penulis: <span class="text-slate-600 font-medium">{{ $book->author }}</span>
                            </p>

                            <!-- Price -->
                            <div class="pt-1">
                                <span class="text-indigo-600 font-extrabold text-lg">{{ $book->formatted_price }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="p-5 pt-0 space-y-2">
                        @if($book->stock > 0)
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="w-full flex items-center justify-center gap-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold py-2.5 rounded-xl transition">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit Data Buku (Admin)
                                    </a>
                                @else
                                    <div class="grid grid-cols-2 gap-2">
                                        <!-- Add to Cart Form -->
                                        <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full flex items-center justify-center gap-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold py-2.5 rounded-xl transition" title="Tambah ke Keranjang">
                                                <i class="fa-solid fa-cart-plus"></i> +Keranjang
                                            </button>
                                        </form>

                                        <!-- Buy Now / Checkout Directly -->
                                        <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="action" value="buy_now">
                                            <button type="submit" class="w-full flex items-center justify-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 rounded-xl transition shadow-md shadow-indigo-100">
                                                <i class="fa-solid fa-bag-shopping"></i> Beli
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-slate-900 hover:bg-indigo-600 text-white text-xs font-bold py-3 rounded-xl transition shadow-sm">
                                    <i class="fa-solid fa-cart-shopping text-xs"></i> Masuk untuk Membeli
                                </a>
                            @endauth
                        @else
                            <button disabled class="w-full bg-slate-100 text-slate-400 text-xs font-bold py-2.5 rounded-xl cursor-not-allowed">
                                Stok Buku Habis
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $books->links() }}
        </div>
    @endif
</section>

<!-- Online Payment Information Banner Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="bg-gradient-to-r from-indigo-900 to-indigo-800 rounded-3xl p-8 sm:p-12 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="space-y-3 max-w-xl text-center md:text-left">
            <span class="bg-indigo-500 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider inline-block">
                Kemudahan Transaksi
            </span>
            <h3 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                Layanan Pembayaran Online Praktis &amp; Aman
            </h3>
            <p class="text-indigo-200 text-xs sm:text-sm leading-relaxed">
                Nikmati kemudahan transaksi belanja buku favorit Anda dengan berbagai saluran pembayaran online: Transfer Bank (BCA, Mandiri) serta scan QRIS instan dari semua e-wallet terkemuka.
            </p>
        </div>
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('about') }}" class="bg-white hover:bg-slate-100 text-indigo-900 font-bold px-6 py-3.5 rounded-2xl text-xs transition shadow-lg">
                Pelajari Tentang Kami
            </a>
            <a href="{{ route('contact') }}" class="bg-indigo-700/60 hover:bg-indigo-700 text-white font-bold px-6 py-3.5 rounded-2xl text-xs transition border border-indigo-400/40">
                Hubungi Admin
            </a>
        </div>
    </div>
</section>
@endsection
