<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <section class="content">
            <?php if(count($errors) > 0): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="alert alert-danger"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(session()->has('message')): ?>
                <p class="alert alert-success message" style=""><?php echo e(session('message')); ?></p>
            <?php endif; ?>

            <div class="row">

                <div class="col-sm-12 ">
                    <div class="box box-info">


                        <div class="box-header with-border">

                            <h2 class="box-title">Questionnaires</h2>

                            <a class='col-lg-offset-8 btn btn-success' href="<?php echo e(route('questionnaires.create')); ?>">Ajouter
                                nouveau</a>

                        </div>

                        <div class="box-body table-responsive">


                            <table class="table table-responsive table-bordered table-stripped text-center dataTable"
                                id="t_user">

                                <thead>
                                    <tr class="thead-dark">
                                        <th>Num°:</th>
                                        <th>Type</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        

                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>

                                                <td><?php echo e($question->type); ?></td>

                                                <td>
                                                    <a href="<?php echo e(route('questionnaires.edit', $question->id)); ?>"><span
                                                            class="glyphicon glyphicon-edit"></span></a>
                                                </td>

                                                <td>
                                                    <form style="display: none;" method="POST"
                                                        action="<?php echo e(route('questionnaires.destroy', $question->id)); ?>"
                                                        id="delete-form-<?php echo e($question->id); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <?php echo e(method_field('DELETE')); ?>

                                                    </form>

                                                    <a href="" onclick="
                        if (confirm('voulez vous supprimer cette ligne ?')) {
                        event.preventDefault();
                        document.getElementById('delete-form-<?php echo e($question->id); ?>').submit();										}
                       "><span class="glyphicon glyphicon-trash"></span></a>
                                                </td>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
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

            $('#t_biologique').DataTable();


        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\questionnaire\show.blade.php ENDPATH**/ ?>