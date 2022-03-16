$data = '';
var select1;
var select2;
$('.show_chart').on('click', function() {
	var id = $(this).attr('id');
	var fun = {
		ajaxGetData : function(){
			$.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url : '/chart/edit/'+id,
                method :'GET',
                datatype : 'array',
                success : (data) => {
                	$element='';
                	$data=data;
					$types = [];

					for(var j=0; j<$data.length; j++){
						if($data[j].element_id != 28){
							if(!$types.includes($data[j].element)){
								$types.push($data[j].element);
							}
							if($data[j].id==id){
								$element = $data[j].element;
							}	
						}
						
					}

					select1 = document.getElementById("TypeExamenGraphe1");
					select2 = document.getElementById("TypeExamenGraphe2");
					select1.options.length=0;
					select2.options.length=0;
					document.getElementById("date_debut").value='';
					document.getElementById("date_fin").value='';
					select2.options[select1.options.length] = new Option("","")
					for (var i =0; i< $types.length ;i++) {
						select1.options[select1.options.length] = new Option($types[i],$types[i]);
						select2.options[select2.options.length] = new Option($types[i],$types[i]);
					}

					select1.value=$element;
					select2.value="";
					getData();
                },
                error:function (jqXHR, textStatus) {
                }
            }); 

		},
	};
	fun.ajaxGetData();
});

function comp(a, b) {
	return new Date(a.x).getTime() - new Date(b.x).getTime();
}

$("#TypeExamenGraphe1").on('click',function(){
	getData();
});

$("#TypeExamenGraphe2").on('click',function(){
	getData();
});

$('#date_debut').on('change',function(){
	if(document.getElementById("date_debut").value!='' && document.getElementById("date_fin").value!=''){
		if(document.getElementById("date_debut").value <= document.getElementById("date_fin").value){
			getData();
		}else{ alert('intervale incorrect !'); }
	}else{getData();}
});

$('#date_fin').on('change',function(){
	if(document.getElementById("date_debut").value!='' && document.getElementById("date_fin").value!=''){
		if(document.getElementById("date_debut").value <= document.getElementById("date_fin").value){
			getData();
		}else{ alert('intervale incorrect !'); }
	}else{getData();}
});

function getData(){
	var select1 = document.getElementById("TypeExamenGraphe1");
	var selected1 = select1.options[select1.selectedIndex].value;
	// var selected1 = "Créatinine";
	var select2 = document.getElementById("TypeExamenGraphe2");
	var selected2 = select2.options[select2.selectedIndex].value;
	// var selected2 = "TAA";
	var data1 =[];
	// var valeurs1 = [];
	var data2 =[];
	// var valeurs2 = [];
	var dateD = document.getElementById("date_debut").value;
	var dateF = document.getElementById("date_fin").value;
	var unite1;
	var unite2;
	var min,max;
	for(var i =0; i< $data.length ;i++) {
		if($data[i].element==selected1){
			unite1 = $data[i].unite;
			min = $data[i].minimum;
			max = $data[i].maximum;
			if((dateD!='' && $data[i].date_analyse>=dateD) || (dateD=='') ){
				if((dateF!='' && $data[i].date_analyse<=dateF) || (dateF=='') ){
					var datee = $data[i].date_analyse;
					datee=datee.replace(/-/g,'/');
					data1.push({'x':datee,'y':$data[i].valeur});	
	   			}
			}
		}			
	}
	data1.sort(comp);
	
	if(selected2!="" && selected2!=selected1){
		for (var i =0; i< $data.length ;i++) {
			if($data[i].element==selected2){
				unite2 = $data[i].unite;
				if((dateD!='' && $data[i].date_analyse>=dateD) || (dateD=='') ){
					if((dateF!='' && $data[i].date_analyse<=dateF) || (dateF=='') ){
						var datee = $data[i].date_analyse;
						datee=datee.replace(/-/g,'/');
						data2.push({x:datee,y:$data[i].valeur});
		   			}
				}
			}
		}
		if(data1.length>0 && data2.length>0){
			data2.sort(comp);
			getDaigram2(selected1,data1,unite1,selected2,data2,unite2);	
		}else{
			if(data1.length<=0 && data2.length<=0){
				getDaigramEmpty();
			}else{
				if(data1.length>0){
					var dataMin =[];
					var dataMax =[];
					dataMin.push({x:data1[0].x,y:min});
					dataMin.push({x:data1[data1.length-1].x,y:min});
					dataMax.push({x:data1[0].x,y:max});
					dataMax.push({x:data1[data1.length-1].x,y:max});	
					getDaigram1(selected1,data1,unite1,dataMin,dataMax);
				}else{
					var dataMin2 =[];
					var dataMax2 =[];
					dataMin2.push({x:data2[0].x,y:min});
					dataMin2.push({x:data2[data2.length-1].x,y:min});
					dataMax2.push({x:data2[0].x,y:max});
					dataMax2.push({x:data2[data2.length-1].x,y:max});	
					getDaigram1(selected2,data2,unite2,dataMin2,dataMax2);

				}
			}
		}
	}else{
		if(data1.length>0){
			var dataMin =[];
			var dataMax =[];
			dataMin.push({x:data1[0].x,y:min});
			dataMin.push({x:data1[data1.length-1].x,y:min});
			dataMax.push({x:data1[0].x,y:max});
			dataMax.push({x:data1[data1.length-1].x,y:max});	
			getDaigram1(selected1,data1,unite1,dataMin,dataMax);
		}else{
			console.log('there is no Data to show !');
			getDaigramEmpty();
		}
		}
}

