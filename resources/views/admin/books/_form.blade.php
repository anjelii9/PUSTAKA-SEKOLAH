<div class="form-group">
    <label for="book_code">Nomor Buku</label>
    <input
        type="text"
        id="book_code"
        name="book_code"
        class="form-control"
        value="{{ old('book_code', $book->book_code ?? '') }}"
        required
    >
    @error('book_code')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="title">Judul Buku</label>
    <input
        type="text"
        id="title"
        name="title"
        class="form-control"
        value="{{ old('title', $book->title ?? '') }}"
        required
    >
    @error('title')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="author">Penulis</label>
    <input
        type="text"
        id="author"
        name="author"
        class="form-control"
        value="{{ old('author', $book->author ?? '') }}"
    >
    @error('author')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="publisher">Penerbit</label>
    <input
        type="text"
        id="publisher"
        name="publisher"
        class="form-control"
        value="{{ old('publisher', $book->publisher ?? '') }}"
    >
    @error('publisher')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="year">Tahun Terbit</label>
    <input
        type="number"
        id="year"
        name="year"
        class="form-control"
        value="{{ old('year', $book->year ?? '') }}"
    >
    @error('year')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="category_id">Kategori</label>
    <select
        id="category_id"
        name="category_id"
        class="form-control"
        required
    >
        <option value="">Pilih kategori</option>

        @foreach($categories as $c)
            <option
                value="{{ $c->id }}"
                @selected(old('category_id', $book->category_id ?? '') == $c->id)
            >
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="stock">Stok</label>
    <input
        type="number"
        id="stock"
        name="stock"
        class="form-control"
        min="0"
        value="{{ old('stock', $book->stock ?? 0) }}"
        required
    >
    @error('stock')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="rack_number">Nomor Rak (1–{{ config('perpustakaan.jumlah_rak', 7) }})</label>
    <select
        id="rack_number"
        name="rack_number"
        class="form-control"
    >
        <option value="">-- Pilih rak --</option>

        @for($i = 1; $i <= config('perpustakaan.jumlah_rak', 7); $i++)
            <option
                value="{{ $i }}"
                @selected(old('rack_number', $book->rack_number ?? '') == $i)
            >
                Rak {{ $i }}
            </option>
        @endfor
    </select>
    @error('rack_number')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="shelf_row">Baris Rak (1–{{ config('perpustakaan.baris_per_rak', 4) }})</label>
    <select
        id="shelf_row"
        name="shelf_row"
        class="form-control"
    >
        <option value="">-- Pilih baris --</option>

        @for($i = 1; $i <= config('perpustakaan.baris_per_rak', 4); $i++)
            <option
                value="{{ $i }}"
                @selected(old('shelf_row', $book->shelf_row ?? '') == $i)
            >
                Baris {{ $i }}
            </option>
        @endfor
    </select>
    @error('shelf_row')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="cover">Nama File Cover</label>
    <input
        type="text"
        id="cover"
        name="cover"
        class="form-control"
        value="{{ old('cover', $book->cover ?? '') }}"
        placeholder="contoh: 5cm.jpg"
    >
    <p style="font-size:12px; color:var(--ink-soft); margin-top:6px; line-height:1.5;">
        Cara manual: taruh gambarnya di
        <code>public/images/books/&lt;kategori&gt;/</code>
        (contoh: <code>public/images/books/novel/5cm.jpg</code>),
        lalu ketik nama filenya saja di sini, misalnya <code>5cm.jpg</code>.
        Folder kategori dicari otomatis. Ekstensi boleh tidak ditulis.
    </p>

    @if(! empty($book->cover_url ?? null))
        <div style="margin-top:10px; width:90px; aspect-ratio:3/4; border:1px solid var(--line); overflow:hidden;">
            <img
                src="{{ $book->cover_url }}"
                alt="Preview cover saat ini"
                style="width:100%; height:100%; object-fit:cover;"
            >
        </div>
    @endif

    @error('cover')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="coverFile">Atau Upload Cover Langsung</label>
    <input
        type="file"
        id="coverFile"
        name="cover_file"
        class="form-control"
        accept="image/png,image/jpeg,image/webp"
    >
    @error('cover_file')
        <div class="error-text">{{ $message }}</div>
    @enderror

    <p style="font-size:12px; color:var(--ink-soft); margin-top:6px; line-height:1.5;">
        Opsional. JPG, PNG, atau WEBP, maksimal 2 MB. Kalau diisi, gambar otomatis
        tersimpan ke folder kategorinya dan menggantikan &quot;Nama File Cover&quot; di atas.
        Kalau dikosongkan, tetap bisa memakai nama file hasil upload lewat VS Code.
    </p>

    <div
        id="coverPreviewWrap"
        style="display:none; margin-top:10px; width:90px; aspect-ratio:3/4; border:1px solid var(--line); overflow:hidden;"
    >
        <img
            id="coverPreview"
            alt="Pratinjau cover baru"
            style="width:100%; height:100%; object-fit:cover;"
        >
    </div>
</div>

<div class="form-group">
    <label for="description">Deskripsi</label>
    <textarea
        id="description"
        name="description"
        class="form-control"
        rows="3"
    >{{ old('description', $book->description ?? '') }}</textarea>
    @error('description')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<script>
    (function () {
        var input = document.getElementById('coverFile');
        var wrap  = document.getElementById('coverPreviewWrap');
        var img   = document.getElementById('coverPreview');

        if (!input) return;

        input.addEventListener('change', function () {
            var file = this.files && this.files[0];

            if (!file) {
                wrap.style.display = 'none';
                return;
            }

            img.src = URL.createObjectURL(file);
            wrap.style.display = 'block';
        });
    })();
</script>