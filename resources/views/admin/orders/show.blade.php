@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number)
@section('page_title', 'Faktur & Pengelolaan Pesanan')
@section('page_description', 'Kelola pengiriman, verifikasi pembayaran online, dan status pesanan')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-slate-500 hover:text-indigo-600 transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
        <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs transition">
            <i class="fa-solid fa-print"></i> Cetak Bukti Transaksi
        </button>
    </div>

    <!-- Status Updater Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
                <span class="text-xs text-slate-400 block font-medium">Nomor Referensi Transaksi</span>
                <h2 class="text-2xl font-black text-slate-900">{{ $order->order_number }}</h2>
                <span class="text-xs text-slate-400">Dibuat pada {{ $order->created_at->translatedFormat('l, d F Y - H:i') }} WIB</span>
            </div>
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full font-extrabold text-xs border {{ $order->status_badge_class }}">
                    Status Saat Ini: {{ $order->status }}
                </span>
            </div>
        </div>

        <!-- Form Update Status & Pembayaran -->
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="bg-slate-50 p-6 rounded-2xl border border-slate-200/80 space-y-4">
            @csrf
            @method('PATCH')

            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Perbarui Status Pesanan & Pembayaran</h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Alur Pengiriman</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white outline-none focus:border-indigo-500">
                        <option value="Menunggu Konfirmasi" {{ $order->status === 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="Diproses" {{ $order->status === 'Diproses' ? 'selected' : '' }}>Diproses (Packing Gudang)</option>
                        <option value="Dikirim" {{ $order->status === 'Dikirim' ? 'selected' : '' }}>Dikirim (Sedang dalam Perjalanan Kurir)</option>
                        <option value="Selesai" {{ $order->status === 'Selesai' ? 'selected' : '' }}>Selesai (Barang Tiba & Pembayaran Diterima)</option>
                        <option value="Dibatalkan" {{ $order->status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pembayaran Tagihan</label>
                    <select name="payment_status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white outline-none focus:border-indigo-500">
                        <option value="Pending" {{ $order->payment_status === 'Pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran Online)</option>
                        <option value="Dibayar" {{ $order->payment_status === 'Dibayar' || $order->payment_status === 'Lunas saat Pengiriman' ? 'selected' : '' }}>Dibayar (Pembayaran Terverifikasi)</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-md shadow-indigo-100 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pembaruan Status
                </button>
            </div>
        </form>
    </div>

    <!-- Order Items & Shipping Details -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">

        <!-- Col 1: Ordered Items (8 cols) -->
        <div class="md:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-sm font-extrabold text-slate-900">Rincian Buku dalam Pesanan Ini</h3>
            </div>

            <div class="p-6 divide-y divide-slate-100 space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 pt-4 first:pt-0">
                        <div class="w-14 h-20 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100 shadow-sm">
                            <img src="{{ $item->book->image_url ?? 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=400&q=80' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow min-w-0 space-y-1">
                            <h4 class="font-bold text-slate-900 text-sm truncate">{{ $item->book_title }}</h4>
                            <p class="text-xs text-slate-400">Harga Satuan: {{ $item->formatted_price }}</p>
                            <p class="text-xs text-slate-500 font-medium">Banyaknya: <strong>{{ $item->quantity }} eksemplar</strong></p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-xs text-slate-400 block">Subtotal</span>
                            <span class="font-extrabold text-indigo-600 text-sm">{{ $item->formatted_subtotal }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-slate-50 p-6 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Subtotal Buku</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Ongkos Kirim Kurir</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
                </div>
                <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-sm">
                    <span class="font-black text-slate-900">Total Tagihan Pesanan</span>
                    <span class="font-black text-indigo-600 text-xl">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Col 2: Customer & Shipping Address (4 cols) -->
        <div class="md:col-span-4 space-y-6">
            <!-- Shipping Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-truck text-indigo-500"></i> Tujuan Pengiriman
                </h3>

                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="block text-slate-400">Nama Penerima:</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $order->recipient_name }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Nomor Telepon:</span>
                        <span class="font-semibold text-slate-800">{{ $order->recipient_phone }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Alamat Pengiriman Lengkap:</span>
                        <span class="font-medium text-slate-800 leading-relaxed block">{{ $order->shipping_address }}</span>
                        <span class="text-slate-500 font-medium">{{ $order->city }} {{ $order->postal_code }}</span>
                    </div>
                    @if($order->notes)
                        <div class="pt-2 border-t border-slate-50">
                            <span class="block text-slate-400">Catatan Khusus:</span>
                            <span class="italic text-slate-700 bg-slate-50 p-2 rounded-lg block">{{ $order->notes }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Method Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-amber-500"></i> Pembayaran
                </h3>

                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="block text-slate-400">Metode Pembayaran:</span>
                        <span class="font-bold text-slate-900">{{ $order->payment_method }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Status Pembayaran:</span>
                        <span class="font-bold {{ $order->payment_status === 'Lunas saat Pengiriman' || $order->payment_status === 'Dibayar' ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Akun Pemesan:</span>
                        <span class="font-semibold text-slate-700">{{ $order->user->name ?? 'Guest' }} ({{ $order->user->email ?? '-' }})</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
