@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Ringkasan Toko Buku')
@section('page_description', 'Pantau kinerja penjualan, stok buku, dan pesanan pelanggan')

@section('content')
<div class="space-y-8">

    <!-- Quick Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat 1: Pendapatan Selesai -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan (Selesai)</span>
                <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <span class="text-[11px] text-emerald-600 font-bold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Penjualan Pembayaran Online
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-rupiah-sign"></i>
            </div>
        </div>

        <!-- Stat 2: Total Pesanan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesanan</span>
                <h3 class="text-2xl font-black text-slate-900">{{ $totalOrders }}</h3>
                <span class="text-[11px] text-indigo-600 font-bold">
                    {{ $pendingOrders }} menunggu konfirmasi
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
        </div>

        <!-- Stat 3: Total Judul Buku -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Katalog Buku</span>
                <h3 class="text-2xl font-black text-slate-900">{{ $totalBooks }}</h3>
                <span class="text-[11px] text-slate-400 font-medium">
                    Dalam {{ $totalCategories }} kategori berbeda
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-book"></i>
            </div>
        </div>

        <!-- Stat 4: Total User Terdaftar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">User Terdaftar</span>
                <h3 class="text-2xl font-black text-slate-900">{{ $totalUsers }}</h3>
                <span class="text-[11px] text-amber-600 font-bold">
                    {{ $unreadMessages }} pesan user belum dibaca
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions Banner -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
        <div class="space-y-1 text-center md:text-left">
            <h3 class="text-lg font-black">Aksi Cepat Pengelolaan Toko</h3>
            <p class="text-xs text-slate-300">Tambahkan buku baru, atur kategori, atau verifikasi pesanan online yang baru masuk.</p>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('admin.books.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Buku Baru
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition border border-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-layer-group"></i> Kelola Kategori
            </a>
            <a href="{{ route('admin.orders.index') }}" class="bg-indigo-500 hover:bg-indigo-400 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-receipt"></i> Proses Pesanan Online
            </a>
        </div>
    </div>

    <!-- Recent Orders & Low Stock Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Col 1: Recent Orders (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Pesanan Pelanggan Terbaru</h3>
                    <p class="text-xs text-slate-400">Pantau pesanan yang baru masuk dari berbagai user</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                    Lihat Semua Pesanan &rarr;
                </a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="p-10 text-center text-xs text-slate-400">
                    Belum ada pesanan yang masuk saat ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-6">Pesanan</th>
                                <th class="py-3 px-6">Pelanggan</th>
                                <th class="py-3 px-6">Metode</th>
                                <th class="py-3 px-6">Total</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-slate-900">
                                        {{ $order->order_number }}
                                        <span class="block text-[10px] text-slate-400 font-normal">{{ $order->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-slate-800">
                                        {{ $order->recipient_name }}
                                        <span class="block text-[10px] text-slate-400 font-normal">{{ $order->recipient_phone }}</span>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 font-bold text-xs text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded">
                                            <i class="fa-solid fa-credit-card text-[10px]"></i>
                                            <span>{{ $order->payment_method }}</span>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-indigo-600">
                                        {{ $order->formatted_total }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $order->status_badge_class }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                            Detail &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Col 2: Low Stock Warning (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                    <h3 class="text-sm font-extrabold text-slate-900">Peringatan Stok Menipis</h3>
                </div>
                <a href="{{ route('admin.books.index') }}" class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800">Semua Buku</a>
            </div>

            @if($lowStockBooks->isEmpty())
                <div class="p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-2xl">
                    <i class="fa-solid fa-check-circle text-emerald-500 text-lg block mb-1"></i>
                    Semua stok buku dalam jumlah aman (> 5 eksemplar).
                </div>
            @else
                <div class="space-y-3">
                    @foreach($lowStockBooks as $lBook)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="min-w-0 pr-2">
                                <h4 class="font-bold text-slate-800 text-xs truncate">{{ $lBook->title }}</h4>
                                <span class="text-[10px] text-slate-400">{{ $lBook->author }}</span>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $lBook->stock == 0 ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                    Sisa {{ $lBook->stock }}
                                </span>
                                <a href="{{ route('admin.books.edit', $lBook->id) }}" class="block text-[10px] text-indigo-600 hover:text-indigo-800 font-bold mt-1">
                                    Tambah Stok
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
