@extends('layouts.model-table')


@section('script_css')

    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">

@endsection


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @if (count($errors) > 0)

            @foreach ($errors->all() as $error)

                <p class="alert alert-danger">{{ $error }}</p>

            @endforeach

        @endif

        <div class="alert alert-danger" style="display: none;"></div>

        @if (session()->has('message'))

            <p class="alert alert-success">{{ session('message') }}</p>

        @endif
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Acceuil</a></li>
                <li><a href="{{ route('patient.index') }}"><i class="fa fa-list-alt"></i> Mes Patient</a></li>
                <li class="active">Ajouter un patient</li>
            </ol>
            <h2>Ajouter un patient </h2>
        </section>
        <section class="content">

            <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                action="{{ route('patient.store') }}" autocomplete="off">
                {{ csrf_field() }}


                @include('includes.forms.patient')

            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{-- Modals --}}
    {{-- @include('includes.modals.add-act') --}}
@endsection

@section('script')

    <script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/adminlte2/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/user/patient/gestion_patient.js') }}"></script>
    <script src="{{ asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            /*
             * Search Patient firstname         
             */
            var options = {
                theme: "square",
                url: function(phrase) {
                    return "/api/patient"; // url to send into server
                },
                getValue: function(element) {
                    return element.nom + " " + element.prenom;
                },
                ajaxSettings: { // d'ont touch and mmodify
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    method: "GET",
                    data: {}
                },
                preparePostData: function(data) {
                    data.nom = $('#nom').val(); // get the value and add to data object
                    return data;
                },

                template: {
                    type: "custom",
                    method: function(value, item) {
                        if (item.photo == 'user.jpg')
                            link = '/images/user.jpg';
                        else
                            link = '/images/avatar/' + item.photo;
                        return "<img src=" + link + " width='30' height='30' /> " + item.nom + " " + item
                            .prenom;
                    }
                },
                list: {
                    maxNumberOfElements: 8,
                    onSelectItemEvent: function(e) {
                        var patient_id = $("#nom").getSelectedItemData().id;

                        $("#patient-id").val(patient_id).trigger("change");

                    },
                    onClickEvent: function() {
                        var patient_id = $("#patient-id").val();
                        return window.location.href = "/patient/" + patient_id + "/edit";
                    },
                    showAnimation: {
                        type: "fade", //normal|slide|fade
                        time: 400,
                    },

                    hideAnimation: {
                        type: "slide", //normal|slide|fade
                        time: 400,
                    },

                },
                // requestDelay: 10000 // delays for response serve
            };
            $('#nom').easyAutocomplete(options);

            $('.select2').select2({
                theme: 'classic'
            });

            $("#btn-add-act").on("click", function() {
                var newStateVal = $("#new-act").val();
                // Set the value, creating a new option if necessary
                if ($("#acts").has('option:contains(' + newStateVal + ')').length) {
                    $("#acts").val(newStateVal).trigger("change");
                } else {
                    // Create the DOM option that is pre-selected by default
                    var form = new FormData();
                    form.append('act', newStateVal);
                    $.ajax('/api/operation/' + newStateVal)
                        .done(id => {
                            var newState = new Option(newStateVal, id, true, true);
                            $("#acts").append(newState).trigger('change');
                        });
                    // Append it to the select
                }
            });

            //Show other works input's 
            $("#travaille").change(function() {
                if ($(this).val() == "Autre") {
                    $("#autre").show();
                } else $("#autre").hide();
            });

            $("#villeId").change(function() {
                $.ajax('/api/utils/dairas/' + $(this).val())
                    .done(res => {
                        var dairas;
                        res.forEach(daira => {
                            dairas += "<option value=" + daira.id + ">" + daira.name +
                                "</option>";
                        });
                        $("#communeId").empty().append(dairas);
                    });
            });
            $("#tabac").change(function() {
                if ($(this).is(":checked")) {
                    $(".tabac").css('display', 'block');
                } else $(".tabac").hide();
            });
            $("#alcool").change(function() {
                if ($(this).is(":checked")) {
                    $(".alcool").show();
                } else $(".alcool").hide();
            });
            $("#drogue").change(function() {
                if ($(this).is(":checked")) {
                    $(".drogue").show();
                } else $(".drogue").hide();
            });
            $("select[name='sexe']").change(function() {
                if ($(this).val() == "F") {
                    $("#etat").show();
                } else {
                    $("#etat").hide();
                    $("#grossesse").hide();
                }
            });
            $("select[name='etat']").change(function() {
                if ($(this).val() == "grossesse") {
                    $("#grossesse").show();
                } else {
                    $("#grossesse").hide();
                }
            });
        });

    </script>

@endsection
