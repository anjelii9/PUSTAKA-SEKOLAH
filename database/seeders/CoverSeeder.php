<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class CoverSeeder extends Seeder
{
    public function run(): void
    {
        // "bagian judul buku" => "nama file di public/images/books/<kategori>/"
        // Tanda % artinya "apa saja boleh ada di sini"
        $covers = [
            // KOMIK
            "Raditya Dika"                       => "radit.jpg",
            "Love Deadline"                      => "love.jpg",
            "Ngopi Yuk"                          => "ngopi.jpg",
            "Sekar Populer"                      => "sekar.jpg",
            "Dulu Gwe%Pernah"                    => "gwen.jpg",
            "Terlalu Tampan"                     => "tampan.jpg",

            // NOVEL
            "Crying Doesn"                       => "crying.jpg",
            "Tentang Kami"                       => "tentang.jpg",
            "Love & Gelato"                      => "gelato.jpg",
            "Alletta"                            => "aleta.jpg",
            "Ruang Tunggu"                       => "ruang.jpg",
            "Klara and the Sun"                  => "sun.jpg",
            "5 cm"                               => "5cm.jpg",
            "Fana Kecuali Luka"                  => "fana.jpg",
            "Loveless"                           => "loveless.jpg",
            "Wonderful Bangkok"                  => "bangkok.jpg",
            "Di Penghujung Pelukan"              => "pelukan.jpg",

            // SAINS
            "Astronomi"                          => "astronomi.jpg",
            "Rekor Kehidupan di Dunia"           => "hewan.jpg",
            "Pemecah Rekor Bumi"                 => "ensiklopedia.jpg",

            // SEJARAH
            "30 Tahun Indonesia Merdeka"         => "30th.jpg",
            "10 November"                        => "10nov.jpg",
            "Prabu Brawijaya"                    => "prabu.jpg",
            "Kerajaan Bawahan Majapahit"         => "majapahit.jpg",
            "Sejarah Nasional Indonesia I"       => "sanas.jpg",

            // KAMUS
            "Kamus Besar Bahasa Indonesia"       => "kbbi.jpg",
            "Kamus Bahasa Inggris"               => "inggris.jpg",

            // PELAJARAN - Kelas 1
            "Bahasa Indonesia - Kelas 1"         => "indo1.jpg",
            "Bahasa Inggris - Kelas 1"           => "inggris1.jpg",
            "Matematika - Kelas 1"               => "mat1.jpg",
            "Seni Budaya%Kelas 1"                => "senbud1.jpg",
            "Sejarah - Kelas 1"                  => "sejarah1.jpg",
            "Pendidikan Agama Islam%Kelas 1"     => "islam1.jpg",
            "Pendidikan Agama Kristen%Kelas 1"   => "kristen1.png",
            "Pendidikan Agama Katolik%Kelas 1"   => "katolik1.jpg",
            "Pendidikan Agama Hindu%Kelas 1"     => "hindu1.jpg",
            "Bahasa Jawa - Kelas 1"              => "jawa1.jpg",
            "IPAS - Kelas 1"                     => "ipas1.jpg",
            "Pendidikan Pancasila%Kelas 1"       => "pp1.jpg",
            "PJOK - Kelas 1"                     => "pjok1.jpg",

            // PELAJARAN - Kelas 2
            "Bahasa Indonesia - Kelas 2"         => "indo2.jpg",
            "Bahasa Inggris - Kelas 2"           => "inggris2.jpg",
            "Matematika - Kelas 2"               => "mat2.jpg",
            "Sejarah - Kelas 2"                  => "sejarah2.jpg",
            "Pendidikan Agama Islam%Kelas 2"     => "islam2.jpg",
            "Pendidikan Agama Kristen%Kelas 2"   => "kristen2.jpg",
            "Pendidikan Agama Katolik%Kelas 2"   => "katolik2.jpg",
            "Pendidikan Agama Hindu%Kelas 2"     => "hindu2.jpg",
            "Bahasa Jawa - Kelas 2"              => "jawa2.jpg",
            "Produk Kreatif%Kelas 2"             => "pkkwu2.jpg",
            "Pendidikan Pancasila%Kelas 2"       => "pp2.jpg",
            "PJOK - Kelas 2"                     => "pjok2.jpg",

            // PELAJARAN - Kelas 3
            "Bahasa Indonesia - Kelas 3"         => "indo3.jpg",
            "Bahasa Inggris - Kelas 3"           => "inggris3.jpg",
            "Matematika - Kelas 3"               => "mat3.jpg",
            "Pendidikan Agama Islam%Kelas 3"     => "islam3.jpg",
            "Pendidikan Agama Kristen%Kelas 3"   => "kristen3.jpg",
            "Pendidikan Agama Katolik%Kelas 3"   => "katolik3.jpg",
            "Pendidikan Agama Hindu%Kelas 3"     => "hindu3.jpg",
            "Bahasa Jawa - Kelas 3"              => "jawa3.jpg",
            "Produk Kreatif%Kelas 3"             => "pkkwu3.jpg",
            "Pendidikan Pancasila%Kelas 3"       => "pp3.jpg",

            // PELAJARAN - TKA
            "TKA Bahasa Indonesia"               => "tkaindo.jpg",
            "TKA Bahasa Inggris"                 => "tkainggris.jpg",
            "TKA Matematika"                     => "tkamat.jpg",
        ];

        foreach ($covers as $judul => $file) {
            Book::where("title", "like", "%" . $judul . "%")->update(["cover" => $file]);
        }
    }
}