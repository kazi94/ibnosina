//delete prescription
function deletePrescription(id) {
    Swal.fire({
        backdrop: `
                                        rgba(255,0,0,0.4)
                                      `,
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimez-le!',
        cancelButtonText: 'Annuler'

    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/prescriptionDelete/" + id,
                method: "GET",
                success: function (data) {
                    Swal.fire({
                        title: 'Supprimé!',
                        text: 'La Prescription a été supprimé..',
                        type: 'success',
                        onClose: function () {
                            window.location.reload();
                        }
                    })
                },
                error: function (data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Quelque chose a mal tourné!'
                    })
                }
            });
        }
    })
}
//calcule SC
function calculeSC() {
    //récupérer formule
    var formule = '{{ $formule }}';

    var taille = document.getElementById("taillecure").value;
    var poids = document.getElementById("poidscure").value;
    //replacer poids et taille dans la formule
    formule = formule.replace("POIDS", poids);
    formule = formule.replace("TAILLE", taille);

    if (taille != 0 && poids != 0) {
        var SC = math.eval(formule);
        document.getElementById("massecure").value = SC.toFixed(2);
        document.getElementById("massecuree").value = SC.toFixed(2);
    } else
        document.getElementById("massecure").value = '';
}
//commRequired
function commRequired() {
    document.getElementById("commR").hidden = false;
    document.getElementById("commmm").required = true;

}
//afficher comm arreter traitement
function afficheCommArreter(nom, comm, date) {
    var myModal = $('#modal-arreter');
    document.getElementById("arreterr").innerHTML = 'Traitement arreter par: ' + nom + ' le: ' + date + '<br>' +
        comm;
    myModal.modal({
        show: true
    });
}
//afficher comm arreter sequence
function afficheCommArreterSeq(nom, comm, date) {
    var myModal = $('#modal-arreterSeq');
    document.getElementById("arreterrseq").innerHTML = 'Prescription arreter par: ' + nom + ' le: ' + date +
        '<br>' + comm;
    myModal.modal({
        show: true
    });


}
//ajouter une cure
function addCure(id, cure_pevu) {
    $.ajax({
        //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/countCure/" + id,
        dataType: "json",
        method: "GET",
        success: function (resultat) {
            if (parseInt(resultat) == cure_pevu) {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Vous avez atteint le nombre maximum de cure prevu pour ce traitement!'
                })
            } else {
                $.ajax({
                    //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/getDateCure/" + id,
                    dataType: "json",
                    method: "GET",
                    success: function (data) {
                        var myModal = $('#modal-cure');
                        myModal.find('input[id="numeroCure"]').attr('value', parseInt(
                            resultat) + 1);
                        myModal.find('input[id="numeroCuree"]').attr('value', parseInt(
                            resultat) + 1);
                        myModal.find('input[id="datecure"]').attr('value', data);
                        myModal.find('input[id="idTraitement"]').attr('value', id);
                        myModal.find('input[id="taillecure"]').attr('value', document
                            .getElementById("taillehhid").value);
                        myModal.find('input[id="poidscure"]').attr('value', document
                            .getElementById("poidshidd").value);
                        myModal.find('input[id="massecuree"]').attr('value', document
                            .getElementById("massehidd").value);
                        myModal.find('input[id="massecure"]').attr('value', document
                            .getElementById("massehidd").value);
                        myModal.modal({
                            show: true
                        });
                    },
                    error: function (data) {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Quelque chose a mal tourné!'
                        })
                    }
                });
            }
        },
        error: function (resultat) {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Quelque chose a mal tourné!'
            })
        }
    });

}

//supp traitement
function deletetraitement(id) {
    Swal.fire({
        backdrop: `
                                        rgba(255,0,0,0.4)
                                      `,
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimez-le!',
        cancelButtonText: 'Annuler'

    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/chimio/traitement/delete/" + id,
                method: "GET",
                success: function (data) {
                    Swal.fire({
                        title: 'Supprimé!',
                        text: 'Le Traitement a été supprimé..',
                        type: 'success',
                        onClose: function () {
                            window.location.reload();
                        }
                    })
                },
                error: function (data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Quelque chose a mal tourné!'
                    })
                }
            });
        }
    })
}
//get remarque
function getRemarque(remarque) {
    //alert(remarque);
    var myModal = $('#modal-commentaire');
    //id="commt"
    if (remarque != '') {
        document.getElementById("commt").innerHTML = remarque;
    } else {
        document.getElementById("commt").innerHTML = 'Pas de commentaire a affiché';
    }


    myModal.modal({
        show: true
    });

}

//arreter traitement
function arreterTraitement(id) {

    Swal.fire({
        title: 'Pourquoi voulez vous arrêter le traitement ?',
        input: 'textarea',
        inputPlaceholder: 'Tapez votre commentaire ici...',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Arrêter',
        showCancelButton: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/chimio/traitement/arrete/" + id,
                method: "GET",
                data: {
                    id: id,
                    text: result.value
                },
                success: function () {
                    Swal.fire({
                        title: 'Arrêter!',
                        text: 'Le Traitement a été Arrêter...',
                        type: 'success',
                        onClose: function () {
                            window.location.reload();
                        }
                    })
                },
                error: function (data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Quelque chose a mal tourné!'
                    })
                }
            });
        }

    })


}

//arreter sequence
function arreterSequence(id) {

    Swal.fire({
        title: 'Pourquoi voulez vous arrêter la prescription ?',
        input: 'textarea',
        inputPlaceholder: 'Tapez votre commentaire ici...',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Arrêter',
        showCancelButton: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/chimio/sequence/arrete/" + id,
                method: "GET",
                data: {
                    id: id,
                    text: result.value
                },
                success: function () {
                    Swal.fire({
                        title: 'Arrêter!',
                        text: 'La Prescription a été Arrêter...',
                        type: 'success',
                        onClose: function () {
                            window.location.reload();
                        }
                    })
                },
                error: function (data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Quelque chose a mal tourné!'
                    })
                }
            });
        }

    })

}