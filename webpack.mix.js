let mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
//-------------------------------------------------------------------
// Mix script Permet de concaténé des fichiers dans un seul fichier
// -----------------------
// mix.js([
//     'resources/assets/js/app.js',
//     'node_modules/chart.js/dist/Chart.bundle.js'
//     ], 'public/js/all.js');

//---------------------------------------------------------------------------
// Mix.js // Mix.css // Mix.less permet de créer un shortcut pour le fichier
// Sourcemap() it comes with a compile/performance cost, this will provide
// extra debugging information to your browser's developer tools when using compiled assets.
// --------------------------------------------------------------------------
//mix.js('resources/assets/js/appChat.js', 'public/js')
//    .js('node_modules/chart.js/dist/Chart.bundle.js', 'public/js')
//    .js('node_modules/moment/src/moment.js', 'public/js')
//    .js('node_modules/chart.js/dist/Chart.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

mix.babel([
	'public/js/user/patient/create-charts.js',
	'public/js/user/patient/create-charts1.js',
	'public/js/user/patient/gestion_patient.js',
	'public/js/user/patient/gestion_bilan.js',
	'public/js/user/patient/gestion_prescription.js',
	'public/js/user/patient/gestion-administration.js',
	'public/js/user/patient/gestion_traitement_auto.js',
	'public/js/user/patient/gestion_phyto.js',
	'public/js/user/patient/gestion_consultation.js',
	'public/js/user/patient/gestion_hospitalisation.js',
	'public/js/user/patient/gestion_questionnaire.js',
	'public/js/user/patient/gestion-education.js',
	'public/js/user/patient/gestion.js',
	'public/js/user/patient/analyse.js',
	'public/js/user/patient/gestion_chimio.js',
	'public/js/user/patient/edit.js',
	'public/js/user/patient/annotation.js',
	'public/js/print.js',
], 'public/js/user/patient/gestion_dmp.js');

// JS Plugins
mix.babel([
	"public/plugins/jquery/js/jquery.min.js",
	"public/plugins/jquery/js/jquery-ui.min.js",
	"public/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js",
	"public/plugins/bootstrap/dist/js/bootstrap.min.js",
	"public/plugins/adminlte2/js/adminlte.min.js",
	"public/plugins/datatable-1.10.24/datatables.min.js",
	// "public/plugins/datatables.net/dataTables.min.js",
	// // "public/plugins/datatables.net/Buttons-1.6.4/js/dataTables.buttons.min.js",
	// "public/plugins/datatables.net/Buttons-1.6.4/js/buttons.flash.min.js",
	// "public/plugins/datatables.net/JSZip-2.5.0/jszip.min.js",
	// "public/plugins/datatables.net/pdfmake-0.1.36/pdfmake.min.js",
	// "public/plugins/datatables.net/pdfmake-0.1.36/vfs_fonts.js",
	// "public/plugins/datatables.net/Buttons-1.6.4/js/buttons.html5.min.js",
	// "public/plugins/datatables.net/Buttons-1.6.4/js/buttons.print.min.js",
	// "public/plugins/datatables.net/Buttons-1.6.4/js/buttons.colVis.min.js",
	// "public/plugins/datatables.net-bs/js/datatables.bootstrap.min.js",
	"public/plugins/select2/dist/js/select2.full.min.js",
	"public/plugins/fastclick.js",
	"public/plugins/toastr/toastr.js",
	"public/plugins/moment.js",
	"public/plugins/ChartJs/js/Chart.js",
	"public/plugins/loading/progress_loading.js",
	"public/plugins/recorder.js",
	// // "public/js/sweetAlert/sweetalert.js",
	// // "public/js/math.js",
	"public/plugins/jquery/js/jquery.hotkeys.js", // for shorcut keyboards
	"public/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js",
	"public/plugins/iCheck/icheck.min.js",
], 'public/plugins/vendors.js');
// JS Plugins

// CSS Plugins
mix.babel([
	"public/plugins/bootstrap/dist/css/bootstrap.min.css",
	// "public/css/font-awesome/css/font-awesome.min.css",
	// "public/css/fontawesome-free-5.15.1-web/css/fontawesome.min.css",
	"public/css/Ionicons/css/ionicons.min.css",
	"public/plugins/adminlte2/css/AdminLTE.min.css",
	"public/plugins/adminlte2/skins/skin-blue.min.css",
	"public/plugins/datatable-1.10.24/datatables.min.css",
	"public/plugins/select2/dist/css/select2.min.css",
	"public/plugins/toastr/toastr.css",
	// "public/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css",
	"public/plugins/jquery/css/jquery_ui.min.css",
	"public/css/style.css",
	"public/css/styleTableTrait.css",
	"public/plugins/floating-action-button/css/button.css",
	"public/plugins/floating-action-button/css/floating-action-button.css",
	"public/plugins/floating-action-button/css/google-icons.css",
	"public/plugins/floating-action-button/css/typography.css",
	"public/plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css",
	"public/plugins/loading/loading-bar.css",
	"public/plugins/iCheck/flat/_all.css",
], 'public/plugins/vendors.css');


/*
 * CSS LINKS 'Liste des patients' VIEW
 */
mix.babel([
	"public/plugins/bootstrap/dist/css/bootstrap.min.css",
	"public/plugins/adminlte2/css/AdminLTE.min.css",
	"public/plugins/adminlte2/skins/skin-blue.min.css",
	"public/plugins/datatable-1.10.24/datatables.min.css",
	"public/plugins/floating-action-button/css/button.css",
	"public/plugins/floating-action-button/css/floating-action-button.css",
	"public/plugins/floating-action-button/css/google-icons.css",
	"public/plugins/floating-action-button/css/typography.css",

], 'public/css/patient/show.css');
// mix.sass("public/plugins/iCheck/flat/_all.scss", 'public/css/icheck.css');
// mix.less("public/test.scss", 'public/test.css');
// mix.sass("public/plugins/bootstrap/less/bootstrap.less", 'public/plugins/bootstrap/dist/css/bootstrap.min.css');
// mix.babel(["public/test.css'", ], 'public/test-vend.css');
mix.browserSync("localhost:8000");
//mix.disableNotifications();
if (mix.inProduction()) {
	// in deployment , because server hash scripts for years
	// when you change the code of scripts
	// you have to tell to server to reload the cache for
	//  new version uploaded
	mix.version();
}