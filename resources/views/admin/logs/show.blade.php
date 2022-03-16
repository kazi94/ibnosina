@extends('layouts.model')
@section('title') Utilisateurs Internes @endsection
@section('content')

    <div class="content-wrapper">


        <section class="content">

            <div class="row">

                <div class="col-sm-12 ">
                    <div class="box box-info">


                        <div class="box-header with-border">

                            <h2 class="box-title">
                                <h1>Log Activity Lists</h1>
                            </h2>

                        </div>

                        <div class="box-body table-responsive">


                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Subject</th>
                                    <th>URL</th>
                                    <th>Method</th>
                                    <th>Ip</th>
                                    <th width="300px">User Agent</th>
                                    <th>User Id</th>
                                    <th>Action</th>
                                </tr>
                                @if ($logs->count())
                                    @foreach ($logs as $key => $log)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $log->subject }}</td>
                                            <td class="text-success">{{ $log->url }}</td>
                                            <td><label class="label label-info">{{ $log->method }}</label></td>
                                            <td class="text-warning">{{ $log->ip }}</td>
                                            <td class="text-danger">{{ $log->agent }}</td>
                                            <td><a href="{{ route('user.edit', ['id' => $log->user_id]) }}">
                                                    {{ $log->user_id }}</a></td>
                                            <td><button class="btn btn-danger btn-sm">Delete</button></td>
                                        </tr>
                                    @endforeach
                                @endif
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
            $('#t_user').DataTable({
                "order": [
                    [8, "desc"]
                ],
                buttons: [
                    'colvis',
                    'excel',
                    'print'
                ]
            });

            $('#select_all').on('click', function() {
                if (this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }
            });
        });

    </script>
@endsection
