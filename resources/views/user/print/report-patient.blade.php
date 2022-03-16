<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="print" />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <title>Rapport Patient</title>
    <style type="text/css">
        body {
            font-family: Rubik;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 700px;
            min-width: 400px;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid gray;
        }

        th,
        td {
            height: 24px;
            padding: 4px;
            vertical-align: middle;
        }

        .page-qr {
            page-break-after: always;
            page-break-inside: avoid;

        }

    </style>
</head>

<body>

    {{-- @if (Auth::user()->can('hospitalisations.print')) --}}
    <div class="container-fluid">
        <img src="{{ asset('/images/logo_chut.png') }}" class="center-block">
        <h4 class="text-center">Centre Hospitalo-Universitaire de Tlemcen</h4>
        <h4 class="text-center">Dr Tidjani Damerdji 05, Bd Mohammed V - Tlemcen</h4>
        <h4 class="text-center">chut@chu-tlemcen.dz</h4>
        <h4 class="text-center">043 41.72.34</h4><br />

        <h3 style="color:#333399;"><B> Dossier médical de {{ $patient->nom }}
                {{ $patient->prenom }} </B></h3>
        <br />
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
        <br /><i>Créé le : </i>{{ $patient->created_at }}
        <i>. Mis à jour le :</i>{{ $patient->updated_at }}
        <br />
        <h4 style="color:#333399;">
            <b>
                <u>Fiche Administrative</u>
            </b>
        </h4>
        <table cellpading="5">
            <tr>
                <td><b>Nom</b></td>
                <td>{{ $patient->nom }}</td>
                <td class="text-center" ROWSPAN="4">
                    <img src="/images/avatar/{{ $patient->photo }}" alt="Logo" style="width:100px;height:100px;" />
                </td>
            </tr>
            <tr>
                <td><b>Pr&eacute;nom</b></td>
                <td>{{ $patient->prenom }}</td>
            </tr>
            <tr>
                <td><b>Date de naissance</b></td>
                <td>{{ $patient->date_naissance }}</td>
            </tr>
            <tr>
                <td><b>Lieu de naissance</b></td>
                <td>{{ $patient->communes->name }}</td>
            </tr>
            <tr>
                <td><b>Adresse</b></td>
                <td colspan="2">{{ $patient->adresse ? $patient->adresse : '/' }}</td>
            </tr>
            <tr>
                <td><b>T&eacute;l&eacute;phone</b></td>
                <td colspan="2">{{ $patient->num_tel_1 }}</td>
            </tr>
            <tr>
                <td><b>Situation familiale</b></td>
                <td colspan="2">
                    {{ $patient->situation_familliale }}<br />
                    @if ($patient->nbre_enfants == '') 0 enfants
                    @else {{ $patient->nbre_enfants }} enfants
                    @endif
                </td>
            </tr>
            <tr>
                <td><b>Profession</b></td>
                <td colspan="2">
                    {{ $patient->travaille ? $patient->travaille : '/' }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>N&#176; S&eacute;c. sociale</b>
                </td>
                <td colspan="2">{{ $patient->num_securite_sociale ? $patient->num_securite_sociale : '/' }}</td>
            </tr>
            <tr>
                <td><b>N&#176; National d'identité</b></td>
                <td colspan="2">{{ $patient->code_national ? $patient->code_national : '/' }}</td>
            </tr>

            <tr>
                @if ($patient->medecinTraitant)
                    <td><b>Médecin traitant</b></td>
                    <td colspan="2">Docteur {{ $patient->medecinTraitant->name }}
                        {{ $patient->medecinTraitant->prenom }}
                    </td>
                @endif
            </tr>
        </table>

        <br />

        @if (isset($data['a']))
            <h4 style="color:#333399;"><B> <u>Ant&eacute;c&eacute;dents</u> </B></h4>
            <table CELLPADDING="5">
                <tr>
                    <td><b>Ant&eacute;c&eacute;dents m&eacute;dicaux et facteurs de risque</b></td>
                    <td>
                        @if (count($patient->pathologies) != 0)
                            <p>
                                @foreach ($patient->pathologies as $path)
                                    {{ strtolower($path->pathologie) }}
                                    {{ $patient->pathologies != '' ? ',' : ' ' }}
                                @endforeach
                            </p>
                        @else /
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Ant&eacute;c&eacute;dents chirurgicaux et obst&eacute;tricaux</b> </td>
                    <td>
                        @if (count($patient->operations) != 0)
                            <p>
                                @foreach ($patient->operations as $all)
                                    {{ $all->nom }} {{ $patient->operations != '' ? ',' : '' }}
                                @endforeach
                            </p>
                        @else /
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Ant&eacute;c&eacute;dents familiaux</b></td>
                    <td>
                        @if (count($patient->antecedentsFamilliaux) != 0)
                            <p>
                                @foreach ($patient->antecedentsFamilliaux as $ant)
                                    {{ strtolower($ant->pathologie) }}
                                    {{ $patient->antecedentsFamilliaux != '' ? ',' : '' }}
                                @endforeach
                            </p>
                        @else /
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Allergies et intol&eacute;rances</b></td>
                    <td>
                        @if (count($patient->allergies) != 0)

                            <p>
                                @foreach ($patient->allergies as $all)
                                    {{ strtolower($all->allergie) }} {{ $patient->allergies != '' ? ',' : '' }}
                                @endforeach
                            </p>
                        @else /
                        @endif
                    </td>
                </tr>
            </table>
            <br />
        @endif

        @if (isset($data['b']))
            <h4 style="color:#333399;"><B> <u>Biom&eacute;trie</u> </B></h4>

            <table CELLPADDING="4">
                <tr>
                    <td><b>Taille</b></td>
                    <td>
                        @if ($patient->taille != '')
                            {{ $patient->taille }} cm
                        @else /
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Poids</b></td>
                    <td class="text-center">
                        {{ $patient->poids ? $patient->poids . 'kg' : '/' }}
                    </td>

                <tr>
                    <td><b>Groupe sanguin</b></td>
                    <td> {{ $patient->groupe_sanguin ? $patient->groupe_sanguin : '/' }}</td>
                </tr>
            </table>
            <br />
        @endif

        @if (isset($data['c']))
            @if (count($patient->consultationsDesc) != 0)
                <h4 style="color:#333399;"><B> <u>Historique des consultations</u> </B></h4>
                <table CELLPADDING="5">
                    <tr bgcolor=#F2F2F2>
                        <td><b>Date</b></td>
                        <td><b>Motif</b></td>
                        <td class="text-center"><b>Observation</b></td>
                        <td><b>Compte Rendu</b></td>
                        <td class="text-center"><b>Examen Physique</b></td>
                    </tr>
                    @foreach ($patient->consultationsDesc as $resultat)
                        <tr>
                            <td><A NAME="950928">{{ $resultat->date_consultation }}</td>
                            <td class="text-center">{{ $resultat->motif }}</td>
                            <td>
                                @if (count($resultat->signes) != 0)
                                    @php
                                        $text = '';
                                        foreach ($resultat->signes as $signe) {
                                            $text .= $signe->name . ($resultat->signes != '' ? ',' : ' ');
                                        }
                                    @endphp
                                @else
                                    /
                                @endif
                            </td>
                            @if ($resultat->compte_rendu == '')
                                <td>/</td>
                            @else
                                <td>{{ $resultat->compte_rendu }}</td>
                            @endif
                            @if ($resultat->examen == '')
                                <td>/</td>
                            @else
                                <td>{{ $resultat->examen }}</td>
                            @endif
                        </tr>
                        @if ($resultat->orientation != '')
                            <tr>
                                <td colspan="2">Orientation</td>
                                <td colspan="3">{{ $resultat->orientation }}</td>
                            </tr>
                        @endif
                        @if ($resultat->certificat != '')
                            <tr>
                                <td colspan="2">Certificat</td>
                                <td colspan="3">{{ $resultat->certificat }}</td>
                            </tr>
                        @endif

                    @endforeach
                </table>
            @endif
        @endif
        <br />

        @if (isset($data['p']) || isset($data['aa']) || isset($data['ch']) || isset($data['e']))

            <h4 style="color:#333399;"><B> <u>Prescriptions</u> </B></h4>

            <br />
            @if (isset($data['p']))
                @if (count($patient->prescriptionsDesc) != 0)

                    <h4 style="color:#333399;"><B> <u>Prescription médicament</u> </B></h4>

                    <table>
                        <thead>
                            <tr bgcolor="#F2F2F2">
                                <th class="text-center">Num°:</th>
                                <th class="text-center">Date Prescription</th>
                                <th class="text-center">Prescripteur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->prescriptionsDesc as $prescription)

                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td> {{ $prescription->date_prescription }} </td>
                                    <td> Dr.{{ $prescription->prescripteur->name }}
                                        {{ $prescription->prescripteur->prenom }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 0 !important;">
                                        <div>
                                            <table>
                                                @foreach ($prescription->lignes as $ligne)
                                                    <tr>
                                                        <th> {{ $loop->index + 1 }} </th>

                                                        <th>
                                                            @php
                                                                $resultats = DB::table('cosac_compo_subact')
                                                                    ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                                    ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                                    ->get();
                                                                foreach ($resultats as $key => $resultat) {
                                                                    echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                                }
                                                            @endphp
                                                            Voie : {{ $ligne->voie }}.
                                                            {{ $ligne->dose_matin ? $ligne->dose_mat . ' ' . $ligne->unite . ' le Matin,' : '' }}
                                                            {{ $ligne->dose_midi ? $ligne->dose_mid . ' à Midi,' : '' }}
                                                            {{ $ligne->dose_soir ? $ligne->dose_soi . ' le Soir,' : '' }}
                                                            {{ $ligne->dose_avant_coucher ? $ligne->dose_ac . ' Avant coucher,' : '' }}
                                                            Pendant : {{ $ligne->nbr_jours }} jours.
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            @endif
            <br>
            {{-- @if (isset($data['aa']))
                    @if (count($patient->actDesc) != 0)
                        <h4 style="color:#333399;"><B> <u>Prescription Acte</u> </B></h4>

                        <table CELLPADDING="5">
                            <tr bgcolor="#F2F2F2">
                                <td><b>Nom Act</b></td>
                                <td><b>Description</b></td>
                                <td><b>Date Act</b></td>
                            </tr>

                            @foreach ($patient->actDesc as $valeur)
                                <tr>
                                    <td class="text-center">{{ $valeur->act_desc->nom }}</td>
                                    <td class="text-center">{{ $valeur->description }}</td>
                                    <td class="text-center">{{ $valeur->date_act }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                @endif --}}
            <br>
            @if (isset($data['e']))
                @if (count($patient->bilansDesc) != 0)
                    <h4 style="color:#333399;"><B> <u>Prescription Examen</u> </B></h4>

                    <table>
                        <thead bgcolor="#F2F2F2">
                            <tr>
                                <th>Type Bilan </th>
                                <th>Type élement </th>
                                <th>Valeur </th>
                                <th>Min </th>
                                <th>Max </th>
                                <th>Unité </th>
                                <th>Date d'analyse </th>
                                <th>Status </th>
                                <th>Laboratoire </th>
                                <th>Commentaire </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->bilansDesc as $bilan)
                                @if ($bilan->element)
                                    <td> {{ $bilan->element->bilan }} </td>
                                    <td> {{ $bilan->element->element }} </td>
                                    <td> {{ $bilan->valeur }} </td>
                                    <td> {{ $bilan->element->minimum }} </td>
                                    <td> {{ $bilan->element->maximum }} </td>
                                    <td> {{ $bilan->element->unite }} </td>
                                    <td> {{ $bilan->date_analyse }} </td>
                                    <td>
                                        @if ($bilan->valeur > $bilan->element->maximum)
                                            <i class="fa fa-chevron-circle-up " style="color:red; font-size:22px;"></i>
                                        @elseif($bilan->valeur < $bilan->element->minimum)
                                                <i class="fa fa-chevron-circle-down "
                                                    style="color: red; font-size:22px;"></i>
                                            @elseif($bilan->valeur < $bilan->element->minimum)
                                                    <i class="fa fa-chevron-circle-down "
                                                        style="color: red; font-size:22px;"></i>
                                                @elseif($bilan->valeur > $bilan->element->maximum)
                                                    <i class="fa fa-chevron-circle-up "
                                                        style="color: red; font-size:22px;"></i>
                                                @else
                                                    <i class="fa fa-check-circle"
                                                        style="color: green; font-size:22px;"></i>
                                        @endif
                                    </td>
                                    <td>{{ $bilan->laboratoire ?? '-' }}</td>
                                    <td>{{ $bilan->commentaire ?? '-' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
            <br>
            @if (isset($data['ch']))

                @if (count($patient->traitementsDesc) != 0)
                    <h4 style="color:#333399;"><B> <u>Prescription Chronique</u> </B></h4>

                    <table>
                        <thead bgcolor="#F2F2F2">
                            <tr>
                                <th>Médicament (DCI)</th>
                                <th>Voie</th>
                                <th>Matin</th>
                                <th>Midi</th>
                                <th>Soir</th>
                                <th>Avant coucher</th>
                                <th>Unité</th>
                                <th>Médecin externe</th>
                                <th>Status</th>
                                <th>Le</th>
                                <th>Hopital</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patient->traitementsDesc as $ligne)
                                <tr>
                                    <th>
                                        @php
                                            $resultats = DB::table('cosac_compo_subact')
                                                ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                ->get();
                                            foreach ($resultats as $key => $resultat) {
                                                echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                            }
                                        @endphp
                                    </th>
                                    <th> {{ $ligne->voie }} </th>
                                    <td> {{ $ligne->dose_matin }} {{ $ligne->repas_matin }} </td>
                                    <td> {{ $ligne->dose_midi }} {{ $ligne->repas_midi }} </td>
                                    <td> {{ $ligne->dose_soir }} {{ $ligne->repas_soir }} </td>
                                    <td> {{ $ligne->dose_avant_coucher }} </td>
                                    <td> {{ $ligne->unite }} </td>
                                    <td>{{ $ligne->medecin_externe ? 'Dr.' . $ligne->medecin_externe : '-' }}
                                    </td>
                                    <td>
                                        @if ($ligne->etats == 'En cours' || $ligne->etats == 'Reprise')
                                            <span class="label label-success">{{ $ligne->etats }} </span>
                                        @else
                                            <span class="label label-danger">{{ $ligne->etats }}</span>
                                        @endif
                                    </td>
                                    <td> {{ $ligne->date_etats }} </td>
                                    <td>
                                        @if ($ligne->status_hopital == '1') H
                                        @else V @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif


            @endif
            <br>
        @endif

        @if (isset($data['h']))
            @if (count($patient->hospiDesc) != 0)
                <h4 style="color:#333399;"><B> <u>Hospitalisations</u> </B></h4>
                <table>
                    <thead bgcolor="#F2F2F2">
                        <tr>
                            <th>Num:</th>
                            <th>Hopital</th>
                            <th>Service </th>
                            <th>Num Billet</th>
                            <th>Chambre</th>
                            <th>Lit</th>
                            <th>Motif</th>
                            <th>Date Admission</th>
                            <th>Date Sortie</th>
                            <th>Motif de sortie</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($patient->hospiDesc as $ho)
                            <tr>
                                <td> {{ $loop->index + 1 }} </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="{{ $ho->hopital }}">{{ $ho->hopital ? $ho->hopital : '/' }}
                                    </span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="{{ $ho->service }}">{{ $ho->service ? $ho->service : '/' }}
                                    </span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="{{ $ho->num_biais }}">
                                        {{ $ho->num_biais ? $ho->num_biais : '/' }}
                                    </span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span
                                        title="{{ $ho->chambre }}">{{ $ho->chambre ? $ho->chambre : '/' }}</span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="{{ $ho->lit }}">{{ $ho->lit ? $ho->lit : '/' }}</span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="{{ $ho->motifs }}">{{ $ho->motifs ? $ho->motifs : '/' }}</span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span
                                        title="{{ $ho->date_admission }}">{{ $ho->date_admission ? $ho->date_admission : '/' }}</span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span
                                        title="{{ $ho->date_sortie }}">{{ $ho->date_sortie ? $ho->date_sortie : '/' }}</span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    @if ($ho->motif_sortie == 'autre')
                                        Vers
                                        {{ $ho->service_transfert ? $ho->service_transfert : '/' }}
                                    @elseif($ho->motif_sortie == 'hopital')
                                        Sortie du CHU
                                    @elseif($ho->motif_sortie == 'décés')
                                        Décédé
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @endif
        @endif
        <br>

        @if (isset($data['ph']))
            @if (count($patient->phytosDesc) != 0)
                <h4 style="color:#333399;"><B> <u>Phytothérapie</u> </B></h4>
                <table>
                    <thead bgcolor="#F2F2F2">
                        <tr>
                            <th> Num°: </th>
                            <th>Plante (FR) </th>
                            <th>Plante (AR) </th>
                            <th>Utilisation </th>
                            <th>Fréquence </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patient->phytosDesc as $phyto)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $phyto->produit['produit_naturel_fr'] }}</td>
                                <td>{{ $phyto->produit['produits_arabe'] }}</td>
                                <td>{{ $phyto->utilisation ? $phyto->utilisation->pathologie : '' }}
                                </td>
                                <td>{{ $phyto->frequence }} {{ $phyto->frequence_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif
        <br>

        @if ($patient->lastEducations)
            <h4 style="color:#333399;"><B> <u>Rapport Education Thérapeutique</u> </B></h4>
            <p>
                {{ $patient->lastEducations->description }}
            </p>

        @endif

        <br><br>
        @if (isset($data['r']))

            @if (count($patient->radiosDesc) != 0)
                <h4 style="color:#333399;"><B> <u>Radiologies et Imageries</u> </B></h4>

                @foreach ($patient->radiosDesc as $url)
                    <img src="/storage/{{ $url->fichier }}" alt="">
                    <p>{{ $url->created_at }}</p>
                @endforeach
                <br />
                <br />
            @endif
        @endif
        {{-- <div class="page-qr"></div> --}}
        <div class="container text-center">

            <div id="qrcode" style=" display: inline-block; "></div>
        </div>
    </div>
</body>
<script src="{{ asset('plugins/jquery/js/jquery.js') }}"></script>
<script src="{{ asset('/plugins/qrcode/qrcode.js') }}"></script>

<script type="text/javascript">
    $(window).on("load", function() {
        var patient_id = $("input[name='patient_id']").val();
        var qr = new QRCode(document.getElementById("qrcode"), {
            text: "https://medicaments.hic-sante.com/patient/" + patient_id + "/edit",
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        // qrcode.makeCode(qr); // make another code.
        window.print();
    });

</script>

</html>
