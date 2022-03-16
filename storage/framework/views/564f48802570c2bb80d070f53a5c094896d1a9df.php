<?php $__env->startSection('title'); ?> Utilisateurs Internes <?php $__env->stopSection(); ?>
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

                            <h2 class="box-title">Utilisateurs</h2>

                            <a class='col-lg-offset-8 btn btn-success' href="<?php echo e(route('user.create')); ?>">Ajouter
                                nouveau</a>

                        </div>

                        <div class="box-body table-responsive">


                            <table class="table table-responsive table-bordered table-stripped text-center nowrap"
                                id="t_user">

                                <thead>
                                    <tr class="bg-gray">
                                        
                                        <th>Num°:</th>
                                        <th>Utilisateur</th>
                                        <th>Email</th>
                                        <th>Service</th>
                                        <th>Grade</th>
                                        <th>Spécialité</th>
                                        <th>Profile</th>
                                        <th>Avant Dernière connexion</th>
                                        <th>Dernière connexion</th>
                                        <th>status</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        

                                        <tr>
                                            
                                            <td><?php echo e($loop->index + 1); ?></td>

                                            <td><?php echo e($user->name); ?> <?php echo e($user->prenom); ?></td>

                                            <td><?php echo e($user->email); ?></td>

                                            <td><?php echo e($user->service); ?></td>

                                            <td><?php echo e($user->grade); ?></td>

                                            <td><?php echo e($user->specialite); ?></td>

                                            <td><?php echo e($user->role['nom_profile']); ?></td>
                                            <td><?php echo e($user->last_login); ?></td>
                                            <td><?php echo e($user->current_login); ?></td>
                                            <td><?php echo $user->connected == 'true'
                                                ? "<span class='badge bg-green'><i class='fa fa-wifi mr-2'></i>En
                                                    ligne</span>"
                                                : "<span class='badge bg-red'><i class='fa fa-sign-out-alt mr-2'></i>Hors
                                                    ligne</span>"; ?></td>

                                            <td>
                                                <a href="<?php echo e(route('user.edit', $user->id)); ?>"><span
                                                        class="glyphicon glyphicon-edit"></span></a>
                                            </td>

                                            <td>
                                                <form style="display: none;" method="POST"
                                                    action="<?php echo e(route('user.destroy', $user->id)); ?>"
                                                    id="delete-form-<?php echo e($user->id); ?>">
                                                    <?php echo e(csrf_field()); ?>

                                                    <?php echo e(method_field('DELETE')); ?>

                                                </form>

                                                <a href="" onclick="
                                    if (confirm('ATTENTION! Si vous supprimer cet utilisateur tout les données qui sont liées seront à leur suite supprimer. Ete vous sur de supprimer l\'utilisateur ?')) {
                                    event.preventDefault();
                                    document.getElementById('delete-form-<?php echo e($user->id); ?>').submit();										}
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

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\user\show.blade.php ENDPATH**/ ?>