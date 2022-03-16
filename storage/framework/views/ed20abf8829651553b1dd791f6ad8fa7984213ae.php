<?php $__env->startSection('script_css'); ?>
<?php $__env->startSection('title'); ?>
    Mon Service
<?php $__env->stopSection(); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/morris.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="content-wrapper" style="min-height: 1036px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mon Service
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 class="patients"></h3>

                        <p>Patients Ajoutés</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus"></i>
                    </div>
                    <a href="<?php echo e(route('patient.index')); ?>" class="small-box-footer">Plus d'info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 class="deaths"></h3>

                        <p>Décés Aujourd'hui</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sad-tear"></i>
                    </div>
                    <a href="<?php echo e(route('patient.archives')); ?>" class="small-box-footer">Plus d'info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 class="exits"></h3>

                        <p>Sorties du service aujourd'hui</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-out-alt"></i>
                    </div>
                    <a href="" class="small-box-footer"><br></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="prescriptions"></h3>

                        <p>Prescriptions rédigées</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clipboard"></i>
                    </div>
                    <a href="" class="small-box-footer"><br></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <!-- /.col (LEFT) -->
            <div class="col-md-12">

                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Prescriptions à risque</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive" id="chart-presc-risque">
                            <div class="form-group">
                                <label for="from">Du</label>
                                <input type="text" id="from" name="from" autocomplete="off">
                                <label for="to">Au</label>
                                <input type="text" id="to" name="to" autocomplete="off">
                                <canvas id="line-chart" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>

                    <div class="col-md-6">
                        <!-- DONUT CHART -->
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Analyses pharmaceutiques</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool"><i class="fa fa-cog"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <label for="from">Du</label>
                                <input type="text" id="from1" name="from" autocomplete="off">
                                <label for="to">Au</label>
                                <input type="text" id="to1" name="to" autocomplete="off">
                                <canvas id="pieChart" style="height: 263px; width: 526px;" width="526"
                                    height="263"></canvas>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                <?php endif; ?>
            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- /.col (LEFT) -->
            <div class="col-md-12">

                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Prescriptions</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                            <div>
                                <label for="from">Du</label>
                                <input type="text" id="from2" name="from" autocomplete="off">
                                <label for="to">Au</label>
                                <input type="text" id="to2" name="to" autocomplete="off">
                                <canvas id="line-chart-prescription" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>

                    <div class="col-md-6">
                        <!-- DONUT CHART -->
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Problèmes pharmaceutique</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <label for="from">Du</label>
                                <input type="text" id="from3" name="from" autocomplete="off">
                                <label for="to">Au</label>
                                <input type="text" id="to3" name="to" autocomplete="off">
                                <canvas id="pieChartProblemPharma" style="height: 263px; width: 526px;" width="526"
                                    height="263"></canvas>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                <?php endif; ?>
            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- /.col (LEFT) -->
            <div class="col-md-12">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>

                    <div class="col-md-6">
                        <!-- DONUT CHART -->
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Interventions pharmaceutique</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <label for="from">Du</label>
                                <input type="text" id="from4" name="from" autocomplete="off">
                                <label for="to">Au</label>
                                <input type="text" id="to4" name="to" autocomplete="off">
                                <canvas id="pieChartInterventionPharma" style="height: 263px; width: 526px;" width="526"
                                    height="263"></canvas>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Patients</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                            <div>
                                <label for="from">Du</label>
                                <input type="text" id="from5" name="from" autocomplete="off">
                                <label for="to">Au</label>
                                <input type="text" id="to5" name="to" autocomplete="off">
                                <canvas id="line-chart-patients" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-sm-12">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Consultations</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                            <div>
                                <label for="from">Du</label>
                                <input type="text" id="from6" name="from" autocomplete="off">
                                <label for="to">Au</label>
                                <input type="text" id="to6" name="to" autocomplete="off">
                                <canvas id="bar-chart-consultations" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
