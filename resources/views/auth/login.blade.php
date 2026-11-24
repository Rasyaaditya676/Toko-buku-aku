@extends('layouts.app')

@section('title', 'Masuk ke Akun - PustakaKita')

@section('content')
<div class="max-w-5xl mx-auto my-10 px-4 sm:px-6">
    <!-- Main Card Container: 2-Kolom Split Screen (HTML + Tailwind CSS Murni) -->
    <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200/70 border border-slate-100 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[580px]">

        <!-- KOLOM KIRI: Visual Branding & Keunggulan Toko (5 Kolom) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900 text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
            <!-- Dekorasi Efek Cahaya Lingkaran (CSS Murni) -->
            <div class="absolute -top-16 -left-16 w-48 h-48 rounded-full bg-indigo-500/20 blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -right-16 w-48 h-48 rounded-full bg-violet-500/20 blur-2xl pointer-events-none"></div>

            <!-- Bagian Atas: Identitas Toko -->
            <div class="relative z-10 space-y-4">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-2xl text-xs font-bold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>PustakaKita Bookstore</span>
                </div>

                <h2 class="text-2xl sm:text-3xl font-black leading-tight tracking-tight">
                    Jendela Literasi Terpercaya Indonesia
                </h2>
                
                <p class="text-xs sm:text-sm text-indigo-200 leading-relaxed font-light">
                    Masuk ke akun Anda untuk menikmati kemudahan berbelanja buku berkualitas, promo eksklusif, dan fasilitas <strong>Pembayaran Online Praktis</strong>.
                </p>
            </div>

            <!-- Bagian Tengah: 3 Poin Keunggulan Utama (List HTML) -->
            <div class="relative z-10 my-8 space-y-3">
                <div class="flex items-center gap-3.5 bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-sm">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">Pembayaran Online Praktis</span>
                        <span class="block text-[11px] text-indigo-200">Transfer Bank (BCA, Mandiri) &amp; QRIS E-Wallet</span>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-emerald-400 text-slate-950 flex items-center justify-center text-sm font-bold shrink-0 shadow-sm">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">100% Buku Asli (Original)</span>
                        <span class="block text-[11px] text-indigo-200">Garansi langsung dari penerbit resmi</span>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-sky-400 text-slate-950 flex items-center justify-center text-sm font-bold shrink-0 shadow-sm">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white">Pengiriman Cepat & Rapi</span>
                        <span class="block text-[11px] text-indigo-200">Kardus tebal & bubble wrap ganda</span>
                    </div>
                </div>
            </div>

            <!-- Bagian Bawah: Kutipan & Hak Cipta -->
            <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between text-[11px] text-indigo-300">
                <span>&copy; {{ date('Y') }} PustakaKita</span>
                <span class="flex items-center gap-1 font-semibold text-white">
                    <i class="fa-solid fa-lock text-[10px] text-emerald-400"></i> Sistem Aman
                </span>
            </div>
        </div>

        <!-- KOLOM KANAN: Formulir Login & Akun Demo (7 Kolom) -->
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-between space-y-6">
            
            <div class="space-y-6">
                <!-- Header Form -->
                <div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali!</h3>
                    <p class="text-xs text-slate-500 mt-1">Masukkan email dan kata sandi akun Anda untuk melanjutkan</p>
                </div>

                <!-- Kotak Bantuan 1-Klik Isi Akun Demo (Sangat Membantu Asesor Ujian) -->
                <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-2xl p-4 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-indigo-950 flex items-center gap-1.5">
                            <i class="fa-solid fa-wand-magic-sparkles text-indigo-600"></i> Akun Pengujian / Demo (1-Klik Isi)
                        </span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-800 font-bold px-2 py-0.5 rounded-full uppercase">Pilih Aktor</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <button type="button" onclick="fillLogin('admin@bookstore.com', 'admin123')" 
                            class="text-left bg-white hover:bg-indigo-50/80 border border-indigo-200 p-3 rounded-xl transition duration-200 shadow-sm hover:shadow group">
                            <div class="flex items-center gap-2 font-bold text-xs text-indigo-800 group-hover:text-indigo-950">
                                <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-[11px]">
                                    <i class="fa-solid fa-user-shield"></i>
                                </div>
                                <span>Aktor Admin</span>
                            </div>
                            <span class="block text-[11px] text-slate-400 mt-1 font-mono truncate">admin@bookstore.com</span>
                        </button>

                        <button type="button" onclick="fillLogin('user@bookstore.com', 'user123')" 
                            class="text-left bg-white hover:bg-emerald-50/80 border border-emerald-200 p-3 rounded-xl transition duration-200 shadow-sm hover:shadow group">
                            <div class="flex items-center gap-2 font-bold text-xs text-emerald-800 group-hover:text-emerald-950">
                                <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-[11px]">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span>Aktor User (Pembeli)</span>
                            </div>
                            <span class="block text-[11px] text-slate-400 mt-1 font-mono truncate">user@bookstore.com</span>
                        </button>
                    </div>
                </div>

                <!-- Formulir Login -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                placeholder="nama@email.com"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none bg-slate-50/40 focus:bg-white">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi (Password)</label>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none bg-slate-50/40 focus:bg-white">
                        </div>
                    </div>

                    <!-- Checkbox Ingat Saya -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600 select-none">
                            <input type="checkbox" name="remember" class="rounded text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                            <span>Ingat sesi masuk saya</span>
                        </label>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition duration-200 shadow-lg shadow-indigo-100 hover:shadow-indigo-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                        <span>Masuk ke Akun Sekarang</span>
                    </button>
                </form>
            </div>

            <!-- Link Pendaftaran Akun Baru -->
            <div class="text-center pt-4 border-t border-slate-100 text-xs text-slate-500">
                Belum memiliki akun pembeli? 
                <a href="{{ route('register') }}" class="font-extrabold text-indigo-600 hover:text-indigo-800 ml-1 transition">
                    Daftar User Baru di Sini &rarr;
                </a>
            </div>

        </div>

    </div>
</div>

<script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection
