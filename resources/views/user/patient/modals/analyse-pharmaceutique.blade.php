{{-- Modal : Analyse Pharmaceutique --}}
<div class="modal fade in" id="modal_analyse_pharm">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Résultat d'analyses</h4>
            </div>

            <form action="{{ route('analyse.store') }}" method="POST" id="formInterventions">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" id="tablist">
                            <li role="presentation" class="active"><a href="#theriaque" aria-controls="theriaque"
                                    role="tab" data-toggle="tab">Thériaque</a></li>
                            <li role="presentation"><a href="#interne" aria-controls="interne" role="tab"
                                    data-toggle="tab">Banque Interne</a></li>
                        </ul>

                        <div class="tab-content">
                            <!--ici c'est le contenu de l'onglet 1-->
                            <div class="tab-pane active" id="theriaque">
                                <div class="table-responsive">
                                    <table class="analyse_table table table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr class="text-center text-bold bg-gray">
                                                <td>Niveau</td>
                                                <td>Médicament</td>
                                                <td>Détails</td>
                                                <td style="width: 300px">Problèmes</td>
                                                <td>Commentaire</td>
                                                <td>Intervention pharmaceutique</td>
                                                <td>Commentaire</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>



                            <div role="tabpanel" class="tab-pane" id="interne">
                                <table class="table table-bordered analyse_table_interne">
                                    <thead>
                                        <tr>
                                            <th>Détails</th>
                                            <th style="width: 300px">Problèmes</th>
                                            <th>Commentaire</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="bg-red">
                                Problème majeur:
                                <select class="form-control" name="first_prob">
                                    <option></option>
                                    <option>Non conformité aux référentiel ou Contre indication</option>
                                    <option>Indication non traitée</option>
                                    <option>Sous dosage</option>
                                    <option>Surdosage</option>
                                    <option>Médicament non indiqué</option>
                                    <option>Interaction : A prendre en compte</option>
                                    <option>Interaction : Précaution d’emploi</option>
                                    <option>Interaction : Association déconseillée</option>
                                    <option>Interaction : Association contre-indiquée</option>
                                    <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS ) </option>
                                    <option>Voie et/ou administration inappropiée</option>
                                    <option>Traitement non reçu</option>
                                    <option>Monitorage à suivre</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="bg-orange">
                                Problème Modéré :
                                <select class="form-control" name="second_prob">
                                    <option></option>
                                    <option>Non conformité aux référentiel ou Contre indication</option>
                                    <option>Indication non traitée</option>
                                    <option>Sous dosage</option>
                                    <option>Surdosage</option>
                                    <option>Médicament non indiqué</option>
                                    <option>Interaction : A prendre en compte</option>
                                    <option>Interaction : Précaution d’emploi</option>
                                    <option>Interaction : Association déconseillée</option>
                                    <option>Interaction : Association contre-indiquée</option>
                                    <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS ) </option>
                                    <option>Voie et/ou administration inappropiée</option>
                                    <option>traitement non reçu</option>
                                    <option>Monitorage à suivre</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="bg-yellow-gradient">
                                Problème mineur :
                                <select class="form-control" name="third_prob">
                                    <option></option>
                                    <option>Non conformité aux référentiel ou Contre indication</option>
                                    <option>Indication non traitée</option>
                                    <option>Sous dosage</option>
                                    <option>Surdosage</option>
                                    <option>Médicament non indiqué</option>
                                    <option>Interaction : A prendre en compte</option>
                                    <option>Interaction : Précaution d’emploi</option>
                                    <option>Interaction : Association déconseillée</option>
                                    <option>Interaction : Association contre-indiquée</option>
                                    <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS ) </option>
                                    <option>Voie et/ou administration inappropiée</option>
                                    <option>traitement non reçu</option>
                                    <option>Monitorage à suivre</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="accord_patient" class="label-control"> Accord Patient ?

                                <select name="patient_decision" class="form-control">
                                    <option value="2"></option>
                                    <option value="1">Accepter</option>
                                    <option value="3">Refuser</option>
                                </select>

                            </label>

                            <label for="accord_pharmacien" class="label-control"> Accord Pharmacien ?

                                <select name="pharmacien_decision" class="form-control">
                                    <option value="2"></option>
                                    <option value="1">Accepter</option>
                                    <option value="3">Refuser</option>
                                </select>

                            </label>
                        </div>
                    </div>






                    <input type="hidden" name="patient_id" value="{{ $patient->id }}" />
                    <input type="hidden" name="presc_id" />
                    <div class="col-sm-8">
                        <textarea name="global_comment" class="form-control" rows="4" cols="10"
                            placeholder="Commentaires global (optionnel)...."></textarea>
                    </div>
                    <input type="reset" class="btn btn-default " data-dismiss="modal" value="Fermer">
                    <input type="submit" class="btn btn-primary " value="Confirmer">
                </div>
            </form>
        </div>
    </div>
</div>



