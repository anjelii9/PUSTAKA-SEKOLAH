<?php $__env->startSection('title', 'Ubah Buku'); ?>

<?php $__env->startSection('content'); ?>
<form
    method="POST"
    action="<?php echo e(route('admin.books.update', $book)); ?>"
    enctype="multipart/form-data"
    class="card"
    style="max-width:640px;"
>
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <?php echo $__env->make('admin.books._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <button type="submit" class="btn btn-solid">
        Simpan Perubahan
    </button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/admin/books/edit.blade.php ENDPATH**/ ?>