<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Perpustakaan Sekolah")</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    @stack("styles")
</head>
<body>

    @php
        $catalogRoute = auth()->check() && auth()->user()->isSiswa()
            ? route("student.catalog")
            : (auth()->check() && auth()->user()->isAdmin()
                ? route("admin.books.index")
                : route("home")."#katalog");
        $searchAction = auth()->check() && auth()->user()->isSiswa()
            ? route("student.catalog")
            : route("home");
    @endphp

    <nav class="navbar">
        <button type="button" class="icon-btn" data-sidebar-toggle title="Menu" style="border:none; margin-right:4px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="nav-left">
            <a href="{{ $catalogRoute }}">Katalog</a>
            <a href="{{ route("home") }}#tentang">Tentang</a>
        </div>
        <a href="{{ route("home") }}" class="nav-logo">Pustaka Sekolah</a>
        <div class="nav-right">
            <form action="{{ $searchAction }}" method="GET" style="display:flex;">
                <input type="text" name="q" placeholder="Cari judul, penulis..." class="form-control" style="width:180px;" value="{{ request("q") }}">
            </form>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route("admin.dashboard") }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route("student.catalog") }}" class="btn">Katalog Saya</a>
                @endif
                <span class="icon-btn" title="{{ auth()->user()->name }} — sudah login">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </span>
                <form action="{{ route("logout") }}" method="POST">
                    @csrf
                    <button class="icon-btn" title="Keluar">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            @else
                <a href="{{ route("login") }}" class="btn">Login</a>
                <a href="{{ route("login") }}" class="icon-btn" title="Akun">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
            @endauth
        </div>
    </nav>

    <div data-sidebar-overlay style="position:fixed; inset:0; background:rgba(0,0,0,.5); opacity:0; pointer-events:none; transition:opacity .3s ease; z-index:98;"></div>

    <aside data-sidebar-drawer style="position:fixed; top:0; left:0; bottom:0; width:280px; max-width:82vw; background:linear-gradient(180deg, var(--mahogany-light) 0%, var(--mahogany-dark) 100%); color:var(--gold-text); z-index:99; transform:translateX(-100%); transition:transform .3s cubic-bezier(.16,1,.3,1); overflow-y:auto; box-shadow:8px 0 32px rgba(0,0,0,.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:20px 20px 16px; border-bottom:1px solid var(--mahogany-line);">
            <span class="nav-logo" style="text-align:left; font-size:20px;">Pustaka Sekolah</span>
            <button type="button" data-sidebar-close class="icon-btn" title="Tutup" style="border-color:var(--gold); color:var(--gold-light);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <nav style="padding:12px 0;">
            <a href="{{ route("home") }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:rgba(241,221,176,.85);">Beranda</a>
            <a href="{{ $catalogRoute }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:rgba(241,221,176,.85);">Katalog</a>
            <a href="{{ route("home") }}#tentang" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:rgba(241,221,176,.85);">Tentang</a>

            <div style="border-top:1px solid var(--mahogany-line); margin:12px 0;"></div>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route("admin.dashboard") }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:var(--gold-light);">Dashboard Admin</a>
                @else
                    <a href="{{ route("student.catalog") }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:var(--gold-light);">Katalog Saya</a>
                    <a href="{{ route("student.history") }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:var(--gold-light);">Riwayat Peminjaman</a>
                    <a href="{{ route("student.profile") }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:var(--gold-light);">Profil Saya</a>
                @endif
                <form action="{{ route("logout") }}" method="POST" style="margin-top:8px;">
                    @csrf
                    <button type="submit" style="all:unset; display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; cursor:pointer; width:100%; color:var(--gold-light);">Keluar</button>
                </form>
            @else
                <a href="{{ route("login") }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:var(--gold-light);">Login</a>
                <a href="{{ route("register") }}" style="display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; color:var(--gold-light);">Daftar Jadi Anggota</a>
            @endauth
        </nav>
    </aside>

    @if(session("success"))
        <div class="container" style="margin-top:16px;">
            <div style="background:#eaf3ec;border:1px solid var(--available);color:var(--available);padding:12px 16px;font-size:14px;">
                {{ session("success") }}
            </div>
        </div>
    @endif
    @if(session("error"))
        <div class="container" style="margin-top:16px;">
            <div style="background:#f7eae8;border:1px solid var(--unavailable);color:var(--unavailable);padding:12px 16px;font-size:14px;">
                {{ session("error") }}
            </div>
        </div>
    @endif

    <main>
        @yield("content")
    </main>

    <footer class="site-footer">
        <div class="container" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div class="nav-logo" style="text-align:left;">Pustaka Sekolah</div>
            <p style="font-size:13px;">&copy; {{ date("Y") }} Perpustakaan Sekolah. Sistem Peminjaman & Pengembalian Buku.</p>
        </div>
    </footer>

    @stack("scripts")
    <script src="{{ asset("js/app.js") }}"></script>
</body>
</html>
