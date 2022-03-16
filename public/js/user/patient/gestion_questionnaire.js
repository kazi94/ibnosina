jQuery(document).ready(function($) {
	$('#questionnaireChoiceId').on('change', function(event) {
		 var questionnaireSelected = $(this).val();
		 var $tbody = $('#modal_question tbody');
		 $tbody.empty(); 
		 $.ajax({
		 	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		 	url: '/getQuestions/'+questionnaireSelected,
		 	type: 'GET',
		 	dataType: 'html'
		 })
		 .done(function(data) {
		 	data = $.parseJSON(data);
		 	$.each(data, function(index, val) {
		 		$tbody.append("<tr> <td>"+val.question+"<input type='hidden' name='questions[]' value="+val.id+"> </td> <fieldset> <td> <input type='hidden' name='oui"+(index+1) +"' value=1> <input type='radio' onclick='this.previousSibling.value=1' name='oui"+ (index+1) +"'> </td> <td> <input type='hidden' name='oui"+ (index+1) +"'  value=1> <input type='radio'  onclick='this.previousSibling.value=8-this.previousSibling.value' name='oui"+ (index+1) +"'> </td> </fieldset> </tr>");
		 	});
		 })
		 .fail(function() {
		 	console.log("error");
		 })
		 .always(function() {
		 	console.log("complete");
		 });
		 
	});
});