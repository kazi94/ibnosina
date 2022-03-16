<!--tab act-->
<div class="tab-pane {{ session('tab') == 'tab_12' ? 'active in' : '' }}" id="tab_12">
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li class="active">Prescription Act</li>
        </ol>
        @can('act_medicales.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#modal_act"
                    title="">Ajouter act medicale</button>
            @endif
        @endcan
        {{-- <input type="checkbox" value="scales3" id="scales3" name="scales3"
            onclick="myFunctions3()">
        <label for="scales">Afficher Par Consultation</label> --}}
        @can('act_medicales.export', Auth::user())
            <a href="/export/act/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        @endcan
    </div>

    <div id="labelforma3" name="labelforma3" style="display:block">
        <div class="box box-widget">

            {{-- <div class="box-header">
                <h4>Act Medicale</h4>
            </div> --}}

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="table_act" class="nowrap table table-bordered table-hover text-center">
                            <thead style="background-color:#d10300ab !important; color:white">
                                <tr>
                                    <th>#</th>
                                    <th>Act medical</th>
                                    <th>Description</th>
                                    <th>date</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                    {{-- @can('act_medicales.print', Auth::user())
                                    <th>Imprimer</th>
                                    @endcan --}}
                                    <th>Annotation</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($patient->act as $aaa)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>

                                        @php
                                            $z = DB::table('act_medicales')
                                                ->where('id', $aaa->act_medicale_id)
                                                ->select('act_medicales.*')
                                                ->get();
                                        @endphp
                                        @foreach ($z as $zz)
                                            <td
                                                style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                <span title="{{ $zz->nom }}">{{ $zz->nom }} </span>
                                            </td>
                                        @endforeach
                                        <td
                                            style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                            <span data-toggle="tooltip"
                                                title="{{ $aaa->description }}">{{ $aaa->description }} </span>
                                        </td>
                                        <td
                                            style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                            <span data-toggle="tooltip" title="{{ $aaa->date_act }}">
                                                {{ $aaa->date_act }} </span>
                                        </td>
                                        <td>

                                            @can('act_medicales.update', Auth::user())
                                                @if (!$patient->readonly)
                                                    <a href="#modifier-act" class="edit_act_med" title="Modifier l'act"
                                                        data-toggle="modal" data-id="{{ $aaa->id }}">
                                                        <i class="fa fa-edit text-green fa-2x"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                        </td>
                                        <td>
                                            @can('act_medicales.delete', Auth::user())
                                                @if (!$patient->readonly)
                                                    <form style="display: none;" method="POST"
                                                        action="{{ route('actee.delete', $aaa->id) }}"
                                                        id="delete-formee-{{ $aaa->id }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>

                                                    <a href="" onclick="
                                                                                                        if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                        event.preventDefault();
                                                                                                        document.getElementById('delete-formee-{{ $aaa->id }}').submit();										}
                                                                                                       "
                                                        style="color: inherit; ">
                                                        <span class="fa fa-trash text-red fa-2x"></span>
                                                    </a>
                                                @endif
                                            @endcan
                                        </td>

                                        <td>
                                            <a href="#" id="btn_ann_act" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="act"
                                                data-id="{{ $aaa->id }}">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--div affiché apres clique act avec consultation-->
    <!-- <div id="labelfor3" name="labelfor3" style="display: none">
        <div class="box box-widget">

            <div class="box-body">

                <div class="row">
                    <div class="col-sm-12">
                        <table id="example127" class="nowrap table table-bordered table-hover text-center">
                            <thead style="background-color:#d10300ab !important">
                                <tr>
                                    <th>Num°:</th>
                                    <th>Date</th>
                                    <th>Motif</th>
                                    <th>Signe Formelle</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->consultations as $consultation)

                                    <tr data-toggle="collapse" href="#mz{{ $loop->index + 1 }}"
                                        style="cursor: pointer;">
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $consultation->date_consultation }} </td>
                                        <td> {{ $consultation->motif }} </td>
                                        <td> {{ $consultation->signe }} </td>


                                    </tr>
                                    @php
                                        $resultats = DB::table('act_medicale_patients')
                                            ->where('consultation_id', $consultation->id)
                                            ->select('act_medicale_patients.*')
                                            ->get();
                                    @endphp
                                    @if (count($resultats) > 0)
                                        <tr>
                                            <td colspan="5" style="padding: 0 !important;">
                                                <div id="mz{{ $loop->index + 1 }}" class="accordian-body collapse">
                                                    <table class="table table-bordered">
                                                        <thead class="bg-gray">
                                                            <tr>
                                                                <th>Operations</th>
                                                                <th>Num </th>
                                                                <th>act </th>
                                                                <th> Description </th>
                                                                <th>date act</th>
                                                                @can('act_medicales.print', Auth::user())
                                                                            <th>Impression</th>
                                                                @endcan
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($resultats as $aaa)
                                                                <tr>
                                                                    <td>
                                                                        @can('act_medicales.delete', Auth::user())
                                                                                    <form style="display: none;" method="POST"
                                                                                        action="{{ route('actee.delete', $aaa->id) }}"
                                                                                        id="delete-formee-{{ $aaa->id }}">
                                                                                        {{ csrf_field() }}
                                                                                        {{ method_field('DELETE') }}
                                                                                    </form>

                                                                                    <a href="" onclick="
                                                                                                        if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                        event.preventDefault();
                                                                                                        document.getElementById('delete-formee-{{ $aaa->id }}').submit();										}
                                                                                                       "
                                                                                        style="color: inherit; "><span
                                                                                            class="glyphicon glyphicon-trash"></span></a>
                                                                        @endcan
                                                                        @can('act_medicales.update', Auth::user())
                                                                                    <i class="glyphicon glyphicon-edit edit_act_med"
                                                                                        title="Modifier" style="cursor: pointer"
                                                                                        id="{{ $aaa->id }}"></i>
                                                                        @endcan
                                                                    </td>
                                                                    <td> {{ $loop->index + 1 }} </td>
                                                                    @php
                                                                        $z = DB::table('act_medicales')
                                                                            ->where('id', $aaa->act_medicale_id)
                                                                            ->select('act_medicales.*')
                                                                            ->get();
                                                                    @endphp
                                                                    @foreach ($z as $zz)
                                                                        <td
                                                                            style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                                            <span
                                                                                title="{{ $zz->nom }}">{{ $zz->nom }}
                                                                            </span>
                                                                        </td>
                                                                    @endforeach
                                                                    <td
                                                                        style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                                        <span data-toggle="tooltip"
                                                                            title="{{ $aaa->description }}">{{ $aaa->description }}
                                                                        </span>
                                                                    </td>
                                                                    <td
                                                                        style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                                        <span data-toggle="tooltip"
                                                                            title="{{ $aaa->date_act }}">
                                                                            {{ $aaa->date_act }} </span>
                                                                    </td>
                                                                    @can('act_medicales.print', Auth::user())
                                                                                <td> <a href="" target="_blank"><button
                                                                                            class="btn btn-default"><i
                                                                                                class="fa fa-print"></i>
                                                                                            Act</button></a></td>
                                                                    @endcan
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-widget">

            <div class="box-header">
                <h3>Act Sans Consultation</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="hist_acts" class="nowrap table table-bordered table-hover text-center">
                            <thead class="bg-gray">
                                <tr>
                                    <th>Operations</th>
                                    <th>Num </th>
                                    <th>act </th>
                                    <th> Description </th>
                                    <th>date act</th>
                                    @can('act_medicales.print', Auth::user())
                                                <th>Impression</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $resulta = DB::table('act_medicale_patients')
                                        ->where('patient_id', $patient->id)
                                        ->select('act_medicale_patients.*')
                                        ->get();
                                @endphp

                                @foreach ($resulta as $aaa)
                                    @if ($aaa->consultation_id == '')
                                        <tr>
                                            <td>
                                                @can('act_medicales.delete', Auth::user())
                                                            <form style="display: none;" method="POST"
                                                                action="{{ route('actee.delete', $aaa->id) }}"
                                                                id="delete-formee-{{ $aaa->id }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                            </form>

                                                            <a href="" onclick="
                                                                                                        if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                        event.preventDefault();
                                                                                                        document.getElementById('delete-formee-{{ $aaa->id }}').submit();										}
                                                                                                       "
                                                                style="color: inherit; "><span
                                                                    class="glyphicon glyphicon-trash"></span></a>
                                                @endcan
                                                @can('act_medicales.update', Auth::user())
                                                            <i class="glyphicon glyphicon-edit edit_act_med" title="Modifier"
                                                                style="cursor: pointer" id="{{ $aaa->id }}"></i>
                                                @endcan
                                            </td>
                                            <td> {{ $loop->index + 1 }} </td>
                                            @php
                                                $z = DB::table('act_medicales')
                                                    ->where('id', $aaa->act_medicale_id)
                                                    ->select('act_medicales.*')
                                                    ->get();
                                            @endphp
                                            @foreach ($z as $zz)
                                                <td
                                                    style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                    <span title="{{ $zz->nom }}">{{ $zz->nom }} </span>
                                                </td>
                                            @endforeach
                                            <td
                                                style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                <span data-toggle="tooltip"
                                                    title="{{ $aaa->description }}">{{ $aaa->description }}
                                                </span>
                                            </td>
                                            <td
                                                style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">
                                                <span data-toggle="tooltip" title="{{ $aaa->date_act }}">
                                                    {{ $aaa->date_act }} </span>
                                            </td>
                                            @can('act_medicales.print', Auth::user())
                                                        <td> <a href="" target="_blank"><button class="btn btn-default"><i
                                                                        class="fa fa-print"></i> Act</button></a></td>
                                            @endcan
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div>
            </div>
        </div> -->
    <!--fin tab act-->
