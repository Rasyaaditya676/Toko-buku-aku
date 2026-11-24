@extends('layouts.app')

@section('title', 'Dashboard Saya - PustakaKita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- Page Header & Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-900 to-indigo-800 rounded-3xl p-6 sm:p-10 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center md:text-left">
            <span class="bg-indigo-700/60 text-indigo-200 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider inline-block">
                Dashboard Pelanggan
            </span>
            <h1 class="text-2xl sm:text-3xl font-black">Halo, {{ $user->name }}!</h1>
            <p class="text-xs sm:text-sm text-indigo-200">
                Kelola pesanan buku Anda dan pantau status transaksi serta proses pengiriman di sini.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('landing') }}" class="bg-white hover:bg-slate-100 text-indigo-900 font-bold px-5 py-3 rounded-2xl text-xs transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-cart-shopping"></i> Belanja Buku Lagi
            </a>
            <a href="{{ route('contact') }}" class="bg-indigo-700/60 hover:bg-indigo-700 text-white font-bold px-5 py-3 rounded-2xl text-xs transition border border-indigo-400/40 flex items-center gap-2">
                <i class="fa-solid fa-headset"></i> Butuh Bantuan?
            </a>
        </div>
    </div>

    <!-- User Profile & Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <!-- Profile Card (4 cols) -->
        <div class="md:col-span-4 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-sm">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                </div>
            </div>

            <div class="space-y-2.5 text-xs text-slate-600">
                <div>
                    <span class="block text-slate-400">Nomor Telepon:</span>
                    <span class="font-bold text-slate-800">{{ $user->phone ?? 'Belum ditambahkan' }}</span>
                </div>
                <div>
                    <span class="block text-slate-400">Alamat Pengiriman Default:</span>
                    <span class="font-bold text-slate-800">{{ $user->address ?? 'Belum ditambahkan' }}</span>
                </div>
                <div>
                    <span class="block text-slate-400">Terdaftar Sejak:</span>
                    <span class="font-semibold text-slate-700">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards (8 cols) -->
        <div class="md:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Stat 1 -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between space-y-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-medium">Total Pesanan</span>
                    <h4 class="text-2xl font-black text-slate-900">{{ $orders->total() }}</h4>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between space-y-2">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-medium">Pesanan Aktif / Berjalan</span>
                    <h4 class="text-2xl font-black text-slate-900">{{ $activeOrdersCount }}</h4>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-medium">Total Pembelian Selesai</span>
                    <h4 class="text-xl font-black text-emerald-600">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

    </div>

    <!-- Order History Section -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Riwayat Pesanan Buku Anda</h2>
                <p class="text-xs text-slate-400">Semua pesanan yang pernah Anda lakukan di PustakaKita</p>
            </div>
            <a href="{{ route('landing') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                Pesan Buku Baru &rarr;
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="p-12 text-center space-y-4">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Riwayat Pesanan</h4>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">
                        Anda belum pernah membuat pesanan buku. Silakan buka katalog kami dan nikmati kemudahan transaksi online!
                    </p>
                </div>
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-md">
                    Mulai Belanja Sekarang
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3.5 px-6">No. Pesanan</th>
                            <th class="py-3.5 px-6">Tanggal</th>
                            <th class="py-3.5 px-6">Daftar Buku</th>
                            <th class="py-3.5 px-6">Metode Bayar</th>
                            <th class="py-3.5 px-6">Total Harga</th>
                            <th class="py-3.5 px-6">Status Pesanan</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($orders as $order)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-4 px-6 font-extrabold text-slate-900">
                                    {{ $order->order_number }}
                                </td>
                                <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-6 max-w-xs">
                                    <div class="space-y-1">
                                        @foreach($order->items as $item)
                                            <div class="truncate text-slate-800 font-medium">
                                                &bull; {{ $item->book_title }} <span class="text-slate-400">({{ $item->quantity }}x)</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 font-bold text-slate-800 bg-slate-100 px-2.5 py-0.5 rounded-md">
                                        <i class="fa-solid fa-credit-card text-[11px] text-indigo-500"></i>
                                        <span>{{ $order->payment_method }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-extrabold text-indigo-600 whitespace-nowrap text-sm">
                                    {{ $order->formatted_total }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-block px-3 py-1 rounded-full font-bold text-[11px] border {{ $order->status_badge_class }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <a href="{{ route('user.order.detail', $order->id) }}" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 font-bold px-3.5 py-2 rounded-xl transition">
                                        <i class="fa-solid fa-file-invoice text-xs"></i>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
