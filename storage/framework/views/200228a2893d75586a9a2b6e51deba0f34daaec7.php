<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<?php $__env->startSection('title'); ?>
    Ajouter un nouveau Patient
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row col-md-offset-2">
            <div class="col-md-3" style="cursor: pointer;">
                <a href="<?php echo e(route('patient.create.step.one.get', ['type' => 'consultation'])); ?>" class="text-black">
                    <div class="mb-3 text-center card card-body">

                        <i class="bg-happy-green fa fa-5x fa-notes-medical icon-gradient mb-2">
                        </i>

                        <h5 class="card-title">Consultation Rapide
                        </h5>

                    </div>
                </a>


            </div>
            <div class="col-md-3" style="cursor: pointer;">
                <a href="<?php echo e(route('patient.create.step.one.get', ['type' => 'hospitalisation'])); ?>"
                    class="text-black">
                    <div class="mb-3 text-center card card-body card-patient">

                        <i class="bg-happy-itmeo fa fa-5x fa-hospital-user icon-gradient mb-2">
                        </i>

                        <h5 class="card-title">Hospitalisation
                        </h5>

                    </div>
                </a>
            </div>
            <div class="col-md-3" style="cursor: pointer;">
                <a href="<?php echo e(route('patient.create.step.one.get', ['type' => 'normal'])); ?>" class="text-black">
                    <div class="mb-3 text-center card card-body">

                        <i class="bg-happy-fisher fa fa-5x fa-user-plus icon-gradient mb-2">
                        </i>

                        <h5 class="card-title">Ajouter Patient
                        </h5>

                    </div>
                </a>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\create.blade.php ENDPATH**/ ?>