<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'price' => 98000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=400&q=80',
                'description' => 'Buku pengantar stoisisme untuk mengatasi emosi negatif dan mental tangguh.'
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'price' => 108000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&w=400&q=80',
                'description' => 'Cara mudah & terbukti untuk membangun kebiasaan baik dan meninggalkan kebiasaan buruk.'
            ],
            [
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'price' => 85000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=400&q=80',
                'description' => 'Pelajaran abadi mengenai kekayaan, keserakahan, dan kebahagiaan.'
            ],
            [
                'title' => 'Bicara Itu Seni',
                'author' => 'Oh Su Hyang',
                'price' => 79000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=400&q=80',
                'description' => 'Rahasia komunikasi efektif agar disegani dan memenangkan hati lawan bicara.'
            ],
            [
                'title' => 'Sebuah Seni untuk Bersikap Bodo Amat',
                'author' => 'Mark Manson',
                'price' => 75000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=400&q=80',
                'description' => 'Pendekatan waras untuk menjalani hidup yang baik dengan fokus pada hal penting.'
            ],
            [
                'title' => 'Pulang',
                'author' => 'Leila S. Chudori',
                'price' => 95000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1524578271613-d550eacf6090?auto=format&fit=crop&w=400&q=80',
                'description' => 'Novel berlatar belakang sejarah dan keluarga yang menyentuh hati.'
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}