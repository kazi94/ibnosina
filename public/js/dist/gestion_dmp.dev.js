"use strict";

function _slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

function _iterableToArrayLimit(arr, i) {
  if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
  var _arr = [];
  var _n = true;
  var _d = false;
  var _e = undefined;

  try {
    for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

$data = '';
var select1;
var select2;
$('.show_chart').on('click', function () {
  var id = $(this).attr('id');
  var fun = {
    ajaxGetData: function ajaxGetData() {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/chart/edit/' + id,
        method: 'GET',
        datatype: 'array',
        success: function success(data) {
          $element = '';
          $data = data;
          $types = [];

          for (var j = 0; j < $data.length; j++) {
            if ($data[j].element_id != 28) {
              if (!$types.includes($data[j].element)) {
                $types.push($data[j].element);
              }

              if ($data[j].id == id) {
                $element = $data[j].element;
              }
            }
          }

          select1 = document.getElementById("TypeExamenGraphe1");
          select2 = document.getElementById("TypeExamenGraphe2");
          select1.options.length = 0;
          select2.options.length = 0;
          document.getElementById("date_debut").value = '';
          document.getElementById("date_fin").value = '';
          select2.options[select1.options.length] = new Option("", "");

          for (var i = 0; i < $types.length; i++) {
            select1.options[select1.options.length] = new Option($types[i], $types[i]);
            select2.options[select2.options.length] = new Option($types[i], $types[i]);
          }

          select1.value = $element;
          select2.value = "";
          getData();
        },
        error: function error(jqXHR, textStatus) {}
      });
    }
  };
  fun.ajaxGetData();
});

function comp(a, b) {
  return new Date(a.x).getTime() - new Date(b.x).getTime();
}

$("#TypeExamenGraphe1").on('click', function () {
  getData();
});
$("#TypeExamenGraphe2").on('click', function () {
  getData();
});
$('#date_debut').on('change', function () {
  if (document.getElementById("date_debut").value != '' && document.getElementById("date_fin").value != '') {
    if (document.getElementById("date_debut").value <= document.getElementById("date_fin").value) {
      getData();
    } else {
      alert('intervale incorrect !');
    }
  } else {
    getData();
  }
});
$('#date_fin').on('change', function () {
  if (document.getElementById("date_debut").value != '' && document.getElementById("date_fin").value != '') {
    if (document.getElementById("date_debut").value <= document.getElementById("date_fin").value) {
      getData();
    } else {
      alert('intervale incorrect !');
    }
  } else {
    getData();
  }
});

function getData() {
  var select1 = document.getElementById("TypeExamenGraphe1");
  var selected1 = select1.options[select1.selectedIndex].value; // var selected1 = "Créatinine";

  var select2 = document.getElementById("TypeExamenGraphe2");
  var selected2 = select2.options[select2.selectedIndex].value; // var selected2 = "TAA";

  var data1 = []; // var valeurs1 = [];

  var data2 = []; // var valeurs2 = [];

  var dateD = document.getElementById("date_debut").value;
  var dateF = document.getElementById("date_fin").value;
  var unite1;
  var unite2;
  var min, max;

  for (var i = 0; i < $data.length; i++) {
    if ($data[i].element == selected1) {
      unite1 = $data[i].unite;
      min = $data[i].minimum;
      max = $data[i].maximum;

      if (dateD != '' && $data[i].date_analyse >= dateD || dateD == '') {
        if (dateF != '' && $data[i].date_analyse <= dateF || dateF == '') {
          var datee = $data[i].date_analyse;
          datee = datee.replace(/-/g, '/');
          data1.push({
            'x': datee,
            'y': $data[i].valeur
          });
        }
      }
    }
  }

  data1.sort(comp);

  if (selected2 != "" && selected2 != selected1) {
    for (var i = 0; i < $data.length; i++) {
      if ($data[i].element == selected2) {
        unite2 = $data[i].unite;

        if (dateD != '' && $data[i].date_analyse >= dateD || dateD == '') {
          if (dateF != '' && $data[i].date_analyse <= dateF || dateF == '') {
            var datee = $data[i].date_analyse;
            datee = datee.replace(/-/g, '/');
            data2.push({
              x: datee,
              y: $data[i].valeur
            });
          }
        }
      }
    }

    if (data1.length > 0 && data2.length > 0) {
      data2.sort(comp);
      getDaigram2(selected1, data1, unite1, selected2, data2, unite2);
    } else {
      if (data1.length <= 0 && data2.length <= 0) {
        getDaigramEmpty();
      } else {
        if (data1.length > 0) {
          var dataMin = [];
          var dataMax = [];
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
          getDaigram1(selected1, data1, unite1, dataMin, dataMax);
        } else {
          var dataMin2 = [];
          var dataMax2 = [];
          dataMin2.push({
            x: data2[0].x,
            y: min
          });
          dataMin2.push({
            x: data2[data2.length - 1].x,
            y: min
          });
          dataMax2.push({
            x: data2[0].x,
            y: max
          });
          dataMax2.push({
            x: data2[data2.length - 1].x,
            y: max
          });
          getDaigram1(selected2, data2, unite2, dataMin2, dataMax2);
        }
      }
    }
  } else {
    if (data1.length > 0) {
      var dataMin = [];
      var dataMax = [];
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
      getDaigram1(selected1, data1, unite1, dataMin, dataMax);
    } else {
      console.log('there is no Data to show !');
      getDaigramEmpty();
    }
  }
}

function getDaigram1(selected1, data1, unite1, dataMin, dataMax) {
  var charts = {
    init: function init() {
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      this.createChart(selected1, data1, unite1, dataMin, dataMax);
    },
    createChart: function createChart(selected1, data1, unite1, dataMin, dataMax) {
      var ctx = document.getElementById("Chart").getContext('2d');
      if (window.line != undefined) line.destroy();
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
          }]
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
                display: true
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
                display: true
              },
              scaleLabel: {
                display: true,
                labelString: selected1 + ' (' + unite1 + ')'
              }
            }]
          },
          legend: {
            display: true
          }
        }
      });
    }
  };
  charts.init();
}

;

function getDaigramEmpty() {
  var charts = {
    init: function init() {
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      this.createChart();
    },
    createChart: function createChart() {
      var ctx = document.getElementById("Chart").getContext('2d');
      if (window.line != undefined) line.destroy();
      window.line = new Chart(ctx, {
        type: 'line',
        data: {
          datasets: [{
            label: '',
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
            data: []
          }]
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
                display: true
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
                display: true
              },
              scaleLabel: {
                display: true
              }
            }]
          },
          legend: {
            display: false
          }
        }
      });
    }
  };
  charts.init();
}

;

function getDaigram2(selected1, data1, unite1, selected2, data2, unite2) {
  var charts = {
    init: function init() {
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      this.createChart(selected1, data1, unite1, selected2, data2, unite2);
    },
    createChart: function createChart(selected1, data1, unite1, selected2, data2, unite2) {
      var ctx = document.getElementById("Chart").getContext('2d');
      if (window.line != undefined) line.destroy();
      window.line = new Chart(ctx, {
        type: 'line',
        data: {
          datasets: [{
            yAxisID: "a",
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
            yAxisID: "b",
            label: selected2,
            lineTension: 0.3,
            backgroundColor: "rgba(255,51,102,0.3)",
            borderColor: "rgba(255,51,102,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(255,51,102,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(255,51,102,1)",
            pointHitRadius: 20,
            pointBorderWidth: 2,
            data: data2
          }]
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
                display: true
              }
            }],
            yAxes: [{
              id: "a",
              ticks: {
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
                display: true
              },
              scaleLabel: {
                display: true,
                labelString: selected1 + ' (' + unite1 + ')'
              }
            }, {
              id: "b",
              position: 'right',
              ticks: {
                min: 0,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
                display: true
              },
              scaleLabel: {
                display: true,
                labelString: selected2 + ' (' + unite2 + ')'
              }
            }]
          },
          legend: {
            display: true
          }
        }
      });
    }
  };
  charts.init();
}

;
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
    success: function success(data) {
      $data = data;
      choix = [];

      for (var i = 0; i < $data.choix.length; i++) {
        choix.push($data.choix[i]);
      }

      document.getElementById("date_debut_tab").value = $data.duree;
      document.getElementById("date_fin_tab").value = new Date().toISOString().substr(0, 10);
      ; // choix = $choix;

      preparer(); //creationCanvas();
    },
    error: function error(jqXHR, textStatus) {}
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

      if (dateD != '' && $data.bilans[i].date_analyse >= dateD || dateD == '') {
        if (dateF != '' && $data.bilans[i].date_analyse <= dateF || dateF == '') {
          var datee = $data.bilans[i].date_analyse;
          datee = datee.replace(/-/g, '/');
          data1.push({
            'x': datee,
            'y': $data.bilans[i].valeur
          });
        }
      }
    }
  } // teste sur la presence des données pour lancer la creation du graphe ...


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
    init: function init() {
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      this.createChart2(selected1, data1, unite1, dataMin, dataMax);
    },
    createChart2: function createChart2(selected1, data1, unite1, dataMin, dataMax) {
      var ctx = document.getElementById(selected1).getContext("2d"); // if(window.line != undefined) line.destroy();

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
          }]
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
                display: true
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
                display: true
              },
              scaleLabel: {
                display: true,
                labelString: selected1 + ' (' + unite1 + ')'
              }
            }]
          },
          legend: {
            display: true
          }
        }
      });
    }
  };
  charts.init();
}

$(function () {
  //******************************^^*****^^*****************************//
  // Patient :
  // retourner les inforamtions sur le patient et l'afficher sur le modal  à modifier
  //******************************^^*****^^**************************************//
  $(".up_patient").on('click', function () {
    var patient_id = $(this).attr("data");
    var token = $("input[name='_token']").val(); // var progressElem = $(".ldBar");

    $("#modal_modifier").modal('show');
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "/api/patient/getPatient/" + patient_id,
      method: "get",
      datatype: "json",
      success: function success(data) {
        var patient = data["patient"];
        var pathologies = data["pathologies"];
        var pathologies_v1 = data["pathologies_v1"];
        var allergiess = data["allergies"]; //Map elements to select2 data struture && chech matched elements

        var paths = setMapping(pathologies, patient.pathologies);
        var ants_fam = setMapping(pathologies_v1, patient.antecedents_familliaux);
        var allergies = setMapping(allergiess, patient.allergies);
        $(".pathologies").select2({
          data: paths
        });
        $(".ants_fam").select2({
          data: ants_fam
        });
        $(".allergies").select2({
          data: allergies
        });
        $("#num_securite_sociale").val(patient.num_securite_sociale);
        $("#nom").val(patient.nom);
        $("#code_nationale").val(patient.code_national);
        $("#prenom").val(patient.prenom);
        $("#date_naissance").val(patient.date_naissance);
        $("#sexe").val(patient.sexe).is(":selected");
        $("#adresse").val(patient.adresse);
        $("#poids").val(patient.poids);
        $("#ville").val(patient.ville);
        $("#commune").val(patient.commune);
        $("#taille").val(patient.taille);
        if (patient.lastPoids != undefined) $("#poids").val(patient.lastPoids.poids);
        $("#owned_by > option").each(function () {
          if (patient.owned_by == $(this).val()) {
            $(this).attr("selected", "selected");
          }
        });
        $("#situation_familliale").val(patient.situation_familliale).is(":selected");

        if (patient.situation_familliale == "Marié(e)") {
          $("#nbre").val(patient.nbre_enfants);
          $("#nbre_enfants").show();
        }

        if (patient.travaille == "Retraité" || patient.travaille == "Universitaire") {
          $("#travaille").val(patient.travaille).is(":selected"); // $("#travaille1").val(patient.travaille1);
        } else {
          $("#travaille").val(patient.travaille).is(":selected");
          $("#travaille1").val(patient.travaille1);
          $("#autre").show();
        }

        if (patient.tabagiste == "on") {
          $("#tabac").prop("checked", true);
          $("#tabac1").val(patient.tabagiste_depuis);
          $("#tabac_stop").val(patient.tabagiste_arreter_depuis);
          $("#cigarettes").val(patient.cigarettes);
          $(".tabac").show();
        }

        if (patient.alcoolique == "on") {
          $("#alcool").prop("checked", true);
          $("#alcool1").val(patient.alcoolique_depuis);
          $(".alcool").show();
        }

        if (patient.drogue == "on") {
          $("#drogue").prop("checked", true);
          $("#drogue1").val(patient.drogue_depuis);
          $("#type_dr").val(patient.details);
          $(".drogue").show();
        }

        $("#num_tel_1").val(patient.num_tel_1);

        if (patient.p_tierce != null) {
          $("#p_tierce").val(patient.p_tierce);
          $("#p_tierce_div").show();
        }

        $("#num_tel_2").val(patient.num_tel_2);
        $("#num_dossier").val(patient.num_dossier);
        $("#photo").attr("src", "/avatar/" + patient.photo);
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    });
  });

  function setMapping(mapArray, patient) {
    return $.map(mapArray, function (obj) {
      obj.text = obj.pathologie || obj.allergie; // replace pathologie with your text
      //Parcours des mapArray du patient

      for (var index = 0; index < patient.length; index++) {
        var pathologie_p = patient[index];

        if (pathologie_p.id == obj.id) {
          obj.selected = true;
          break;
        }
      }

      return obj;
    });
  }

  $("#situation_familliale").change(function () {
    if ($(this).val() == "Marié(e)") {
      $("#nbre_enfants").show();
    } else $("#nbre_enfants").hide();
  });
  $("#sexe").on("change", function () {
    if ($(this).val() == "F") {
      $("#etat").show();
      $("#letat").show();
    } else {
      $("#etat").hide();
      $("#letat").hide();
    }
  });
  $("#travaille").change(function () {
    if ($(this).val() == "autre") {
      $("#autre").show();
    } else {
      $("#autre").hide();
      $("#autre").find("input").val("");
    }

    $("#travaille1").val($(this).val());
  });
  $("#tabac").change(function () {
    if ($(this).is(":checked")) {
      $(".tabac").show();
    } else {
      $("#tabac1").val("");
      $("#tabac_stop").val("");
      $("#paquets").val("");
      $(".tabac").hide();
    }
  });
  $("#alcool").change(function () {
    if ($(this).is(":checked")) {
      $(".alcool").show();
    } else {
      $("#alcool1").val("");
      $(".alcool").hide();
    }
  });
  $("#drogue").change(function () {
    if ($(this).is(":checked")) {
      $(".drogue").show();
    } else {
      $("#drogue1").val("");
      $(".drogue").hide();
    }
  });
  $("form").on("change", "#date_naissance", function () {
    var valeur = parseInt($("#date_naissance").val());
    var d = new Date();
    var strDate = d.getFullYear();

    if (strDate - valeur <= 18) {
      $("#p_tierce_div").show();
    } else $("#p_tierce_div").hide();
  });
});

