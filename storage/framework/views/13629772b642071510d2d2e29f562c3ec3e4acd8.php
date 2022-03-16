<?php $__env->startSection('script_css'); ?>
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<?php $__env->startSection('title'); ?>
    AnaPharm - Tableau de bord
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <section class="content">
        <?php if(session()->has('message')): ?>
            <p class="alert alert-success" id="message" style="display: none;"><?php echo e(session('message')); ?></p>
        <?php endif; ?>

        

        <?php if($countInj): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.inject', Auth::user())): ?>
                <h5 class="alert alert-danger alert-dismissible fade in d-none" id="injAlert">
                    
                    
                    <strong>Aujourd'hui vous avez <?php echo e($countInj); ?> <a
                            href="<?php echo e(route('administrations.index')); ?>">Prescription(s)</a> pour administration de
                        médicaments
                        aux patients.</strong>
                </h5>
            <?php endif; ?>
        <?php endif; ?>
        <?php if($countDem): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.executeRequest', Auth::user())): ?>
                <h5 class="alert alert-danger alert-dismissible fade in d-none" id="examAlert">
                    
                    
                    <strong>Vous avez <?php echo e($countDem); ?> <a href="<?php echo e(route('examens.index')); ?>">demande(s)
                            d'examen(s)</a>
                        à
                        faire
                        !.</strong>
                </h5>
            <?php endif; ?>
        <?php endif; ?>
        <div class="row ">
            <h3 class="ml-4">APPLICATIONS
            </h3>
            <div class="col-md-9">

                <div class="row">
                    <div class="col-md-4" style="cursor: pointer;">
                        <a href="<?php echo e(route('stats.index')); ?>" class="text-black">
                            <div class="mb-3 text-center card card-body">



                                <i class="bg-blue-active fa fa-5x fa-hospital icon-gradient mb-2">
                                </i>

                                <h5 class="card-title">MON SERVICE
                                </h5>

                                Consulter le tableau de bord de votre service.


                            </div>
                        </a>


                    </div>
                    <div class="col-md-4" style="cursor: pointer;">
                        <a href="<?php echo e(route('patient.index')); ?>" class="text-black">
                            <div class="mb-3 text-center card card-body">

                                <i class="bg-happy-green fa fa-5x fa-bed icon-gradient mb-2">
                                </i>

                                <h5 class="card-title">MES PATIENTS
                                </h5>
                                Gérez vos patients et leurs dossiers médicales.

                            </div>
                        </a>


                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.inject', Auth::user())): ?>
                        <div class="col-md-4" style="cursor: pointer;">
                            <a href="<?php echo e(route('administrations.index')); ?>" class="text-black">
                                <div class="mb-3 text-center card card-body card-patient">
                                    <?php if($countInj): ?>
                                        <span class='label label-danger'
                                            style="position: absolute;top: 4px;right: 5px;text-align: center;font-size: 19px;padding: 2px 3px;line-height: .9;">
                                            <?php echo e($countInj); ?>

                                        </span>
                                    <?php endif; ?>
                                    <i class="bg-happy-itmeo fa fa-5x fa-user-nurse icon-gradient mb-2">
                                    </i>

                                    <h5 class="card-title">MES ADMINISTRATIONS
                                    </h5>
                                    Gérez l'administration des médicaments aux patients.

                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.executeRequest', Auth::user())): ?>
                        <div class="col-md-4" style="cursor: pointer;">
                            <a href="<?php echo e(route('examens.index')); ?>" class="text-black">
                                <div class="mb-3 text-center card card-body p-3">
                                    <?php if($countDem): ?>
                                        <span class='label label-danger'
                                            style="position: absolute;top: 4px;right: 5px;text-align: center;font-size: 19px;padding: 2px 3px;line-height: .9;">
                                            <?php echo e($countDem); ?>

                                        </span>
                                    <?php endif; ?>
                                    <i class="bg-happy-fisher fa fa-5x fa-flask icon-gradient mb-2">
                                    </i>

                                    <h5 class="card-title">MES DEMANDES D'EXAMENS
                                    </h5>
                                    Gérez les demandes d'examens à faire.

                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                        <div class="col-md-4" style="cursor: pointer;">
                            <a href="<?php echo e(route('pharmacie.index')); ?>" class="text-black">
                                <div class="mb-3 text-center card card-body p-3">
                                    <?php if($countAnal): ?>
                                        <span class='label label-danger'
                                            style="position: absolute;top: 4px;right: 5px;text-align: center;font-size: 19px;padding: 2px 3px;line-height: .9;">
                                            <?php echo e($countAnal); ?>

                                        </span>
                                    <?php endif; ?>
                                    <i class="bg-grow-early fa fa-5x fa-clinic-medical icon-gradient mb-2">
                                    </i>

                                    <h5 class="card-title">MON ARMOIRE PHARMACEUTIQUE
                                    </h5>
                                    Gérez les tâches pharmaceutiques.<br /><br />

                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="col-md-4" style="cursor: pointer;">
                        <a href="<?php echo e(route('appointement.index')); ?>" class="text-black">
                            <div class="mb-3 text-center card card-body p-3">

                                <i class="fa fa-calendar-alt icon-gradient bg-plum-plate fa-5x mb-2">
                                </i>

                                <h5 class="card-title">MON AGENDA
                                </h5>
                                Gérez les prises de rendez-vous des patients .

                            </div>
                        </a>


                    </div>
                </div>

            </div>

            <div class="col-md-3">

                <div class="row">
                    <div class="col-sm-12">
                        
                        <a class="btn btn-app bg-red" data-toggle="modal" data-target="#modal_release_date">
                            <i class="fa fa-exclamation-circle"></i>Dernière <br />mise à jour!
                        </a>
                        <a class="btn btn-app bg-green" href="/docs/" target="_blank">
                            <i class="fa fa-book"></i>Manuel <br /> d'utilisation
                        </a>
                    </div>
                </div>
                <div class="mb-3 text-center card card-body">

                    <i class="fa fa-user-md icon-gradient bg-mean-fruit fa-5x mb-2">
                    </i>

                    <h3 class="text-center">Bienvenue Mr.<?php echo e(Auth::user()->name); ?>

                        <?php echo e(Auth::user()->prenom); ?>

                    </h3>
                    <p class="text-center">Votre dernière connexion <?php echo e(Auth::user()->last_login); ?> </p>
                    <p class="text-center">Adresse IP <?php echo e(Auth::user()->last_login_ip); ?> </p>
                    <p class="align-left"><b>Service</b> <?php echo e(Auth::user()->service); ?> <br />
                        <b>Grade </b><?php echo e(Auth::user()->grade); ?> <br />
                        <b>Spécialité</b> <?php echo e(Auth::user()->specialite); ?> <br />
                    </p>

                </div>



            </div>

        </div>
        <h3 class="">OUTILS
        </h3>
        <div class="row">

            

            <div class="col-md-3 mr-3" style="cursor: pointer;">

                <div class="mb-3 text-center card card-body">

                    <i class="bg-mean-fruit fa fa-5x fa-images icon-gradient mb-2">
                    </i>

                    <h5 class="card-title">MA BIBLIOTHEQUE
                    </h5>
                    Gérez votre bibliothèque de photos. (A VENIR !)

                </div>

            </div>
            <div class="col-md-3 mr-3" style="cursor: pointer;">
                <a href="<?php echo e(route('clairance.index')); ?>" class="text-black">
                    <div class="mb-3 text-center card card-body">
                        <i class="bg-info fa fa-5x fa-calculator icon-gradient mb-2">
                        </i>

                        <h5 class="card-title">Clairance Calculateur
                        </h5>
                        Calculer la clairance selon le profil du Patient.

                    </div>
                </a>

            </div>

        </div>
    </section>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('/plugins/jquery/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/toastr/toastr.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/adminlte2/js/adminlte.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/home.js')); ?>"></script>

<script>
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    // if (!getCookie('release1') || getCookie('release1') == 'v2') {
    //     $("#modal_release_date").modal('show');
    //     // document.cookie = "release1=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    //     document.cookie = "release1=v3";
    // }
    // document.cookie = "view-mode=list";

    if ($("#injAlert").text()) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": null,
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.error($("#injAlert").text());
    }
    if ($("#examAlert").text()) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": null,
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.error($("#examAlert").text());
    }

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\home.blade.php ENDPATH**/ ?>