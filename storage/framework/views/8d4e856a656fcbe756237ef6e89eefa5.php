<?php if($paginator->hasPages()): ?>
    <nav style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;" aria-label="Navigasi halaman">

        
        <?php if($paginator->onFirstPage()): ?>
            <span class="btn" style="opacity:.4; cursor:not-allowed; padding:8px 14px; font-size:13px;">&laquo; Sebelumnya</span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="btn" style="padding:8px 14px; font-size:13px;" rel="prev">&laquo; Sebelumnya</a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span class="btn" style="padding:8px 14px; font-size:13px; opacity:.5; cursor:default;"><?php echo e($element); ?></span>
            <?php endif; ?>

            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span class="btn btn-solid" style="padding:8px 14px; font-size:13px;" aria-current="page"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" class="btn" style="padding:8px 14px; font-size:13px;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="btn" style="padding:8px 14px; font-size:13px;" rel="next">Selanjutnya &raquo;</a>
        <?php else: ?>
            <span class="btn" style="opacity:.4; cursor:not-allowed; padding:8px 14px; font-size:13px;">Selanjutnya &raquo;</span>
        <?php endif; ?>

    </nav>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>