<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">

        <section class="content">

            <?php if(session()->has('message')): ?>

                <p class="alert alert-success"><?php echo e(session('message')); ?></p>

            <?php endif; ?>

            <div class="row">

                <div class="col-sm-12 ">
                    <div class="box box-widget">
                        <div class="box-header with-border">

                            <h2 class="box-title">Bilans d'examens</h2>

                            <a class='col-lg-offset-5 btn btn-success' href="<?php echo e(route('element.create')); ?>">Ajouter
                                nouveau</a>

                        </div>

                        <div class="box-body table-responsive">

                            <table
                                class="table table-responsive table-bordered table-stripped table-hover text-center dataTable "
                                id="t_biologique">

                                <thead>

                                    <tr class="alert alert-info">

                                        <th>Num°</th>
                                        <th>Type Bilan</th>

                                        <th>Type Element</th>

                                        <th>Min </th>

                                        <th>Max </th>

                                        <th>Unité</th>

                                        <th>Sexe</th>

                                        <th>Modifier</th>

                                        <th>Supprimer</th>
                                    </tr>


                                </thead>

                                <tbody>

                                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr>
                                            <th><?php echo e($loop->index + 1); ?></th>
                                            <th><?php echo e($element->bilan); ?></th>

                                            <th><?php echo e($element->element); ?></th>

                                            <th><?php echo e($element->minimum); ?></th>

                                            <th><?php echo e($element->maximum); ?></th>

                                            <th><?php echo e($element->unite); ?></th>

                                            <th>
                                                <?php echo e($element->sexe); ?>

                                            </th>
                                            

                                            <td><a href="<?php echo e(route('element.edit', $element->id)); ?>"><span
                                                        class="glyphicon glyphicon-edit"></span></a></td>

                                            <td>

                                                <form style="display: none;" method="POST"
                                                    action="<?php echo e(route('element.destroy', $element->id)); ?>"
                                                    id="delete-form-<?php echo e($element->id); ?>">
                                                    <?php echo e(csrf_field()); ?>

                                                    <?php echo e(method_field('DELETE')); ?>

                                                </form>

                                                <a href="" onclick="
                  if (confirm('Attention la suppression de lelement va supprimer les informations existante sur le patient , Voulez vous vraiment supprimer cette ligne ?')) {
                  event.preventDefault();
                  document.getElementById('delete-form-<?php echo e($element->id); ?>').submit();										}
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

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\biologie\show.blade.php ENDPATH**/ ?>