function myFunction() {
  // Get the checkbox
  var checkBox = document.getElementById("e"); // Get the output text

  var text = document.getElementById("text"); // If the checkbox is checked, display the output text

  if (checkBox.checked == true) {
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
}

function myFunctions() {
  // Get the checkbox
  var checkBox = document.getElementById("scales"); // Get the output text

  var text = document.getElementById("labelfor");
  var table3 = document.getElementById("labelforma"); // If the checkbox is checked, display the output text

  if (checkBox.checked == true) {
    text.style.display = "block";
    table3.style.display = "none";
  } else {
    text.style.display = "none";
    table3.style.display = "block";
  }
}

function myFunctions2() {
  // Get the checkbox
  var checkBox = document.getElementById("scales2"); // Get the output text

  var text = document.getElementById("labelfor2");
  var table3 = document.getElementById("labelforma2"); // If the checkbox is checked, display the output text

  if (checkBox.checked == true) {
    text.style.display = "block";
    table3.style.display = "none";
  } else {
    text.style.display = "none";
    table3.style.display = "block";
  }
}

function myFunctions3() {
  // Get the checkbox
  var checkBox = document.getElementById("scales3"); // Get the output text

  var text = document.getElementById("labelfor3");
  var table3 = document.getElementById("labelforma3"); // If the checkbox is checked, display the output text

  if (checkBox.checked == true) {
    text.style.display = "block";
    table3.style.display = "none";
  } else {
    text.style.display = "none";
    table3.style.display = "block";
  }
}
/** Code pour les bilans autocomplete */

/**
 * All auto suggestion boxes are fucked up or badly written.
 * This is an attempt to create something that doesn't suck...
 *
 * Requires: jQuery
 *
 * Author: Nicolas Bize
 * Date: Feb. 8th 2013
 * Version: 1.3.1
 * Licence: TagSuggest is licenced under MIT licence (https://www.opensource.org/licenses/mit-license.php)
 */


(function ($) {
  "use strict";

  var TagSuggest = function TagSuggest(element, options) {
    var ms = this;
    /**
     * Initializes the TagSuggest component
     * @param defaults - see config below
     */

    var defaults = {
      /**********  CONFIGURATION PROPERTIES ************/

      /**
       * @cfg {Boolean} allowFreeEntries
       * <p>Restricts or allows the user to validate typed entries.</p>
       * Defaults to <code>true</code>.
       */
      allowFreeEntries: true,

      /**
       * @cfg {String} cls
       * <p>A custom CSS class to apply to the field's underlying element.</p>
       * Defaults to <code>''</code>.
       */
      cls: "",

      /**
       * @cfg {Array / String / Function} data
       * JSON Data source used to populate the combo box. 3 options are available here:<br/>
       * <p><u>No Data Source (default)</u><br/>
       *    When left null, the combo box will not suggest anything. It can still enable the user to enter
       *    multiple entries if allowFreeEntries is * set to true (default).</p>
       * <p><u>Static Source</u><br/>
       *    You can pass an array of JSON objects, an array of strings or even a single CSV string as the
       *    data source.<br/>For ex. data: [* {id:0,name:"Paris"}, {id: 1, name: "New York"}]<br/>
       *    You can also pass any json object with the results property containing the json array.</p>
       * <p><u>Url</u><br/>
       *     You can pass the url from which the component will fetch its JSON data.<br/>Data will be fetched
       *     using a POST ajax request that will * include the entered text as 'query' parameter. The results
       *     fetched from the server can be: <br/>
       *     - an array of JSON objects (ex: [{id:...,name:...},{...}])<br/>
       *     - a string containing an array of JSON objects ready to be parsed (ex: "[{id:...,name:...},{...}]")<br/>
       *     - a JSON object whose data will be contained in the results property
       *      (ex: {results: [{id:...,name:...},{...}]</p>
       * <p><u>Function</u><br/>
       *     You can pass a function which returns an array of JSON objects  (ex: [{id:...,name:...},{...}])<br/>
       *     The function can return the JSON data or it can use the first argument as function to handle the data.<br/>
       *     Only one (callback function or return value) is needed for the function to succeed.<br/>
       *     See the following example:<br/>
       *     function (response) { var myjson = [{name: 'test', id: 1}]; response(myjson); return myjson; }</p>
       * Defaults to <b>null</b>
       */
      data: null,

      /**
       * @cfg {Object} dataParams
       * <p>Additional parameters to the ajax call</p>
       * Defaults to <code>{}</code>
       */
      dataUrlParams: {},

      /**
       * @cfg {Boolean} disabled
       * <p>Start the component in a disabled state.</p>
       * Defaults to <code>false</code>.
       */
      disabled: false,

      /**
       * @cfg {String} displayField
       * <p>name of JSON object property displayed in the combo list</p>
       * Defaults to <code>name</code>.
       */
      displayField: "name",

      /**
       * @cfg {Boolean} editable
       * <p>Set to false if you only want mouse interaction. In that case the combo will
       * automatically expand on focus.</p>
       * Defaults to <code>true</code>.
       */
      editable: true,

      /**
       * @cfg {String} emptyText
       * <p>The default placeholder text when nothing has been entered</p>
       * Defaults to <code>'Type or click here'</code> or just <code>'Click here'</code> if not editable.
       */
      emptyText: function emptyText() {
        return cfg.editable ? "Entrer Valeur" : "Click here";
      },

      /**
       * @cfg {String} emptyTextCls
       * <p>A custom CSS class to style the empty text</p>
       * Defaults to <code>'tag-empty-text'</code>.
       */
      emptyTextCls: "tag-empty-text",

      /**
       * @cfg {Boolean} expanded
       * <p>Set starting state for combo.</p>
       * Defaults to <code>false</code>.
       */
      expanded: false,

      /**
       * @cfg {Boolean} expandOnFocus
       * <p>Automatically expands combo on focus.</p>
       * Defaults to <code>false</code>.
       */
      expandOnFocus: function expandOnFocus() {
        return cfg.editable ? false : true;
      },

      /**
       * @cfg {String} groupBy
       * <p>JSON property by which the list should be grouped</p>
       * Defaults to null
       */
      groupBy: null,

      /**
       * @cfg {Boolean} hideTrigger
       * <p>Set to true to hide the trigger on the right</p>
       * Defaults to <code>false</code>.
       */
      hideTrigger: false,

      /**
       * @cfg {Boolean} highlight
       * <p>Set to true to highlight search input within displayed suggestions</p>
       * Defaults to <code>true</code>.
       */
      highlight: true,

      /**
       * @cfg {String} id
       * <p>A custom ID for this component</p>
       * Defaults to 'tag-ctn-{n}' with n positive integer
       */
      id: function id() {
        return "tag-ctn-" + $('div[id^="tag-ctn"]').length;
      },

      /**
       * @cfg {String} infoMsgCls
       * <p>A class that is added to the info message appearing on the top-right part of the component</p>
       * Defaults to ''
       */
      infoMsgCls: "",

      /**
       * @cfg {Object} inputCfg
       * <p>Additional parameters passed out to the INPUT tag. Enables usage of AngularJS's custom tags for ex.</p>
       * Defaults to <code>{}</code>
       */
      inputCfg: {},

      /**
       * @cfg {String} invalidCls
       * <p>The class that is applied to show that the field is invalid</p>
       * Defaults to tag-ctn-invalid
       */
      invalidCls: "tag-ctn-invalid",

      /**
       * @cfg {Boolean} matchCase
       * <p>Set to true to filter data results according to case. Useless if the data is fetched remotely</p>
       * Defaults to <code>false</code>.
       */
      matchCase: false,

      /**
       * @cfg {Integer} maxDropHeight (in px)
       * <p>Once expanded, the combo's height will take as much room as the # of available results.
       *    In case there are too many results displayed, this will fix the drop down height.</p>
       * Defaults to 290 px.
       */
      maxDropHeight: 290,

      /**
       * @cfg {Integer} maxEntryLength
       * <p>Defines how long the user free entry can be. Set to null for no limit.</p>
       * Defaults to null.
       */
      maxEntryLength: null,

      /**
       * @cfg {String} maxEntryRenderer
       * <p>A function that defines the helper text when the max entry length has been surpassed.</p>
       * Defaults to <code>function(v){return 'Please reduce your entry by ' + v + ' character' + (v > 1 ? 's':'');}</code>
       */
      maxEntryRenderer: function maxEntryRenderer(v) {
        return "Please reduce your entry by " + v + " character" + (v > 1 ? "s" : "");
      },

      /**
       * @cfg {Integer} maxSuggestions
       * <p>The maximum number of results displayed in the combo drop down at once.</p>
       * Defaults to null.
       */
      maxSuggestions: null,

      /**
       * @cfg {Integer} maxSelection
       * <p>The maximum number of items the user can select if multiple selection is allowed.
       *    Set to null to remove the limit.</p>
       * Defaults to 10.
       */
      maxSelection: 10,

      /**
       * @cfg {Function} maxSelectionRenderer
       * <p>A function that defines the helper text when the max selection amount has been reached. The function has a single
       *    parameter which is the number of selected elements.</p>
       * Defaults to <code>function(v){return 'You cannot choose more than ' + v + ' item' + (v > 1 ? 's':'');}</code>
       */
      maxSelectionRenderer: function maxSelectionRenderer(v) {
        return "You cannot choose more than " + v + " item" + (v > 1 ? "s" : "");
      },

      /**
       * @cfg {String} method
       * <p>The method used by the ajax request.</p>
       * Defaults to 'POST'
       */
      method: "POST",

      /**
       * @cfg {Integer} minChars
       * <p>The minimum number of characters the user must type before the combo expands and offers suggestions.
       * Defaults to <code>0</code>.
       */
      minChars: 0,

      /**
       * @cfg {Function} minCharsRenderer
       * <p>A function that defines the helper text when not enough letters are set. The function has a single
       *    parameter which is the difference between the required amount of letters and the current one.</p>
       * Defaults to <code>function(v){return 'Please type ' + v + ' more character' + (v > 1 ? 's':'');}</code>
       */
      minCharsRenderer: function minCharsRenderer(v) {
        return "Please type " + v + " more character" + (v > 1 ? "s" : "");
      },

      /**
       * @cfg {String} name
       * <p>The name used as a form element.</p>
       * Defaults to 'null'
       */
      name: null,

      /**
       * @cfg {String} noSuggestionText
       * <p>The text displayed when there are no suggestions.</p>
       * Defaults to 'No suggestions"
       */
      noSuggestionText: "No suggestions",

      /**
       * @cfg {Boolean} preselectSingleSuggestion
       * <p>If a single suggestion comes out, it is preselected.</p>
       * Defaults to <code>true</code>.
       */
      preselectSingleSuggestion: true,

      /**
       * @cfg (function) renderer
       * <p>A function used to define how the items will be presented in the combo</p>
       * Defaults to <code>null</code>.
       */
      renderer: null,

      /**
       * @cfg {Boolean} required
       * <p>Whether or not this field should be required</p>
       * Defaults to false
       */
      required: false,

      /**
       * @cfg {Boolean} resultAsString
       * <p>Set to true to render selection as comma separated string</p>
       * Defaults to <code>false</code>.
       */
      resultAsString: false,

      /**
       * @cfg {String} resultsField
       * <p>Name of JSON object property that represents the list of suggested objets</p>
       * Defaults to <code>results</code>
       */
      resultsField: "results",

      /**
       * @cfg {String} selectionCls
       * <p>A custom CSS class to add to a selected item</p>
       * Defaults to <code>''</code>.
       */
      selectionCls: "",

      /**
       * @cfg {String} selectionPosition
       * <p>Where the selected items will be displayed. Only 'right', 'bottom' and 'inner' are valid values</p>
       * Defaults to <code>'inner'</code>, meaning the selected items will appear within the input box itself.
       */
      selectionPosition: "inner",

      /**
       * @cfg (function) selectionRenderer
       * <p>A function used to define how the items will be presented in the tag list</p>
       * Defaults to <code>null</code>.
       */
      selectionRenderer: null,

      /**
       * @cfg {Boolean} selectionStacked
       * <p>Set to true to stack the selectioned items when positioned on the bottom
       *    Requires the selectionPosition to be set to 'bottom'</p>
       * Defaults to <code>false</code>.
       */
      selectionStacked: false,

      /**
       * @cfg {String} sortDir
       * <p>Direction used for sorting. Only 'asc' and 'desc' are valid values</p>
       * Defaults to <code>'asc'</code>.
       */
      sortDir: "asc",

      /**
       * @cfg {String} sortOrder
       * <p>name of JSON object property for local result sorting.
       *    Leave null if you do not wish the results to be ordered or if they are already ordered remotely.</p>
       *
       * Defaults to <code>null</code>.
       */
      sortOrder: null,

      /**
       * @cfg {Boolean} strictSuggest
       * <p>If set to true, suggestions will have to start by user input (and not simply contain it as a substring)</p>
       * Defaults to <code>false</code>.
       */
      strictSuggest: false,

      /**
       * @cfg {String} style
       * <p>Custom style added to the component container.</p>
       *
       * Defaults to <code>''</code>.
       */
      style: "",

      /**
       * @cfg {Boolean} toggleOnClick
       * <p>If set to true, the combo will expand / collapse when clicked upon</p>
       * Defaults to <code>false</code>.
       */
      toggleOnClick: false,

      /**
       * @cfg {Integer} typeDelay
       * <p>Amount (in ms) between keyboard registers.</p>
       *
       * Defaults to <code>400</code>
       */
      typeDelay: 400,

      /**
       * @cfg {Boolean} useTabKey
       * <p>If set to true, tab won't blur the component but will be registered as the ENTER key</p>
       * Defaults to <code>false</code>.
       */
      useTabKey: false,

      /**
       * @cfg {Boolean} useCommaKey
       * <p>If set to true, using comma will validate the user's choice</p>
       * Defaults to <code>true</code>.
       */
      useCommaKey: true,

      /**
       * @cfg {Boolean} useZebraStyle
       * <p>Determines whether or not the results will be displayed with a zebra table style</p>
       * Defaults to <code>true</code>.
       */
      useZebraStyle: true,

      /**
       * @cfg {String/Object/Array} value
       * <p>initial value for the field</p>
       * Defaults to <code>null</code>.
       */
      value: null,

      /**
       * @cfg {String} valueField
       * <p>name of JSON object property that represents its underlying value</p>
       * Defaults to <code>id</code>.
       */
      valueField: "id",

      /**
       * @cfg {Integer} width (in px)
       * <p>Width of the component</p>
       * Defaults to underlying element width.
       */
      width: function width() {
        return $(this).width();
      }
    };
    var conf = $.extend({}, options);
    var cfg = $.extend(true, {}, defaults, conf); // some init stuff

    if ($.isFunction(cfg.emptyText)) {
      cfg.emptyText = cfg.emptyText.call(this);
    }

    if ($.isFunction(cfg.expandOnFocus)) {
      cfg.expandOnFocus = cfg.expandOnFocus.call(this);
    }

    if ($.isFunction(cfg.id)) {
      cfg.id = cfg.id.call(this);
    }
    /**********  PUBLIC METHODS ************/

    /**
     * Add one or multiple json items to the current selection
     * @param items - json object or array of json objects
     * @param isSilent - (optional) set to true to suppress 'selectionchange' event from being triggered
     */


    this.addToSelection = function (items, isSilent) {
      if (!cfg.maxSelection || _selection.length < cfg.maxSelection) {
        if (!$.isArray(items)) {
          items = [items];
        }

        var valuechanged = false;
        $.each(items, function (index, json) {
          if ($.inArray(json[cfg.valueField], ms.getValue()) === -1) {
            _selection.push(json);

            valuechanged = true;
          }
        });

        if (valuechanged === true) {
          self._renderSelection();

          this.empty();

          if (isSilent !== true) {
            $(this).trigger("selectionchange", [this, this.getSelectedItems()]);
          }
        }
      }
    };
    /**
     * Clears the current selection
     * @param isSilent - (optional) set to true to suppress 'selectionchange' event from being triggered
     */


    this.clear = function (isSilent) {
      this.removeFromSelection(_selection.slice(0), isSilent); // clone array to avoid concurrency issues
    };
    /**
     * Collapse the drop down part of the combo
     */


    this.collapse = function () {
      if (cfg.expanded === true) {
        this.combobox.detach();
        cfg.expanded = false;
        $(this).trigger("collapse", [this]);
      }
    };
    /**
     * Set the component in a disabled state.
     */


    this.disable = function () {
      this.container.addClass("tag-ctn-disabled");
      cfg.disabled = true;
      ms.input.attr("disabled", true);
    };
    /**
     * Empties out the combo user text
     */


    this.empty = function () {
      this.input.removeClass(cfg.emptyTextCls);
      this.input.val("");
    };
    /**
     * Set the component in a enable state.
     */


    this.enable = function () {
      this.container.removeClass("tag-ctn-disabled");
      cfg.disabled = false;
      ms.input.attr("disabled", false);
    };
    /**
     * Expand the drop drown part of the combo.
     */


    this.expand = function () {
      if (!cfg.expanded && (this.input.val().length >= cfg.minChars || this.combobox.children().size() > 0)) {
        this.combobox.appendTo(this.container);

        self._processSuggestions();

        cfg.expanded = true;
        $(this).trigger("expand", [this]);
      }
    };
    /**
     * Retrieve component enabled status
     */


    this.isDisabled = function () {
      return cfg.disabled;
    };
    /**
     * Checks whether the field is valid or not
     * @return {boolean}
     */


    this.isValid = function () {
      return cfg.required === false || _selection.length > 0;
    };
    /**
     * Gets the data params for current ajax request
     */


    this.getDataUrlParams = function () {
      return cfg.dataUrlParams;
    };
    /**
     * Gets the name given to the form input
     */


    this.getName = function () {
      return cfg.name;
    };
    /**
     * Retrieve an array of selected json objects
     * @return {Array}
     */


    this.getSelectedItems = function () {
      return _selection;
    };
    /**
     * Retrieve the current text entered by the user
     */


    this.getRawValue = function () {
      return ms.input.val() !== cfg.emptyText ? ms.input.val() : "";
    };
    /**
     * Retrieve an array of selected values
     */


    this.getValue = function () {
      return $.map(_selection, function (o) {
        return o[cfg.valueField];
      });
    };
    /**
     * Remove one or multiples json items from the current selection
     * @param items - json object or array of json objects
     * @param isSilent - (optional) set to true to suppress 'selectionchange' event from being triggered
     */


    this.removeFromSelection = function (items, isSilent) {
      if (!$.isArray(items)) {
        items = [items];
      }

      var valuechanged = false;
      $.each(items, function (index, json) {
        var i = $.inArray(json[cfg.valueField], ms.getValue());

        if (i > -1) {
          _selection.splice(i, 1);

          valuechanged = true;
        }
      });

      if (valuechanged === true) {
        self._renderSelection();

        if (isSilent !== true) {
          $(this).trigger("selectionchange", [this, this.getSelectedItems()]);
        }

        if (cfg.expandOnFocus) {
          ms.expand();
        }

        if (cfg.expanded) {
          self._processSuggestions();
        }
      }
    };
    /**
     * Set up some combo data after it has been rendered
     * @param data
     */


    this.setData = function (data) {
      cfg.data = data;

      self._processSuggestions();
    };
    /**
     * Sets the name for the input field so it can be fetched in the form
     * @param name
     */


    this.setName = function (name) {
      cfg.name = name;

      if (ms._valueContainer) {
        ms._valueContainer.name = name;
      }
    };
    /**
     * Sets a value for the combo box. Value must be a value or an array of value with data type matching valueField one.
     * @param data
     */


    this.setValue = function (data) {
      var values = data,
          items = [];

      if (!$.isArray(data)) {
        if (typeof data === "string") {
          if (data.indexOf("[") > -1) {
            values = eval(data);
          } else if (data.indexOf(",") > -1) {
            values = data.split(",");
          }
        } else {
          values = [data];
        }
      }

      $.each(_cbData, function (index, obj) {
        if ($.inArray(obj[cfg.valueField], values) > -1) {
          items.push(obj);
        }
      });

      if (items.length > 0) {
        this.addToSelection(items);
      }
    };
    /**
     * Sets data params for subsequent ajax requests
     * @param params
     */


    this.setDataUrlParams = function (params) {
      cfg.dataUrlParams = $.extend({}, params);
    };
    /**********  PRIVATE ************/


    var _selection = [],
        // selected objects
    _comboItemHeight = 0,
        // height for each combo item.
    _timer,
        _hasFocus = false,
        _groups = null,
        _cbData = [],
        _ctrlDown = false;

    var self = {
      /**
       * Empties the result container and refills it with the array of json results in input
       * @private
       */
      _displaySuggestions: function _displaySuggestions(data) {
        ms.combobox.empty();
        var resHeight = 0,
            // total height taken by displayed results.
        nbGroups = 0;

        if (_groups === null) {
          self._renderComboItems(data);

          resHeight = _comboItemHeight * data.length;
        } else {
          for (var grpName in _groups) {
            nbGroups += 1;
            $("<div/>", {
              "class": "tag-res-group",
              html: grpName
            }).appendTo(ms.combobox);

            self._renderComboItems(_groups[grpName].items, true);
          }

          resHeight = _comboItemHeight * (data.length + nbGroups);
        }

        if (resHeight < ms.combobox.height() || resHeight <= cfg.maxDropHeight) {
          ms.combobox.height(resHeight);
        } else if (resHeight >= ms.combobox.height() && resHeight > cfg.maxDropHeight) {
          ms.combobox.height(cfg.maxDropHeight);
        }

        if (data.length === 1 && cfg.preselectSingleSuggestion === true) {
          ms.combobox.children().filter(":last").addClass("tag-res-item-active");
        }

        if (data.length === 0 && ms.getRawValue() !== "") {
          self._updateHelper(cfg.noSuggestionText);

          ms.collapse();
        }
      },

      /**
       * Returns an array of json objects from an array of strings.
       * @private
       */
      _getEntriesFromStringArray: function _getEntriesFromStringArray(data) {
        var json = [];
        $.each(data, function (index, s) {
          var entry = {};
          entry[cfg.displayField] = entry[cfg.valueField] = $.trim(s);
          json.push(entry);
        });
        return json;
      },

      /**
       * Replaces html with highlighted html according to case
       * @param html
       * @private
       */
      _highlightSuggestion: function _highlightSuggestion(html) {
        var q = ms.input.val() !== cfg.emptyText ? ms.input.val() : "";

        if (q.length === 0) {
          return html; // nothing entered as input
        }

        if (cfg.matchCase === true) {
          html = html.replace(new RegExp("(" + q + ")(?!([^<]+)?>)", "g"), "<em>$1</em>");
        } else {
          html = html.replace(new RegExp("(" + q + ")(?!([^<]+)?>)", "gi"), "<em>$1</em>");
        }

        return html;
      },

      /**
       * Moves the selected cursor amongst the list item
       * @param dir - 'up' or 'down'
       * @private
       */
      _moveSelectedRow: function _moveSelectedRow(dir) {
        if (!cfg.expanded) {
          ms.expand();
        }

        var list, start, active, scrollPos;
        list = ms.combobox.find(".tag-res-item");

        if (dir === "down") {
          start = list.eq(0);
        } else {
          start = list.filter(":last");
        }

        active = ms.combobox.find(".tag-res-item-active:first");

        if (active.length > 0) {
          if (dir === "down") {
            start = active.nextAll(".tag-res-item").first();

            if (start.length === 0) {
              start = list.eq(0);
            }

            scrollPos = ms.combobox.scrollTop();
            ms.combobox.scrollTop(0);

            if (start[0].offsetTop + start.outerHeight() > ms.combobox.height()) {
              ms.combobox.scrollTop(scrollPos + _comboItemHeight);
            }
          } else {
            start = active.prevAll(".tag-res-item").first();

            if (start.length === 0) {
              start = list.filter(":last");
              ms.combobox.scrollTop(_comboItemHeight * list.length);
            }

            if (start[0].offsetTop < ms.combobox.scrollTop()) {
              ms.combobox.scrollTop(ms.combobox.scrollTop() - _comboItemHeight);
            }
          }
        }

        list.removeClass("tag-res-item-active");
        start.addClass("tag-res-item-active");
      },

      /**
       * According to given data and query, sort and add suggestions in their container
       * @private
       */
      _processSuggestions: function _processSuggestions(source) {
        var json = null,
            data = source || cfg.data;

        if (data !== null) {
          if (typeof data === "function") {
            data = data.call(ms);
          }

          if (typeof data === "string" && data.indexOf(",") < 0) {
            // get results from ajax
            $(ms).trigger("beforeload", [ms]);
            var params = $.extend({
              query: ms.input.val()
            }, cfg.dataUrlParams);
            $.ajax({
              type: cfg.method,
              url: data,
              data: params,
              success: function success(asyncData) {
                json = typeof asyncData === "string" ? JSON.parse(asyncData) : asyncData;

                self._processSuggestions(json);

                $(ms).trigger("load", [ms, json]);
              },
              error: function error() {
                throw "Could not reach server";
              }
            });
            return;
          } else if (typeof data === "string" && data.indexOf(",") > -1) {
            // results from csv string
            _cbData = self._getEntriesFromStringArray(data.split(","));
          } else {
            // results from local array
            if (data.length > 0 && typeof data[0] === "string") {
              // results from array of strings
              _cbData = self._getEntriesFromStringArray(data);
            } else {
              // regular json array or json object with results property
              _cbData = data[cfg.resultsField] || data;
            }
          }

          self._displaySuggestions(self._sortAndTrim(_cbData));
        }
      },

      /**
       * Render the component to the given input DOM element
       * @private
       */
      _render: function _render(el) {
        $(ms).trigger("beforerender", [ms]);
        var w = $.isFunction(cfg.width) ? cfg.width.call(el) : cfg.width; // holds the main div, will relay the focus events to the contained input element.

        ms.container = $("<div/>", {
          id: cfg.id,
          "class": "tag-ctn " + cfg.cls + (cfg.disabled === true ? " tag-ctn-disabled" : "") + (cfg.editable === true ? "" : " tag-ctn-readonly"),
          style: cfg.style
        }).width(w);
        ms.container.focus($.proxy(handlers._onFocus, this));
        ms.container.blur($.proxy(handlers._onBlur, this));
        ms.container.keydown($.proxy(handlers._onKeyDown, this));
        ms.container.keyup($.proxy(handlers._onKeyUp, this)); // holds the input field

        ms.input = $("<input/>", $.extend({
          id: "tag-input-" + $('input[id^="tag-input"]').length,
          type: "text",
          "class": cfg.emptyTextCls + (cfg.editable === true ? "" : " tag-input-readonly"),
          value: cfg.emptyText,
          readonly: !cfg.editable,
          disabled: cfg.disabled
        }, cfg.inputCfg)).width(w - (cfg.hideTrigger ? 16 : 42));
        ms.input.focus($.proxy(handlers._onInputFocus, this));
        ms.input.click($.proxy(handlers._onInputClick, this)); // holds the trigger on the right side

        if (cfg.hideTrigger === false) {
          ms.trigger = $("<div/>", {
            id: "tag-trigger-" + $('div[id^="tag-trigger"]').length,
            "class": "tag-trigger",
            html: '<div class="tag-trigger-ico"></div>'
          });
          ms.trigger.click($.proxy(handlers._onTriggerClick, this));
          ms.container.append(ms.trigger);
        } // holds the suggestions. will always be placed on focus


        ms.combobox = $("<div/>", {
          id: "tag-res-ctn-" + $('div[id^="tag-res-ctn"]').length,
          "class": "tag-res-ctn "
        }).width(w).height(cfg.maxDropHeight); // bind the onclick and mouseover using delegated events (needs jQuery >= 1.7)

        ms.combobox.on("click", "div.tag-res-item", $.proxy(handlers._onComboItemSelected, this));
        ms.combobox.on("mouseover", "div.tag-res-item", $.proxy(handlers._onComboItemMouseOver, this));
        ms.selectionContainer = $("<div/>", {
          id: "tag-sel-ctn-" + $('div[id^="tag-sel-ctn"]').length,
          "class": "tag-sel-ctn"
        });
        ms.selectionContainer.click($.proxy(handlers._onFocus, this));

        if (cfg.selectionPosition === "inner") {
          ms.selectionContainer.append(ms.input);
        } else {
          ms.container.append(ms.input);
        }

        ms.helper = $("<div/>", {
          "class": "tag-helper " + cfg.infoMsgCls
        });

        self._updateHelper();

        ms.container.append(ms.helper); // Render the whole thing

        $(el).replaceWith(ms.container);

        switch (cfg.selectionPosition) {
          case "bottom":
            ms.selectionContainer.insertAfter(ms.container);

            if (cfg.selectionStacked === true) {
              ms.selectionContainer.width(ms.container.width());
              ms.selectionContainer.addClass("tag-stacked");
            }

            break;

          case "right":
            ms.selectionContainer.insertAfter(ms.container);
            ms.container.css("float", "left");
            break;

          default:
            ms.container.append(ms.selectionContainer);
            break;
        }

        self._processSuggestions();

        if (cfg.value !== null) {
          ms.setValue(cfg.value);

          self._renderSelection();
        }

        $(ms).trigger("afterrender", [ms]);
        $("body").click(function (e) {
          if (ms.container.hasClass("tag-ctn-bootstrap-focus") && ms.container.has(e.target).length === 0 && e.target.className.indexOf("tag-res-item") < 0 && e.target.className.indexOf("tag-close-btn") < 0 && ms.container[0] !== e.target) {
            handlers._onBlur();
          }
        });

        if (cfg.expanded === true) {
          cfg.expanded = false;
          ms.expand();
        }
      },
      _renderComboItems: function _renderComboItems(items, isGrouped) {
        var ref = this,
            html = "";
        $.each(items, function (index, value) {
          var displayed = cfg.renderer !== null ? cfg.renderer.call(ref, value) : value[cfg.displayField];
          var resultItemEl = $("<div/>", {
            "class": "tag-res-item " + (isGrouped ? "tag-res-item-grouped " : "") + (index % 2 === 1 && cfg.useZebraStyle === true ? "tag-res-odd" : ""),
            html: cfg.highlight === true ? self._highlightSuggestion(displayed) : displayed,
            "data-json": JSON.stringify(value)
          });
          resultItemEl.click($.proxy(handlers._onComboItemSelected, ref));
          resultItemEl.mouseover($.proxy(handlers._onComboItemMouseOver, ref));
          html += $("<div/>").append(resultItemEl).html();
        });
        ms.combobox.append(html);
        _comboItemHeight = ms.combobox.find(".tag-res-item:first").outerHeight();
      },

      /**
       * Renders the selected items into their container.
       * @private
       */
      _renderSelection: function _renderSelection() {
        var ref = this,
            w = 0,
            inputOffset = 0,
            items = [],
            asText = cfg.resultAsString === true && !_hasFocus;
        ms.selectionContainer.find(".tag-sel-item").remove();

        if (ms._valueContainer !== undefined) {
          ms._valueContainer.remove();
        }

        $.each(_selection, function (index, value) {
          var selectedItemEl,
              delItemEl,
              selectedItemHtml = cfg.selectionRenderer !== null ? cfg.selectionRenderer.call(ref, value) : value[cfg.displayField]; // tag representing selected value

          if (asText === true) {
            selectedItemEl = $("<div/>", {
              "class": "tag-sel-item tag-sel-text " + cfg.selectionCls,
              html: selectedItemHtml + (index === _selection.length - 1 ? "" : ",")
            }).data("json", value);
          } else {
            selectedItemEl = $("<div/>", {
              "class": "tag-sel-item " + cfg.selectionCls,
              html: selectedItemHtml
            }).data("json", value);

            if (cfg.disabled === false) {
              // small cross img
              delItemEl = $("<span/>", {
                "class": "tag-close-btn"
              }).data("json", value).appendTo(selectedItemEl);
              delItemEl.click($.proxy(handlers._onTagTriggerClick, ref));
            }
          }

          items.push(selectedItemEl);
        });
        ms.selectionContainer.prepend(items);
        ms._valueContainer = $("<input/>", {
          type: "hidden",
          name: cfg.name,
          value: JSON.stringify(ms.getValue())
        });

        ms._valueContainer.appendTo(ms.selectionContainer);

        if (cfg.selectionPosition === "inner") {
          ms.input.width(0);
          inputOffset = ms.input.offset().left - ms.selectionContainer.offset().left;
          w = ms.container.width() - inputOffset - 42;
          ms.input.width(w);
          ms.container.height(ms.selectionContainer.height());
        }

        if (_selection.length === cfg.maxSelection) {
          self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
        } else {
          ms.helper.hide();
        }
      },

      /**
       * Select an item either through keyboard or mouse
       * @param item
       * @private
       */
      _selectItem: function _selectItem(item) {
        if (cfg.maxSelection === 1) {
          _selection = [];
        }

        ms.addToSelection(item.data("json"));
        item.removeClass("tag-res-item-active");

        if (cfg.expandOnFocus === false || _selection.length === cfg.maxSelection) {
          ms.collapse();
        }

        if (!_hasFocus) {
          ms.input.focus();
        } else if (_hasFocus && (cfg.expandOnFocus || _ctrlDown)) {
          self._processSuggestions();

          if (_ctrlDown) {
            ms.expand();
          }
        }
      },

      /**
       * Sorts the results and cut them down to max # of displayed results at once
       * @private
       */
      _sortAndTrim: function _sortAndTrim(data) {
        var q = ms.getRawValue(),
            filtered = [],
            newSuggestions = [],
            selectedValues = ms.getValue(); // filter the data according to given input

        if (q.length > 0) {
          $.each(data, function (index, obj) {
            var name = obj[cfg.displayField];

            if (cfg.matchCase === true && name.indexOf(q) > -1 || cfg.matchCase === false && name.toLowerCase().indexOf(q.toLowerCase()) > -1) {
              if (cfg.strictSuggest === false || name.toLowerCase().indexOf(q.toLowerCase()) === 0) {
                filtered.push(obj);
              }
            }
          });
        } else {
          filtered = data;
        } // take out the ones that have already been selected


        $.each(filtered, function (index, obj) {
          if ($.inArray(obj[cfg.valueField], selectedValues) === -1) {
            newSuggestions.push(obj);
          }
        }); // sort the data

        if (cfg.sortOrder !== null) {
          newSuggestions.sort(function (a, b) {
            if (a[cfg.sortOrder] < b[cfg.sortOrder]) {
              return cfg.sortDir === "asc" ? -1 : 1;
            }

            if (a[cfg.sortOrder] > b[cfg.sortOrder]) {
              return cfg.sortDir === "asc" ? 1 : -1;
            }

            return 0;
          });
        } // trim it down


        if (cfg.maxSuggestions && cfg.maxSuggestions > 0) {
          newSuggestions = newSuggestions.slice(0, cfg.maxSuggestions);
        } // build groups


        if (cfg.groupBy !== null) {
          _groups = {};
          $.each(newSuggestions, function (index, value) {
            if (_groups[value[cfg.groupBy]] === undefined) {
              _groups[value[cfg.groupBy]] = {
                title: value[cfg.groupBy],
                items: [value]
              };
            } else {
              _groups[value[cfg.groupBy]].items.push(value);
            }
          });
        }

        return newSuggestions;
      },

      /**
       * Update the helper text
       * @private
       */
      _updateHelper: function _updateHelper(html) {
        ms.helper.html(html);

        if (!ms.helper.is(":visible")) {
          ms.helper.fadeIn();
        }
      }
    };
    var handlers = {
      /**
       * Triggered when blurring out of the component
       * @private
       */
      _onBlur: function _onBlur() {
        ms.container.removeClass("tag-ctn-bootstrap-focus");
        ms.collapse();
        _hasFocus = false;

        if (ms.getRawValue() !== "" && cfg.allowFreeEntries === true) {
          var obj = {};
          obj[cfg.displayField] = obj[cfg.valueField] = ms.getRawValue();
          ms.addToSelection(obj);
        }

        self._renderSelection();

        if (ms.isValid() === false) {
          ms.container.addClass("tag-ctn-invalid");
        }

        if (ms.input.val() === "" && _selection.length === 0) {
          ms.input.addClass(cfg.emptyTextCls);
          ms.input.val(cfg.emptyText);
        } else if (ms.input.val() !== "" && cfg.allowFreeEntries === false) {
          ms.empty();

          self._updateHelper("");
        }

        if (ms.input.is(":focus")) {
          $(ms).trigger("blur", [ms]);
        }
      },

      /**
       * Triggered when hovering an element in the combo
       * @param e
       * @private
       */
      _onComboItemMouseOver: function _onComboItemMouseOver(e) {
        ms.combobox.children().removeClass("tag-res-item-active");
        $(e.currentTarget).addClass("tag-res-item-active");
      },

      /**
       * Triggered when an item is chosen from the list
       * @param e
       * @private
       */
      _onComboItemSelected: function _onComboItemSelected(e) {
        self._selectItem($(e.currentTarget));
      },

      /**
       * Triggered when focusing on the container div. Will focus on the input field instead.
       * @private
       */
      _onFocus: function _onFocus() {
        ms.input.focus();
      },

      /**
       * Triggered when clicking on the input text field
       * @private
       */
      _onInputClick: function _onInputClick() {
        if (ms.isDisabled() === false && _hasFocus) {
          if (cfg.toggleOnClick === true) {
            if (cfg.expanded) {
              ms.collapse();
            } else {
              ms.expand();
            }
          }
        }
      },

      /**
       * Triggered when focusing on the input text field.
       * @private
       */
      _onInputFocus: function _onInputFocus() {
        if (ms.isDisabled() === false && !_hasFocus) {
          _hasFocus = true;
          ms.container.addClass("tag-ctn-bootstrap-focus");
          ms.container.removeClass(cfg.invalidCls);

          if (ms.input.val() === cfg.emptyText) {
            ms.empty();
          }

          var curLength = ms.getRawValue().length;

          if (cfg.expandOnFocus === true) {
            ms.expand();
          }

          if (_selection.length === cfg.maxSelection) {
            self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
          } else if (curLength < cfg.minChars) {
            self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - curLength));
          }

          self._renderSelection();

          $(ms).trigger("focus", [ms]);
        }
      },

      /**
       * Triggered when the user presses a key while the component has focus
       * This is where we want to handle all keys that don't require the user input field
       * since it hasn't registered the key hit yet
       * @param e keyEvent
       * @private
       */
      _onKeyDown: function _onKeyDown(e) {
        // check how tab should be handled
        var active = ms.combobox.find(".tag-res-item-active:first"),
            freeInput = ms.input.val() !== cfg.emptyText ? ms.input.val() : "";
        $(ms).trigger("keydown", [ms, e]);

        if (e.keyCode === 9 && (cfg.useTabKey === false || cfg.useTabKey === true && active.length === 0 && ms.input.val().length === 0)) {
          handlers._onBlur();

          return;
        }

        switch (e.keyCode) {
          case 8:
            //backspace
            if (freeInput.length === 0 && ms.getSelectedItems().length > 0 && cfg.selectionPosition === "inner") {
              _selection.pop();

              self._renderSelection();

              $(ms).trigger("selectionchange", [ms, ms.getSelectedItems()]);
              ms.input.focus();
              e.preventDefault();
            }

            break;

          case 9: // tab

          case 188: // esc

          case 13:
            // enter
            e.preventDefault();
            break;

          case 17:
            // ctrl
            _ctrlDown = true;
            break;

          case 40:
            // down
            e.preventDefault();

            self._moveSelectedRow("down");

            break;

          case 38:
            // up
            e.preventDefault();

            self._moveSelectedRow("up");

            break;

          default:
            if (_selection.length === cfg.maxSelection) {
              e.preventDefault();
            }

            break;
        }
      },

      /**
       * Triggered when a key is released while the component has focus
       * @param e
       * @private
       */
      _onKeyUp: function _onKeyUp(e) {
        var freeInput = ms.getRawValue(),
            inputValid = $.trim(ms.input.val()).length > 0 && ms.input.val() !== cfg.emptyText && (!cfg.maxEntryLength || $.trim(ms.input.val()).length <= cfg.maxEntryLength),
            selected,
            obj = {};
        $(ms).trigger("keyup", [ms, e]);
        clearTimeout(_timer); // collapse if escape, but keep focus.

        if (e.keyCode === 27 && cfg.expanded) {
          ms.combobox.height(0);
        } // ignore a bunch of keys


        if (e.keyCode === 9 && cfg.useTabKey === false || e.keyCode > 13 && e.keyCode < 32) {
          if (e.keyCode === 17) {
            _ctrlDown = false;
          }

          return;
        }

        switch (e.keyCode) {
          case 40:
          case 38:
            // up, down
            e.preventDefault();
            break;

          case 13:
          case 9:
          case 188:
            // enter, tab, comma
            if (e.keyCode !== 188 || cfg.useCommaKey === true) {
              e.preventDefault();

              if (cfg.expanded === true) {
                // if a selection is performed, select it and reset field
                selected = ms.combobox.find(".tag-res-item-active:first");

                if (selected.length > 0) {
                  self._selectItem(selected);

                  return;
                }
              } // if no selection or if freetext entered and free entries allowed, add new obj to selection


              if (inputValid === true && cfg.allowFreeEntries === true) {
                obj[cfg.displayField] = obj[cfg.valueField] = freeInput;
                ms.addToSelection(obj);
                ms.collapse(); // reset combo suggestions

                ms.input.focus();
              }

              break;
            }

          default:
            if (_selection.length === cfg.maxSelection) {
              self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
            } else {
              if (freeInput.length < cfg.minChars) {
                self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - freeInput.length));

                if (cfg.expanded === true) {
                  ms.collapse();
                }
              } else if (cfg.maxEntryLength && freeInput.length > cfg.maxEntryLength) {
                self._updateHelper(cfg.maxEntryRenderer.call(this, freeInput.length - cfg.maxEntryLength));

                if (cfg.expanded === true) {
                  ms.collapse();
                }
              } else {
                ms.helper.hide();

                if (cfg.minChars <= freeInput.length) {
                  _timer = setTimeout(function () {
                    if (cfg.expanded === true) {
                      self._processSuggestions();
                    } else {
                      ms.expand();
                    }
                  }, cfg.typeDelay);
                }
              }
            }

            break;
        }
      },

      /**
       * Triggered when clicking upon cross for deletion
       * @param e
       * @private
       */
      _onTagTriggerClick: function _onTagTriggerClick(e) {
        ms.removeFromSelection($(e.currentTarget).data("json"));
      },

      /**
       * Triggered when clicking on the small trigger in the right
       * @private
       */
      _onTriggerClick: function _onTriggerClick() {
        if (ms.isDisabled() === false && !(cfg.expandOnFocus === true && _selection.length === cfg.maxSelection)) {
          $(ms).trigger("triggerclick", [ms]);

          if (cfg.expanded === true) {
            ms.collapse();
          } else {
            var curLength = ms.getRawValue().length;

            if (curLength >= cfg.minChars) {
              ms.input.focus();
              ms.expand();
            } else {
              self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - curLength));
            }
          }
        }
      }
    }; // startup point

    if (element !== null) {
      self._render(element);
    }
  };

  $.fn.tagSuggest = function (options) {
    var obj = $(this);

    if (obj.length == 1 && obj.data("tagSuggest")) {
      return obj.data("tagSuggest");
    }

    obj.each(function (i) {
      // assume $(this) is an element
      var cntr = $(this); // Return early if this element already has a plugin instance

      if (cntr.data("tagSuggest")) {
        return;
      }

      if (this.nodeName.toLowerCase() === "select") {
        // rendering from select
        options.data = [];
        options.value = [];
        $.each(this.children, function (index, child) {
          if (child.nodeName && child.nodeName.toLowerCase() === "option") {
            options.data.push({
              id: child.value,
              name: child.text
            });

            if (child.selected) {
              options.value.push(child.value);
            }
          }
        });
      }

      var def = {}; // set values from DOM container element

      $.each(this.attributes, function (i, att) {
        def[att.name] = att.value;
      });
      var field = new TagSuggest(this, $.extend(options, def));
      cntr.data("tagSuggest", field);
      field.container.data("tagSuggest", field);
    });

    if (obj.length == 1) {
      return obj.data("tagSuggest");
    }

    return obj;
  }; //renseigner les bilans

})(jQuery);

