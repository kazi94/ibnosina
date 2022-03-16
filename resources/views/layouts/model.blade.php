 <!DOCTYPE html>

 <html>

 {{-- head layouts --}}
 @include('layouts.head')

 <body @if (strpos(url()->current(), '/appointement') != false) onload="init();" @endif
     class="hold-transition skin-blue sidebar-mini     @if (strpos(url()->current(),
     '/patient') != false) sidebar-collapse @endif">
     <!-- <div class="se-pre-con"></div> -->
     <div>
         <p class="roleMedecin" style="display: none;">
             @if (Auth::user()->role->medecin_presc)
                 {{ Auth::user()->role->medecin_presc }}
             @endif
         </p>
         <p class="rolePharmacien" style="display: none;">
             @if (Auth::user()->role->analyse_ph){{ Auth::user()->role->analyse_ph }}
             @endif
         </p>
     </div>
     <div class="wrapper" id="app">
         <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
         @include('layouts.header')

         @include('layouts.aside')


         @yield('content')


         @include('layouts.footer')

     </div>

     <script src="{{ asset('plugins/vendors.js') }}"></script>

     {{-- {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
         rel="noreferrer">
     </script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
         integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous" rel="noreferrer">
     </script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
     integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"
     rel="noreferrer"></script> --}}
     <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" rel="noreferrer"></script>
     <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js" rel="noreferrer"></script>
     <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" rel="noreferrer"></script>
     <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" rel="noreferrer"></script>
     <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js" rel="noreferrer"></script>
     <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" rel="noreferrer"></script>
     <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js" rel="noreferrer"></script> -->
     <script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>

     {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/recorderjs/0.1.0/recorder.min.js" rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.hotkeys/0.1.0/jquery.hotkeys.min.js" rel="noreferrer">
     </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"
         rel="noreferrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/icheck.min.js" rel="noreferrer"></script> --}}
     <script src="{{ asset('js/model.js') }}"></script>
     @yield('script')
 </body>

 </html>
