<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ================= AKUN DEMO =================
        $admin = User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'admin@perpus.sekolah.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $siswaUser = User::create([
            'name' => 'Ayu Lestari',
            'email' => 'siswa@perpus.sekolah.id',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        Member::create([
            'user_id' => $siswaUser->id,
            'member_code' => 'SIS-000001',
            'name' => 'Ayu Lestari',
            'class' => 'XI IPA 2',
            'phone' => '081234567890',
            'address' => 'Jl. Pendidikan No. 1',
            'status' => 'aktif',
        ]);

        // ================= KATEGORI =================
        $categories = [
            ['name' => 'Komik', 'slug' => 'komik'],
            ['name' => 'Novel', 'slug' => 'novel'],
            ['name' => 'Sains', 'slug' => 'sains'],
            ['name' => 'Sejarah', 'slug' => 'sejarah'],
            ['name' => 'Kamus', 'slug' => 'kamus'],
            ['name' => 'Pelajaran', 'slug' => 'pelajaran'],
        ];
        foreach ($categories as $c) {
            Category::create($c);
        }

        // ================= DATA BUKU =================
        $booksByCategory = [

            'komik' => [
                ['title' => 'Komik Dari Twit-nya Raditya Dika', 'author' => 'Raditya Dika', 'publisher' => null, 'year' => null, 'stock' => 3, 'description' => 'Kumpulan komik strip hasil adaptasi cuitan jenaka Raditya Dika, dikemas ringan dan kocak.'],
                ['title' => 'Love Deadline!', 'author' => 'Aisah PL', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Komik romansa remaja tentang perjuangan mengejar tenggat waktu sambil berurusan dengan cinta.'],
                ['title' => 'Ngopi Yuk di Warkop Pak Gundul!', 'author' => null, 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Komik strip kehidupan sehari-hari yang penuh humor khas warung kopi.'],
                ['title' => 'Sekar Populer', 'author' => null, 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Komik bertema kehidupan remaja populer di sekolah, ringan dan menghibur.'],
                ['title' => 'Dulu Gwe(n) Pernah', 'author' => null, 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Komik kisah masa lalu yang dikemas dengan gaya bercerita santai dan relatable.'],
                ['title' => 'Terlalu Tampan, Masih Diary Orang Ganteng', 'author' => null, 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Komik diary jenaka seputar suka-duka menjadi "orang ganteng" sehari-hari.'],
            ],

            'novel' => [
                ['title' => 'Crying Doesn\'t Change a Thing', 'author' => 'Park Joon', 'publisher' => null, 'year' => null, 'stock' => 3, 'description' => 'Novel bertema penyembuhan diri dan pengelolaan emosi, populer di kalangan pembaca muda.'],
                ['title' => 'Tentang Kami', 'author' => 'Tere Liye', 'publisher' => null, 'year' => null, 'stock' => 4, 'description' => 'Novel karya Tere Liye yang mengangkat tema keluarga, persahabatan, dan kehidupan.'],
                ['title' => 'Love & Gelato', 'author' => 'Jenna Evans Welch', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Novel remaja berlatar Italia tentang pencarian jati diri dan cinta pertama.'],
                ['title' => 'Alletta', 'author' => 'Galih Aditya', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Novel drama romansa karya penulis lokal dengan alur yang emosional.'],
                ['title' => 'Ruang Tunggu', 'author' => 'Seruni Puti', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Novel bertema penantian dan proses menerima keadaan, ditulis dengan gaya reflektif.'],
                ['title' => 'Klara and the Sun (Klara dan Sang Matahari)', 'author' => 'Kazuo Ishiguro', 'publisher' => null, 'year' => null, 'stock' => 3, 'description' => 'Novel karya pemenang Nobel Sastra tentang AI pendamping bernama Klara dan makna cinta dari sudut pandangnya.'],
                ['title' => '5 cm', 'author' => 'Donny Dhirgantoro', 'publisher' => null, 'year' => null, 'stock' => 5, 'description' => 'Novel Indonesia legendaris tentang persahabatan, mimpi, dan pendakian Mahameru - "Aku, Kamu, Samudera, dan Bintang-Bintang".'],
                ['title' => 'Fana Kecuali Luka: Tak Ada Lagi yang Tersisa Setelah Usainya Kita', 'author' => 'Rina Yunita', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Novel bertema kehilangan dan proses merelakan, dengan narasi yang puitis.'],
                ['title' => 'Loveless', 'author' => 'Ririn Ayu', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Novel romansa remaja dengan konflik seputar makna cinta sejati.'],
                ['title' => 'Wonderful Bangkok: Enjoy a Place of Happiness', 'author' => 'Kinoysan', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Novel ringan berlatar Bangkok yang mengisahkan perjalanan menemukan kebahagiaan.'],
                ['title' => 'Di Penghujung Pelukan', 'author' => 'Lilit Senjani & Momo DM', 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Novel drama romansa karya kolaborasi dua penulis, mengangkat tema perpisahan dan penerimaan.'],
            ],

            'sains' => [
                ['title' => 'Pemecah Rekor Bumi dan Alam Semesta', 'author' => 'Strom Dunlap', 'publisher' => null, 'year' => null, 'stock' => 3, 'description' => 'Buku pengetahuan populer berisi fakta dan rekor-rekor menakjubkan seputar bumi dan alam semesta.'],
                ['title' => 'Astronomi', 'author' => null, 'publisher' => 'Balai Pustaka, Jakarta', 'year' => null, 'stock' => 3, 'description' => 'Buku pengantar astronomi yang membahas tata surya, bintang, dan fenomena luar angkasa.'],
                ['title' => 'Pemecah Rekor Kehidupan di Dunia', 'author' => 'David Lambert', 'publisher' => null, 'year' => null, 'stock' => 3, 'description' => 'Buku pengetahuan populer yang mengulas rekor-rekor unik dalam kehidupan flora, fauna, dan manusia.'],
            ],

            'sejarah' => [
                ['title' => '30 Tahun Indonesia Merdeka 1950-1964', 'author' => null, 'publisher' => 'PT Citra Lamtoro Gung Persada, Indonesia', 'year' => null, 'stock' => 2, 'description' => 'Buku sejarah yang merekam perjalanan bangsa Indonesia pada periode 1950-1964.'],
                ['title' => 'Sejarah Nasional Indonesia I', 'author' => null, 'publisher' => null, 'year' => null, 'stock' => 3, 'description' => 'Buku referensi sejarah nasional Indonesia jilid pertama, mencakup masa awal pembentukan bangsa.'],
                ['title' => '10 November: Gelora Kepahlawanan Indonesia', 'author' => null, 'publisher' => 'Yayasan Dwi Warna', 'year' => null, 'stock' => 2, 'description' => 'Buku yang mengisahkan semangat kepahlawanan dalam peristiwa 10 November di Surabaya.'],
                ['title' => 'Sejarah Kerajaan Bawahan Majapahit di Luar Jawa dan di Luar Negeri', 'author' => null, 'publisher' => 'Araska', 'year' => null, 'stock' => 2, 'description' => 'Buku yang membahas wilayah kekuasaan dan kerajaan bawahan Majapahit di luar Pulau Jawa.'],
                ['title' => 'Prabu Brawijaya: Raja Agung Binathara Ambeg Adil Paramarta', 'author' => null, 'publisher' => null, 'year' => null, 'stock' => 2, 'description' => 'Buku sejarah yang mengangkat kisah kepemimpinan Prabu Brawijaya dari Kerajaan Majapahit.'],
            ],

            'kamus' => [
                ['title' => 'Kamus Besar Bahasa Indonesia (KBBI)', 'author' => null, 'publisher' => 'Balai Pustaka', 'year' => null, 'stock' => 6, 'description' => 'Kamus resmi Bahasa Indonesia, referensi wajib untuk pembelajaran dan penulisan.'],
                ['title' => 'Kamus Bahasa Inggris', 'author' => null, 'publisher' => 'PT Gramedia Pustaka Utama, Jakarta', 'year' => null, 'stock' => 6, 'description' => 'Kamus dwibahasa Inggris-Indonesia untuk menunjang pembelajaran bahasa asing.'],
            ],

            'pelajaran' => [
                // ===== KELAS 1 =====
                ['title' => 'Bahasa Indonesia - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Bahasa Indonesia SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'Bahasa Inggris - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Bahasa Inggris SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'Matematika - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Matematika SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'Sejarah - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku pelajaran Sejarah SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'Pendidikan Agama (Islam/Kristen/Katolik/Hindu) - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Agama SMK Kelas 1 terbitan Erlangga, tersedia untuk agama Islam, Kristen, Katolik, dan Hindu.'],
                ['title' => 'Bahasa Jawa - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku pelajaran Bahasa Jawa (muatan lokal) SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'IPAS - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku pelajaran Ilmu Pengetahuan Alam dan Sosial (IPAS) SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'Seni Budaya - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 6, 'description' => 'Buku pelajaran Seni Budaya SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'Pendidikan Pancasila (PP) - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Pancasila SMK Kelas 1 terbitan Erlangga.'],
                ['title' => 'PJOK - Kelas 1', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK) SMK Kelas 1 terbitan Erlangga.'],

                // ===== KELAS 2 =====
                ['title' => 'Bahasa Indonesia - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Bahasa Indonesia SMK Kelas 2 terbitan Erlangga.'],
                ['title' => 'Bahasa Inggris - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Bahasa Inggris SMK Kelas 2 terbitan Erlangga.'],
                ['title' => 'Matematika - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Matematika SMK Kelas 2 terbitan Erlangga.'],
                ['title' => 'Sejarah - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku pelajaran Sejarah SMK Kelas 2 terbitan Erlangga.'],
                ['title' => 'Pendidikan Agama (Islam/Kristen/Katolik/Hindu) - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Agama SMK Kelas 2 terbitan Erlangga, tersedia untuk agama Islam, Kristen, Katolik, dan Hindu.'],
                ['title' => 'Bahasa Jawa - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku pelajaran Bahasa Jawa (muatan lokal) SMK Kelas 2 terbitan Erlangga.'],
                ['title' => 'Pendidikan Pancasila (PP) - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Pancasila SMK Kelas 2 terbitan Erlangga.'],
                ['title' => 'PJOK - Kelas 2', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK) SMK Kelas 2 terbitan Erlangga.'],

                // ===== KELAS 3 =====
                ['title' => 'Bahasa Indonesia - Kelas 3', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Bahasa Indonesia SMK Kelas 3 terbitan Erlangga.'],
                ['title' => 'Bahasa Inggris - Kelas 3', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Bahasa Inggris SMK Kelas 3 terbitan Erlangga.'],
                ['title' => 'Matematika - Kelas 3', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 10, 'description' => 'Buku pelajaran Matematika SMK Kelas 3 terbitan Erlangga.'],
                ['title' => 'Pendidikan Agama (Islam/Kristen/Katolik/Hindu) - Kelas 3', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Agama SMK Kelas 3 terbitan Erlangga, tersedia untuk agama Islam, Kristen, Katolik, dan Hindu.'],
                ['title' => 'Bahasa Jawa - Kelas 3', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku pelajaran Bahasa Jawa (muatan lokal) SMK Kelas 3 terbitan Erlangga.'],
                ['title' => 'Pendidikan Pancasila (PP) - Kelas 3', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 8, 'description' => 'Buku Pendidikan Pancasila SMK Kelas 3 terbitan Erlangga.'],

                // ===== BUKU TKA =====
                ['title' => 'Erlangga X-Press TKA Bahasa Indonesia', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 6, 'description' => 'Buku persiapan Tes Kemampuan Akademik (TKA) mata pelajaran Bahasa Indonesia terbitan Erlangga.'],
                ['title' => 'Erlangga X-Press TKA Bahasa Inggris', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 6, 'description' => 'Buku persiapan Tes Kemampuan Akademik (TKA) mata pelajaran Bahasa Inggris terbitan Erlangga.'],
                ['title' => 'Erlangga X-Press TKA Matematika', 'author' => null, 'publisher' => 'Erlangga', 'year' => null, 'stock' => 6, 'description' => 'Buku persiapan Tes Kemampuan Akademik (TKA) mata pelajaran Matematika terbitan Erlangga.'],
            ],
        ];

        foreach ($booksByCategory as $slug => $books) {
            $category = Category::where('slug', $slug)->first();
            foreach ($books as $b) {
                Book::create([
                    'book_code' => 'BK-' . strtoupper(Str::random(6)),
                    'title' => $b['title'],
                    'author' => $b['author'],
                    'publisher' => $b['publisher'],
                    'year' => $b['year'],
                    'category_id' => $category->id,
                    'stock' => $b['stock'],
                    'description' => $b['description'],
                ]);
            }
        }

        // ================= TESTIMONI CONTOH =================
        Testimonial::create([
            'user_id' => $siswaUser->id,
            'role_label' => 'Siswa Kelas XI IPA 2',
            'quote' => 'Sistem peminjaman jadi jauh lebih cepat, aku bisa cek stok buku dulu sebelum ke perpustakaan.',
        ]);

        Testimonial::create([
            'user_id' => $admin->id,
            'role_label' => 'Petugas Perpustakaan',
            'quote' => 'Koleksi bukunya lengkap dan rapi. Memantau riwayat peminjaman siswa juga jadi lebih mudah.',
        ]);
    }
}