$(document).ready(function () {
  var jsonData = [];
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: "/element/all",
    method: "GET",
    datatype: "array",
    success: function success(data) {
      var JSONObject = JSON.parse(JSON.stringify(data));

      for (var i = 0; i < JSONObject[0].length; i++) {
        jsonData.push({
          id: JSONObject[0][i].id,
          name: JSONObject[0][i].element
        });
      }

      var ms1 = $("#ms1").tagSuggest({
        data: jsonData,
        sortOrder: "name",
        maxDropHeight: 200,
        name: "ms1"
      });
    },
    error: function error(jqXHR, textStatus) {}
  });
});
$(document).ready(function () {
  var jsonData = [];
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: "/act/all",
    method: "GET",
    datatype: "array",
    success: function success(data) {
      var JSONObject = JSON.parse(JSON.stringify(data));

      for (var i = 0; i < JSONObject[0].length; i++) {
        jsonData.push({
          id: JSONObject[0][i].id,
          name: JSONObject[0][i].nom
        });
      }

      var ms2 = $("#ms2").tagSuggest({
        data: jsonData,
        sortOrder: "name",
        maxDropHeight: 200,
        name: "ms2"
      });
    },
    error: function error(jqXHR, textStatus) {}
  });
}); //******************************^^*****^^**************************************// 
// Analyse biologique : 													   //
// Ajouter des lignes bilans 												   //
// faire une demande dexamens 												   //
// Affichage dynamique des élements et des unité via AJAX 					   //
// Affectation des champs pour la modification 								   //
// fonction d'affichage des fichiers médias 								   //
// Suppression d'une ligne 													   //
// Ajout auto des dates d'analyse et du nom du laboratoire 				       //
//******************************^^*****^^**************************************// 

jQuery(function () {
  /*
   * Listen to change of type bilan
   * 
   */
  var selected = [];
  $("#modal_demande_examen").on('change', 'select#type_bilan', function () {
    //if ($('#modal_demande_examen #bilan').contents().length == 0) {
    var bilan = $(this).val();
    var patient_id = $("input[name='patient_id']").val();
    if (bilan != "") $.ajax({
      type: "get",
      url: "/admin/element/get-elements/" + bilan + "&&" + patient_id,
      success: function success(response) {
        var $rows = '';

        if (selected.indexOf(bilan) == -1) {
          selected.push(bilan);
          response.forEach(function (element, key) {
            if (key % 2 == 0) {
              $rows = "\n\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t\t\t\t<input type='hidden' name='elements_id[]' value='".concat(response[key].id, "'>\n\t\t\t\t\t\t\t\t\t\t\t<input type='hidden' name='checkedElements[]' value='0'>\n\t\t\t\t\t\t\t\t\t\t\t<input type='checkbox' class=\"flat-red\" '/>\n\t\t\t\t\t\t\t\t\t\t\t").concat(response[key].element, "\n\t\t\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t\t\t\t<input type='hidden' name='elements_id[]' value='").concat(response[key++].id, "'>\n\t\t\t\t\t\t\t\t\t\t\t<input type='hidden' name='checkedElements[]' value='0'>\n\t\t\t\t\t\t\t\t\t\t\t<input type='checkbox' class=\"flat-red\" '/>\n\t\t\t\t\t\t\t\t\t\t\t").concat(response[key++].element, "\n\t\t\t\t\t\t\t\t\t\t</td>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t");
              $("#elements tbody").append($rows);
              $('input[type="checkbox"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-red'
              });
            }
          });
        }
      }
    }); //}
  });
  /*
   * handler when click to 'remplir' btn
   * get the elements of the requested exam to do
   * display the elements to fields values input if bio
   * or display input file to upload radio img
   */

  $(".remplir").on('click', function () {
    var $id = $(this).data('id');
    $('#modal_biologique form').attr('action', "/patient/bilan/" + $id);
    $("#bilansTable > tbody").empty();
    $("#bilanDiv").show();
    $("#radioDiv").hide();
    $.ajax({
      type: "get",
      url: "/patient/element/get-demande/" + $id,
      success: function success(response) {
        var $rows;

        if (response[0].type == 'bilan') {
          response.forEach(function (element) {
            $rows += "\n\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t<td style='border-top : 0px;' >\n\t\t\t\t\t\t\t\t\t<input type='hidden' name='lignes_id[]' value='".concat(element.id, "'>\n\t\t\t\t\t\t\t\t\t").concat(element.element.element, "\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t<td style='border-top : 0px;' ><input type='number' step='0.1' name='valeurs[]' autocomplete=\"off\"  style='width:50%' /> ").concat(element.element.unite, "</td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t");
          });
          $("#bilansTable > tbody").append($rows);
        } else if (response[0].type == 'radio') {
          $("#bilanDiv, #radioDiv").toggle();
        }
      }
    });
  }); // Listen on checbox events

  function handleBilanCheckEvent() {
    var input = $(this).parent().prev().val();
    $(this).parent().prev().val(1 - input);
  }

  ;
  $("#bilansTable ").on('ifToggled', 'input', handleBilanCheckEvent);
  $("#modal_demande_examen ").on('ifToggled', 'input', handleBilanCheckEvent);
  /*
   * Handle edit button on openning modal
   *
   */

  $('.edit_bilan').on('click', function () {
    var $id = $(this).data('id');
    var $el = $(this).data('el');
    $.get('/patient/element/get-element/' + $id).done(function (res) {
      $("#modal_update_biologique input[name='valeur']").val(res.valeur);
      $("#modal_update_biologique input[name='laboratoire']").val(res.laboratoire);
      $("#modal_update_biologique input[name='commentaire']").val(res.commentaire);
      $('#modal_update_biologique form').attr('action', "/patient/bilan/element/" + $id);
      $('#modal_update_biologique #el').html($el);
    });
  });
  /*
   * open radio image
   */

  $('.open_image').on('click', function () {
    var url = "/storage" + $(this).data('url');
    var comment = $(this).data('comment');
    $("#modal_imgs .modal-body img").attr('src', url);
    $("#modal_imgs .modal-body img").attr('alt', comment);
    $("#modal_imgs .modal-body img").attr('title', comment);
  });
});
$(function () {
  //******************************^^*****^^*****************************// 
  // Prescription :
  // Ajouter des lignes prescriptions
  // Aide à la saise médicament dci ou médicament spécialité
  // Affichage de la page de confirmation
  // Envoi du formulaire au serveur HTTP , la méthode :POST
  // Button to delete row
  //******************************^^*****^^**************************************// 
  toastr.options = {
    "positionClass": "toast-bottom-center",
    "hideDuration": "300",
    "timeOut": "2000",
    "escapeHtml ": true
  };
  var $options = "<option>BILLE(S)</option> <option>BOUFFEE(S)</option> <option>CACHET(S)</option> <option>GELULE(S)</option> <option>CAPSULE(S) MOLLE(S)</option> <option>CATAPLASME(S)</option> <option>CHAMP(S) MEDICAMENTEUX</option> <option>CIGARETTE(S)</option> <option>COMPRESSE(S)</option> <option>COMPRIME(S)</option> <option>DISPOSITIF(S) INTRAUTERIN(S)</option> <option>DISPOSITIF(S) TRANSDERMIQUE(S)</option> <option>DOSE(S)</option> <option>EMPLATRE(S)</option> <option>EPONGE(S)</option> <option>GAZE(S)</option> <option>GOMME(S)</option> <option>GRANULE(S)</option> <option>IMPLANT(S)</option> <option>INSERT(S)</option> <option>LYOPHILISAT(S)</option> <option>OVULE(S)</option> <option>PASTILLE(S)</option> <option>PATE(S)</option> <option>PILULE(S)</option> <option>SUPPOSITOIRE(S)</option> <option>TAMPON(S)</option> <option>TIMBRE(S)</option> <option>CUILLERE(S) A CAFE</option> <option>CUILLERE(S) A SOUPE</option> <option>CUILLERE(S) A DESSERT</option> <option>CUILLERE(S) MESURE</option> <option>GOUTTE(S)</option> <option>GOBELET(S)</option> <option>PULVERISATION(S)</option> <option>MESURE(S)</option> <option>PANSEMENT(S) ADHESIF(S)</option> <option>MECHE(S)</option> <option>SYSTEME DE DIFFUSION VAGINAL</option> <option>DISPOSITIF(S)</option> <option>RECIPIENT(S) UNIDOSE(S)</option> <option>BATON(S)</option> <option>FILM(S) ORODISPERSIBLE(S)</option> <option>DOSE(S) KG</option> <option>MATRICE(S)</option> <option>APPLICATION(S)</option>";
  var lines = [];
  var $modalPrescSelector = $('#modal_prescription');
  var $row = "";
  var g_idx = ""; // Listen on checbox events

  function handleCheckboxEvent() {
    var input = $(this).parent().prev().val();
    $(this).parent().prev().val(1 - input);
  }

  ;
  $('#modal_prescription ,#modalPrescriptionVille, #prescription_box').on('ifToggled', 'input', handleCheckboxEvent);
  /*Recherche médicament*/

  $("#modal_prescription, #modalPrescriptionVille , #prescription_box").on('keydown', "input[name='medicament_dci']", function () {
    $(this).autocomplete({
      // appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
      source: function source(request, response) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/medicament",
          method: "POST",
          data: {
            phrase: request.term // value on field input

          },
          success: function success(data, status, code) {
            response($.map(data.slice(0, 30), function (item) {
              // slice cut number of element to show
              dosage = "";

              if (item.status == "médicament") {
                //pour afficher le status du medicament sp en couleur
                style = "style='color:red;'";
              } else {
                // status : substance active
                //dosage = item.dosage+""+item.unite;
                style = "style='color: green;'";
              }

              status = "<i " + style + ">" + item.status + "</i>";
              return {
                label: item.medicament + " " + status,
                // pour afficher dans la liste des suggestions
                //sac_id: item.sac_code_sq_pk,
                //dosage: item.dosage,
                //unite:  item.unite, 
                unite: item.unite,
                voies: item.voies,
                sp_id: item.sp_id,
                value: item.medicament // value c la valeur à mettre dans l'input this

              };
            }));
          }
        });
      },
      // END SOURCE
      minLength: 2,
      select: function select(event, ui) {
        var unit = $("#modal_prescription,#modalPrescriptionVille, #prescription_box").find("select[name='unite']");
        var voie = $("#modal_prescription,#modalPrescriptionVille, #prescription_box").find("select[name='voie']");
        var input_sp_id = $("#modal_prescription,#modalPrescriptionVille, #prescription_box").find("input[name='med_sp_id']");
        $(input_sp_id).val(""); // var input_dci = $(this).closest('tr').find("input[name='medicament_dci']");

        if (typeof ui.item.sp_id != 'undefined' || ui.item.sp_id != null) {
          // si le médicament selectionner est une spécialité
          get_unite_voie(ui.item.unite, ui.item.voies, unit, voie);
          $(this).prev().val(ui.item.sp_id);
        }
      },
      open: function open() {
        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
      },
      close: function close() {
        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
      }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
      //cette method permet de gérer l'affichage de la liste des suggestions
      var bg = "";

      if (item.alg == 1) {
        bg = "style = 'background-color:green; color:white;'";
        $(this).addClass('type');
      }

      return $("<li></li>").data("item.autocomplete", item) //récupérer les donnée de l'autocomplete
      //.attr( "data-value", item.id )
      .append("<a " + bg + ">" + item.label + "</a>") //ajouter à la liste de suggestions
      .appendTo(ul);
    };
  });
  /*Retourner l'unite et la voie d'administration de la specialite/Dci*/

  function get_unite_voie(unite_data, voie_data, unit, voie) {
    $(unit).empty();
    $(voie).empty();

    if (unite_data.length == 0) {
      //Si le médicament ne contient aucune voie d'administration, on ajoute la liste des voies
      $(unit).append($options);
    } else $.each(unite_data, function (i, value) {
      //ajouter les unites coresspondant à la spécialité sélectionner
      $(unit).append("<option value=" + value.unite_nom + ">" + value.unite_nom + "</option>");
    });

    $.each(voie_data, function (i, value) {
      //ajouter les voie coresspondant à la spécialité sélectionner
      $(voie).append("<option value=" + value.cdf_nom + ">" + value.cdf_nom + "</option>");
    });
  } // Supprimer le médicament du tableau 


  $('#tablePrescription > tbody').on('click', '.del_line', function (e) {
    e.stopPropagation(); // pour en cas 2 boutton dasn la meme ligne

    var $row = $(this).closest('tr');
    var index = $row.index();
    $row.remove();

    if ($(".up_line_btn").is(":visible")) {
      $(".up_line_btn").hide();
    }

    if ($(".add_line_btn").is(':hidden')) {
      $(".add_line_btn").show();
    } // supprimer le médicament du tablea lines


    lines.splice(index, 1);
  });
  $('#tableTraitement > tbody ').on('click', '.fa-times-circle', function () {
    var $row = $(this).closest('tr');
    var index = $row.index();
    $row.remove(); // supprimer le médicament du tablea lines

    lines.splice(index, 1);
  }); // Modifier le médicament du tableau 

  $('#tablePrescription > tbody,#tableTraitement > tbody ').on('click', '.up_line', function () {
    var idx = $(this).index(); // get the line from the index

    var up_line = lines[idx]; //

    $modalPrescSelector.find("input[name='med_sp_id']").val(up_line.med_sp_id);
    $modalPrescSelector.find("select[name='type_j']").val(up_line.type_j);
    $modalPrescSelector.find("input[name='nbr_jours']").val(up_line.nbr_jours);
    $(".d_matin").iCheck(up_line.dose_matin == 0 ? 'uncheck' : 'check');
    $modalPrescSelector.find("input[name='dose_matin']").val(up_line.dose_matin);
    $modalPrescSelector.find("input[name='dose_mat']").val(up_line.dose_mat);
    $(".d_midi").iCheck(up_line.dose_midi == 0 ? 'uncheck' : 'check');
    $modalPrescSelector.find("input[name='dose_midi']").val(up_line.dose_midi);
    $modalPrescSelector.find("input[name='dose_mid']").val(up_line.dose_mid);
    $(".d_soir").iCheck(up_line.dose_soir == 0 ? 'uncheck' : 'check');
    $modalPrescSelector.find("input[name='dose_soir']").val(up_line.dose_soir);
    $modalPrescSelector.find("input[name='dose_soi']").val(up_line.dose_soi);
    $modalPrescSelector.find("input[name='dose_ac']").val(up_line.dose_ac);
    $(".d_av").iCheck(up_line.dose_av == 0 ? 'uncheck' : 'check');
    $modalPrescSelector.find("input[name='dose_av']").val(up_line.dose_av);
    $modalPrescSelector.find("select[name='unite']").append("<option value=".concat(up_line.unite, " > ").concat(up_line.unite, "</option>")).is(":selected");
    $modalPrescSelector.find("select[name='voie']").append("<option value=".concat(up_line.voie, " > ").concat(up_line.voie, "</option>")).is(":selected");
    $modalPrescSelector.find("input[name='line_id']").val(up_line.id);
    $modalPrescSelector.find("input[name='medicament_dci']").val(up_line.medicament_dci).prop('readonly', true);

    if ($(".up_line_btn").is(":hidden")) {
      $(".up_line_btn").show();
    }

    if ($(".add_line_btn").is(':visible')) {
      $(".add_line_btn").hide();
    }

    $row = $(this);
    g_idx = idx;
  }); // ajouter la line prescription au tableau lines

  function upLinePrescription(e) {
    e.preventDefault();
    var form = $("form#addLinePrescription").serializeArray();
    var line = objectifyForm(form);
    var index = $row.index(); //

    lines.splice(g_idx, 1);
    $row.remove(); //

    $(".up_line_btn").toggle();
    $(".add_line_btn").toggle(); // add form to lines

    var count = lines.push(line); // get textual format of Prescription

    var medicament = medicToText(line); // add to table

    appendToTable(medicament, count);
    resetForm(); //reset form
    //$("form#addLinePrescription")[0].reset();

    $modalPrescSelector.find("input[name='medicament_dci']").attr("readonly", false);
  }

  $(".up_line_btn").on('click', upLinePrescription); // ajouter la line prescription au tableau lines

  function addLinePrescription(e) {
    e.preventDefault();
    var form = $("form#addLinePrescription").serializeArray();
    var line = objectifyForm(form); // add form to lines

    var count = lines.push(line); // get textual format of Prescription

    var medicament = medicToText(line); // add to table

    appendToTable(medicament, count, null); // uncheckAll();
    //reset form
    // $("form#addLinePrescription")[0].reset();

    resetForm();
  }

  function resetForm() {
    $("form#addLinePrescription input[name='medicament_dci']").val('');
    $("form#addLinePrescription input[name='dose_mat']").val('1');
    $("form#addLinePrescription input[name='dose_mid']").val('1');
    $("form#addLinePrescription input[name='dose_soi']").val('1');
    $("form#addLinePrescription input[name='dose_ac']").val('1');
    $("form#addLinePrescription input[name='nbr_jours']").val('1');
  } // $('form#addLinePrescription').on('reset', function (e) {
  // 	var form = $("form#addLinePrescription");
  // 	setTimeout(function () {
  // 		form.find('input.icheck-input').each(function (index, element) {
  // 			$(element).icheck('updated', function (node) {});
  // 		});
  // 	});
  // });


  $("form#addLinePrescription").on('submit', addLinePrescription);
  /**
   * Uncheck all
   */
  // function uncheckAll() {
  // 	$(".d_matin").iCheck('uncheck');
  // 	$(".d_midi").iCheck('uncheck');
  // 	$(".d_soir").iCheck('uncheck');
  // 	$(".d_av").iCheck('uncheck');
  // }
  // store prescription to database

  function savePrescription() {
    var formData = new FormData();
    var url = $modalPrescSelector.find("input[name='url']").val() !== "" ? $modalPrescSelector.find("input[name='url']").val() : "/patient/prescription";
    var dataToAppend = [{
      key: 'patient_id',
      value: $("input[name='patient_id']").val()
    }, {
      key: 'date_prescription',
      value: $modalPrescSelector.find("input[name='date_prescription']").val()
    }, {
      key: 'cons_id',
      value: $modalPrescSelector.find("input[name='cons_id']").val()
    }, {
      key: 'med_sp_id',
      value: JSON.stringify(lines)
    }, {
      key: '_method',
      value: $modalPrescSelector.find("input[name='method']").val() == "PUT" ? 'PATCH' : ''
    }];
    dataToAppend.map(function (keyvalue) {
      formData.append(keyvalue.key, keyvalue.value);
    });
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
      success: function success(response) {
        window.location.reload();
      },
      error: function error(exception, type, code) {
        toastr.error(exception.responseText);
      }
    });
  }

  $("#savePrescription").on('click', savePrescription);
  $("#prescrBtn").on('click', function () {
    $("#tablePrescription>tbody").empty();
  });
  $('.modal_act').on('click', function () {
    var myModal = $('#modal_act');
    var cons_id = $(this).data('id');
    $(".modal-body #cons_id").val(cons_id);
    $('form', myModal).attr('action', '/patient/acte/store'); // and finally show the modal

    myModal.modal({
      show: true
    });
  });
  /*Dubliquer la prescription*/

  $('.cloner').on('click', function () {
    $("#tablePrescription>tbody").empty();
    var $prescription_id = $(this).data('id');
    $.get({
      url: "/patient/prescription/" + $prescription_id,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        lines = [];
        var lignes_presc = data.lignes; // lignes de prescription

        var lignes_ips = data.intervention.lignes_i_p; // les intervention du médecin sur les lignes

        for (var i = 0; i < lignes_presc.length; i++) {
          var j = i;
          var ipMsg = lignes_ips[i].ip;
          var medicament = medicToText(lignes_presc[i]);
          appendToTable(medicament, j + 1, ipMsg);
          lines.push(lignes_presc[i]);
        }

        $("#modal_prescription").modal({
          show: true
        });
      }
    });
  });
  /*
   * append line to medicament table
   */

  function appendToTable(line) {
    var index = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
    var ipMsg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null; // let up_line = "";
    // if (ipMsg)

    up_line = "\n\t\t\t\tclass = \"up_line\"\n\t\t\t\tstyle = 'cursor : pointer;'\n\t\t\t\tdata - index = '".concat(index - 1, "'\n\t\t\t\t");
    $("#tablePrescription > tbody").append("<tr title = \"Cliquer pour modifier le m\xE9dicament\"".concat(up_line, " ><td> ").concat(line, " </td> <td> <i class = 'fa fa-times-circle fa-1x del_line' style = 'color:red;cursor : pointer;' data-index = '").concat(index - 1, "' ></i></td></tr>"));
  }
  /*
   * Transform line prescription to readable text
   */


  function medicToText(line) {
    var toText = "<b> ".concat(line.medicament_dci, " </b> ").concat(line.voie, ". \n\t\t\t\t").concat(line.dose_matin != 0 ? line.dose_mat + " <b>" + line.unite.toLowerCase() + '</b> le <b class="text-info">Matin</b>, ' : '', "\n\t\t\t\t").concat(line.dose_midi != 0 ? line.dose_mid + ' à <b class="text-green">Midi</b>, ' : '', "\n\t\t\t\t").concat(line.dose_soir != 0 ? line.dose_soi + ' le <b class="text-orange">Soir</b>, ' : '', "\n\t\t\t\t").concat(line.dose_av != 0 ? line.dose_ac + ' <b class="text-red">Avant-coucher</b>.' : '', "\n\t\t\t\tPendant: <b> ").concat(line.nbr_jours, " </b> ").concat(line.type_j, "\n\t\t\t\t");
    return toText;
  }
  /*Supprimer la ligne Prescription*/


  $("a.deleteRowPrescription").on('click', function (event) {
    var _this = this;

    if (confirm('voulez vous supprimer cette ligne ?')) {
      var url = $(this).data('url');
      event.preventDefault();
      $.ajax({
        url: url,
        type: 'POST',
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }).done(function (response) {
        if (response.response == 'success') {
          $(_this).closest('tr').remove();
          $(_this).closest('tr').next('tr').remove();
          toastr.success(response.msg);
        } else toastr.error(response);
      });
    }
  });
  /*
   * edit prescription on open modal
   */

  $(".editPrescription").on('click', function () {
    var id = $(this).data('id');
    $.get(" / patient / prescription / $ {\n\t\t\t\t\tid\n\t\t\t\t}\n\t\t\t\t/edit").done(function (res) {
      lines = res.lignes;
      var count = lines.length;
      var date_prescription = res.date_prescription;
      var url = "/patient/prescription/".concat(id);
      $modalPrescSelector.find("input[name='date_prescription']").val(date_prescription);
      $modalPrescSelector.find("input[name='url']").val(url);
      $modalPrescSelector.find("input[name='method']").val('PUT');
      lines.forEach(function (line, index) {
        // get textual format of Prescription
        var medicament = medicToText(line); // add to table

        appendToTable(medicament, ++index, 1);
      });
    });
  });
  $("#modal_prescription").on('hide.bs.modal', function () {
    $modalPrescSelector.find("input[name='url']").val("");
    $modalPrescSelector.find("input[name='method']").val("");
    $modalPrescSelector.find("tbody").empty();

    if ($(".up_line_btn").is(":visible")) {
      $(".up_line_btn").hide();
    }

    if ($(".add_line_btn").is(':hidden')) {
      $(".add_line_btn").show();
    }

    lines = [];
  });

  function objectifyForm(formArray) {
    //serialize data function
    var returnArray = {};

    for (var i = 0; i < formArray.length; i++) {
      returnArray[formArray[i]['name']] = formArray[i]['value'];
    }

    return returnArray;
  }
}); // Listen on checbox events

