<!DOCTYPE html>
<html lang="">

{{-- head layouts --}}
@include('layouts.head1')

<body class="hold-transition skin-blue sidebar-mini @if (strpos(url()->current(), '/patient') !=
    false) sidebar-collapse @endif">

    <div id="app">
        <p class="roleMedecin" style="display: none;">{{ Auth::user()->role->medecin_presc }}</p>
        <p class="rolePharmacien" style="display: none;">{{ Auth::user()->role->analyse_ph }}</p>
    </div>

    <div class="wrapper">

        {{-- Header ,navbar layouts --}}
        @include('layouts.header')

        {{-- aside layouts --}}
        @include('layouts.aside')

        {{-- call of content here --}}
        @yield('content')


        {{-- footer layouts --}}
        @include('layouts.footer')

    </div>

    <script src="{{ asset('plugins/vendors.js') }}"></script>
    <script src="{{ asset('js/model.js') }}"></script>

    @yield('script')
    <script>
        $(function() {

            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })
        });

    </script>
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"> </script>
    <script src="{{ asset('plugins/fastclick.js') }}"> </script>
    <script>
        $(function() {
            FastClick.attach(document.body);
            //Initialize Select2 Elements
            $('.select2').select2();
        });

    </script>

</body>

</html>
