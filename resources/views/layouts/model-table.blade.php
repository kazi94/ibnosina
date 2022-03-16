 <!DOCTYPE html>

 <html>

 {{-- head layouts --}}
 @include('layouts.head')

 <body @if (strpos(url()->current(), '/appointement') != false) onload="init();" @endif
     class="hold-transition skin-blue sidebar-mini  @if (strpos(url()->current(),
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


     @yield('script')
     {{-- <script src="{{ asset('js/model.js') }}"></script> --}}
 </body>

 </html>
