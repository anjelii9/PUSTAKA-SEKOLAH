@extends('layouts.app')

@section('title', 'Beranda — Perpustakaan Sekolah')

@section('content')

    @php
        $user = auth()->user();

        $isStudent = $user && $user->isSiswa();
        $isAdmin = $user && $user->isAdmin();

        $browseRoute = $isStudent
            ? route('student.catalog')
            : ($isAdmin ? route('admin.books.index') : route('login'));

        $categoryRoute = fn ($categoryId) => $isStudent
            ? route('student.catalog', ['category_id' => $categoryId])
            : ($isAdmin
                ? route('admin.books.index', ['category_id' => $categoryId])
                : route('login'));

        $bookRoute = fn ($book) => $isStudent
            ? route('student.catalog.show', $book)
            : ($isAdmin
                ? route('admin.books.edit', $book)
                : route('login'));

        // Deskripsi singkat tiap kategori (kunci = slug kategori)
        $categoryDescriptions = [
            'komik'     => 'Cerita bergambar seru untuk hiburan dan penyegar pikiran.',
            'novel'     => 'Kisah fiksi dan cerita panjang yang menemani waktu bacamu.',
            'sains'     => 'Pengetahuan alam, teknologi, dan penemuan untuk memuaskan rasa ingin tahu.',
            'sejarah'   => 'Jejak peristiwa, tokoh, dan peradaban dari masa ke masa.',
            'kamus'     => 'Rujukan kata dan istilah untuk memperkaya kosakatamu.',
            'pelajaran' => 'Buku pegangan mata pelajaran untuk menunjang belajar di sekolah.',
        ];
    @endphp

    {{-- HERO --}}
    <section
        class="hero"
        style="background-image: url('https://images.pexels.com/photos/4353719/pexels-photo-4353719.jpeg?auto=compress&cs=tinysrgb&w=1600');"
    >
        <div class="hero-content">
            <h1>Temukan<br>Buku<br>Favoritmu</h1>

            <p>
                Jelajahi koleksi perpustakaan sekolah dan pinjam buku favoritmu
                dengan mudah, cepat, dan tanpa antre.
            </p>

            @guest
                <a href="{{ route('register') }}" class="btn btn-solid">
                    Daftar Jadi Anggota
                </a>
            @else
                @if($isStudent)
                    <a href="{{ route('student.catalog') }}" class="btn btn-solid">
                        Jelajahi Katalog
                    </a>
                @elseif($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-solid">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-solid">
                        Masuk
                    </a>
                @endif
            @endguest
        </div>
    </section>

    {{-- KATEGORI --}}
    <section class="section" id="katalog">
        <div class="container">
            <div class="section-head reveal" style="justify-content:center; text-align:center;">
                <div>
                    <h2>Cari Berdasarkan<br>Kategori</h2>
                    <p class="sub">
                        Pilih kategori untuk mulai menjelajah koleksi buku.
                    </p>
                </div>
            </div>

            <div class="category-grid reveal-stagger">
                @forelse($categories as $cat)
                    <a href="{{ $categoryRoute($cat->id) }}" class="category-card">
                        <span class="cat-name">{{ $cat->name }}</span>
                        <span class="cat-desc">
                            {{ $categoryDescriptions[$cat->slug] ?? 'Jelajahi koleksi buku dalam kategori ini.' }}
                        </span>
                        <span class="cat-meta">{{ $cat->books_count ?? 0 }} buku &rarr;</span>
                    </a>
                @empty
                    <p>Belum ada kategori buku.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- BUKU TERBARU --}}
    <section
        class="section"
        style="background:var(--bone); border-top:1px solid var(--line); border-bottom:1px solid var(--line);"
    >
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <h2>Buku Terbaru</h2>
                    <p class="sub">
                        Koleksi buku terbaru yang baru saja ditambahkan ke perpustakaan.
                    </p>
                </div>

                <a href="{{ $browseRoute }}" class="btn">
                    Lihat Semua Buku
                </a>
            </div>

            <div class="book-grid reveal-stagger">
                @forelse($latestBooks as $book)
                    <a href="{{ $bookRoute($book) }}" class="book-card">
                        <div class="book-cover">
                            @if($book->cover_url)
                                <img
                                    src="{{ $book->cover_url }}"
                                    alt="{{ $book->title }}"
                                >
                            @else
                                <span
                                    style="font-family:'Archivo Expanded'; font-size:13px; color:var(--ink-soft); text-align:center; padding:12px;"
                                >
                                    {{ $book->title }}
                                </span>
                            @endif
                        </div>

                        <span class="badge {{ $book->isAvailable() ? 'badge-available' : 'badge-unavailable' }}">
                            {{ $book->isAvailable() ? 'Tersedia' : 'Dipinjam Semua' }}
                        </span>

                        <div class="book-title">{{ $book->title }}</div>

                        <div class="book-meta">
                            {{ $book->category->name ?? '-' }}
                            &middot;
                            {{ $book->author }}
                        </div>
                    </a>
                @empty
                    <p>Belum ada buku pada katalog.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- TESTIMONI --}}
    <section class="section" id="tentang">
        <div class="container">
            <div
                class="section-head reveal"
                style="justify-content:center; text-align:center;"
            >
                <div>
                    <h2>Apa Kata<br>Mereka</h2>
                    <p class="sub">
                        Testimoni dari siswa dan guru tentang perpustakaan sekolah.
                    </p>
                </div>
            </div>

            <div class="testi-grid reveal-stagger">
                @forelse($testimonials as $t)
                    <div class="testi-card">
                        <p class="testi-quote">"{{ $t->quote }}"</p>
                        <div class="testi-name">
                            {{ $t->user->name ?? 'Anggota Perpustakaan' }}
                        </div>
                        <div class="testi-role">{{ $t->role_label }}</div>
                    </div>
                @empty
                    <p style="color:var(--ink-soft); font-size:14px; text-align:center;">
                        Belum ada testimoni. Jadilah yang pertama menulis testimoni!
                    </p>
                @endforelse
            </div>

            <div
                class="card reveal"
                style="max-width:560px; margin:40px auto 0; text-align:center;"
            >
                @auth
                    @if($isStudent)
                        <h3
                            style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:14px;"
                        >
                            {{ $myTestimonial ? 'Ubah Testimonimu' : 'Tulis Testimonimu' }}
                        </h3>

                        <form
                            method="POST"
                            action="{{ route('student.testimonials.store') }}"
                            style="text-align:left;"
                        >
                            @csrf

                            <div class="form-group">
                                <label for="quote">Testimoni</label>

                                <textarea
                                    id="quote"
                                    name="quote"
                                    rows="3"
                                    class="form-control"
                                    maxlength="500"
                                    required
                                    placeholder="Ceritakan pengalamanmu memakai perpustakaan sekolah..."
                                >{{ old('quote', $myTestimonial->quote ?? '') }}</textarea>

                                @error('quote')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="role_label">Label (opsional)</label>

                                <input
                                    type="text"
                                    id="role_label"
                                    name="role_label"
                                    class="form-control"
                                    maxlength="100"
                                    placeholder="Contoh: Siswa Kelas XI RPL"
                                    value="{{ old('role_label', $myTestimonial->role_label ?? '') }}"
                                >

                                @error('role_label')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div style="text-align:center;">
                                <button type="submit" class="btn btn-solid">
                                    {{ $myTestimonial ? 'Perbarui Testimoni' : 'Kirim Testimoni' }}
                                </button>
                            </div>
                        </form>

                        @if($myTestimonial)
                            <form
                                method="POST"
                                action="{{ route('student.testimonials.destroy') }}"
                                style="margin-top:10px; text-align:center;"
                                onsubmit="return confirm('Yakin ingin menghapus testimonimu?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn"
                                    style="border-color:var(--unavailable); color:var(--unavailable);"
                                >
                                    Hapus Testimoni
                                </button>
                            </form>
                        @endif
                    @else
                        <p style="font-size:14px; color:var(--ink-soft);">
                            Fitur kirim testimoni hanya tersedia untuk anggota (siswa).
                        </p>
                    @endif
                @else
                    <p style="font-size:14px; color:var(--ink-soft);">
                        Ingin berbagi pengalamanmu?
                        <a href="{{ route('login') }}" style="text-decoration:underline;">
                            Masuk
                        </a>
                        atau
                        <a href="{{ route('register') }}" style="text-decoration:underline;">
                            daftar sebagai anggota
                        </a>
                        dulu untuk menulis testimoni.
                    </p>
                @endauth
            </div>
        </div>
    </section>

@endsection