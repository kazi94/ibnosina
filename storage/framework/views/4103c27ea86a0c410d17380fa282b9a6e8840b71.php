<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="plugins/jquery/css/jquery_ui.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <?php if(count($errors) > 0): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="alert alert-danger"><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div class="alert alert-danger" style="display: none;"></div>
        <?php if(session()->has('message')): ?>
            <p class="alert alert-success"><?php echo e(session('message')); ?></p>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-8 col-xs-12 col-md-offset-2">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ajouter un médicament spécialité</h3>
                    </div>
                    <div class="box-body">
                        <div class="element" style="">
                            <form class="form-group" id="form_01" role="form" method="POST"
                                action="<?php echo e(route('specialite.store')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group col-sm-4">
                                    <label for="">Médicament spécialité</label>
                                    <input type="text" class="form-control" placeholder="taper le médicament spécialité"
                                        name="sp_nom" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Voie</label>
                                    <select name="voie" class="form-control">
                                        <?php
                                            $voies = DB::table('voies')
                                                ->select('voies.*')
                                                ->distinct()
                                                ->orderBy('cdf_nom', 'ASC')
                                                ->get();
                                            
                                        ?>
                                        <?php $__currentLoopData = $voies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($voie->CDF_CODE_PK); ?>"><?php echo e($voie->CDF_NOM); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Unité</label>
                                    <select name="unite" class="form-control">
                                        <?php
                                            $unites = DB::table('unites')
                                                ->select('unites.*')
                                                ->distinct()
                                                ->orderBy('unite_nom', 'asc')
                                                ->get();
                                        ?>
                                        <?php $__currentLoopData = $unites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($unite->id); ?>"><?php echo e($unite->unite_nom); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                    <label for="Médicament">Médicament(s) DCI lié(s) :</label>
                                    <input type="hidden" name='med_sp_id[]'>
                                    <input type="text" class="form-control" name='medicament_dci' autocomplete="off">
                                </div>
                                <div class="col-sm-1">
                                    <label for=""> </label>
                                    <input type="button" class="btn btn-info" id="addMed" style="margin-top: 25px;"
                                        value="+">
                                </div>
                                <div class="col-sm-12 col-sm-offset-9">
                                    <input type="submit" class="btn btn-primary" id="" value="Ajouter" />
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <?php
                                $sps = DB::table('sp_specialite')
                                    ->where('sp_specialite.SP_ALGERIE', 1)
                                    ->select('sp_specialite.*')
                                    ->limit(2000)
                                    ->get();
                            ?>
                            <?php if(count($sps) > 0): ?>
                                <table class="table table-bordered text-center dataTable " id="example6">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Num :</th>
                                            <th>Spécialité</th>
                                            <th>Médicament(s) (DCI)</th>
                                            <th>Modifier</th>
                                            <th>Supprimer</th>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $sps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>
                                                <td><?php echo e($sp->SP_NOM); ?></td>
                                                <td>
                                                    <?php
                                                        $resultats = DB::table('cosac_compo_subact')
                                                            ->join('sac_subactive', 'sac_subactive.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                            ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $sp->SP_CODE_SQ_PK)
                                                            ->select('sac_subactive.SAC_NOM')
                                                            ->get();
                                                        foreach ($resultats as $key => $resultat) {
                                                            echo $resultat->SAC_NOM . ($key == count($resultats) - 1 ? '.' : ' / ');
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(route('specialite.edit', $sp->SP_CODE_SQ_PK)); ?>"><span
                                                            class="glyphicon glyphicon-edit"></span></a>
                                                </td>
                                                <td>
                                                    
                                                    <form style='display: none;' method='POST'
                                                        action="<?php echo e(route('specialite.destroy', $sp->SP_CODE_SQ_PK)); ?>"
                                                        id='delete-form-<?php echo e($sp->SP_CODE_SQ_PK); ?>'>
                                                        <?php echo e(csrf_field()); ?>

                                                        <?php echo e(method_field('DELETE')); ?>

                                                    </form>
                                                    <a href=""
                                                        onclick="if (confirm('ATTENTION SI VOUS SUPPRIMER CE MEDICAMENT LOPERATION VA AUSSI SUPPRIMER LES MEDICAMENTS DES PATIENTS ,voulez vous supprimer cette ligne ?')) {event.preventDefault(); document.getElementById('delete-form-<?php echo e($sp->SP_CODE_SQ_PK); ?>').submit();} ">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- <script src="<?php echo e(asset('js/datatables.net/js/jquery.dataTables.js')); ?>"></script>
            <script src="<?php echo e(asset('js/datatables.net-bs/js/dataTables.bootstrap.js')); ?>"></script> -->
    <script src="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/jquery/js/jquery-ui.js')); ?>"></script>
    <script type="text/javascript" src="/js/admin/gestion_specialite.js"></script>
    <script>
        $(function() {
            $("#example6").DataTable();
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views/admin/specialite/create.blade.php ENDPATH**/ ?>