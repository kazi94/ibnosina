<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>FAQ-Foire au questions </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/plugins/adminlte2/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="/plugins/datatable-1.10.24/datatables.min.css">
    <link rel="stylesheet" href="/plugins/select2/dist/css/select2.min.css">
    <script src="{{ asset('plugins/toastr/toastr.css') }}"> </script>
    <link rel="stylesheet" href="/plugins/jquery/css/jquery_ui.min.css">

    <script src="{{ asset('/plugins/jquery/js/jquery.min.js') }}"> </script>
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"> </script>
</head>

<body style="font-size: 20px">

    <div class="container">

        <div class="page-header">
            <h1>AnaPharmDz FAQ <small>Questions fréquement posés</small></h1>
        </div>

        <!-- Bootstrap FAQ - START -->
        <div class="container">
            <br />
            <br />
            <br />

            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                Cette section contient les informations nécessaires en relation avec l'utilisation de l'application
                <strong>AnaPharmaDz</strong> et ses fonctionnalités. Si vous ne trouvez pas des réponses à vos
                questiuons,
                Veuillez nous contactez sur l'adresse email suivante : contact@hic-sante.com
            </div>

            <br />

            <div class="panel-group" id="accordion">
                <div class="faqHeader">Questions générales</div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseOne">A-propos de la gestion des droits d'accés?</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            Dans la page ajouter profile l'administrateur peut ajouter les futurs profils des
                            utilsateurs , ainisi que les droits d'accés sur l'application , nous démontrons les
                            fonctions de chaque droit d'accés ci dessous :
                            <ul>
                                <li><strong>Détails :</strong> ce droit est gérer seulement pour le cas du dossier
                                    patient, Il permet à l'utilisateur de percevoir le détails du patient , en d'autre
                                    terme le DMP : dossier médicale patient</li>
                                <li><strong>Lister :</strong> Permet à l'utilisateur d'afficher la liste des objets en
                                    question (Format tableau ou autre type de liste).Exemple : liste patient , liste
                                    questionnaire , liste bilans , liste interventions....</li>
                                <li><strong>Modifier , ajouté , supprimer</strong> <strong>...!!</strong></li>
                                <li><strong>Modifier patient :</strong> permet de modifier le profils patient :
                                    informations sociaux/professionnels : nom , prénom , adresse , poids,... et
                                    informations médicales : chambre, lits....</li>
                                <li><strong>Cloner prescription :</strong> permet à l'utilisateur de modifier de cloner
                                    la prescription à risque et analyser par le pharamcien , la prescription à cloner
                                    contient les interventions du pharamcien pour chaque médicaments prescrits</li>
                                <li><strong>Peut faire l'analyse pharamceutique :</strong> Pour définir le pharmacien
                                    qui peut faire l'analyser pharamceutique , et aussi pour ajouter les médicaments de
                                    ville</li>
                                <li><strong>Médecin prescripteur :</strong> permet à l'utilisateur possédant le droit ,
                                    de valider ou refuser les médicametnts de ville ajouté par le pharmacien qui possède
                                    le droits d'accés : 'Peut faire l'analyser pharmaceutique</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseTen">Je veux changer mon adresse email et mon mots de passe?</a>
                        </h4>
                    </div>
                    <div id="collapseTen" class="panel-collapse collapse">
                        <div class="panel-body">
                            Vous désirez changer de mots ou d'adresse email , pour des questions d'intégrité et de
                            confidentialité , c'est simple ! Contactez l'équipe d'administration sur l'adresse email
                            suivante: <strong>'contact@hic-sante.com'</strong> . Veuillez indiquer votre adresse email ,
                            ou votre numéro de téléphone dans votre message , pour vous transmettre les nouvelles
                            informations en retour.
                        </div>
                    </div>
                </div>

                <!--         <div class="faqHeader">Sellers</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Who cen sell items?</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    Any registed user, who presents a work, which is genuine and appealing, can post it on <strong>PrepBootstrap</strong>.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">I want to sell my items - what are the steps?</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    The steps involved in this process are really simple. All you need to do is:
                    <ul>
                        <li>Register an account</li>
                        <li>Activate your account</li>
                        <li>Go to the <strong>Themes</strong> section and upload your theme</li>
                        <li>The next step is the approval step, which usually takes about 72 hours.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">How much do I get from each sale?</a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
                <div class="panel-body">
                    Here, at <strong>PrepBootstrap</strong>, we offer a great, 70% rate for each seller, regardless of any restrictions, such as volume, date of entry, etc.
                    <br />
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Why sell my items here?</a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse">
                <div class="panel-body">
                    There are a number of reasons why you should join us:
                    <ul>
                        <li>A great 70% flat rate for your items.</li>
                        <li>Fast response/approval times. Many sites take weeks to process a theme or template. And if it gets rejected, there is another iteration. We have aliminated this, and made the process very fast. It only takes up to 72 hours for a template/theme to get reviewed.</li>
                        <li>We are not an exclusive marketplace. This means that you can sell your items on <strong>PrepBootstrap</strong>, as well as on any other marketplate, and thus increase your earning potential.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">What are the payment options?</a>
                </h4>
            </div>
            <div id="collapseEight" class="panel-collapse collapse">
                <div class="panel-body">
                    The best way to transfer funds is via Paypal. This secure platform ensures timely payments and a secure environment. 
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseNine">When do I get paid?</a>
                </h4>
            </div>
            <div id="collapseNine" class="panel-collapse collapse">
                <div class="panel-body">
                    Our standard payment plan provides for monthly payments. At the end of each month, all accumulated funds are transfered to your account. 
                    The minimum amount of your balance should be at least 70 USD. 
                </div>
            </div>
        </div>

        <div class="faqHeader">Buyers</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">I want to buy a theme - what are the steps?</a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    Buying a theme on <strong>PrepBootstrap</strong> is really simple. Each theme has a live preview. 
                    Once you have selected a theme or template, which is to your liking, you can quickly and securely pay via Paypal.
                    <br />
                    Once the transaction is complete, you gain full access to the purchased product. 
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">Is this the latest version of an item</a>
                </h4>
            </div>
            <div id="collapseSeven" class="panel-collapse collapse">
                <div class="panel-body">
                    Each item in <strong>PrepBootstrap</strong> is maintained to its latest version. This ensures its smooth operation.
                </div>
            </div>
        </div> -->
            </div>
        </div>

        <style>
            .faqHeader {
                font-size: 27px;
                margin: 20px;
            }

            .panel-heading [data-toggle="collapse"]:after {
                font-family: 'Glyphicons Halflings';
                content: "\e072";
                /* "play" icon */
                float: right;
                color: #F58723;
                font-size: 18px;
                line-height: 22px;
                /* rotate "play" icon from > (right arrow) to down arrow */
                -webkit-transform: rotate(-90deg);
                -moz-transform: rotate(-90deg);
                -ms-transform: rotate(-90deg);
                -o-transform: rotate(-90deg);
                transform: rotate(-90deg);
            }

            .panel-heading [data-toggle="collapse"].collapsed:after {
                /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
                -webkit-transform: rotate(90deg);
                -moz-transform: rotate(90deg);
                -ms-transform: rotate(90deg);
                -o-transform: rotate(90deg);
                transform: rotate(90deg);
                color: #454444;
            }

        </style>

        <!-- Bootstrap FAQ - END -->

    </div>

</body>

</html>
