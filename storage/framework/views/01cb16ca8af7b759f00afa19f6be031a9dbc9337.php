

<?php $__env->startSection('content'); ?>
    <dentist-service-patient prop-data='<?php echo json_encode($data, 15, 512) ?>' prop-admit-id=<?php echo e($admitid); ?> prop-tooth-id=<?php echo e($toothid); ?>></dentist-service-patient>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dentist-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\dental_care\resources\views/dentist/dentist-service-patient.blade.php ENDPATH**/ ?>