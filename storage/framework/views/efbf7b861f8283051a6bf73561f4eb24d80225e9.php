<?php $__env->startSection('content'); ?>
    <?php if(auth()->guard()->check()): ?>
        <navbar-menu prop-is-auth="1"></navbar-menu>
        <welcome prop-is-auth="1"></welcome>
    <?php else: ?>

        <navbar-menu prop-is-auth="0"></navbar-menu>
        <welcome prop-is-auth="0"></welcome>
    <?php endif; ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.no-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\training_reservation\resources\views/welcome.blade.php ENDPATH**/ ?>