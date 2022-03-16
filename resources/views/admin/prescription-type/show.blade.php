@extends('layouts.model')
@section('script_css')
    <link rel="stylesheet" href="{{ asset('css/icheck.css') }}">

@endsection


@section('content')

    <div class="content-wrapper">
        @if (session()->has('message'))
            <p class="alert alert-success">{{ session('message') }}</p>
        @endif
        <section class="content-header">
            <h3>Prescriptions Type</h3>
        </section>

        <section class="content">
            <div class="nav-tabs-custom d-sm-none">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#service">Services</a></li>
                    <li><a data-toggle="tab" href="#examen">Examens</a></li>
                </ul>
            </div>
            <div class="tab-content">
                {{-- Service Tab --}}
                <div id="service" class="tab-pane fade in active">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class=" btn btn-success mb-3 pull-right" data-toggle="modal"
                                        data-target="#modal_prescription">Nouveau</button>
                                    <table class="table table-bordered text-center table-hover">
                                        <thead>
                                            <tr class="bg-gray">
                                                <th>#</th>
                                                <th>Nom</th>
                                                <th>Service</th>
                                                <th>Modifier</th>
                                                <th>Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prescriptionsServices as $type)
                                                <tr>
                                                    <td class="text-bold">{{ $loop->index + 1 }}</td>
                                                    <td>{{ $type->name }}</td>
                                                    <td>{{ $type->service }}</td>
                                                    <td>
                                                        <a href="#modifierPrescription" class="editPrescriptionType"
                                                            data-toggle="modal" data-target="#modal_prescription"
                                                            data-id="{{ $type->id }}">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <form style="display: none;" method="POST"
                                                            action="{{ route('prescription-service.destroy', $type->id) }}"
                                                            id="delete-form-{{ $type->id }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        </form>

                                                        <a href="#"
                                                            onclick="
                                                                                                                                                                                                                                                                                                                                                                                                                    if (confirm('voulez vous supprimer cette ligne ?')) 
                                                                                                                                                                                                                                                                                                                                                                                                                    { 
                                                                                                                                                                                                                                                                                                                                                                                                                        event.preventDefault();document.getElementById('delete-form-{{ $type->id }}').submit();	
                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <span class="glyphicon glyphicon-trash"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- !END Service Tab --}}

                {{-- Examen Tab --}}
                <div id="examen" class="tab-pane fade in ">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class=" btn btn-success mb-3 pull-right" data-toggle="modal"
                                        data-target="#modal_demande_examen">Nouveau</button>
                                    <table class="table table-bordered text-center table-hover">
                                        <thead>
                                            <tr class="bg-gray">
                                                <th>#</th>
                                                <th>Nom</th>
                                                <th>Service</th>
                                                <th>Modifier</th>
                                                <th>Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prescriptionsExamens as $type)
                                                <tr>
                                                    <td class="text-bold">{{ $loop->index + 1 }}</td>
                                                    <td>{{ $type->name }}</td>
                                                    <td>{{ $type->service }}</td>
                                                    <td>
                                                        <a href="#modifierPrescriptionExamen" class="editPrescriptionExamen"
                                                            data-toggle="modal" data-target="#modal_demande_examen"
                                                            data-id="{{ $type->id }}">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <form style="display: none;" method="POST"
                                                            action="{{ route('prescription-examen.destroy', $type->id) }}"
                                                            id="delete-form-{{ $type->id }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        </form>

                                                        <a href="#"
                                                            onclick="
                                                                                                                                                                                                                                                                                                                                                                                                                    if (confirm('voulez vous supprimer cette ligne ?')) 
                                                                                                                                                                                                                                                                                                                                                                                                                    { 
                                                                                                                                                                                                                                                                                                                                                                                                                        event.preventDefault();document.getElementById('delete-form-{{ $type->id }}').submit();	
                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                    ">
                                                            <span class="glyphicon glyphicon-trash"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- !END Examen Tab --}}
            </div>
        </section>
    </div>

    {{-- Modals --}}
    <div class="modal fade" id="modal_demande_examen" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="bg-blue modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Prescription type : Examen</h4>
                </div>
                <form method="POST" action="{{ route('prescription-examen.store') }}" enctype="multipart/form-data"
                    class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="POST">

                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label for="d_analyse" class="col-sm-3 control-label">Nom*</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="d_analyse" class="col-sm-3 control-label">Service*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='service' required>
                                        <option value="Maladies infectieuses">Maladies infectieuses</option>
                                        <option value="Pneumologie">Pneumologie</option>
                                        <option value="Hématologie">Hématologie</option>
                                        <option value="Médecine Interne">Médecine Interne</option>
                                        <option value="Bloc 470">Bloc 470</option>
                                        <option value="Réanimation Covid">Réanimation Covid</option>
                                        <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie</option>
                                        <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                        <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid</option>
                                        <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Type de bilan</label>

                                <div class="col-sm-9">
                                    <select id="type_bilan" class="form form-control">
                                        <option value="">Sélectionner le Bilan</option>
                                        @foreach ($bilans as $bilan)
                                            <option value="{{ $bilan->bilan }}">{{ $bilan->bilan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Eléments</label>

                                <div class="col-sm-9" id="elements">
                                    <table>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default mb-0" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary mb-0">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_prescription" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="bg-blue modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Prescription type : Service</h4>
                </div>
                <div class="modal-body form-horizontal">
                    <div class="p-3 m-1 bg-info">
                        <form id="addLinePrescription">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" name="method">
                            <input type="hidden" class="form-control" name="url">

                            <div class="form-group">
                                <label for="d_analyse" class="col-sm-2 control-label">Nom*</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Nom de la prescription type" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="d_analyse" class="col-sm-2 control-label">Service*</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name='service' required>
                                        <option value="Maladies infectieuses">Maladies infectieuses</option>
                                        <option value="Pneumologie">Pneumologie</option>
                                        <option value="Hématologie">Hématologie</option>
                                        <option value="Médecine Interne">Médecine Interne</option>
                                        <option value="Bloc 470">Bloc 470</option>
                                        <option value="Réanimation Covid">Réanimation Covid</option>
                                        <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie</option>
                                        <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                        <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid</option>
                                        <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie</option>
                                    </select>
                                </div>
                            </div>
                            <select class="" name='voie' style="display : none"></select>
                            <select class="" name="unite" style="display : none"></select>
                            <div class="form-group">
                                <label for="d_analyse" class="col-sm-2 control-label">Médicament</label>

                                <div class="col-sm-10">
                                    <input type="hidden" name="med_sp_id" />
                                    <input type="text" class="form-control" placeholder="Médicament DCI / Nom de spécialité"
                                        name="medicament_dci" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Posologie</label>
                                <div class="col-sm-10">

                                    <input type="number" step="0.01" name="dose_mat" value="1"
                                        class="form-control posologie">
                                    <input type="hidden" name="dose_matin" value="1">
                                    <input type='checkbox' class='form-control flat-green d_matin' checked
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" /> Matin

                                    <input type="number" step="0.01" name="dose_mid" value="1"
                                        class="form-control posologie">
                                    <input type="hidden" name="dose_midi" value="1">
                                    <input type='checkbox' class='form-control flat-green d_midi' checked
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" /> Midi

                                    <input type="number" step="0.01" name="dose_soi" value="1"
                                        class="form-control posologie">
                                    <input type="hidden" name="dose_soir" value="1">
                                    <input type='checkbox' class='form-control flat-green d_soir' checked
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" /> Soir

                                    <input type="number" step="0.01" name="dose_ac" value="1"
                                        class="form-control posologie">
                                    <input type="hidden" name="dose_avant_coucher" value="1">
                                    <input type='checkbox' class='form-control flat-green d_av' checked
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" /> Av-coucher
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date de prise" class="col-sm-2 control-label">Pendant</label>

                                <div class="col-sm-10">
                                    <input type="number" class="form-control posologie" name="nbr_jours" value="1">
                                    <select id="type_j" name='type_j' class="form-control"
                                        style="width: 17%; display: inline;">
                                        <option value="jours">Jours</option>
                                        <option value="semaines">Semaines</option>
                                        <option value="mois">Mois</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-success btn-block add_line_btn"
                                        value="Ajouter Médicament">
                                    <input type="button" class="btn btn-success btn-block up_line_btn"
                                        value="Modifier Médicament" style="display: none;">
                                </div>
                            </div>
                        </form>
                        <div class="">
                            <table class="table table-hover" id="tablePrescription">
                                <thead>
                                    <tr>
                                        <th class="text-center">Mes médicaments</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-default" data-dismiss="modal" value="Fermer">
                    <input type="button" class="btn btn-primary" id="savePrescriptionType" value="Valider">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/user/patient/gestion_prescription.js') }}"></script>
    <script src="{{ asset('js/user/patient/gestion_bilan.js') }}"></script>
    <script>
        $('input[type="checkbox"].flat-green').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });

        function savePrescriptionType() {
            const forme = new FormData();
            const service = $modalPrescSelector.find("select[name='service']").val();
            const url = $modalPrescSelector.find("input[name='url']").val() !== "" ? $modalPrescSelector.find(
                "input[name='url']").val() : "/admin/prescription-type/prescription-service";

            const name = $modalPrescSelector.find("input[name='name']").val();
            if (name == "") {
                alert('Vous devez d\'abord renseigner le nom de la prescription type')
            } else {
                const dataToAppend = [{
                        key: 'service',
                        value: service
                    },
                    {
                        key: 'name',
                        value: name
                    },

                    {
                        key: 'lines',
                        value: JSON.stringify(lines)
                    },
                    {
                        key: '_method',
                        value: $modalPrescSelector.find("input[name='method']").val() == "PUT" ? 'PATCH' : 'POST'
                    },
                ];

                dataToAppend.map((keyvalue) => {
                    forme.append(keyvalue.key, keyvalue.value);
                })
                $.ajax({
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: forme,
                    success: function(response) {
                        window.location.reload();
                    },
                    error(exception, type, code) {
                        toastr.error(exception.responseText);
                    }
                });
            }
        }

        $("#savePrescriptionType").on('click', savePrescriptionType);


        $(".editPrescriptionExamen").on('click', function() {
            const id = $(this).data('id');
            $.get(`/admin/prescription-type/prescription-examen/${id}/edit	`)
                .done(res => {
                    const url = `/admin/prescription-type/prescription-examen/${id}`;
                    $("#modal_demande_examen form").attr("action", url);
                    $("#modal_demande_examen form").attr("method", 'post');
                    $("#modal_demande_examen form").find("input[name='name']").val(res.name);
                    $(
                        "#modal_demande_examen select[name='service']").val(res.service).is(
                        ":selected");
                    $("#modal_demande_examen form").find("input[name='_method']").val(
                        'PUT');
                    res = res.examens_type;
                    res.forEach((element, key) => {
                        let cel = "";
                        if (key % 2 == 0) {
                            let cel0 =
                                `
                                                                                                                                                                                                                                                                                <td>
                                                                                                                                                                                                                                                                                <input type='hidden' name='elements_id[]' value='${element.element.id}'>
                                                                                                                                                                                                                                                                                <input type='hidden' name='checkedElements[]' value='0'>
                                                                                                                                                                                                                                                                                <input type='checkbox' class="flat-red" '/>
                                                                                                                                                                                                                                                                                ${element.element.element}
                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                `;
                            if (key < res.length - 1) {
                                cel =
                                    `
                                                                                                                                                                                                                                                                                        <td>
                                                                                                                                                                                                                                                                                        <input type='hidden' name='elements_id[]' value='${res[ key + 1].element.id}'>
                                                                                                                                                                                                                                                                                        <input type='hidden' name='checkedElements[]' value='0'>
                                                                                                                                                                                                                                                                                        <input type='checkbox' class="flat-red" '/>
                                                                                                                                                                                                                                                                                        ${res[ key + 1].element.element}
                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                    `;
                            }
                            $rows =
                                `
                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                    ${cel0}
                                                                                                                                                                                                                                                                                    ${cel}							
                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                `;
                            $("#elements tbody").append($rows);
                            $('input[type="checkbox"].flat-red').iCheck({
                                checkboxClass: 'icheckbox_flat-red'
                            });
                            $('input[type="checkbox"].flat-red').iCheck('check');
                        }
                    });


                });
        });

        $("#modal_demande_examen").on('hide.bs.modal', function() {
            $("#modal_demande_examen").find("input[name='url']").val(
                "/admin/prescription-type/prescription-examen");
            $("#modal_demande_examen form").attr("action",
                "/admin/prescription-type/prescription-examen");
            $("#modal_demande_examen").find("input[name='_method']").val("post");
            $("#modal_demande_examen").find("input[name='name']").val("");
            $("#elements tbody").empty();

        });
        $(".editPrescriptionType").on('click', function() {
            const id = $(this).data('id');
            $.get(`/admin/prescription-type/prescription-service/${id}/edit	`)
                .done(res => {
                    lines = res.services_type;
                    const url = `/admin/prescription-type/prescription-service/${id}`;
                    $modalPrescSelector.find("input[name='url']").val(url);
                    $modalPrescSelector.find("input[name='name']").val(res.name);
                    $modalPrescSelector.find("select[name='service']")
                        .val(res.service)
                        .is(":selected");
                    $modalPrescSelector.find("input[name='method']").val('PUT');
                    lines.forEach((line, index) => {
                        // get textual format of Prescription
                        let medicament = medicToText(line)

                        // add to table
                        appendToTable(medicament, ++index, 1);
                    });
                });
        });

    </script>
@endsection
