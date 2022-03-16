<?php $__env->startSection('title'); ?> Utilisateurs Internes <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">


        <section class="content">

            <div class="row">

                <div class="col-sm-12 ">
                    <div class="box box-info">


                        <div class="box-header with-border">

                            <h2 class="box-title">
                                <h1>Log Activity Lists</h1>
                            </h2>

                        </div>

                        <div class="box-body table-responsive">


                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Subject</th>
                                    <th>URL</th>
                                    <th>Method</th>
                                    <th>Ip</th>
                                    <th width="300px">User Agent</th>
                                    <th>User Id</th>
                                    <th>Action</th>
                                </tr>
                                <?php if($logs->count()): ?>
                                    <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(++$key); ?></td>
                                            <td><?php echo e($log->subject); ?></td>
                                            <td class="text-success"><?php echo e($log->url); ?></td>
                                            <td><label class="label label-info"><?php echo e($log->method); ?></label></td>
                                            <td class="text-warning"><?php echo e($log->ip); ?></td>
                                            <td class="text-danger"><?php echo e($log->agent); ?></td>
                                            <td><a href="<?php echo e(route('user.edit', ['id' => $log->user_id])); ?>">
                                                    <?php echo e($log->user_id); ?></a></td>
                                            <td><button class="btn btn-danger btn-sm">Delete</button></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </section>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(function() {
            $('#t_user').DataTable({
                "order": [
                    [8, "desc"]
                ],
                buttons: [
                    'colvis',
                    'excel',
                    'print'
                ]
            });

            $('#select_all').on('click', function() {
                if (this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\logs\show.blade.php ENDPATH**/ ?>