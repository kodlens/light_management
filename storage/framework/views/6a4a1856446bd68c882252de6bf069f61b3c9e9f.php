

<?php $__env->startSection('content'); ?>

    <div class="section">
        <div class="printarea">
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Appointment</th>
                    <th>Dentist Name</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->appointment_id); ?></td>
                            <td><?php echo e($item->user_lname); ?>, <?php echo e($item->user_fname); ?> <?php echo e($item->user_mname); ?></td>
                            <td><?php echo e($item->appoint_date); ?>, <?php echo e($item->appoint_time); ?> <?php echo e($item->user_mname); ?></td>
                            <td><?php echo e($item->dentist_lname); ?>, <?php echo e($item->dentist_fname); ?> <?php echo e($item->dentist_mname); ?></td>
                            <td>
                                <?php if($item->appoint_status == 0): ?>
                                    PENDING
                                <?php elseif($item->appoint_status == 1): ?>
                                    ADMITTED
                                <?php else: ?>
                                    CANCELLED
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.print-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\dental_care\resources\views/administrator/report/print/print-appointment.blade.php ENDPATH**/ ?>