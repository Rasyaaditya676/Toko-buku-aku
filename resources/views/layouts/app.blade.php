<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PustakaKita - Toko Buku Online Modern')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen selection:bg-indigo-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-indigo-900 text-white text-xs py-2 px-4 text-center font-medium">
        <span class="inline-flex items-center gap-1.5">
            <span class="bg-indigo-500 text-white font-bold px-2 py-0.5 rounded text-[10px] uppercase tracking-wider">Online Payment</span>
            Belanja Buku Mudah &amp; Aman &middot; <strong>Pembayaran Online Instan (Transfer Bank &amp; QRIS)</strong> &middot; Buku 100% Original
        </span>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 transition-all shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="text-2xl font-black text-slate-900 flex items-center gap-2.5 group shrink-0">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200 group-hover:scale-105 transition-transform duration-300">
                    <i class="fa-solid fa-book-open-reader text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="leading-none text-xl font-extrabold tracking-tight">Pustaka<span class="text-indigo-600">Kita</span></span>
                    <span class="text-[10px] text-slate-400 font-medium tracking-widest uppercase">Bookstore Online</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('landing') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('landing') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-compass mr-1.5 text-xs"></i> Katalog Buku
                </a>
                <a href="{{ route('about') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('about') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-circle-info mr-1.5 text-xs"></i> Tentang Kami
                </a>
                <a href="{{ route('contact') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-envelope mr-1.5 text-xs"></i> Hubungi Kami
                </a>
            </div>

            <!-- Right Controls (Cart & Auth) -->
            <div class="flex items-center gap-3">
                @auth
                    @if(Auth::user()->isAdmin())
                        <!-- Admin Quick Link -->
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-3.5 py-2 rounded-xl text-xs font-bold transition border border-indigo-200/60 shadow-sm">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span class="hidden sm:inline">Panel Admin</span>
                        </a>
                    @else
                        <!-- Shopping Cart Button with Dynamic Badge -->
                        <a href="{{ route('cart.index') }}" class="relative p-2.5 rounded-xl text-slate-700 hover:text-indigo-600 hover:bg-slate-100 transition" title="Keranjang Belanja">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                            @if(($cartCount ?? 0) > 0)
                                <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[11px] font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-md animate-pulse">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Dashboard Link -->
                        <a href="{{ route('user.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 text-slate-700 hover:text-indigo-600 px-3 py-2 rounded-xl text-sm font-semibold transition hover:bg-slate-50">
                            <i class="fa-solid fa-box-open text-xs text-indigo-500"></i>
                            <span>Pesanan Saya</span>
                        </a>
                    @endif

                    <!-- User Profile Dropdown Pill -->
                    <div class="flex items-center gap-2 bg-slate-100 py-1.5 pl-3 pr-2 rounded-2xl text-xs">
                        <span class="font-bold text-slate-700 truncate max-w-[110px]">{{ Auth::user()->name }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ Auth::user()->isAdmin() ? 'bg-indigo-600 text-white' : 'bg-emerald-600 text-white' }}">
                            {{ Auth::user()->role }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                            @csrf
                            <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 transition" title="Keluar">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold px-3 py-2 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-bold px-4 sm:px-5 py-2.5 rounded-xl transition shadow-lg shadow-indigo-100 hover:shadow-indigo-200">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Global Alert Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-2xl text-sm flex items-center justify-between gap-3 shadow-sm mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0 font-bold">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-2xl text-sm flex items-center justify-between gap-3 shadow-sm mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0 font-bold">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-amber-50 border border-amber-200 text-amber-900 px-4 py-3.5 rounded-2xl text-sm shadow-sm mb-4">
                <div class="flex items-center gap-2 font-bold mb-1 text-amber-800">
                    <i class="fa-solid fa-circle-exclamation"></i> Ada beberapa kesalahan dalam pengisian formulir:
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 text-amber-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Body Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-10 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <span class="text-xl font-black text-white">Pustaka<span class="text-indigo-400">Kita</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Toko buku online terpercaya menyajikan koleksi buku bermutu tinggi, terlengkap, dan 100% original. Siap mendukung kemajuan literasi Indonesia.
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-slate-400">
                        <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-instagram text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-whatsapp text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-facebook text-xs"></i></a>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Navigasi Toko</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('landing') }}" class="hover:text-indigo-400 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Katalog Buku Lengkap</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-indigo-400 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Tentang Kami (About Us)</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-400 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Hubungi Admin (Contact Us)</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-indigo-400 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Keranjang Belanja</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Kami -->
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Layanan Kami</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-shield-check text-emerald-400 mt-0.5"></i>
                            <span>Buku 100% Original dari Penerbit Resmi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-truck-fast text-indigo-400 mt-0.5"></i>
                            <span>Pengiriman Cepat ke Seluruh Indonesia</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-credit-card text-indigo-400 mt-0.5"></i>
                            <span><strong>Pembayaran Online Praktis</strong>: Transfer Bank (BCA, Mandiri) &amp; QRIS E-Wallet</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Kontak Toko -->
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider">Lokasi & Kontak</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        <i class="fa-solid fa-location-dot text-indigo-400 mr-1.5"></i> Gedung Sentra Pustaka Lt. 3, Jl. MH Thamrin No. 45, Jakarta Pusat 10350
                    </p>
                    <p class="text-xs text-slate-400">
                        <i class="fa-solid fa-envelope text-indigo-400 mr-1.5"></i> support@pustakakita.id
                    </p>
                    <p class="text-xs text-slate-400">
                        <i class="fa-solid fa-phone text-indigo-400 mr-1.5"></i> (021) 555-0192 / 0812-3456-7890
                    </p>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} PustakaKita Bookstore. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-4">
                    <span>Sertifikasi BNSP &bull; Aplikasi Toko Buku Modern</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
