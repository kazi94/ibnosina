<!--tab Consultation-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_10' ? 'active in' : ''); ?>" id="tab_10">

    <div class="clearfix">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                    data-target="#modal_consultation" title="Raccourci(c)">Ajouter une Consultation</button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.export', Auth::user())): ?>
            <a href="/export/consultation/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> </button></a>
        <?php endif; ?>
    </div>

    <div class="box box-widget">

        <div class="box-header">
            <h4>Consultations</h4>
        </div>

        <div class="box-body ">
            <div class="">
                <div class="col-sm-12 table-responsive">
                    <table id="table_consultation" class=" table table-bordered table-hover text-center" width="100%"
                        cellspacing="0">
                        <thead style="background-color: #5a3f15 !important; color:white">
                            <tr>
                                <th>Num°</th>
                                <th>Date</th>
                                <th>Détails</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.update', Auth::user())): ?>
                                    <?php if(!$patient->readonly): ?>
                                        <th>Modifier</th>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.delete', Auth::user())): ?>
                                    <?php if(!$patient->readonly): ?>
                                        <th>Supprimer</th>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if(!$patient->readonly): ?>
                                    <th>Annotation</th>
                                <?php endif; ?>

                                <th>Orientation</th>
                                <th>Certificat</th>

                                <th>Compte rendu</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $patient->consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($loop->index + 1); ?> </td>
                                    <td><?php echo e($consultation->date_consultation); ?></td>
                                    <td>
                                        <a href="#detail-consultation" class="detailConsultation"
                                            title="Détails de la consultation" data-toggle="modal"
                                            data-target="#modal_detail_consultation"
                                            data-id="<?php echo e($consultation->id); ?>">
                                            <i class="fa fa-plus-circle fa-2x"></i>
                                        </a>
                                    </td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.update', Auth::user())): ?>
                                        <?php if(!$patient->readonly): ?>
                                            <td>
                                                <a href="#modifier-consultation" class="edit_consultation"
                                                    title="Modifier la consultation" data-toggle="modal"
                                                    data-id="<?php echo e($consultation->id); ?>">
                                                    <i class="fa fa-edit text-green fa-2x"></i>
                                                </a>
                                            </td>

                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.delete', Auth::user())): ?>
                                        <?php if(!$patient->readonly): ?>
                                            <td>
                                                <form style="display: none;" method="POST"
                                                    action="/patient/consultation/destroy/<?php echo e($consultation->id); ?>&<?php echo e($patient->id); ?>"
                                                    id="delete-form-<?php echo e($loop->index + 1); ?>">
                                                    <?php echo e(csrf_field()); ?>

                                                    <?php echo e(method_field('DELETE')); ?>

                                                </form>
                                                <a href="" title="Supprimer la consultation"
                                                    onclick="if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                    event.preventDefault();
                                                                                                                                    document.getElementById('delete-form-<?php echo e($loop->index + 1); ?>').submit();										}
                                                                                                                                    " style="color:inherit;">
                                                    <span class="fa fa-trash text-red fa-2x"></span>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(!$patient->readonly): ?>
                                        <td>
                                            <a href="#" id="btn_ann_con" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="consultation"
                                                data-id="<?php echo e($consultation->id); ?>">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if($consultation->orientation != ''): ?>
                                            <a href="#"
                                                onclick="downloadLettre('<?php echo e($consultation->orientation); ?>' , '<?php echo e($consultation->date_consultation); ?>')"><i
                                                    class="fa fa-print fa-2x"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($consultation->certificat != ''): ?>
                                            <a href="#"
                                                onclick="downloadCertificat('<?php echo e($consultation->certificat); ?>' , '<?php echo e($consultation->date_consultation); ?>')"><i
                                                    class="fa fa-print fa-2x"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($consultation->compte_rendu != ''): ?>
                                            <a href="#" onclick="donwloadConsultation(<?php echo e($consultation->id); ?>)"><i
                                                    class="fa fa-print fa-2x"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!--fin tab consultation-->
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\tabs\consultation.blade.php ENDPATH**/ ?>