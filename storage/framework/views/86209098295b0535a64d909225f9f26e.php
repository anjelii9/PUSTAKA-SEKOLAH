<?php $__env->startSection("title", "Katalog Buku"); ?>
<?php $__env->startSection("content"); ?>
<div class="container" style="padding: 48px 24px;">
    <h2 style="font-size:32px; margin-bottom:20px;">Katalog Buku</h2>

    <form method="GET" style="display:flex; gap:8px; margin-bottom:12px; flex-wrap:wrap;">
        <input type="text" name="q" class="form-control" style="flex:1; min-width:200px;" placeholder="Cari judul, penulis, atau kategori" value="<?php echo e(request('q')); ?>">
        <select name="category_id" class="form-control" style="width:200px;">
            <option value="">Semua Jenis Buku</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($c->id); ?>" <?php if(request('category_id')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn btn-solid">Cari</button>
        <?php if(request('q') || request('category_id')): ?>
            <a href="<?php echo e(route('student.catalog')); ?>" class="btn">Reset</a>
        <?php endif; ?>
    </form>
    <p style="font-size:12px; color:var(--ink-soft); margin-bottom:28px;">Gunakan kotak pencarian untuk judul/penulis, atau pilih dropdown untuk mencari berdasarkan jenis buku (kategori).</p>

    <div class="book-grid reveal-stagger">
        <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="book-card">
                <a href="<?php echo e(route('student.catalog.show', $book)); ?>" style="text-decoration:none; color:inherit; display:block;">
                    <div class="book-cover">
                        <?php if($book->cover_url): ?>
                         <img src="<?php echo e($book->cover_url); ?>" alt="<?php echo e($book->title); ?>">
                        <?php else: ?>
                            <span style="font-family:'Archivo Expanded'; font-size:13px; color:var(--ink-soft); text-align:center; padding:12px;"><?php echo e($book->title); ?></span>
                        <?php endif; ?>
                    </div>
                    <span class="badge <?php echo e($book->isAvailable() ? 'badge-available' : 'badge-unavailable'); ?>">
                        <?php echo e($book->isAvailable() ? 'Tersedia ('.$book->stock.' unit)' : 'Dipinjam Semua'); ?>

                    </span>
                    <div class="book-title"><?php echo e($book->title); ?></div>
                    <div class="book-meta"><?php echo e($book->category->name ?? '-'); ?> &middot; <?php echo e($book->author); ?></div>
                </a>

                <?php if($book->isAvailable()): ?>
                    <a href="<?php echo e(route('student.booking.create', $book)); ?>" class="btn btn-solid" style="display:block; text-align:center; margin-top:8px; font-size:11px; padding:8px 12px;">Booking</a>
                <?php else: ?>
                    <span class="btn" style="display:block; text-align:center; margin-top:8px; font-size:11px; padding:8px 12px; opacity:.5; cursor:not-allowed;">Stok Habis</span>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>Buku tidak ditemukan untuk pencarian ini.</p>
        <?php endif; ?>
    </div>
    <div style="margin-top:24px;"><?php echo e($books->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/student/catalog/index.blade.php ENDPATH**/ ?>