function handleCheckboxInjectedEvent() {
  var line_id = $(this).parent().prev().data('id');
  var prise = $(this).parent().prev().data('prise');
  var newLocal = $(this);
  var input = $(this).parent().prev().val();
  var isChecked = $(this).parent().prev().val(1 - input).val();
  $.ajax({
    type: "get",
    url: "/patient/prescription/ligneprescription/" + line_id + "&&" + isChecked + "&&" + prise,
    success: function success(response) {
      if (response.type == "success") {
        // disable selected Checkbox
        $(newLocal).iCheck('disable');
        toastr.success(response.msg);
      } else toastr.info(response.msg);
    },
    error: function error(txter, er) {
      toastr.warning(txter.responseJSON.message);
    }
  });
}

;
$('#example127 ').on('ifToggled', 'input[name="injected"]', handleCheckboxInjectedEvent);
/*                              */

/! STOP INJECTION EVENT HANDLER !/;
/*                              */

$(".stopInjection").on('click', onStopInjection);

function onStopInjection() {
  var comment = prompt("Préciser l'arrét du médicament", "Aucune raison!");
  var form = new FormData();
  form.append('comment', comment);
  var line_id = $(this).data('id');
  var btn = $(this);
  $.ajax({
    method: "post",
    url: "/patient/prescription/ligneprescription/stop-injection/" + line_id,
    processData: false,
    contentType: false,
    data: form,
    dataType: "json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(response) {
      toastr.success(response);
      btn.prop("disabled", true);
    },
    error: function error(exception, status, type) {
      toastr.error(status + " " + exception.status + " " + type + " : " + exception.responseText);
    }
  });
}
/*/                               /*/
//? SHOW MODAL INJECTIONS HANDLER ?// 

/*/                               /*/


var administration_table;
var groupColumn = 1;
$("#modal_administrations").on('show.bs.modal', function (e) {
  var id = $(e.relatedTarget).data("id");

  if ($.fn.dataTable.isDataTable('#administrations_table')) {
    administration_table.destroy();
  }

  administration_table = $('#administrations_table').DataTable({
    dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    lengthChange: false,
    buttons: [{
      extend: 'excelHtml5',
      className: 'btn-success',
      text: "<i class='fa fa-download mr-1'></i>Excel"
    }, {
      extend: "pdfHtml5",
      text: "<i class='fa fa-download mr-1'></i>PDF"
    }],
    "processing": true,
    "ajax": "/patient/prescription/get-injections/id=" + id,
    "columns": [{
      "data": "administrator.nurse"
    }, {
      "data": "line.medicament.SP_NOM"
    }, {
      "data": "posologie"
    }, {
      "data": "custom_injected_at"
    }],
    "columnDefs": [{
      "visible": false,
      "targets": groupColumn
    }],
    "order": [[groupColumn, 'asc']],
    "displayLength": 20,
    "drawCallback": function drawCallback(settings) {
      var api = this.api();
      var rows = api.rows({
        page: 'current'
      }).nodes();
      var last = null;
      api.column(groupColumn, {
        page: 'current'
      }).data().each(function (group, i) {
        if (last !== group) {
          $(rows).eq(i).before('<tr class="group"><td colspan="4">' + group + '</td></tr>');
          last = group;
        }
      });
    }
  });
  administration_table.buttons().container().appendTo('#administrations_table .col-sm-6:eq(0)');
}); // Order by the grouping

$('#administrations_table tbody').on('click', 'tr.group', function () {
  var currentOrder = administration_table.order()[0];

  if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
    administration_table.order([groupColumn, 'desc']).draw();
  } else {
    administration_table.order([groupColumn, 'asc']).draw();
  }
});
$(function () {
  //******************************^^*****^^*****************************// 
  // Traitement :
  // Ajouter des lignes prescriptions
  // Affichage du modal modification traitement
  //******************************^^*****^^**************************************// 
  var linesTraitements = [];
  var $modalPrescriptionVille = $("#modalPrescriptionVille");
  /*
   * update the state of trait or auto medic
   */

  $(".updateTraitAuto").on('click', function () {
    var ligne_id = $(this).data('id');
    var type = $(this).data('type');
    var url = type == 'trait' ? '/patient/traitement_chronique/get-last-state/' + ligne_id : '/patient/automedication/get-last-state/' + ligne_id;
    var action = type == 'trait' ? '/patient/traitement_chronique/update-state/' + ligne_id : '/patient/automedication/update-state/' + ligne_id;
    $("#historyStates > tbody").empty(); // Get Last State From Ajax Request

    var response = getLastState(url); // handle ajax request

    response.done(function (res) {
      var line = res['line'];
      var history = res['history'];
      $("#updateTraitAutoModal #state").html(line.etats == "En cours" ? "<span class='bg-red'>Arréter</span>" : "<span class='bg-blue'>Reprise</span>");
      $("#updateTraitAutoModal input[name='etats']").val(line.etats == "En cours" ? "Arréter" : "Reprise");
      $('#updateTraitAutoModal').modal('show');
      $('#updateTraitAutoModal form').attr('action', action); // show history states

      showHistoryStates(history);
    }).fail(function (err) {
      alert(err);
    });
  });
  /*
   * show history states in table
   */

  function showHistoryStates(h) {
    h.forEach(function (l) {
      $("#historyStates > tbody").append("\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td>".concat(l.etats, " ").concat(l.date_etats, "</td>\n\t\t\t\t\t</tr>\n\t\t\t\t"));
    });
  }
  /*
   * Ajax request to get Ligne Prescription Object
   */


  function getLastState(url) {
    return $.get(url);
  }
  /*
   * open edit modal and update value of trait or auto medic
   */


  $('.editPrescriptionVille').on('click', function () {
    //traitement pour modifier le médicament du traitement chronique
    var myModal = $('#modalUpdatePrescriptionVille');
    var ligneId = $(this).data('id'); // var medicament = $(this).data('medicament');

    var typePrescription = $(this).data('type');
    var url = typePrescription == 'trait' ? '/getTraitement' : '/getAutomedication'; //remplir le tableau historique de prise du médicament

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: url,
      method: 'post',
      data: {
        ligne_id: ligneId
      },
      datatype: 'json',
      success: function success(ligne) {
        $("input[name='medecin_externe']", myModal).val(ligne.medecin_externe);
        $("input[name='dose']", myModal).val(ligne.dose);
        $("input[name='dose_matin']", myModal).val(ligne.dose_matin);
        $('#dose_matin', myModal).iCheck(ligne.dose_matin == "1" ? 'check' : 'uncheck');
        $("input[name='dose_midi']", myModal).val(ligne.dose_midi);
        $('#dose_midi', myModal).iCheck(ligne.dose_midi == "1" ? 'check' : 'uncheck');
        $("input[name='dose_soir']", myModal).val(ligne.dose_soir);
        $('#dose_soir', myModal).iCheck(ligne.dose_soir == "1" ? 'check' : 'uncheck');
        $("input[name='dose_avant_coucher']", myModal).val(ligne.dose_avant_coucher);
        $('#dose_avant_coucher', myModal).iCheck(ligne.dose_avant_coucher == "1" ? 'check' : 'uncheck');
        $("select[name='repas_matin']", myModal).val(ligne.repas_matin).is(':selected');
        $("select[name='repas_soir']", myModal).val(ligne.repas_soir).is(':selected');
        $("select[name='repas_midi']", myModal).val(ligne.repas_midi).is(':selected');
        $("input[name='date_etats']", myModal).val(ligne.date_etats);
        $('#state', myModal).html(ligne.etats).addClass(ligne.etats == "En cours" ? "bg-green" : "bg-red");
        $('#hopital', myModal).prop('checked', ligne.status_hopital == "1" ? true : false);
        action = typePrescription == 'trait' ? '/patient/traitement_chronique/' + ligne.id : '/patient/automedication/' + ligne.id;
        $('form', myModal).attr('action', action);
        /*---------------------------------------------------------*/
        // $('#example12>tbody', myModal).empty();
        // $.each(data['history'], function (i, value) {
        // 	if (value.status_hopital === '1') stat = 'V';
        // 	else stat = 'H';
        // 	if ((value.etats == "En cours") || (value.etats == "Reprise")) color = "success";
        // 	else color = "danger";
        // 	$('#example12>tbody', myModal).append("<tr>" +
        // 		"<td>" + ((!value.voie) ? "/" : value.voie) + "</td>" +
        // 		"<td>" + ((!value.dose_matin) ? "/" : value.dose_matin) + " " + ((!value.repas_matin) ? "" : value.repas_matin) + "</td>" +
        // 		"<td>" + ((!value.dose_midi) ? "/" : value.dose_midi) + " " + ((!value.repas_midi) ? "" : value.repas_midi) + "</td>" +
        // 		"<td>" + ((!value.dose_soir) ? "/" : value.dose_soir) + " " + ((!value.repas_soir) ? "" : value.repas_soir) + "</td>" +
        // 		"<td>" + ((!value.dose_avant_coucher) ? "/" : value.dose_avant_coucher) + "</td>" +
        // 		"<td>" + value.unite + "</td>" +
        // 		"<td>" + ((!value.medecin_externe) ? "/" : "Dr." + value.medecin_externe) + "</td>" +
        // 		"<td><span class='label label-" + color + "'> " + value.etats + "</span></td>" +
        // 		"<td>" + value.date_etats + "</td>" +
        // 		"<td>" + stat + "</td>" +
        // 		"</tr>");
        // });
      },
      error: function error(jqXHR, textStatus) {
        alert("Request failed: " + textStatus + " " + jqXHR);
      }
    }); //and finally show the modal

    myModal.modal({
      show: true
    });
  });

  function addLineTraitement(e) {
    e.preventDefault();
    var med_sp_id = $modalPrescriptionVille.find("input[name='med_sp_id']").val();
    var dose_matin = $modalPrescriptionVille.find("input[name='dose_matin']").val();
    var dose_midi = $modalPrescriptionVille.find("input[name='dose_midi']").val();
    var dose_soir = $modalPrescriptionVille.find("input[name='dose_soir']").val();
    var dose_av = $modalPrescriptionVille.find("input[name='dose_avant_coucher']").val();
    var status_hopital = $modalPrescriptionVille.find("input[name='status_hopital']").val();
    var unite = $modalPrescriptionVille.find("select[name='unite']").val();
    var voie = $modalPrescriptionVille.find("select[name='voie']").val();
    var dose = $modalPrescriptionVille.find("input[name='dose']").val();
    var date_etats = $modalPrescriptionVille.find("input[name='date_etats']").val();
    var medic = $modalPrescriptionVille.find("input[name='medicament_dci']").val();
    var line = {
      'med_sp_id': med_sp_id,
      'dose_matin': dose_matin,
      'dose_midi': dose_midi,
      'dose_soir': dose_soir,
      'dose_avant_coucher': dose_av,
      'unite': unite,
      'voie': voie,
      'dose': dose,
      'medic': medic,
      'date_etats': date_etats,
      'status_hopital': status_hopital
    }; // add form to lines

    var count = linesTraitements.push(line); // get textual format of Prescription

    var medicament = medicToText(line); // add to table

    appendToTable(medicament, count);
    resetForm1(); //reset form
    //$("form#addLineTraitement")[0].reset();
  }

  $("#addLineTraitement").on('submit', addLineTraitement);

  function resetForm1() {
    $("form#addLinePrescription input[name='medicament_dci']").val('');
    $("form#addLinePrescription input[name='date_etats']").val('');
    $("form#addLinePrescription input[name='dose_mat']").val('1');
    $("form#addLinePrescription input[name='dose_mid']").val('1');
    $("form#addLinePrescription input[name='dose_soi']").val('1');
    $("form#addLinePrescription input[name='dose_ac']").val('1');
    $("form#addLinePrescription input[name='nbr_jours']").val('1');
  } // store traitement to database

  /**
   */


  function saveTraitement() {
    var formData = new FormData();
    var patient_id = $("input[name='patient_id']").val();
    var medecin_externe = $modalPrescriptionVille.find("input[name='medecin_externe']").val();
    var url = $modalPrescriptionVille.find("form").attr("action");
    formData.append('patient_id', patient_id);
    formData.append('medecin_externe', medecin_externe);
    formData.append('med_sp_id', JSON.stringify(linesTraitements));
    $.ajax({
      type: "post",
      processData: false,
      contentType: false,
      url: url,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      dataType: "json",
      success: function success(response) {
        if (response !== "success") window.location.href = response;else window.location.reload();
      }
    });
  }

  $("#saveTraitement").on('click', saveTraitement);
  /*
   * append line to medicament table
   */

  function appendToTable(line) {
    var index = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
    var ipMsg = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
    $("#tableTraitement > tbody").append("\n\t\t\t\t<tr>\n\t\t\t\t\t<td>".concat(line, "</td>\n\t\t\t\t\t<td><i class='fa fa-times-circle' style='color:red;cursor : pointer;' data-index = '").concat(index - 1, "'></i></td>\n\t\t\t\t</tr>\n\t\t\t"));
  }
  /*
   * Transform line prescription to readable text
   */


  function medicToText(line) {
    var toText = "\n\t\t\t\t".concat(line.medic, " ").concat(line.voie, ". ").concat(line.dose, " ").concat(line.unite, " le ").concat(line.dose_matin != 0 ? 'matin' : '', " ").concat(line.dose_midi != 0 ? 'midi' : '', "\n\t\t\t\t").concat(line.dose_soir != 0 ? 'soir' : '', " ").concat(line.dose_avant_coucher != '0' ? 'av-coucher' : '', "\n\t\t\t");
    return toText;
  }
});
$(function () {
  //******************************^^*****^^*****************************// 
  // Produit alimentaire et phytotherapie :
  // Ajouter des lignes prescriptions
  // Affichage de la page de confirmation
  // Envoi du formulaire au serveur HTTP , la méthode :POST
  //******************************^^*****^^**************************************// 
  $('#used_on').select2({
    ajax: {
      url: '/patient/get-pathologies',
      dataType: 'json',
      processResults: function processResults(data) {
        // Transforms the top-level key of the response object from 'items' to 'results'
        return {
          results: data.items
        };
      }
    }
  });
  $("#modal_phyto").on('change', '.frequence', function () {
    if ($(this).val() == "Depuis :") $('.frequence_date').show();else $('.frequence_date').hide();
  });
  $("#add_produit").click(function () {//$(this).closest('tbody').prepend("<tr><td><input type='hidden' class='pr_hidden' name='produitalimentaire_id[]'><input type='text' class='pr_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'><input type='text' class='ar_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'> <select class='form form-control frequence' name='frequence[]' > <option>Occasionnellement</option> <option>Exceptionnellement</option> <option>Depuis :</option> </select> </td> <td><input type='date' class='form-control frequence_date'  name='frequence_date[]' style='display: none;' /></td></tr>");
  });
  var options = {
    url: function url(phrase) {
      return "/patient/produit/" + phrase; // url to send into server
    },
    getValue: "produit_naturel_fr",
    template: {
      // permet d'afficher dans la liste un autre champs
      type: "description",
      fields: {
        description: "produits_arabe"
      }
    },
    ajaxSettings: {
      // d'ont touch and mmodify
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      method: "POST",
      data: {
        dataType: "json"
      }
    },
    preparePostData: function preparePostData(data) {
      data.phrase = $('.pr_input').val(); // returned data from server , json format

      return data;
    },
    list: {
      onSelectItemEvent: function onSelectItemEvent() {
        var value = $('.pr_input').getSelectedItemData().id;
        $(".pr_hidden").val(value).trigger("change");
      }
    } // requestDelay: 10000 // delays for response serve

  };
  var options1 = {
    url: function url(phrase) {
      return "/patient/produit_ar/" + phrase; // url to send into server
    },
    getValue: "produits_arabe",
    template: {
      // permet d'afficher dans la liste un autre champs
      type: "description",
      fields: {
        description: "produit_naturel_fr"
      }
    },
    ajaxSettings: {
      // d'ont touch and mmodify
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      method: "POST",
      data: {
        dataType: "json"
      }
    },
    preparePostData: function preparePostData(data) {
      // function before send data to server
      data.phrase = $('.pr_input').val(); // get val input into data.phrase

      return data;
    },
    list: {
      onSelectItemEvent: function onSelectItemEvent() {
        var value = $('.ar_input').getSelectedItemData().id;
        $(".pr_hidden").val(value).trigger("change");
      }
    } // requestDelay: 10000 // delays for response serve

  }; // Recherche produits phyotohérapeutique en français

  $('.pr_input').easyAutocomplete(options);
  $('.ar_input').easyAutocomplete(options1);
  $('#modal_phyto .easy-autocomplete').css('width', '100%');
});
$(function () {
  //******************************^^*****^^*****************************// 
  // Consultation :
  // Ajouter des lignes consultation
  // Affichage de la page de confirmation
  // Envoi du formulaire au serveur HTTP , la méthode :POST
  // Button to delete row
  //******************************^^*****^^**************************************//
  $('.edit_consultation').on('click', function () {
    var myModal = $('#modal_edit_consultation');
    var cons_id = $(this).data('id'); // get the values from the table

    var motif = $(this).closest('tr').find('td:eq(2)').text();
    var signe = $(this).closest('tr').find('td:eq(3)').text();
    var examen = $(this).closest('tr').find('td:eq(4)').text();
    var compte = $(this).closest('tr').find('td:eq(5)').text();
    var lettre = $(this).closest('tr').find('td:eq(6)').text();
    var cert = $(this).closest('tr').find('td:eq(7)').text();
    var date = $(this).closest('tr').find('td:eq(8)').text(); //  set them in the modal:

    $('#date', myModal).val(date);
    $('#motif', myModal).val(motif);
    $('#signe', myModal).val(signe);
    $('#examen', myModal).val(examen);
    $('#compte', myModal).val(compte);
    $('#lettre', myModal).val(lettre);
    $('#cert', myModal).val(cert);
    $('form', myModal).attr('action', '/patient/consultation/' + cons_id); // and finally show the modal

    myModal.modal({
      show: true
    });
  });
  /*
   * handle 'Ajouter un examen' button
   *
   */

  $('.modale_bilane').on('click', function () {
    var cons_id = $(this).data('id');
    $("#modal_demande_examen #cons_id").val(cons_id);
  });
});
$(function () {
  //******************************^^*****^^**************************************// 
  // Hospitalisation : 													   //					   //
  // Affectation des champs pour la modification 								   //			       //
  //******************************^^*****^^**************************************// 
  $('.edit_hospitalisation').on('click', function () {
    // traitement pour modifier un bilan
    var myModal = $('#modal_detail_hospitalisation');
    var hospitalisation_id = $(this).attr('id'); // get bilan ID
    // now get the values from the table

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/hospitalisation/getHospitalisation/' + hospitalisation_id,
      method: 'POST',
      datatype: 'json',
      success: function success(data) {
        // and set them in the modal:
        $('#service', myModal).val(data[0].service);
        $('#numbiais', myModal).val(data[0].num_biais);
        $('#chambre', myModal).val(data[0].chambre);
        $('#lit', myModal).val(data[0].lit);
        $('#motif', myModal).val(data[0].motifs);
        $('#date_admission', myModal).val(data[0].date_admission);
        $('#date_sortie', myModal).val(data[0].date_sortie);
        $("#motif_sortie").val(data[0].motif_sortie).is(":selected"); // $("#service_transfert")
        //     .val(data[0].service_transfert)
        //     .is(":selected");

        $('.up_hospitalisation', myModal).attr('action', '/hospitalisation/' + hospitalisation_id + '/edit');
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    }); // and finally show the modal

    myModal.modal({
      show: true
    });
  });
  $('.edit_act_med').on('click', function () {
    // traitement pour modifier un bilan
    var myModal = $('#modal_detail_act');
    var act_id = $(this).attr('id'); // get bilan ID
    // now get the values from the table

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/acts/getAct/' + act_id,
      method: 'POST',
      datatype: 'json',
      success: function success(data) {
        // and set them in the modal:
        $('#cons_id', myModal).val(data[0].consultation_id);
        $('#actm', myModal).val(data[0].act_medicale_id);
        $('#patient_id', myModal).val(data[0].patient_id);
        $('#description', myModal).val(data[0].description);
        $('#date_act', myModal).val(data[0].date_act);
        $('.up_acts', myModal).attr('action', '/acts/' + act_id + '/edit');
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    }); // and finally show the modal

    myModal.modal({
      show: true
    });
  });
  $('.edit_impression').on('click', function () {
    // traitement pour modifier un rapport
    var myModal = $('#modal_detail_impression');
    var hospitalisation_id = $(this).attr('id'); // get bilan ID
    // now get the values from the table

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        $('.up_impression', myModal).attr('action', '/hospitalisation/' + hospitalisation_id + '/print');
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    }); // and finally show the modal

    myModal.modal({
      show: true
    });
  }); //Show other works input's 

  $("#motif_sortie1").on('change', function () {
    if ($(this).val() == "autre") {
      $("#service_transfert1").show();
    } else $("#service_transfert1").hide();
  });
  $("#motif_sortie").on('change', function () {
    if ($(this).val() == "autre") {
      $("#service_transfert").show();
    } else $("#service_transfert").hide();
  });
});
jQuery(document).ready(function ($) {
  $('#questionnaireChoiceId').on('change', function (event) {
    var questionnaireSelected = $(this).val();
    var $tbody = $('#modal_question tbody');
    $tbody.empty();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/getQuestions/' + questionnaireSelected,
      type: 'GET',
      dataType: 'html'
    }).done(function (data) {
      data = $.parseJSON(data);
      $.each(data, function (index, val) {
        $tbody.append("<tr> <td>" + val.question + "<input type='hidden' name='questions[]' value=" + val.id + "> </td> <fieldset> <td> <input type='hidden' name='oui" + (index + 1) + "' value=1> <input type='radio' onclick='this.previousSibling.value=1' name='oui" + (index + 1) + "'> </td> <td> <input type='hidden' name='oui" + (index + 1) + "'  value=1> <input type='radio'  onclick='this.previousSibling.value=8-this.previousSibling.value' name='oui" + (index + 1) + "'> </td> </fieldset> </tr>");
      });
    }).fail(function () {
      console.log("error");
    }).always(function () {
      console.log("complete");
    });
  });
});
/**
 * on submit education form
 * @param {Event} e 
 */

