<!--tab le devenir de l'intervention pharmaceutique-->
<div class="tab-pane {{ session('tab') == 'tab_7' ? 'active in' : '' }}" id="tab_7">
    <div class="box  box-widget">
        <div class="box-header">
            <h2>Avis sur l'IP</h2>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-sm-12 ">
                    <table id="example10" class="nowrap table table-bordered table-hover text-center">
                        <thead>
                            <tr style="background-color: #515151 !important; color:white">
                                <th>Num Prescription</th>
                                <th>Pharmacien</th>
                                <th>Date de l'IP</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patient->interventions as $intervention)
                                <tr>
                                    <th> {{ $intervention->prescription_id }}</th>
                                    <td> {{ $intervention->analyseur->name }} {{ $intervention->analyseur->prenom }}
                                    </td>
                                    <td> {{ date('d/m/Y', strtotime($intervention->date_ip)) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger execute"
                                            data-id="{{ $intervention->id }}">Consulter IP</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!--HITORIQUE DES INTERVENTIONS DU MEDECIN-->
    <div class=" box box-widget">
        <div class="box-body">
            <h2>Historique</h2>
            <div class="row">
                <div class="col-sm-12 ">
                    <table id="example9" class="table table table-bordered table-hover text-center">
                        <thead>
                            <tr role="row" style="background-color: #515151 !important; color:white">
                                <th class="sorting_asc" tabindex="0" aria-controls="example9" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending"
                                    style="width: 82px;">Num</th>
                                <th>Pharmacien</th>
                                <th>Date de l'IP</th>
                                <th>Médecin execucteur</th>
                                <!-- <th >date de l'IP médecin</th> -->
                                <!-- <th >Status</th> -->
                                <th>Motifs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->interventionsValide as $int)
                                <tr>
                                    <td> {{ $loop->index + 1 }}</td>
                                    <td> {{ $int->analyseur->name }} {{ $int->analyseur->prenom }}</td>
                                    <td> {{ date('d/m/Y', strtotime($int->date_ip)) }}</td>
                                    <td> {{ $int->executeur->name }} {{ $int->executeur->prenom }}</td>
                                    <td> {{ $int->motifs_refus != '' ? $int->motifs_refus : 'RSR' }}</td>
                                    <!-- <td></td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
