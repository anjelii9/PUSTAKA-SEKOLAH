<?php $__env->startSection("title", $book->title); ?>
<?php $__env->startSection("content"); ?>
<div class="container" style="padding: 48px 24px; display:flex; gap:40px; flex-wrap:wrap;">
    <div class="book-cover" style="width:280px; flex-shrink:0;">
        <?php if($book->cover): ?>
            <img src="<?php echo e(asset("storage/".$book->cover)); ?>" alt="<?php echo e($book->title); ?>">
        <?php else: ?>
            <span style="padding:20px; text-align:center; font-family:"Archivo Expanded";"><?php echo e($book->title); ?></span>
        <?php endif; ?>
    </div>
    <div style="flex:1; min-width:280px;">
        <span class="badge <?php echo e($book->isAvailable() ? "badge-available" : "badge-unavailable"); ?>">
            <?php echo e($book->isAvailable() ? "Tersedia" : "Dipinjam Semua"); ?>

        </span>
        <h1 style="font-size:34px; margin-top:12px;"><?php echo e($book->title); ?></h1>
        <p style="color:var(--ink-soft); margin-top:6px;"><?php echo e($book->author); ?> &middot; <?php echo e($book->publisher); ?> &middot; <?php echo e($book->year); ?></p>
        <p style="margin-top:6px; font-size:13px; text-transform:uppercase; letter-spacing:.04em;">Kategori: <?php echo e($book->category->name ?? "-"); ?></p>
        <p style="margin-top:6px; font-size:13px;">Nomor Buku: <?php echo e($book->book_code); ?> &middot; Stok: <?php echo e($book->stock); ?></p>
        <p style="margin-top:20px; line-height:1.6;"><?php echo e($book->description); ?></p>
        <p style="margin-top:20px; font-size:13px; color:var(--ink-soft);">Untuk meminjam buku ini, silakan datang ke perpustakaan dan sampaikan nomor buku kepada petugas.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/student/catalog/show.blade.php ENDPATH**/ ?>