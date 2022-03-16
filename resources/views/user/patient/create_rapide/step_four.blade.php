@extends('layouts.model')

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
        <section class="content-header text-center">
            <h2>Ajouter un Patient </h2>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info" id="prescription_box">
                        <div class=" box-header with-border text-center">
                            <h3 class="box-title">
                                Prescription Médicament
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <input type="hidden" name="patient_id" value="{{ session('patient_id') }}">
                            <input type="hidden" name="presc" value="{{ $presc }}">
                            <input type="hidden" name="cons_id" value="{{ session('consultation_id') }}" />
                            <input type="hidden" name="date_prescription"
                                value="<?php echo date('Y-m-d'); ?>" />

                            <div class="bg-info col-sm-6 form-horizontal p-3">
                                <div class="form-group">
                                    <label for="type_prescription" class="col-sm-3 control-label">Prescriptions type</label>

                                    <div class="col-sm-9">
                                        <select id="prescriptions_type" class="form-control">
                                            <option value=""></option>
                                            @foreach (Auth::user()->prescriptionsType as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <form id="addLinePrescription1">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="line_id" value="">
                                    <select class="" name='voie' style="display : none"></select>
                                    <select class="" name="unite" style="display : none"></select>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-2 control-label">Médicament</label>

                                        <div class="col-sm-10">
                                            <input type="hidden" name="med_sp_id" />
                                            <input type="text" class="form-control"
                                                placeholder="Médicament DCI / Nom de spécialité" name="medicament_dci"
                                                autocomplete="off" required>
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
                                            <input type="hidden" name="dose_av" value="1">
                                            <input type='checkbox' class='form-control flat-green d_av' checked
                                                onclick="this.previousSibling.value=1-this.previousSibling.value" />
                                            Av-coucher
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
                                        <div class="col-sm-12 mt-2">

                                            <input type="submit" class="btn btn-success btn-block"
                                                value="Ajouter Médicament">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
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
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <!-- Pour la consultation rapide -->
                            <!-- Pour l'hospitalisation -->
                            @if (session()->has('type') && session('type') == 'consultation')
                                <a href="{{ route('patient.create.step.two', ['id' => session('consultation_id')]) }}">
                                    <button type="button" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i>
                                        Précédent </button>
                                </a>
                            @else
                                <a href="{{ route('patient.create.step.three', ['id' => session('hospi_id')]) }}">
                                    <button type="button" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i>
                                        Précédent </button>
                                </a>
                            @endif
                            <button type="button" id="savePrescription1" class="btn btn-success pull-right">Suivant <i
                                    class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function() {
            $('input[type="checkbox"].flat-green').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            });

            //***********************************************/
            var lines = [];

            function getPrescription() {
                const res = $("input[name='presc']").val();
                if (res) {
                    const date_prescription = res.date_prescription;
                    lines = res.lignes;
                    $("#modal_prescription input[name='date_prescription']").val(date_prescription);
                    lines.forEach((line, index) => {
                        // get textual format of Prescription
                        let medicament = medicToText(line)

                        // add to table
                        appendToTable(medicament, ++index, 1);
                    });
                }
            };

            getPrescription();
            /*
             * append line to medicament table
             */
            function appendToTable(line, index = 1, ipMsg = null) {
                // let up_line = "";
                // if (ipMsg)
                up_line = `class="up_line" style='cursor : pointer;' data-index = '${index - 1}' `;
                $("#tablePrescription > tbody").append(`
                                                        <tr title = "Cliquer pour modifier le médicament" ${up_line} >
                                                         <td>${line}</td>
                                                         <td><i class='fa fa-times-circle fa-1x del_line' style='color:red;cursor : pointer;' data-index = '${index-1}'></i></td>
                                                         
                                                        </tr>
                                                       `);
            }
            /*
             * Transform line prescription to readable text
             */
            function medicToText(line) {
                const toText = `
                                                        <b>${line.medicament_dci}</b> ${line.voie}. 
                                                        ${line.dose_matin != 0 ? line.dose_mat+" <b>"+line.unite.toLowerCase()+'</b> le <b class="text-info">Matin</b>, ' : ''} 
                                                        ${line.dose_midi != 0 ? line.dose_mid+' à <b class="text-green">Midi</b>, ' : ''}
                                                        ${line.dose_soir != 0 ? line.dose_soi+' le <b class="text-orange">Soir</b>, ' : ''} 
                                                        ${line.dose_av != 0 ? line.dose_ac + ' <b class="text-red">Avant-coucher</b>.' : ''} 
                                                        Pendant : <b>${line.nbr_jours}</b> ${line.type_j}
                                                       `;
                return toText;
            }
            // ajouter la line prescription au tableau lines
            function addLinePrescription(e) {
                e.preventDefault();
                if ($("input[name='med_sp_id']").val() != "") {
                    let med_sp_id = $("input[name='med_sp_id']").val();
                    let type_j = $("select[name='type_j']").val();
                    let nbr_jours = $("input[name='nbr_jours']").val();
                    let dose_matin = $("input[name='dose_matin']").val();
                    let dose_mat = $("input[name='dose_mat']").val();
                    let dose_midi = $("input[name='dose_midi']").val();
                    let dose_mid = $("input[name='dose_mid']").val();
                    let dose_soir = $("input[name='dose_soir']").val();
                    let dose_soi = $("input[name='dose_soi']").val();
                    let dose_ac = $("input[name='dose_ac']").val();
                    let dose_av = $("input[name='dose_av']").val();
                    let unite = $("select[name='unite']").val();
                    let voie = $("select[name='voie']").val();
                    let medicament_dci = $("input[name='medicament_dci']").val();
                    let line = {
                        'med_sp_id': med_sp_id,
                        'type_j': type_j,
                        'nbr_jours': nbr_jours,
                        'dose_matin': dose_matin,
                        'dose_mat': dose_mat,
                        'dose_midi': dose_midi,
                        'dose_mid': dose_mid,
                        'dose_soir': dose_soir,
                        'dose_soi': dose_soi,
                        'dose_av': dose_av,
                        'dose_ac': dose_ac,
                        'unite': unite,
                        'voie': voie,
                        'medicament_dci': medicament_dci,
                    };
                    // add form to lines
                    let count = lines.push(line);

                    // get textual format of Prescription
                    let medicament = medicToText(line)

                    // add to table
                    appendToTable(medicament, count, null);

                    //reset form
                    $("form#addLinePrescription1")[0].reset();

                } else {
                    alert("Le médicament renseigné doit etre sélectionner de la liste des suggestions");
                }

            }
            $("form#addLinePrescription1").on('submit', addLinePrescription);

            // store prescription to database
            function savePrescription() {
                if (window.lines.length == 0) {
                    alert('Vous devez renseigner au moin un médicament !')
                    return
                }
                const formData = new FormData();
                const patient_id = $("input[name='patient_id']").val();
                const date_prescription = $("input[name='date_prescription']").val();
                const cons_id = $("input[name='cons_id']").val();
                const url = "{{ route('patient.create.step.four.post') }}";

                formData.append('patient_id', patient_id);
                formData.append('date_prescription', date_prescription);
                formData.append('cons_id', cons_id);
                formData.append('med_sp_id', JSON.stringify(window.lines));

                $.ajax({
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        window.location.href = "{{ route('patient.create.step.five') }}"
                    },
                    error(exception, type, code) {
                        toastr.error(exception.responseText);
                    }
                });

            }

            $("#savePrescription1").on('click', savePrescription);
        });

    </script>
    <script src="{{ asset('js/user/patient/gestion_prescription.js') }}"></script>
@endsection
