@extends('layouts.admin')

@section('title', 'Edit Buku: ' . $book->title)
@section('page_title', 'Perbarui Data Buku')
@section('page_description', 'Ubah informasi judul, pengarang, harga, stok, atau cover buku')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.books.index') }}" class="text-xs font-bold text-slate-500 hover:text-indigo-600 transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Buku
        </a>
    </div>

    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-100 shadow-sm">
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Kategori & Judul -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Kategori Buku -->
                <div class="md:col-span-4">
                    <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Kategori Buku <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none bg-white">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Judul Buku -->
                <div class="md:col-span-8">
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Judul Buku <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none font-bold">
                </div>
            </div>

            <!-- 2. Penulis, Penerbit & ISBN -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Penulis -->
                <div>
                    <label for="author" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Nama Penulis / Pengarang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>

                <!-- Penerbit -->
                <div>
                    <label for="publisher" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Penerbit
                    </label>
                    <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>

                <!-- ISBN -->
                <div>
                    <label for="isbn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Nomor ISBN
                    </label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>
            </div>

            <!-- 3. Harga & Stok -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Harga Satuan -->
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Harga Buku (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center font-bold text-slate-400 text-sm">Rp</span>
                        <input type="number" name="price" id="price" value="{{ old('price', $book->price) }}" min="0" required
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none font-bold">
                    </div>
                </div>

                <!-- Jumlah Stok -->
                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Jumlah Stok Buku <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" min="0" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none font-bold">
                </div>
            </div>

            <!-- 4. Gambar Sampul Buku & Preview Saat Ini -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                <div class="flex items-start gap-4">
                    <!-- Current Image Preview -->
                    <div class="w-20 h-28 rounded-xl overflow-hidden bg-slate-200 shrink-0 border border-slate-200 shadow-sm">
                        <img src="{{ $book->image_url }}" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <div class="space-y-1">
                        <span class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                            Ganti Sampul Buku (Opsional)
                        </span>
                        <p class="text-xs text-slate-500">Biarkan kosong jika tidak ingin mengubah cover gambar saat ini.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <!-- Upload File Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Unggah File Baru</label>
                        <input type="file" name="image_file" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer border border-slate-200 rounded-xl bg-white p-1">
                    </div>

                    <!-- Input URL Gambar Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Atau Perbarui Tautan URL Gambar</label>
                        <input type="url" name="image_url" value="{{ old('image_url', str_starts_with($book->image ?? '', 'http') ? $book->image : '') }}"
                            placeholder="https://..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs transition outline-none bg-white">
                    </div>
                </div>
            </div>

            <!-- 5. Sinopsis / Deskripsi -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Sinopsis & Deskripsi Buku
                </label>
                <textarea name="description" id="description" rows="5"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">{{ old('description', $book->description) }}</textarea>
            </div>

            <!-- 6. Featured Toggle -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $book->is_featured) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="is_featured" class="text-xs font-semibold text-slate-700 cursor-pointer">
                    Jadikan Buku Unggulan (Tampilkan di Bagian Featured / Rekomendasi)
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.books.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition">
                    Batal
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-lg shadow-indigo-100 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Buku</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
