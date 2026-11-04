
<?php $__currentLoopData = $bookings->where("status", "menunggu"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aktif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div style="background:#fff8e6; border:1px solid #d9a400; color:#7a5c00; padding:16px 20px; border-radius:6px; margin-bottom:16px; display:flex; gap:12px; align-items:flex-start;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        <div>
            <div style="font-weight:700; text-transform:uppercase; font-size:13px; letter-spacing:.03em;">Lokasi Buku Yang Kamu Booking</div>
            <div style="font-size:14px; margin-top:4px;">
                "<strong><?php echo e($aktif->book->title ?? '-'); ?></strong>" &mdash; <strong><?php echo e($aktif->book ? $aktif->book->locationMessage() : '-'); ?></strong>.
                Ambil jam <strong><?php echo e(substr($aktif->pickup_time, 0, 5)); ?> WIB</strong>
                (batas <?php echo e($aktif->deadline()->format("H:i")); ?> WIB), kode booking <strong><?php echo e($aktif->booking_code); ?></strong>.
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__currentLoopData = $bookingNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($notif->status === 'dikonfirmasi'): ?>
        <div style="background:#eaf3ec; border:1px solid var(--available); color:var(--available); padding:16px 20px; border-radius:6px; margin-bottom:16px; display:flex; gap:12px; align-items:flex-start;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="M20 6 9 17l-5-5"/></svg>
            <div>
                <div style="font-weight:700; text-transform:uppercase; font-size:13px; letter-spacing:.03em;">Booking Dikonfirmasi</div>
                <div style="font-size:14px; margin-top:4px;">Booking <strong><?php echo e($notif->booking_code); ?></strong> untuk buku "<strong><?php echo e($notif->book->title ?? '-'); ?></strong>" sudah dikonfirmasi petugas. Buku resmi dipinjamkan, cek jatuh tempo di riwayat peminjaman ya!</div>
            </div>
        </div>
    <?php else: ?>
        <div style="background:#f7eae8; border:1px solid var(--unavailable); color:var(--unavailable); padding:16px 20px; border-radius:6px; margin-bottom:16px; display:flex; gap:12px; align-items:flex-start;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            <div>
                <div style="font-weight:700; text-transform:uppercase; font-size:13px; letter-spacing:.03em;">Booking Dibatalkan</div>
                <div style="font-size:14px; margin-top:4px;">Booking <strong><?php echo e($notif->booking_code); ?></strong> untuk buku "<strong><?php echo e($notif->book->title ?? '-'); ?></strong>" dibatalkan otomatis karena melewati batas 10 menit jam pengambilan.</div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if($bookings->isNotEmpty()): ?>
    <div class="card" style="margin-bottom:28px;">
        <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:16px;">Booking Saya</h3>
        <table class="data-table table-stack">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Lokasi</th>
                    <th>Tgl</th>
                    <th>Jam Ambil</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td data-label="Buku"><?php echo e($b->book->title ?? '-'); ?></td>
                    <td data-label="Lokasi"><?php echo e($b->book ? $b->book->locationShort() : '-'); ?></td>
                    <td data-label="Tgl"><?php echo e($b->booking_date->format('d-m-Y')); ?></td>
                    <td data-label="Jam Ambil"><?php echo e(substr($b->pickup_time, 0, 5)); ?> WIB</td>
                    <td data-label="Status">
                        <span class="badge <?php echo e($b->status === 'dikonfirmasi' ? 'badge-available' : ($b->status === 'dibatalkan' ? 'badge-unavailable' : 'badge-late')); ?>">
                            <?php echo e(ucfirst($b->status)); ?>

                        </span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/student/profile/_booking-notifications.blade.php ENDPATH**/ ?>