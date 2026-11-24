<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - PustakaKita Bookstore</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 flex min-h-screen">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 min-h-screen border-r border-slate-800">
        <!-- Logo Area -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800/80 gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/30">
                <i class="fa-solid fa-shield-halved text-base"></i>
            </div>
            <div>
                <span class="font-extrabold text-white text-base leading-tight block">Panel Admin</span>
                <span class="text-[10px] text-indigo-400 font-semibold uppercase tracking-wider">PustakaKita Store</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-grow py-6 px-4 space-y-1 text-sm font-semibold">
            <div class="text-[11px] font-bold text-slate-500 uppercase px-3 pb-2 tracking-wider">Menu Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <!-- Kategori Buku (Add/Update/Delete Kategori Buku) -->
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <i class="fa-solid fa-layer-group w-5 text-center"></i>
                <span>Kategori Buku</span>
            </a>

            <!-- Data Buku (Add/Update/Delete Data Buku) -->
            <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.books.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <i class="fa-solid fa-book w-5 text-center"></i>
                <span>Data Buku</span>
            </a>

            <div class="text-[11px] font-bold text-slate-500 uppercase px-3 pt-4 pb-2 tracking-wider">Aktivitas & User</div>

            <!-- List User yang Sudah Terdaftar -->
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span>List User Terdaftar</span>
            </a>

            <!-- List Pesanan Buku dari User yang Berbeda-beda -->
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <i class="fa-solid fa-bag-shopping w-5 text-center"></i>
                <span>List Pesanan Buku</span>
            </a>

            <!-- Pesan Masuk (Contact to Admin) -->
            <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.messages.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <i class="fa-solid fa-envelope-open-text w-5 text-center"></i>
                <span>Pesan dari User</span>
            </a>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                <i class="fa-solid fa-store w-4 text-center text-indigo-400"></i>
                <span>Lihat Toko Publik</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-950/40 transition text-left">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-slate-200/80 px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 leading-tight">@yield('page_title', 'Dashboard')</h1>
                <p class="text-xs text-slate-400">@yield('page_description', 'Kelola data toko buku Anda dengan mudah')</p>
            </div>

            <!-- Admin Profile Badge -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <span class="block text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-400">{{ Auth::user()->email }}</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-sm border border-indigo-200">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-8 pt-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-sm flex items-center justify-between gap-3 shadow-sm mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold shrink-0">
                            <i class="fa-solid fa-check text-xs"></i>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-sm flex items-center justify-between gap-3 shadow-sm mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600 font-bold shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-amber-50 border border-amber-200 text-amber-900 px-4 py-3 rounded-2xl text-sm shadow-sm mb-4">
                    <div class="flex items-center gap-2 font-bold mb-1 text-amber-800">
                        <i class="fa-solid fa-circle-exclamation"></i> Ada kesalahan pada data yang Anda kirimkan:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-amber-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="p-8 flex-grow">
            @yield('content')
        </main>
    </div>

</body>
</html>
