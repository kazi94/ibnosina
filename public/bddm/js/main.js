
// 
	jQuery(function($){
		//$ = jQuery.noConflict(true);
		let type_search ='meds';
		// get Random Background Color
		//getRandomColor();

		// Generate Auto Refresh
		refreshPage();
		$("#type_search").change(function(){
			type_search = $(this).children('option:selected').val();
			$("#med_search").val("");
			switch (type_search) {
				case 'meds':
					$("#med_search").attr("placeholder" ,"Entrer le nom commercial d'un médicament");
					break;
				case 'sac':
					$("#med_search").attr("placeholder" ,"Entrer la substance active");
					break;
				case 'atc':
					$("#med_search").attr("placeholder" ,"Entrer la classe ATC");
					break;		
			}
		});
		
		var options = {
		    url: function(phrase) {
			    return "/api/medicament/"+ phrase +"&&type=" + type_search;
			 },

			getValue: function(element) {
			    return element.nom;
			},

			// template: { // pour ajouter le type du mot recherché : {Médicament, DCI , Classes}
			// 	type: "description",
			// 	fields: {
			// 		description: "type"
			// 	}
			// },
			
			// template: { // Ajouter un lien sur la liste 
		 	//        type: "links",
		 	//        fields: {
		 	//            link: "website-link"
		 	//        }
		 	//    },
		    template: {
				type: "custom",
				method: function(value, item) {
					if (item.type == 'meds')
						$link = "<a href='/medicaments/" + item.code + "' >" + value + "</a>";
					if (item.type == 'sac')
						$link = "<a href='/substances/" + item.code + "&&view' >" + value + "</a>";

					return $link;
				}
			},

			ajaxSettings: {
				headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
			    dataType: 'json',
			    method: "get",
			    data: {
			      dataType: "json"
			    }
			},

			preparePostData: function(data) { //This is function is invoked just before sending ajax request
			    data.phrase = $("#med_search").val();
			    return data;
			},

			// requestDelay: 400,

			list: {
					match: {
						enabled: true
					},
					maxNumberOfElements: 10,

					showAnimation: {
						type: "slide",
						time: 300
					},
					hideAnimation: {
						type: "slide",
						time: 300
					}
				},

				theme: "square", cssClasses:' col-xs-12 col-sm-9',

				adjustWidth: false			
		};

		$("#med_search").easyAutocomplete(options);
		
		$("#report_btn").click(function(){
			report();
		});



	});

	function getRandomColor() 
	{
		var letters = '0123456789ABCDEF';
		var color = '#';
		for (var i = 0; i < 6; i++) 
			color += letters[Math.floor(Math.random() * 16)];
		
		$('#searchbar').css({background:'linear-gradient(to bottom right, #575c61, '+color+')'});
	}		


	function refreshPage()
	{
		const idleDurationSecs = 610;    // X number of seconds
	    const redirectUrl = location.href;  // Redirect idle users to this URL
	    let idleTimeout; // variable to hold the timeout, do not modify		
	    let type_search="meds";
	    const resetIdleTimeout = function() {

	        // Clears the existing timeout
	        if(idleTimeout) clearTimeout(idleTimeout);

	        // Set a new idle timeout to load the redirectUrl after idleDurationSecs
	        idleTimeout = setTimeout(() => location.href = redirectUrl, idleDurationSecs * 1000);
	    };

	    // Init on page load
	    resetIdleTimeout();

	    // Reset the idle timeout on any of the events listed below
	    ['click', 'touchstart', 'mousemove'].forEach(evt => 
	        document.addEventListener(evt, resetIdleTimeout, false)
	    );
	}

	//report Function
	function report()
	{
		let $form = $("#report_form");
		$('#bug_report').modal('hide');
		$.ajax({
			url: '/bddm_report',
			headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
			type: 'get',
			data: $form.serialize(),
		})
		.done(function() {
			console.log("envoi avec succés !")
			
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});			
	}