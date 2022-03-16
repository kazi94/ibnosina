@extends('layouts.model')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
            @endif
            @if (session()->has('message'))
                <p class="alert alert-success message" style="">{{ session('message') }}</p>
            @endif

            <div class="row">

                <div class="col-sm-12 ">
                    <div class="box box-info">


                        <div class="box-header with-border">

                            <h2 class="box-title">Questionnaires</h2>

                            <a class='col-lg-offset-8 btn btn-success' href="{{ route('questionnaires.create') }}">Ajouter
                                nouveau</a>

                        </div>

                        <div class="box-body table-responsive">


                            <table class="table table-responsive table-bordered table-stripped text-center dataTable"
                                id="t_user">

                                <thead>
                                    <tr class="thead-dark">
                                        <th>Num°:</th>
                                        <th>Type</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($questions as $question)
                                        {{-- @foreach ($produit->interactions as $interaction_id)
                                            --}}

                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>

                                                <td>{{ $question->type }}</td>

                                                <td>
                                                    <a href="{{ route('questionnaires.edit', $question->id) }}"><span
                                                            class="glyphicon glyphicon-edit"></span></a>
                                                </td>

                                                <td>
                                                    <form style="display: none;" method="POST"
                                                        action="{{ route('questionnaires.destroy', $question->id) }}"
                                                        id="delete-form-{{ $question->id }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>

                                                    <a href="" onclick="
                        if (confirm('voulez vous supprimer cette ligne ?')) {
                        event.preventDefault();
                        document.getElementById('delete-form-{{ $question->id }}').submit();										}
                       "><span class="glyphicon glyphicon-trash"></span></a>
                                                </td>

                                            </tr>

                                        @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </section>
    </div>

@endsection
@section('script')

    <script>
        $(function() {

            $('#t_biologique').DataTable();


        })

    </script>
@endsection
