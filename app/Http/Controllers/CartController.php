<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan Keranjang Belanja User
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->with('book.category')
            ->latest()
            ->get();

        $subtotal = $carts->sum(function ($cart) {
            return $cart->subtotal;
        });

        // Estimasi ongkos kirim standar flat Rp 15.000 jika ada barang, Rp 0 jika kosong
        $shippingFee = $carts->count() > 0 ? 15000 : 0;
        $totalPrice = $subtotal + $shippingFee;

        return view('cart.index', compact('carts', 'subtotal', 'shippingFee', 'totalPrice'));
    }

    // Tambah Buku ke Keranjang (Add to Cart Buku)
    public function add(Request $request, Book $book)
    {
        if ($book->stock < 1) {
            return back()->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        $quantity = $request->integer('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $quantity;
            if ($newQuantity > $book->stock) {
                return back()->with('error', "Stok tidak mencukupi. Anda sudah memiliki {$cart->quantity} di keranjang, dan sisa stok adalah {$book->stock}.");
            }
            $cart->update(['quantity' => $newQuantity]);
        } else {
            if ($quantity > $book->stock) {
                return back()->with('error', "Jumlah melebihi stok yang tersedia ({$book->stock} buku).");
            }

            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'quantity' => $quantity,
            ]);
        }

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('checkout.index')->with('success', 'Buku ditambahkan! Silakan lengkapi pesanan Anda.');
        }

        return back()->with('success', "'{$book->title}' berhasil dimasukkan ke keranjang belanja!");
    }

    // Update Jumlah Buku di Keranjang
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $book = $cart->book;
        if ($request->quantity > $book->stock) {
            return back()->with('error', "Jumlah tidak boleh melebihi sisa stok ({$book->stock} buku).");
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah buku di keranjang berhasil diperbarui!');
    }

    // Hapus Buku dari Keranjang
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $title = $cart->book ? $cart->book->title : 'Buku';
        $cart->delete();

        return back()->with('success', "'{$title}' telah dihapus dari keranjang belanja.");
    }

    // Kosongkan Keranjang
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Keranjang belanja Anda telah dikosongkan.');
    }
}
