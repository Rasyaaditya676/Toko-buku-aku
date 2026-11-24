<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'Selesai')->sum('total_price');
        $pendingOrders = Order::where('status', 'Menunggu Konfirmasi')->count();
        $shippingOrders = Order::where('status', 'Dikirim')->count();
        $unreadMessages = Message::where('status', 'unread')->count();

        // 5 Pesanan Terbaru
        $recentOrders = Order::with(['user', 'items.book'])->latest()->take(5)->get();

        // 5 Buku Terpopuler / Stok Menipis
        $lowStockBooks = Book::where('stock', '<=', 5)->orderBy('stock')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalCategories',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'shippingOrders',
            'unreadMessages',
            'recentOrders',
            'lowStockBooks'
        ));
    }

    // List User yang Sudah Terdaftar (Sesuai Persyaratan Gambar)
    public function users(Request $request)
    {
        $query = User::withCount('orders')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // List Pesanan Buku dari User yang Berbeda-beda (Sesuai Persyaratan Gambar)
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items.book'])->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('recipient_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        // Status counts for tabs
        $statusCounts = [
            'all' => Order::count(),
            'Menunggu Konfirmasi' => Order::where('status', 'Menunggu Konfirmasi')->count(),
            'Diproses' => Order::where('status', 'Diproses')->count(),
            'Dikirim' => Order::where('status', 'Dikirim')->count(),
            'Selesai' => Order::where('status', 'Selesai')->count(),
            'Dibatalkan' => Order::where('status', 'Dibatalkan')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    // Detail Pesanan
    public function orderDetail(Order $order)
    {
        $order->load(['user', 'items.book']);
        return view('admin.orders.show', compact('order'));
    }

    // Update Status Pesanan & Pembayaran
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Konfirmasi,Diproses,Dikirim,Selesai,Dibatalkan',
            'payment_status' => 'nullable|string',
        ]);

        $updateData = ['status' => $request->status];

        // Jika pesanan selesai, tandai pembayaran telah diterima/dibayar
        if ($request->status === 'Selesai') {
            $updateData['payment_status'] = 'Dibayar';
        } elseif ($request->filled('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }

        // Jika dibatalkan, kembalikan stok buku
        if ($request->status === 'Dibatalkan' && $order->status !== 'Dibatalkan') {
            foreach ($order->items as $item) {
                if ($item->book) {
                    $item->book->increment('stock', $item->quantity);
                }
            }
        }

        $order->update($updateData);

        return back()->with('success', "Status pesanan {$order->order_number} berhasil diperbarui menjadi '{$request->status}'!");
    }

    // List Pesan Kontak dari User (Contact to Admin)
    public function messages(Request $request)
    {
        $query = Message::with('user')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $messages = $query->paginate(10)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    // Update / Balas Pesan dari User
    public function replyMessage(Request $request, Message $message)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update([
            'reply' => $request->reply,
            'status' => 'replied',
        ]);

        return back()->with('success', 'Balasan berhasil disimpan!');
    }

    // Tandai Pesan Telah Dibaca
    public function markMessageRead(Message $message)
    {
        $message->update(['status' => 'read']);
        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }
}
