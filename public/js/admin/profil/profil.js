	$(function(){
		$('th').click(function(){
			console.log($(this).index());
			index =  $(this).index(); // récupérer l'index de l'émeent th
			for (var i=1 ; i<=10 ; i++) {
				if ($("tr:eq("+i+") td:eq("+index+")").find('div').hasClass('checked')) {
					$("tr:eq("+i+") td:eq("+index+")").find('div').removeClass('checked').find('input').prop('checked' , false);
				} else
				$("tr:eq("+i+") td:eq("+index+")").find('div').addClass('checked').find('input').prop('checked' , true);
			}
		});
	});