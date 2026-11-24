<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Message;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@bookstore.com'],
            [
                'name' => 'Administrator Toko',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Gedung Sentra Pustaka Lt. 3, Jl. Thamrin No. 45, Jakarta Pusat',
            ]
        );

        $user1 = User::firstOrCreate(
            ['email' => 'user@bookstore.com'],
            [
                'name' => 'Rasya Aditya',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'phone' => '087808941784',
                'address' => 'Jl. Ancol selatan 2, sunter , Jakarta utara',
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'siti@bookstore.com'],
            [
                'name' => 'Siti Rahmawati',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'phone' => '081298765432',
                'address' => 'Jl. Flamboyan Blok B2 No. 5, Sleman, D.I. Yogyakarta',
            ]
        );

        // 2. Seed Categories
        $categoriesData = [
            [
                'name' => 'Pengembangan Diri',
                'slug' => 'pengembangan-diri',
                'description' => 'Buku-buku motivasi, pola pikir positif, kebiasaan produktif, dan manajemen diri.',
            ],
            [
                'name' => 'Fiksi & Sastra',
                'slug' => 'fiksi-dan-sastra',
                'description' => 'Novel lokal dan internasional, antologi cerita pendek, dan karya sastra abadi.',
            ],
            [
                'name' => 'Komputer & Teknologi',
                'slug' => 'komputer-dan-teknologi',
                'description' => 'Pemrograman, kecerdasan buatan, keamanan siber, dan infrastruktur IT.',
            ],
            [
                'name' => 'Bisnis & Keuangan',
                'slug' => 'bisnis-dan-keuangan',
                'description' => 'Strategi wirausaha, investasi, manajemen keuangan pribadi, dan ekonomi modern.',
            ],
            [
                'name' => 'Sains & Pengetahuan',
                'slug' => 'sains-dan-pengetahuan',
                'description' => 'Fakta ilmiah, eksplorasi semesta, biologi, dan pengetahuan umum populer.',
            ],
            [
                'name' => 'Komik & Grafis',
                'slug' => 'komik-dan-grafis',
                'description' => 'Novel grafis, komik edukasi, dan seri manga terfavorit.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::create($cat);
        }

        // 3. Seed Books
        $booksData = [
            [
                'category_id' => $categories['pengembangan-diri']->id,
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '978-602-06-3317-6',
                'price' => 108000,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80',
                'description' => 'Perubahan kecil yang memberikan hasil luar biasa. Buku panduan praktis dan terbukti untuk membentuk kebiasaan baik dan meruntuhkan kebiasaan buruk setiap hari.',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['pengembangan-diri']->id,
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'publisher' => 'Kompas Penerbit Buku',
                'isbn' => '978-602-412-518-9',
                'price' => 98000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80',
                'description' => 'Penerapan filsafat Stoa kuno untuk mental tangguh di era modern yang penuh kecemasan. Membantu mengendalikan hal-hal dalam kendali diri kita.',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['bisnis-dan-keuangan']->id,
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'publisher' => 'Baca Publishing',
                'isbn' => '978-602-6486-57-8',
                'price' => 85000,
                'stock' => 14,
                'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&w=600&q=80',
                'description' => 'Pelajaran abadi mengenai kekayaan, keserakahan, dan kebahagiaan finansial. Mengajarkan bagaimana perilaku manusia lebih menentukan kesuksesan finansial dibanding kepintaran.',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['fiksi-dan-sastra']->id,
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Lentera Dipantara',
                'isbn' => '978-979-97312-3-4',
                'price' => 135000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1495640388908-05fa85288e61?auto=format&fit=crop&w=600&q=80',
                'description' => 'Karya agung sastra Indonesia yang menceritakan perjuangan Minke, seorang pribumi cerdas di era Hindia Belanda, dalam melawan ketidakadilan kolonial.',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['komputer-dan-teknologi']->id,
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'publisher' => 'Prentice Hall',
                'isbn' => '978-013-235088-4',
                'price' => 175000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=600&q=80',
                'description' => 'Panduan fundamental bagi para developer untuk menulis kode yang bersih, mudah dibaca, dapat diuji, dan mudah dipelihara dalam jangka panjang.',
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['pengembangan-diri']->id,
                'title' => 'Bicara Itu Ada Seninya',
                'author' => 'Oh Su Hyang',
                'publisher' => 'Bhuana Ilmu Populer',
                'isbn' => '978-602-455-390-6',
                'price' => 79000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80',
                'description' => 'Rahasia komunikasi efektif dari pakar vokal dan komunikasi Korea Selatan agar ucapan Anda memikat hati dan memenangkan negosiasi.',
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['fiksi-dan-sastra']->id,
                'title' => 'Pulang',
                'author' => 'Leila S. Chudori',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'isbn' => '978-979-91-0515-8',
                'price' => 95000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1524578271613-d550eacf6090?auto=format&fit=crop&w=600&q=80',
                'description' => 'Novel dramatis berlatar eksil politik Indonesia pasca tragedi 1965 di Paris hingga reformasi 1998 di Jakarta.',
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['bisnis-dan-keuangan']->id,
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert T. Kiyosaki',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '978-602-03-3311-3',
                'price' => 88000,
                'stock' => 16,
                'image' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=600&q=80',
                'description' => 'Buku keuangan pribadi nomor satu sepanjang masa yang membongkar mitos bahwa Anda harus berpenghasilan tinggi untuk menjadi kaya.',
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['sains-dan-pengetahuan']->id,
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'KPG',
                'isbn' => '978-602-424-416-3',
                'price' => 125000,
                'stock' => 11,
                'image' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=600&q=80',
                'description' => 'Kisah luar biasa evolusi Homo sapiens dari kera tak signifikan di Afrika timur hingga menjadi penguasa tunggal planet Bumi.',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['komik-dan-grafis']->id,
                'title' => 'One Piece Volume 100',
                'author' => 'Eiichiro Oda',
                'publisher' => 'Elex Media Komputindo',
                'isbn' => '978-623-00-3051-2',
                'price' => 45000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1569317002804-ab77bcf1bce4?auto=format&fit=crop&w=600&q=80',
                'description' => 'Volume bersejarah petualangan Luffy dan kru Bajak Laut Topi Jerami di negeri Wano menghadapi Yonko Kaido.',
                'is_featured' => false,
            ],
        ];

        $createdBooks = [];
        foreach ($booksData as $bData) {
            $createdBooks[] = Book::create($bData);
        }

        // 4. Seed Sample Orders (untuk memastikan List Pesanan Admin langsung terisi bagus)
        // Order 1: Status Menunggu Konfirmasi (COD)
        $order1 = Order::create([
            'order_number' => 'ORD-' . date('Ymd') . '-0001',
            'user_id' => $user1->id,
            'recipient_name' => 'Budi Santoso',
            'recipient_phone' => '085712349876',
            'shipping_address' => 'Jl. Anggrek No. 18, Kebayoran Baru',
            'city' => 'Jakarta Selatan',
            'postal_code' => '12150',
            'notes' => 'Tolong telepon sebelum kurir sampai.',
            'subtotal' => 206000,
            'shipping_fee' => 15000,
            'total_price' => 221000,
            'payment_method' => 'Payment at Delivery (COD)',
            'payment_status' => 'Pending',
            'status' => 'Menunggu Konfirmasi',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'book_id' => $createdBooks[0]->id, // Atomic Habits
            'book_title' => $createdBooks[0]->title,
            'price' => $createdBooks[0]->price,
            'quantity' => 1,
            'subtotal' => $createdBooks[0]->price,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'book_id' => $createdBooks[1]->id, // Filosofi Teras
            'book_title' => $createdBooks[1]->title,
            'price' => $createdBooks[1]->price,
            'quantity' => 1,
            'subtotal' => $createdBooks[1]->price,
        ]);

        // Order 2: Status Sedang Dikirim (COD)
        $order2 = Order::create([
            'order_number' => 'ORD-' . date('Ymd') . '-0002',
            'user_id' => $user2->id,
            'recipient_name' => 'Siti Rahmawati',
            'recipient_phone' => '081298765432',
            'shipping_address' => 'Jl. Flamboyan Blok B2 No. 5, Sleman',
            'city' => 'Yogyakarta',
            'postal_code' => '55281',
            'notes' => 'Tolong bungkus dengan bubble wrap tebal.',
            'subtotal' => 125000,
            'shipping_fee' => 20000,
            'total_price' => 145000,
            'payment_method' => 'Payment at Delivery (COD)',
            'payment_status' => 'Pending',
            'status' => 'Dikirim',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'book_id' => $createdBooks[8]->id, // Sapiens
            'book_title' => $createdBooks[8]->title,
            'price' => $createdBooks[8]->price,
            'quantity' => 1,
            'subtotal' => $createdBooks[8]->price,
        ]);

        // Order 3: Status Selesai (COD)
        $order3 = Order::create([
            'order_number' => 'ORD-' . date('Ymd', strtotime('-2 days')) . '-0003',
            'user_id' => $user1->id,
            'recipient_name' => 'Budi Santoso',
            'recipient_phone' => '085712349876',
            'shipping_address' => 'Jl. Anggrek No. 18, Kebayoran Baru',
            'city' => 'Jakarta Selatan',
            'postal_code' => '12150',
            'notes' => null,
            'subtotal' => 85000,
            'shipping_fee' => 15000,
            'total_price' => 100000,
            'payment_method' => 'Payment at Delivery (COD)',
            'payment_status' => 'Lunas saat Pengiriman',
            'status' => 'Selesai',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'book_id' => $createdBooks[2]->id, // Psychology of Money
            'book_title' => $createdBooks[2]->title,
            'price' => $createdBooks[2]->price,
            'quantity' => 1,
            'subtotal' => $createdBooks[2]->price,
        ]);

        // 5. Seed Messages (Contact to Admin)
        Message::create([
            'user_id' => $user1->id,
            'name' => 'Budi Santoso',
            'email' => 'user@bookstore.com',
            'phone' => '085712349876',
            'subject' => 'Pertanyaan Ketersediaan Stok Buku',
            'message' => 'Halo Admin Pustaka, apakah novel Bumi Manusia edisi hard cover akan tersedia lagi bulan depan? Terima kasih.',
            'status' => 'unread',
        ]);

        Message::create([
            'user_id' => $user2->id,
            'name' => 'Siti Rahmawati',
            'email' => 'siti@bookstore.com',
            'phone' => '081298765432',
            'subject' => 'Konfirmasi Metode Payment at Delivery (COD)',
            'message' => 'Halo, apakah untuk COD di wilayah Sleman Yogyakarta kurir menerima pembayaran non-tunai via QRIS juga saat pengiriman? Terima kasih banyak.',
            'reply' => 'Halo Kak Siti! Iya betul, kurir kami dilengkapi QRIS dinamis dan juga menerima uang tunai saat pengiriman.',
            'status' => 'replied',
        ]);
    }
}
