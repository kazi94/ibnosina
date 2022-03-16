         <a class="skip-link screen-reader-text" href="#content">Skip to content</a>
         <div class="masthead inline-header right widgets shadow-decoration small-mobile-menu-icon dt-parent-menu-clickable show-device-logo show-mobile-logo"
             role="banner">
             <div class="top-bar top-bar-line-hide">
                 <div class="top-bar-bg"></div>
                 <div class="left-widgets mini-widgets"><span
                         class="mini-contacts email show-on-desktop near-logo-first-switch in-menu-second-switch"><i
                             class=" the7-mw-icon-mail-bold"></i><a href="" class="__cf_email__"
                             data-cfemail="4d2e2223392c2e390d25242e603e2c233928632e2220">contact@hic-sante.com</a></span>
                     <!-- <span class="mini-contacts address show-on-desktop in-top-bar-left in-menu-second-switch"><i class=" the7-mw-icon-address-bold"></i>Cité des 325 logements Bloc 02, Tlemcen, 13 000, Algérie</span> -->
                 </div>
                 <div class="right-widgets mini-widgets">
                     <div
                         class="soc-ico show-on-desktop in-top-bar-right in-menu-second-switch accent-bg disabled-border border-off hover-custom-bg hover-disabled-border  hover-border-off">
                         <a title="Facebook" href="https://www.facebook.com/hicSante" target="_blank"
                             class="facebook"><span class="soc-font-icon"></span><span
                                 class="screen-reader-text">Facebook</span></a><a title="YouTube"
                             href="https://www.youtube.com/channel/UC8d3MxBkxAljQ6M0AWslZwg?view_as=subscriber"
                             target="_blank" class="you-tube"><span class="soc-font-icon"></span><span
                                 class="screen-reader-text">YouTube</span></a></div>
                 </div>
             </div>
             <header class="header-bar">
                 <div class="branding">
                     <div id="site-title" class="assistive-text">hic-sante.com</div>
                     <div id="site-description" class="assistive-text"></div>
                     <a class="" href="https://www.medicaments.hic-sante.com/"><img class=" preload-me"
                             src="{{ asset('bddm/images/logo.png') }}" srcset="{{ asset('bddm/images/logo.png') }}"
                             width="160" height="70" sizes="160px" alt="hic-sante.com" /><img
                             class="mobile-logo preload-me" src="{{ asset('bddm/images/logo.png') }}"
                             srcset="{{ asset('bddm/images/logo.png') }}" width="160" height="70" sizes="160px"
                             alt="HIC MEDIC" /></a>
                 </div>
                 <ul id="primary-menu"
                     class="main-nav bg-outline-decoration hover-outline-decoration active-bg-decoration"
                     role="navigation">
                     <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2148 first"><a
                             href='https://hic-sante.com/a-propos/' data-level='1'><span class="menu-item-text"><span
                                     class="menu-text">A-propos</span></span></a></li>
                     <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2108"><a
                             href='https://hic-sante.com/articles/' data-level='1'><span class="menu-item-text"><span
                                     class="menu-text">Blog</span></span></a></li>
                     <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2110"><a
                             href='https://hic-sante.com/services/' title='Prestations' data-level='1'><span
                                 class="menu-item-text"><span class="menu-text">Prestations</span></span></a></li>
                     <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2107"><a
                             href='https://hic-sante.com/contact/' data-level='1'><span class="menu-item-text"><span
                                     class="menu-text">Contact</span></span></a></li>
                 </ul>
             </header>
         </div>

         {{-- <div
             class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm">
             --}}
             <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                 {{-- <h3> </h3> --}}
                 <br>
                 <br>
                 <br>
                 <a href="#"><i class="fa fa-capsules"> </i> Médicaments</a>
                 <a href="#"><i class="fa fa-globe"> </i> A-propos</a>
                 <a href="#"><i class="fa fa-graduation-cap"> </i> Nos Formations</a>
                 <a href="#"><i class="fa fa-newspaper"> </i> Nos Articles</a>
                 <a href="#"><i class="fa fa-tasks"> </i> Nos Prestations</a>
             </nav>


             <nav class="d-md-none navbar navbar-dark navbar-expand-lg rounded shadow-sm">
                 <a class="" href="https:\\www.medicaments.hic-sante.com">
                     <img src="{{ asset('bddm/images/logo.png') }}" height="52px"
                         alt="Health Inforamtion and communication">
                 </a>
                 <button class="navbar-toggler rounded-0" style="background: orange" type="button"
                     data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false"
                     aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse mt-1" style="background: orange" id="navbarText">
                     <ul class="navbar-nav mr-auto ml-1 text-uppercase text-center">
                         <li class="nav-item active">
                             <a class="nav-link" href="{{ route('medicaments.noms-commerciale') }}"> <i
                                     class="fa fa-pills"> </i> Médicaments </a>
                         </li>
                         <li class="nav-item active">
                             <a class="nav-link" href="{{ route('medicaments.substances') }}"> <i class="fa fa-tablets">
                                 </i> Substances Actives</a>
                         </li>
                         {{-- <li class="nav-item active">
                             <a class="nav-link" href="{{ route('medicaments.classes') }}"> <i class="fa fa-vial"> </i>
                                 Classes ATC</a>
                         </li> --}}
                         <li class="nav-item active">
                             <a class="nav-link" href="{{ route('medicaments.indications') }}"> <i
                                     class="fa fa-temperature-high"> </i> Indications</a>
                         </li>
                     </ul>
                     <ul class="bg-white fa-2x justify-content-center nav">
                         <li class="nav-item active">
                             <a class="" href="https://www.facebook.com/hicEvents">
                                 <i class="fab fa-facebook"></i>
                             </a>
                             <a class="" href="https://www.youtube.com/channel/UC8d3MxBkxAljQ6M0AWslZwg">
                                 <i class="fab fa-youtube"></i>
                             </a>
                             <a class="" href="https://www.linkedin.com/company/hic-sante/?viewAsMember=true">
                                 <i class="fab fa-linkedin"></i>
                             </a>
                         </li>
                     </ul>
                 </div>
             </nav>
