@extends('layouts.model1')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            @if (count($errors) > 0)

                @foreach ($errors->all() as $error)

                    <p class="alert alert-danger">{{ $error }}</p>

                @endforeach

            @endif

            @if (session()->has('message'))

                <p class="alert alert-success">{{ session('message') }}</p>

            @endif
            <div class="row">

                <div class="col-md-6 col-sm-offset-2">

                    <!-- Horizontal Form -->
                    <div class="box box-info">

                        <div class="box-header with-border">

                            <h3 class="box-title">Modifier utilisateur</h3>

                        </div>
                        <!-- /.box-header -->

                        <!-- form start -->

                        <div class="box-body">
                            <form class="form-horizontal" role="form" method="POST"
                                action="{{ route('user.update', $user->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}

                                <div class="form-group">
                                    <label for="matricule" class="label-control col-xs-3"> Matricule*</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="matricule" id="matricule"
                                            placeholder="matricule" value="{{ $user->matricule }}" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Nom" class="label-control col-xs-3"> Nom*</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="name" id="nom" placeholder="nom"
                                            value="{{ $user->name }}" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Prénom" class="label-control col-xs-3"> Prénom*</label>
                                    <div class="col-xs-9">
                                        <input type="text" class="form-control" name="prenom" id="prenom"
                                            placeholder="prénom" value="{{ $user->prenom }}" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="matricule" class="label-control col-xs-3"> Date de Naissance</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" name="date_naissance" id="date_naissance"
                                            placeholder="date_naissance" value="{{ $user->date_naissance }}">
                                    </div>
                                </div>
                                @isset($roles)
                                    <div class="form-group">
                                        <label for="matricule" class="label-control col-xs-3"> Email*</label>
                                        <div class="col-xs-9">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="email"
                                                value="{{ $user->email }}" autocomplete="off" required />
                                        </div>
                                    </div>
                                @endisset
                                <div class="form-group">
                                    <label for="matricule" class="label-control col-xs-3"> Mots de Passe*</label>
                                    <div class="col-xs-8">
                                        <input type="password" class="form-control" name="password" id="pass"
                                            placeholder="Mots de passe" autocomplete="off" required />

                                    </div>
                                    <div class="col-xs-1 no-padding">
                                        <i class="fa fa-eye fa-1x mt-2 text-success" id="showMdp"
                                            style="cursor: pointer"></i>
                                    </div>
                                </div>
                                @isset($roles)
                                    <div class="form-group">

                                        <label for="service" class="label-control col-sm-3"> Service</label>
                                        <div class="col-sm-9">
                                            <select class="form form-control" name="service">
                                                <option value="Maladies infectieuses"
                                                    {{ $user->Service == 'Maladies infectieuses' ? 'selected' : '' }}>Maladies
                                                    infectieuses</option>
                                                <option value="Pneumologie"
                                                    {{ $user->Service == 'Pneumologie' ? 'selected' : '' }}>Pneumologie</option>
                                                <option value="Bloc 470" {{ $user->Service == 'Bloc 470' ? 'selected' : '' }}>
                                                    Bloc 470</option>
                                                <option value="Réanimation Covid"
                                                    {{ $user->Service == 'Réanimation Covid' ? 'selected' : '' }}>Réanimation
                                                    Covid</option>
                                                <option value="Laboratoire de Pharmacologie"
                                                    {{ $user->Service == 'Laboratoire de Pharmacologie' ? 'selected' : '' }}>
                                                    Laboratoire de Pharmacologie</option>
                                                <option value="Pharmacie Centrale"
                                                    {{ $user->Service == 'Pharmacie Centrale' ? 'selected' : '' }}>Pharmacie
                                                    Centrale</option>
                                                <option value="Laboratoire de Biologie Covid"
                                                    {{ $user->Service == 'Laboratoire de Biologie Covid' ? 'selected' : '' }}>
                                                    Laboratoire de Biologie Covid</option>
                                                <option value="Laboratoire de Microbiologie"
                                                    {{ $user->Service == 'Laboratoire de Microbiologie' ? 'selected' : '' }}>
                                                    Laboratoire de Microbiologie</option>
                                                <option value="Hématologie"
                                                    {{ $user->Service == 'Hématologie' ? 'selected' : '' }}>Hématologie</option>
                                                <option value="Médecine Interne"
                                                    {{ $user->Service == 'Médecine Interne' ? 'selected' : '' }}>Médecine
                                                    Interne</option>
                                            </select>
                                        </div>
                                    </div>
                                @endisset
                                <div class="form-group">

                                    <label for="specialite" class="label-control col-sm-3"> Spécialité</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="specialite">
                                            <option value="Pharmacologue"
                                                {{ $user->specialite == 'Pharmacologue' ? 'selected' : '' }}>Pharmacologue
                                            </option>
                                            <option value="Pharmacognoste"
                                                {{ $user->specialite == 'Pharmacognoste' ? 'selected' : '' }}>Pharmacognoste
                                            </option>
                                            <option value="Galésite"
                                                {{ $user->specialite == 'Galésite' ? 'selected' : '' }}>Galésite</option>
                                            <option value="Infectiologue"
                                                {{ $user->specialite == 'Infectiologue' ? 'selected' : '' }}>Infectiologue
                                            </option>
                                            <option value="Pneumologue"
                                                {{ $user->specialite == 'Pneumologue' ? 'selected' : '' }}>Pneumologue
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="grade" class="label-control col-sm-3"> Grade</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="grade">
                                            <option value="Maître Assistant"
                                                {{ $user->grade == 'Maître Assistant' ? 'selected' : '' }}>Maître Assistant
                                            </option>
                                            <option value="Maître de Conférences grade B"
                                                {{ $user->grade == 'Maître de Conférences grade B' ? 'selected' : '' }}>
                                                Maître de Conférences grade B</option>
                                            <option value="Maître de Conférences grade A"
                                                {{ $user->grade == 'Maître de Conférences grade A' ? 'selected' : '' }}>
                                                Maître de Conférences grade A</option>
                                            <option value="Médecin Assistant"
                                                {{ $user->grade == 'Médecin Assistant' ? 'selected' : '' }}>Médecin
                                                Assistant</option>
                                            <option value="Résident" {{ $user->grade == 'Résident' ? 'selected' : '' }}>
                                                Résident</option>
                                            <option value="Professeur" {{ $user->grade == 'Professeur' ? 'selected' : '' }}>
                                                Professeur</option>
                                            <option value="Assistant" {{ $user->grade == 'Assistant' ? 'selected' : '' }}>
                                                Assistant</option>

                                        </select>
                                    </div>
                                </div>
                                @isset($roles)
                                    <div class="form-group">

                                        <label for="role" class="label-control col-sm-3"> Role</label>
                                        <div class="col-sm-9">
                                            <select name="role_id" id="role" class="form-control">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->nom_profile }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endisset
                                @isset($roles)
                                    <div class="form-group">

                                        <label for="role" class="label-control col-sm-3"></label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="admin" class="flat-red" @if ($user->is_admin === 'on') checked @endif
                                            > Administrateur
                                        </div>
                                    </div>
                                @endisset

                                <button type="submit" class="btn btn-info pull-right">Modifier</button>
                            </form>

                        </div>
                        <!-- /.box-body -->

                    </div>

                </div>

            </div>

        </section>


    </div>


@endsection

@section('script')
    <script>
        $(function() {
            $("#showMdp").on('click', function() {
                if ($("#pass").attr('type') == 'password') {
                    $("#pass").attr('type', 'text');
                } else {
                    $("#pass").attr('type', 'password');
                }
            })
        });

    </script>
    {{-- <script>
        $(function() {

            //get json records from general.json and display bilan and unités in there respective select for admin
            $.getJSON("/js/json/general.json", function(obj) {

                $.each(obj, function(key, value) {
                    // console.log(value.unite.length)
                    if (value.grade != "") {
                        $("#grade").append("<option value=" + value.grade + ">" + value.grade +
                            "</option>");
                    }
                    if (value.specialite != "") {
                        $("#specialite").append("<option value=" + value.specialite + ">" + value
                            .specialite + "</option>");
                    }

                });
            });
        });

    </script> --}}
@endsection
