

<?php $__env->startSection('content'); ?>
    <services-log prop-patient-id=<?php echo e($patient); ?> prop-app-id=<?php echo e($appid); ?>></services-log>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dentist-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\dental_care\resources\views/dentist/services-log.blade.php ENDPATH**/ ?>