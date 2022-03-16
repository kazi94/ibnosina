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

                            <h3 class="box-title">Ajouter utilisateur</h3>

                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" autocomplete="off" method="POST"
                                action="<?php echo e(route('user.store')); ?>">
                                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="hopital" value="CHU Tlemcen">
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="matricule" class="label-control"> Matricule*

                                            <input type="text" class="form-control" name="matricule" id="matricule"
                                                placeholder="matricule" required>

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="nom" class="label-control"> Nom*

                                            <input type="text" class="form-control" name="name" id="nom" placeholder="nom"
                                                required />

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="prénom" class="label-control"> Prénom*

                                            <input type="text" class="form-control" name="prenom" id="prénom"
                                                placeholder="prénom" required />

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="date_naissance" class="label-control"> Date de naissance

                                            <input type="date" class="form-control" name="date_naissance"
                                                id="date_naissance" placeholder="date_naissance" style="width: 214px;">

                                        </label>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="email" class="label-control"> Email*

                                            <input type="email" class="form-control" autocomplete="off" name="email"
                                                id="email" placeholder="Ex : '@'email.com" required />

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="password" class="label-control"> Mots de passe*

                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Mots de passe" required autocomplete="off" />

                                        </label>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="service" class="label-control col-sm-3"> Service</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="service">
                                            <option value="Maladies infectieuses">Maladies infectieuses</option>
                                            <option value="Pneumologie">Pneumologie</option>
                                            <option value="Hématologie">Hématologie</option>
                                            <option value="Médecine Interne">Médecine Interne</option>
                                            <option value="Bloc 470">Bloc 470</option>
                                            <option value="Réanimation Covid">Réanimation Covid</option>
                                            <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie
                                            </option>
                                            <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                            <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid
                                            </option>
                                            <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="specialite" class="label-control col-sm-3"> Spécialité</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="specialite">
                                            <option value="Pharmacologue">Pharmacologue</option>
                                            <option value="Pharmacognoste">Pharmacognoste</option>
                                            <option value="Galésite">Galésite</option>
                                            <option value="Infectiologue">Infectiologue</option>
                                            <option value="Pneumologue">Pneumologue</option>
                                            <option value="Microbiologiste">Microbiologiste</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="grade" class="label-control col-sm-3"> Grade</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="grade">
                                            <option value="Maître Assistant">Maître Assistant</option>
                                            <option value="Maître de Conférences grade B">Maître de Conférences grade B
                                            </option>
                                            <option value="Maître de Conférences grade A">Maître de Conférences grade A
                                            </option>
                                            <option value="Médecin Assistant">Médecin Assistant</option>
                                            <option value="Résident">Résident</option>
                                            <option value="Professeur">Professeur</option>
                                            <option value="Assistant">Assistant</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="role" class="label-control col-sm-3"> Role</label>
                                    <div class="col-sm-9">
                                        <select name="role_id" id="role" class="form-control">
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($role->id); ?>"><?php echo e($role->nom_profile); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="role" class="label-control col-sm-3"></label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" name="admin" class="flat-red"> Administrateur
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info pull-right">Ajouter</button>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views/admin/user/create.blade.php ENDPATH**/ ?>