function downloadEducation(e) {
  if (confirm('Voulez vous une copie du rapport de l\'éducation thérapeutique?')) {
    var notes = $("#modal_entretien").find("textarea[name='notes']").val();
    var date_educ = new Date().toISOString().slice(0, 10);
    lunchDownloadEduc(date_educ, notes);
  }
}

$("#formEducation").on('submit', downloadEducation);

function lunchDownloadEduc(date_educ, notes) {
  text = {
    head: ['Date : ' + date_educ + '\n'],
    core: [{
      text: 'Rapport Education Thérapeutique',
      style: 'header',
      alignment: 'center'
    }, {
      style: 'core',
      text: notes
    }]
  };
  downloadDocument(text, 'Education-Thérapeutique-' + new Date().toISOString().slice(0, 10) + ".pdf");
}

function preDownloadEduc() {
  var date_educ = $(this).data('date');
  var notes = $(this).data('notes');
  lunchDownloadEduc(date_educ, notes);
}

$(".download-education").on('click', preDownloadEduc);
$(".envoyer").click(function () {
  var message = $("input[name='message']").val();
  var patient_id = $(this).data('id');
  var user_id = $(this).data('user');
  var user_name = $(this).data('name');
  console.log(message + patient_id + user_id);
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: "POST",
    url: "/patient/message",
    data: {
      message: message,
      patient_id: patient_id,
      user_id: user_id
    },
    datatype: 'html',
    success: function success(data) {
      var msg_id = data;
      var d = new Date();
      var month = d.getMonth() + 1;
      var day = d.getDate();
      var weekday = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
      var output = weekday[d.getDay()] + " " + (day < 10 ? '0' : '') + day + " " + (month < 10 ? '0' : '') + month + " " + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes();
      $('.direct-chat-messages').prepend("<div class='direct-chat-msg right'> <div class='direct-chat-info clearfix'>" + "<span class='direct-chat-name pull-right'>" + user_name + "</span> <span class='direct-chat-timestamp pull-left'>" + output + "</span> </div> <img class='direct-chat-img' src='/images/user.jpg' alt='Message User Image'><div class='direct-chat-text'>" + message + "<i class='fa fa-times-circle' style='color:red;cursor : pointer; ' data-id=" + msg_id + "></i>" + "</div></div>");
    },
    failure: function failure(error) {
      console.log(error);
    }
  });
}); // $("input[name='q1']").autocomplete({
// 	source: availableTags
//  });

