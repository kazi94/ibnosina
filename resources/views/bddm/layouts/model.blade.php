<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- HTML Meta Tags -->
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="@yield('title')">
    <meta itemprop="description" content="@yield('description')">
    <meta itemprop="image" content="{{ asset('bddm/images/logo.png') }}">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="@yield('url')">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('og_description')">
    <meta property="og:image" content="{{ asset('bddm/images/logo.png') }}">
    <meta property="og:site_name" content="HIC SANTÉ" />
    @yield('fb_meta')
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:site" content="@HICSANTÉ">
    <meta name="twitter:description" content="@yield('og_description')">
    <meta name="twitter:image" content="{{ asset('bddm/images/logo.png') }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="@yield('meta_robot')" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap">
    <link rel="icon" href="https://hic-sante.com/wp-content/uploads/2020/01/Logo.ico" type="image/x-icon"
        sizes="16x16" />
    <link rel="icon" href="https://hic-sante.com/wp-content/uploads/2020/01/Logo.ico" type="image/x-icon"
        sizes="32x32" />
    <link rel="apple-touch-icon" href="https://hic-sante.com/wp-content/uploads/2020/02/logo-hic-sante-60-26-px.png">
    <link rel="apple-touch-icon" sizes="76x76"
        href="https://hic-sante.com/wp-content/uploads/2020/02/logo-hic-sante-76-36-px.png">
    <link rel="apple-touch-icon" sizes="120x120"
        href="https://hic-sante.com/wp-content/uploads/2020/02/logo-hic-sante-120-52-px.png">
    <link rel="apple-touch-icon" sizes="152x152"
        href="https://hic-sante.com/wp-content/uploads/2020/02/logo-hic-sante-152-62-px.png">
    <link rel='stylesheet'
        href='https://fonts.googleapis.com/css?family=Roboto:400,600,700|Roboto+Condensed:400,600,700' type='text/css'
        media='all' />




    <link rel="stylesheet" href="{{ asset('bddm/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bddm/fonts/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bddm/plugins/jquery/css/jquery_ui.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('/plugins/select2/dist/css/select2.min.css') }}"> --}}

    <script type="text/javascript">
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            var originalAddEventListener = EventTarget.prototype.addEventListener,
                oldWidth = window.innerWidth;
            EventTarget.prototype.addEventListener = function(eventName, eventHandler, useCapture) {
                if (eventName === "resize") {
                    originalAddEventListener.call(this, eventName, function(event) {
                        if (oldWidth === window.innerWidth) {
                            return;
                        } else if (oldWidth !== window.innerWidth) {
                            oldWidth = window.innerWidth;
                        }
                        if (eventHandler.handleEvent) {
                            eventHandler.handleEvent.call(this, event);
                        } else {
                            eventHandler.call(this, event);
                        };
                    }, useCapture);
                } else {
                    originalAddEventListener.call(this, eventName, eventHandler, useCapture);
                };
            };
        };

    </script>

    <link rel='stylesheet' href='https://hic-sante.com/wp-content/themes/dt-the7/css/main.min.css?ver=8.2.0'
        type='text/css' media='all' />
    <link rel='stylesheet'
        href="{{ asset('bddm/wp-theme/fonts/icomoon-the7-font/icomoon-the7-font.min.css?ver=8.2.0') }}"
        type='text/css' media='all' />
    <link rel='stylesheet' href="{{ asset('bddm/wp-theme/fonts/FontAwesome/css/all.min.css?ver=8.2.0') }}"
        type='text/css' media='all' />
    <link rel='stylesheet' href='https://hic-sante.com/wp-content/uploads/the7-css/custom.css?ver=66296b0650ad'
        type='text/css' media='all' />
    <link rel='stylesheet' href='https://hic-sante.com/wp-content/uploads/the7-css/media.css?ver=66296b0650ad'
        type='text/css' media='all' />
    <link rel="stylesheet" href="{{ asset('/bddm/css/main.css') }}">
</head>

<body>
    @include('bddm.layouts.navbar')
    {{-- {!! get_header() !!} --}}
    <div class="container-fluid">

        @include('bddm.layouts.searchbar')

        @yield('content')
    </div>
    {{-- {!! get_footer() !!} --}}
    @include('bddm.layouts.footer')

    <div class="modal fade" id="bug_report" tabindex="-1" role="dialog" aria-labelledby="bugReport" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Signaler un problème !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="report_form">
                        @method('post')
                        @csrf

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Objet :</label>
                            <input type="text" class="form-control" id="recipient-name" name="report_obj">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text" name="report_msg"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" id="report_btn"><i class="fa fa-envelope"></i> Envoyer
                        rapport</button>
                </div>
            </div>
        </div>
    </div>
    <!-- !Footer -->
    <footer id="footer" class="footer solid-bg">
        <!-- !Bottom-bar -->
        <div id="bottom-bar" class="logo-center" role="contentinfo">
            <div class="wf-wrap">
                <div class="wf-container-bottom">
                    <div id="branding-bottom"><a class="" href="https://hic-sante.com/"><img class=" preload-me"
                                src="https://hic-sante.com/wp-content/uploads/2020/02/logo-hic-sante-160-70-px.png"
                                srcset="https://hic-sante.com/wp-content/uploads/2020/02/logo-hic-sante-160-70-px.png 160w, https://hic-sante.com/wp-content/uploads/2020/02/logo-hic-sante-160-70-px.png 160w"
                                width="160" height="70" sizes="160px" alt="hic-sante.com" /></a></div>
                    <div class="wf-float-left">
                        HIC Santé © 2020 - HIC Santé, tous droits réservés.
                    </div>
                    <div class="wf-float-right">
                        <div class="mini-nav">
                            <ul id="bottom-menu">
                                <li
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2125 first">
                                    <a href='https://hic-sante.com/conditions-dutilisation/'
                                        title='Conditions d&rsquo;utilisation' target='_blank' data-level='1'><span
                                            class="menu-item-text"><span class="menu-text">Conditions
                                                d&rsquo;utilisation</span></span></a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2126"><a
                                        href='https://hic-sante.com/conditions-generales-de-vente/'
                                        title='Conditions générales de vente' target='_blank' data-level='1'><span
                                            class="menu-item-text"><span class="menu-text">Conditions générales de
                                                vente</span></span></a></li>
                                <li
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-2127">
                                    <a href='https://hic-sante.com/politique-de-confidentialite/'
                                        title='Politique de confidentialité' target='_blank' data-level='1'><span
                                            class="menu-item-text"><span class="menu-text">Politique de
                                                confidentialité</span></span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="bottom-text-block">
                            <p>HIC Santé ne fournit pas de conseils médicaux, de diagnostic ou de traitement. <a
                                    href='https:\\www.hic-sante.com/info-plus'>En savoir plus</a></p>
                        </div>
                    </div>
                </div>
                <!-- .wf-container-bottom -->
            </div>
            <!-- .wf-wrap -->
        </div>
        <!-- #bottom-bar -->
    </footer>
    <!-- #footer -->
    @include('bddm.layouts.js_scripts')


</body>

</html>
