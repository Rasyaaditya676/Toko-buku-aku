<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ], [
            'category_id.required' => 'Kategori buku wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis/pengarang wajib diisi.',
            'price.required' => 'Harga buku wajib diisi.',
            'price.min' => 'Harga tidak boleh negatif.',
            'stock.required' => 'Jumlah stok buku wajib diisi.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'image_file.image' => 'File harus berupa gambar.',
            'image_file.max' => 'Ukuran file gambar maksimal 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('books', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        Book::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'isbn' => $request->isbn,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil ditambahkan ke katalog!');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ], [
            'category_id.required' => 'Kategori buku wajib dipilih.',
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis/pengarang wajib diisi.',
            'price.required' => 'Harga buku wajib diisi.',
            'stock.required' => 'Jumlah stok buku wajib diisi.',
        ]);

        $imagePath = $book->image;

        if ($request->hasFile('image_file')) {
            // Hapus gambar lama jika disimpan di storage lokal
            if ($book->image && !str_starts_with($book->image, 'http') && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
            $imagePath = $request->file('image_file')->store('books', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $book->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'isbn' => $request->isbn,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        // Hapus file gambar jika ada di storage
        if ($book->image && !str_starts_with($book->image, 'http') && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus dari katalog!');
    }
}
