<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery/css/jquery_ui.css')); ?>">
    
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
            <div class="col-md-10 col-xs-12 col-md-offset-1">
                <div class="box box-info">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.create', Auth::user())): ?>
                        <div class="box-header with-border">
                            <h3 class="box-title">Ajouter un Tableau de bord</h3>
                            <input type="submit" class="btn btn-primary pull-right" data-toggle="modal"
                                data-target="#modal_create" value="Nouveau Tableau de bord" />
                        </div>
                    <?php endif; ?>
                    <div class="box-body">

                        <?php
                        $elements = DB::table('elements')
                        ->select('element')
                        ->where('bilan','<>','Radiographie')
                            ->distinct()
                            ->orderBy('element', 'ASC')
                            ->pluck('element')
                            ?>

                            <table
                                class="table table-responsive table-bordered table-stripped table-hover text-center dataTable "
                                id="t_biologique">

                                <thead>
                                    <tr class="alert alert-info">
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Inerval par Defaut</th>
                                        <th>Elements</th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.delete', Auth::user())): ?>
                                            <th>Supprimer</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $dashboards = DB::table('dashboards')
                                    ->join('elements','elements.id','dashboards.element_id')
                                    ->groupBy('nom')
                                    ->get();
                                    ?>

                                    <?php $__currentLoopData = $dashboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dashboard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>

                                            <th><?php echo e($dashboard->nom); ?></th>

                                            <th><?php echo e($dashboard->description); ?></th>
                                            <th><?php echo e($dashboard->duree); ?></th>

                                            <th>
                                                <?php
                                                $els = DB::table('dashboards')
                                                ->join('elements','elements.id','dashboards.element_id')
                                                ->where('nom','=',$dashboard->nom)
                                                ->get();
                                                ?>
                                                <?php $__currentLoopData = $els; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($el->element); ?><br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </th>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.delete')): ?>
                                                <td>
                                                    <form style="display: none;" method="POST"
                                                        action="<?php echo e(route('dashboard.destroy', $dashboard->nom)); ?>"
                                                        id="delete-form-<?php echo e($dashboard->nom); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <?php echo e(method_field('DELETE')); ?>

                                                    </form>

                                                    <a href=""
                                                        onclick="
                                                                                                                                                                                                                          if (confirm('Voulez vous vraiment supprimer cet Dashboard ?')) {
                                                                                                                                                                                                                           event.preventDefault();
                                                                                                                                                                                                                           document.getElementById('delete-form-<?php echo e($dashboard->nom); ?>').submit();
                                                                                                                                                                                                                          }
                                                                                                                                                                                                                         "><span
                                                            class="glyphicon glyphicon-trash"></span></a>
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

    <div class="modal fade in" id="modal_create" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="bg-blue modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Nouveau Tableau de bord</h4>
                </div>
                <form class="form-horizontal" id="form_01" role="form" method="POST"
                    action="<?php echo e(route('dashboard.store')); ?>">
                    <div class="modal-body">
                        <div class="element" style="">

                            <?php echo e(csrf_field()); ?>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nom Dashboard</label>
                                <div class="col-sm-9">
                                    <input type="text" id="nom" class="form-control"
                                        placeholder="entrer un nom de dashboard" name="nom" value="<?php echo e(old('nom')); ?>"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Interval par Defaut </label>
                                <div class="col-sm-9">
                                    <select name="duree" class="form-control">
                                        <option value="Dernier jour">Dernier jour</option>
                                        <option value="Derniere semaine">Derniere semaine</option>
                                        <option value="Dernier mois">Dernier mois</option>
                                        <option value="Derniere hospitalisation">Derniere hospitalisation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea type="text" id="desc" class="form-control"
                                        placeholder="entrer une description" name="desc"
                                        value="<?php echo e(old('desc')); ?>"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Elements</label>
                                

                                <div class="col-sm-9">
                                    <select name="elements[]" class="select2" multiple="multiple" style="width:100%"
                                        required>
                                        <?php
                                        $elements = DB::table('elements')->distinct()->get();
                                        ?>

                                        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($element->id); ?>"><?php echo e($element->element); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary pull-right" id="" value="Ajouter Dashboard" />
                            <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
                        </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\graphe\create.blade.php ENDPATH**/ ?>