

<?php $__env->startSection('content'); ?>



    <div class="section">
        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <button class="button is-info" onclick="history.back()">BACK</button>
                </div>
                <div class="printarea">
                    <table class="table">
                        <thead>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Item Type</th>
                        <th>Quantity</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->item_id); ?></td>
                                <td><?php echo e($item->item_name); ?></td>
                                <td><?php echo e($item->item_type); ?></td>
                                <td><?php echo e($item->qty); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.print-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\dental_care\resources\views/administrator/report/report-inventory.blade.php ENDPATH**/ ?>