$('#messageBox').on('click', '.fa-times-circle', function () {
  var _this2 = this;

  var msg_id = $(this).data('id'); //get msg id

  $.ajax({
    //remove message from database
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: "DELETE",
    url: "/patient/message/" + msg_id,
    data: {
      msg_id: msg_id
    },
    datatype: 'html',
    success: function success(data) {
      if (data == '1') $(_this2).closest('div.direct-chat-msg').remove(); //remove message from chat box
    },
    failure: function failure(error) {
      console.log(error);
    }
  });
}); // new Date().getDate()          // Get the day as a number (1-31)
// new Date().getDay()           // Get the weekday as a number (0-6)
// new Date().getFullYear()      // Get the four digit year (yyyy)
// new Date().getHours()         // Get the hour (0-23)
// new Date().getMilliseconds()  // Get the milliseconds (0-999)
// new Date().getMinutes()       // Get the minutes (0-59)
// new Date().getMonth()         // Get the month (0-11)
// new Date().getSeconds()       // Get the seconds (0-59)
// new Date().getTime()          // Get the time (milliseconds since January 1, 1970)
// $(function(){
// 	//******************************^^*****^^*****************************// 
// 	// Traitement :
// 	// Ajouter des lignes prescriptions
// 	// Affichage du modal modification traitement
// 	//******************************^^*****^^**************************************// 
// 	$("#tableAddMedicamenttrait>tbody").on('click','#add_traitement',function(){
// 			$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>unité</option> <option>comprimé</option> </select> </td> <td><input type='hidden' name='status_hopital[]' value='0'><input type='checkbox' onclick='this.previousSibling.value=1-this.previousSibling.value'</td> <td> <input type='date' class='form-control' name='date_etats[]'> </td><td> <button type='button' class='btn btn-info btn-flat' id='add_traitement'>+</button> </td></tr>");
// 			$(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>");
// 	});
// 	 $('.edit_traitement').on('click', function() {
// 	     var myModal = $('#modal_update_traitement');
// 	     var ligne_id = $(this).attr('id');  //get bilan ID
// 	      //now get the values from the table
// 	    	 var medicament_dci_id = $(this).closest('tr').find('th:eq(0)').attr('value');
// 	    	 var dose_matin = $(this).closest('tr').find('td:eq(0)').attr('value');
// 	    	 var repas_matin = $(this).closest('tr').find('td:eq(0)').attr('value1');
// 	    	 var dose_midis = $(this).closest('tr').find('td:eq(1)').attr('value');
// 	    	 var repas_midis = $(this).closest('tr').find('td:eq(1)').attr('value1');
// 	    	 var dose_soir = $(this).closest('tr').find('td:eq(2)').attr('value');
// 	    	 var repas_soir = $(this).closest('tr').find('td:eq(2)').attr('value1');
// 	    	 var dose_avant_coucher = $(this).closest('tr').find('td:eq(3)').attr('value');
// 	    	 var unite = $(this).closest('tr').find('td:eq(4)').attr('value');
// 	    	 var medecin_externe = $(this).closest('tr').find('td:eq(5)').attr('value');
// 	    	 var status = $(this).closest('tr').find('td:eq(6)').attr('value');
// 	    	 var date_etats = $(this).closest('tr').find('td:eq(7)').attr('value');
// 	    	 var hopital = $(this).closest('tr').find('td:eq(8)').attr('value');
// 	      //and set them in the modal:
// 	     $('h4' ,myModal).html("Modifier médicament : "+medicament_dci_id);
// 	     $('h2' ,myModal).html("Historique du médicament :"+medicament_dci_id);
// 	     $('#medecin_externe',myModal).val(medecin_externe);
// 	     $('#medicament_dci_id',myModal).val(medicament_dci_id);
// 	     $('#dose_matin',myModal).val(dose_matin);
// 	     $('#dose_midis',myModal).val(dose_midis);
// 	     $('#dose_soir',myModal).val(dose_soir);
// 	     $('#dose_avant_coucher',myModal).val(dose_avant_coucher);
// 	     $('#unite',myModal).val(unite).is(':selected'); 
// 	     $('#repas_matin',myModal).val(repas_matin).is(':selected'); 
// 	     $('#repas_soir',myModal).val(repas_soir).is(':selected'); 
// 	     $('#repas_midis',myModal).val(repas_midis).is(':selected'); 
// 		 if(hopital == "1") $('#hopital',myModal).prop('checked', true); else $('#hopital',myModal).prop('checked', false);   
//      	$('#date_etats',myModal).val(date_etats);
// 		if (status == "Arrété" )
//      		$("#status").append("<option value='Reprise'>Reprise</option>");
//      		else
//      			$("#status").append("<option value='Arrété'>Arrété</option>");
// 	     $('.up_traitement',myModal).attr('action' ,'/patient/traitement_chronique/'+ligne_id);  
// 	     //remplir le tableau sur l'historique de prise du médicament
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			data : {medicament_dci_id : medicament_dci_id },
// 			datatype : 'json',
// 			success : function (data) {
// 				var stat;
// 				$('#example12>tbody',myModal).empty();
// 				 $.each(data ,function(i,value) {
// 				 	if (data[i].status_hopital === '1') { stat = 'V'} else stat = 'H'
// 					$('#example12>tbody',myModal).append("<tr><td>" + data[i].dose_matin + " " + data[i].repas_matin + "</td><td>" + data[i].dose_midi + " " + data[i].repas_midi + "</td><td>"+data[i].dose_soir + " "+data[i].repas_soir + "</td><td>" + data[i].dose_avant_coucher + "</td><td>" + data[i].unite + "</td><td>Dr." + data[i].medecin_externe + "</td><td> "+data[i].etats + " </td><td>"+data[i].date_etats + " </td><td>"+stat+"</td></tr>");
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 	      //and finally show the modal
// 	     myModal.modal({ show: true });
// 	 });
// 	     	$('#tableAddMedicamenttrait>tbody').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove(); });
// 	 //**************************************************************************************************************************//
// 	//******************************^^*****^^*****************************// 
// 	// Automedication / prescription ponctuelle  :
// 	// Ajouter des lignes automedications
// 	// Set fields to update modal's
// 	//******************************^^*****^^**************************************// 
// 	$("#tableAddMedicamentauto>tbody").on('click','#add_auto',function(){
// 			$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>unité</option> <option>comprimé</option> </select> </td> <td><input type='hidden' name='status_hopital[]' value='0'><input type='checkbox' onclick='this.previousSibling.value=1-this.previousSibling.value'</td> <td> <input type='date' class='form-control' name='date_etats[]'> </td><td> <button type='button' class='btn btn-info btn-flat' id='add_ضعفخ'>+</button> </td></tr>");
// 			$(this).remove();
// 	});
// 	 $('.edit_auto').on('click', function() {
// 	     var myModal = $('#modal_update_auto');
// 	     var ligne_id = $(this).attr('id');  //get bilan ID
// 	      //now get the values from the table
// 	    	 var medicament_dci_id = $(this).closest('tr').find('th:eq(0)').attr('value');
// 	    	 var dose_matin = $(this).closest('tr').find('td:eq(0)').attr('value');
// 	    	 var repas_matin = $(this).closest('tr').find('td:eq(0)').attr('value1');
// 	    	 var dose_midis = $(this).closest('tr').find('td:eq(1)').attr('value');
// 	    	 var repas_midis = $(this).closest('tr').find('td:eq(1)').attr('value1');
// 	    	 var dose_soir = $(this).closest('tr').find('td:eq(2)').attr('value');
// 	    	 var repas_soir = $(this).closest('tr').find('td:eq(2)').attr('value1');
// 	    	 var dose_avant_coucher = $(this).closest('tr').find('td:eq(3)').attr('value');
// 	    	 var unite = $(this).closest('tr').find('td:eq(4)').attr('value');
// 	    	 var medecin_externe = $(this).closest('tr').find('td:eq(5)').attr('value');
// 	    	 var status = $(this).closest('tr').find('td:eq(6)').attr('value');
// 	    	 var date_etats = $(this).closest('tr').find('td:eq(7)').attr('value');
// 	    	 var hopital = $(this).closest('tr').find('td:eq(8)').attr('value');
// 	      //and set them in the modal:
// 	     $('h4' ,myModal).html("Modifier médicament : "+medicament_dci_id);
// 	     $('h2' ,myModal).html("Historique du médicament :"+medicament_dci_id);
// 	     $('#medecin_externe',myModal).val(medecin_externe);
// 	     $('#medicament_dci_id',myModal).val(medicament_dci_id);
// 	     $('#dose_matin',myModal).val(dose_matin);
// 	     $('#dose_midis',myModal).val(dose_midis);
// 	     $('#dose_soir',myModal).val(dose_soir);
// 	     $('#dose_avant_coucher',myModal).val(dose_avant_coucher);
// 	     $('#unite',myModal).val(unite).is(':selected'); 
// 	     $('#repas_matin',myModal).val(repas_matin).is(':selected'); 
// 	     $('#repas_soir',myModal).val(repas_soir).is(':selected'); 
// 	     $('#repas_midis',myModal).val(repas_midis).is(':selected'); 
// 		 if(hopital == "1") $('#hopital1',myModal).prop('checked', true); else $('#hopital1',myModal).prop('checked', false);   
//      	$('#date_etats',myModal).val(date_etats);
// 				if (status == "Arrété" )
//      		$("#status",myModal).append("<option value='Reprise'>Reprise</option>");
//      		else
//      			$("#status",myModal).append("<option value='Arrété'>Arrété</option>");
// 	     $('.up_auto',myModal).attr('action' ,'/patient/automedication/'+ligne_id);  
// 	     $.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			data : {medicament_dci_id_auto : medicament_dci_id},
// 			datatype : 'json',
// 			success : function (data) {
// 				var stat;
// 				$('#example112>tbody',myModal).empty();
// 				 $.each(data ,function(i,value) {
// 				 	if (data[i].status_hopital === '1') { stat = 'V'} else stat = 'H'
// 					$('#example112>tbody',myModal).append("<tr><td>" + data[i].dose_matin + " " + data[i].repas_matin + "</td><td>" + data[i].dose_midi + " " + data[i].repas_midi + "</td><td>"+data[i].dose_soir + " "+data[i].repas_soir + "</td><td>" + data[i].dose_avant_coucher + "</td><td>" + data[i].unite + "</td><td>Dr." + data[i].medecin_externe + "</td><td> "+data[i].etats + " </td><td>"+data[i].date_etats + " </td><td>"+stat+"</td></tr>");
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 	      //and finally show the modal
// 	     myModal.modal({ show: true });
// 	 });
// 	 //**************************************************************************************************************************//
// 	//******************************^^*****^^*****************************// 
// 	// Analyse biologique :
// 	// Ajouter des lignes bilans
// 	// Affectation des champs pour la modification
// 	//fonction d'affichage des fichiers médias
// 	//******************************^^*****^^**************************************// 
// 	$("#add_bilan").click(function(){
// 		for(i =0 ; i< $("#rd").val() ;i++) {
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			data : {someData : '1' },
// 			datatype : 'json',
// 			success : function (data) {
// 				var option = "<option></option>";
// 				$.each(data ,function(key , value){
// 					option+="<option value="+data[key].bilan+">"+data[key].bilan+"</option>"
// 				});
// 			$("#bilans>tbody").prepend("<tr> <td> <select class='form form-control bilan' name='typeBilans[]'>"+option+"</td> <td> <select class='form form-control element' name='typeElements[]'></td> <td><input type='text' class='form form-control' name='valeurs[]'></td> <td style='font-weight: bolder;'> <select class='form form-control unite' name='unites[]'> </select> </td> <td><input type='date' class='date_analyses form form-control' name='date_analyses[]' /></td> <td><input type='text' class='form form-control lab' placeholder='laboratoire' name='laboratoires[]'/></td> <td><input type='text' class='form form-control' placeholder='Commentaire' name='commentaires[]'/></td> <td><input type='file' class='form-control' name='fichiers[]' id='fichier'  accept='.jpg, .jpeg, .png, .mp3, .mp4 ,.flv'></td><td><i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i></td> </tr>");					
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 		}
// 		});
// 	$('tbody').on('change','.bilan',function(){
// 		var bilan = $(this).val(); //récupérer le bilan selectionné
// 		if ($(this).val() == "")  {
// 			$(this).parent().next().children('select').empty();
// 			return true;
// 		}
// 			$(this).parent().next().children('select').empty();
// 		var option ="<option></option>";
// 		function callback(response) {
// 				 $.each(response ,function(i,value) {
// 					option+="<option value=" + response[i].element + ">" + response[i].element + "</option>";
// 				});
//   //use return_first variable here
// }
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			'async': false,
// 			data : {bilan : bilan },
// 			datatype : 'json',
// 			success : function (data) {
// 				callback(data);
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 		$(this).parent().next().children('select').append(option);
// 	});
// 	$('tbody').on('change','.element',function(){
// 		var element = $(this).val(); //récupérer le bilan selectionné
// 		if ($(this).val() == "")  {
// 			$(this).parent().next().next().children('select').empty();
// 			return true;
// 		}
// 		$(this).parent().next().next().children('select').empty();
// 		var option ="";
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			'async': false,
// 			data : {element : element },
// 			datatype : 'json',
// 			success : function (data) {
// 				 $.each(data ,function(i,value) {
// 					option+="<option value=" + data[i].id + ">" + data[i].unite + "</option>";
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 		$(this).parent().next().next().children('select').append(option);
// 	});	
// 			//function to edit biological analysis row and show in the modal
// 	$('.edit_bilan').on('click', function() {
// 	    var myModal = $('#modal_detail_analyse');
// 	    var bilan_id = $(this).attr('id'); // get bilan ID
// 	    // now get the values from the table
// 	   	 var bilan = $(this).closest('tr').find('th:eq(0)').attr('value');
// 	   	 var element = $(this).closest('tr').find('th:eq(1)').attr('value');
// 	   	 var valeur = $(this).closest('tr').find('td:eq(0)').attr('value');
// 	   	 var date_analyse = $(this).closest('tr').find('td:eq(4)').attr('value');
// 	   	 var laboratoire = $(this).closest('tr').find('td:eq(6)').attr('value');
// 	   	 var commentaire = $(this).closest('tr').find('td:eq(7)').attr('value');
// 	    // and set them in the modal:
// 	    $('#bilan' ,myModal).val(bilan).is(':selected');
// 	    $('#element',myModal).val(element).is(':selected');
// 	    $('#valeur',myModal).val(valeur);
// 	    $('#date_analyse',myModal).val(date_analyse);
// 	    $('#laboratoire',myModal).val(laboratoire);
// 	    $('#commentaire',myModal).val(commentaire);    
// 	    $('.up_bilan',myModal).attr('action' ,'/patient/bilan/'+bilan_id);    
// 	    // and finally show the modal
// 	    myModal.modal({ show: true });
//     });
//     //Function to show modal media
//     $('.media').click(function(){
//     	var id = $(this).parent().attr('value');
//     	 console.log(id);
//     	$("#modal_media img").attr('src','/images/'+id+'.jpg');
//     	var myModal = $("#modal_media");	
//     	myModal.modal({ show: true });
//     });
//     $("#labo_gen").keyup(function(){
//     	var valeur = $("#labo_gen").val();
//     	console.log(valeur);
//     	$('.lab').val(valeur);
//     });
//     	$('#bilans').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove();
// 	});
// 	//**************************************************************************************************************************//
// 	//******************************^^*****^^*****************************// 
// 	// Produit alimentaire et phytotherapie :
// 	// Ajouter des lignes prescriptions
// 	// Affichage de la page de confirmation
// 	// Envoi du formulaire au serveur HTTP , la méthode :POST
// 	//******************************^^*****^^**************************************// 
// 	$("tbody").on('change','.frequence',function(){
// 			if($(this).val() == "Depuis :")
// 				$(this).parent().next().children('input').show();
// 		else $(" this.frequence_date").hide();
// 	});
// 	$("#add_produit").click(function(){
// 		$(this).closest('tbody').prepend("<tr><td><input type='hidden' class='pr_hidden' name='produitalimentaire_id[]'><input type='text' class='pr_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'><input type='text' class='ar_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'> <select class='form form-control frequence' name='frequence[]' > <option>Occasionnellement</option> <option>Exceptionnellement</option> <option>Depuis :</option> </select> </td> <td><input type='date' class='form-control frequence_date'  name='frequence_date[]' style='display: none;' /></td></tr>");
// 			});
// 	// console.log($(this).val());
// 	var options = {
// 			  url: function(phrase) {
// 			    return "/patient/produit/"+ phrase; // url to send into server
// 			  },
// 			  getValue: "produit_naturel_fr",
// 			  ajaxSettings: { // d'ont touch and mmodify
// 				  	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 				    dataType: "json",
// 				    method: "POST",
// 				    data: {
// 				      dataType: "json"
// 				    }
// 			  },
// 			  preparePostData: function(data) {
// 			    data.phrase = $('.pr_input').val(); // returned data from server , json format
// 			    return data;
// 			  },
// 			  list : {
// 			  	onSelectItemEvent : function () {
// 			  		var value = $('.pr_input').getSelectedItemData().id;
// 			  		$(".pr_hidden").val(value).trigger("change");
// 			  	}
// 			  }
// 			  // requestDelay: 10000 // delays for response serve
// 			};
// 	$('.pr_input').easyAutocomplete(options);
// 	$('#modal_phyto').on('blur','.pr_input',function(){
// 		var valeur = $ (this).val();
// 		console.log(valeur);
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/patient/produit/'+valeur,
// 			method :'POST',
// 			// data : {phrase : valeur },
// 			datatype : 'json',
// 			success : function (data) {
// 					if (data.length == "0") {
// 						$(this.element).val("Erreur !!!!").css('border-color','red');
// 						$(this.element).val(""); 
// 					}
// 			},
// 			error:function (jqXHR, textStatus) {
// 				 $('.pr_input').val("");
// 				console.log( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 	});
// 	//**************************************************************************************************************************//
// 	//******************************^^*****^^*****************************// 
// 	// Prescription :
// 	// Ajouter des lignes prescriptions
// 	// Affichage de la page de confirmation
// 	// Envoi du formulaire au serveur HTTP , la méthode :POST
// 	// Button to delete row
// 	//******************************^^*****^^**************************************// 
// 	$("#tablePrescription>tbody").on('click','#add_prescription',function(){
// 		$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><select class='form form-control' name='voie[]'><option>IM</option><option>IV</option></select></td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]' value='0'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>gellule</option> <option>comprimé</option> </select> </td> <td> <input type='text' class='form-control' name='nbr_jours[]' value='0'> </td> <td> <button type='button' class='btn btn-info btn-flat' id='add_prescription'>+</button> </td> </tr>");
// 		 $(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>");
// 	});	
// 	// Affichage de la page de confirmation	
// 	$(".confirmer").click(function(){
// 		//test if display table is show , submit form so
// 		 if ($('#modal_display').is(':visible')) {
// 			$('#target').submit();
// 			event.preventDefault();
// 		 } 
// 		 else {
// 				var medicament_dci = []; var voie = []; var dose_matin = []; var repas_matin = []; var dose_midi = []; var repas_midi = []; var dose_soir = []; var repas_soir = []; var dose_avant_coucher = []; var unite = []; var jours = [];
// 				$('#tablePrescription > tbody > tr').each(function(){
// 					medicament_dci.push($(this).find('td:eq(1) > input').val());
// 					voie.push($(this).find('td:eq(2) > select option:selected').val())
// 					dose_matin.push($(this).find('td:eq(3) > input').val());
// 					repas_matin.push($(this).find('td:eq(4) > select option:selected').val());
// 					dose_midi.push($(this).find('td:eq(5) > input').val());
// 					repas_midi.push($(this).find('td:eq(6) > select option:selected').val());
// 					dose_soir.push($(this).find('td:eq(7) > input').val());
// 					repas_soir.push($(this).find('td:eq(8) > select option:selected').val());
// 					dose_avant_coucher.push($(this).find('td:eq(9) > input').val());
// 					unite.push($(this).find('td:eq(10) > select option:selected').val());
// 					jours.push($(this).find('td:eq(11) > input').val());
// 				});
// 					 console.log(repas_matin);
// 				//affect inputs  to table
// 				for (var i = 0; i < medicament_dci.length; i++) 
// 					$(".display > tbody").append("<tr>"+
// 													"<td>"+medicament_dci[i]+"</td>"+
// 													"<td>"+voie[i]+"</td>"+
// 													"<td>"+dose_matin[i]+" "+repas_matin[i]+"</td>"+
// 													"<td>"+dose_midi[i]+" "+repas_midi[i]+"</td>"+
// 													"<td>"+dose_soir[i]+" "+repas_soir[i]+"</td>"+
// 													"<td>"+dose_avant_coucher[i]+"</td>"+
// 													"<td>"+unite[i]+"</td>"+
// 													"<td>"+jours[i]+" j</td>"+
// 												"</tr>");
// 				//show Modal
// 				$("#modal_display").modal({ show: true });
// 		 	}
// 	});
// 	//function to delete row
// 	$('#tablePrescription').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove();
// 	});
// 	//******************************^^*****^^*****************************// 
// 	// Consultation :
// 	// Ajouter des lignes consultation
// 	// Affichage de la page de confirmation
// 	// Envoi du formulaire au serveur HTTP , la méthode :POST
// 	// Button to delete row
// 	//******************************^^*****^^**************************************// 
// 	$("#tableConsultation>tbody").on('click','#add_consultation',function(){
// 		$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><select class='form form-control' name='voie[]'><option>IM</option><option>IV</option></select></td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]' value='0'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>gellule</option> <option>comprimé</option> </select> </td> <td> <input type='text' class='form-control' name='nbr_jours[]' value='0'> </td> <td> <button type='button' class='btn btn-info btn-flat' id='add_consultation'>+</button> </td> </tr>");
// 		 $(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>");
// 	});	
// 	// Affichage de la page de confirmation	
// 	$(".confirmer").click(function(){
// 		//test if display table is show , submit form so
// 		 if ($('#modal_display_consultation').is(':visible')) {
// 			$('#target_consultation').submit();
// 			event.preventDefault();
// 		 } 
// 		 else {
// 				var medicament_dci = []; var voie = []; var dose_matin = []; var repas_matin = []; var dose_midi = []; var repas_midi = []; var dose_soir = []; var repas_soir = []; var dose_avant_coucher = []; var unite = []; var jours = [];
// 				$('#tableConsultation > tbody > tr').each(function(){
// 					medicament_dci.push($(this).find('td:eq(1) > input').val());
// 					voie.push($(this).find('td:eq(2) > select option:selected').val())
// 					dose_matin.push($(this).find('td:eq(3) > input').val());
// 					repas_matin.push($(this).find('td:eq(4) > select option:selected').val());
// 					dose_midi.push($(this).find('td:eq(5) > input').val());
// 					repas_midi.push($(this).find('td:eq(6) > select option:selected').val());
// 					dose_soir.push($(this).find('td:eq(7) > input').val());
// 					repas_soir.push($(this).find('td:eq(8) > select option:selected').val());
// 					dose_avant_coucher.push($(this).find('td:eq(9) > input').val());
// 					unite.push($(this).find('td:eq(10) > select option:selected').val());
// 					jours.push($(this).find('td:eq(11) > input').val());
// 				});
// 					 console.log(repas_matin);
// 				//affect inputs  to table
// 				for (var i = 0; i < medicament_dci.length; i++) 
// 					$(".display_cons > tbody").append("<tr>"+
// 													"<td>"+medicament_dci[i]+"</td>"+
// 													"<td>"+voie[i]+"</td>"+
// 													"<td>"+dose_matin[i]+" "+repas_matin[i]+"</td>"+
// 													"<td>"+dose_midi[i]+" "+repas_midi[i]+"</td>"+
// 													"<td>"+dose_soir[i]+" "+repas_soir[i]+"</td>"+
// 													"<td>"+dose_avant_coucher[i]+"</td>"+
// 													"<td>"+unite[i]+"</td>"+
// 													"<td>"+jours[i]+" j</td>"+
// 												"</tr>");
// 				//show Modal
// 				$("#modal_display_consultation").modal({ show: true });
// 		 	}
// 	});
// 	//function to delete row
// 	$('#tableConsultation').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove();
// 	});
// 	//******************************^^*****^^*****************************// 
// 	// Patient :
// 	// retourner les inforamtions sur le patient et l'afficher sur le modal  à modifier
// 	//******************************^^*****^^**************************************// 
// 	$(".up_patient").click(function(){
// 		var patient_id = $(this).attr('data');
// 		console.log(patient_id);
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/api/patient/getPatient/'+patient_id,
// 			method :'POST',
// 			datatype : 'json',
// 			success : function (data) {
// 				$("#num_securite_sociale").val(data[0].num_securite_sociale);				
// 				$("#nom").val(data[0].nom);				
// 				$("#prenom").val(data[0].prenom);				
// 				$("#date_naissance").val(data[0].date_naissance);				
// 				$("#sexe").val(data[0].sexe).is(':selected');				
// 				$("#adresse").val(data[0].adresse);				
// 				$("#ville").val(data[0].ville);				
// 				$("#commune").val(data[0].commune);				
// 				$("#taille").val(data[0].taille);				
// 				$("#poids").val(data[0].poids);				
// 				$("#situation_familliale").val(data[0].situation_familliale).is(':selected'); if (data[0].situation_familliale == "Marié(e)") {$("#nbre").val(data[0].nbre_enfants) ;$("#nbre_enfants").show(); }			
// 				if (data[0].travaille == "Retraité" || data[0].travaille == "Universitaire")
// 					{
// 						$("#travaille").val(data[0].travaille).is(':selected');
// 						$("#travaille1").val(data[0].travaille);
// 					} 
// 					else { $("#travaille1").val(data[0].travaille);  $("#autre").show(); }
// 				if(data[0].tabagiste == "on") { $("#tabac").prop('checked' , true); $("#tabac1").val(data[0].tabagiste_depuis); $(".tabac").show(); }				
// 				if(data[0].alcoolique == "on") { $("#alcool").prop('checked' , true); $("#alcool1").val(data[0].alcoolique_depuis); $(".alcool").show(); }				
// 				if(data[0].drogue == "on") { $("#drogue").prop('checked' , true); $("#drogue1").val(data[0].drogue_depuis); $("#type_dr").val(data[0].details); $(".drogue").show(); }	
// 				$("#num_tel_1").val(data[0].num_tel_1);	
// 				$("#num_tel_2").val(data[0].num_tel_2);	
// 				$("#num_dossier").val(data[0].num_dossier);	
// 				$.each(data[1] , function ( i , val) {
// 					$("#date_admission").val(val.date_admission);	
// 					$("#chambre").val(val.chambre);	
// 					$("#lit").val(val.lit);	
// 					console.log(val.service);
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {
// 				console.log( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		})
// 	});
//         //Show number of children input's when the situation is married
//         $("#situation_familliale").change(function(){
//             if ($(this).val() == "Marié(e)") {
//                 $("#nbre_enfants").show();
//             } else $("#nbre_enfants").hide();
//         });
//         //Show other works input's 
//         $("#travaille").change(function(){
//             if ($(this).val() == "autre") {
//                 $("#autre").show();
//             } else $("#autre").hide();
//         });
//         $("#tabac").change(function(){
//             if ($(this).is(":checked")) {
//                 $(".tabac").show();
//             } else{
//             	$("#tabac1").val("");
//             	 $(".tabac").hide();
//             }
//         });
//         $("#alcool").change(function(){
//             if ($(this).is(":checked")) {
//                 $(".alcool").show();
//             } else{
//             	$("#alcool1").val("");
//             	$(".alcool").hide();
//             } 
//         });
//                 $("#drogue").change(function(){
//             if ($(this).is(":checked")) {
//                 $(".drogue").show();
//             } else{
//             	$("#drogue1").val("");
//             	$(".drogue").hide();
//             } 
//         });
//                 $("#travaille").change(function(){
//                 	var valeur = $(this).val();
//                 	$("#travaille1").val(valeur);
//                 });
// 	// var options1 = {
// 	// 			  url: function(phrase1) {
// 	// 			    return "/patient/produit_ar/"+ phrase1; // url to send into server
// 	// 			  },
// 	// 			  getValue: "produits_arabe",
// 	// 			  ajaxSettings: { // d'ont touch and mmodify
// 	// 				  	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 	// 				    dataType: "json",
// 	// 				    method: "POST",
// 	// 				    data: {
// 	// 				      dataType: "json"
// 	// 				    }
// 	// 			  },
// 	// 			  preparePostData: function(data) {
// 	// 			    data.phrase = $(".pr_inputt").val(); // returned data before sedn to server
// 	// 			    return data;
// 	// 			  },
// 	// 			  // requestDelay: 10000 // delays for response serve
// 	// 			  list: {
// 	// 						onSelectItemEvent: function() {
// 	// 							var produit_fr = $("#function-index").getSelectedItemIndex();
// 	// 							$(".pr_input").val(produit_fr).trigger("change");
// 	// 						}
// 	// 					};
// 	// $(".ar_input").easyAutocomplete(options1);
// });

jQuery(function () {
  $('input[id="maladie_nom"]').keydown(function () {
    $(this).autocomplete({
      appendTo: $(this).parent(),
      // selectionner l'element pour ajouter la liste des suggestion
      source: function source(request, response) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/maladie",
          method: "POST",
          data: {
            phrase: request.term // value on field input

          },
          success: function success(data, status, code) {
            response($.map(data.slice(0, 20), function (item) {
              // slice cut number of element to show
              return {
                label: item.pathologie,
                // pour afficher dans la liste des suggestions
                value: item.pathologie,
                // value c la valeur à mettre dans l'input this
                id_pathologie: item.id
              };
            }));
          }
        });
      },
      // END SOURCE
      select: function select(event, ui) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/protocolesPathologie",
          method: "POST",
          data: {
            maladie_id: ui.item.id_pathologie
          },
          success: function success(data, status, code) {
            console.log(data);
            $("#protocole_presc").empty();
            data.forEach(function (d) {
              $("#protocole_presc").append("<option value=" + d.id + ">" + d.nom + "</option>");
            });
          },
          error: function error(_error) {
            console.log(_error);
          }
        });
        $("#maladie_id").attr("value", ui.item.id_pathologie);
      }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
      //cette method permet de gérer l'affichage de la liste des suggestions
      return $("<li></li>").data("item.autocomplete", item) //récupérer les donnée de l'autocomplete
      //.attr( "data-value", item.id )
      .append(item.label) //ajouter à la liste de suggestions
      .appendTo(ul);
    };
  });
  $('#tablist a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
  }); // Animate loader off screen

  $(".se-pre-con").fadeOut("slow");
  $(".fold-table tr.view").on("click", function () {
    $(this).toggleClass("open").next(".fold").toggleClass("open");
  });
  $('input[type="checkbox"].flat-green').iCheck({
    checkboxClass: 'icheckbox_flat-green'
  });
  $but = $('table').find('a.deleteRow');
  $but.click(function (e) {
    e.stopPropagation();
  }); //redirect to specific tab 

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $.fn.dataTable.tables({
      visible: true,
      api: true
    }).columns.adjust();
  });
  $("#tab_trait").DataTable({
    "scrollX": true,
    "scrollY": "400px",
    "scrollCollapse": true,
    "paging": false
  });
  $("#example7").DataTable({
    "scrollX": true,
    "scrollY": "400px",
    "scrollCollapse": true
  });
  $("#tabtous").DataTable({
    "order": [[4, "asc"], [3, "desc"]],
    "scrollX": true,
    "scrollY": "400px",
    "scrollCollapse": true,
    "paging": false
  });
  $("#example3").DataTable({
    "order": [[7, "desc"]],
    "scrollX": true,
    "scrollY": "400px",
    "scrollCollapse": true,
    "paging": false
  }); //analyse biologique

  $("#example17").DataTable({
    "order": [[2, "desc"]],
    "scrollY": "400px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false
  }); //Historique poids

  $("#hist_presc").DataTable({
    "ordering": false // "order": [
    // 	[1, "desc"]
    // ],
    // "scrollX": true,
    // "scrollY": "400px",
    // "scrollCollapse": true,
    // "paging": false

  }); //historique prescriptions

  $("#example127").DataTable({
    "ordering": false
  }); //Prescription			

  $("#example4").DataTable({
    "paging": true
  }); //traitement

  $("#example6").DataTable({
    "scrollX": true
  }); //auto

  $("#example8").DataTable({
    "scrollY": "400px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false
  }); //phyto

  $("#example9").DataTable({
    "scrollY": "400px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false
  }); //avis

  $("#example21").DataTable({
    "scrollX": true,
    "scrollY": "400px",
    "scrollCollapse": true,
    "paging": false
  }); //questionnaire

  $("#example211").DataTable({
    "scrollX": true,
    "scrollY": "400px",
    "scrollCollapse": true,
    "paging": false
  }); //Education Therapeutique

  $("#exemple16").DataTable({
    "scrollY": "400px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false
  });
  $("#table_hospitalisation").DataTable({
    "scrollY": "400px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false
  });
  $("#table_consultation").DataTable();
  $("#table_act").DataTable({
    "scrollY": "400px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false
  });
  $("#example10").DataTable({
    "scrollY": "400px",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false
  });

  function lastState() {
    // set the last state of display profile patient
    if (getCookie("profileShown") == "yes") {
      // show widget profile display
      showWidgetProfile();
    } else {
      //show table profile display
      showTableProfile();
    }
  }

  lastState();
  $('button.closes').click(function () {
    if ($('#desc').hasClass('col-md-12')) {
      // show profile display
      showWidgetProfile();
      setCookie("profileShown", "yes", 43200); // Set state (expire in 30 days)
    } else {
      showTableProfile();
      setCookie("profileShown", "no", 43200); // Set state (expire in 30 days)
    }
  });

  function showTableProfile() {
    $('#profile').fadeOut(100, function () {
      // show table display
      $("#desc").toggleClass("col-md-9", function () {
        $("#desc").addClass("col-md-12").removeAttr('style');
        $('#par').fadeIn(100);
        $('#list').hide();
        $("a [href='#tab_9']").hide();
        $("a [href='#tab_7']").hide();
      });
    });
  }

  function showWidgetProfile() {
    $('#profile').fadeIn(function () {
      $("#desc").toggleClass("col-md-12", function () {
        $(this).addClass("col-md-9").attr("style", "padding-left:0px;");
        $('#par').fadeOut(300);
        $('#list').show();
        $('a [href="#tab_9"]').removeAttr('style');
        $('a [href="#tab_7"]').removeAttr('style');
      });
    });
  } // COOKIES DEFINITION //


  function setCookie(name, value, mins) {
    var expires = "";

    if (mins) {
      var date = new Date();
      date.setTime(date.getTime() + mins * 60 * 1000);
      expires = "; expires=" + date.toGMTString();
    } else expires = "";

    document.cookie = name + "=" + value + expires + "; path=/";
  }

  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');

    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];

      while (c.charAt(0) == ' ') {
        c = c.substring(1, c.length);
      }

      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }

    return null;
  } // END COOKIES DEFINITION //

  /*Supprimer la ligne Traitement / Automédication / Prescription */


  $("a.deleteRow").on('click', function (event) {
    var _this3 = this;

    if (confirm('Vous confirmer votre action sur cette ligne ?')) {
      var url = $(this).data('url');
      event.preventDefault();
      $.ajax({
        url: url,
        type: 'POST',
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }).done(function (response) {
        if (response.response == 'success') {
          $(_this3).closest('tr').remove();
          toastr.success(response.msg);
        } else toastr.error(response);
      });
    }
  });
});
$(function () {
  //******************************^^*****^^*****************************// 
  // Intervention pharmaceutique :
  // Afficher les alertes analyse pharmaceutique.
  // Afficher le tableau d'interventipn pharmaceutique
  //******************************^^*****^^**************************************// 
  var levels = [{
    'key': 1,
    'value': 'Problème majeure'
  }, {
    'key': 2,
    'value': 'Problème modéré'
  }, {
    'key': 3,
    'value': 'Problème mineur'
  }];

  function createLevels() {
    var options = "<option value=''></option>";
    levels.forEach(function (level) {
      options += "<option value='".concat(level.key, "'>").concat(level.value, "</option>");
    });
    return options;
  }

  var options = createLevels();
  /**
   * 
   * Lunch the processus of pharmaceutical analysis
   */

  $('#analyseBtn').on('click', function () {
    // Lancement du traitement Analyse Pharmaceutique , et affichage des alertes
    var myModal = $('#modal_analyse_pharm');
    $('.analyse_table > tbody').empty();
    $('.analyse_table_interne > tbody').empty();
    var patient_id = $(this).data('id');
    var presc_id = $(this).data('risque');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/patient/' + patient_id + '&' + presc_id + '/analysePharmaceutique',
      method: 'get',
      datatype: 'html',
      success: function success(data) {
        $.ajax({
          type: "POST",
          url: '/js/php/save_alerte_json.php',
          data: {
            data: JSON.stringify(data[0])
          }
        }); // stockage du resultat dans un fichier

        $("input[name='presc_id']", myModal).val(data.presc_id);
        $.each(data[0], function (i, value) {
          problemes_select = "<select class='form-control select2 select2-hidden-accessible' style='width: 100%;' multiple='multiple'data-placeholder='Problèmes'  tabindex='-1' aria-hidden='true' name='problemes[" + value.medicament + "][]'> <option>Non conformité aux référentiel ou Contre indication</option> <option>Indication non traitée</option> <option>Sous dosage</option> <option>Surdosage</option> <option>Médicament non indiqué</option> <option>Interaction : A prendre en compte</option> <option>Interaction : Précaution d’emploi</option> <option>Interaction : Association déconseillée</option> <option>Interaction : Association contre-indiquée</option> <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS )  </option> <option>Voie et/ou administration inappropiée</option> <option>traitement non reçu</option> <option>Monitorage à suivre</option></select>";
          $reds = value.alertes.redondance;
          $iams = value.alertes.interaction;
          $pes = value.alertes.Precaution_emploi;
          $sur = value.alertes.Surdosage;
          $ial = value.alertes.interaction_alimentaire;
          $cia = value.alertes.contre_indication;
          $red_tmp = "";
          $iam_tmp = "";
          $phrase = "";
          $iam_phrase = "";
          $red_phrase = "";

          if ($reds != "") {
            $.each($reds, function (j, red) {
              $red_tmp += red.nom_sac_redondant;
            });
            $red_phrase = "<b>Redondance</b> : " + $red_tmp;
          }

          if ($iams != "") {
            $.each($iams, function (j, iam) {
              $iam_tmp += iam.item_sac_2;
            });
            $iam_phrase = '<b>Interaction :</b> ' + $iam_tmp;
          }

          if ($iam_phrase != "" || $red_phrase != "") {
            $phrase = $iam_phrase + ($iam_phrase != "" ? '<br/>' : '') + $red_phrase;
          }

          if ($reds != "" || $iams != "" || $pes != "" || $sur != "" || $ial != null || $cia != "") $back = "class='bg-red'"; // background color red
          else $back = "";
          $('.analyse_table > tbody').append("\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<select class=\"form-control\" name=\"prob_lvl[]\">\n\t\t\t\t\t\t\t\t\t".concat(options, "\n\t\t\t\t\t\t\t\t</select>\n\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t<td  ").concat($back, " style='white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:250px;' title='").concat(value.dci, "'> \n\t\t\t\t\t\t\t\t<input type='hidden' value='").concat(value.dci, "' name='med_sp[]'/>\n\t\t\t\t\t\t\t\t<input type='hidden' value='").concat(value.medicament, "' name='med_sp_id[]'/>\n\t\t\t\t\t\t\t\t<input type='hidden' value='").concat(encodeURI($phrase), "' name='med_sp_1[]'/>  \n\t\t\t\t\t\t\t\t").concat(value.dci, "  \n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<button type='button' class='btn btn-primary alerte_btn' data-id='").concat(value.medicament, "'> D\xE9tails </button>\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td>").concat(problemes_select, "</td> \n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<input type='text' class='form-control' name='comment_prob[]' placeholder='commentraire '/>\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<select class='form-control' name='ip[]'>\n\t\t\t\t\t\t\t\t\t<option></option> \n\t\t\t\t\t\t\t\t\t<option>Ajout (prescription nouvelle)</option> \n\t\t\t\t\t\t\t\t\t<option>Arr\xE9t</option> <option>Substitution/\xE9change</option> \n\t\t\t\t\t\t\t\t\t<option>Choix de la voie d'adminitration</option> \n\t\t\t\t\t\t\t\t\t<option>Suivie th\xE9rapeutique</option> \n\t\t\t\t\t\t\t\t\t<option>Optimisation des modalit\xE9s d'administration</option>\n\t\t\t\t\t\t\t\t\t<option>Adapatation posologique</option> \n\t\t\t\t\t\t\t\t</select>\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<input type='text' class='form-control' name='comment_ip[]' placeholder='commentraire '/>\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t</tr"));
          $('.select2').select2(); // pour afficher select2
        }); //and finally show the modal

        myModal.modal({
          show: true
        });
      },
      error: function error(jqXHR, textStatus) {
        alert("Erreur Serveur: " + textStatus + " " + jqXHR);
      }
    });
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/patient/' + patient_id + '&' + presc_id + '/pre_analyse_interne',
      method: 'get',
      datatype: 'html',
      success: function success(data) {
        if (data.array_id.length == 0) {} else {
          console.log(data.si[$x]);

          for (var $x = 0; $x < data.array_id.length; $x++) {
            console.log(data.si[$x]);
            $('.analyse_table_interne > tbody').append("<tr>" + "<td> " + data.si[$x] + "</td>" + //"<td><button type='button' class='btn btn-primary alerte_btn' data-id='"+1+"'> Détails </button></td>"+ 
            "<td> " + data.alors[$x] + "</td>" + "<td> " + data.commentaire[$x] + "</td>" + "</tr");
          }
        }
      }
    });
  });
  /**
   * 
   * Lunch the processus of Thérapeutical analysis
   */

  $('.BTNANALYSE').on('click', function () {
    // afficher les details de l'Analyse thérapeutique 
    var myModal2 = $('#modal_analyse_therap');
    $('#div_body').empty();
    var patient_id = $(this).data('id');
    var presc_id = $(this).data('risque');
    $.ajax({
      //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
      url: '/patient/' + patient_id + '&' + presc_id + '/details_education',
      method: 'get',
      datatype: 'html',
      success: function success(data) {
        if (data.si.length == 0) {} else {
          $('#div_body').append("<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#si' aria-expanded='true' aria-controls='si'>" + "Si :" + "</a>" + "</h4>" + "</div>" + "<div id='si' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.si + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#titre' aria-expanded='true' aria-controls='titre'>" + "Titre :" + "</a>" + "</h4>" + "</div>" + "<div id='titre' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.titre + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#maladie' aria-expanded='true' aria-controls='maladie'>" + "Maladie :" + "</a>" + "</h4>" + "</div>" + "<div id='maladie' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.maladie + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#effet' aria-expanded='true' aria-controls='effet'>" + "Effet :" + "</a>" + "</h4>" + "</div>" + "<div id='effet' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.effet + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#voyage' aria-expanded='true' aria-controls='voyage'>" + "Voyage :" + "</a>" + "</h4>" + "</div>" + "<div id='voyage' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.voyage + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#act' aria-expanded='true' aria-controls='act'>" + "Act :" + "</a>" + "</h4>" + "</div>" + "<div id='act' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.act + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#utilisation' aria-expanded='true' aria-controls='utilisation'>" + "Utilisation :" + "</a>" + "</h4>" + "</div>" + "<div id='utilisation' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.utilisation + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#effet_indiserable' aria-expanded='true' aria-controls='effet_indiserable'>" + "Effet indésirable :" + "</a>" + "</h4>" + "</div>" + "<div id='effet_indiserable' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.effet_indiserable + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#regime' aria-expanded='true' aria-controls='regime'>" + "Regime allimentaire :" + "</a>" + "</h4>" + "</div>" + "<div id='regime' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.regime + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#url' aria-expanded='true' aria-controls='url'>" + "URL :" + "</a>" + "</h4>" + "</div>" + "<div id='url' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body' id='urlBody'> " + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#pdff' aria-expanded='true' aria-controls='pdff'>" + "PDF :" + "</a>" + "</h4>" + "</div>" + "<div id='pdff' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body' id='pdfBody'>" + "</div>" + "</div>" + "</div>" + "</div>");

          if (data.url != "") {
            $('#urlBody').append("<a href='" + data.url + "' target='_blank'>" + "Aller sur le site" + "</a>");
          } else {
            $('#urlBody').append("Aucun site enregistré");
          }

          if (data.pdf != null) {
            $('#pdfBody').append(data.pdf + "<a href='https://ibno-sina.com/pdfs/" + data.pdf + "' target='_blank'>" + "  Ouvrir");
          } else {
            $('#pdfBody').append("Aucun pdf enregistré");
          }
        } //$('#div_body').empty(); 
        //$('#modal_analyse_therap').modal({show : true}); 


        myModal2.modal({
          show: true
        }); // console.log(myModal2.show); 
      },
      error: function error(jqXHR, textStatus) {
        alert("Erreur Serveur: " + textStatus + " " + jqXHR);
      }
    });
  });
  /**
   * Show the details of analysis of the selected medicament
   */

  $('.analyse_table > tbody').on('click', '.alerte_btn', function () {
    var myModal = $('#modal_alertes');
    var sp_id = $(this).data('id');
    var alert = "<i class='glyphicon glyphicon-alert p44' style='color: red; '></i>";
    $('#modal_alertes table > tbody').empty(); //Vider tout les tableaux du modal détails alerte					

    $('#modal_alertes').find('.p44').remove(); //Vider tout les tableaux du modal détails alerte					

    $('.alrt_med').html("");
    $.getJSON("/js/json/alerte.json", function (obj) {
      $.each(obj, function (key, value) {
        $row = "";

        if (value.medicament === sp_id) {
          $('.alrt_med').html("<h3>Médicament : " + value.dci + "</h3>");
          $.each(value.alertes.redondance, function (i, val) {
            $('.i11').append(alert);
            $item_sac_2 = val.nom_sac_redondant;
            $row = "<tr>" + "<td><b>Médicament Redondant :</b> </td>" + "<td>" + $item_sac_2 + " </td>" + "</tr>";
            $("#redondance_table").append($row);
          });
          $.each(value.alertes.contre_indication, function (i, val) {
            if (typeof val.hypersensibilité != "undefined") {
              $hyp = val.hypersensibilité;
              $row = "<tr>" + "<td><b>TERRAIN HYPERSENSIBILITE : </b></td>" + "<td>" + $hyp + " </td>" + "</tr>";
            }

            if (typeof val.pathologie != "undefined") {
              $path = val.pathologie;
              $row = "<tr>" + "<td><b>TERRAIN PATHOLOGIQUE : </b></td>" + "<td>" + $path + " </td>" + "</tr>";
            }

            if ($row != "") {
              $('.i1').append(alert);
              $('#patient_ci_table > tbody').append($row);
            }
          });
          $.each(value.alertes.interaction, function (i, val) {
            if (value.alertes.interaction.length > 0) {
              if (val instanceof Array) $.each(val, function (j, element) {
                $item_sac_int = element.item_sac_2;
                $fiche_int = element.fiche_interaction;
                $mecanisme = element.mecanisme;
                $niveau = element.niveau_inter;
                storeTableInteraction($item_sac_int, $fiche_int, $mecanisme, $niveau, alert, j);
              });else {
                $item_sac_int = val.item_sac_2;
                $fiche_int = val.fiche_interaction;
                $mecanisme = val.mecanisme;
                $niveau = val.niveau_inter;
                storeTableInteraction($item_sac_int, $fiche_int, $mecanisme, $niveau, alert, "m" + i);
              }
            }
          }); //$.each(value.alertes.Surdosage , function(i,val){

          if (Object.keys(value.alertes.Surdosage).length > 0) {
            $('.i4').append(alert);
            $profile = value.alertes.Surdosage.profile;
            $row = "<tr><td><b>Dose journalière prescrite :</b></td><td>" + value.alertes.Surdosage.dosePatient + " " + value.alertes.Surdosage.unitePatient + "</td></tr><tr>" + "<tr><td><b>Posologie maximale </b></td></tr><tr>" + "<td><b>Profile patient  : </b></td>" + "<td>" + $profile + " </td>" + "</tr><tr>" + "<td><b>Dose  : </b></td>" + "<td>" + value.alertes.Surdosage.dose + " " + value.alertes.Surdosage.unite + " </td>" + "</tr><tr>" + "<td><b>Fréquence maximale  : </b></td>" + "<td>" + (value.alertes.Surdosage.uniteFreqMax != "ADAPTER" ? value.alertes.Surdosage.freqMax + " " + value.alertes.Surdosage.uniteFreqMax : "ADAPTER") + "</td>" + "</tr><tr>" + "<td><b>Durée maximale :</b> </td>" + "<td>" + (value.alertes.Surdosage.durée != null ? value.alertes.Surdosage.durée : "ADAPTER SELON RAPPORT BENEFICE/RISQUE") + "</td>" + "</tr>";
            $('#posologie_ci_table > tbody').append($row);
          } //});


          if (value.alertes.interaction_alimentaire != null) {
            $.each(value.alertes.interaction_alimentaire, function (i, val) {
              if (val != null) {
                $produit = val.aliment;
                $type_effet = val.type_effet;
                $effet = val.effet;
                $indic = val.indication;
                $effet_pharmaco = val.effet_pharmaco;
                $recommendation = val.recommendation;
                $niveau_phyto = val.niveau;
                $row = "\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td> <strong>Produit Alimentaire</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>".concat($produit, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Type d'int\xE9raction</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($type_effet, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Effet de l'int\xE9raction</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($effet, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Indication</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($indic, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Recommendation</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($recommendation, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Effet Pharmacologique Document\xE9</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($effet_pharmaco, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\t\t"); // $row = "<tr>" +
                // 	"<td>" + $produit + " </td>" +
                // 	"<td>" + $type_effet + " </td>" +
                // 	"<td>" + $effet + " </td>" +
                // 	"<td>" + $indic + " </td>" +
                // 	"<td>" + $recommendation + " </td>" +
                // 	"<td>" + $effet_pharmaco + " </td>" +
                // 	"</tr>";

                if ($niveau_phyto === 1) {
                  $('.i3').append(alert);
                  $('#produit_ci_table > tbody').append($row);
                }

                if ($niveau_phyto === 2) {
                  $('.i7').append(alert);
                  $('#produit_ad_table > tbody').append($row);
                }

                if ($niveau_phyto === 3) {
                  $('.i10').append(alert);
                  $('#produit_pe_table > tbody').append($row);
                }
              }
            });
          }

          $.each(value.alertes.Precaution_emploi, function (i, val) {
            if (typeof val.hypersensibilité != "undefined") {
              $hyp = val.hypersensibilité;
              $row = "<tr>" + "<td>TERRAIN HYPERSENSIBILITE : </td>" + "<td>" + $hyp + " </td>" + "</tr>";
            }

            if (typeof val.pathologie != "undefined") {
              $path = val.pathologie;
              $row = "<tr>" + "<td>TERRAIN PATHOLOGIQUE : </td>" + "<td>" + $path + " </td>" + "</tr>";
            }

            if ($row != "") {
              $('.i8').append(alert);
              $('#patient_pe_table > tbody').append($row);
            }
          });
          $.each(value.alertes.Association_deconseillé, function (i, val) {
            if (typeof val.hypersensibilité != "undefined") {
              $hyp = val.hypersensibilité;
              $row = "<tr>" + "<td>TERRAIN HYPERSENSIBILITE : </td>" + "<td>" + $hyp + " </td>" + "</tr>";
            }

            if (typeof val.pathologie != "undefined") {
              $path = val.pathologie;
              $row = "<tr>" + "<td>TERRAIN PATHOLOGIQUE : </td>" + "<td>" + $path + " </td>" + "</tr>";
            }

            if ($row != "") {
              $('.i1').append(alert);
              $('#patient_ad_table > tbody').append($row);
            }
          });
          return false;
        }
      });
    });
    myModal.modal({
      show: true
    });
  });
  /**
   * Handle the accept checkbox
   * Modal : Avis sur l'IP
   */

  function onCheckIntervention() {
    var state = $(this)[0].checked;

    if (state) {
      var checkedCount = $('.execute_table > tbody  .checked ').length;
      var rowCount = $('.execute_table > tbody > tr').length;
      if (checkedCount + 1 == rowCount) $('.refus').prop('disabled', true);
    } else {
      $('.refus').prop('disabled', false);
    }
  }

  ;
  $('.execute_table > tbody').on('ifToggled', 'input', onCheckIntervention);
  /**
   * Handle the execute button on Avis sur l'IP Table
   * Populate and open the execute modal
   */

  $('.execute').on('click', function () {
    // Lancement de l'execution de devenir de l'IP
    var myModal = $('#modal_executer');
    var intervention_id = $(this).data('id');
    $('.execute_table > tbody').empty();
    $('.pri').empty();
    $('.sec').empty();
    $('.det').empty();
    $('.sef').empty();
    $('form', myModal).attr('action', '/analyse/' + intervention_id);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/analyse/' + intervention_id + '/edit',
      method: 'get',
      datatype: 'json',
      success: function success(data) {
        var back = "";
        if (data['ip'].first_prob) $('.pri').append("<h5><i class='fa fa-exclamation-circle'></i> <u>Probl\xE8me Majeur :</u></h5><h5> ".concat(data['ip'].first_prob, "</h5>")).show();
        if (data['ip'].second_prob) $('.sec').append("<h5><i class='fa fa-exclamation-triangle'></i> <u>Probl\xE8me Mod\xE9r\xE9 :</u></h5><h5> ".concat(data['ip'].second_prob, "</h5>")).show();
        if (data['ip'].third_prob) $('.sef').append("<h5><i class='fa fa-exclamation'></i> <u>Probl\xE8me Mineur :</u></h5><h5> ".concat(data['ip'].third_prob, "</h5>")).show();
        if (data['ip'].global_comment) $('.det').append("<h5><i class='fa fa-pencil'></i>  <u>Rapport :</u></h5><h5> ".concat(data['ip'].global_comment, "</h5>")).show();
        $.each(data['lignes'], function (i, value) {
          // set the color of background in fct of the lvl of problem
          back = value.prob_lvl == '1' ? 'alert-danger' : value.prob_lvl == '2' ? 'alert-warning' : value.prob_lvl == '3' ? 'alert-success' : '';
          $('.execute_table > tbody').append( //Ajout des interventions Pharmacien au tableau
          "<tr>" + "<td class=" + back + ">" + value.med_sp + "</td>" + "<td>" + (value.med_sp_1 != null ? decodeURI(value.med_sp_1) : "/") + "</td>" + //Decode Uri , permet de formater le text dans un format HTML
          "<td>" + (value.problemes != null ? value.problemes : "/") + "</td>" + // "<td>" + value.comment_prob                                        + "</td>"+
          "<td>" + (value.ip != null ? value.ip : "/") + "</td>" + "<td>" + (value.comment_ip != null ? value.comment_ip : "RAS") + "</td>" + "<td class='text-center'><input type='checkbox' class='form-control flat-green' name='accept[]' checked /></td>" + "</tr");
          $('input[type="checkbox"].flat-green').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          }); //Affecter le fonction icheck aux input ajoutés.
        }); //and finally show the modal

        myModal.modal({
          show: true
        });
      },
      error: function error(jqXHR, textStatus) {
        alert("Erreur Serveur: " + textStatus + " " + jqXHR);
      }
    });
  });

  function storeTableInteraction($item_sac_int, $fiche_int, $mecanisme, $niveau, alert2, i) {
    $row = "<tr>" + "<td><h4>Médicament en interaction : </h4></td>" + "<td>" + $item_sac_int + " </td>" + // "<td><button class='btn btn-primary' data-toggle='collapse'  href='#"+i+"'> Fiche détails</button> </td>"+
    "</tr><tr>" + "<td><h4>Mécanisme d'interaction : </h4></td>" + "<td>" + $mecanisme + " </td>" + // "<td><button class='btn btn-primary' data-toggle='collapse'  href='#"+i+"'> Fiche détails</button> </td>"+
    "</tr>" + "<tr><td colspan = '2'> " + $fiche_int + "</td></tr>"; // "<tr> <td colspan='3' style='padding: 0 !important;'> <div  id=" + i + " class='accordian-body collapse' >" + $fiche_int +
    // "</div></td></tr><tr><td colspan='3' class='bg-aqua'></td></tr>";

    switch ($niveau) {
      case '1':
        $('.i2').append(alert2);
        $('#med_interaction_ci_table > tbody').append($row);
        break;

      case '2':
        $('.i6').append(alert2);
        $('#med_interaction_ad_table > tbody').append($row);
        break;

      case '3':
        $('.i9').append(alert2);
        $('#med_interaction_pe_table > tbody').append($row);
        break;

      case '4':
        $('.i6').append(alert2);
        $('#med_interaction_ad_table > tbody').append($row);
        break;

      case '11':
        // $('.i2').append(alert2); 
        //$('#med_interaction_ci_div ').html(decodeURI($fiche_int));
        break;

      default:
        break;
    }
  }
  /**
   * Download report of intervention on submit
   */


  function downloadIntervention() {
    if (confirm('Voulez vous une copie du rapport de l\'intervention pharmaceutique?')) {
      var report = $("#modal_analyse_pharm textarea[name='global_comment']").val();
      lunchDownloadIntervention(report);
    }
  }

  $("#modal_analyse_pharm #formInterventions").on('submit', downloadIntervention);

  function lunchDownloadIntervention(report) {
    text = {
      head: ['Date : ' + new Date().toISOString().slice(0, 10) + '\n'],
      core: [{
        text: 'Rapport Intervention Pharmaceutique',
        style: 'header',
        alignment: 'center'
      }, {
        style: 'core',
        text: report
      }]
    };
    downloadDocument(text, 'Intervention-pharmaceutique-' + new Date().toISOString().slice(0, 10) + ".pdf");
  }
}); //delete prescription

