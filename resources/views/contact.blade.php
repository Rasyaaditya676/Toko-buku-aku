@extends('layouts.app')

@section('title', 'Hubungi Admin - PustakaKita Toko Buku')

@section('content')
<!-- Header Banner Section -->
<section class="bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900 text-white py-16 px-4 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-2xl mx-auto space-y-3 relative z-10">
        <span class="inline-flex items-center gap-1.5 bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase">
            <i class="fa-solid fa-headset text-amber-400"></i> Bantuan & Layanan Pelanggan
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            Hubungi <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-300">Admin Toko</span>
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm font-light leading-relaxed">
            Punya pertanyaan mengenai stok buku, konfirmasi pembayaran online, atau ingin memberikan masukan? Kirimkan pesan langsung kepada administrator kami.
        </p>
    </div>
</section>

<!-- Main Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Col 1: Contact Information (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-100 border border-slate-100 space-y-6">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Saluran Komunikasi Resmi</h3>
                    <p class="text-xs text-slate-400 mt-1">Kami siap merespons Anda pada jam kerja operasional.</p>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="flex items-start gap-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Email Dukungan Pelanggan</span>
                            <span class="font-bold text-slate-800 text-sm">support@pustakakita.id</span>
                            <span class="block text-slate-400 text-[11px] mt-0.5">Respons dalam 1 &times; 24 jam</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Layanan WhatsApp Cepat</span>
                            <span class="font-bold text-slate-800 text-sm">+62 812-3456-7890</span>
                            <span class="block text-slate-400 text-[11px] mt-0.5">Senin - Minggu: 09.00 - 20.00 WIB</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Alamat Kantor & Toko Utama</span>
                            <span class="font-bold text-slate-800 text-sm">Gedung Sentra Pustaka Lt. 3</span>
                            <span class="block text-slate-500 text-xs mt-0.5">Jl. MH Thamrin No. 45, Menteng, Jakarta Pusat 10350</span>
                        </div>
                    </div>
                </div>

                <!-- Operating hours note -->
                @if($isOperatingHours ?? false)
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-xs text-emerald-950 space-y-1.5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-bold flex items-center gap-1.5 text-emerald-800">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <i class="fa-solid fa-headset text-emerald-600"></i> Admin Sedang Online
                            </span>
                            <span class="bg-emerald-600 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">Aktif</span>
                        </div>
                        <p class="text-emerald-800 leading-relaxed text-[11px]">
                            Jam operasional: <strong>09.00 &ndash; 21.00 WIB</strong> (Waktu saat ini: <strong class="font-bold">{{ $currentTime ?? now('Asia/Jakarta')->format('H:i') }} WIB</strong>). Pesan Anda akan langsung direspons admin.
                        </p>
                    </div>
                @else
                    <div class="bg-amber-50 border border-amber-200/90 rounded-2xl p-4 text-xs text-amber-950 space-y-1.5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-bold flex items-center gap-1.5 text-amber-800">
                                <i class="fa-solid fa-moon text-amber-600"></i> Di Luar Jam Kerja Admin
                            </span>
                            <span class="bg-amber-500 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">Offline</span>
                        </div>
                        <p class="text-amber-800 leading-relaxed text-[11px]">
                            Jam operasional: <strong>09.00 &ndash; 21.00 WIB</strong> (Waktu saat ini: <strong class="font-bold">{{ $currentTime ?? now('Asia/Jakarta')->format('H:i') }} WIB</strong>). Pesan Anda tetap diterima dan admin akan menghubungi Anda kembali pada jam kerja.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Col 2: Message Form (7 cols) -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-100 border border-slate-100 space-y-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Formulir Kirim Pesan ke Admin</h2>
                    <p class="text-xs text-slate-400 mt-1">Silakan lengkapi formulir di bawah ini dengan pesan yang jelas.</p>
                </div>

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Pengirim -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" id="name" 
                                value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" required
                                placeholder="Nama Anda"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>

                        <!-- Email Pengirim -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                            <input type="email" name="email" id="email" 
                                value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" required
                                placeholder="email@domain.com"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Phone / WhatsApp -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. Telepon / WhatsApp (Opsional)</label>
                            <input type="text" name="phone" id="phone" 
                                value="{{ old('phone', Auth::check() ? Auth::user()->phone : '') }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>

                        <!-- Subjek Pesan -->
                        <div>
                            <label for="subject" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Topik / Subjek</label>
                            <input type="text" name="subject" id="subject" 
                                value="{{ old('subject') }}" required
                                placeholder="Contoh: Tanya Stok Novel / Konfirmasi Pembayaran"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                        </div>
                    </div>

                    <!-- Isi Pesan -->
                    <div>
                        <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Pesan Anda</label>
                        <textarea name="message" id="message" rows="5" required
                            placeholder="Tuliskan pertanyaan, keluhan, atau pesan Anda secara rinci di sini..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3.5 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-indigo-100 hover:shadow-indigo-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Kirim Pesan ke Admin Sekarang</span>
                    </button>

                    @if(!($isOperatingHours ?? false))
                        <p class="text-center text-[11px] text-amber-700 flex items-center justify-center gap-1.5 pt-1">
                            <i class="fa-solid fa-clock"></i>
                            <span>Catatan: Pesan yang dikirim di luar jam kerja (setelah pukul 21.00 WIB) akan dihubungi kembali pada jam operasional admin berikutnya.</span>
                        </p>
                    @endif
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
