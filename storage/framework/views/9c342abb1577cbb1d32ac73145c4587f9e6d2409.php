<!--direct chat Message-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_1' ? 'active in' : ''); ?>" id="tab_1">
    <!-- Direct Chat -->
    <div class="row">
        <div class="col-md-12">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Annotations</h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool btn-chat" data-widget="collapse"
                            style="box-shadow: none;"><i class="fa fa-minus"></i>
                        </button>
                        <!--  <button type="button" class="btn btn-box-tool btn-chat" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle" style="box-shadow: none;">
                            <i class="fa fa-comments"></i></button> -->
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                        <?php $__currentLoopData = $annotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($annotation->annotation_id == null): ?>
                                <div class="direct-chat-msg  <?php if($annotation->user_id ==
                                    Auth::user()->id): ?> right <?php endif; ?>">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name <?php if($annotation->user_id ==
                                            Auth::user()->id): ?> pull-right <?php endif; ?>"><?php echo e($annotation->name); ?> <?php echo e($annotation->prenom); ?></span>
                                    <span class="direct-chat-timestamp <?php if($annotation->user_id == Auth::user()->id): ?> pull-left <?php else: ?>
                                            pull-right <?php endif; ?>"><?php echo e($annotation->date); ?></span>
                                    </div>
                                    <!-- /.direct-chat-info -->
                                    <img class="direct-chat-img" src="<?php echo e(asset('/images/user.jpg')); ?>"
                                        alt="Message User Image"><!-- /.direct-chat-img -->

                                    <div class="direct-chat-text"
                                        style="background: #34c5d6;border-color: #00a65a;color:#212c35;border: 0;border-radius: 5px 5px 5px 5px;">

                                        <div class="row">

                                            <div class="col-md-8">
                                                <div>
                                                    Domaine: <?php echo e($annotation->domaine); ?> <br>
                                                    Sujet: <?php echo e($annotation->sujet); ?>

                                                </div>
                                                <?php if($annotation->commentaire != null): ?>
                                                    <?php
                                                    echo htmlspecialchars_decode(stripslashes($annotation->commentaire))
                                                    ;
                                                    ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-md-4  pull-right">
                                                <?php if($annotation->audio != null): ?>
                                                    <audio class="pull-right" preload="metadata" controls
                                                        controlsList="nodownload" style="height: 25px; width: 350px;">
                                                        <source src="/storage/<?php echo e($annotation->audio); ?>"
                                                            type="audio/mpeg">
                                                        Sorry, your browser doesn't support html5!
                                                    </audio>
                                                <?php endif; ?>
                                                <a>
                                                    <button id="btn_ann_anno" class="btn btn-default pull-right"
                                                        data-toggle="modal" data-target="#modal_annotation"
                                                        data-id="<?php echo e($annotation->id); ?>" data-type="annotation"
                                                        style="border-radius: 50%;">
                                                        <i class="fa fa-comment-medical"></i>
                                                    </button>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                    <?php $__currentLoopData = $annotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($anno->annotation_id == $annotation->id): ?>
                                            <!-- les sous annotations      -->
                                            <div style="padding-left: 55px;">

                                                <div class="direct-chat-msg  <?php if($anno->user_id
                                                    == Auth::user()->id): ?> right <?php endif; ?>">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name <?php if($anno->user_id == Auth::user()->id): ?> pull-right <?php endif; ?>"><?php echo e($anno->name); ?>

                                                            <?php echo e($anno->prenom); ?></span>
                                                        <span class="direct-chat-timestamp <?php if($anno->user_id == Auth::user()->id): ?> pull-left
                                                        <?php else: ?> pull-right <?php endif; ?>"><?php echo e($anno->date); ?></span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="<?php echo e(asset('/images/user.jpg')); ?>"
                                                        alt="Message User Image"><!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text"
                                                        style="background: #34cccc;border-color: #00a65a;color:#212c35;border: 0;border-radius: 5px 5px 5px 5px;">
                                                        <div class="row">

                                                            <div class="col-md-8">
                                                                <div>
                                                                    Domaine: <?php echo e($anno->domaine); ?> <br>
                                                                    Sujet: <?php echo e($anno->sujet); ?>

                                                                </div>
                                                                <?php if($anno->commentaire != null): ?>
                                                                    <?php
                                                                    echo
                                                                    htmlspecialchars_decode(stripslashes($anno->commentaire))
                                                                    ;
                                                                    ?>
                                                                <?php endif; ?>
                                                            </div>

                                                            <div class="col-md-4  pull-right">
                                                                <?php if($anno->audio != null): ?>
                                                                    <audio class="pull-right" preload="metadata"
                                                                        controls controlsList="nodownload"
                                                                        style="height: 25px; width: 350px;">
                                                                        <source src="/storage/<?php echo e($anno->audio); ?>"
                                                                            type="audio/mpeg">
                                                                        Sorry, your browser doesn't support html5!
                                                                    </audio>
                                                                <?php endif; ?>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>

                                            </div>
                                            <!-- fin les sous annotations-->
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!-- /.direct-chat-text -->
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!--/.direct-chat-messages-->

                </div>
                <!-- /.box-body -->
                <!-- <div class="box-footer">
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Taper un message ..." class="form-control" required>
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat envoyer" data-id="<?php echo e($patient->id); ?>" data-user="<?php echo e(Auth::user()->id); ?>" data-name="<?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->prenom); ?>" >Envoyer</button> </span>
                    </div>
                </div> -->
                <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
        </div>
        <!-- /.col -->
    </div>
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/tabs/message.blade.php ENDPATH**/ ?>