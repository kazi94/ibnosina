$dashboard = '';
$patient_id = '';
$data = '';
var choix;



$('#date_debut_tab').on('change', function () {
	preparer();
});

$('#date_fin_tab').on('change', function () {
	preparer();
});

$('#graphesBtn').on('click', function () {
	var checkbox = document.getElementsByName('dash');

	for (var i = 0; i < checkbox.length; i++) {
		if (checkbox[i].checked) {
			$dashboard = checkbox[i].value;
		}
	}

	$patient_id = document.getElementById('id_pat').value;

	if ($dashboard != '') {
		$('#modal_Graphes1').modal('hide');
		$('#modal_Graphes2').modal('show');
		document.getElementById('title').innerHTML = "Tableau de bord: " + $dashboard;
	}
	ajaxGetData1();
});

function ajaxGetData1() {
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: '/ajax/' + $patient_id + '/' + $dashboard,
		method: 'GET',
		datatype: 'json',
		success: (data) => {
			$data = data;
			choix = [];
			for (var i = 0; i < $data.choix.length; i++) {
				choix.push($data.choix[i]);
			}
			document.getElementById("date_debut_tab").value = $data.duree;
			document.getElementById("date_fin_tab").value = new Date().toISOString().substr(0, 10);;
			// choix = $choix;
			preparer();

			//creationCanvas();
		},
		error: function (jqXHR, textStatus) {}
	});
}

function preparer() {
	if (window.line != undefined) line.destroy();
	document.getElementById('div_graphes').innerHTML = "";
	for (var i = 0; i < choix.length; i++) {
		drawGraphe(choix[i]);
	}
}

function creationCanvas($element) {
	var d = document.createElement("div");
	var dbox = document.createElement("div");
	var dhead = document.createElement("div");
	var h = document.createElement("h4");
	var ht = document.createTextNode("Element: " + $element);
	var c = document.createElement("canvas");

	var dt = document.createAttribute("class");
	dt.value = "col-sm-6";
	var dtbox = document.createAttribute("class");
	dtbox.value = "panel panel-primary";
	var dthead = document.createAttribute("class");
	dthead.value = "box-header";

	var ct1 = document.createAttribute("width");
	ct1.value = "100%";
	var ct2 = document.createAttribute("height");
	ct2.value = "50%";
	var ct3 = document.createAttribute("id");
	ct3.value = $element;
	c.setAttributeNode(ct1);
	c.setAttributeNode(ct2);
	c.setAttributeNode(ct3);
	d.setAttributeNode(dt);
	dbox.setAttributeNode(dtbox);
	dhead.setAttributeNode(dthead);
	h.append(ht);
	dhead.append(h);
	dbox.append(dhead);
	dbox.append(c);
	d.append(dbox);
	var myDiv = document.getElementById('div_graphes');
	myDiv.append(d);
}

function drawGraphe($element) {
	var data1 = [];
	var dataMin = [];
	var dataMax = [];
	var min = '';
	var max = '';
	var unite1 = '';
	var dateD = document.getElementById("date_debut_tab").value;
	var dateF = document.getElementById("date_fin_tab").value;

	for (var i = 0; i < $data.bilans.length; i++) {
		if ($data.bilans[i].element == $element) {
			min = $data.bilans[i].minimum;
			max = $data.bilans[i].maximum;
			unite1 = $data.bilans[i].unite;
			if ((dateD != '' && $data.bilans[i].date_analyse >= dateD) || (dateD == '')) {
				if ((dateF != '' && $data.bilans[i].date_analyse <= dateF) || (dateF == '')) {
					var datee = $data.bilans[i].date_analyse;
					datee = datee.replace(/-/g, '/');
					data1.push({
						'x': datee,
						'y': $data.bilans[i].valeur
					});
				}
			}
		}
	}

	// teste sur la presence des données pour lancer la creation du graphe ...
	if (data1.length > 0) {
		creationCanvas($element);
		data1.sort(comp);
		dataMin.push({
			x: data1[0].x,
			y: min
		});
		dataMin.push({
			x: data1[data1.length - 1].x,
			y: min
		});
		dataMax.push({
			x: data1[0].x,
			y: max
		});
		dataMax.push({
			x: data1[data1.length - 1].x,
			y: max
		});
		getDaigram12($element, data1, unite1, dataMin, dataMax);
	}
}

function getDaigram12(selected1, data1, unite1, dataMin, dataMax) {

	var charts = {
		init: function () {
			Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
			Chart.defaults.global.defaultFontColor = '#292b2c';
			this.createChart2(selected1, data1, unite1, dataMin, dataMax);
		},

		createChart2: function (selected1, data1, unite1, dataMin, dataMax) {
			var ctx = document.getElementById(selected1).getContext("2d");
			// if(window.line != undefined) line.destroy();
			window.line = new Chart(ctx, {
				type: 'line',
				data: {
					datasets: [{
						label: selected1,
						lineTension: 0.3,
						backgroundColor: "rgba(2,117,216,0.2)",
						borderColor: "rgba(2,117,216,1)",
						pointRadius: 5,
						pointBackgroundColor: "rgba(2,117,216,1)",
						pointBorderColor: "rgba(255,255,255,0.8)",
						pointHoverRadius: 5,
						pointHoverBackgroundColor: "rgba(2,117,216,1)",
						pointHitRadius: 20,
						pointBorderWidth: 2,
						data: data1
					}, {
						label: 'Minimum',
						lineTension: 0.3,
						backgroundColor: "rgba(2,117,216,0)",
						borderColor: "rgba(255,51,102,1)",
						pointRadius: 1,
						pointBackgroundColor: "rgba(255,51,102,1)",
						pointBorderColor: "rgba(255,51,102,1)",
						pointHoverRadius: 1,
						pointHoverBackgroundColor: "rgba(255,51,102,1)",
						pointHitRadius: 1,
						pointBorderWidth: 1,
						data: dataMin
					}, {
						label: 'Maximum',
						lineTension: 0.3,
						backgroundColor: "rgba(2,117,216,0)",
						borderColor: "rgba(255,51,102,1)",
						pointRadius: 1,
						pointBackgroundColor: "rgba(255,51,102,1)",
						pointBorderColor: "rgba(255,51,102,1)",
						pointHoverRadius: 1,
						pointHoverBackgroundColor: "rgba(255,51,102,1)",
						pointHitRadius: 1,
						pointBorderWidth: 1,
						data: dataMax
					}],
				},

				options: {
					title: {
						display: true,
						fontSize: 20
					},
					scales: {
						xAxes: [{
							type: 'time',
							gridLines: {
								display: false
							},
							ticks: {
								maxTicksLimit: 7
							},
							scaleLabel: {
								display: true,
							},
						}],
						yAxes: [{
							ticks: {
								min: 0,
								maxTicksLimit: 5
							},
							gridLines: {
								color: "rgba(0, 0, 0, .125)",
								display: true,
							},
							scaleLabel: {
								display: true,
								labelString: selected1 + ' (' + unite1 + ')',
							},
						}],

					},
					legend: {
						display: true,

					}
				}
			});
		},
	};

	charts.init();
}