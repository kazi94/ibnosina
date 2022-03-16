<?php $__env->startSection('script_css'); ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery-smartwizard-master/dist/css/smart_wizard_all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery-smartwizard-master/dist/css/smart_wizard_dots.min.css')); ?>">
<?php $__env->startSection('title'); ?>
    Dossier Patient - <?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?>

<?php $__env->stopSection(); ?>

<style>
    /* Propeller css for Floating Action Button*/
    .pmd-floating-action {
        bottom: 0;
        position: fixed;
        margin: 1em;
        right: 0;
    }

    .pmd-floating-action-btn {
        display: block;
        position: relative;
        transition: all .2s ease-out;
    }

    .pmd-floating-action-btn:before {
        bottom: 10%;
        content: attr(data-title);
        opacity: 0;
        position: absolute;
        right: 100%;
        transition: all .2s ease-out .5s;
        white-space: nowrap;
        background-color: #fff;
        padding: 6px 12px;
        border-radius: 2px;
        color: #333;
        font-size: 12px;
        margin-right: 5px;
        display: inline-block;
        box-shadow: 0px 2px 3px -2px rgba(0, 0, 0, 0.18), 0px 2px 2px -7px rgba(0, 0, 0, 0.15);
    }

    .pmd-floating-action-btn:last-child:before {
        font-size: 14px;
        bottom: 25%;
    }

    .pmd-floating-action-btn:active,
    .pmd-floating-action-btn:focus,
    .pmd-floating-action-btn:hover {
        box-shadow: 0px 5px 11px -2px rgba(0, 0, 0, 0.18), 0px 4px 12px -7px rgba(0, 0, 0, 0.15);
    }

    .pmd-floating-action-btn:not(:last-child) {
        opacity: 0;
        -ms-transform: translateY(20px) scale(0.3);
        transform: translateY(20px) scale(0.3);
        margin-bottom: 15px;
        margin-left: 8px;
        position: absolute;
        bottom: 0;
    }

    .pmd-floating-action-btn:not(:last-child):nth-last-child(1) {
        transition-delay: 50ms;
    }

    .pmd-floating-action-btn:not(:last-child):nth-last-child(2) {
        transition-delay: 100ms;
    }

    .pmd-floating-action-btn:not(:last-child):nth-last-child(3) {
        transition-delay: 150ms;
    }

    .pmd-floating-action-btn:not(:last-child):nth-last-child(4) {
        transition-delay: 200ms;
    }

    .pmd-floating-action-btn:not(:last-child):nth-last-child(5) {
        transition-delay: 250ms;
    }

    .pmd-floating-action-btn:not(:last-child):nth-last-child(6) {
        transition-delay: 300ms;
    }

    .pmd-floating-action:hover .pmd-floating-action-btn,
    .menu--floating--open .pmd-floating-action-btn {
        opacity: 1;
        -ms-transform: none;
        transform: none;
        position: relative;
        bottom: auto;
    }

    .pmd-floating-action:hover .pmd-floating-action-btn:before,
    .menu--floating--open .pmd-floating-action-btn:before {
        opacity: 1;
    }

    .pmd-floating-hidden {
        display: none;
    }

    .pmd-floating-action-btn.btn:hover {
        overflow: visible;
    }

    .pmd-floating-action-btn .ink {
        width: 50px;
        height: 50px;
    }

