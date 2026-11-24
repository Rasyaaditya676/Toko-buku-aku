@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number . ' - PustakaKita')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <nav class="flex items-center gap-2 text-xs text-slate-400">
            <a href="{{ route('user.dashboard') }}" class="hover:text-indigo-600 transition flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <i class="fa-solid fa-angle-right text-[10px]"></i>
            <span class="text-slate-700 font-bold">Faktur Pesanan {{ $order->order_number }}</span>
        </nav>

        <button type="button" onclick="window.print()" class="hidden sm:inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs transition">
            <i class="fa-solid fa-print"></i> Cetak Bukti Pesanan
        </button>
    </div>

    <!-- Order Status Tracker Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
                <span class="text-xs text-slate-400 block font-medium">Nomor Referensi Pesanan</span>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900">{{ $order->order_number }}</h1>
                <p class="text-xs text-slate-400 mt-0.5">Dipesan pada {{ $order->created_at->translatedFormat('l, d F Y - H:i') }} WIB</p>
            </div>
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full font-extrabold text-xs border {{ $order->status_badge_class }}">
                    Status: {{ $order->status }}
                </span>
            </div>
        </div>

        <!-- 4-Step Tracker Visual -->
        @php
            $steps = ['Menunggu Konfirmasi', 'Diproses', 'Dikirim', 'Selesai'];
            $currentIndex = array_search($order->status, $steps);
            if ($order->status === 'Dibatalkan') {
                $currentIndex = -1;
            }
        @endphp

        @if($order->status === 'Dibatalkan')
            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 text-xs text-rose-800 flex items-center gap-3">
                <i class="fa-solid fa-circle-xmark text-rose-600 text-lg"></i>
                <div>
                    <span class="font-bold block">Pesanan Ini Telah Dibatalkan</span>
                    <span>Buku telah dikembalikan ke stok katalog. Jika membutuhkan bantuan, silakan hubungi admin.</span>
                </div>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-2">
                @foreach($steps as $idx => $step)
                    @php
                        $isPassed = $currentIndex !== false && $currentIndex >= $idx;
                        $isCurrent = $currentIndex !== false && $currentIndex === $idx;
                    @endphp
                    <div class="flex items-center gap-3 p-3.5 rounded-2xl border transition {{ $isCurrent ? 'bg-indigo-50/80 border-indigo-300 ring-2 ring-indigo-200' : ($isPassed ? 'bg-slate-50 border-slate-200' : 'bg-slate-50/40 border-slate-100 opacity-60') }}">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 {{ $isPassed ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-200 text-slate-500' }}">
                            @if($isPassed && !$isCurrent)
                                <i class="fa-solid fa-check"></i>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[11px] font-extrabold text-slate-800 truncate">{{ $step }}</span>
                            <span class="block text-[10px] text-slate-400">
                                @if($isCurrent) Sedang Berjalan @elseif($isPassed) Selesai @else Menunggu @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">

        <!-- Col 1: Ordered Items (8 cols) -->
        <div class="md:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-sm font-extrabold text-slate-900">Rincian Buku yang Dipesan</h3>
            </div>

            <div class="divide-y divide-slate-100 p-6 space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 pt-4 first:pt-0">
                        <div class="w-14 h-20 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100 shadow-sm">
                            <img src="{{ $item->book->image_url ?? 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=400&q=80' }}" alt="{{ $item->book_title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow min-w-0 space-y-1">
                            <h4 class="font-bold text-slate-900 text-sm truncate">{{ $item->book_title }}</h4>
                            <p class="text-xs text-slate-400">Harga Satuan: {{ $item->formatted_price }}</p>
                            <p class="text-xs text-slate-500 font-medium">Jumlah: <strong>{{ $item->quantity }} eksemplar</strong></p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-xs text-slate-400 block">Subtotal</span>
                            <span class="font-extrabold text-indigo-600 text-sm">{{ $item->formatted_subtotal }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Price Breakdown Summary -->
            <div class="bg-slate-50 p-6 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Subtotal Produk</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Biaya Pengiriman (Ongkir)</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
                </div>
                <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-sm">
                    <span class="font-black text-slate-900">Total Pembayaran</span>
                    <span class="font-black text-indigo-600 text-xl">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Col 2: Shipping & Payment Info (4 cols) -->
        <div class="md:col-span-4 space-y-6">

            <!-- Shipping Info Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-indigo-500"></i> Informasi Pengiriman
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
                        <span class="block text-slate-400">Alamat Lengkap:</span>
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

            <!-- Payment Info Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-amber-500"></i> Informasi Pembayaran
                </h3>

                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="block text-slate-400">Metode yang Dipilih:</span>
                        <span class="font-black text-slate-900">{{ $order->payment_method }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Status Pembayaran:</span>
                        <span class="font-bold {{ $order->payment_status === 'Lunas saat Pengiriman' || $order->payment_status === 'Dibayar' ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>

                    @if(str_contains($order->payment_method, 'BCA'))
                        <div class="bg-indigo-50 border border-indigo-200/80 rounded-2xl p-3 text-[11px] text-indigo-950 space-y-1">
                            <span class="font-bold block text-indigo-900"><i class="fa-solid fa-building-columns"></i> Instruksi Transfer BCA</span>
                            <p class="leading-relaxed">
                                Transfer <strong>{{ $order->formatted_total }}</strong> ke Rekening BCA: <strong class="text-indigo-600">882-019-4821</strong> a/n PT PustakaKita Indonesia.
                            </p>
                        </div>
                    @elseif(str_contains($order->payment_method, 'Mandiri'))
                        <div class="bg-indigo-50 border border-indigo-200/80 rounded-2xl p-3 text-[11px] text-indigo-950 space-y-1">
                            <span class="font-bold block text-indigo-900"><i class="fa-solid fa-credit-card"></i> Instruksi Transfer Mandiri</span>
                            <p class="leading-relaxed">
                                Transfer <strong>{{ $order->formatted_total }}</strong> ke Rekening Mandiri: <strong class="text-indigo-600">137-00-9821-4455</strong> a/n PustakaKita Store.
                            </p>
                        </div>
                    @elseif(str_contains($order->payment_method, 'QRIS'))
                        <div class="bg-indigo-50 border border-indigo-200/80 rounded-2xl p-3 text-[11px] text-indigo-950 space-y-1">
                            <span class="font-bold block text-indigo-900"><i class="fa-solid fa-qrcode"></i> Instruksi QRIS / E-Wallet</span>
                            <p class="leading-relaxed">
                                Silakan scan kode QRIS melalui aplikasi e-wallet (GoPay, OVO, ShopeePay, DANA) sebesar <strong>{{ $order->formatted_total }}</strong>.
                            </p>
                        </div>
                    @else
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3 text-[11px] text-slate-700 space-y-1">
                            <span class="font-bold block text-slate-900"><i class="fa-solid fa-circle-info"></i> Pembayaran Online</span>
                            <p class="leading-relaxed">
                                Silakan selesaikan pembayaran sebesar <strong>{{ $order->formatted_total }}</strong> sesuai metode yang dipilih.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Support Button -->
            <a href="{{ route('contact') }}" class="w-full py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-xs transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-headset"></i>
                <span>Tanya Admin Mengenai Pesanan Ini</span>
            </a>

        </div>

    </div>

</div>
@endsection