<script src="<?php echo e(asset('plugins/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/ChartJs/js/Chart.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/ChartJs/js/util.js')); ?>"></script>
<script>
    let colors = [
        "#38eb7a",
        "#ffab03",
        "#ffda05",
        "#00b803",
        "#47a7c9",
        "#704444",
        "#1c2a57",
        "#f505c9",
        "#c90ffc",
        "#0fecfc",
        "#0ffcd1",
        "#d4fc0f",
        "#f5cc00",
        "#f58f00",
    ];
    $(function() {
        var chartRisk,
            chartPrescription,
            chartProblemes,
            chartIp,
            chartAnalyse,
            chartConsultations,
            chartPatients;
        var dateFormat = "mm/dd/yy",
            configFrom = {
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                changeYear: true
            },
            configTo = {
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                changeYear: true
            };
        var from = $("#from")
            .datepicker(configFrom)
            .on("change", function() {
                to.datepicker("option", "minDate", getDate(this));
            });
        var to = $("#to").datepicker(configTo)
            .on("change", function() {
                from.datepicker("option", "maxDate", getDate(this));
            });
        var from1 = $("#from1")
            .datepicker(configFrom)
            .on("change", function() {
                to1.datepicker("option", "minDate", getDate(this));
            });
        var to1 = $("#to1").datepicker(configTo)
            .on("change", function() {
                from1.datepicker("option", "maxDate", getDate(this));
            });
        var from2 = $("#from2")
            .datepicker(configFrom)
            .on("change", function() {
                to2.datepicker("option", "minDate", getDate(this));
            });
        var to2 = $("#to2").datepicker(configTo)
            .on("change", function() {
                from2.datepicker("option", "maxDate", getDate(this));
            });
        var from3 = $("#from3")
            .datepicker(configFrom)
            .on("change", function() {
                to3.datepicker("option", "minDate", getDate(this));
            });
        var to3 = $("#to3").datepicker(configTo)
            .on("change", function() {
                from3.datepicker("option", "maxDate", getDate(this));
            });
        var from4 = $("#from4")
            .datepicker(configFrom)
            .on("change", function() {
                to4.datepicker("option", "minDate", getDate(this));
            });
        var to4 = $("#to4").datepicker(configTo)
            .on("change", function() {
                from4.datepicker("option", "maxDate", getDate(this));
            });
        var from5 = $("#from5")
            .datepicker(configFrom)
            .on("change", function() {
                to5.datepicker("option", "minDate", getDate(this));
            });
        var to5 = $("#to5").datepicker(configTo)
            .on("change", function() {
                from5.datepicker("option", "maxDate", getDate(this));
            });
        var from6 = $("#from6")
            .datepicker(configFrom)
            .on("change", function() {
                to6.datepicker("option", "minDate", getDate(this));
            });
        var to6 = $("#to6").datepicker(configTo)
            .on("change", function() {
                from6.datepicker("option", "maxDate", getDate(this));
            });


        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }


        // -------------
        // - PRESCRIPTIONS / Patients / DEATHS / EXITS -
        // -------------

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/api/stats/getAll',
                type: 'GET',
                dataType: 'JSON',

            })
            .done(function(obj) {
                $(".patients").text(obj.patients);
                //$(".users").text(obj.users);
                $(".prescriptions").text(obj.prescriptions);
                $(".exits").text(obj.exits);
                $(".deaths").text(obj.deaths);
            })
            .fail(function(e1, e2) {
                console.log(e1 + e2);
            })
            .always(function() {

            });

        // -------------
        // - PRESCRIPTIONS A RISQUE CHART -
        // -------------
        var ctx = document.getElementById('line-chart').getContext('2d');

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/api/stats/get-prescriptions-risque//',
                type: 'GET',
                dataType: 'JSON',

            })
            .done(function(obj) {
                drawPrescRiskChart(obj, ctx);
            })
            .fail(function(e1, e2) {
                console.log(e1 + e2);
            })
            .always(function() {
                console.log("complete");
            });

        function drawPrescRiskChart(obj, ctx) {
            // return array of labels , and data
            var labels = obj.map(function(e) {
                return moment(e.d_risque).format(
                    'LL'
                ); // moment().format() : affiche la date dans un format spécifique , ll : 'Jan 29,2019'
            });
            var data = obj.map(function(e) {
                return e.nbr;
            });;

            //Configuration des éléments du graphe
            var color = Chart.helpers.color;
            var config = {
                type: 'line',
                data: {
                    labels: labels, // labels: les valeurs de l'axe des x , ici : updated_at
                    datasets: [{
                        label: 'Nombre de prescriptions à risque',
                        backgroundColor: color(window.chartColors.red).alpha(0.5)
                            .rgbString(), //Couleur de fond du rectangle afficher dans le titre
                        borderColor: window.chartColors
                            .red, //Couleur de bordure du rectangle afficher dans le titre
                        fill: false,
                        data: data, // data les valeur de l'axe des y
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        xAxes: [{
                            type: 'time', // time pour afficher en forme de date extensible
                            display: true, //Afficher l'axe des x
                            scaleLabel: {
                                display: true,
                                labelString: 'Temps' // Donner un label à l'axe des x
                            },
                            ticks: {
                                major: {
                                    fontStyle: 'bold',
                                    fontColor: '#FF0000'
                                }
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Nombre de prescriptions'
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            defaultFontSize: 18
                        }
                    }
                }
            };

            //Création du graphe
            chartRisk = new Chart(ctx, config);
        }
        // -------------
        // - PRESCRIPTIONS  CHART -
        // -------------
        var ctx1 = document.getElementById('line-chart-prescription').getContext('2d');


        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/api/stats/get-prescriptions//',
                type: 'GET',
                dataType: 'JSON',

            })
            .done(function(obj) {
                drawPrescPrescriptionChart(obj);
            })
            .fail(function(e1, e2) {
                console.log(e1 + e2);
            })
            .always(function() {
                console.log("complete");
            });


        function drawPrescPrescriptionChart(obj) {
            // return array of labels , and data
            var labels = obj.map(function(e) {
                return moment(e.date_prescription).format(
                    'LL'
                ); // moment().format() : affiche la date dans un format spécifique , ll : 'Jan 29,2019'
            });
            var data = obj.map(function(e) {
                return e.nbr;
            });;

            //Configuration des éléments du graphe
            var color = Chart.helpers.color;
            var config = {
                type: 'line',
                data: {
                    labels: labels, // labels: les valeurs de l'axe des x , ici : updated_at
                    datasets: [{
                        label: 'Nombre de prescriptions',
                        backgroundColor: color(window.chartColors.red).alpha(0.5)
                            .rgbString(), //Couleur de fond du rectangle afficher dans le titre
                        borderColor: window.chartColors
                            .red, //Couleur de bordure du rectangle afficher dans le titre
                        fill: false,
                        data: data, // data les valeur de l'axe des y
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        xAxes: [{
                            type: 'time', // time pour afficher en forme de date extensible
                            display: true, //Afficher l'axe des x
                            scaleLabel: {
                                display: true,
                                labelString: 'Temps' // Donner un label à l'axe des x
                            },
                            ticks: {
                                major: {
                                    fontStyle: 'bold',
                                    fontColor: '#FF0000'
                                }
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Nombre de prescriptions'
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            defaultFontSize: 18
                        }
                    }
                }
            };

            //Création du graphe
            chartPrescription = new Chart(ctx1, config);
        }


        // -------------
        // - ANALYSES PHARMACEUTIQUES CHART -
        // -------------
        // Get context with jQuery - using jQuery's .ajax() method.
        $.ajax({
                url: '/api/stats/get-analyse-pharmaceutique//',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'json'
            })
            .done((data) => {
                drawPrescAnalyseChart(data);
            });

        function drawPrescAnalyseChart(data) {
            var labels = data.map(function(e) {
                return e.type_effet;
            });
            var data = data.map(function(e) {
                return e.nb;
            });;
            var config = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            window.chartColors.green,
                            window.chartColors.orange,
                            window.chartColors.yellow,
                            window.chartColors.brown,
                            window.chartColors.blue,
                            window.chartColors.grey,
                            window.chartColors.red,
                        ],
                        label: 'Evenement indésirables'
                    }],
                    labels: labels
                },
                options: {
                    responsive: true
                }
            };
            var ctx2 = document.getElementById('pieChart').getContext('2d');
            chartAnalyse = new Chart(ctx2, config);
        }
        // -------------
        // - PROBLEMES PHARMACEUTIQUES CHART -
        // -------------
        // Get context with jQuery - using jQuery's .ajax() method.
        $.ajax({
                url: '/api/stats/get-probleme-pharmaceutique//',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'json'
            })
            .done((data) => {
                drawPrescProblemeChart(data);
            });

        function drawPrescProblemeChart(data) {
            let labels = [];
            let datas = [];
            $.each(data, function(index, val) {
                labels.push(index);
                datas.push(val);
            });
            var config = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: datas,
                        backgroundColor: colors,
                        label: 'Evenement indésirables'
                    }],
                    labels: labels
                },
                options: {
                    responsive: true
                }
            };
            var ctx3 = document.getElementById('pieChartProblemPharma').getContext('2d');
            chartProblemes = new Chart(ctx3, config);
        }

        // -------------
        // - INTERVENTIONS PHARMACEUTIQUES CHART -
        // -------------
        // Get context with jQuery - using jQuery's .ajax() method.
        $.ajax({
                url: '/api/stats/get-intervention-pharmaceutique//',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'json'
            })
            .done((data) => {
                drawPrescInterventionChart(data);

            });

        function drawPrescInterventionChart(data) {
            var labels = data.map(function(e) {
                return e.ip;
            });
            var data = data.map(function(e) {
                return e.compt;
            });;
            var config = {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            window.chartColors.green,
                            window.chartColors.orange,
                            window.chartColors.yellow,
                            window.chartColors.brown,
                            window.chartColors.blue,
                            window.chartColors.grey,
                            window.chartColors.red,
                        ],
                        label: 'Interventions pharmaceutique'
                    }],
                    labels: labels
                },
                options: {
                    responsive: true
                }
            };
            var ctx4 = document.getElementById('pieChartInterventionPharma').getContext('2d');
            chartIp = new Chart(ctx4, config);
        }
        // -------------
        // - PATIENTS  CHART -
        // -------------
        var ctx2 = document.getElementById('line-chart-patients').getContext('2d');

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/api/stats/get-patients//',
                type: 'GET',
                dataType: 'JSON',

            })
            .done(function(obj) {
                drawPrescPatientChart(obj);
            })
            .fail(function(e1, e2) {
                console.log(e1 + e2);
            })
            .always(function() {
                console.log("complete");
            });

        function drawPrescPatientChart(obj) {
            // return array of labels , and data
            var labels = obj.map(function(e) {
                return moment(e.date_created).format(
                    'LL'
                ); // moment().format() : affiche la date dans un format spécifique , ll : 'Jan 29,2019'
            });
            var data = obj.map(function(e) {
                return e.nbr;
            });;

            //Configuration des éléments du graphe
            var color = Chart.helpers.color;
            var config = {
                type: 'line',
                data: {
                    labels: labels, // labels: les valeurs de l'axe des x , ici : updated_at
                    datasets: [{
                        label: 'Nombre de Patients',
                        backgroundColor: color(window.chartColors.red).alpha(0.5)
                            .rgbString(), //Couleur de fond du rectangle afficher dans le titre
                        borderColor: window.chartColors
                            .red, //Couleur de bordure du rectangle afficher dans le titre
                        fill: false,
                        data: data, // data les valeur de l'axe des y
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        xAxes: [{
                            type: 'time', // time pour afficher en forme de date extensible
                            display: true, //Afficher l'axe des x
                            scaleLabel: {
                                display: true,
                                labelString: 'Temps' // Donner un label à l'axe des x
                            },
                            ticks: {
                                major: {
                                    fontStyle: 'bold',
                                    fontColor: '#f0000'
                                }
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Nombre de patients'
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            defaultFontSize: 18
                        }
                    }
                }
            };

            //Création du graphe
            chartPatients = new Chart(ctx2, config);
        }
        // -------------
        // - CONSULTATIONS  CHART -
        // -------------
        var ctx3 = document.getElementById('bar-chart-consultations').getContext('2d');

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/api/stats/get-consultations//',
                type: 'GET',
                dataType: 'JSON',

            })
            .done(function(obj) {
                drawPrescConsultationChart(obj);

            })
            .fail(function(e1, e2) {
                console.log(e1 + e2);
            })
            .always(function() {
                console.log("complete");
            });

        function drawPrescConsultationChart(obj) {


            var randomColorGenerator = function() {
                return '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
            };
            var colors = [];
            // return array of labels of X axis, and data
            var labels = obj.map(function(e) {
                return e.name;
            });
            var data = obj.map(function(e) {
                return e.nbr;
            });
            data.forEach(element => {
                colors.push(randomColorGenerator());
            });
            //Configuration des éléments du graphe
            var color = Chart.helpers.color;
            var config = {
                type: 'horizontalBar',
                data: {
                    labels: labels, // labels: les valeurs de l'axe des x , ici : updated_at
                    datasets: [{
                        label: 'Nombre de Consultations',
                        backgroundColor: colors, //Couleur de fond du rectangle afficher dans le titre
                        borderWidth: 1,
                        borderColor: colors, //Couleur de bordure du rectangle afficher dans le titre
                        data: data, // data les valeur de l'axe des y
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Signe formelles'
                    }
                }
            };

            //Création du graphe
            chartConsultations = new Chart(ctx3, config);
        }

        $('input').on('change', function(event) {
            console.log('changed');
            event.preventDefault();
            var from = $(this).parent().find('input[name="from"]').val();
            var to = $(this).parent().find('input[name="to"]').val();

            if (from && to) {
                var idChart = $(this).parent().find('canvas').attr('id');
                console.log(idChart);
                var rangeStart = moment(from).format("YYYY-MM-DD");
                var rangeEnd = moment(to).format("YYYY-MM-DD");
                console.log(rangeStart);
                console.log(rangeEnd);
                var url = getUrl(idChart, rangeStart, rangeEnd);
                var request = $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'JSON',
                    // data: {
                    //     rangeStart: rangeStart,
                    //     rangeEnd: rangeEnd,
                    // },
                    cache: false
                });
                request.done(function(response, textStatus) {
                    console.log('done');
                    switch (idChart) {
                        case 'line-chart': // chart prescriptions à risque
                            removeDataset(chartRisk);
                            drawPrescRiskChart(response, chartRisk);

                            break;
                        case 'line-chart-prescription': // prescriptions Chart
                            removeDataset(chartPrescription);
                            drawPrescPrescriptionChart(response, chartPrescription);

                            break;
                        case 'pieChart': // Analyse Pharma Chart
                            removeDataset(chartAnalyse);
                            drawPrescAnalyseChart(response, chartAnalyse);

                            break;
                        case 'pieChartProblemPharma': // Problème Chart
                            removeDataset(chartProblemes);
                            drawPrescProblemeChart(response, chartProblemes);

                            break;
                        case 'pieChartInterventionPharma': // Interventions Pharma Chart
                            removeDataset(chartIp);
                            drawPrescInterventionChart(response, chartIp);

                            break;
                        case 'line-chart-patients': // Patients Chart
                            removeDataset(chartPatients);
                            drawPrescPatientChart(response, chartPatients);

                            break;
                        case 'bar-chart-consultations': // Consultations Chart
                            removeDataset(chartConsultations);
                            drawPrescConsultationChart(response, chartConsultations);

                            break;
                        default:
                            break;
                    }


                });
                request.fail(function(textStatus, errorThrown) {
                    // Log the error to the console
                    console.error(
                        "The following error occurred: " +
                        textStatus, errorThrown
                    );
                });

                request.always(function() {
                    console.log('request finished');
                });
            }
        });

        function getUrl(idChart, rangeStart, rangeEnd) {
            switch (idChart) {
                case 'line-chart':
                    return '/api/stats/get-prescriptions-risque/' + rangeStart + '/' + rangeEnd
                    break;
                case 'line-chart-prescription':
                    return '/api/stats/get-prescriptions/' + rangeStart + '/' + rangeEnd
                    break;
                case 'pieChart':
                    return '/api/stats/get-analyse-pharmaceutique/' + rangeStart + '/' + rangeEnd
                    break;
                case 'pieChartProblemPharma':
                    return '/api/stats/get-probleme-pharmaceutique/' + rangeStart + '/' + rangeEnd
                    break;
                case 'pieChartInterventionPharma':
                    return '/api/stats/get-intervention-pharmaceutique/' + rangeStart + '/' + rangeEnd
                    break;
                case 'line-chart-patients':
                    return '/api/stats/get-patients/' + rangeStart + '/' + rangeEnd
                    break;
                case 'bar-chart-consultations':
                    return '/api/stats/get-consultations/' + rangeStart + '/' + rangeEnd
                    break;
                default:
                    break;
            }
        }

        function removeDataset(chart) {
            chart.data.labels.pop();
            chart.data.datasets = [];
            chart.update();
        };
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\stats\show.blade.php ENDPATH**/ ?>