</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<!-- Floating Action Button like Google Material -->
<div class="menu pmd-floating-action d-md-none" role="navigation">

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.module', Auth::user())): ?>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_prescription"
            class="pmd-floating-action-btn btn btn-sm pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-default"
            data-title="Prescription">
            <span class="pmd-floating-hidden">Prescription</span>
            <i class="fa fa-plus"></i>
        </a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.module', Auth::user())): ?>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_consultation"
            class="bg-blue pmd-floating-action-btn btn btn-sm pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-default"
            data-title="Consultation">
            <span class="pmd-floating-hidden">Consultation</span>
            <i class="fa fa-pencil"></i>
        </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.module', Auth::user())): ?>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_hospitalisation"
            class="bg-yellow pmd-floating-action-btn btn btn-sm pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-default"
            data-title="Hospitalisation">
            <span class="pmd-floating-hidden">Hospitalisation</span>
            <i class="fa fa-ambulance"></i>
        </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.module', Auth::user())): ?>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_phyto"
            class="bg-green pmd-floating-action-btn btn btn-sm pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-default"
            data-title="Phytothérapeute">
            <span class="pmd-floating-hidden">Phytothérapeute</span>
            <i class="fa fa-envira"></i>
        </a>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('traitements_chronique.module', Auth::user())): ?>
        <a href="javascript:void(0);" data-toggle="modal"
            onclick='$("#modalPrescriptionVille form").attr("action", "<?php echo e(route('traitement_chronique.store')); ?>");'
            data-target="#modalPrescriptionVille"
            class="bg-navy pmd-floating-action-btn btn btn-sm pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-default"
            data-title="Traitement Chronique">
            <span class="pmd-floating-hidden">Traitement Chronique</span>
            <i class="fa fa-medkit"></i>
        </a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.module', Auth::user())): ?>
        <a href="javascript:void(0);"
            onclick='$("#modalPrescriptionVille form").attr("action", "<?php echo e(route('automedication.store')); ?>");'
            data-toggle="modal" data-target="#modalPrescriptionVille"
            class="bg-red pmd-floating-action-btn btn btn-sm pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-default"
            data-title="Automédication">
            <span class="pmd-floating-hidden">Automédication</span>
            <i class="fa fa-medkit"></i>
        </a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.module', Auth::user())): ?>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_demande_examen"
            class="bg-maroon pmd-floating-action-btn btn btn-sm pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-default"
            data-title="Prescription Examen">
            <span class="pmd-floating-hidden">Prescription Examen</span>
            <i class="fa fa-flask"></i>
        </a>
    <?php endif; ?>
    <a class="pmd-floating-action-btn btn pmd-btn-fab pmd-btn-raised pmd-ripple-effect btn-primary" data-title="Ajouter"
        href="javascript:void(0);">
        <span class="pmd-floating-hidden">Primary</span>
        <i class="fa fa-plus fa-1x"></i>
    </a>
</div>