function deletePrescription(id) {
  Swal.fire({
    backdrop: "\n                                        rgba(255,0,0,0.4)\n                                      ",
    title: 'Êtes-vous sûr?',
    text: "Vous ne pourrez pas revenir en arrière!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Oui, supprimez-le!',
    cancelButtonText: 'Annuler'
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/prescriptionDelete/" + id,
        method: "GET",
        success: function success(data) {
          Swal.fire({
            title: 'Supprimé!',
            text: 'La Prescription a été supprimé..',
            type: 'success',
            onClose: function onClose() {
              window.location.reload();
            }
          });
        },
        error: function error(data) {
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Quelque chose a mal tourné!'
          });
        }
      });
    }
  });
} //calcule SC


function calculeSC() {
  //récupérer formule
  var formule = '{{ $formule }}';
  var taille = document.getElementById("taillecure").value;
  var poids = document.getElementById("poidscure").value; //replacer poids et taille dans la formule

  formule = formule.replace("POIDS", poids);
  formule = formule.replace("TAILLE", taille);

  if (taille != 0 && poids != 0) {
    var SC = math.eval(formule);
    document.getElementById("massecure").value = SC.toFixed(2);
    document.getElementById("massecuree").value = SC.toFixed(2);
  } else document.getElementById("massecure").value = '';
} //commRequired


function commRequired() {
  document.getElementById("commR").hidden = false;
  document.getElementById("commmm").required = true;
} //afficher comm arreter traitement


function afficheCommArreter(nom, comm, date) {
  var myModal = $('#modal-arreter');
  document.getElementById("arreterr").innerHTML = 'Traitement arreter par: ' + nom + ' le: ' + date + '<br>' + comm;
  myModal.modal({
    show: true
  });
} //afficher comm arreter sequence


function afficheCommArreterSeq(nom, comm, date) {
  var myModal = $('#modal-arreterSeq');
  document.getElementById("arreterrseq").innerHTML = 'Prescription arreter par: ' + nom + ' le: ' + date + '<br>' + comm;
  myModal.modal({
    show: true
  });
} //ajouter une cure


function addCure(id, cure_pevu) {
  $.ajax({
    //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: "/countCure/" + id,
    dataType: "json",
    method: "GET",
    success: function success(resultat) {
      if (parseInt(resultat) == cure_pevu) {
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Vous avez atteint le nombre maximum de cure prevu pour ce traitement!'
        });
      } else {
        $.ajax({
          //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "/getDateCure/" + id,
          dataType: "json",
          method: "GET",
          success: function success(data) {
            var myModal = $('#modal-cure');
            myModal.find('input[id="numeroCure"]').attr('value', parseInt(resultat) + 1);
            myModal.find('input[id="numeroCuree"]').attr('value', parseInt(resultat) + 1);
            myModal.find('input[id="datecure"]').attr('value', data);
            myModal.find('input[id="idTraitement"]').attr('value', id);
            myModal.find('input[id="taillecure"]').attr('value', document.getElementById("taillehhid").value);
            myModal.find('input[id="poidscure"]').attr('value', document.getElementById("poidshidd").value);
            myModal.find('input[id="massecuree"]').attr('value', document.getElementById("massehidd").value);
            myModal.find('input[id="massecure"]').attr('value', document.getElementById("massehidd").value);
            myModal.modal({
              show: true
            });
          },
          error: function error(data) {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Quelque chose a mal tourné!'
            });
          }
        });
      }
    },
    error: function error(resultat) {
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'Quelque chose a mal tourné!'
      });
    }
  });
} //supp traitement


function deletetraitement(id) {
  Swal.fire({
    backdrop: "\n                                        rgba(255,0,0,0.4)\n                                      ",
    title: 'Êtes-vous sûr?',
    text: "Vous ne pourrez pas revenir en arrière!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Oui, supprimez-le!',
    cancelButtonText: 'Annuler'
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/chimio/traitement/delete/" + id,
        method: "GET",
        success: function success(data) {
          Swal.fire({
            title: 'Supprimé!',
            text: 'Le Traitement a été supprimé..',
            type: 'success',
            onClose: function onClose() {
              window.location.reload();
            }
          });
        },
        error: function error(data) {
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Quelque chose a mal tourné!'
          });
        }
      });
    }
  });
} //get remarque


function getRemarque(remarque) {
  //alert(remarque);
  var myModal = $('#modal-commentaire'); //id="commt"

  if (remarque != '') {
    document.getElementById("commt").innerHTML = remarque;
  } else {
    document.getElementById("commt").innerHTML = 'Pas de commentaire a affiché';
  }

  myModal.modal({
    show: true
  });
} //arreter traitement


function arreterTraitement(id) {
  Swal.fire({
    title: 'Pourquoi voulez vous arrêter le traitement ?',
    input: 'textarea',
    inputPlaceholder: 'Tapez votre commentaire ici...',
    cancelButtonText: 'Annuler',
    confirmButtonText: 'Arrêter',
    showCancelButton: true
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/chimio/traitement/arrete/" + id,
        method: "GET",
        data: {
          id: id,
          text: result.value
        },
        success: function success() {
          Swal.fire({
            title: 'Arrêter!',
            text: 'Le Traitement a été Arrêter...',
            type: 'success',
            onClose: function onClose() {
              window.location.reload();
            }
          });
        },
        error: function error(data) {
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Quelque chose a mal tourné!'
          });
        }
      });
    }
  });
} //arreter sequence


function arreterSequence(id) {
  Swal.fire({
    title: 'Pourquoi voulez vous arrêter la prescription ?',
    input: 'textarea',
    inputPlaceholder: 'Tapez votre commentaire ici...',
    cancelButtonText: 'Annuler',
    confirmButtonText: 'Arrêter',
    showCancelButton: true
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/chimio/sequence/arrete/" + id,
        method: "GET",
        data: {
          id: id,
          text: result.value
        },
        success: function success() {
          Swal.fire({
            title: 'Arrêter!',
            text: 'La Prescription a été Arrêter...',
            type: 'success',
            onClose: function onClose() {
              window.location.reload();
            }
          });
        },
        error: function error(data) {
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Quelque chose a mal tourné!'
          });
        }
      });
    }
  });
}
/*
 * Reload Page when user click on back button
 * It avoid confuse informations
 */


function reloadOnBackEvent() {
  var _performance$getEntri = performance.getEntriesByType("navigation"),
      _performance$getEntri2 = _slicedToArray(_performance$getEntri, 1),
      entry = _performance$getEntri2[0]; // Show it in a nice table in the developer console
  //console.table(entry.toJSON());


  if (entry["type"] === "back_forward") location.reload();
}

reloadOnBackEvent();
/* 
 * Scroll on footer on the page when page on load
 * Only on mobiles
 */

function scrollToBottom() {
  if (window.innerWidth <= 768) $('html, body').animate({
    scrollTop: 1200
  }, 1500);
}

scrollToBottom(); //* Binding keys 

$(document).bind('keyup', 'd', function assets() {
  $("#modal_entretien").modal('show');
});
$(document).bind('keyup', 'h', function assets() {
  $("#modal_hospitalisation").modal('show');
});
$(document).bind('keyup', 'o', function assets() {
  $("#modal_question").modal('show');
});
$(document).bind('keyup', 't', function assets() {
  $("#modalPrescriptionVille").modal('show');
});
$(document).bind('keyup', 'e', function assets() {
  $("#modal_demande_examen").modal('show');
});
$(document).bind('keyup', 'm', function assets() {
  $("#modal_prescription").modal('show');
});
$(document).bind('keyup', 'p', function assets() {
  $("#modal_phyto").modal('show');
});
$(document).bind('keyup', 'c', function assets() {
  $("#modal_consultation").modal('show');
}); //! End Binding Keys

$(function () {
  //webkitURL is deprecated but nevertheless
  URL = window.URL || window.webkitURL;
  var gumStream; //stream from getUserMedia()

  var rec; //Recorder.js object

  var input; //MediaStreamAudioSourceNode we'll be recording
  // shim for AudioContext when it's not avb. 

  var AudioContext = window.AudioContext || window.webkitAudioContext;
  var audioContext; //audio context to help us record

  var recordButton = $("#recordButton");
  var stopButton = $("#stopButton");
  var pauseButton = $("#pauseButton");
  recordButton.on('click', startRecording);
  pauseButton.on('click', pauseRecording);
  stopButton.on('click', stopRecording);

  function startRecording() {
    console.log('clicked');

    while (recorderList.firstChild) {
      console.log('we are here..');
      recorderList.removeChild(recorderList.firstChild);
      console.log('we are here..after');
    }
    /*
    	Simple constraints object, for more advanced audio features see
    	https://addpipe.com/blog/audio-constraints-getusermedia/
    */


    var constraints = {
      audio: true,
      video: false
    };
    /*
    Disable the record button until we get a success or fail from getUserMedia() 
    */
    // recordButton.disabled = true;
    // stopButton.disabled = false;
    // pauseButton.disabled = false;

    recordButton.disabled = true; // stopButton.disabled = false;
    // pauseButton.disabled = false;

    /*
    We're using the standard promise based getUserMedia() 
    https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
    */

    navigator.mediaDevices.getUserMedia(constraints).then(function (stream) {
      console.log("getUserMedia() success, stream created, initializing Recorder.js ...");
      /*
      	create an audio context after getUserMedia is called
      	sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
      	the sampleRate defaults to the one set in your OS for your playback device
      */

      audioContext = new AudioContext(); //update the format 
      // document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

      /*  assign to gumStream for later use  */

      gumStream = stream;
      /* use the stream */

      input = audioContext.createMediaStreamSource(stream);
      /* 
      	Create the Recorder object and configure to record mono sound (1 channel)
      	Recording 2 channels  will double the file size
      */

      rec = new Recorder(input, {
        numChannels: 1
      }); //start the recording process

      rec.record();
      console.log("Recording started");
    })["catch"](function (err) {
      //enable the record button if getUserMedia() fails
      recordButton.disabled = false;
      stopButton.disabled = true;
      pauseButton.disabled = true;
    });
  }

  function pauseRecording() {
    console.log("pauseButton clicked rec.recording=", rec.recording);

    if (rec.recording) {
      //pause
      rec.stop();
      pauseButton.innerHTML = "Resume";
    } else {
      //resume
      rec.record();
      pauseButton.innerHTML = "Pause";
    }
  }

  function stopRecording() {
    console.log("stopButton clicked"); //disable the stop button, enable the record too allow for new recordings

    stopButton.disabled = true;
    recordButton.disabled = false;
    pauseButton.disabled = true; //reset button just in case the recording is stopped while paused

    pauseButton.innerHTML = "Pause"; //tell the recorder to stop the recording

    rec.stop(); //stop microphone access

    gumStream.getAudioTracks()[0].stop(); //create the wav blob and pass it on to createDownloadLink

    rec.exportWAV(createDownloadLink);
  }

  function createDownloadLink(blob) {
    var url = URL.createObjectURL(blob);
    var au = document.createElement('audio');
    var li = document.createElement('li');
    var link = document.createElement('a'); //name of .wav file to use during upload and download (without extendion)

    var filename = new Date().toISOString(); //add controls to the <audio> element

    au.controls = true;
    au.src = url; //save to disk link

    link.href = url;
    link.download = filename + ".wav"; //download forces the browser to donwload the file using the  filename

    link.innerHTML = "Enregistrer"; //add the new audio element to li

    li.appendChild(au); //add the filename to the li

    li.appendChild(document.createTextNode(filename + ".wav ")); //add the save to disk link to li

    li.appendChild(link);
    recorderList.appendChild(li);
  }

  function audioPlayer() {
    $("#audioPlayer")[0].play();
  }

  $('#modal_annotation').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var type = button.data("type");
    $(this).find('#object_id').val(id);
    $(this).find('#object_type').val(type);
  });
});

