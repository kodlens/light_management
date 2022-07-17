

<?php $__env->startSection('content'); ?>
    <appointment prop-services='<?php echo json_encode($services, 15, 512) ?>'></appointment>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\dental_care\resources\views/administrator/appointment.blade.php ENDPATH**/ ?>