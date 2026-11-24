<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // Landing Page & Katalog Buku (dengan Pencarian & Filter Kategori)
    public function landing(Request $request)
    {
        $categories = Category::withCount('books')->orderBy('name')->get();

        $query = Book::with('category')->latest();

        // 1. Fitur Pencarian Buku (Search by title, author, publisher)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 2. Filter Kategori
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // 3. Sorting (Urutan Harga & Terbaru)
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        }

        $books = $query->paginate(12)->withQueryString();

        // Featured Books untuk Banner / Highlight
        $featuredBooks = Book::where('is_featured', true)->take(4)->get();

        return view('landing', compact('books', 'categories', 'featuredBooks'));
    }

    // Detail Buku
    public function bookDetail(Book $book)
    {
        $book->load('category');
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('book-detail', compact('book', 'relatedBooks'));
    }

    // Halaman About Us (Sesuai Persyaratan Gambar: "Melihat detail halaman About Us")
    public function about()
    {
        return view('about');
    }

    // Halaman Kontak ke Admin (Sesuai Persyaratan Gambar: "Contact to Admin")
    public function contact()
    {
        $now = now('Asia/Jakarta');
        $currentTime = $now->format('H:i');
        // Jam operasional admin: 09:00 s/d 21:00 WIB
        $isOperatingHours = ($currentTime >= '09:00' && $currentTime < '21:00');

        return view('contact', compact('isOperatingHours', 'currentTime'));
    }

    // Kirim Pesan ke Admin (Contact to Admin Process)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:5|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek pesan wajib diisi.',
            'message.required' => 'Isi pesan wajib diisi.',
            'message.min' => 'Pesan terlalu singkat, minimal 5 karakter.',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        $now = now('Asia/Jakarta');
        $currentTime = $now->format('H:i');
        // Jam operasional admin: 09:00 s/d 21:00 WIB
        $isOperatingHours = ($currentTime >= '09:00' && $currentTime < '21:00');

        if ($isOperatingHours) {
            $responseMessage = "Terima kasih! Pesan Anda berhasil dikirim ke Administrator Toko. Admin kami sedang online dan akan segera merespons pesan Anda.";
        } else {
            $responseMessage = "Terima kasih! Pesan Anda telah kami terima (Pukul {$currentTime} WIB). Saat ini sedang di luar jam operasional admin (09.00 - 21.00 WIB). Admin kami akan segera menghubungi dan merespons Anda kembali pada jam kerja operasional.";
        }

        return back()->with('success', $responseMessage);
    }
}
