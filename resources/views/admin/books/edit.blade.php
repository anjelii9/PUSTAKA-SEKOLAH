@extends("layouts.admin")
@section("title", "Ubah Buku")
@section("content")
<form method="POST" action="{{ route("admin.books.update", $book) }}" enctype="multipart/form-data" class="card" style="max-width:640px;">
    @csrf @method("PUT")
    @include("admin.books._form")
    <button class="btn btn-solid">Simpan Perubahan</button>
</form>
@endsection
