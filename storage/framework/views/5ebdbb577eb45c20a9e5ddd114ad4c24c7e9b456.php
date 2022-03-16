<!--tab analyse biologique-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_3' ? 'active in' : ''); ?>" id="tab_3">
    <!--analyse biologique tab -->
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li class="active">Prescription Examen</li>
        </ol>

        <div class="row">
            <div class="col-sm-9 col-xs-5">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.create', Auth::user())): ?>
                    <?php if(!$patient->readonly): ?>
                        <button type="button" class="btn btn-primary " data-toggle="modal"
                            data-target="#modal_demande_examen" title="Raccourci(e)">Prescrire un Examen</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="col-sm-3 col-xs-7 col-xs-push-1 col-sm-push-0">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.export', Auth::user())): ?>
                    <a href="/export/gen_ab/<?php echo e($patient->id); ?>" class="pull-right"><button type="button"
                            class="btn btn-success "><i class="fa fa-download"></i></button></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="box box-widget">
        <div class="box-body">
            <div class="">
                <div class="col-sm-12">
                    <?php if(count($patient->requestExams) != 0): ?>
                        <!-- <div class="alert alert-success alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Une demande d'examen est en cours
                        </div> -->

                        <!--  -->
                        <!--  -->

                        <h3>Prescriptions d'examens en cours</h3>
                        <table id="demandes_table" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #0097f0 !important; color:white">
                                <tr>
                                    <th>Médecin prescripiteur</th>
                                    <th>Date de prescription</th>
                                    <th>Type de demande</th>
                                    <th>Note</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $patient->requestExams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>Dr.<?php echo e($demande->prescripteur->name); ?>

                                            <?php echo e($demande->prescripteur->prenom); ?>

                                        </td>
                                        <td><?php echo e($demande->date_prescription); ?></td>
                                        <td><?php echo $demande->type == 'radio' ? 'Examen Radiologique' : 'Examen Biologique'; ?></td>
                                        <td><?php echo e($demande->note); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.executeRequest', Auth::user())): ?>
                                                <button class="btn btn-primary remplir" data-toggle="modal"
                                                    data-target="#modal_biologique" data-id="<?php echo e($demande->id); ?>">
                                                    <i class="fa fa-vial mr-1"></i>Remplir</button>
                                            <?php endif; ?>
                                            
                                            <button class="btn btn-light" onclick="
                                                if (confirm('voulez vous annuler la demande d\'examen ?')) {
                                                event.preventDefault();
                                                document.getElementById('delete-form-<?php echo e($demande->id); ?>').submit();										}
                                                ">
                                                <i class="fa fa-redo mr-1"></i>
                                                <form style="display: none;" method="POST"
                                                    action="<?php echo e(route('prescription.examen.destroy', $demande->id)); ?>"
                                                    id="delete-form-<?php echo e($demande->id); ?>">
                                                    <?php echo e(csrf_field()); ?>

                                                    <?php echo e(method_field('DELETE')); ?>

                                                </form>
                                                Annuler
                                            </button>

                                            <button class="btn btn-danger"
                                                onclick="downloadExamen(<?php echo e($demande->id); ?>)"><i
                                                    class="fa fa-print mr-1"></i> Imprimer</button>
                                            
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    <?php endif; ?>
                    <?php if(count($patient->bilans) > 0): ?>
                        <h3>Liste des bilans d'examens biologique</h3>

                        <div id="labelforma" name="labelforma" value="labelforma" style="display: block">
                            <table id="example3"
                                class="nowrap table table-bordered table-hover table-striped text-center">
                                <thead style="background-color: #0097f0 !important; color:white">
                                    <tr>
                                        <th># </th>
                                        <th>Type Bilan </th>
                                        <th>Type élement </th>
                                        <th>Valeur </th>
                                        <th>Min </th>
                                        <th>Max </th>
                                        <th>Date d'analyse </th>
                                        <th>Laboratoire </th>
                                        <th>Commentaire </th>
                                        <th>Graphe </th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.update', Auth::user())): ?>
                                            <th>Modifier</th>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.delete', Auth::user())): ?>
                                            <th>Supprimer </th>
                                        <?php endif; ?>
                                        <th>Annotation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $patient->bilans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bilan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($bilan->element): ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>
                                                <td> <?php echo e($bilan->element->bilan); ?> </td>
                                                <td> <?php echo e($bilan->element->element); ?> </td>
                                                <td>

                                                    <?php if($bilan->valeur && ($bilan->valeur > $bilan->element->maximum || $bilan->valeur < $bilan->element->minimum)): ?>
                                                        <span class="label label-danger text-sm"><?php echo e($bilan->valeur); ?>

                                                            <?php echo e($bilan->element->unite); ?></span>
                                                    <?php elseif($bilan->valeur ): ?>
                                                        <span
                                                            class="label label-success text-sm"><?php echo e($bilan->valeur); ?>

                                                            <?php echo e($bilan->element->unite); ?></span>
                                                    <?php endif; ?>

                                                </td>
                                                <td> <b><?php echo e($bilan->element->minimum); ?> </b> </td>
                                                <td> <b><?php echo e($bilan->element->maximum); ?></b> </td>
                                                <td> <?php echo e($bilan->date_analyse); ?> </td>

                                                <td><?php echo e($bilan->laboratoire); ?></td>
                                                <td><?php echo e($bilan->commentaire); ?></td>
                                                <td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.dessin', Auth::user())): ?>
                                                        <?php
                                                            $el = DB::table('elements')
                                                                ->where('id', $bilan->element_id)
                                                                ->get();
                                                        ?>
                                                        <?php if($el->first()->bilan != 'Radiographie'): ?>
                                                            <button type="button"
                                                                class="btn btn-primary float-left show_chart"
                                                                data-toggle="modal" id="<?php echo e($bilan->id); ?>"
                                                                data-target="#modal_graphe">Graphe</button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.update', Auth::user())): ?>
                                                    <td>
                                                        <?php if(!$patient->readonly): ?>
                                                            <a href="#modifier-element" class="edit_bilan"
                                                                title="Modifier la consultation" data-toggle="modal"
                                                                data-target="#modal_update_biologique"
                                                                data-el="<?php echo e($bilan->element->element); ?>"
                                                                data-id="<?php echo e($bilan->id); ?>">
                                                                <i class="fa fa-edit text-green fa-2x"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.delete', Auth::user())): ?>
                                                    <td>
                                                        <?php if(!$patient->readonly): ?>
                                                            <form style="display: none;" method="POST"
                                                                action="<?php echo e(route('bilan.destroy', $bilan->id)); ?>"
                                                                id="delete-form-<?php echo e($bilan->id); ?>">
                                                                <?php echo e(csrf_field()); ?>

                                                                <?php echo e(method_field('DELETE')); ?>

                                                            </form>

                                                            <a href=""
                                                                onclick="if (confirm('voulez vous supprimer cette ligne ?')) {event.preventDefault(); document.getElementById('delete-form-<?php echo e($bilan->id); ?>').submit(); }"
                                                                style="color: inherit; ">
                                                                <span class="fa fa-trash text-red fa-2x"></span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <?php if(!$patient->readonly): ?>
                                                        <a href="#" id="btn_ann_examen" data-toggle="modal"
                                                            data-target="#modal_annotation" data-type="bilan"
                                                            data-id="<?php echo e($bilan->id); ?>">
                                                            <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                                        </a>

                                                    <?php endif; ?>
                                                </td>

                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php if(count($patient->bilansRadiologique) > 0): ?>
                        <h3>Liste des bilans d'examens radiologique</h3>

                        <div id="labelforma" name="labelforma" value="labelforma" style="display: block">
                            <table id="example3"
                                class="nowrap table table-bordered table-hover table-striped text-center">
                                <thead style="background-color: #0097f0 !important; color:white">
                                    <tr>
                                        <th>#</th>
                                        <th>Type Bilan </th>
                                        <th>Date d'analyse </th>
                                        <th>Laboratoire </th>
                                        <th>Commentaire </th>
                                        <th>Image</th>
                                        <th>Annotation</th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.delete', Auth::user())): ?>
                                            <th>Supprimer </th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $patient->bilansRadiologique; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bilan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr>
                                            <td><?php echo e($loop->index + 1); ?></td>
                                            <td>Radiologique</td>
                                            <td> <?php echo e($bilan->date_analyse); ?> </td>
                                            <td><?php echo e($bilan->laboratoire); ?></td>
                                            <td><?php echo e($bilan->commentaire); ?></td>
                                            <td>
                                                <a href="#" class="open_image" data-toggle="modal"
                                                    data-target="#modal_imgs" data-url="<?php echo e($bilan->fichier); ?>"
                                                    data-comment="<?php echo e($bilan->commentaire); ?>">
                                                    <i class="fa fa-2x fa-image text-green"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if(!$patient->readonly): ?>
                                                    <a href="#" id="btn_ann_examen" data-toggle="modal"
                                                        data-target="#modal_annotation" data-type="bilan"
                                                        data-id="<?php echo e($bilan->id); ?>">
                                                        <i class="fa fa-2x fa-comment-dots text-yellow"></i></a>
                                                <?php endif; ?>
                                            </td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.delete', Auth::user())): ?>
                                                <td>
                                                    <?php if(!$patient->readonly): ?>
                                                        <form style="display: none;" method="POST"
                                                            action="<?php echo e(route('bilan.destroy', $bilan->id)); ?>"
                                                            id="delete-form-<?php echo e($bilan->id); ?>">
                                                            <?php echo e(csrf_field()); ?>

                                                            <?php echo e(method_field('DELETE')); ?>

                                                        </form>

                                                        <a href=""
                                                            onclick="
                                                                                                                                                                                                                                                                                                                                                                                                                      if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                                                                                                                                                                                                                                                                                                      event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                      document.getElementById('delete-form-<?php echo e($bilan->id); ?>').submit();										}
                                                                                                                                                                                                                                                                                                                                                                                                                     "
                                                            style="color: inherit; "><span
                                                                class="fa fa-2x fa-trash text-red"></span></a>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\tabs\analyse_biologique.blade.php ENDPATH**/ ?>