<!--  -->
<div class="tab-pane <?php echo e(session('tab') == 'tab_8' ? 'active in' : ''); ?>" id="tab_8">
    <div class="clearfix">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left" title="Raccourci(o)" data-toggle="modal"
                    data-target="#modal_question">Lancer questionnaire</button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.export', Auth::user())): ?>
            <a href="/export/ques/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        <?php endif; ?>
    </div>

    <div class="box box-widget">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12 ">
                    <table id="example21" class="nowrap table table-bordered table-hover text-center">
                        <thead style="background-color: #390d70c2 !important; color:white">
                            <tr>
                                <th>Num°</th>
                                <th>Type questionnaire</th>
                                <th>Date</th>
                                <th>Observations</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.delete', Auth::user())): ?>
                                    <th>Supprimer</th>
                                <?php endif; ?>
                                <th>Annotation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient->questionnaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th><?php echo e($loop->index + 1); ?></th>
                                    <th><?php echo e($res->type); ?></th>
                                    <th><?php echo e($res->pivot->date_questionnaire); ?></th>
                                    <th>
                                        <?php if($res->pivot->reponse == '1' || $res->pivot->reponse == '2'): ?>
                                            <p class=" label-warning">Patient modérément observant</p>
                                        <?php elseif($res->pivot->reponse == "3" || $res->pivot->reponse == "4"): ?>
                                            <p class=" label-danger">Patient non observant</p>
                                        <?php else: ?>
                                            <p class=" label-success">Patient très observant</p>
                                        <?php endif; ?>
                                    </th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.delete', Auth::user())): ?>
                                        <td>
                                            <?php if(!$patient->readonly): ?>
                                                <a href="" class="deleteRow"
                                                    data-url="/patient/questionnairePatient/destroy/<?php echo e($res->pivot->questionnaire_id); ?>&<?php echo e($patient->id); ?>&<?php echo e($res->pivot->user_id); ?>&<?php echo e($res->pivot->date_questionnaire); ?>"
                                                    style="color: inherit; cursor: pointer;"><span
                                                        class="glyphicon glyphicon-trash fa-2x"></span></a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if(!$patient->readonly): ?>
                                            <a href="#" id="btn_ann_obs" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="observance"
                                                data-id="<?php echo e($res->date_questionnaire); ?>">
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
<?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/tabs/observance.blade.php ENDPATH**/ ?>