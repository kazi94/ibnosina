<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Consultation</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" media="print" />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">
</head>

<body>

    <div class="container-fluid">

        <table class="table">
            <img src="/images/logo_chut.png" alt="Chu Tlemcen" style="position: absolute; width: 100px; height: 100px;
    top: -10px;
    right: 44px" />
            <tr>
                <td><u><b>Date consultation :</b></u>{{ $consultation->date_consultation or '' }}</td>
                <td class="float-right"><u><b>Hopital :</b></u>{{ $consultation->patient->hospi->hopital or '' }}
                </td>
            </tr>

            <tr>
                <td><u><b>Nom , Prénom :</b></u> {{ $consultation->patient->nom or '' }}
                    {{ $consultation->patient->prenom or '' }}</td>
                <td class="float-right"><u><b>Service :</b></u> {{ $consultation->patient->hospi->service or '' }}
                </td>
            </tr>

            <tr>
                <td><u><b>Date de naissance :</b></u> {{ $consultation->patient->date_naissance or '' }}</td>
                <td class="float-right"><u><b>Médecin consultant :</b></u>{{ $consultation->userCreate->name or '' }}
                    {{ $consultation->userCreate->prenom or '' }} </td>
            </tr>


        </table>

        <br />

        <table class="table">
            <tr class="alert alert-success">
                <th>Motif</th>
            </tr>
            <tr>
                <td>{{ $consultation->motif or '' }}</td>
            </tr>

            <tr class="alert alert-success">
                <th>Signes Formelles</th>
            </tr>
            <tr>
                <td>{{ $consultation->signe or '' }}</td>
            </tr>

            <tr class="alert alert-success">
                <th>Examens physiques</th>
            </tr>
            <tr>
                <td>{{ $consultation->examen or '' }}</td>
            </tr>

            <tr class="alert alert-success">
                <th>Compte rendu</th>
            </tr>
            <tr>
                <td>{{ $consultation->compte_rendu or '' }}</td>
            </tr>

        </table>
    </div>
</body>
<script src="{{ asset('plugins/jquery/js/jquery.js') }}"></script>
<script type="text/javascript">
    $(window).on("load", function() {
        window.print();
    });

</script>

</html>
