@extends('layouts.model')

@section('content')

    <div class="content-wrapper">

        <section class="content">

            @if (session()->has('message'))

                <p class="alert alert-success">{{ session('message') }}</p>

            @endif

            <div class="row">

                <div class="col-sm-12 ">
                    <div class="box box-widget">
                        <div class="box-header with-border">

                            <h2 class="box-title">Bilans d'examens</h2>

                            <a class='col-lg-offset-5 btn btn-success' href="{{ route('element.create') }}">Ajouter
                                nouveau</a>

                        </div>

                        <div class="box-body table-responsive">

                            <table
                                class="table table-responsive table-bordered table-stripped table-hover text-center dataTable "
                                id="t_biologique">

                                <thead>

                                    <tr class="alert alert-info">

                                        <th>Num°</th>
                                        <th>Type Bilan</th>

                                        <th>Type Element</th>

                                        <th>Min </th>

                                        <th>Max </th>

                                        <th>Unité</th>

                                        <th>Sexe</th>

                                        <th>Modifier</th>

                                        <th>Supprimer</th>
                                    </tr>


                                </thead>

                                <tbody>

                                    @foreach ($elements as $element)

                                        <tr>
                                            <th>{{ $loop->index + 1 }}</th>
                                            <th>{{ $element->bilan }}</th>

                                            <th>{{ $element->element }}</th>

                                            <th>{{ $element->minimum }}</th>

                                            <th>{{ $element->maximum }}</th>

                                            <th>{{ $element->unite }}</th>

                                            <th>
                                                {{ $element->sexe }}
                                            </th>
                                            {{-- <th>
                                                @if ($element->special === 'on') Oui @else Non
                                                @endif
                                            </th> --}}

                                            <td><a href="{{ route('element.edit', $element->id) }}"><span
                                                        class="glyphicon glyphicon-edit"></span></a></td>

                                            <td>

                                                <form style="display: none;" method="POST"
                                                    action="{{ route('element.destroy', $element->id) }}"
                                                    id="delete-form-{{ $element->id }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>

                                                <a href="" onclick="
                  if (confirm('Attention la suppression de lelement va supprimer les informations existante sur le patient , Voulez vous vraiment supprimer cette ligne ?')) {
                  event.preventDefault();
                  document.getElementById('delete-form-{{ $element->id }}').submit();										}
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
