@extends('layouts.app')

@section('title', 'Tentang Kami - PustakaKita Toko Buku')

@section('content')
<!-- Header Banner Section -->
<section class="bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900 text-white py-20 px-4 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-3xl mx-auto space-y-4 relative z-10">
        <span class="inline-flex items-center gap-1.5 bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase">
            <i class="fa-solid fa-book-bookmark text-amber-400"></i> Profil Toko Buku
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight">
            Tentang <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-300">PustakaKita</span>
        </h1>
        <p class="text-slate-300 text-sm sm:text-base font-light leading-relaxed">
            Mendedikasikan diri untuk menyalakan lentera literasi, menghadirkan buku-buku bermutu dan original langsung ke tangan para pembaca di seluruh penjuru nusantara.
        </p>
    </div>
</section>

<!-- Content Overview -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20 pb-20 space-y-16">

    <!-- Story Card & Interactive Visual Showcase -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 grid grid-cols-1 md:grid-cols-12 gap-10 items-center">
        <!-- Kolom Cerita & Visi (6 cols) -->
        <div class="md:col-span-6 space-y-5">
            <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-xs font-extrabold uppercase tracking-wider">
                <i class="fa-solid fa-feather-pointed"></i> Cerita Perjalanan Kami
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                Membangun Ekosistem Baca yang Mudah, Nyaman, dan Terpercaya
            </h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                Didirikan dengan kecintaan mendalam terhadap dunia literasi, <strong>PustakaKita</strong> berawal dari sebuah toko buku kecil di jantung ibu kota. Kini, melalui platform online modern kami, pembaca dari Sabang sampai Merauke dapat dengan mudah memesan buku-buku idaman mereka.
            </p>
            <p class="text-sm text-slate-600 leading-relaxed">
                Kami memahami bahwa kenyamanan dan keamanan bertransaksi adalah prioritas utama pelanggan. Itulah mengapa kami menyediakan sistem <strong>Pembayaran Online Cepat &amp; Terverifikasi</strong> melalui Transfer Bank dan QRIS untuk kemudahan proses transaksi Anda.
            </p>

            <!-- Quick Badges -->
            <div class="pt-2 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-3 py-1.5 rounded-xl">
                    <i class="fa-solid fa-check-circle"></i> 100% Produk Original
                </span>
                <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-bold px-3 py-1.5 rounded-xl">
                    <i class="fa-solid fa-credit-card"></i> Pembayaran Online Praktis
                </span>
                <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-bold px-3 py-1.5 rounded-xl">
                    <i class="fa-solid fa-truck-fast"></i> Pengiriman Seluruh Indonesia
                </span>
            </div>
        </div>

        <!-- Kolom Visual Showcase Interaktif (6 cols) -->
        <div class="md:col-span-6">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white min-h-[380px] p-6 sm:p-8 flex flex-col justify-between group">
                
                <!-- Background Image dengan Overlay Elegan -->
                <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=800&q=80" 
                    alt="Interior Toko Buku PustakaKita" 
                    onerror="this.style.display='none'"
                    class="absolute inset-0 w-full h-full object-cover opacity-35 mix-blend-overlay group-hover:scale-105 transition-transform duration-700 pointer-events-none">

                <!-- Header Showcase -->
                <div class="relative z-10 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-2xl">
                        <div class="w-6 h-6 rounded-lg bg-indigo-500 text-white flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <span class="text-xs font-bold text-white tracking-wide">PustakaKita Official Store</span>
                    </div>

                    <span class="bg-emerald-500/90 backdrop-blur-md text-white text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider flex items-center gap-1 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Terverifikasi
                    </span>
                </div>

                <!-- Showcase Center Quote & Highlights -->
                <div class="relative z-10 space-y-3 my-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center text-white text-xl shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <blockquote class="text-base sm:text-lg font-bold leading-snug text-slate-100">
                        "Buku adalah jendela dunia. Melalui PustakaKita, setiap lembaran inspirasi dapat Anda genggam dengan mudah dan aman."
                    </blockquote>
                    <p class="text-xs text-indigo-300 font-medium">&mdash; Tim Kurasi Buku PustakaKita</p>
                </div>

                <!-- Floating Stats Bar (3 Metric Counters) -->
                <div class="relative z-10 grid grid-cols-3 gap-2.5 pt-4 border-t border-white/10 text-center">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 border border-white/10">
                        <span class="block text-base sm:text-xl font-black text-amber-400">10.000+</span>
                        <span class="block text-[10px] text-slate-300 uppercase tracking-wider font-semibold">Buku Terjual</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 border border-white/10">
                        <span class="block text-base sm:text-xl font-black text-emerald-400">99.8%</span>
                        <span class="block text-[10px] text-slate-300 uppercase tracking-wider font-semibold">Puas Belanja</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-2.5 border border-white/10">
                        <span class="block text-base sm:text-xl font-black text-sky-400">50+ Kota</span>
                        <span class="block text-[10px] text-slate-300 uppercase tracking-wider font-semibold">Jangkauan</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Alur Mudah Belanja dengan Pembayaran Online -->
    <div class="bg-gradient-to-br from-indigo-50 via-white to-indigo-50/40 rounded-3xl p-8 sm:p-12 border border-indigo-100 shadow-sm space-y-8">
        <div class="text-center space-y-2 max-w-2xl mx-auto">
            <span class="text-xs font-black text-indigo-600 uppercase tracking-widest bg-indigo-100/80 px-3 py-1 rounded-full">
                Kemudahan Layanan Pelanggan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                Cara Kerja Belanja &amp; Pembayaran Online
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Empat langkah mudah membeli buku impian Anda dengan transaksi online yang aman dan terpercaya.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-indigo-200">
                    1
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Pilih Buku di Katalog</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Cari dan pilih buku favorit Anda dari berbagai kategori yang tersedia, lalu masukkan ke keranjang belanja.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-indigo-200">
                    2
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Isi Alamat Pengiriman</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Tentukan alamat lengkap penerima dan nomor WhatsApp yang aktif untuk mempermudah kurir saat pengantaran.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-indigo-200">
                    3
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Pilih Metode Online</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Pilih opsi <strong>Transfer Bank (BCA, Mandiri)</strong> atau <strong>QRIS</strong> untuk pembayaran yang instan dan aman.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-emerald-200">
                    4
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Buku Dikemas &amp; Dikirim</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Setelah pembayaran terverifikasi, tim kami segera mengemas paket buku dengan aman dan mengirimkannya ke alamat Anda.
                </p>
            </div>
        </div>
    </div>

    <!-- Visi & Misi Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold shadow-inner">
                <i class="fa-solid fa-eye"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900">Visi Kami</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                Menjadi platform toko buku digital paling terpercaya dan inovatif di Indonesia yang mampu menginspirasi generasi muda melalui akses bahan bacaan bermutu tinggi, terjangkau, dan mudah diakses siapa saja.
            </p>
        </div>

        <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shadow-inner">
                <i class="fa-solid fa-bullseye"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900">Misi Kami</h3>
            <ul class="space-y-2 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span>Menjamin keaslian (100% original) setiap eksemplar buku langsung dari penerbit terakreditasi.</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span>Memberikan kenyamanan berbelanja dengan opsi pembayaran online yang fleksibel &amp; aman.</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span>Menyediakan pengemasan ekstra aman (bubble wrap ganda) bebas biaya tambahan.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- 4 Keunggulan Toko Buku -->
    <div class="space-y-8">
        <div class="text-center space-y-2 max-w-xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Mengapa Memilih PustakaKita?</h2>
            <p class="text-xs sm:text-sm text-slate-400">Komitmen kami demi kepuasan dan ketenangan berbelanja Anda</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">100% Produk Asli</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Kami menentang pembajakan buku. Semua buku bersumber langsung dari penerbit resmi Indonesia maupun internasional.
                </p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Pembayaran Online Cepat</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Mendukung transaksi instan Transfer Bank (BCA, Mandiri) dan QRIS terverifikasi tanpa ribet.
                </p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-box-check"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Pengemasan Aman</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Setiap paket dilapisi kardus tebal dan bubble wrap premium agar buku tidak tertekuk atau rusak saat transit.
                </p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Layanan Ramah</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Admin kami siap membantu konsultasi rekomendasi buku atau melacak status pengiriman Anda kapan saja.
                </p>
            </div>
        </div>
    </div>

    <!-- Store Location & Operating Hours Card -->
    <div class="bg-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="space-y-4">
            <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Kunjungi Toko Fisik Kami</span>
            <h3 class="text-2xl font-extrabold">Gerai PustakaKita Sentra Buku</h3>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Selain berbelanja online, Anda juga dipersilakan untuk berkunjung langsung ke galeri membaca kami untuk menikmati suasana toko buku yang tenang dan nyaman didampingi kopi hangat.
            </p>
            <div class="space-y-2 pt-2 text-xs text-slate-300">
                <p><i class="fa-solid fa-location-dot text-indigo-400 mr-2"></i> Gedung Sentra Pustaka Lt. 3, Jl. MH Thamrin No. 45, Menteng, Jakarta Pusat 10350</p>
                <p><i class="fa-solid fa-clock text-indigo-400 mr-2"></i> Jam Buka: Senin &ndash; Minggu (09.00 &ndash; 21.00 WIB)</p>
                <p><i class="fa-solid fa-phone text-indigo-400 mr-2"></i> Telepon: (021) 555-0192 | WhatsApp: 0812-3456-7890</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('landing') }}" class="w-full sm:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3.5 rounded-2xl text-xs transition shadow-lg shadow-indigo-600/30">
                <i class="fa-solid fa-book-open mr-2"></i> Mulai Belanja Sekarang
            </a>
            <a href="{{ route('contact') }}" class="w-full sm:w-auto text-center bg-slate-800 hover:bg-slate-700 text-white font-bold px-6 py-3.5 rounded-2xl text-xs transition border border-slate-700">
                <i class="fa-solid fa-envelope mr-2"></i> Hubungi Admin
            </a>
        </div>
    </div>

</section>
@endsection
