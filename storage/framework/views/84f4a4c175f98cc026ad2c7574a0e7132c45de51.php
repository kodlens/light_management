

<?php $__env->startSection('content'); ?>
    
    <?php if(auth()->guard()->check()): ?>
        <my-appointment prop-services='<?php echo json_encode($services, 15, 512) ?>'></my-appointment>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Github\dental_care\resources\views/my-appointment.blade.php ENDPATH**/ ?>