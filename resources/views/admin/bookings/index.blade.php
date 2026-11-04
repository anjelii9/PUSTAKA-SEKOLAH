@extends("layouts.admin")
@section("title", "Daftar Booking")
@section("content")
    <form method="GET" style="display:flex; gap:8px; margin-bottom:20px;">
        <select name="status" class="form-control" style="width:200px;">
            <option value="">Semua Status</option>
            <option value="menunggu" @selected(request('status')=='menunggu')>Menunggu</option>
            <option value="dikonfirmasi" @selected(request('status')=='dikonfirmasi')>Dikonfirmasi</option>
            <option value="dibatalkan" @selected(request('status')=='dibatalkan')>Dibatalkan</option>
        </select>
        <button class="btn">Filter</button>
    </form>

    <p style="font-size:12px; color:var(--ink-soft); margin-top:-12px; margin-bottom:20px;">Booking yang telat diambil lebih dari 10 menit otomatis dibatalkan sistem setiap halaman ini dibuka.</p>

    <div class="card">
        <table class="data-table">
            <thead><tr><th>Kode</th><th>Buku</th><th>Lokasi</th><th>Anggota</th><th>Tgl Booking</th><th>Jam Ambil</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($bookings as $b)
                <tr>
                    <td>{{ $b->booking_code }}</td>
                    <td>{{ $b->book->title ?? '-' }}</td>
                    <td>{{ $b->book ? $b->book->locationShort() : '-' }}</td>
                    <td>{{ $b->member->name ?? '-' }} <span style="color:var(--ink-soft); font-size:12px;">({{ $b->member->class ?? '-' }})</span></td>
                    <td>{{ $b->booking_date->format('d-m-Y') }}</td>
                    <td>{{ substr($b->pickup_time, 0, 5) }} WIB</td>
                    <td>
                        <span class="badge {{ $b->status === 'dikonfirmasi' ? 'badge-available' : ($b->status === 'dibatalkan' ? 'badge-unavailable' : 'badge-late') }}">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>
                    <td>
                        @if($b->status === 'menunggu')
                            <form action="{{ route('admin.bookings.confirm', $b) }}" method="POST" onsubmit="return confirm('Konfirmasi pengambilan buku ini?')">
                                @csrf
                                <button class="btn btn-solid" style="padding:6px 14px; font-size:12px;">Konfirmasi</button>
                            </form>
                        @else
                            <span style="color:var(--ink-soft); font-size:12px;">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">Belum ada booking.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $bookings->links() }}</div>
    </div>
@endsection