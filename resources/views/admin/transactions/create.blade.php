@extends('layouts.admin')

@section('title', 'Input Peminjaman')

@section('content')

    <form method="POST" action="{{ route('admin.transactions.store') }}" class="card" style="max-width:640px;">
        @csrf

        <div class="form-group">
            <label for="book_id">Buku (Nomor Buku)</label>

            <select name="book_id" id="book_id" class="form-control" required>
                <option value="">Pilih buku</option>

                @foreach($books as $b)
                    <option
                        value="{{ $b->id }}"
                        @selected(old('book_id') == $b->id)
                    >
                        {{ $b->book_code }} — {{ $b->title }} (stok: {{ $b->stock }})
                    </option>
                @endforeach
            </select>

            @error('book_id')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="member_id">Anggota (Siswa)</label>

            <select name="member_id" id="member_id" class="form-control" required>
                <option value="">Pilih anggota</option>

                @foreach($members as $m)
                    <option
                        value="{{ $m->id }}"
                        @selected(old('member_id') == $m->id)
                    >
                        {{ $m->member_code }} — {{ $m->name }} ({{ $m->class }})
                    </option>
                @endforeach
            </select>

            @error('member_id')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <p style="font-size:12px; color:var(--ink-soft); margin-bottom:18px;">
            Tanggal pinjam dan jatuh tempo diatur otomatis oleh sistem.
            Jatuh tempo: {{ config('perpustakaan.lama_pinjam_hari', 7) }} hari dari sekarang.
        </p>

        <div class="form-group">
            <label for="notes">Catatan (opsional)</label>

            <input
                type="text"
                id="notes"
                name="notes"
                class="form-control"
                value="{{ old('notes') }}"
                placeholder="Contoh: Buku untuk tugas sekolah"
            >

            @error('notes')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-solid">
            Simpan Peminjaman
        </button>
    </form>

@endsection
