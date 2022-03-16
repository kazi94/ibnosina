<!--tab Education thérapeutique-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_9' ? 'active in' : ''); ?>" id="tab_9">

    <div class="clearfix">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left" title="Raccourci(e)" data-toggle="modal"
                    data-target="#modal_entretien">Education Thérapeutique</button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.export', Auth::user())): ?>
            <a href="/export/et/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i></button></a>
        <?php endif; ?>
    </div>

    <div id="labelforma4" name="labelforma2" style="display: block">

        <div class="box box-widget">
            <div class="box-body">
                <table id="example211" class="table table-bordered table-hover text-center">
                    <thead style="background-color:#39CCCC !important; color:white">
                        <tr>
                            <th>#</th>
                            <th>Type </th>
                            <th>Date </th>
                            <th>Notes </th>
                            <th>Média </th>
                            <th>Imprimer</th>
                            <th>Annotation</th>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.delete', Auth::user())): ?>
                                <th> Supprimer </th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $patient->educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th><?php echo e($loop->index + 1); ?></th>
                                <td><?php echo e($education->type); ?></td>
                                <td><?php echo e($education->date_et); ?></td>
                                <td style="word-break: break-word">
                                    <?php echo e($education->description); ?>

                                </td>
                                <td>
                                    <a href="#" class="open_image" data-toggle="modal" data-target="#modal_imgs"
                                        data-url="<?php echo e($education->fichier); ?>"
                                        data-comment="<?php echo e($education->description); ?>">
                                        <i class="fa fa-image fa-2x text-green"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="download-education" data-date="<?php echo e($education->date_et); ?>"
                                        data-notes="<?php echo e($education->description); ?>">
                                        <i class="fa fa-print fa-2x"></i>
                                    </a>
                                </td>
                                <td>
                                    <?php if(!$patient->readonly): ?>
                                        <a href="#" id="btn_ann_educ" data-toggle="modal"
                                            data-target="#modal_annotation" data-type="edu"
                                            data-id="<?php echo e($education->id); ?>">
                                            <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                        </a>

                                    <?php endif; ?>
                                </td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.delete', Auth::user())): ?>
                                    <td>
                                        <?php if(!$patient->readonly): ?>
                                            <form style="display: none;" method="POST"
                                                action="<?php echo e(route('education_therapeutique.destroy', $education->id)); ?>"
                                                id="delete-form-<?php echo e($education->id); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <?php echo e(method_field('DELETE')); ?>

                                            </form>

                                            <a href=""
                                                onclick="
                                                                                                                                                                         if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                                                         event.preventDefault();
                                                                                                                                                                         document.getElementById('delete-form-<?php echo e($education->id); ?>').submit();										}
                                                                                                                                                                        "
                                                style="color:black"><span class="fa fa-trash text-red fa-2x"></span></a>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyse_therap', Auth::user())): ?>
            <?php if(count($patient->ReglesEduPatient) > 0): ?>
                <div class="box box-widget">
                    <div class="box-header">
                        <h3>Educations Thérapeutiques A Faire</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <table id="example212" class="nowrap table table-bordered table-hover text-center">
                                    <thead style="background-color:#39CCCC !important; color:white">
                                        <tr>
                                            <th>Num° prescription</th>
                                            <th>Fait par le medecin</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $patient->ReglesEduPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_presc_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'risqueTherap'): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo e($regle_presc_edu->prescription_id); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->name); ?>

                                                        <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->prenom); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($regle_presc_edu->RegleEducConcerne->titre); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($regle_presc_edu->created_at); ?>

                                                    </td>
                                                    <td>
                                                        <a
                                                            href="<?php echo e(route('patient.FaireEducation', [$regle_presc_edu->prescription_id])); ?>">
                                                            <button class="btn btn-primary">Faire</button>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn BTNANALYSE"
                                                            data-id="<?php echo e($patient->id); ?>"
                                                            data-risque="<?php echo e($regle_presc_edu->prescription_id); ?>">Details</button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/tabs/education_therapeutique.blade.php ENDPATH**/ ?>