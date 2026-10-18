<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Admin — Perpustakaan Sekolah")</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
</head>
<body style="display:flex; min-height:100vh;">

    <aside class="sidebar">
        <div style="padding:0 24px 20px; font-family:"Bebas Neue"; font-size:22px; letter-spacing:.06em; color: var(--gold-light); text-shadow: 0 1px 2px rgba(0,0,0,.4); position:relative; z-index:2;">Pustaka Admin</div>
        <a href="{{ route("admin.dashboard") }}" class="{{ request()->routeIs("admin.dashboard") ? "active" : "" }}">Dashboard</a>
        <a href="{{ route("admin.books.index") }}" class="{{ request()->routeIs("admin.books.*") ? "active" : "" }}">Data Buku</a>
        <a href="{{ route("admin.members.index") }}" class="{{ request()->routeIs("admin.members.*") ? "active" : "" }}">Data Anggota</a>
        <a href="{{ route("admin.transactions.index") }}" class="{{ request()->routeIs("admin.transactions.*") ? "active" : "" }}">Transaksi Peminjaman</a>
        <a href="{{ route("admin.reports.index") }}" class="{{ request()->routeIs("admin.reports.*") ? "active" : "" }}">Laporan</a>
        <a href="{{ route("home") }}" style="margin-top:20px; opacity:.85; color: var(--gold-text);">Lihat Situs</a>
        <form action="{{ route("logout") }}" method="POST">
            @csrf
            <button type="submit" style="all:unset; display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; cursor:pointer; width:100%; color: var(--gold-light);">Keluar</button>
        </form>
    </aside>

    <div style="flex:1; padding: 32px; max-width: calc(100% - 240px);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <h1 style="font-size:28px;">@yield("title")</h1>
            <div style="font-size:13px; color:var(--ink-soft);">Halo, {{ auth()->user()->name }}</div>
        </div>

        @if(session("success"))
            <div style="background:#eaf3ec;border:1px solid var(--available);color:var(--available);padding:12px 16px;font-size:14px; margin-bottom:20px;">{{ session("success") }}</div>
        @endif
        @if(session("error"))
            <div style="background:#f7eae8;border:1px solid var(--unavailable);color:var(--unavailable);padding:12px 16px;font-size:14px; margin-bottom:20px;">{{ session("error") }}</div>
        @endif

        @yield("content")
    </div>
    <script src="{{ asset("js/app.js") }}"></script>
</body>
</html>
