<div class="form-group">
    <label for="book_code">Nomor Buku</label>
    <input
        type="text"
        id="book_code"
        name="book_code"
        class="form-control"
        value="<?php echo e(old('book_code', $book->book_code ?? '')); ?>"
        required
    >
    <?php $__errorArgs = ['book_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="title">Judul Buku</label>
    <input
        type="text"
        id="title"
        name="title"
        class="form-control"
        value="<?php echo e(old('title', $book->title ?? '')); ?>"
        required
    >
    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="author">Penulis</label>
    <input
        type="text"
        id="author"
        name="author"
        class="form-control"
        value="<?php echo e(old('author', $book->author ?? '')); ?>"
    >
    <?php $__errorArgs = ['author'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="publisher">Penerbit</label>
    <input
        type="text"
        id="publisher"
        name="publisher"
        class="form-control"
        value="<?php echo e(old('publisher', $book->publisher ?? '')); ?>"
    >
    <?php $__errorArgs = ['publisher'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="year">Tahun Terbit</label>
    <input
        type="number"
        id="year"
        name="year"
        class="form-control"
        value="<?php echo e(old('year', $book->year ?? '')); ?>"
    >
    <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option
                value="<?php echo e($c->id); ?>"
                <?php if(old('category_id', $book->category_id ?? '') == $c->id): echo 'selected'; endif; ?>
            >
                <?php echo e($c->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="stock">Stok</label>
    <input
        type="number"
        id="stock"
        name="stock"
        class="form-control"
        min="0"
        value="<?php echo e(old('stock', $book->stock ?? 0)); ?>"
        required
    >
    <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="rack_number">Nomor Rak (1–<?php echo e(config('perpustakaan.jumlah_rak', 7)); ?>)</label>
    <select
        id="rack_number"
        name="rack_number"
        class="form-control"
    >
        <option value="">-- Pilih rak --</option>

        <?php for($i = 1; $i <= config('perpustakaan.jumlah_rak', 7); $i++): ?>
            <option
                value="<?php echo e($i); ?>"
                <?php if(old('rack_number', $book->rack_number ?? '') == $i): echo 'selected'; endif; ?>
            >
                Rak <?php echo e($i); ?>

            </option>
        <?php endfor; ?>
    </select>
    <?php $__errorArgs = ['rack_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="shelf_row">Baris Rak (1–<?php echo e(config('perpustakaan.baris_per_rak', 4)); ?>)</label>
    <select
        id="shelf_row"
        name="shelf_row"
        class="form-control"
    >
        <option value="">-- Pilih baris --</option>

        <?php for($i = 1; $i <= config('perpustakaan.baris_per_rak', 4); $i++): ?>
            <option
                value="<?php echo e($i); ?>"
                <?php if(old('shelf_row', $book->shelf_row ?? '') == $i): echo 'selected'; endif; ?>
            >
                Baris <?php echo e($i); ?>

            </option>
        <?php endfor; ?>
    </select>
    <?php $__errorArgs = ['shelf_row'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="cover">Nama File Cover</label>
    <input
        type="text"
        id="cover"
        name="cover"
        class="form-control"
        value="<?php echo e(old('cover', $book->cover ?? '')); ?>"
        placeholder="contoh: 5cm.jpg"
    >
    <p style="font-size:12px; color:var(--ink-soft); margin-top:6px; line-height:1.5;">
        Cara manual: taruh gambarnya di
        <code>public/images/books/&lt;kategori&gt;/</code>
        (contoh: <code>public/images/books/novel/5cm.jpg</code>),
        lalu ketik nama filenya saja di sini, misalnya <code>5cm.jpg</code>.
        Folder kategori dicari otomatis. Ekstensi boleh tidak ditulis.
    </p>

    <?php if(! empty($book->cover_url ?? null)): ?>
        <div style="margin-top:10px; width:90px; aspect-ratio:3/4; border:1px solid var(--line); overflow:hidden;">
            <img
                src="<?php echo e($book->cover_url); ?>"
                alt="Preview cover saat ini"
                style="width:100%; height:100%; object-fit:cover;"
            >
        </div>
    <?php endif; ?>

    <?php $__errorArgs = ['cover'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
    <?php $__errorArgs = ['cover_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

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
    ><?php echo e(old('description', $book->description ?? '')); ?></textarea>
    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
</script><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/admin/books/_form.blade.php ENDPATH**/ ?>