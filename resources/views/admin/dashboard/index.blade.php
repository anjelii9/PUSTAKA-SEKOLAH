@extends("layouts.admin")
@section("title", "Dashboard")
@section("content")

    {{-- ================= KARTU STATISTIK ================= --}}
    <div class="stat-grid">
        <div class="stat-tile">
            <div class="stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div>
                <div class="num" data-count-target="{{ $totalBuku }}">0</div>
                <div class="label">Judul Buku</div>
            </div>
        </div>

        <div class="stat-tile">
            <div class="stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            </div>
            <div>
                <div class="num" data-count-target="{{ $totalStok }}">0</div>
                <div class="label">Total Stok Buku</div>
            </div>
        </div>

        <div class="stat-tile">
            <div class="stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="num" data-count-target="{{ $transaksiAktif }}">0</div>
                <div class="label">Peminjaman Aktif</div>
            </div>
        </div>

        <div class="stat-tile is-danger">
            <div class="stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div>
                <div class="num" data-count-target="{{ $terlambat }}">0</div>
                <div class="label">Terlambat</div>
            </div>
        </div>

        <div class="stat-tile">
            <div class="stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="num" data-count-target="{{ $totalAnggota }}">0</div>
                <div class="label">Anggota</div>
            </div>
        </div>
    </div>

    {{-- ================= TRANSAKSI PEMINJAMAN ================= --}}
    <div class="panel-head" id="transaksi">
        <h2 class="panel-title">Transaksi Peminjaman</h2>
        <span class="panel-sub">{{ $transactions->total() }} transaksi</span>
    </div>

    <div class="admin-toolbar">
        <form method="GET" action="{{ route('admin.dashboard') }}#transaksi" class="admin-filter">
            <input
                type="text"
                name="q"
                class="form-control filter-search"
                placeholder="Cari judul buku / anggota"
                value="{{ request('q') }}"
            >
            <select name="status" class="form-control filter-select">
                <option value="">Semua Status</option>
                <option value="dipinjam" @selected(request('status') == 'dipinjam')>Dipinjam</option>
                <option value="dikembalikan" @selected(request('status') == 'dikembalikan')>Dikembalikan</option>
                <option value="terlambat" @selected(request('status') == 'terlambat')>Terlambat</option>
            </select>
            <button type="submit" class="btn">Filter</button>
        </form>

        <a href="{{ route('admin.transactions.create') }}" class="btn btn-solid btn-add">+ Input Peminjaman</a>
    </div>

    <div class="card dash-card reveal">
        <div class="table-scroll">
            <table class="data-table dash-table table-stack">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Buku</th>
                        <th>Anggota</th>
                        <th>Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td data-label="Kode">{{ $t->transaction_code }}</td>
                        <td data-label="Buku" class="col-buku">{{ $t->book->title ?? '-' }}</td>
                        <td data-label="Anggota">{{ $t->member->name ?? '-' }}</td>
                        <td data-label="Pinjam">{{ $t->borrow_date->format('d-m-Y') }}</td>
                        <td data-label="Jatuh Tempo">{{ $t->due_date->format('d-m-Y') }}</td>
                        <td data-label="Status">
                            <span class="badge {{ $t->status === 'dikembalikan' ? 'badge-available' : ($t->status === 'terlambat' ? 'badge-unavailable' : 'badge-late') }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                        <td data-label="Denda">Rp {{ number_format($t->fine, 0, ',', '.') }}</td>
                        <td data-label="Aksi">
                            <div class="aksi-buttons">
                                <a href="{{ route('admin.transactions.show', $t) }}" class="btn">Detail</a>
                                @if($t->status !== 'dikembalikan')
                                    <a href="{{ route('admin.transactions.return-form', $t) }}" class="btn btn-solid">Kembalikan</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">Belum ada transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">{{ $transactions->withQueryString()->fragment('transaksi')->links() }}</div>
    </div>
@endsection