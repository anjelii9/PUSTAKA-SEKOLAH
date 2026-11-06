<?php $__env->startSection('title', 'Data Buku'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">

    
    <form method="GET" class="admin-filter">
        <input
            type="text"
            name="q"
            class="form-control filter-search"
            placeholder="Cari judul/penulis/nomor buku"
            value="<?php echo e(request('q')); ?>"
        >

        <select name="category_id" class="form-control filter-select">
            <option value="">Semua Kategori</option>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option
                    value="<?php echo e($c->id); ?>"
                    <?php if(request('category_id') == $c->id): echo 'selected'; endif; ?>
                >
                    <?php echo e($c->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit" class="btn">Cari</button>
    </form>

    
    <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-solid btn-add">
        + Tambah Buku
    </a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nomor Buku</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($book->book_code); ?></td>

                    <td><?php echo e($book->title); ?></td>

                    <td><?php echo e($book->category->name ?? '-'); ?></td>

                    <td>
                        <span class="badge <?php echo e($book->isAvailable() ? 'badge-available' : 'badge-unavailable'); ?>">
                            <?php echo e($book->stock); ?> unit
                        </span>
                    </td>

                    <td><?php echo e($book->locationShort()); ?></td>

                    <td style="display:flex; gap:8px; flex-wrap:wrap;">
                        <a
                            href="<?php echo e(route('admin.books.edit', $book)); ?>"
                            class="btn"
                            style="padding:6px 14px;"
                        >
                            Ubah
                        </a>

                        <form
                            action="<?php echo e(route('admin.books.destroy', $book)); ?>"
                            method="POST"
                            onsubmit="return confirm('Hapus buku ini?')"
                        >
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">Belum ada data buku.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top:16px;">
        <?php echo e($books->withQueryString()->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/admin/books/index.blade.php ENDPATH**/ ?>