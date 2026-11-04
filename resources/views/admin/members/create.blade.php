@extends('layouts.admin')

@section('title', 'Tambah Anggota')

@section('content')
<form
    method="POST"
    action="{{ route('admin.members.store') }}"
    class="card"
    style="max-width:640px;"
>
    @csrf

    <div class="form-group">
        <label for="name">Nama</label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            value="{{ old('name') }}"
            required
        >
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="class">Kelas</label>
        <input
            type="text"
            id="class"
            name="class"
            class="form-control"
            value="{{ old('class') }}"
            required
        >
        @error('class')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">No. HP</label>
        <input
            type="text"
            id="phone"
            name="phone"
            class="form-control"
            value="{{ old('phone') }}"
        >
        @error('phone')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="address">Alamat</label>
        <input
            type="text"
            id="address"
            name="address"
            class="form-control"
            value="{{ old('address') }}"
        >
        @error('address')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-control">
            <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>
                Aktif
            </option>
            <option value="nonaktif" @selected(old('status') === 'nonaktif')>
                Nonaktif
            </option>
        </select>
        @error('status')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <p style="font-size:12px; color:var(--ink-soft); margin-bottom:8px;">
        Opsional: buat akun login untuk anggota ini.
    </p>

    <div class="form-group">
        <label for="email">Email (opsional)</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            value="{{ old('email') }}"
        >
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password (opsional)</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control"
        >
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-solid">
        Simpan Anggota
    </button>
</form>
@endsection
