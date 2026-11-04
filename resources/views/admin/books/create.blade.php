
@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
<form
    method="POST"
    action="{{ route('admin.books.store') }}"
    enctype="multipart/form-data"
    class="card"
    style="max-width:640px;"
>
    @csrf

    @include('admin.books._form')

    <button type="submit" class="btn btn-solid">
        Simpan Buku
    </button>
</form>
@endsection