function getDaigram1(selected1,data1,unite1,dataMin,dataMax) {

	var charts = {
		init: function () {
			Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
			Chart.defaults.global.defaultFontColor = '#292b2c';
			this.createChart(selected1,data1,unite1,dataMin,dataMax);
		},

		createChart: function (selected1,data1,unite1,dataMin,dataMax) {
			var ctx = document.getElementById("Chart").getContext('2d');
			if(window.line != undefined) line.destroy();
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
					},{
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
					},{
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
							type : 'time',
							gridLines: {
								display: false
							},
							ticks: {
								maxTicksLimit: 7
							},
							scaleLabel:{
								display:true,
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
							scaleLabel:{
								display:true,
								labelString: selected1+' ('+unite1+')',
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
};

function getDaigramEmpty() {

	var charts = {
		init: function () {
			Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
			Chart.defaults.global.defaultFontColor = '#292b2c';
			this.createChart();
		},

		createChart: function () {
			var ctx = document.getElementById("Chart").getContext('2d');
			if(window.line != undefined) line.destroy();
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
						data: [],
					}],
				},

				options: {
					title: {
			            display: true,
			            fontSize: 20    
			        },
					scales: {
						xAxes: [{
							type : 'time',
							gridLines: {
								display: false
							},
							ticks: {
								maxTicksLimit: 7
							},
							scaleLabel:{
								display:true,
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
							scaleLabel:{
								display:true,
							},
						}],
						
					},
					legend: {
						display: false,
						
					}
				}
			});
		},
	};

	charts.init();
};

function getDaigram2(selected1,data1,unite1,selected2,data2,unite2) {

	var charts = {
		init: function () {
			Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
			Chart.defaults.global.defaultFontColor = '#292b2c';
			this.createChart(selected1,data1,unite1,selected2,data2,unite2);
		
		},

		createChart: function (selected1,data1,unite1,selected2,data2,unite2) {
			var ctx = document.getElementById("Chart").getContext('2d');
			if(window.line != undefined) line.destroy();
			window.line = new Chart(ctx, {
				type: 'line',
				data: {
					datasets: [{
						yAxisID:"a",
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
					},
					{
						yAxisID:"b", 
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
							type : 'time',
							gridLines: {
								display: false
							},
							ticks: {
								maxTicksLimit: 7
							},
							scaleLabel:{
								display:true,
							},
						}],
						yAxes: [{
							id:"a",
							ticks: {
								maxTicksLimit: 5
							},
							gridLines: {
								color: "rgba(0, 0, 0, .125)",
								display: true,
							},
							scaleLabel:{
								display:true,
								labelString:selected1+' ('+unite1+')',
							},
						},
						{
							id:"b",
							position: 'right',
							ticks: {
								min: 0, 
								maxTicksLimit: 5
							},
							gridLines: {
								color: "rgba(0, 0, 0, .125)",
								display: true,
							},
							scaleLabel:{
								display:true,
								labelString:selected2+' ('+unite2+')',
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
};