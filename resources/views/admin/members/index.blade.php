@extends('layouts.admin')

@section('title', 'Data Anggota')

@section('content')
<div class="admin-toolbar">

    {{-- Baris 1: cari + tombol cari sejajar --}}
    <form method="GET" class="admin-filter">
        <input
            type="text"
            name="q"
            class="form-control filter-search"
            placeholder="Cari nama / kode anggota"
            value="{{ request('q') }}"
        >

        <button type="submit" class="btn">Cari</button>
    </form>

    {{-- Baris 2: tombol tambah anggota di bawahnya --}}
    <a href="{{ route('admin.members.create') }}" class="btn btn-solid btn-add">
        + Tambah Anggota
    </a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($members as $m)
                <tr>
                    <td>{{ $m->member_code }}</td>

                    <td>{{ $m->name }}</td>

                    <td>{{ $m->class }}</td>

                    <td>
                        <span class="badge {{ $m->status === 'aktif' ? 'badge-available' : 'badge-unavailable' }}">
                            {{ ucfirst($m->status) }}
                        </span>
                    </td>

                    <td style="display:flex; gap:8px; flex-wrap:wrap;">
                        <a
                            href="{{ route('admin.members.edit', $m) }}"
                            class="btn"
                            style="padding:6px 14px;"
                        >
                            Ubah
                        </a>

                        <a
                            href="{{ route('admin.members.card', $m) }}"
                            target="_blank"
                            class="btn"
                            style="padding:6px 14px;"
                        >
                            Kartu
                        </a>

                        <form
                            action="{{ route('admin.members.destroy', $m) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus anggota ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn"
                                style="padding:6px 14px; border-color:var(--unavailable); color:var(--unavailable);"
                            >
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada data anggota.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:16px;">
        {{ $members->withQueryString()->links() }}
    </div>
</div>
@endsection