<div class="content-wrapper">
    <div>
        <div class="ldBar label-center" id="myItem1" data-value="50" data-preset="bubble"
            style="display: none;    position: absolute; left: 50%; top: 10%; z-index: 999999;"></div>
    </div>
    
    <?php if(count($errors) > 0): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="alert alert-danger"><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <?php if(session()->has('message')): ?>
        <p class="alert alert-success message" style="display: none;"><?php echo e(session('message')); ?></p>
    <?php endif; ?>
    <div class="clearfix">
        <ol class="breadcrumb no-margin">
            <li><a href="/home"><i class="fa fa-home"></i> Acceuil</a></li>
            <li><a href="<?php echo e(route('patient.index')); ?>"><i class="fa fa-user-injured"></i> Mes Patients</a></li>
            <li class="active"><?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?></li>
        </ol>
    </div>
    <?php echo $__env->make('user.patient.content_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <section class="content">
        <div class="row">

            <?php echo $__env->make('user.patient.profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-md-9" id="card-container-modules">
                <div class="bs-glyphicons d-sm-none">
                    <ul class="bs-glyphicons-list text-bold">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_10' ? 'active' : ''); ?>">
                                <a href="#tab_10" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-notes-medical margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class ">Consultations</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_11' ? 'active' : ''); ?>">
                                <a href="#tab_11" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-ambulance margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class">Hospitalisations</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_5' ? 'active' : ''); ?>">
                                <a href="#tab_5" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-medkit margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class">Automédications</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_2' ? 'active' : ''); ?>">
                                <a href="#tab_2" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-pills margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class ">Prescriptions Service</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_12' ? 'active' : ''); ?>">
                                <a href="#tab_12" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-heartbeat margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class">Prescriptions Act</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_3' ? 'active' : ''); ?>">
                                <a href="#tab_3" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-vial margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class ">Prescriptions Examen</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('traitements_chronique.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_4' ? 'active' : ''); ?>">
                                <a href="#tab_4" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-capsules margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class ">Prescriptions Chronique</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="<?php echo e(session('tab') == 'tab_1' ? 'active' : ''); ?>">
                            <a href="#tab_1" data-toggle="tab" role="tab">
                                <span class="fa fa-4x fa-comments margin" aria-hidden="true"></span>
                                <span class="glyphicon-class ">Annotations</span>
                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_8' ? 'active' : ''); ?>">
                                <a href="#tab_8" data-toggle="tab" role="tab" aria-expanded="true">
                                    <span class="fa fa-4x fa-question-circle margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class ">Observances</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_6' ? 'active' : ''); ?>">
                                <a href="#tab_6" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-leaf margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class">Phytothérapies</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_9' ? 'active' : ''); ?>">
                                <a href="#tab_9" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-4x fa-chalkboard-teacher margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class ">Educations Thérapeutique</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="<?php echo e(session('tab') == 'tab_7' ? 'active' : ''); ?>">
                            <a href="#tab_7" data-toggle="tab" role="tab" aria-expanded="false">
                                <span class="fa fa-4x fa-tasks margin" aria-hidden="true"></span>
                                <span class="glyphicon-class ">Avis sur l'IP</span>
                            </a>
                        </li>
                    </ul>

                </div>

                <div class="bs-glyphicons d-md-none">
                    <ul class="bs-glyphicons-list text-bold">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_10' ? 'active' : ''); ?>">
                                <a href="#tab_10" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-notes-medical margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm ">Consultations</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_11' ? 'active' : ''); ?>">
                                <a href="#tab_11" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-ambulance margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm">Hospitalisations</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_5' ? 'active' : ''); ?>">
                                <a href="#tab_5" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-medkit margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm">Automédications</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_2' ? 'active' : ''); ?>">
                                <a href="#tab_2" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-pills margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm ">Prescriptions Service</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_12' ? 'active' : ''); ?>">
                                <a href="#tab_12" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-heartbeat margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm">Prescriptions Act</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_3' ? 'active' : ''); ?>">
                                <a href="#tab_3" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-vial margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm ">Prescriptions Examen</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('traitements_chronique.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_4' ? 'active' : ''); ?>">
                                <a href="#tab_4" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-capsules margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm ">Prescriptions Chronique</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="<?php echo e(session('tab') == 'tab_1' ? 'active' : ''); ?>">
                            <a href="#tab_1" data-toggle="tab" role="tab">
                                <span class="fa fa-3x fa-comments margin" aria-hidden="true"></span>
                                <span class="glyphicon-class text-sm ">Annotations</span>
                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_8' ? 'active' : ''); ?>">
                                <a href="#tab_8" data-toggle="tab" role="tab" aria-expanded="true">
                                    <span class="fa fa-3x fa-question-circle margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm ">Observances</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_6' ? 'active' : ''); ?>">
                                <a href="#tab_6" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-leaf margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm">Phytothérapies</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.module', Auth::user())): ?>
                            <li class="<?php echo e(session('tab') == 'tab_9' ? 'active' : ''); ?>">
                                <a href="#tab_9" data-toggle="tab" role="tab" aria-expanded="false">
                                    <span class="fa fa-3x fa-chalkboard-teacher margin" aria-hidden="true"></span>
                                    <span class="glyphicon-class text-sm ">Educations Thérapeutique</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="<?php echo e(session('tab') == 'tab_7' ? 'active' : ''); ?>">
                            <a href="#tab_7" data-toggle="tab" role="tab" aria-expanded="false">
                                <span class="fa fa-3x fa-tasks margin" aria-hidden="true"></span>
                                <span class="glyphicon-class text-sm ">Avis sur l'IP</span>
                            </a>
                        </li>
                    </ul>

                </div>
                <div class="tab-content ">

                    <!--tab annotations -->
                    <?php echo $__env->make('user.patient.tabs.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--tab Prescription -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.prescription', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--tab Analyse biologique-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.analyse_biologique', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--Tab Traitement chronique-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('traitements_chronique.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.traitement', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--tab Automédication-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.automedication', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--tab Phytothérapie-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.phytotherapie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--tab devenir de l'intervention pharmaceutique-->
                    <?php echo $__env->make('user.patient.tabs.devenir_ip', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!-- tab Observance  -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.observance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--tab Consultation-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.consultation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--tab hospitalisation-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.hospitalisation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <!--tab Education thérapeutique-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.education_therapeutique', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    
                    <!--tab act_medicale-->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.module', Auth::user())): ?>
                        <?php echo $__env->make('user.patient.tabs.act_medicale', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                </div>
            </div>


        </div>
    </section>

</div>

<?php echo $__env->make('user.patient.modals.modals' , ['pathologies' => $pathologies], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('plugins/jquery-smartwizard-master/dist/js/jquery.smartWizard.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/user/patient/gestion_dmp.js')); ?>"></script>

<?php if(session('notif')): ?>

    <script type="text/javascript">
        // var qr = new QRCode(document.getElementById("qrcode"), {
        //     text: "http//medicaments.hic-sante.com/patient/x/edit",
        //     width: 128,
        //     height: 128,
        //     colorDark: "#000000",
        //     colorLight: "#ffffff",
        //     correctLevel: QRCode.CorrectLevel.H
        // });
        //qrcode.makeCode(qr); // make another code.
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            type: 'success',
            title: '<?php echo e(session('
            notif ')); ?>'
        })

    </script>

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\edit1.blade.php ENDPATH**/ ?>