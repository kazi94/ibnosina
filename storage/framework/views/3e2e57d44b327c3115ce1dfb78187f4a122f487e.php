<?php $__env->startSection('script_css'); ?>
<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="/css/home.css">
<?php $__env->startSection('title'); ?>
    Mon Armoire Pharmaceutique
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h2>Mon Armoire Pharmaceutique</h2>
    </section>
    <section class="content">
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="<?php echo e(route('intervention.show')); ?>" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <?php if($countAnal): ?>
                                <span class='label label-danger'
                                    style="position: absolute;top: 4px;right: 5px;text-align: center;font-size: 19px;padding: 2px 3px;line-height: .9;">
                                    <?php echo e($countAnal); ?>

                                </span>
                            <?php endif; ?>
                            <i class="bg-yellow fa fa-5x fa-exclamation-triangle icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES PRESCRIPTIONS A ANALYSER
                            </h5>
                            Gérez les prescriptions à risque pour analyse.<br /><br />

                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="<?php echo e(route('intervention.history')); ?>" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-gray-active fa fa-5x fa-history icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES PRESCRIPTIONS ANALYSÉES
                            </h5>
                            Historique des prescriptions analysé par le Pharmacien.

                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="<?php echo e(route('education.todo')); ?>" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-aqua-active fa fa-5x fa-chalkboard-teacher icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES ÉDUCATIONS THÉRAPTEUTIQUE
                            </h5>
                            Gérez les éducations thérapeutique effectuées sur le patient.

                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="<?php echo e(route('questionnaire.show', Auth::user()->id)); ?>" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-love-kiss fa fa-5x fa-question-circle icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES OBSERVANCES
                            </h5>
                            Gérez les observances faite par le Pharmacien.

                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="<?php echo e(route('pharmaco.index')); ?>" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-asteroid fa fa-5x fa-file-alt icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">PHARMACOVIGILANCE FORMULAIRE
                            </h5>
                            Rédiger un formulaire de pharmacovigilance.

                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="<?php echo e(route('liste1')); ?>" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-blue-active fa fa-5x fa-sa fa-save icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">PHARMACOVIGILANCES ENREGISTRÉES
                            </h5>
                            Gérer les pharmacovigilances enregistrées.

                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="<?php echo e(route('liste2')); ?>" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-grow-early fa fa-5x fa-file-export icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">PHARMACOVIGILANCES ENVOYÉES
                            </h5>
                            Gérer les pharmacovigilances envoyées.

                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views/user/pharmacien/show.blade.php ENDPATH**/ ?>