<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <?php if(count($errors) > 0): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="alert alert-danger"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(session()->has('message')): ?>
                <p class="alert alert-success" id="message" style="display: none;"><?php echo e(session('message')); ?></p>
            <?php endif; ?>
            <div class="">
                <a href="<?php echo e(route('intervention.show')); ?>"><button type="button" class="btn btn-info btn-sm"
                        data-toggle="tooltip" title="Afficher Liste"><i class="fa fa-list"></i></button></a>
                <a href=""><button type="button" class="btn btn-info btn-sm" data-toggle="tooltip"
                        title="Afficher Tableau de bords"><i class=" fa-grip-horizontal"></i></button></a>
            </div>
            <h2 class="box-title">Interventions pharmaceutique</h2>
        </section>

        <section class="content">
            <div class="row">
                <div class="box box-body">
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $patient->prescriptionsRisque; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr_risque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- ./col -->
                            <div class="col-xs-3">

                                <div class="small-box" style="hover:text-decoration: none;">

                                    <div class="inner">
                                        <h4><?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?></h4>
                                        <i class="fa fa-info bg-blue pull-right"
                                            style="position: relative; bottom: 47px; right:0px;  width: 20px;line-height: 20px;color: #666;background: #d2d6de;border-radius: 50%;text-align: center;"
                                            title="C1 / L3"></i>

                                        <p>Dr.<?php echo e($pr_risque->prescripteur->name); ?> <?php echo e($pr_risque->prescripteur->prenom); ?> ,
                                            <?php if(isset($patient->hospi->service)): ?>
                                                <?php echo e($patient->hospi->service); ?>

                                            <?php endif; ?>
                                            <small></small>
                                        </p>

                                        <small> Le <?php echo e($pr_risque->date_prescription); ?></small>
                                        <span class="label label-danger">A analyser !</span><br />

                                    </div>
                                    <div class="icon">
                                        <img class="img-circle" style="width: 60px" src="/images/user.jpg"
                                            alt="User Avatar">
                                    </div>
                                    <div class="pull-le" style="text-align: center"><b>Chambre
                                            <?php echo e($patient->hospi['chambre']); ?>

                                            <?php if(isset($patient->hospi->lit)): ?> /Lit
                                                <?php echo e($patient->hospi->lit); ?>

                                            <?php endif; ?>
                                        </b></div> <br />
                                    <a href="<?php echo e(route('patient.intervenir', [$patient->id, $pr_risque->id])); ?>"
                                        class="small-box-footer bg-red">Plus d'infos <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\pharmacien\intervention\intervention_pharmaceutique_2.blade.php ENDPATH**/ ?>