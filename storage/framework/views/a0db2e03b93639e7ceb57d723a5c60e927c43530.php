<link rel="stylesheet" href="<?php echo e(asset('plugins/scheduler/codebase/dhtmlxscheduler_material.css?v=5.2.1')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/select2/dist/css/select2.min.css')); ?>">


<style>
    .add_button_set {
        background-color: #ffffff;
    }

    .dhx_menu_icon.icon_validate {
        background-image: url('location_icon.png');
    }

    .dhx_menu_icon.icon_invalidate {
        background-image: url('location_icon.png');
    }

    .dhx_qi_big_icon.icon_invalidate {
        color: #ff584c;
    }

</style>


<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <section class="content">
            <?php if(session()->has('message')): ?>
                <p class="alert alert-success" id="message" style="display: none;"><?php echo e(session('message')); ?></p>
            <?php endif; ?>

            <div id="scheduler_here" class="dhx_cal_container table-responsive" style='width:100%; height:100%;'>
                <div class="dhx_cal_navline">
                    <div class="dhx_cal_prev_button">&nbsp;</div>
                    <div class="dhx_cal_next_button">&nbsp;</div>
                    <div class="dhx_cal_today_button"></div>
                    <div class="dhx_cal_date"></div>
                    <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                    <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                    <div class="dhx_cal_tab" name="agenda_tab" style="right:280px;"></div>
                    <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
                </div>
                <div class="dhx_cal_header">
                </div>
                <div class="dhx_cal_data">
                </div>
            </div>

        </section>
    </div>

    <div class="modal fade in" id="modal_patient">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Ajouter Nouveau Patient</h4>
                </div>
                <form class="form-group">
                    <div class="modal-body table-responsive" style="display: block;">

                        <?php echo e(csrf_field()); ?>

                        <div class="col-sm-12">
                            <div class="form-group">

                                <label for="matricule" class="label-control"> Nom*

                                    <input type="text" class="form-control" name="nom" placeholder="Nom" required>

                                </label>

                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">

                                <label for="nom" class="label-control"> Prénom*

                                    <input type="text" class="form-control" name="prenom" placeholder="Prénom" />

                                </label>

                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">

                                <label for="prénom" class="label-control"> Date de Naissance

                                    <input type="date" class="form-control" name="date_naissance" />

                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
                        <input type="button" class="btn btn-primary pull-right" onClick="addPatient(event)"
                            value="Confirmer">
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/scheduler/codebase/dhtmlxscheduler.js?v=5.2.1')); ?>" type="text/javascript"
        charset="utf-8"></script>
    <script src="<?php echo e(asset('plugins/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.2.1')); ?>"
        type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo e(asset('plugins/scheduler/codebase/ext/dhtmlxscheduler_quick_info.js?v=5.2.1')); ?>"
        type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo e(asset('plugins/scheduler/codebase/ext/dhtmlxscheduler_readonly.js?v=5.2.1')); ?>" type="text/javascript"
        charset="utf-8"></script>
    <script src="<?php echo e(asset('plugins/scheduler/codebase/sources/locale/locale_fr.js')); ?>" type="text/javascript"
        charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        

        function addPatient(event) {
            event.preventDefault();
            let myModal = $('#modal_patient');
            $.ajax({
                    url: '/appointement/storePatient',
                    type: 'POST',
                    data: $('form').serialize(),
                })
                .done(function(data, status, code) {
                    let nom = $('form').find("input[name='nom']").val();
                    let prenom = $('form').find("input[name='prenom']").val();
                    $('#patients').append("<option value=" + data.p_id + ">" + nom + " " + prenom + "</option>");
                    toastr.success("Patient ajouté avec succés");
                    myModal.modal({
                        hide: true
                    });
                })
                .fail(function(error, status, message) {
                    toastr.warning("Code d'erreur :" + error.status + " , " + error.responseJSON.message);
                })
                .always(function() {
                    console.log("complete");
                });
        }

        

        function getTypeRdv() {
            let types = [];
            //get json records from general.json and display bilan and unités in there respective select for admin
            $.getJSON("/js/json/general.json", function(obj) {

                $.each(obj, function(key, value) {
                    // console.log(value.unite.length)
                    if (value.type_rdv != "")
                        types.push({
                            "label": value.type_rdv,
                            "key": value.type_rdv
                        });
                });
            });
            return types;
        }

        function init() {
            scheduler.config.touch = "force"; //when touch to the cas , modals appear
            scheduler.config.multi_day = true;
            scheduler.config.prevent_cache = true;
            scheduler.config.first_hour = 8; //first hour display in calendar
            scheduler.config.start_on_monday = false; //Set First day to Sunday (Dimanche)
            scheduler.config.limit_time_select = true;
            scheduler.config.date_format = "%Y-%m-%d %H:%i:%s"; //parse returned date to spesefic format 
            scheduler.locale.labels.agenda_tab = "Agenda"; //Nom tab Agenda
            scheduler.config.event_duration = 60; //specify the event duration in minutes for the auto_end_time parameter
            scheduler.config.auto_end_date = true;
            scheduler.config.details_on_dblclick = true;
            scheduler.config.dblclick_create = true;
            // scheduler.config.readonly_form = true; // readonly just lightbox
            // scheduler.config.readonly= true; //readonly all calendar

            // Définir le text , View:Agenda , Column:Description
            scheduler.templates.agenda_text = function(start, end, ev) {
                return ev.type_rdv + " avec le Patient : " + scheduler.getLabel("patient_id", ev.patient_id);
            };

            //Définir le text dans l'event box
            scheduler.templates.event_text = function(start, end, ev) {
                return ev.type_rdv /*+" avec le Patient : "+scheduler.getLabel("patient_id" , ev.patient_id)*/ ;
            };

            //Définir le text dans le titre du popup(quand on clique une fois sur l'event)
            scheduler.templates.quick_info_title = function(start, end, ev) {
                return ev.type_rdv;
            };

            //Définir le text dans le corps du popup(quand on clique une fois sur l'event)
            scheduler.templates.quick_info_content = function(start, end, ev) {
                return "Patient : " + scheduler.getLabel("patient_id", ev.patient_id);
            };
            // ****************************
            //Config Edit Bars 
            //*****************************
            // Redefine icons_select as in:
            // scheduler.config.icons_select = [
            //    "icon_validate",
            //    "icon_cancel",
            //    "icon_details",
            //     "icon_delete"
            // ];
            // // Set the label for the new button:
            // scheduler.locale.labels.icon_validate = "Valider";
            // scheduler.locale.labels.icon_invalidate = "Non honoré";
            // //Specify the handler for processing clicks on the button:
            // scheduler._click.buttons.validate = function(id){
            //    alert('coucou');
            // };
            // scheduler._click.buttons.invalidate = function(id){
            //    alert('coucou');
            // };    
            scheduler.form_blocks["my_editor1"] = {
                render: function(sns) {
                    let options = "";
                    let patients = scheduler.serverList("type");
                    $.each(patients, function(index, val) {
                        options += "<option value=" + val.key + ">" + val.label + "</option>";
                    });
                    let html = "<div class='dhx_cal_ltext' style='height:60px;'>" +
                        "<select class=' select2' name='patient_id' id='patients' style='width:277px; margin :5px;'>" +
                        options + "</select>" +
                        "<button class='btn btn-dropbox' id='addPatient' style='margin-left:5px;' data-toggle='modal' data-target='#modal_patient' >+</button>" +
                        "</div>";
                    return html;
                },
                set_value: function(node, value, ev) {
                    node.querySelector("[name='patient_id']").value = value || "";
                },
                get_value: function(node, ev) {
                    return node.querySelector("[name='patient_id']").value;
                }
            };

            // Handle View Permission
            //scheduler.attachEvent("onBeforeDrag",block_readonly); // block drag event
            //scheduler.attachEvent("onClick",block_readonly); //block edit event
            // function block_readonly(id){ // block edit  event external users
            //   if(id != undefined) {
            //       var event = scheduler.getEvent(id); // can't edit détails
            //       return !event.readonly; 
            //   }
            // }
            scheduler.attachEvent("onLightBox", function() {
                $('.select2').select2(); // pour afficher select2

            });

            // specify The content Of Event Modal
            scheduler.config.lightbox.sections = [{
                    name: "Type ",
                    height: 23,
                    type: "select",
                    map_to: "type_rdv",
                    options: getTypeRdv()
                },
                {
                    name: "Patient",
                    height: 23,
                    type: "my_editor1",
                    map_to: "patient_id",
                    options: scheduler.serverList("type")
                },
                {
                    name: "Description",
                    height: 100,
                    type: "textarea",
                    map_to: "text"
                },
                {
                    name: "Periode",
                    height: 72,
                    type: "time",
                    map_to: "auto"
                }
            ];

            // Init Scheduler
            scheduler.init("scheduler_here", new Date(), "week");

            // load data from DB
            scheduler.load("/appointement/1", "json");

            var dp = new dataProcessor("/appointement"); //Rest Mode : PUT,POST,DELETE
            dp.init(scheduler);
            dp.setTransactionMode({
                mode: "REST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content'), // specify Toekn to avoid 419 error
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' // to send Form Data instead of head request
                }
            });
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\appointement.blade.php ENDPATH**/ ?>