     		// Listen on checbox events
     		function handleCheckboxInjectedEvent() {
     			if (confirm("Vous confirmer l'\administration du médicament?")) {
     				let line_id = $(this).parent().prev().data('id');
     				let prise = $(this).parent().prev().data('prise');
     				let newLocal = $(this);
     				let input = $(this).parent().prev().val();
     				let isChecked = $(this).parent().prev().val(1 - input).val();

     				$.ajax({
     					type: "get",
     					url: "/patient/prescription/ligneprescription/" + line_id + "&&" + isChecked + "&&" + prise,

     					success: function (response) {
     						if (response.type == "success") {

     							// disable selected Checkbox
     							$(newLocal).iCheck('disable');
     							toastr.success(response.msg);
     						} else toastr.info(response.msg);
     					},
     					error: function (txter, er) {
     						toastr.warning(txter.responseJSON.message);
     					}
     				});

     			}
     		};

     		$('#table_injections').on('ifToggled', 'input[name="injected"]', handleCheckboxInjectedEvent);

     		/*                              */
     		/! STOP INJECTION EVENT HANDLER !/
     		/*                              */

     		$(".stopInjection").on('click', onStopInjection)

     		function onStopInjection() {

     			var comment = prompt("Préciser l'arrét du médicament", "Aucune raison!");
     			var form = new FormData();
     			form.append('comment', comment);
     			let line_id = $(this).data('id');

     			const btn = $(this);
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
     				success: function (response) {
     					toastr.success(response);
     					btn.prop("disabled", true);
     				},
     				error: function (exception, status, type) {
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
     			let id = $(e.relatedTarget).data("id");
     			if ($.fn.dataTable.isDataTable('#administrations_table')) {
     				administration_table.destroy();
     			}
     			administration_table = $('#administrations_table').DataTable({
     				dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
     					"<'row'<'col-sm-12'tr>>" +
     					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
     				lengthChange: false,
     				buttons: [{
     						extend: 'excelHtml5',
     						className: 'btn-success',
     						text: "<i class='fa fa-download mr-1'></i>Excel",
     					},
     					{
     						extend: "pdfHtml5",
     						text: "<i class='fa fa-download mr-1'></i>PDF"
     					}

     				],

     				"processing": true,
     				"ajax": "/patient/prescription/get-injections/id=" + id,
     				"columns": [{
     						"data": "administrator.nurse"
     					},
     					{
     						"data": "line.medicament.SP_NOM"
     					},
     					{
     						"data": "posologie"
     					},
     					{
     						"data": "custom_injected_at"
     					}
     				],
     				"columnDefs": [{
     					"visible": false,
     					"targets": groupColumn,
     				}],
     				"order": [
     					[groupColumn, 'asc']
     				],
     				"displayLength": 20,
     				"drawCallback": function (settings) {
     					var api = this.api();
     					var rows = api.rows({
     						page: 'current'
     					}).nodes();
     					var last = null;

     					api.column(groupColumn, {
     						page: 'current'
     					}).data().each(function (group, i) {
     						if (last !== group) {
     							$(rows).eq(i).before(
     								'<tr class="group"><td colspan="4">' + group + '</td></tr>'
     							);

     							last = group;
     						}
     					});
     				}
     			});

     			administration_table.buttons().container()
     				.appendTo('#administrations_table .col-sm-6:eq(0)');

     		})


     		// Order by the grouping
     		$('#administrations_table tbody').on('click', 'tr.group', function () {
     			var currentOrder = administration_table.order()[0];
     			if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
     				administration_table.order([groupColumn, 'desc']).draw();
     			} else {
     				administration_table.order([groupColumn, 'asc']).draw();
     			}
     		});