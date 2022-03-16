<!--tab Hospitalisation-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_11' ? 'active in' : ''); ?>" id="tab_11">

    <div class="clearfix d-sm-none">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                    data-target="#modal_hospitalisation" title="Raccourci(h)">Ajouter une Hospitalisation</button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.print', Auth::user())): ?>
            <button class="btn btn-default pull-right edit_impression" id="<?php echo e($patient->id); ?>" <?php if(count($patient->hospitalisation) == 0): ?> disabled <?php endif; ?>><i
                    class="fa fa-print"></i> Imprimer Rapport</button>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.export', Auth::user())): ?>
            <a href="/export/ho/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        <?php endif; ?>
    </div>
    <div class="clearfix d-md-none">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                    data-target="#modal_hospitalisation">Ajouter Hospitalisation</button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.print', Auth::user())): ?>
            <button class="btn btn-default pull-right edit_impression" id="<?php echo e($patient->id); ?>" <?php if(count($patient->hospitalisation) == 0): ?> disabled <?php endif; ?>><i
                    class="fa fa-print"></i> </button>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.export', Auth::user())): ?>
            <a href="/export/ho/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> </button></a>
        <?php endif; ?>
    </div>

    <div class="box box-widget">

        

        <div class="box-body ">
            <div class="row">
                <div class="col-sm-12">
                    <table id="table_hospitalisation" class="table table-bordered nowrap text-center">
                        <thead style="background-color: #3D9970 !important; color:white">
                            <tr>
                                <th>#</th>
                                <th>Service</th>
                                <th>Détails</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                                <th>Annotations</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $patient->hospitalisation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ho): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($loop->index + 1); ?> </td>
                                    <td> <?php echo e($ho->service); ?></td>
                                    <td>
                                        <a href="#detail-hospitalisation" class="detailHospitalisation"
                                            title="Détails de l'hospitalisation" data-toggle="modal"
                                            data-target="#modal_detail_hospitalisation" data-id="<?php echo e($ho->id); ?>">
                                            <i class="fa fa-plus-circle fa-2x"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.update', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>
                                                <a href="#modifier-hospitalisation" class="edit_hospitalisation"
                                                    title="Modifier l'hospitalisation" data-toggle="modal"
                                                    data-id="<?php echo e($ho->id); ?>">
                                                    <i class="fa fa-edit text-green fa-2x"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.delete', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>
                                                <form style="display: none;" method="POST"
                                                    action="<?php echo e(route('hospitalisation.destroy', $ho->id)); ?>"
                                                    id="delete-form-<?php echo e($ho->id); ?>">
                                                    <?php echo e(csrf_field()); ?>

                                                    <?php echo e(method_field('DELETE')); ?>

                                                </form>

                                                <a href="" title="Supprimer Hospitalisation"
                                                    onclick="
                                                                                                                                                                                                                if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                                                                                                event.preventDefault();
                                                                                                                                                                                                                document.getElementById('delete-form-<?php echo e($ho->id); ?>').submit();										}
                                                                                                                                                                                                                "
                                                    style="color:inherit;"><span
                                                        class="fa fa-trash text-red fa-2x"></span></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!$patient->readonly): ?>
                                            <a href="#" id="btn_ann_hosp" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="hospitalisation"
                                                data-id="<?php echo e($ho->id); ?>">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
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
<!--fin tab hospitalisation-->
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\tabs\hospitalisation.blade.php ENDPATH**/ ?>