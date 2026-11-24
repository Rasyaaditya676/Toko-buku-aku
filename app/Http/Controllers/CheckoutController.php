<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Halaman Form Checkout & Pembayaran
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('book')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong. Silakan pilih buku terlebih dahulu.');
        }

        // Periksa apakah ada buku yang stoknya kurang dari quantity
        foreach ($carts as $cart) {
            if (!$cart->book || $cart->book->stock < $cart->quantity) {
                return redirect()->route('cart.index')->with('error', "Stok untuk buku '{$cart->book->title}' tidak mencukupi. Silakan sesuaikan jumlah pesanan.");
            }
        }

        $subtotal = $carts->sum(function ($cart) {
            return $cart->subtotal;
        });

        $shippingFee = 15000; // Flat ongkir
        $totalPrice = $subtotal + $shippingFee;

        return view('checkout.index', compact('user', 'carts', 'subtotal', 'shippingFee', 'totalPrice'));
    }

    // Proses Simpan Pesanan (Checkout Process)
    public function process(Request $request)
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('book')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:Transfer Bank (BCA),Transfer Bank (Mandiri),QRIS / E-Wallet',
        ], [
            'recipient_name.required' => 'Nama penerima paket wajib diisi.',
            'recipient_phone.required' => 'Nomor WhatsApp / telepon penerima wajib diisi.',
            'shipping_address.required' => 'Alamat pengiriman lengkap wajib diisi.',
            'city.required' => 'Kota / Kabupaten wajib diisi.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        return DB::transaction(function () use ($request, $user, $carts) {
            $subtotal = 0;

            // Validasi ulang stok sebelum transaksi
            foreach ($carts as $cart) {
                if ($cart->book->stock < $cart->quantity) {
                    throw new \Exception("Stok buku '{$cart->book->title}' tidak mencukupi.");
                }
                $subtotal += $cart->subtotal;
            }

            $shippingFee = 15000;
            $totalPrice = $subtotal + $shippingFee;

            // Generate Order Number unik: ORD-YYYYMMDD-XXXX
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            // Buat Data Pesanan Baru
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'notes' => $request->notes,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Pending',
                'status' => 'Menunggu Konfirmasi',
            ]);

            // Simpan setiap item pesanan & kurangi stok buku
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $cart->book_id,
                    'book_title' => $cart->book->title,
                    'price' => $cart->book->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->subtotal,
                ]);

                // Kurangi stok buku secara otomatis
                $cart->book->decrement('stock', $cart->quantity);
            }

            // Kosongkan keranjang user setelah berhasil checkout
            Cart::where('user_id', $user->id)->delete();

            // Update info kontak default user jika sebelumnya belum ada
            if (empty($user->phone)) {
                $user->update(['phone' => $request->recipient_phone]);
            }
            if (empty($user->address)) {
                $user->update(['address' => $request->shipping_address . ', ' . $request->city]);
            }

            return redirect()->route('user.order.detail', $order->id)
                ->with('success', "Pesanan {$order->order_number} berhasil dibuat! Kami akan segera memproses buku pesanan Anda.");
        });
    }

    // Dashboard User (Menampilkan profil, riwayat pesanan, dan status pelacakan)
    public function userDashboard()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('items.book')
            ->latest()
            ->paginate(10);

        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->sum('total_price');

        $activeOrdersCount = Order::where('user_id', $user->id)
            ->whereIn('status', ['Menunggu Konfirmasi', 'Diproses', 'Dikirim'])
            ->count();

        $completedOrdersCount = Order::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->count();

        return view('user.dashboard', compact('user', 'orders', 'totalSpent', 'activeOrdersCount', 'completedOrdersCount'));
    }

    // Halaman Detail / Faktur Pesanan untuk User
    public function orderDetail(Order $order)
    {
        // Pastikan hanya pemilik pesanan atau admin yang bisa melihat
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load(['user', 'items.book']);

        return view('user.order-detail', compact('order'));
    }
}