{{-- <div class="modal fade in" id="modal_alertes">
    <div class="modal-dialog modal-xl">
        <div class="modal-content table-responsive">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title alrt_med"></h4>
            </div>
            <div class="modal-body" class="table-responsive">
                <div class="row">

                    <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse1">Contre Indication</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class=" treeview"><a href="#tab_112" data-toggle="tab"><i
                                                    class="fa fa-wheelchair"></i> <span>Patient</span>
                                                <span class="pull-right-container i1">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class="treeview"><a href="#tab_114" data-toggle="tab"><i
                                                    class="fa fa-flask"></i> <span>Médicament</span>
                                                <span class="pull-right-container i2">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class=" treeview"><a href="#tab_113" data-toggle="tab"><i
                                                    class="fa fa-leaf"></i> <span>Produit Alimentaire</span>
                                                <span class="pull-right-container i3">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class=" treeview"><a href="#tab_115" data-toggle="tab"><i
                                                    class="fa fa-flask"></i> <span>Posologie</span>
                                                <span class="pull-right-container i4">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse2">Association Déconseillée</a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse in">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class=" treeview "><a href="#tab_116" data-toggle="tab"><i
                                                    class="fa fa-wheelchair"></i> <span>Patient</span>
                                                <span class="pull-right-container i5">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class=" treeview"><a href="#tab_117" data-toggle="tab"><i
                                                    class="fa fa-flask"></i> <span>Médicament</span>
                                                <span class="pull-right-container i6">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class=" treeview"><a href="#tab_118" data-toggle="tab"><i
                                                    class="fa fa-leaf"></i> <span>Produit Alimentaire</span>
                                                <span class="pull-right-container i7">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse3">Précaution d'emploi</a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse in">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class=" treeview"><a href="#tab_119" data-toggle="tab"><i
                                                    class="fa fa-wheelchair"></i> <span>Patient</span>
                                                <span class="pull-right-container i8">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class=" treeview"><a href="#tab_120" data-toggle="tab"><i
                                                    class="fa fa-flask"></i> <span>Médicament</span>
                                                <span class="pull-right-container i9">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class=" treeview"><a href="#tab_121" data-toggle="tab"><i
                                                    class="fa fa-leaf"></i> <span>Produit Alimentaire</span>
                                                <span class="pull-right-container i10">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                        <li class=" treeview"><a href="#tab_122" data-toggle="tab"><i
                                                    class="fa fa-flask"></i> <span>Redondance</span>
                                                <span class="pull-right-container i11">
                                                    <i class="fa fa-angle-right pull-right"></i>
                                                </span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9">
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_112">
                                <div class="box box-danger">

                                    <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>
                                        <strong>Contre indication!</strong> Patient.
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="patient_ci_table">
                                            <thead>
                                                <tr>
                                                    <th>Type de terrain </th>
                                                    <th> Terrain patient</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_114">
                                <div class="box box-danger">
                                    <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>
                                        <strong>Contre indication!</strong> Médicament.
                                    </div>
                                    <div class="box-body">

                                        <table class="table" id="med_interaction_ci_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_113">
                                <div class="box box-danger">
                                    <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>
                                        <strong>Contre indication!</strong> Produit alimentaire.
                                    </div>

                                    <div class="box-body">
                                        <table class="table table-striped" id="produit_ci_table">
                                            <!-- <thead>
            <tr>
             <th>Produit Alimentaire</th>
             <th>Type d'effet </th>
             <th>Effet</th>
            </tr>
           </thead> -->
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_115">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h2>Contre indication : Posologie</h2>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="posologie_ci_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab_116">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h1>Association Déconseillée : Patient</h1>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="patient_ad_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_117">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h1>Association Déconseillée : Médicament</h1>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="med_interaction_ad_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_118">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h1>Association Déconseillée : Produit alimentaire</h1>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="produit_ad_table">
                                            <thead>
                                                <tr>
                                                    <th>Produit Alimentaire</th>
                                                    <th>Type d'effet </th>
                                                    <th>Effet</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_119">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h1>Précaution d'emploi : Patient</h1>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="patient_pe_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_120">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h1>Précaution d'emploi : Médicament</h1>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="med_interaction_pe_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_121">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h1>Précaution d'emploi : Produit alimentaire</h1>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="produit_pe_table">
                                            <thead>
                                                <tr>
                                                    <th>Produit Alimentaire</th>
                                                    <th>Type d'effet </th>
                                                    <th>Effet</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_122">
                                <div class="box box-danger">

                                    <div class="box-header alert-danger">
                                        <h1>Précaution d'emploi / Redondance</h1>
                                    </div>

                                    <div class="box-body">
                                        <table class="table" id="redondance_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</div> --}}
<div class="modal fade in" id="modal_alertes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="bg-blue-active modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title alrt_med"></h4>
            </div>
            <div class="modal-body" class="table-responsive">
                <div class="box-group" id="alertes_accordion">

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade in" id="modal_executer">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="bg-blue modal-header ">
                <h4 class="modal-title col-sm-4">Résultats D'analyses Pharmaceutiques</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="">
                            <div class="col-sm-3 alert alert-danger pt-1 no-border pl-1 pr-0 pri" hidden></div>
                            <div class="col-sm-3 alert alert-warning pt-1 no-border pl-1 pr-0 sec" hidden></div>
                            <div class="col-sm-3 alert alert-success pt-1 no-border pl-1 pr-0 sef" hidden></div>
                            <div class="col-sm-3 alert bg-gray pt-1 no-border pl-1 pr-0 det" hidden></div>
                        </div>
                        <table class="execute_table table table-bordered table-stripede">
                            <thead class="text-nowrap bg-gray">
                                <tr>
                                    <th>Médicament A</th>
                                    <th>Médicament(s) B</th>
                                    <th>Problèmes</th>
                                    <th>Intervention Pharmacien</th>
                                    <th>Commentaire</th>
                                    <th>Accepter</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-4">
                        <input type="textarea" name="refus" size="50" height="3" placeholder="Motifs de refus......"
                            class="form-control pull-left refus" disabled="true">
                    </div>
                    <input type="reset" class="btn btn-default" data-dismiss="modal" value="Fermer">
                    <input type="submit" class="btn btn-primary" value="Valider mon Avis">
                </div>
            </form>
        </div>
    </div>
</div>