function getPatient() {
  var patient_id = $("input[name='patient_id']").val();
  var text = [];
  $.getJSON("/patient/".concat(patient_id, "/edit")).done(function (res) {
    text.push("Patient : ".concat(res.nom, " ").concat(res.prenom, " \n"), "Date de Naissance : ".concat(res.date_naissance, " \n"), "T\xE9l\xE9phone : ".concat(res.num_tel_1, "\n"));
  }).fail(function (err) {
    alert(err.responseText);
  });
  return text;
}

var patient = getPatient();
/**
 * 
 */

function getMedecin() {
  var user_id = $("input[name='user_id']").val();
  var text = [];
  $.getJSON("/admin/user/".concat(user_id, "/edit")).done(function (res) {
    text.push("M\xE9decin : Dr.".concat(res.name, " ").concat(res.prenom, "\n"), "Service :  ".concat(res.service, "\n"), "Sp\xE9cialit\xE9 :  ".concat(res.specialite, "\n"));
  }).fail(function (err) {
    alert(err.responseText);
  });
  return text;
}

var medecin = getMedecin();
/**
 * download Prescription
 * @param  {} p_id=null
 */

function downloadPrescription() {
  var p_id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
  var response = getJsonData(p_id, "/patient/prescription/".concat(p_id, "/edit"));
  response.done(function (res) {
    var text;
    var lines = [];
    res.lignes.forEach(function (line) {
      var toText = "".concat(line.medicament_dci, " ").concat(line.voie, ". ").concat(line.dose_matin != 0 ? line.dose_mat + " " + line.unite.toLowerCase() + ' le Matin, ' : '', "  ").concat(line.dose_midi != 0 ? line.dose_mid + ' à Midi, ' : '', " ").concat(line.dose_soir != 0 ? line.dose_soi + ' le Soir, ' : '', " ").concat(line.dose_av != 0 ? line.dose_ac + ' Avant-coucher.' : '', " Pendant : ").concat(line.nbr_jours, " ").concat(line.type_j, " \n\n");
      lines.push(toText);
    });
    text = {
      head: ['Prescription #' + res.id + ' \n', 'Date Prescription : ' + res.date_prescription + ' \n'],
      core: [{
        text: 'Prescription Médicament',
        style: 'header',
        alignment: 'center'
      }, {
        // style: 'core',
        ol: lines
      }]
    };
    downloadDocument(text, 'Prescription-' + new Date().toISOString().slice(0, 10) + ".pdf");
  }).fail(function (err, type) {
    alert("Error : ".concat(err.responseText, " \n Type : ").concat(type));
  });
}
/**
 * download Demande d'Examen
 * @param  {Integer} b_id Demande Bilan ID
 * @return {void}
 */


function downloadExamen() {
  var b_id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
  var response = getJsonData(b_id, "/patient/element/get-prescription/".concat(b_id));
  response.done(function (res) {
    var text;
    var bilanss = [];
    res.bilans.forEach(function (bilan) {
      bilanss.push(bilan.element.element);
    });
    text = {
      head: ['Prescription #' + res.id + ' \n', 'Date Prescription : ' + res.date_prescription + ' \n'],
      core: [{
        text: 'Prescription examen ' + res.type,
        style: 'header'
      }, {
        ul: bilanss
      }, {
        text: 'Note',
        style: 'header'
      }, {
        style: 'core',
        text: res.note
      }]
    };
    downloadDocument(text, 'Demande-Examen-' + new Date().toISOString().slice(0, 10) + ".pdf");
  }).fail(function (err, type) {
    alert("Error : ".concat(err.responseText, " \n Type : ").concat(type));
  });
}
/*
 * download Compte Rendu de la consultation
 */


$("#formReport").on('submit', downloadReport);

function downloadReport(e) {
  if (confirm('Voulez vous confirmer l\'impression du rapport ?')) {
    // e.preventDefault();
    var _text;

    var compte_rendu = $("textarea[name='compte_rendu']").val();
    _text = {
      head: ['Date Consultation : ' + new Date().toISOString().slice(0, 10) + ' \n'],
      core: [{
        text: 'Compte rendu de la consultation',
        style: 'header',
        alignment: 'center'
      }, {
        // style: 'core',
        text: compte_rendu
      }]
    };
    downloadDocument(_text, 'Rapport-' + new Date().toISOString().slice(0, 10) + ".pdf");
  }
}
/*
 * Fetch data via Ajax Request
 */


function getJsonData(id, url) {
  return $.getJSON(url);
}
/**
 * Pre-Download Document
 */


function downloadDocument(data, nameFile) {
  var dd = createDD(data);
  download(dd, nameFile);
}
/**
 * Create Document Definition
 * @param {JSON} data data returned from the server
 * @return {JSON} Document Definition
 */


function createDD(data) {
  return dd = {
    content: [{
      image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKQAAAB4CAYAAAB8SVkVAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAABhJSURBVHja7F1NduI8s1ZzenQnr3sF7awgsIEbs4KQFQRWEDzNHRAmPYWsAGcFkBXg3A3EWUHcK2i/k2/an2WVcFlIsmQbDMR1jk+nE7Bl6dFTPyqVvv39+5d00smpSK/rgk46QHbSSQfITjpAdtJJB8hOOkB20kkHyE46QHbSSQfITjpAdtJJB8hOOukA2UkHyE466QDZSQfITjrpANlJB8hOOukA2UkHyE466QDZyVeTbpNXJ6v//59+ejmn0JZvFJDfvn3rRuVrAdBL/5mlV5xeH+m1SK8wvV7T6za9osn//sdPP/eU/nyTXm/ptUkvJ/192A4gH8M++eVF3fBdBPge0itJr9/pdQ0gpIAM0uslvbbwcQo2D/59g89QoThwAcD0X5IC88ch2vtd+tvHkD70HhrSyXkLBdhI+N0r/Et//yz5TgIXl77wLwW6C98PUnAmh3Zq6MyYd2N53syYXn8kQKPiANs5wI4i8XwAS3LWlBHTO6h6+pxVeo0PA8jH0Muo/ZeXdMN6diAcp9ff9HoHsDmgrpfwkSH6+ARI5w4Yc4mYM05Zj4JwkP47hM/h70Zwb4qRVXpRMN6kz502b0M+huussR0gzxGQOGSyQap6CCCLS77vAvNdydQw3N8HMN6AChe980n63aAZhmTsGHdgvAgZYTuwDIzoM1cam5D+bQnOkC8BI/1eRMNITansmcLI7eR0WdGh4RmII27A5uOAsh5LnYPCQS2AO5HYlu9VQdkTPGs3Zce4G+bzASM4JTP4dwI23xXYiEuurpt+NtiY9N4DsDGXAmNSUG7rhH1GyLP6evIYOjisoZDkVGKzwEBbBII+eL0TYLkAeckHERQkpwy9lnzEqQNIGnd8+SLg82AAr+HfvsV3CTAOvd6yAf/lhS2DMYGfPct+WGRj3swk433iwv+pjXkLjtCSrvyYe9n/90Zf5k9GwUfu3CMB0AUNcGs9aGaSgP32coz+g7COOIlCUNc2YJxC2wdNmGrgpY+BlRfQRnpfP23bxsaG7F8kCB/DaXrRwfuEDvIO9DQHBmKbPm8LDHwoMHrCeG3AlptY3uoDMVuC+m1UQ4XT0NIT9DMHI+2bNQ2e2wDSVer8Gg1sCYgjiKV+oll6TPEAmGuwS5sE45rk6847YFFbziSsU5BfXgBM5u/CfEyTrBto6gYmiIMw5VQB5K0wuOO9352qQ0Lb+hh+QoeewiQaZZOiIbYEu3GEWM0HQMUV+4xrjDUAMXtMgx74PclXc7L+UDg+irAPk7HQgQsw3E8ZiE/Ahis0sapKKFx1jX0H2HLcEMAJIhCaIjassSpSVNk0u4sBtKkogk+Ky41WXjalWJ5qRDuQvuRv9LdTBOMU2myjFhPo8DfkFUZGK1NsorrgmXuWpsAq886Zmqwq14JKrOeE0LY8hglECRJkXjTilFGWTBnxk+SJHC/c7Ej/dqf3sulaNlN37h7Kf3nLk7MRGXObsuEGhWeiBtvBPfcHw7YkEMWo1IZ0IEfIvqPOw9UBQmHUPr3CHjdK0qXtf7ZJ0EWrNX3BHPihWhHCgBRjW8u0Yf4JAdGFl/IMQUhDMJsjtc0Dti5rG2XjgSUQHTBJMkAAOEbpgH5r+B3G2b1/eRP0bB4awnJnGsJBoaBPcWKCnamxIdnMHcBgRicGRm4n6gacG/o/0rbfHQ2MrO8o+/LQi0799+FdbIRn1LgA+vkBwMhXeeYCkGTpZA8V7OgQ7h2RPAfTyKlJGjZs63cUiyPOShwRqgqvMvOizUwlZiNeldhhDzbhIFCRFOwBjIvXYP9yp/A9u38xOE77PATw36GJZtW/wIQvcD+uwmNV8sV3iSfnIIembadlUQLE+cmtLLEJMUzbzxNXZYwxIvlas4nweGpg+T05CBmob9F4yzRilr6GAvEhUW95KJMIQL2C5/WJYouMCMjbJj2tGh221jDBaQJxH5gTWPeWgfLWElicUcfAUH7Ffp3BPZw9Z2vfgXIk6jWssusQPO4Z8rgpqOnvHNG5EVW21+ogMlvmXdGOmLBM9vNZb2cOgqyttv38gpy1fyu2Zg02oSMw1wCbObA3Zq1hOb4aZrsKNQdzZk7ydLm1miEZGBz08GODcUzUKwVz8PrPMZP9DhwyR8J4tvJaKRDOzB9PYMXntD+fBGb0YAxiNAlCZMtynNzaOo3Akp4wxn2dyvYEO+iYYFwoPLoQWDEm5yos6Dzfs4ft9r3Tfgis16uLqjoGhn2VaRgIL1Gw+LBNQXWvxY4p7cVFE2KTPmei87J/tqSmVxIwMjuJqefzBWMOyqWtdyoIVW+fFbeaTne2G3Vc1OYO/dyLEoy5c9XEBsDMsYPQkhKQ/SMD0YGsnLHEVhmc3ApRfdkIILUxi3h8c1Vhr8rNTgMqEj2AHfF22SwOKan3w5ydCllM0G6urqnZMZAxfk9Cp8fypLdkPytnnq1kXOa+nteqX6R2I5QuGVawP/HnVTY6HYdI8HizVDcBlHzcqmAlhvbTZcOJyvyQA/KACaYIjH1BRd+JRvaFSaT42QaYVcIuSWGMmVMiCo0JviE2m5J8awdelAgIi1lGFdqeQNtdqKrhlgHymMzYl6joDblkKbL+MaMY4j6pFWS1jwWHFrcJ58COC2EstkRaSWDrxTtgYGEDyEPZk2IGN0u//3pbb1+POBECUkxV43mP9yjUIzIpBqejYjOBbLzMQVXYl+CQ9dGz5jaAvD6QNz0u0D9LgviKVTLCIz9Pp336yMaTsao+3MT2Lm0JX9FRj+etYEZ4ZV724RiSBWZFME7I15TNUSchsxmniPk4ON+w04NBBwkRccEpYlERR3Lvd/jsoGRMHcFfodqShrLWGJhqQDa1QYk5SItCCOMrgjF3Jo69911cGRkBgJYl2nAjAImO4Z+d7cneZw3O6MTA0Yk0Hv47Nx16Cm+MkCY2SuWJEhiMwRdlRrYt9JjOGwNPXwIGbCqpiOdD+HuCnCIXgG6TV/Bawp4rEZCRRudXlTV6oeBswJjbRU3KTQvs+ACTYACMGBLzbRRxwXxj6WkTxLq+jTMKIR/d+NNwkNuTNCBnyHx7ZFW70TtTm5Ftlajz/iLAmQ29POKk4nmHbmY2sWVDY0ZD8c5Q8Ngj+NnaMYO1a5mGyOLQ1I7tSSiaSGNQ9gMwQ0b8+YCxOJEeGgR4cOSIAlbFswbvm9Rk+g+JbXnF9+n0SkIRDxWdG54ZHBH7Eh9tOx6Lhu1oDvDj1mwvqlOvRgWSZM8WbNb08vGSpbjJK5HMsqnlAIxhABLBeD4XVV2wa2qaLVxTBC0F/7GtuKhILh8C0Js2Owpt6ilcfVKge/n6p8puWSBPLj4bKOYe6Z6x3YBT19aJFqHwHlNDFiQoNhgeuI00DvmHbrmliRw9Q9fctObLbDcA51fWTxWP8yoCfEX4xqz2JuazIblEqol46JO7BE087Ql0rCrRUb6fmKmnKWEVIp7I+UlzLJavTFXbkNWsHRkYkMuLYiIem1TCnmHj+OwalbBjclZOTHHwEiKPk/1TQfUvdiBv34aeE/FULjZhdupasU/nmhwmCUQLctnRcksIdzhS1f0YxnuBVbY8OCaWwdITlFeyH+rqW4Jxtev4trLeqbbi40D/fQyfhdDPLCsoxiaLrzFVfGRP0ne7kXwuO5hTVRrFVnoKpphrdP1WYofMWh2A5lhyUwMEGIztaQrmWK6E93oSTLGd8ynL5IF92TSDPEaHKfHaReJFf/8OdYDqittTDMySqBfDi6DM6wr65DIkqgCChQCCNjWFypMWx2esCWndItONb4sNgKjmCtPGVL3Hmt8n+uOJ2cwgmlDBkPDVjEvJ4GEbz0YFm0eVJZ2zEf58u8ukjyE/cJNuVb0nbP91BH/bClEDaVuhriOv0jbCNibarIW1pFXBfeEIvCvM0j2N+opKWM8BwI4uiB2pfBgOfB+9P2ZXv0UweqRYAsVFYBxLHNa9ChSgrhMAYiIBI9/kFYBZMiTV92nvmQy9EptqScpr0DhgJDvkq0heMcwVVM7wxFam/AJQ2ZLfXBi7sUTz0ffaCEDlYAyA1SawGzI8xnnZ4kuV2VVThbNzjpJoGYhVGp5JvnMKy6Rxwami7MiY8T4DGLMZxaIF9xKCyRgWqufyfdvZKcH0AKQGABhWByQvL1cOSqbCqIF/3mwZSW1FZlvK9iTXKtXccJQgBttvADXEWagmtxPHknhrX3BuEjSeHDj8yLrGk4vFfTU9wxc1BSVny8+GTh44FRkReeZPljp1Kucf7mx/FnvkRaFyMOZxRHFJcQSnym4FtRyCqv4tW0KE9ee6WrECIO1BybxPqt4uA5iuoG64MT88yWymvMDURAjlJIhJMdvxw9jfkH3I1f+DzI+Ak7mmRFOeuYp8t5x97Fw8Vma5bziQK4jTPZN2Ew1MBrHsnXiNnbw8MV25YoP7fELvNoX2JGBqxDAWGKCviPU9OKojFEDnwN9kYaz5ISIs32sM3AZiWib2Ip+x1BvfQGdsWmeXYnnjMcmLs8schQkwyVgy6VgyxWN4KnWJ/kHZVi7hCxdF02JD8mA+2+K6Px4joghkA4P+sLAVx2UOjZ3KLjaSe9+mKlz8Pu2IP3Ae4LSxvStmIOzDM9eEnYArq8CG5Td4ptcln3NIs1sFqr4fBd8H0moDwurxBBJtFwpOqUzDVRobSRGABxh37Wka3ys865awnWx85gwqnqqFnYUFqL4IOjMkpids6QfHRQxxbcHoonjELHN+RGzWsGm/6db/2eassEb4R/V/Lm9En+9JNUJWHMo0LxKAuJb0w4uJmffdcoDlJwjQTmWqeEaqbgzLZ+NoxzSsaHyIOrXsdIhrFEdrKiaakIYOpRT6cmwwOR5ItZzEPGSTmyUyCUtYnQOWetPDsvgjVE2j94vE7B9aCDX9u0zLJHUYkqvrD0UMbALli+sAU8ZObcqDBauGFhN7oXUImNaxZ3PKqMyJ5My70JhV8d7POHWtuDebZvTQsd1gYAIj4iP2AoUTlG2DTT//Ap/14HdRHUDeoPibqkNEYI5I9SLvx5IYVEogsZlcktfn/pewhN2RwrYyPTmX78qMNabGjFQv2/eKCh14RHUqK4tXkp0JxpOLH8Ms0E+XBlMAPRC+v5u1m1bxjaHt+KAEvrdaGzwH1R8CmEd1nRpvNwvLZ2oMQdkrsCeiEwMhX7G4g1PAnhQesg9/9+EzPmGrIYHksxsDdlQF2WWAtTUDRtD3T2hy3BmMF2839wO2yNEcSpjfRfY4z5+9qrCS81DdhswdBLuwRr5UFaATVG9IO4esc6Z70yTjFutXypwO9k4TZFMTwdHTqeqVgZfsVQRjhNr4tIsq6MeUyjP87KCIAQULX7cegmr2BM0QNr0J7Ls1O9Y5p5kN2HJn3+SdfyPQf1MSFjx3sxihU1B9evELgCwH41a4vydhH68kFKO6t7s3yfKNeZFm8uWLFVRV520sBL0h7hg0PD59uvSI7UgbQF7XBqTMAMcDguvRsOsfw0HBHnhoxFZq+WmsgpndlZD8tNYyML4K73OtsdPZ5DAL/az2wiz58qFuJeW+8HeWHeTD/VxFsLxJcUQSsgEk78jDHcy5H6xtQ1ykrhMDZnJ235PFFZkWwMdhzApRi/IDlGbaPmH7v98kbe1LGB+HnGZEttzJsoRm0A84fPS0s7vxs/IT4KqSQFxXZV+6eIbqmkhCW9RDvUFhsVsEjDui3smpS9JgtbvFrQa5Pdov2TLxU/gePi/mhsgrsoUk31fO7dMZeqeh5JDUYRXtKWaMmwHymEt7bUruAMSGBZVk1dFkXvRmZ989hjLN8wlhslih+vmGrFcACQ8wO8qQjopImFoOoI2q3aW/d5/NbVAexvNQVeQYfv+zqUolpgz5NQCZs5lvCF6TfjHZEotrIumAJWqppQYIMTIlinYoOzp5XqJiN4Iz+gT28gKY0T9EAVrTOORX2S9zW2CzZvpEVMdl8VjTve0R0ZV/YSCKkVngSP6uEupMvkjuybc/xHXBqErs7Vkyx7mr5LLYp0vMkyMSg7/LisG/aMNULPAeGt67rA0heq+t0dYSvs9ePSmjhhxPpw4gLwGMHtFVxGWep28c5mBAizSDNlSwSKD4HlbtvgbwMTHfw4Pr+nBb9UnqE7C66k8QntKZLG+kmcJcTh0bUhUnOydZlNqG9ob5HeH1yHMgPmvVGcviHgoeakxwPU3mePDPuAiwAbEpYMXipD7Bibh5onRcsDPz5yy1/VCjsh2sXc+Qxt2bVOrKFcXZ84Tc/giSPs+JHacZO9I16dNqFwOCDgDc86+zkSyvyFamsueHLKWIKlZsIDS2V6SqCiCp/DibUs1sQLfQ2Zd2BrdNP/CiALeIERNgKc7s8SGbQCvlEpYRFNYN+8hCEJszGQSeORNU6EA6aDx9jif/eqDqYhjQD6R+IjHQC0mr9HvLJis8WAsjkCU5wtEk4EGL52zTifBcloxRFZA3ZwHI/PRZ4yM5EAjvNdEFbHONhO8PuBqCraJjZANePENDtQtVFnppfNcUkLLdaKddYCo/fTYp8woNQWjlPcLZfeMvaBzcIkcNa4s3uo2hKUBGewxBY3qneuh68ShkpW0EQFwQfW5mQngOJQsbZYwL6fhcNWEVxZ+1KunDs5XU73BTv0Nnb15pjzRuAJCymz+cpNougjEq8RrHCjDG8G4v2AtMAcgLM43p/hL0t1AA+pjsLytGlwJGwiq/qfZkv1YFozkgi3l/uWNzSiyZb5zCatKmcKgUhIL0RdWskAfErlmaf6sOTbMyLnn3n3VubrNSE0qdhlOodMbieVsBjL5B7C4GW5g6IldQai5SqPdCMqnmcx7ZT9IIyOVIKftBXx2QIYGKJeqN22BtljAekf1NUYFJzFFxHAbReNa6ySmyY4i+83IpaExtx4DGrjXC93JX0pw2DLlRUngbFc5YzUaeCuUIttohIgCOIUt4aGCozRk1dWTGKYGyBCeVIxW25fhUDVkdFZSMFalhPZU4DocqkYc7+UOhqngQPSF5aWRf8jm6t/kvnPHntgUs6nxBO/7K9khXEbCV48MDslz18LJ7hwSiBxvg1wov9pD1Gh0Dj/kGqetsL4y4MiEEy3VlTvbsMrrqU9U+E4EPkQAcmrpXfK9/zEljB0iWBKCzDaYZYJre8pADcasYwJAct3hoVKKuXQCbLwHBWOckAPAog64xKAirGrYglsdFAwvSNeRPnhSL4q9aZwUq6r4T/fEwMuBXHv8qS4c+0VcR8wjLu6PqfV55wT4vKlC2enKsc2H4llXdqQMuUu9Lie3Il9SWAKwYMyiw3xa/Lzr9wLEEokuKqXE8DMXb4cDESuAzzxIm9wxCXETyjh/HA+R+jp0uXjVGBUr1G/UZAPtw3RoYxgk50L4OA5VdFhaKibBcCcByBSadaMCYAKj2wAifXcB97kTgQ+gJO3tZX6GA9Qi9E588scKs2LEnei5t17NYOgUtl14dkyH53l1ZNVmZ5Lvw2I67iBTXxquUzouIfHvAKahrQvISJGI/YAdpwtlRxozQRxyMMSkm6n4isNHjO6748yS2YYDbI2Ti0HvSZVAfgWoqGdeNhKn72HyDv6/hfkdzajAoJ6RawJefjcgvGzByVhy0ePLBvzLDH4NAwhw8/QoDNpCAcSOofxdY9EVQiWJq1wwx20p4zkSYHHgbxwaXzgMw8/J9gRBVEJna4Z45AiupG3Krt6eGgXJ+JCAEhB3B0VYKl4ccKFEKNSRRPW0V+0WCndeH9xPL+U0AuDcCAH1h4KfggGBmG4rZNRJV/IEcqSdoC4tWFBmZv99GeP8ZnAK7Rc+s5ViaZYybeMG8HkyzwjNt5m0Xk087np88MZSEckaC7ctjtrxokwMDKToYHMQ8ewifbuFzQIGX7AgglalnghyvoTAp+CGhEYoCiO2gfcy3p/wRnVmogsvPuHQFG/OuiQWAZnYdsnDQgOyfXl/HTvOBEScncrKB8r2oik6vJ5KXX3EIP5mB/TwHgIQSJ4mDEdvSAQIjjmgs8XIn/MyP88CayuXxSgDtJ8lLcQ8Fj9pBfc4ZbiRh6iU8Uzz0nd5z0NRq1PfGhovFAJ8Iq3AwBjXjGbJmDB1S7o23JyZt4qc1eMgZ8ZFN6Qshl1fEthiME4mpUHA+BHt1A+C7R7YnXQXCk2lX3Tb9PW3nT5LX+3wT1vWxvbsU1/zpfWhmPPzcqC3fjMrWq3M88z00uDFi15MXsL/6TdhJls/NHD+TbGvk6WISCIHhYotn8jPDl7JJcEg5PCA7aWPy8IkfVZk8XN23kcP5XwEGAMi598R/2IFlAAAAAElFTkSuQmCC',
      fit: [80, 80],
      alignment: 'center'
    }, {
      text: 'Centre Hospitalier Universitée Tlemcen\n\n',
      style: 'header',
      alignment: 'center'
    }, {
      columns: [{
        width: '33.33%',
        text: patient
      }, {
        width: '40.33%',
        text: medecin
      }, {
        width: '25.33%',
        text: data.head
      }] // end column

    }, {
      canvas: [{
        type: 'line',
        x1: 0,
        y1: 20,
        x2: 560,
        y2: 20,
        lineWidth: 0.8
      }]
    }, data.core],
    styles: {
      header1: {
        fontSize: 16,
        bold: true
      },
      header: {
        fontSize: 14,
        bold: true
      },
      core: {
        lineHeight: 2
      }
    },
    defaultStyle: {
      columnGap: 20
    },
    pageMargins: [15, 10, 15, 40]
  };
}
/** Launch Download */


function download(dd, nameFile) {
  pdfMake.createPdf(dd).download(nameFile);
}