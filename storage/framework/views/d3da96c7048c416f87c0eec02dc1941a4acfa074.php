<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo e(route('home')); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>I</b><b style="color:#fc1313">B</b><b style="color:#04ff04">S</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Ibno</b><b style="color:#fc1313">SINA</b><b style="color:#04ff04">Dz</b></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="fa fa-bars"></span>
        </a>

        <?php if(isset($flag)): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.create', Auth::user())): ?>
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_consultation" title="Ajouter une consultation">
                    <i class="fa fa-plus"></i>
                    Consultation</button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.create', Auth::user())): ?>
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_hospitalisation" title="Faire une demande d'hospitalisation"><i class="fa fa-plus"></i>
                    Hospitalisation</button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.create', Auth::user())): ?>
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_demande_examen" title="Prescrire un examen"><i class="fa fa-plus"></i>
                    Examen</button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.create', Auth::user())): ?>
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_prescription" title="Rédiger une prescription"><i class="fa fa-plus"></i>
                    Prescription</button>
            <?php endif; ?>

        <?php endif; ?>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav fa-1x">
                <!-- Notifications Menu -->

                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <?php if(Auth::user()->notifications): ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>

                            <?php echo count(Auth::user()->unreadNotifications) ? "<span class='label label-danger'>" .
                                count(Auth::user()->unreadNotifications) . '</span>' : ''; ?>


                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Vous avez <?php echo e(count(Auth::user()->unreadNotifications)); ?> nouvelles
                                notifications</li>
                            <!--  -->
                            <li>
                                <?php $__currentLoopData = Auth::user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <ul class="menu">
                                        <li style="background: #E4E9F2;">
                                            <?php if($notification->type == 'App\Notifications\analyseNotification'): ?>
                                                <a href="<?php echo e(route('patient.notification', [$notification->data['patient_id'], $notification->data['prescription_id'], $notification->id])); ?>"
                                                    title="Prescription num <?php echo e($notification->data['prescription_id']); ?> ,Prescrit par Dr.<?php echo e($notification->data['doctor_first_name']); ?> <?php echo e($notification->data['doctor_scnd_name']); ?>, à risque">
                                                    <i class="fa fa-users text-aqua"></i> Prescription
                                                    num°<?php echo e($notification->data['prescription_id']); ?>

                                                    ,Prescrit par Dr.<?php echo e($notification->data['doctor_first_name']); ?>

                                                    <?php echo e($notification->data['doctor_scnd_name']); ?>, à risque
                                                <?php else: ?>
                                                    
                                                    <a href="<?php echo e(route('patient.notification', [$notification->data['patient_id'], '_', $notification->id])); ?>"
                                                        title="Prescription num°<?php echo e($notification->data['prescription_id']); ?> est analysé par Dr.<?php echo e($notification->data['pharm_first_name']); ?> <?php echo e($notification->data['pharm_scnd_name']); ?> .Le : <?php echo e($notification->data['date_ip']); ?> ">
                                                        <i class="fa fa-users text-aqua"></i> Prescription
                                                        num°<?php echo e($notification->data['prescription_id']); ?> est analysé
                                                        par
                                                        Dr.<?php echo e($notification->data['pharm_first_name']); ?>

                                                        <?php echo e($notification->data['pharm_scnd_name']); ?> .Le
                                                        : <?php echo e($notification->data['date_ip']); ?>

                                            <?php endif; ?>
                                            </a>
                                        </li>
                                        <!-- end notification -->
                                    </ul>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </li>
                        </ul>
                    <?php endif; ?>
                </li>

                <!-- Messages: style can be found in dropdown.less -->
                
    





            <!-- Appointements Notification Menu -->
            
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name); ?>+<?php echo e(Auth::user()->prenom); ?>  "
                        class="user-image" alt="User Image">
                    <span class="hidden-xs"><?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->prenom); ?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name); ?>+<?php echo e(Auth::user()->prenom); ?>  "
                            class="user-image" alt="User Image" style="float: none; ">

                        <p>
                            <?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->prenom); ?> -
                            <?php echo e(isset(Auth::user()->specialite) ? Auth::user()->specialite : ''); ?>

                            <small title="<?php echo e(date('m-d-Y', strtotime(Auth::user()->created_at))); ?>">Membre depuis
                                <?php echo e(Auth::user()->since_date); ?></small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?php echo e(route('user.profile', ['id' => Auth::user()->id])); ?>"
                                class="btn btn-github btn-flat" style="background: #444444;">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt fa-2x text-black" title="Se déconnecter"></i>
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </div>
                    </li>
                </ul>
            </li>
            <li> <a href="/docs/" target="_blank"><i class="fa fa-info" title="Aide et assistance"></i></a> </li>

            </ul>
        </div>
    </nav>
</header>
<?php /**PATH C:\laragon\www\anapharm\resources\views\layouts\header.blade.php ENDPATH**/ ?>