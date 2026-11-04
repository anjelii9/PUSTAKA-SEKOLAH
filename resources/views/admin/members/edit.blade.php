@extends('layouts.admin')

@section('title', 'Ubah Anggota')

@section('content')
<form
    method="POST"
    action="{{ route('admin.members.update', $member) }}"
    class="card"
    style="max-width:640px;"
>
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Nama</label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            value="{{ old('name', $member->name) }}"
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
            value="{{ old('class', $member->class) }}"
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
            value="{{ old('phone', $member->phone) }}"
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
            value="{{ old('address', $member->address) }}"
        >
        @error('address')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-control">
            <option
                value="aktif"
                @selected(old('status', $member->status) === 'aktif')
            >
                Aktif
            </option>

            <option
                value="nonaktif"
                @selected(old('status', $member->status) === 'nonaktif')
            >
                Nonaktif
            </option>
        </select>

        @error('status')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-solid">
        Simpan Perubahan
    </button>
</form>
@endsection
