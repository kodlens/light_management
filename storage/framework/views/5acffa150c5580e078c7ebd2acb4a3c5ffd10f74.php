

<?php $__env->startSection('content'); ?>
    <inv-logs prop-patient-id=<?php echo e($patient); ?> prop-app-id=<?php echo e($appid); ?> prop-service-id=<?php echo e($service); ?>></inv-logs>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dentist-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\dental_care\resources\views/dentist/inv-logs.blade.php ENDPATH**/ ?>