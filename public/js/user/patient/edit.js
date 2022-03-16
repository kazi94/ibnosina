    // $('[data-toggle="tooltip"]').tooltip();
    /*
     * Reload Page when user click on back button
     * It avoid confuse informations
     */
    function reloadOnBackEvent() {
        const [entry] = performance.getEntriesByType("navigation");

        // Show it in a nice table in the developer console
        //console.table(entry.toJSON());

        if (entry["type"] === "back_forward")
            location.reload();
    }
    reloadOnBackEvent();

    /* 
     * Scroll on footer on the page when page on load
     * Only on mobiles
     */
    // function scrollToBottom() {
    //     if (window.innerWidth <= 768) $('html, body').animate({
    //         scrollTop: 1200
    //     }, 1500);
    // }
    // scrollToBottom();

    /*
     * Bind shortcuts keyboard with modals
     */
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
    });

    $('input[id="maladie_nom"]').keydown(function () {
        $(this).autocomplete({
            appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
            source: function (request, response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/maladie",
                    method: "POST",
                    data: {
                        phrase: request.term // value on field input
                    },
                    success: function (data, status, code) {
                        response($.map(data.slice(0, 20), function (item) { // slice cut number of element to show
                            return {
                                label: item.pathologie, // pour afficher dans la liste des suggestions
                                value: item.pathologie, // value c la valeur à mettre dans l'input this
                                id_pathologie: item.id
                            };
                        }));
                    }
                });
            }, // END SOURCE
            select: function (event, ui) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/protocolesPathologie",
                    method: "POST",
                    data: {
                        maladie_id: ui.item.id_pathologie
                    },
                    success: function (data, status, code) {
                        $("#protocole_presc").empty();

                        data.forEach(function (d) {
                            $("#protocole_presc").append("<option value=" + d.id + ">" + d.nom + "</option>");
                        });

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
                $("#maladie_id").attr("value", ui.item.id_pathologie);
            }

        }).data("ui-autocomplete")._renderItem = function (ul, item) { //cette method permet de gérer l'affichage de la liste des suggestions


            return $("<li></li>")
                .data("item.autocomplete", item) //récupérer les donnée de l'autocomplete
                //.attr( "data-value", item.id )
                .append(item.label) //ajouter à la liste de suggestions
                .appendTo(ul);
        };
    });


    $('#tablist a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

    // Animate loader off screen
    //$(".se-pre-con").fadeOut("slow");

    $(".fold-table tr.view").on("click", function () {
        $(this).toggleClass("open").next(".fold").toggleClass("open");
    });


    $('input[type="checkbox"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green'
    });

    // $but = $('table').find('a.deleteRow');
    // $but.click(function (e) {
    //     e.stopPropagation();
    // });


    //redirect to specific tab 


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
        "scrollCollapse": true,
    });
    $("#tabtous").DataTable({
        "order": [
            [4, "asc"],
            [3, "desc"]
        ],
        "scrollX": true,
        "scrollY": "400px",
        "scrollCollapse": true,
        "paging": false
    });
    $("#example3").DataTable({
        "order": [
            [6, "desc"]
        ],
        "scrollX": true,
        "scrollY": "400px",
        "scrollCollapse": true,
        // "paging": false
    }); //analyse biologique
    $("#radio_table").DataTable({
        "order": [
            [6, "desc"]
        ],
        "scrollX": true,
        "scrollY": "400px",
        "scrollCollapse": true,
        // "paging": false
    }); //analyse biologique    
    $("#example17").DataTable({
        "order": [
            [2, "desc"]
        ],
        "scrollY": "400px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false
    }); //Historique poids
    $("#hist_presc").DataTable({
        // "ordering": false,
        "order": [
            [1, "desc"]
        ],
        // "scrollX": true,
        // "scrollY": "400px",
        // "scrollCollapse": true,
        // "paging": false
    }); //historique prescriptions
    $("#example127").DataTable({
        // "ordering": false,
        "order": [
            [1, "desc"]
        ],
    }); //Prescription			
    $("#table_injections").DataTable({
        "ordering": false,
    }); //Prescription			
    $("#example4").DataTable({
        "paging": true
    }); //traitement
    $("#example6").DataTable({
        "scrollX": true
    }); //auto
    $("#example8").DataTable({
        // "scrollY": "400px",
        // "scrollX": true,
        // "scrollCollapse": true,
        // "paging": false
    }); //phyto
    $("#example9").DataTable({
        // "scrollY": "400px",
        // "scrollX": true,
        // "scrollCollapse": true,
        // "paging": false
    }); //avis
    $("#example21").DataTable({
        "scrollX": true,
        //"scrollY": "400px",
        //"scrollCollapse": true,
        //"paging": false
    }); //questionnaire
    $("#example211").DataTable({
        "scrollX": true,
        //"scrollY": "400px",
        //"scrollCollapse": true,
        //"paging": false
    }); //Education Therapeutique
    $("#exemple16").DataTable({
        "scrollY": "400px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false
    });
    $("#table_hospitalisation").DataTable({
        // "scrollY": "400px",
        // "scrollX": true,
        // "scrollCollapse": true,
        // "paging": false
    });
    $("#table_consultation").DataTable();
    $("#table_act").DataTable({
        // "scrollY": "400px",
        // "scrollX": true,
        // "scrollCollapse": true,
        // "paging": false
    });
    $("#example10").DataTable({
        // "scrollY": "400px",
        // "scrollX": true,
        // "scrollCollapse": true,
        // "paging": false
    }); // ip a intervenir

    function lastState() {
        // set the last state of display profile patient
        if (getCookie("profileShown") == "yes") {
            // show widget profile display
            showAsideProfil();
        } else {
            //show table profile display
            showHorizontalProfil();
        }
    }
    if (window.innerWidth >= 768) {

        lastState();
    }
    /**
     * Handler changement of the display of patient profil view
     */
    $('.switch').on('click', function () {
        if ($('#card-container-modules').hasClass('col-md-12')) { // show profile display
            showAsideProfil();
            setCookie("profileShown", "yes", 43200); // Set state (expire in 30 days)
        } else {
            showHorizontalProfil();
            setCookie("profileShown", "no", 43200); // Set state (expire in 30 days)

        }
    });

    /**
     * Display Profil card in header of the sub folders interface 
     */
    function showHorizontalProfil() {
        $('#aside-profil').attr('style', 'display:none');;
        $("#card-container-modules").toggleClass("col-md-9", function () {
            $("#card-container-modules").addClass("col-md-12").removeAttr('style');
            $('#horizontal-profil').removeClass("d-md-none").attr('style', 'display:block');
        });
    }

    /**
     * Display Profil card aside of the sub folders interface 
     */
    function showAsideProfil() {
        $('#aside-profil').attr('style', 'display:block');
        $("#card-container-modules").toggleClass("col-md-12", function () {
            $('#card-container-modules').addClass("col-md-9").attr("style", "padding-left:0px;");
            $('#horizontal-profil').attr('style', 'display:none');
        });
    }

    // COOKIES DEFINITION //
    function setCookie(name, value, mins) {
        var expires = "";
        if (mins) {
            var date = new Date();
            date.setTime(date.getTime() + (mins * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
    // END COOKIES DEFINITION //


    /*Supprimer la ligne Traitement / Automédication / Prescription */
    $('table').on('click', 'a.deleteRow', function (event) {
        event.preventDefault();

        if (confirm('Vous confirmer votre suppression ?')) {
            let url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'POST',
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done((response) => {
                if (response.response == 'success') {
                    $(this).closest('tr').remove();
                    toastr.success(response.msg);
                } else toastr.error(response);
            });
        }
    });