@include('user.patient.modals.annotation')

@can('patients.update', Auth::user())
    @include('user.patient.modals.profile')
@endcan
@can('hospitalisations.module', Auth::user())
    @include('user.patient.modals.hospitalisation')
@endcan
@can('consultations.module', Auth::user())
    @include('user.patient.modals.consultation')
@endcan
@can('prescriptions.module', Auth::user())
    @include('user.patient.modals.prescription')
@endcan
@can('phytotherapies.module', Auth::user())
    @include('user.patient.modals.phytotherapie')
@endcan
@can('analyses_biologique.module', Auth::user())
    @include('user.patient.modals.examen')
@endcan
@canany(['automedications.module', 'traitements_chronique.module'])
@include('user.patient.modals.auto-traitement')
@endcanany
@can('educations_therapeutique.module', Auth::user())
    @include('user.patient.modals.education-therapeutique')
@endcan
@can('questionaires.module', Auth::user())
    @include('user.patient.modals.observance')
@endcan
@can('peut-analyser', Auth::user())
    @include('user.patient.modals.analyse-pharmaceutique')
@endcan
@can('act_medicales.module', Auth::user())
    @include('user.patient.modals.act-medicale')
@endcan
