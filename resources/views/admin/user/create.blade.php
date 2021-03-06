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

                            <h3 class="box-title">Ajouter utilisateur</h3>

                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <form class="form-horizontal" autocomplete="off" method="POST"
                                action="{{ route('user.store') }}">
                                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                {{ csrf_field() }}
                                <input type="hidden" name="hopital" value="CHU Tlemcen">
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="matricule" class="label-control"> Matricule*

                                            <input type="text" class="form-control" name="matricule" id="matricule"
                                                placeholder="matricule" required>

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="nom" class="label-control"> Nom*

                                            <input type="text" class="form-control" name="name" id="nom" placeholder="nom"
                                                required />

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="pr??nom" class="label-control"> Pr??nom*

                                            <input type="text" class="form-control" name="prenom" id="pr??nom"
                                                placeholder="pr??nom" required />

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="date_naissance" class="label-control"> Date de naissance

                                            <input type="date" class="form-control" name="date_naissance"
                                                id="date_naissance" placeholder="date_naissance" style="width: 214px;">

                                        </label>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="email" class="label-control"> Email*

                                            <input type="email" class="form-control" autocomplete="off" name="email"
                                                id="email" placeholder="Ex : '@'email.com" required />

                                        </label>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="password" class="label-control"> Mots de passe*

                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Mots de passe" required autocomplete="off" />

                                        </label>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="service" class="label-control col-sm-3"> Service</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="service">
                                            <option value="Maladies infectieuses">Maladies infectieuses</option>
                                            <option value="Pneumologie">Pneumologie</option>
                                            <option value="H??matologie">H??matologie</option>
                                            <option value="M??decine Interne">M??decine Interne</option>
                                            <option value="Bloc 470">Bloc 470</option>
                                            <option value="R??animation Covid">R??animation Covid</option>
                                            <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie
                                            </option>
                                            <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                            <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid
                                            </option>
                                            <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="specialite" class="label-control col-sm-3"> Sp??cialit??</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="specialite">
                                            <option value="Pharmacologue">Pharmacologue</option>
                                            <option value="Pharmacognoste">Pharmacognoste</option>
                                            <option value="Gal??site">Gal??site</option>
                                            <option value="Infectiologue">Infectiologue</option>
                                            <option value="Pneumologue">Pneumologue</option>
                                            <option value="Microbiologiste">Microbiologiste</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="grade" class="label-control col-sm-3"> Grade</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="grade">
                                            <option value="Ma??tre Assistant">Ma??tre Assistant</option>
                                            <option value="Ma??tre de Conf??rences grade B">Ma??tre de Conf??rences grade B
                                            </option>
                                            <option value="Ma??tre de Conf??rences grade A">Ma??tre de Conf??rences grade A
                                            </option>
                                            <option value="M??decin Assistant">M??decin Assistant</option>
                                            <option value="R??sident">R??sident</option>
                                            <option value="Professeur">Professeur</option>
                                            <option value="Assistant">Assistant</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="role" class="label-control col-sm-3"> Role</label>
                                    <div class="col-sm-9">
                                        <select name="role_id" id="role" class="form-control">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->nom_profile }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="role" class="label-control col-sm-3"></label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" name="admin" class="flat-red"> Administrateur
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info pull-right">Ajouter</button>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>



@endsection
