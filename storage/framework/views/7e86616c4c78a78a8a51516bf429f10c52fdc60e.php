<!--tab phyltothérapie-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_6' ? 'active in' : ''); ?>" id="tab_6">

    <div class="clearfix">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left" title="Raccourci(p)" data-toggle="modal"
                    data-target="#modal_phyto">Saisir
                    plante(s)</button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.export', Auth::user())): ?>
            <a href="/export/phyto/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-widget">
                <div class="box-body table-responsive">
                    <table id="example8" class="table text-center table-bordered nowrap">
                        <thead style="background-color: #68a942 !important; color:white">
                            <tr>
                                <th> Num°: </th>
                                <th>Plante (FR) </th>
                                <th>Plante (AR) </th>
                                <th>Utilisation </th>
                                <th>Fréquence </th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.delete', Auth::user())): ?>
                                    <th>Supprimer</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient->phytos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phyto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($phyto->produit['produit_naturel_fr']); ?></td>
                                    <td><?php echo e($phyto->produit['produits_arabe']); ?></td>
                                    <td><?php echo e($phyto->utilisation ? $phyto->utilisation->pathologie : ''); ?>

                                    </td>
                                    <td><?php echo e($phyto->frequence); ?> <?php echo e($phyto->frequence_date); ?></td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.delete', Auth::user())): ?>
                                        <td>
                                            <?php if(!$patient->readonly): ?>
                                                <a href="" class="deleteRow"
                                                    data-url="<?php echo e(route('phytotherapie.destroy', $phyto->id)); ?>"
                                                    style="color: inherit; cursor: pointer;"><span
                                                        class="glyphicon glyphicon-trash "></span></a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\tabs\phytotherapie.blade.php ENDPATH**/ ?>