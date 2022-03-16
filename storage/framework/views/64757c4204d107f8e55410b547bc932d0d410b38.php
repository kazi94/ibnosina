<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <section class="content">
            <?php if(count($errors) > 0): ?>

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <p class="alert alert-danger"><?php echo e($error); ?></p>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>

            <?php if(session()->has('message')): ?>

                <p class="alert alert-success"><?php echo e(session('message')); ?></p>

            <?php endif; ?>
            <div class="row">

                <div class="col-md-6 col-sm-offset-2">

                    <!-- Horizontal Form -->
                    <div class="box box-info">

                        <div class="box-header with-border">

                            <h3 class="box-title">Modifier utilisateur</h3>

                        </div>
                        <!-- /.box-header -->

                        <!-- form start -->

                        <div class="box-body">
                            <form class="form-horizontal" role="form" method="POST"
                                action="<?php echo e(route('user.update', $user->id)); ?>">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('PATCH')); ?>


                                <div class="form-group">
                                    <label for="matricule" class="label-control col-xs-3"> Matricule*</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="matricule" id="matricule"
                                            placeholder="matricule" value="<?php echo e($user->matricule); ?>" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Nom" class="label-control col-xs-3"> Nom*</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="name" id="nom" placeholder="nom"
                                            value="<?php echo e($user->name); ?>" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Prénom" class="label-control col-xs-3"> Prénom*</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="prenom" id="prenom"
                                            placeholder="prénom" value="<?php echo e($user->prenom); ?>" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="matricule" class="label-control col-xs-3"> Date de Naissance</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" name="date_naissance" id="date_naissance"
                                            placeholder="date_naissance" value="<?php echo e($user->date_naissance); ?>">
                                    </div>
                                </div>
                                <?php if(isset($roles)): ?>
                                    <div class="form-group">
                                        <label for="matricule" class="label-control col-xs-3"> Email*</label>
                                        <div class="col-xs-9">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="email"
                                                value="<?php echo e($user->email); ?>" autocomplete="off" required />
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="matricule" class="label-control col-xs-3"> Mots de Passe*</label>
                                    <div class="col-xs-8">
                                        <input type="password" class="form-control" name="password" id="pass"
                                            placeholder="Mots de passe" autocomplete="off" required />

                                    </div>
                                    <div class="col-xs-1 no-padding">
                                        <i class="fa fa-eye fa-1x mt-2 text-success" id="showMdp"
                                            style="cursor: pointer"></i>
                                    </div>
                                </div>
                                <?php if(isset($roles)): ?>
                                    <div class="form-group">

                                        <label for="service" class="label-control col-sm-3"> Service</label>
                                        <div class="col-sm-9">
                                            <select class="form form-control" name="service">
                                                <option value="Maladies infectieuses"
                                                    <?php echo e($user->Service == 'Maladies infectieuses' ? 'selected' : ''); ?>>Maladies
                                                    infectieuses</option>
                                                <option value="Pneumologie"
                                                    <?php echo e($user->Service == 'Pneumologie' ? 'selected' : ''); ?>>Pneumologie</option>
                                                <option value="Bloc 470" <?php echo e($user->Service == 'Bloc 470' ? 'selected' : ''); ?>>
                                                    Bloc 470</option>
                                                <option value="Réanimation Covid"
                                                    <?php echo e($user->Service == 'Réanimation Covid' ? 'selected' : ''); ?>>Réanimation
                                                    Covid</option>
                                                <option value="Laboratoire de Pharmacologie"
                                                    <?php echo e($user->Service == 'Laboratoire de Pharmacologie' ? 'selected' : ''); ?>>
                                                    Laboratoire de Pharmacologie</option>
                                                <option value="Pharmacie Centrale"
                                                    <?php echo e($user->Service == 'Pharmacie Centrale' ? 'selected' : ''); ?>>Pharmacie
                                                    Centrale</option>
                                                <option value="Laboratoire de Biologie Covid"
                                                    <?php echo e($user->Service == 'Laboratoire de Biologie Covid' ? 'selected' : ''); ?>>
                                                    Laboratoire de Biologie Covid</option>
                                                <option value="Laboratoire de Microbiologie"
                                                    <?php echo e($user->Service == 'Laboratoire de Microbiologie' ? 'selected' : ''); ?>>
                                                    Laboratoire de Microbiologie</option>
                                                <option value="Hématologie"
                                                    <?php echo e($user->Service == 'Hématologie' ? 'selected' : ''); ?>>Hématologie</option>
                                                <option value="Médecine Interne"
                                                    <?php echo e($user->Service == 'Médecine Interne' ? 'selected' : ''); ?>>Médecine
                                                    Interne</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">

                                    <label for="specialite" class="label-control col-sm-3"> Spécialité</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="specialite">
                                            <option value="Pharmacologue"
                                                <?php echo e($user->specialite == 'Pharmacologue' ? 'selected' : ''); ?>>Pharmacologue
                                            </option>
                                            <option value="Pharmacognoste"
                                                <?php echo e($user->specialite == 'Pharmacognoste' ? 'selected' : ''); ?>>Pharmacognoste
                                            </option>
                                            <option value="Galésite"
                                                <?php echo e($user->specialite == 'Galésite' ? 'selected' : ''); ?>>Galésite</option>
                                            <option value="Infectiologue"
                                                <?php echo e($user->specialite == 'Infectiologue' ? 'selected' : ''); ?>>Infectiologue
                                            </option>
                                            <option value="Pneumologue"
                                                <?php echo e($user->specialite == 'Pneumologue' ? 'selected' : ''); ?>>Pneumologue
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="grade" class="label-control col-sm-3"> Grade</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="grade">
                                            <option value="Maître Assistant"
                                                <?php echo e($user->grade == 'Maître Assistant' ? 'selected' : ''); ?>>Maître Assistant
                                            </option>
                                            <option value="Maître de Conférences grade B"
                                                <?php echo e($user->grade == 'Maître de Conférences grade B' ? 'selected' : ''); ?>>
                                                Maître de Conférences grade B</option>
                                            <option value="Maître de Conférences grade A"
                                                <?php echo e($user->grade == 'Maître de Conférences grade A' ? 'selected' : ''); ?>>
                                                Maître de Conférences grade A</option>
                                            <option value="Médecin Assistant"
                                                <?php echo e($user->grade == 'Médecin Assistant' ? 'selected' : ''); ?>>Médecin
                                                Assistant</option>
                                            <option value="Résident" <?php echo e($user->grade == 'Résident' ? 'selected' : ''); ?>>
                                                Résident</option>
                                            <option value="Professeur" <?php echo e($user->grade == 'Professeur' ? 'selected' : ''); ?>>
                                                Professeur</option>
                                            <option value="Assistant" <?php echo e($user->grade == 'Assistant' ? 'selected' : ''); ?>>
                                                Assistant</option>

                                        </select>
                                    </div>
                                </div>
                                <?php if(isset($roles)): ?>
                                    <div class="form-group">

                                        <label for="role" class="label-control col-sm-3"> Role</label>
                                        <div class="col-sm-9">
                                            <select name="role_id" id="role" class="form-control">
                                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($role->id); ?>"
                                                        <?php echo e($user->role_id == $role->id ? 'selected' : ''); ?>>
                                                        <?php echo e($role->nom_profile); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($roles)): ?>
                                    <div class="form-group">

                                        <label for="role" class="label-control col-sm-3"></label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="admin" class="flat-red" <?php if($user->is_admin === 'on'): ?> checked <?php endif; ?>
                                            > Administrateur
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-info pull-right">Modifier</button>
                            </form>

                        </div>
                        <!-- /.box-body -->

                    </div>

                </div>

            </div>

        </section>


    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(function() {
            $("#showMdp").on('click', function() {
                if ($("#pass").attr('type') == 'password') {
                    $("#pass").attr('type', 'text');
                } else {
                    $("#pass").attr('type', 'password');
                }
            })
        });

    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\user\edit.blade.php ENDPATH**/ ?>