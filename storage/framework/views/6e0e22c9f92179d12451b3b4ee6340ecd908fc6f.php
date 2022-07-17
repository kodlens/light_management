
<?php $__env->startSection('content'); ?>
    <?php if(auth()->guard()->check()): ?>
        <home-page prop-user='<?php echo json_encode($user, 15, 512) ?>'></home-page>
    <?php else: ?>
        <home-page prop-user=''></home-page>
    <?php endif; ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.no-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ACER\Desktop\schoolpass\resources\views/welcome.blade.php ENDPATH**/ ?>