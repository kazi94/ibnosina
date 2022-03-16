<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
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

        @isset($flag)
            @can('consultations.create', Auth::user())
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_consultation" title="Ajouter une consultation">
                    <i class="fa fa-plus"></i>
                    Consultation</button>
            @endcan
            @can('hospitalisations.create', Auth::user())
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_hospitalisation" title="Faire une demande d'hospitalisation"><i class="fa fa-plus"></i>
                    Hospitalisation</button>
            @endcan
            @can('analyses_biologique.create', Auth::user())
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_demande_examen" title="Prescrire un examen"><i class="fa fa-plus"></i>
                    Examen</button>
            @endcan
            @can('prescriptions.create', Auth::user())
                <button type="button" class="btn btn-outline ml-3 mt-2 no-shadow hidden-sm hidden-xs" data-toggle="modal"
                    data-target="#modal_prescription" title="Rédiger une prescription"><i class="fa fa-plus"></i>
                    Prescription</button>
            @endcan

        @endisset
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav fa-1x">
                <!-- Notifications Menu -->

                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    @if (Auth::user()->notifications)
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>

                            {!! count(Auth::user()->unreadNotifications) ? "<span class='label label-danger'>" .
                                count(Auth::user()->unreadNotifications) . '</span>' : '' !!}

                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Vous avez {{ count(Auth::user()->unreadNotifications) }} nouvelles
                                notifications</li>
                            <!-- {{-- Pharmacists notfications --}} -->
                            <li>
                                @foreach (Auth::user()->unreadNotifications as $notification)
                                    <ul class="menu">
                                        <li style="background: #E4E9F2;">
                                            @if ($notification->type == 'App\Notifications\analyseNotification')
                                                <a href="{{ route('patient.notification', [$notification->data['patient_id'], $notification->data['prescription_id'], $notification->id]) }}"
                                                    title="Prescription num {{ $notification->data['prescription_id'] }} ,Prescrit par Dr.{{ $notification->data['doctor_first_name'] }} {{ $notification->data['doctor_scnd_name'] }}, à risque">
                                                    <i class="fa fa-users text-aqua"></i> Prescription
                                                    num°{{ $notification->data['prescription_id'] }}
                                                    ,Prescrit par Dr.{{ $notification->data['doctor_first_name'] }}
                                                    {{ $notification->data['doctor_scnd_name'] }}, à risque
                                                @else
                                                    {{-- Doctors notfications
                                                    --}}
                                                    <a href="{{ route('patient.notification', [$notification->data['patient_id'], '_', $notification->id]) }}"
                                                        title="Prescription num°{{ $notification->data['prescription_id'] }} est analysé par Dr.{{ $notification->data['pharm_first_name'] }} {{ $notification->data['pharm_scnd_name'] }} .Le : {{ $notification->data['date_ip'] }} ">
                                                        <i class="fa fa-users text-aqua"></i> Prescription
                                                        num°{{ $notification->data['prescription_id'] }} est analysé
                                                        par
                                                        Dr.{{ $notification->data['pharm_first_name'] }}
                                                        {{ $notification->data['pharm_scnd_name'] }} .Le
                                                        : {{ $notification->data['date_ip'] }}
                                            @endif
                                            </a>
                                        </li>
                                        <!-- end notification -->
                                    </ul>
                                @endforeach
                            </li>
                        </ul>
                    @endif
                </li>

                <!-- Messages: style can be found in dropdown.less -->
                {{-- <li class="dropdown  messages-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" :title="info">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">@{{ count }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"> @{{ info }}</li>
                        @foreach ($messages as $message)
                            @if ($message->messageMax != null)
                                <li>
                                    <ul class="menu">
                                        <li>
                                            <a href="{{ route('chat.index') }}">
                                                <div class="pull-left">
                                                    <img src="https://ui-avatars.com/api/?name={{ $message->name }}+{{ $message->prenom }}"
                                                        class="img-circle" alt="User Image">
                                                </div>
                                                <h4>
                                                    <span>{{ $message->name }}</span>
                                                    {{ strlen($message->name) >= 11 ? '<br>' : '' }}
                                                    <span>{{ $message->prenom }}</span>
                                                    <small><i class="fa fa-clock-o"></i>
                                                        {{ date('H:i', strtotime($message->time)) }}</small>
                                                </h4>
                                                <p>{{ $message->message }}</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <last-message v-for="val ,index in chat" v-if="index >= 1" :message="val.message"
                                    :nom="val.nom" :prenom="val.prenom" :time="val.time" :url="val.url">
                                </last-message>
                                {{-- @endif --}}
    {{-- @endforeach 
    <li class="footer">
      <a href="{{ route('chat.index') }}">Allez vers le chat room</a>
                </li>
            </ul>

            </li> --}}





            <!-- Appointements Notification Menu -->
            {{-- <li class="dropdown  messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    title="Vous avez  {{ count($appointements) }} rendez-vous aujourd'hui">
                    <i class="fa fa-flag-o"></i>
                    <span class="label label-primary">{{ count($appointements) }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">Vous avez {{ count($appointements) }} rendez-vous aujourd'hui</li>
                    @foreach ($appointements as $appointement)
                        @if ($appointement->in >= 0)
                            <li>
                                <ul class="menu">
                                    <li>
                                        <!-- start task item -->
                                        <a href="{{ route('patient.edit', ['id' => $appointement->patient_id]) }}">
                                            <div class="pull-left">
                                                <img src="{!!  $appointement->patient->photo ? '/avatar/' . $appointement->patient->photo : '/images/user.jpg' !!}"
                                                    class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                <span>{!! $appointement->patient->nom !!}</span>
                                                {!! strlen($appointement->patient->nom) >= 11 ? '<br>' : '' !!}
                                                <span>{!! $appointement->patient->prenom !!}</span>
                                                <small><i class="fa fa-clock-o"></i> {!! date('H:i',
                                                    strtotime($appointement->start_date)) !!}</small>
                                            </h4>
                                            <p>{{ $appointement->text }}</p>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                        @endif
                    @endforeach
                    <li class="footer">
                        <a href="{{ route('appointement.index') }}">Allez vers le calendrier</a>
                    </li>
                </ul>

            </li> --}}
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}+{{ Auth::user()->prenom }}  "
                        class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ Auth::user()->name }} {{ Auth::user()->prenom }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}+{{ Auth::user()->prenom }}  "
                            class="user-image" alt="User Image" style="float: none; ">

                        <p>
                            {{ Auth::user()->name }} {{ Auth::user()->prenom }} -
                            {{ isset(Auth::user()->specialite) ? Auth::user()->specialite : '' }}
                            <small title="{{ date('m-d-Y', strtotime(Auth::user()->created_at)) }}">Membre depuis
                                {{ Auth::user()->since_date }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    {{-- <li class="user-body">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li> --}}
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ route('user.profile', ['id' => Auth::user()->id]) }}"
                                class="btn btn-github btn-flat" style="background: #444444;">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt fa-2x text-black" title="Se déconnecter"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
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
