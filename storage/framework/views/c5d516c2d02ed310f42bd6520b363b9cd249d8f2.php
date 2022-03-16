<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="print" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome/css/font-awesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/fonts.css')); ?>">

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

    
    <div class="container-fluid">
        <img src="<?php echo e(asset('/images/logo_chut.png')); ?>" class="center-block">
        <h4 class="text-center">Centre Hospitalo-Universitaire de Tlemcen</h4>
        <h4 class="text-center">Dr Tidjani Damerdji 05, Bd Mohammed V - Tlemcen</h4>
        <h4 class="text-center">chut@chu-tlemcen.dz</h4>
        <h4 class="text-center">043 41.72.34</h4><br />

        <h3 style="color:#333399;"><B> Dossier médical de <?php echo e($patient->nom); ?>

                <?php echo e($patient->prenom); ?> </B></h3>
        <br />
        <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
        <br /><i>Créé le : </i><?php echo e($patient->created_at); ?>

        <i>. Mis à jour le :</i><?php echo e($patient->updated_at); ?>

        <br />
        <h4 style="color:#333399;">
            <b>
                <u>Fiche Administrative</u>
            </b>
        </h4>
        <table cellpading="5">
            <tr>
                <td><b>Nom</b></td>
                <td><?php echo e($patient->nom); ?></td>
                <td class="text-center" ROWSPAN="4">
                    <img src="/images/avatar/<?php echo e($patient->photo); ?>" alt="Logo" style="width:100px;height:100px;" />
                </td>
            </tr>
            <tr>
                <td><b>Pr&eacute;nom</b></td>
                <td><?php echo e($patient->prenom); ?></td>
            </tr>
            <tr>
                <td><b>Date de naissance</b></td>
                <td><?php echo e($patient->date_naissance); ?></td>
            </tr>
            <tr>
                <td><b>Lieu de naissance</b></td>
                <td><?php echo e($patient->communes->name); ?></td>
            </tr>
            <tr>
                <td><b>Adresse</b></td>
                <td colspan="2"><?php echo e($patient->adresse ? $patient->adresse : '/'); ?></td>
            </tr>
            <tr>
                <td><b>T&eacute;l&eacute;phone</b></td>
                <td colspan="2"><?php echo e($patient->num_tel_1); ?></td>
            </tr>
            <tr>
                <td><b>Situation familiale</b></td>
                <td colspan="2">
                    <?php echo e($patient->situation_familliale); ?><br />
                    <?php if($patient->nbre_enfants == ''): ?> 0 enfants
                    <?php else: ?> <?php echo e($patient->nbre_enfants); ?> enfants
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><b>Profession</b></td>
                <td colspan="2">
                    <?php echo e($patient->travaille ? $patient->travaille : '/'); ?>

                </td>
            </tr>
            <tr>
                <td>
                    <b>N&#176; S&eacute;c. sociale</b>
                </td>
                <td colspan="2"><?php echo e($patient->num_securite_sociale ? $patient->num_securite_sociale : '/'); ?></td>
            </tr>
            <tr>
                <td><b>N&#176; National d'identité</b></td>
                <td colspan="2"><?php echo e($patient->code_national ? $patient->code_national : '/'); ?></td>
            </tr>

            <tr>
                <?php if($patient->medecinTraitant): ?>
                    <td><b>Médecin traitant</b></td>
                    <td colspan="2">Docteur <?php echo e($patient->medecinTraitant->name); ?>

                        <?php echo e($patient->medecinTraitant->prenom); ?>

                    </td>
                <?php endif; ?>
            </tr>
        </table>

        <br />

        <?php if(isset($data['a'])): ?>
            <h4 style="color:#333399;"><B> <u>Ant&eacute;c&eacute;dents</u> </B></h4>
            <table CELLPADDING="5">
                <tr>
                    <td><b>Ant&eacute;c&eacute;dents m&eacute;dicaux et facteurs de risque</b></td>
                    <td>
                        <?php if(count($patient->pathologies) != 0): ?>
                            <p>
                                <?php $__currentLoopData = $patient->pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e(strtolower($path->pathologie)); ?>

                                    <?php echo e($patient->pathologies != '' ? ',' : ' '); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </p>
                        <?php else: ?> /
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Ant&eacute;c&eacute;dents chirurgicaux et obst&eacute;tricaux</b> </td>
                    <td>
                        <?php if(count($patient->operations) != 0): ?>
                            <p>
                                <?php $__currentLoopData = $patient->operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($all->nom); ?> <?php echo e($patient->operations != '' ? ',' : ''); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </p>
                        <?php else: ?> /
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Ant&eacute;c&eacute;dents familiaux</b></td>
                    <td>
                        <?php if(count($patient->antecedentsFamilliaux) != 0): ?>
                            <p>
                                <?php $__currentLoopData = $patient->antecedentsFamilliaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e(strtolower($ant->pathologie)); ?>

                                    <?php echo e($patient->antecedentsFamilliaux != '' ? ',' : ''); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </p>
                        <?php else: ?> /
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Allergies et intol&eacute;rances</b></td>
                    <td>
                        <?php if(count($patient->allergies) != 0): ?>

                            <p>
                                <?php $__currentLoopData = $patient->allergies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e(strtolower($all->allergie)); ?> <?php echo e($patient->allergies != '' ? ',' : ''); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </p>
                        <?php else: ?> /
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <br />
        <?php endif; ?>

        <?php if(isset($data['b'])): ?>
            <h4 style="color:#333399;"><B> <u>Biom&eacute;trie</u> </B></h4>

            <table CELLPADDING="4">
                <tr>
                    <td><b>Taille</b></td>
                    <td>
                        <?php if($patient->taille != ''): ?>
                            <?php echo e($patient->taille); ?> cm
                        <?php else: ?> /
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Poids</b></td>
                    <td class="text-center">
                        <?php echo e($patient->poids ? $patient->poids . 'kg' : '/'); ?>

                    </td>

                <tr>
                    <td><b>Groupe sanguin</b></td>
                    <td> <?php echo e($patient->groupe_sanguin ? $patient->groupe_sanguin : '/'); ?></td>
                </tr>
            </table>
            <br />
        <?php endif; ?>

        <?php if(isset($data['c'])): ?>
            <?php if(count($patient->consultationsDesc) != 0): ?>
                <h4 style="color:#333399;"><B> <u>Historique des consultations</u> </B></h4>
                <table CELLPADDING="5">
                    <tr bgcolor=#F2F2F2>
                        <td><b>Date</b></td>
                        <td><b>Motif</b></td>
                        <td class="text-center"><b>Observation</b></td>
                        <td><b>Compte Rendu</b></td>
                        <td class="text-center"><b>Examen Physique</b></td>
                    </tr>
                    <?php $__currentLoopData = $patient->consultationsDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resultat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><A NAME="950928"><?php echo e($resultat->date_consultation); ?></td>
                            <td class="text-center"><?php echo e($resultat->motif); ?></td>
                            <td>
                                <?php if(count($resultat->signes) != 0): ?>
                                    <?php
                                        $text = '';
                                        foreach ($resultat->signes as $signe) {
                                            $text .= $signe->name . ($resultat->signes != '' ? ',' : ' ');
                                        }
                                    ?>
                                <?php else: ?>
                                    /
                                <?php endif; ?>
                            </td>
                            <?php if($resultat->compte_rendu == ''): ?>
                                <td>/</td>
                            <?php else: ?>
                                <td><?php echo e($resultat->compte_rendu); ?></td>
                            <?php endif; ?>
                            <?php if($resultat->examen == ''): ?>
                                <td>/</td>
                            <?php else: ?>
                                <td><?php echo e($resultat->examen); ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php if($resultat->orientation != ''): ?>
                            <tr>
                                <td colspan="2">Orientation</td>
                                <td colspan="3"><?php echo e($resultat->orientation); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($resultat->certificat != ''): ?>
                            <tr>
                                <td colspan="2">Certificat</td>
                                <td colspan="3"><?php echo e($resultat->certificat); ?></td>
                            </tr>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            <?php endif; ?>
        <?php endif; ?>
        <br />

        <?php if(isset($data['p']) || isset($data['aa']) || isset($data['ch']) || isset($data['e'])): ?>

            <h4 style="color:#333399;"><B> <u>Prescriptions</u> </B></h4>

            <br />
            <?php if(isset($data['p'])): ?>
                <?php if(count($patient->prescriptionsDesc) != 0): ?>

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
                            <?php $__currentLoopData = $patient->prescriptionsDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td>
                                        <?php echo e($loop->index + 1); ?>

                                    </td>
                                    <td> <?php echo e($prescription->date_prescription); ?> </td>
                                    <td> Dr.<?php echo e($prescription->prescripteur->name); ?>

                                        <?php echo e($prescription->prescripteur->prenom); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 0 !important;">
                                        <div>
                                            <table>
                                                <?php $__currentLoopData = $prescription->lignes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <th> <?php echo e($loop->index + 1); ?> </th>

                                                        <th>
                                                            <?php
                                                                $resultats = DB::table('cosac_compo_subact')
                                                                    ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                                    ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                                    ->get();
                                                                foreach ($resultats as $key => $resultat) {
                                                                    echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                                }
                                                            ?>
                                                            Voie : <?php echo e($ligne->voie); ?>.
                                                            <?php echo e($ligne->dose_matin ? $ligne->dose_mat . ' ' . $ligne->unite . ' le Matin,' : ''); ?>

                                                            <?php echo e($ligne->dose_midi ? $ligne->dose_mid . ' à Midi,' : ''); ?>

                                                            <?php echo e($ligne->dose_soir ? $ligne->dose_soi . ' le Soir,' : ''); ?>

                                                            <?php echo e($ligne->dose_avant_coucher ? $ligne->dose_ac . ' Avant coucher,' : ''); ?>

                                                            Pendant : <?php echo e($ligne->nbr_jours); ?> jours.
                                                        </th>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            <?php endif; ?>
            <br>
            
            <br>
            <?php if(isset($data['e'])): ?>
                <?php if(count($patient->bilansDesc) != 0): ?>
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
                            <?php $__currentLoopData = $patient->bilansDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bilan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($bilan->element): ?>
                                    <td> <?php echo e($bilan->element->bilan); ?> </td>
                                    <td> <?php echo e($bilan->element->element); ?> </td>
                                    <td> <?php echo e($bilan->valeur); ?> </td>
                                    <td> <?php echo e($bilan->element->minimum); ?> </td>
                                    <td> <?php echo e($bilan->element->maximum); ?> </td>
                                    <td> <?php echo e($bilan->element->unite); ?> </td>
                                    <td> <?php echo e($bilan->date_analyse); ?> </td>
                                    <td>
                                        <?php if($bilan->valeur > $bilan->element->maximum): ?>
                                            <i class="fa fa-chevron-circle-up " style="color:red; font-size:22px;"></i>
                                        <?php elseif($bilan->valeur < $bilan->element->minimum): ?>
                                                <i class="fa fa-chevron-circle-down "
                                                    style="color: red; font-size:22px;"></i>
                                            <?php elseif($bilan->valeur < $bilan->element->minimum): ?>
                                                    <i class="fa fa-chevron-circle-down "
                                                        style="color: red; font-size:22px;"></i>
                                                <?php elseif($bilan->valeur > $bilan->element->maximum): ?>
                                                    <i class="fa fa-chevron-circle-up "
                                                        style="color: red; font-size:22px;"></i>
                                                <?php else: ?>
                                                    <i class="fa fa-check-circle"
                                                        style="color: green; font-size:22px;"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($bilan->laboratoire ?? '-'); ?></td>
                                    <td><?php echo e($bilan->commentaire ?? '-'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
            <br>
            <?php if(isset($data['ch'])): ?>

                <?php if(count($patient->traitementsDesc) != 0): ?>
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
                            <?php $__currentLoopData = $patient->traitementsDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th>
                                        <?php
                                            $resultats = DB::table('cosac_compo_subact')
                                                ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                ->get();
                                            foreach ($resultats as $key => $resultat) {
                                                echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                            }
                                        ?>
                                    </th>
                                    <th> <?php echo e($ligne->voie); ?> </th>
                                    <td> <?php echo e($ligne->dose_matin); ?> <?php echo e($ligne->repas_matin); ?> </td>
                                    <td> <?php echo e($ligne->dose_midi); ?> <?php echo e($ligne->repas_midi); ?> </td>
                                    <td> <?php echo e($ligne->dose_soir); ?> <?php echo e($ligne->repas_soir); ?> </td>
                                    <td> <?php echo e($ligne->dose_avant_coucher); ?> </td>
                                    <td> <?php echo e($ligne->unite); ?> </td>
                                    <td><?php echo e($ligne->medecin_externe ? 'Dr.' . $ligne->medecin_externe : '-'); ?>

                                    </td>
                                    <td>
                                        <?php if($ligne->etats == 'En cours' || $ligne->etats == 'Reprise'): ?>
                                            <span class="label label-success"><?php echo e($ligne->etats); ?> </span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo e($ligne->etats); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td> <?php echo e($ligne->date_etats); ?> </td>
                                    <td>
                                        <?php if($ligne->status_hopital == '1'): ?> H
                                        <?php else: ?> V <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>


            <?php endif; ?>
            <br>
        <?php endif; ?>

        <?php if(isset($data['h'])): ?>
            <?php if(count($patient->hospiDesc) != 0): ?>
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
                        <?php $__currentLoopData = $patient->hospiDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ho): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td> <?php echo e($loop->index + 1); ?> </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="<?php echo e($ho->hopital); ?>"><?php echo e($ho->hopital ? $ho->hopital : '/'); ?>

                                    </span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="<?php echo e($ho->service); ?>"><?php echo e($ho->service ? $ho->service : '/'); ?>

                                    </span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="<?php echo e($ho->num_biais); ?>">
                                        <?php echo e($ho->num_biais ? $ho->num_biais : '/'); ?>

                                    </span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span
                                        title="<?php echo e($ho->chambre); ?>"><?php echo e($ho->chambre ? $ho->chambre : '/'); ?></span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="<?php echo e($ho->lit); ?>"><?php echo e($ho->lit ? $ho->lit : '/'); ?></span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span title="<?php echo e($ho->motifs); ?>"><?php echo e($ho->motifs ? $ho->motifs : '/'); ?></span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span
                                        title="<?php echo e($ho->date_admission); ?>"><?php echo e($ho->date_admission ? $ho->date_admission : '/'); ?></span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <span
                                        title="<?php echo e($ho->date_sortie); ?>"><?php echo e($ho->date_sortie ? $ho->date_sortie : '/'); ?></span>
                                </td>
                                <td
                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                    <?php if($ho->motif_sortie == 'autre'): ?>
                                        Vers
                                        <?php echo e($ho->service_transfert ? $ho->service_transfert : '/'); ?>

                                    <?php elseif($ho->motif_sortie == 'hopital'): ?>
                                        Sortie du CHU
                                    <?php elseif($ho->motif_sortie == 'décés'): ?>
                                        Décédé
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            <?php endif; ?>
        <?php endif; ?>
        <br>

        <?php if(isset($data['ph'])): ?>
            <?php if(count($patient->phytosDesc) != 0): ?>
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
                        <?php $__currentLoopData = $patient->phytosDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phyto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->index + 1); ?></td>
                                <td><?php echo e($phyto->produit['produit_naturel_fr']); ?></td>
                                <td><?php echo e($phyto->produit['produits_arabe']); ?></td>
                                <td><?php echo e($phyto->utilisation ? $phyto->utilisation->pathologie : ''); ?>

                                </td>
                                <td><?php echo e($phyto->frequence); ?> <?php echo e($phyto->frequence_date); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>
        <br>

        <?php if($patient->lastEducations): ?>
            <h4 style="color:#333399;"><B> <u>Rapport Education Thérapeutique</u> </B></h4>
            <p>
                <?php echo e($patient->lastEducations->description); ?>

            </p>

        <?php endif; ?>

        <br><br>
        <?php if(isset($data['r'])): ?>

            <?php if(count($patient->radiosDesc) != 0): ?>
                <h4 style="color:#333399;"><B> <u>Radiologies et Imageries</u> </B></h4>

                <?php $__currentLoopData = $patient->radiosDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="/storage/<?php echo e($url->fichier); ?>" alt="">
                    <p><?php echo e($url->created_at); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <br />
                <br />
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="container text-center">

            <div id="qrcode" style=" display: inline-block; "></div>
        </div>
    </div>
</body>
<script src="<?php echo e(asset('plugins/jquery/js/jquery.js')); ?>"></script>
<script src="<?php echo e(asset('/plugins/qrcode/qrcode.js')); ?>"></script>

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
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\print\report-patient.blade.php ENDPATH**/ ?>