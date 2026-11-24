@extends('layouts.admin')

@section('title', 'List Pesanan Buku')
@section('page_title', 'List Pesanan Buku dari Berbagai User')
@section('page_description', 'Pantau dan perbarui status pesanan buku pelanggan toko')

@section('content')
<div class="space-y-6">

    <!-- Status Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition {{ request('status', 'all') === 'all' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Semua Pesanan ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'Menunggu Konfirmasi'])) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition {{ request('status') === 'Menunggu Konfirmasi' ? 'bg-amber-500 text-white shadow-md shadow-amber-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Menunggu Konfirmasi ({{ $statusCounts['Menunggu Konfirmasi'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'Diproses'])) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition {{ request('status') === 'Diproses' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Diproses ({{ $statusCounts['Diproses'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'Dikirim'])) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition {{ request('status') === 'Dikirim' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Sedang Dikirim ({{ $statusCounts['Dikirim'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'Selesai'])) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition {{ request('status') === 'Selesai' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Selesai ({{ $statusCounts['Selesai'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'Dibatalkan'])) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition {{ request('status') === 'Dibatalkan' ? 'bg-rose-600 text-white shadow-md shadow-rose-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Dibatalkan ({{ $statusCounts['Dibatalkan'] }})
        </a>
    </div>

    <!-- Search Bar Form -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <div class="relative flex-grow max-w-lg">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari No. Pesanan (ORD-...), nama penerima, atau nomor HP..."
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs transition outline-none">
            </div>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition">
                Cari Pesanan
            </button>

            @if(request('search'))
                <a href="{{ route('admin.orders.index', ['status' => request('status', 'all')]) }}" class="text-xs font-bold text-rose-600 hover:text-rose-800 flex items-center gap-1">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Daftar Transaksi Pesanan ({{ $orders->total() }})</h3>
        </div>

        @if($orders->isEmpty())
            <div class="p-16 text-center space-y-3">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Tidak Ada Data Pesanan</h4>
                <p class="text-xs text-slate-400">Tidak ada pesanan buku yang sesuai dengan filter yang dipilih.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-6">No. Pesanan & Waktu</th>
                            <th class="py-3 px-6">Penerima & User</th>
                            <th class="py-3 px-6">Buku yang Dipesan</th>
                            <th class="py-3 px-6">Metode & Status Bayar</th>
                            <th class="py-3 px-6">Total Tagihan</th>
                            <th class="py-3 px-6">Status Pesanan</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($orders as $order)
                            <tr class="hover:bg-slate-50/60 transition group">
                                <!-- Order Number -->
                                <td class="py-4 px-6 font-extrabold text-slate-900 whitespace-nowrap">
                                    <span class="block text-indigo-600 group-hover:underline">{{ $order->order_number }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal block">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </td>

                                <!-- Customer Details -->
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-800 block text-sm">{{ $order->recipient_name }}</span>
                                    <span class="text-slate-500 text-[11px] block">{{ $order->recipient_phone }}</span>
                                    <span class="text-slate-400 text-[10px] block truncate max-w-xs">{{ $order->city }}</span>
                                </td>

                                <!-- Books Summary -->
                                <td class="py-4 px-6 max-w-xs">
                                    <div class="space-y-1">
                                        @foreach($order->items as $item)
                                            <div class="text-slate-700 truncate font-medium">
                                                &bull; {{ $item->book_title }} <span class="text-slate-400 text-[10px]">({{ $item->quantity }}x)</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Payment Method & Status -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 font-bold text-xs text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-md">
                                        <i class="fa-solid fa-credit-card text-[11px]"></i>
                                        <span>{{ $order->payment_method }}</span>
                                    </span>
                                    <span class="block text-[10px] font-semibold text-slate-400 mt-1">
                                        Status: <span class="{{ $order->payment_status === 'Dibayar' || $order->payment_status === 'Lunas saat Pengiriman' ? 'text-emerald-600 font-bold' : 'text-slate-600' }}">{{ $order->payment_status }}</span>
                                    </span>
                                </td>

                                <!-- Total Price -->
                                <td class="py-4 px-6 font-extrabold text-indigo-600 whitespace-nowrap text-sm">
                                    {{ $order->formatted_total }}
                                </td>

                                <!-- Status with Dropdown Form -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="text-xs font-bold px-3 py-1.5 rounded-full border outline-none cursor-pointer {{ $order->status_badge_class }}">
                                            <option value="Menunggu Konfirmasi" {{ $order->status === 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="Diproses" {{ $order->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="Dikirim" {{ $order->status === 'Dikirim' ? 'selected' : '' }}>Dikirim (Kurir)</option>
                                            <option value="Selesai" {{ $order->status === 'Selesai' ? 'selected' : '' }}>Selesai (Lunas)</option>
                                            <option value="Dibatalkan" {{ $order->status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Detail Action -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 font-bold px-3.5 py-1.5 rounded-xl transition">
                                        <i class="fa-solid fa-file-invoice text-xs"></i>
                                        <span>Faktur</span>
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
