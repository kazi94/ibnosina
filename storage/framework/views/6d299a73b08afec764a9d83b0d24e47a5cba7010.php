<!--tab act-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_12' ? 'active in' : ''); ?>" id="tab_12">
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li class="active">Prescription Act</li>
        </ol>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#modal_act"
                    title="">Ajouter act medicale</button>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.export', Auth::user())): ?>
            <a href="/export/act/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        <?php endif; ?>
    </div>

    <div id="labelforma3" name="labelforma3" style="display:block">
        <div class="box box-widget">

            

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="table_act" class="nowrap table table-bordered table-hover text-center">
                            <thead style="background-color:#d10300ab !important; color:white">
                                <tr>
                                    <th>#</th>
                                    <th>Act medical</th>
                                    <th>Description</th>
                                    <th>date</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                    
                                    <th>Annotation</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $patient->act; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aaa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index + 1); ?></td>

                                        <?php
                                            $z = DB::table('act_medicales')
                                                ->where('id', $aaa->act_medicale_id)
                                                ->select('act_medicales.*')
                                                ->get();
                                        ?>
                                        <?php $__currentLoopData = $z; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td
                                                style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                <span title="<?php echo e($zz->nom); ?>"><?php echo e($zz->nom); ?> </span>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td
                                            style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                            <span data-toggle="tooltip"
                                                title="<?php echo e($aaa->description); ?>"><?php echo e($aaa->description); ?> </span>
                                        </td>
                                        <td
                                            style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                            <span data-toggle="tooltip" title="<?php echo e($aaa->date_act); ?>">
                                                <?php echo e($aaa->date_act); ?> </span>
                                        </td>
                                        <td>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.update', Auth::user())): ?>
                                                <?php if(!$patient->readonly): ?>
                                                    <a href="#modifier-act" class="edit_act_med" title="Modifier l'act"
                                                        data-toggle="modal" data-id="<?php echo e($aaa->id); ?>">
                                                        <i class="fa fa-edit text-green fa-2x"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.delete', Auth::user())): ?>
                                                <?php if(!$patient->readonly): ?>
                                                    <form style="display: none;" method="POST"
                                                        action="<?php echo e(route('actee.delete', $aaa->id)); ?>"
                                                        id="delete-formee-<?php echo e($aaa->id); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <?php echo e(method_field('DELETE')); ?>

                                                    </form>

                                                    <a href="" onclick="
                                                                                                        if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                        event.preventDefault();
                                                                                                        document.getElementById('delete-formee-<?php echo e($aaa->id); ?>').submit();										}
                                                                                                       "
                                                        style="color: inherit; ">
                                                        <span class="fa fa-trash text-red fa-2x"></span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <a href="#" id="btn_ann_act" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="act"
                                                data-id="<?php echo e($aaa->id); ?>">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                            </a>
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
    <!--div affiché apres clique act avec consultation-->
    <!-- <div id="labelfor3" name="labelfor3" style="display: none">
        <div class="box box-widget">

            <div class="box-body">

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example127" class="nowrap table table-bordered table-hover text-center">
                            <thead style="background-color:#d10300ab !important">
                                <tr>
                                    <th>Num°:</th>
                                    <th>Date</th>
                                    <th>Motif</th>
                                    <th>Signe Formelle</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $patient->consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr data-toggle="collapse" href="#mz<?php echo e($loop->index + 1); ?>"
                                        style="cursor: pointer;">
                                        <td> <?php echo e($loop->index + 1); ?> </td>
                                        <td> <?php echo e($consultation->date_consultation); ?> </td>
                                        <td> <?php echo e($consultation->motif); ?> </td>
                                        <td> <?php echo e($consultation->signe); ?> </td>


                                    </tr>
                                    <?php
                                        $resultats = DB::table('act_medicale_patients')
                                            ->where('consultation_id', $consultation->id)
                                            ->select('act_medicale_patients.*')
                                            ->get();
                                    ?>
                                    <?php if(count($resultats) > 0): ?>
                                        <tr>
                                            <td colspan="5" style="padding: 0 !important;">
                                                <div id="mz<?php echo e($loop->index + 1); ?>" class="accordian-body collapse">
                                                    <table class="table table-bordered">
                                                        <thead class="bg-gray">
                                                            <tr>
                                                                <th>Operations</th>
                                                                <th>Num </th>
                                                                <th>act </th>
                                                                <th> Description </th>
                                                                <th>date act</th>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.print', Auth::user())): ?>
                                                                            <th>Impression</th>
                                                                <?php endif; ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php $__currentLoopData = $resultats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aaa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.delete', Auth::user())): ?>
                                                                                    <form style="display: none;" method="POST"
                                                                                        action="<?php echo e(route('actee.delete', $aaa->id)); ?>"
                                                                                        id="delete-formee-<?php echo e($aaa->id); ?>">
                                                                                        <?php echo e(csrf_field()); ?>

                                                                                        <?php echo e(method_field('DELETE')); ?>

                                                                                    </form>

                                                                                    <a href="" onclick="
                                                                                                        if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                        event.preventDefault();
                                                                                                        document.getElementById('delete-formee-<?php echo e($aaa->id); ?>').submit();										}
                                                                                                       "
                                                                                        style="color: inherit; "><span
                                                                                            class="glyphicon glyphicon-trash"></span></a>
                                                                        <?php endif; ?>
                                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.update', Auth::user())): ?>
                                                                                    <i class="glyphicon glyphicon-edit edit_act_med"
                                                                                        title="Modifier" style="cursor: pointer"
                                                                                        id="<?php echo e($aaa->id); ?>"></i>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td> <?php echo e($loop->index + 1); ?> </td>
                                                                    <?php
                                                                        $z = DB::table('act_medicales')
                                                                            ->where('id', $aaa->act_medicale_id)
                                                                            ->select('act_medicales.*')
                                                                            ->get();
                                                                    ?>
                                                                    <?php $__currentLoopData = $z; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <td
                                                                            style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                                            <span
                                                                                title="<?php echo e($zz->nom); ?>"><?php echo e($zz->nom); ?>

                                                                            </span>
                                                                        </td>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <td
                                                                        style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                                        <span data-toggle="tooltip"
                                                                            title="<?php echo e($aaa->description); ?>"><?php echo e($aaa->description); ?>

                                                                        </span>
                                                                    </td>
                                                                    <td
                                                                        style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                                        <span data-toggle="tooltip"
                                                                            title="<?php echo e($aaa->date_act); ?>">
                                                                            <?php echo e($aaa->date_act); ?> </span>
                                                                    </td>
                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.print', Auth::user())): ?>
                                                                                <td> <a href="" target="_blank"><button
                                                                                            class="btn btn-default"><i
                                                                                                class="fa fa-print"></i>
                                                                                            Act</button></a></td>
                                                                    <?php endif; ?>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
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

        <div class="box box-widget">

            <div class="box-header">
                <h3>Act Sans Consultation</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="hist_acts" class="nowrap table table-bordered table-hover text-center">
                            <thead class="bg-gray">
                                <tr>
                                    <th>Operations</th>
                                    <th>Num </th>
                                    <th>act </th>
                                    <th> Description </th>
                                    <th>date act</th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.print', Auth::user())): ?>
                                                <th>Impression</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $resulta = DB::table('act_medicale_patients')
                                        ->where('patient_id', $patient->id)
                                        ->select('act_medicale_patients.*')
                                        ->get();
                                ?>

                                <?php $__currentLoopData = $resulta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aaa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($aaa->consultation_id == ''): ?>
                                        <tr>
                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.delete', Auth::user())): ?>
                                                            <form style="display: none;" method="POST"
                                                                action="<?php echo e(route('actee.delete', $aaa->id)); ?>"
                                                                id="delete-formee-<?php echo e($aaa->id); ?>">
                                                                <?php echo e(csrf_field()); ?>

                                                                <?php echo e(method_field('DELETE')); ?>

                                                            </form>

                                                            <a href="" onclick="
                                                                                                        if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                        event.preventDefault();
                                                                                                        document.getElementById('delete-formee-<?php echo e($aaa->id); ?>').submit();										}
                                                                                                       "
                                                                style="color: inherit; "><span
                                                                    class="glyphicon glyphicon-trash"></span></a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.update', Auth::user())): ?>
                                                            <i class="glyphicon glyphicon-edit edit_act_med" title="Modifier"
                                                                style="cursor: pointer" id="<?php echo e($aaa->id); ?>"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td> <?php echo e($loop->index + 1); ?> </td>
                                            <?php
                                                $z = DB::table('act_medicales')
                                                    ->where('id', $aaa->act_medicale_id)
                                                    ->select('act_medicales.*')
                                                    ->get();
                                            ?>
                                            <?php $__currentLoopData = $z; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td
                                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                    <span title="<?php echo e($zz->nom); ?>"><?php echo e($zz->nom); ?> </span>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td
                                                style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                <span data-toggle="tooltip"
                                                    title="<?php echo e($aaa->description); ?>"><?php echo e($aaa->description); ?>

                                                </span>
                                            </td>
                                            <td
                                                style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                <span data-toggle="tooltip" title="<?php echo e($aaa->date_act); ?>">
                                                    <?php echo e($aaa->date_act); ?> </span>
                                            </td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.print', Auth::user())): ?>
                                                        <td> <a href="" target="_blank"><button class="btn btn-default"><i
                                                                        class="fa fa-print"></i> Act</button></a></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div>
            </div>
        </div> -->
    <!--fin tab act-->
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\tabs\act_medicale.blade.php ENDPATH**/ ?>