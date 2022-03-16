jQuery(document).ready(function($){
        var options = {
            url: function(phrase) {
                return "/api/medicament/"+ phrase;
             },

            getValue: function(element) {
                return element.SP_NOM;
            },

            // template: { // pour ajouter le type du mot recherché : {Médicament, DCI , Classes}
            //  type: "description",
            //  fields: {
            //      description: "type"
            //  }
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
                        return "<a href='/medicaments/" + item.SP_CODE_SQ_PK + "' >" + value + "</a>";
                }
            },

            ajaxSettings: {
                headers : {"X-CSRF-TOKEN" : $("meta[name='csrf-token']").attr("content")},
                dataType: "json",
                method: "POST",
                data: {
                  dataType: "json"
                }
            },

            preparePostData: function(data) { //This is function is invoked just before sending ajax request
                data.phrase = $("#med_search").val();
                return data;
            },

            requestDelay: 400,

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

                theme: "square", cssClasses: "w-100",

                adjustWidth: false          
        };

        $("#med_search").easyAutocomplete(options);

    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings("a.active").removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});

