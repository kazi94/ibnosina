<?php $__env->startSection('script_css'); ?>
<?php $__env->startSection('title'); ?>
    Mes Patients
<?php $__env->stopSection(); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="clearfix">
            <ol class="breadcrumb mb-1">
                <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-home"></i> Acceuil</a></li>
                <li class="active">Mes Patients</li>
            </ol>
        </div>
        <div class="row">
            
            <div class="col-sm-offset-4 col-sm-4" style="cursor: pointer;">
                <a href="<?php echo e(route('patient.create.step.one.get', ['type' => 'normal'])); ?>" class="text-black">
                    <div class="mb-1 text-center card card-body">

                        <i class="bg-happy-fisher fa fa-3x fa-user-plus icon-gradient mb-2">
                        </i>

                        <p class="card-title">Ajouter Patient
                        </p>

                    </div>
                </a>
            </div>
        </div>
        <div class="">

            <div class="col-md-2 col-md-push-10 col-sm-3 col-sm-offset-0 col-sm-push-9 col-xs-offset-2">

                <a href="<?php echo e(route('patient.view.list')); ?>"><button type="button" class="btn btn-info"
                        data-toggle="tooltip" title="Afficher Tableau de bords"><i class="fa fa-address-card"></i> Vue
                        en Grille</button></a>
                <button class="btn btn-success" data-toggle="modal" data-target="#modal_export">Exporter</button>
            </div>
            <div class="col-md-10 col-md-pull-2 col-sm-9 col-sm-pull-3 ">
                <h2 class="no-margin">Liste des Patients</h2>
            </div>
        </div>
        <!-- search form (Optional) -->





    </section>

    <section class="content">
        <?php if(session()->has('message')): ?>
            <p style="display: none;" id="message"><?php echo e(session('message')); ?></p>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-info ">
                    <div class="box-body">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.delete', Auth::user())): ?>
                            <?php
                                $canDelete = true;
                            ?>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.module', Auth::user())): ?>
                            <?php
                                $canModule = true;
                            ?>
                        <?php endif; ?>
                        <table id="t_patients" class="table table-hover table-bordered text-center">
                            <thead>
                                <tr class="bg-gray">
                                    <th></th>
                                    <th>N°Dossier</th>
                                    <th>Ajouté le</th>
                                    <th>Patient</th>
                                    <th>Sexe</th>
                                    <th>Age</th>
                                    <th>Poids</th>
                                    <th>Taille</th>
                                    <th>Ville</th>
                                    <th>Profession</th>
                                    <th>Tél</th>
                                    <th>Status</th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.module', Auth::user())): ?>
                                        <th>DMP</th>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.delete', Auth::user())): ?>
                                        <th>Supprimer</th>
                                    <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(Auth::user()->id != 26): ?>

                                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td style="width: 15px"></td>
                                            <th> <?php echo e($patient->num_dossier); ?></th>
                                            <th> <?php echo e(date('m-d-Y', strtotime($patient->created_at))); ?></th>
                                            <td> <?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?></td>
                                            <td> <?php echo e($patient->sexe); ?> </td>
                                            <td>
                                                <?php if($patient->date_naissance != ''): ?>
                                                    <?php echo e(intval(date('Y/m/d', strtotime('now'))) - intval(date('Y/m/d', strtotime($patient->date_naissance)))); ?>

                                                    ans
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($patient->poids): ?>
                                                    <?php echo e($patient->poids); ?> Kg
                                                <?php else: ?>
                                                    

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($patient->taille ? $patient->taille . ' cm' : '-'); ?>

                                            </td>
                                            <td>
                                                <?php echo e(!empty($patient->villes) ? $patient->name : '-'); ?>

                                            </td>
                                            <td>
                                                <?php if($patient->travaille): ?>
                                                    <?php echo e($patient->travaille == 'autre' ? $patient->travaille1 : $patient->travaille); ?>

                                                <?php else: ?> -
                                                <?php endif; ?>

                                            </td>
                                            <td> <?php echo e($patient->num_tel_1); ?> </td>
                                            <td>
                                                <?php if(empty($patient->date_sortie) && $patient->hospi): ?>
                                                    <span class="label label-success text-sm">
                                                        <?php echo e($patient->hospi->service); ?>

                                                        ::<?php echo e($patient->hospi->chambre); ?>

                                                        /<?php echo e($patient->hospi->lit); ?>

                                                    </span>
                                                <?php elseif(!empty($patient->date_sortie)): ?>
                                                    <span class="label label-danger text-sm">
                                                        <?php echo e(($patient->motif_sortie == 'autre' ? 'Transférer vers service ' . $patient->service_transfert : $patient->motif_sortie == 'hopital') ? 'Sortie du CHU' : 'Décédé'); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.module', Auth::user())): ?>
                                                

                                                
                                                <td>
                                                    <a href="<?php echo e(route('patient.edit', $patient->id)); ?>">
                                                        <i class="fa fa-folder-open fa-2x text-blue"
                                                            title="Dossier patient"></i>
                                                    </a>
                                                </td>
                                                
                                            <?php endif; ?>
                                            

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.delete', Auth::user())): ?>
                                                

                                                <td>
                                                    <form style="display: none;" method="POST"
                                                        action="<?php echo e(route('patient.destroy', $patient->id)); ?>"
                                                        id="delete-form-<?php echo e($patient->id); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <?php echo e(method_field('DELETE')); ?>

                                                    </form>

                                                    <a href=""
                                                        onclick="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            if (confirm('voulez vous supprimer ce patient ?')) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            document.getElementById('delete-form-<?php echo e($patient->id); ?>').submit();                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          "><span
                                                            class="fa fa-trash fa-2x text-red"></span></a>
                                                </td>
                                                
                                            <?php endif; ?>

                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <div class="modal fade in" id="modal_export">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="bg-blue modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <div class="row">
                        <div class="col-md-9">
                            <h4 class="modal-title">Générer un fichier excel des patients</h4>
                        </div>
                    </div>
                </div>
                <form action="<?php echo e(route('export.patients.bilans')); ?>" class="up_impression" method="get"
                    enctype="multipart/form-data" target="newStuff">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body" style="display: block;">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-condensed text-center">
                                    <tr id="text" style="display:block">
                                        <td>Date début</td>
                                        <td>
                                            <input type="date" id="dateD" name="dateD" class="form form-control"
                                                required>
                                        </td>
                                        <td>Date Fin</td>
                                        <td>
                                            <input type="date" id="dateF" name="dateF" class="form form-control"
                                                required />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
                        <input type="submit" class="btn btn-success pull-right" value="Générer Excel">
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('plugins/jquery/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/adminlte2/js/adminlte.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>
<script>
    var constraints = {
        audio: false,
        video: true
    };
    //navigator.mediaDevices.getUserMedia(constraints).then(function (stream) { }).catch(function (err) {
    /* handle the error */
    //});
    var table;
    $(function() {
        table = $('#t_patients').DataTable({
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            "scrollX": true,
            dom: "<'row'<'col-sm-2'l><'col-sm-4'B> <'col-sm-6'f>>tipr",
            "order": [],
            buttons: [{
                text: 'Archives',
                titleAttr: 'Liste des patients archivés',
                action: function(e, dt, node, config) {
                    window.location.href = "<?php echo e(route('patient.archives')); ?>"
                },
                className: 'btn bg-navy'
            }],

        });
        table.on('select', function() {
            var rowData = table.rows({
                selected: true
            }).data()[0];
            console.log(rowData[1]);
            // now do what you need to do wht the row data

        });
        if ($("#message").text()) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success($("#message").text())
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/show.blade.php ENDPATH**/ ?>