<div class="form-group">
    <label>Nomor Buku</label>
    <input type="text" name="book_code" class="form-control" value="{{ old("book_code", $book->book_code ?? "") }}" required>
    @error("book_code") <div class="error-text">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label>Judul Buku</label>
    <input type="text" name="title" class="form-control" value="{{ old("title", $book->title ?? "") }}" required>
    @error("title") <div class="error-text">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label>Penulis</label>
    <input type="text" name="author" class="form-control" value="{{ old("author", $book->author ?? "") }}">
</div>
<div class="form-group">
    <label>Penerbit</label>
    <input type="text" name="publisher" class="form-control" value="{{ old("publisher", $book->publisher ?? "") }}">
</div>
<div class="form-group">
    <label>Tahun Terbit</label>
    <input type="number" name="year" class="form-control" value="{{ old("year", $book->year ?? "") }}">
</div>
<div class="form-group">
    <label>Kategori</label>
    <select name="category_id" class="form-control" required>
        <option value="">Pilih kategori</option>
        @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old("category_id", $book->category_id ?? "")==$c->id)>{{ $c->name }}</option>
        @endforeach
    </select>
    @error("category_id") <div class="error-text">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label>Stok</label>
    <input type="number" min="0" name="stock" class="form-control" value="{{ old("stock", $book->stock ?? 0) }}" required>
    @error("stock") <div class="error-text">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label>Cover Buku</label>
    <input type="file" name="cover" class="form-control">
</div>
<div class="form-group">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control" rows="3">{{ old("description", $book->description ?? "") }}</textarea>
</div>
