<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}+{{ Auth::user()->prenom }}  "
                    class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>
                    Mr.{{ Auth::user()->name }}
                    {!! isset(Auth::user()->grade) ? ',<br> <small>' . Auth::user()->grade . '</small>' : '' !!}
                    {!! isset(Auth::user()->specialite) ? ',<br></small>' . Auth::user()->specialite . '</small>' : '' !!}
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
                            {{-- <div
                                class="dropdown-menu dropdown-menu-right dropdown-menu-filter" role="menu">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="filter">Date de Naissance</label>
                                        <input type="date" name="" id="" class="form-control">
                                        <input type="date" name="" id="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="contain">Matricule</label>
                                        <input class="form-control" type="text" value="Veuillez entrer le texte ici" />
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            @can('is-admin', Auth::user())
                <li class="header">ADMINISTRATION</li>
                <!-- Optionally, you can add icons to the links -->

                <li class="treeview">
                    <a href="#"><i class="fa fa-user"></i> <span>Comptes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        {{-- @can('compte_externe.view', Auth::user())
                        <li>
                            <a href="{{ route('userEx.index') }}"><i class="fa fa-user-plus"></i> <span>Utilisateurs
                                    Externes</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                        @endcan --}}

                        <li>
                            <a href="{{ route('user.index') }}"><i class="fa fa-user-plus"></i> <span>Utilisateurs
                                    Internes</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                        @can('is-admin', Auth::user())
                            <li>
                                <a href="{{ route('admin.logs') }}"><i class="fa fa-cogs"></i> <span>
                                        Activités utilisateurs</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        @endcan
                        {{-- @can('compte_patient.view', Auth::user())
                        <li>
                            <a href="{{ route('compte.index') }}"><i class="fa fa-user-plus"></i> <span>Comptes
                                    Patients</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                        @endcan --}}

                        <li>
                            <a href="{{ route('profile.index') }}"><i class="fa fa-users"></i> <span>Profils</span>
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
                            <a href="{{ route('element.index') }}"><i class="fa fa-flask"></i> <span>Bilans</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>

                        {{-- <li>
                            <a href="{{ route('medicaments.index') }}"><i class="fa fa-flask"></i> <span>Voie
                                    d'administration</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li> --}}

                        @can('dashboard.view', Auth::user())
                            <li>
                                <a href="{{ route('dashboard.index') }}"><i class="fa fa-chart-bar"></i> <span>Les Tableaux de
                                        bord</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        @endcan


                        <li>
                            <a href="{{ route('specialite.index') }}"><i class="fa fa-cog"></i> <span>Création d'une
                                    spécialité</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('produit.index') }}"><i class="fa fa-leaf"></i><span>Phytothérapeutes</span>
                                <span class="pull-right-container"></span>
                            </a>
                        </li>


                        @can('editeur_regle', Auth::user())
                            <li>
                                <a href="{{ route('regle.index') }}"><i class="fa fa-cog"></i> <span>Règles de
                                        pré-analyse</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        @endcan


                        {{-- <li>
                            <a href="{{ route('unite.index') }}"><i class="fa fa-cog"></i> <span>Paramètres des
                                    unités</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li> --}}

                        <li>
                            <a href="{{ route('questionnaires.index') }}"><i class="fa fa-cog"></i>
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
                                    <a href="{{ route('para') }}">
                                        <i class="fa fa-wrench"></i><span>&nbsp;Paramètre
                                            générale
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('listProtocole') }}">
                                        <i class="fa fa-pinterest"></i><span>
                                            style="width: 8%">&nbsp;&nbsp;Lister les protocoles</a>
                                </li>
                                <li>
                                    <a href="{{ route('listMaladie.index') }}">
                                        <i class="fa fa-hotel"></i><span>
                                            style="width: 8%">&nbsp;&nbsp;Lister les maladies</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('preparation.index') }}"><i
                                            class="fa fa-flask"></i><span>&nbsp;Dash
                                            préparateurs</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
            @endcan
            <li class="header">PRINCIPALE</li>
            @can('patients.view', Auth::user())
                <li class="treeview">
                    <a href="#"><i class="fa fa-wheelchair"></i> <span>DMP</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('prescription-type.index') }}"><i class="fa fa-cog"></i>
                                <span>Prescriptions
                                    Type</span>
                                <span class="pull-right-container"></span>
                            </a>
                        </li>
                        @can('patients.create', Auth::user())
                            <li>
                                <a href="{{ route('patient.create.step.one.get', ['type' => 'normal']) }}"><i
                                        class="fa fa-user-plus"></i> <span>Ajouter
                                        patient</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                        @endcan

                        @can('patients.view', Auth::user())
                            <li>
                                <a href="{{ route('patient.index') }}"><i class="fa fa-user-injured"></i> <span>Liste des
                                        patients</span>
                                    <span class="pull-right-container"></span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('analyse_therap', Auth::user())
                <li class="treeview">
                    <a href="#"><i class="fa fa-folder-open"></i> <span>Dossier pharmaceutique</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('peut-analyser', Auth::user())
                            <li>
                                <a href="{{ route('intervention.show') }}"><i class="fa fa-clipboard-list"></i>
                                    <span>Préscriptions
                                        à
                                        analyser</span></a>
                            </li>
                        @endcan

                        @can('analyse_therap', Auth::user())
                            <li>
                                <a href="{{ route('education.todo') }}"><i class="fa fa-history"></i> <span>Education
                                        thérapeutique</span>
                                    <span class="pull-right-container">
                                    </span>
                                </a>
                            </li>
                        @endcan

                        <li>
                            <a href="{{ route('intervention.history') }}"><i class="fa fa-history"></i>
                                <span>Historique
                                    IP</span>
                                <span class="pull-right-container"></span></a>
                        </li>

                        <li>
                            <a href="{{ route('questionnaire.show', Auth::user()->id) }}"><i class="fa fa-history"></i>
                                <span>Historique Observances</span>
                                <span class="pull-right-container"></span></a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('peut-analyser', Auth::user())
                <li class="treeview">
                    <a href="#"><i class="fa fa-folder "></i> <span>Pharmacovigilance</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

                        <li>
                            <a href="{{ route('pharmaco.index') }}"><i class="fa fa-folder-o"></i> <span>Formulaire
                                    pharmacovigilance</span></a>
                        </li>

                        <li>
                            <a href="{{ route('liste1') }}"><i class="fa fa-list"></i> <span>Liste enregistrée</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('liste2') }}"><i class="fa fa-list"></i> <span>Liste envoyée</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <li class="treeview">
                <a href="#"><i class="fa fa-star"></i> <span>Divers</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('appointement.index') }}"><i class="fa fa-calendar-check"></i>
                            <span>Rendez-vous</span></a>
                    </li>
                    <li>
                        <a href="{{ route('stats.index') }}"><i class="fa fa-chart-bar"></i>
                            <span>Statistiques</span></a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('chat.index') }}"><i class="fa fa-wechat"></i> <span>Chat Room</span></a>
                    </li> --}}
                    {{-- <li>
                        <a href="{{ route('stats.index') }}"><i class="fa  fa-envelope"></i> <span>Boite de
                                Messagerie</span></a>
                    </li> --}}
                </ul>
            </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
<!-- Main Header -->
