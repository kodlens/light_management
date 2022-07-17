

<?php $__env->startSection('content'); ?>
    <dentist-appointment prop-services='<?php echo json_encode($services, 15, 512) ?>'></dentist-appointment>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dentist-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\dental_care\resources\views/dentist/dentist-appointment.blade.php ENDPATH**/ ?>