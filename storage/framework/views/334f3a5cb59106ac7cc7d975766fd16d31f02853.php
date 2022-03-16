<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name); ?>+<?php echo e(Auth::user()->prenom); ?>  "
                    class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>
                    Mr.<?php echo e(Auth::user()->name); ?>

                    <?php echo isset(Auth::user()->grade) ? ',<br> <small>' . Auth::user()->grade . '</small>' : ''; ?>

                    <?php echo isset(Auth::user()->specialite) ? ',<br></small>' . Auth::user()->specialite . '</small>' : ''; ?>

                </p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> En ligne</a>
            </div>
        </div>

        <div action="" method="" class="sidebar-form" style="overflow: inherit">
            <div class="input-group">
                <input type="hidden" name="patient_pick">
                <input type="text" name="q" class="form-control" placeholder="Rechercher..." autocomplete="off">
                <div class="input-group-btn">
                    <button type="button" name="search" class="btn btn-flat"><a href="" class="pick_patient"><i
                                class="fa fa-search" style="margin-top:-0px;"></i> </a></button>
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false"><span class="caret"></span></button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('is-admin', Auth::user())): ?>
                <li class="header">ADMINISTRATION</li>
                <!-- Optionally, you can add icons to the links -->

                <li class="treeview">
                    <a href="#"><i class="fa fa-user"></i> <span>Comptes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        

                        <li>
                            <a href="<?php echo e(route('user.index')); ?>"><i class="fa fa-user-plus"></i> <span>Utilisateurs
                                    Internes</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('is-admin', Auth::user())): ?>
                            <li>
                                <a href="<?php echo e(route('admin.logs')); ?>"><i class="fa fa-cogs"></i> <span>
                                        Activités utilisateurs</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        <?php endif; ?>
                        

                        <li>
                            <a href="<?php echo e(route('profile.index')); ?>"><i class="fa fa-users"></i> <span>Profils</span>
                                <span class="pull-right-container"></span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><i class="fa fa-cogs"></i> <span>Paramètres</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">
                        <li>
                            <a href="<?php echo e(route('element.index')); ?>"><i class="fa fa-flask"></i> <span>Bilans</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>

                        

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.view', Auth::user())): ?>
                            <li>
                                <a href="<?php echo e(route('dashboard.index')); ?>"><i class="fa fa-chart-bar"></i> <span>Les Tableaux de
                                        bord</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        <?php endif; ?>


                        <li>
                            <a href="<?php echo e(route('specialite.index')); ?>"><i class="fa fa-cog"></i> <span>Création d'une
                                    spécialité</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('produit.index')); ?>"><i class="fa fa-leaf"></i><span>Phytothérapeutes</span>
                                <span class="pull-right-container"></span>
                            </a>
                        </li>


                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editeur_regle', Auth::user())): ?>
                            <li>
                                <a href="<?php echo e(route('regle.index')); ?>"><i class="fa fa-cog"></i> <span>Règles de
                                        pré-analyse</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        <?php endif; ?>


                        

                        <li>
                            <a href="<?php echo e(route('questionnaires.index')); ?>"><i class="fa fa-cog"></i>
                                <span>Questionnaires</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/settings"><i class="fa fa-flask"></i> <span>Générales</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cogs"></i> <span>Chimiothérapie</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li>
                                    <a href="<?php echo e(route('para')); ?>">
                                        <i class="fa fa-wrench"></i><span>&nbsp;Paramètre
                                            générale
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo e(route('listProtocole')); ?>">
                                        <i class="fa fa-pinterest"></i><span>
                                            style="width: 8%">&nbsp;&nbsp;Lister les protocoles</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('listMaladie.index')); ?>">
                                        <i class="fa fa-hotel"></i><span>
                                            style="width: 8%">&nbsp;&nbsp;Lister les maladies</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('preparation.index')); ?>"><i
                                            class="fa fa-flask"></i><span>&nbsp;Dash
                                            préparateurs</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
            <?php endif; ?>
            <li class="header">PRINCIPALE</li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.view', Auth::user())): ?>
                <li class="treeview">
                    <a href="#"><i class="fa fa-wheelchair"></i> <span>DMP</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?php echo e(route('prescription-type.index')); ?>"><i class="fa fa-cog"></i>
                                <span>Prescriptions
                                    Type</span>
                                <span class="pull-right-container"></span>
                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.create', Auth::user())): ?>
                            <li>
                                <a href="<?php echo e(route('patient.create.step.one.get', ['type' => 'normal'])); ?>"><i
                                        class="fa fa-user-plus"></i> <span>Ajouter
                                        patient</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.view', Auth::user())): ?>
                            <li>
                                <a href="<?php echo e(route('patient.index')); ?>"><i class="fa fa-user-injured"></i> <span>Liste des
                                        patients</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyse_therap', Auth::user())): ?>
                <li class="treeview">
                    <a href="#"><i class="fa fa-folder-open"></i> <span>Dossier pharmaceutique</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                            <li>
                                <a href="<?php echo e(route('intervention.show')); ?>"><i class="fa fa-clipboard-list"></i>
                                    <span>Préscriptions
                                        à
                                        analyser</span></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyse_therap', Auth::user())): ?>
                            <li>
                                <a href="<?php echo e(route('education.todo')); ?>"><i class="fa fa-history"></i> <span>Education
                                        thérapeutique</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a href="<?php echo e(route('intervention.history')); ?>"><i class="fa fa-history"></i>
                                <span>Historique
                                    IP</span>
                                <span class="pull-right-container"></span></a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('questionnaire.show', Auth::user()->id)); ?>"><i class="fa fa-history"></i>
                                <span>Historique Observances</span>
                                <span class="pull-right-container"></span></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
                <li class="treeview">
                    <a href="#"><i class="fa fa-folder "></i> <span>Pharmacovigilance</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <li>
                            <a href="<?php echo e(route('pharmaco.index')); ?>"><i class="fa fa-folder-o"></i> <span>Formulaire
                                    pharmacovigilance</span></a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('liste1')); ?>"><i class="fa fa-list"></i> <span>Liste enregistrée</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('liste2')); ?>"><i class="fa fa-list"></i> <span>Liste envoyée</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <li class="treeview">
                <a href="#"><i class="fa fa-star"></i> <span>Divers</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo e(route('appointement.index')); ?>"><i class="fa fa-calendar-check"></i>
                            <span>Rendez-vous</span></a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('stats.index')); ?>"><i class="fa fa-chart-bar"></i>
                            <span>Statistiques</span></a>
                    </li>
                    
                    
                </ul>
            </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
<!-- Main Header -->
<?php /**PATH C:\laragon\www\anapharm\resources\views/layouts/aside.blade.php ENDPATH**/ ?>