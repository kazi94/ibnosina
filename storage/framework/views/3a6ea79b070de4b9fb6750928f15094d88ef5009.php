<?php $__env->startSection('script_css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('/plugins/toastr/toastr.css')); ?>">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .swal2-popup {
            font-size: 1.6rem !important;
        }

        .form-lol {
            background: #288CF0;
            background: #FFF;
            border: 2px solid #545454;
            padding: 25px;
            margin-bottom: 40px;
            margin: 2rem auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);

            position: relative;
        }

        .form-label {
            position: absolute;
            top: 0;
            left: 3rem;
            background: #FFF;
            padding: 0.5rem 1rem;
            margin: 0;
            transform: translateY(-50%);
            color: #545454;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: separate;
        }

        td {
            text-align: center;
            vertical-align: middle;
        }

        .pos {
            max-width: 55px;
            padding: 0px;
        }

        .premBg {
            background-color: #e4e4e4;
        }

        .error {
            border-color: red;
        }

        .sectiontitle {
            background-position: center;
            margin: 30px 0 0px;
            text-align: center;
            min-height: 20px;
        }

        .sectiontitle h2 {
            font-size: 40px;
            color: #545454;
            margin-bottom: 0px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .headerLine {
            width: 160px;
            height: 2px;
            display: inline-block;
            background: #101F2E;
        }

    </style>
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-12 ">
                    <form action="<?php echo e(route('protocole.store')); ?>" method="POST" id="formAddProtocole">
                        <?php echo e(csrf_field()); ?>

                        <input type="submit" style="display: none; float: left" class="btn btn-primary" id="submitForm"
                            value="Valider et ajouter le protocole">
                        <a type="button" class="btn  btn-default" href="<?php echo e(route('listProtocole')); ?>">Lister les
                            protocoles</a>
                        <button type="button" onclick="javascript:history.back();"
                            class="btn  btn-secondary">Annuler</button>
                        <div class="box box-solid">
                            <div class="box-header">

                                <div class="sectiontitle">
                                    <h2>Ajout protocole de chimiothérapie</h2><br>

                                </div>

                                <!-- /.box-header -->
                                <div class="lol">
                                    <div class="form-lol front">
                                        <h3 class="form-label"><strong> IDENTIFICATION DU PROTOCOLE</strong></h3>
                                        <div class="col-md-12" style="text-align: center">
                                            <div class="form-inline">
                                                <label for="nom_protocole">Nom du protocole:</label>
                                                <input type="text" class="form-control" id="nom_protocole"
                                                    name="nom_protocole" required>
                                            </div>
                                            <hr>

                                            <div class="col-md-7" style="text-align: center">
                                                <div class="col-md-6" style="text-align: center">
                                                    <br>
                                                    <div class="form-inline">
                                                        <label for="cure_min">Nombre de cures minimum:</label>
                                                        <input type="number" min="1" class="form-control" id="cure_min"
                                                            name="cure_min" style="width: 20%;text-align: center" required>
                                                    </div><br />
                                                    <div class="form-inline">
                                                        <label for="nbr_sequence">Intervalle entre cure (Jours): </label>
                                                        <input type="number" min="1" class="form-control" id="intervalle"
                                                            name="intervalle" style="width: 20%;text-align: center"
                                                            required>
                                                    </div><br />

                                                </div>
                                                <div class="col-md-6" style="text-align: center">
                                                    <br>
                                                    <div class="form-inline">
                                                        <label for="cure_max">Nombre de cures maximum:</label>
                                                        <input type="number" min="1" class="form-control" id="cure_max"
                                                            name="cure_max" style="width: 20%;text-align: center" required>
                                                    </div> <br />

                                                    <div class="form-inline">
                                                        <label for="nbr_sequence">Nombre séquences par cure:</label>
                                                        <input type="number" min="1" class="form-control" id="nbr_sequence"
                                                            name="nbr_sequence" style="width: 20%;text-align: center"
                                                            required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-5" style="text-align: center">
                                                <label class="control-label">Remarque protocole:</label>
                                                <div class="form-group">

                                                    <textarea id="remarque" name="remarque"
                                                        placeholder="Ecrivez quelque chose a propos du protocole" rows="4"
                                                        cols="55"></textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- /.box-body -->


                                        <div class="col-md-4" style="float: left">
                                            <button class="btn  btn-secondary" type=button onclick="generateTable()"
                                                id="btn_addSeq">Valider et continuer</button>
                                        </div>
                                        <div class="col-md-4">
                                            <p id="msg_err_nbrseq" style="color:red; display:none;">Nombre de séquences par
                                                cure invalide</p>
                                        </div>



                                        <!-- box-footer --><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </div>
                                </div><br>
                                <!-- /.box -->
                                <!-- **********************box2********************** -->


                                <!-- /.box-header -->
                                <div class="lol" hidden id="box_tab">
                                    <div class="form-lol front">
                                        <div style="overflow-x: auto;">
                                            <h3 class="form-label"><strong> RENSEIGNER LE PROTOCOLE</strong></h3><br>

                                            <div id="divTab" style="display: none">

                                                <table id="tab" class="table" border="1">
                                                    <tr id="firstTr">
                                                        <td><b>Etape</b></td>
                                                    </tr>
                                                    <tr id="trPrem1" class="premBg">
                                                        <td id="tdPrem" rowspan="1">

                                                            <b>Prémédication</b><br>
                                                            <a style="color:black; cursor: pointer;" id="add_med_prem"
                                                                onclick="addlignePrem()">
                                                                <span class="glyphicon glyphicon-plus-sign"></span></a>
                                                        </td>
                                                    </tr>
                                                    <tr id="trTrait1">
                                                        <td id="tdTrait" rowspan="1">
                                                            <b>Traitement</b><br>
                                                            <a style="color:black; cursor: pointer;" id="add_med_trait"
                                                                onclick="addligneTrait()">
                                                                <span class="glyphicon glyphicon-plus-sign"></span></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- /.box-body -->





                                <div class="col-md-4">
                                    <p id="msg_err_jr" style="color:red; display:none;"></p>
                                </div>

                                <!-- <button type="button" onclick="show()">okkkk</button>-->

                                <!-- box-footer -->

                                <!-- /.box -->
                    </form>
                    <div class="alert alert-danger" role="alert" id="div_error" style="display:none">
                        <ul id="list_error"></ul>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </section>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/sweetAlert/sweetalert.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/toastr/toastr.js')); ?>"></script>

    <script src="<?php echo e(asset('/js/user/chimio/gestion_addProtocole.js')); ?>"></script>

    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

    </script>

    <script type="text/javascript">
        var opt = '<option value=""></option>';
        var unites = {
            !!$unites!!
        };
        unites.forEach(function(unite) {
            opt = opt.concat('<option value="' + unite.unite + '">' + unite.unite + '</option>');
        });

        var tdprem = 1;
        var tdTrait = 1;

        var prem = 0;
        var trait = 0;
        var nb_seq;

        function generateTable() {
            nb_seq = $('#nbr_sequence').val();
            if (nb_seq != null && nb_seq != 0) {
                document.getElementById('box_tab').hidden = false;
                document.getElementById("msg_err_nbrseq").style.display = "none";
                // $("#box_tab").boxWidget('expand');
                $("#btn_addSeq").attr("disabled", true);
                $('#nbr_sequence').attr("readonly", true);
                var first_row = $("#tab tr:first");
                first_row.append('<td style="min-width:330px;"><b>Médicaments</b></td>');
                first_row.append('<td style="min-width:150px;"><b>Voies</b></td>');
                first_row.append('<td style="min-width:260px;"><b>Posologie</b></td>');

                var tdd = 0;
                var tdd1 = 0;

                for (var i = 1; i <= nb_seq; i++) {

                    $('#tab tr').each(function(t) {
                        if (t === 0) {
                            $(this).append(
                                '<td class="form-inline" style="min-width:75px;width:80px;padding:2px;"><b>J-</b><input class="form-control" style="width:45px; padding:0;text-align:center" type="number" id="seq_j" name="seq_j[]"></td>'
                                );
                        } else if (t === 1) {
                            if (tdd === 0) {
                                prem = prem + 1;
                                $(this).append('<td class="form-inline" style="display:none;"></td>' +
                                    '<td style="display:none;"></td>' +
                                    '<td style="display:none;"></td>');

                                tdd = 1;
                            }
                            $(this).append('<td style="display:none;"></td>');
                        } else if (t === 2) {
                            if (tdd1 === 0) {
                                trait = trait + 1;
                                $(this).append('<td class="form-inline" style="display:none;"></td>' +
                                    '<td style="display:none;"></td>' +
                                    '<td style="display:none;"></td>');
                                tdd1 = 1;
                            }
                            $('#trait_form').val(trait);
                            $(this).append('<td style="display:none;"></td>');
                        }

                    });
                }
                first_row.append('<td style="min-width:50px;"><b>Info</b></td>');
                var x = document.getElementById("divTab");
                x.style.display = "block";

                document.getElementById("submitForm").style.display = "block";
            } else {
                document.getElementById("msg_err_nbrseq").style.display = "block";
            }
        }

        function addlignePrem() {
            tdprem++;
            $("#tdPrem").attr('rowspan', tdprem);

            $('<tr id="trPrem' + (prem + 1) + '" class="premBg"><td class="form-inline">' +
                '<i class="fa fa-times-circle" id="deleteP" style="color:red;cursor : pointer;"></i>' +
                '<input type="hidden" name="med_sp_id_prem[]">' +
                '<input type="text" name="prem" class="form form-control" style="width:90%;" placeholder="Médicament DCI ou médicament commerciale" id="medicament_dci" autocomplete="off"></td>' +
                '<td><select class="form form-control" name="voie_prem[]"></select></td>' +
                '<td><div class="form-inline"><input type="number" min="1" required class="pos form form-control" name="pos_prem[]" required style="text-align: center">' +
                '&nbsp;<select class="pos form form-control" name="u1_prem[]">' + opt + '</select>&nbsp;' +
                '<select class="pos form form-control" name="u2_prem[]">' + opt + '</select>' +
                '</div></td></tr>'
            ).insertAfter($("#trPrem" + prem));

            prem++;

            for (var j = 1; j <= nb_seq; j++) {
                $($("#trPrem" + prem)).append('<td><input style="display:none;" type="checkbox" name="prem_seq_' + j +
                    '[]" value="0" checked>' +
                    '<input id="tc" style="margin-top:8px;" type="checkbox" name="prem_seq_' + j + '[]" value="' +
                    prem + '"></td>');
            }
            $($("#trPrem" + prem)).append(
                '<td><span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modal-' + prem +
                '" data-backdrop="static" style="color: black; cursor: pointer; position: relative; top: 10px;" ></span>' +
                '<div class="modal fade" id="modal-' + prem + '">' +
                '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button>' +
                '<h4 class="modal-title" style="text-align:left">DÉTAIL</h4>' +
                '</div>    ' +
                '<div class="modal-body">' +
                '<div class="box-body">' +
                '<div class="col-sm-12">' +
                '<label class="col-sm-12 control-label" style="text-align:left">Solvant</label>' +
                '<textarea name="solvant_prem[]" id="" class="col-xs-12 col-md-12"></textarea> <br><br>' +
                '<br><br><label class="col-sm-12 control-label" style="text-align:left">Commentaire</label>' +
                '<textarea name="commentairedci_prem[]" id="" class="col-xs-12 col-md-12"></textarea>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">' +
                '</div>   ' +
                '</div>' +
                '</div>' +
                '</div> </td>');
        }

        function addligneTrait() {
            tdTrait++;
            $("#tdTrait").attr('rowspan', tdTrait);

            $('<tr id="trTrait' + (trait + 1) + '"><td class="form-inline">' +
                    '<i class="fa fa-times-circle" id="delete" style="color:red;cursor : pointer;"></i>' +
                    '<input type="hidden" name="med_sp_id_trait[]">' +
                    '<input type="text" name="trait" class="form form-control" style="width:90%;" placeholder="Médicament DCI ou médicament commerciale" id="medicament_dci" autocomplete="off"></td>' +
                    '<td><select class="form form-control" name="voie_trait[]"></select></td>' +
                    '<td><div class="form-inline"><input type="number" min="1" required class="pos form form-control" name="pos_trait[]" required style="text-align:center">' +
                    '&nbsp;<select class="pos form form-control" name="u1_trait[]">' + opt + '</select>&nbsp;' +
                    '<select class="pos form form-control" name="u2_trait[]">' + opt + '</select>&nbsp;' +
                    '<select class="pos form form-control" name="u3_trait[]">' + opt + '</select></div></td></tr>')
                .insertAfter($("#trTrait" + trait));

            trait++;

            for (var j = 1; j <= nb_seq; j++) {
                $($("#trTrait" + trait)).append('<td><input style="display:none;" type="checkbox" name="trait_seq_' + j +
                    '[]" value="0" checked>' +
                    '<input id="tc" style="margin-top:8px;" type="checkbox" name="trait_seq_' + j + '[]" value="' +
                    trait + '"></td>');
            }
            $($("#trTrait" + trait)).append(
                '<td><span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modal-' + (trait +
                100) +
                '" data-backdrop="static" style="color: black; cursor: pointer; position: relative; top: 10px;" ></span>' +
                '<div class="modal fade" id="modal-' + (trait + 100) + '">' +
                '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button>' +
                '<h4 class="modal-title" style="text-align:left">DÉTAIL</h4>' +
                '</div>    ' +
                '<div class="modal-body">' +
                '<div class="box-body">' +
                '<div class="col-sm-12">' +
                '<label class="col-sm-12 control-label" style="text-align:left" >Solvant</label>' +
                '<textarea name="solvant_trait[]" id="" class="col-xs-12 col-md-12"></textarea> <br><br>' +
                '<br><br><label class="col-sm-12 control-label" style="text-align:left">Commentaire</label>' +
                '<textarea name="commentairedci_trait[]" id="" class="col-xs-12 col-md-12"></textarea>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">' +
                '</div>   ' +
                '</div>' +
                '</div>' +
                '</div> </td>');
        }


        $('#tab').on('click', '#tc', function() {
            console.log("4654");
            if ($(this).is(':checked')) {
                $(this).prev().attr('value', '');
                $(this).prev().click();
            } else {
                console.log("uncheked");
                $(this).prev().attr('value', '0');
                $(this).prev().click();
            }

        });


        $("#submitForm").click(function() {
            event.preventDefault();
            $this = $("#formAddProtocole");

            $("#div_error").css("display", "none");
            $("#list_error").empty();
            $("input").removeClass("error");

            $.ajax({
                url: $this.attr('action'),
                method: $this.attr('method'),
                data: $this.serialize(),
                datatype: 'json',
                success: function(data) {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        type: 'success',
                        title: 'Protocole ajouter'
                    })
                    window.setTimeout(function() {
                        location.href = "<?php echo e(route('listProtocole')); ?>"
                    }, 3000);
                },
                error: function(error) {
                    console.log(error);
                    var obj = error.responseJSON.errors;
                    if (error.status == 422) {
                        if ('nom_protocole' in obj) {
                            $("#list_error").append("<li>" + obj.nom_protocole + "</li>");
                            $("#nom_protocole").addClass("error");
                        }
                        if ('cure_min' in obj) {
                            $("#list_error").append("<li>" + obj.cure_min + "</li>");
                            $("#cure_min").addClass("error");
                        }
                        if ('cure_max' in obj) {
                            $("#list_error").append("<li>" + obj.cure_max + "</li>");
                            $("#cure_max").addClass("error");
                        }
                        if ('intervalle' in obj) {
                            $("#list_error").append("<li>" + obj.intervalle + "</li>");
                            $("#intervalle").addClass("error");
                        }
                        if ('seq_j' in obj) {
                            $("#list_error").append("<li>" + obj.seq_j + "</li>");
                            $("input[name='seq_j[]']").addClass("error");
                        }
                        if ('med_sp_id_prem' in obj) {
                            $("#list_error").append("<li>" + obj.med_sp_id_prem +
                                " (prémédication)</li>");
                            $("input[name='prem']").addClass("error");
                        }
                        if ('med_sp_id_trait' in obj) {
                            $("#list_error").append("<li>" + obj.med_sp_id_trait +
                            " (traitement)</li>");
                            $("input[name='trait']").addClass("error");
                        }
                        if ('pos_prem' in obj) {
                            $("#list_error").append(
                                "<li>Verifier les valeurs de posologie prémidication</li>");
                            $("input[name='pos_prem[]']").addClass("error");
                        }
                        if ('pos_trait' in obj) {
                            $("#list_error").append(
                                "<li>Verifier les valeurs de posologie traitements</li>");
                            $("input[name='pos_trait[]']").addClass("error");
                        }

                        document.getElementById("div_error").style.display = "block";
                    }
                }
            });

        });



        $('form input').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });


        //function to delete row
        $('#tab').on('click', '#delete', function() {
            tdTrait--;
            $("#tdTrait").attr('rowspan', tdTrait);

            $(this).closest('tr').find('input,select').remove();
            $(this).closest('tr').hide();
        });

        //function to delete row
        $('#tab').on('click', '#deleteP', function() {
            tdprem--;
            $("#tdPrem").attr('rowspan', tdprem);

            $(this).closest('tr').find('input,select').remove();
            $(this).closest('tr').hide();
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\chimio\addProtocole.blade.php ENDPATH**/ ?>