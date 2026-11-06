<?php $__env->startSection("title", "Booking Buku"); ?>
<?php $__env->startSection("content"); ?>
<div class="container" style="padding:48px 24px; max-width:640px;">
    <h2 style="font-size:32px; margin-bottom:8px;">Booking Buku</h2>
    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">Pesan jam pengambilan untuk buku berikut, lalu ambil ke perpustakaan sesuai jadwal.</p>

    <div class="card" style="display:flex; gap:16px; align-items:center; margin-bottom:24px;">
        <div class="book-cover" style="width:70px; height:94px; flex-shrink:0;">
            <?php if($book->cover_url): ?>
               <img src="<?php echo e($book->cover_url); ?>" alt="<?php echo e($book->title); ?>">
            <?php else: ?>
                <span style="font-size:9px; text-align:center; padding:4px; color:var(--ink-soft);"><?php echo e($book->title); ?></span>
            <?php endif; ?>
        </div>
        <div>
            <div style="font-weight:700;"><?php echo e($book->title); ?></div>
            <div class="book-meta"><?php echo e($book->category->name ?? '-'); ?> &middot; <?php echo e($book->author); ?></div>
            <span class="badge badge-available" style="margin-top:6px;">Tersedia (<?php echo e($book->stock); ?> unit)</span>
            <div style="margin-top:8px; font-size:13px;">📍 <strong><?php echo e($book->locationMessage()); ?></strong></div>
        </div>
    </div>

    
    <div class="card" style="background:var(--bone); border-color:var(--accent); margin-bottom:24px;">
        <h3 style="font-size:15px; text-transform:none; letter-spacing:normal; margin-bottom:12px; color:var(--accent);">⚠ Peraturan Booking</h3>
        <ul style="margin:0; padding-left:18px; font-size:13px; line-height:1.8; color:var(--ink-soft);">
            <li>Booking hanya berlaku untuk <strong>hari ini</strong>, jam operasional pengambilan <strong>08.00 &ndash; 15.00 WIB</strong>.</li>
            <li>Kamu <strong>wajib mengambil buku sesuai jadwal</strong> yang dipilih di bawah.</li>
            <li>Jika terlambat <strong>lebih dari 10 menit</strong> dari jam pengambilan, booking akan <strong>dibatalkan otomatis</strong> oleh sistem dan stok buku dikembalikan.</li>
            <li>Satu buku hanya bisa di-booking satu kali dalam satu waktu (nggak bisa dobel booking buku yang sama).</li>
        </ul>
    </div>

    <?php if($errors->any()): ?>
        <div style="background:#f7eae8; border:1px solid var(--unavailable); color:var(--unavailable); padding:12px 16px; font-size:14px; margin-bottom:20px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($e); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('student.booking.store', $book)); ?>" class="card">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Pilih Jam Pengambilan</label>
            <select name="pickup_time" class="form-control" required>
                <option value="">-- Pilih jam --</option>
                <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($slot); ?>" <?php if(old('pickup_time')==$slot): echo 'selected'; endif; ?>><?php echo e($slot); ?> WIB</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <label style="display:flex; gap:10px; align-items:flex-start; font-size:13px; margin-bottom:20px; line-height:1.5;">
            <input type="checkbox" name="agree" value="1" style="margin-top:3px;" <?php if(old('agree')): echo 'checked'; endif; ?> required>
            <span>Saya sudah membaca dan <strong>menyetujui peraturan booking</strong> di atas, termasuk konsekuensi pembatalan otomatis kalau terlambat lebih dari 10 menit.</span>
        </label>

        <button type="submit" class="btn btn-solid" style="width:100%;">Konfirmasi Booking</button>
        <a href="<?php echo e(route('student.catalog.show', $book)); ?>" class="btn" style="width:100%; margin-top:10px; text-align:center;">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/student/booking/create.blade.php ENDPATH**/ ?>