<?php $__env->startSection('title'); ?> Médicaments | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('meta_robot'); ?> index,follow <?php $__env->stopSection(); ?>
<?php $__env->startSection('description'); ?>
la liste des médicaments. Environ 21 000 spécialités diponnibles.<?php $__env->stopSection(); ?>
<?php $__env->startSection('og_title'); ?> Médicaments | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_description'); ?>
la liste des médicaments. Environ 21 000 spécialités diponnibles.<?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?> <?php echo e(url()->current()); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(count($errors) > 0): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <p class="alert alert-danger"><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(session()->has('message')): ?>
        <p class="alert alert-success"><?php echo e(session('message')); ?></p>
    <?php endif; ?>
	<div class="row d-flex justify-content-center">
		<div class="bg-white col-sm-8 p-3 m-3 rounded shadow table-responsive" style="width: auto;">
			<h1 style="text-align: center;">Médicaments</h1>
        <button   title="Signaler un problème" type="button" class="btn btn-link btn-report" data-toggle="modal" data-target="#bug_report" ><i class="fa fa-bug"></i> Signaler !</button>
			<div class="abecedaire">
                
                
                <strong class="txt-left">Cliquez sur une lettre pour accéder à la liste alphabétique des médicaments.</strong>
                <div class="one columns"><a href="#A" data-value="A">A</a></div>
                <div class="one columns"><a href="#B" data-value="B">B</a></div>
                <div class="one columns"><a href="#C" data-value="C">C</a></div>
                <div class="one columns"><a href="#D" data-value="D">D</a></div>
                <div class="one columns"><a href="#E" data-value="E">E</a></div>
                <div class="one columns"><a href="#F" data-value="F">F</a></div>
                <div class="one columns"><a href="#G" data-value="G">G</a></div>
                <div class="one columns"><a href="#H" data-value="H">H</a></div>
                <div class="one columns"><a href="#I" data-value="I">I</a></div>
                <div class="one columns"><a href="#J" data-value="J">J</a></div>
                <div class="one columns"><a href="#K" data-value="K">K</a></div>
                <div class="one columns"><a href="#L" data-value="L">L</a></div>
                <div class="one columns"><a href="#M" data-value="M">M</a></div>
                <div class="one columns"><a href="#N" data-value="N">N</a></div>
                <div class="one columns"><a href="#O" data-value="O">O</a></div>
                <div class="one columns"><a href="#P" data-value="P">P</a></div>
                <div class="one columns"><a href="#Q" data-value="Q">Q</a></div>
                <div class="one columns"><a href="#R" data-value="R">R</a></div>
                <div class="one columns"><a href="#S" data-value="S">S</a></div>
                <div class="one columns"><a href="#T" data-value="T">T</a></div>
                <div class="one columns"><a href="#U" data-value="U">U</a></div>
                <div class="one columns"><a href="#V" data-value="V">V</a></div>
                <div class="one columns"><a href="#W" data-value="W">W</a></div>
                <div class="one columns"><a href="#X" data-value="X">X</a></div>
                <div class="one columns"><a href="#Y" data-value="Y">Y</a></div>
                <div class="one columns"><a href="#Z" data-value="Z">Z</a></div>
                <div class="clear"></div>
            </div>

	        <br>	

			<table  id="medicaments" class="table table-striped table-bordered table-hover" style="width:100%">
						
				<tbody>
     
                </tbody>			
			</table>					
		</div>
	</div>

<?php $__env->stopSection(); ?>

 <?php $__env->startSection('js_scripts'); ?>

	<script>
		jQuery(document).ready(function($) {
                    
			/*JQuery DataTable Handle*/
            var table = $('#medicaments').DataTable({
                responsive: true,
                ajax : {
                    url:'/medicaments_ajax',
                    dataSrc:'data'
                },
                "columns": [
                {
                    data:"SP_CODE_SQ_PK",
                    "visible" : false,
                    "searchable":false
                },
                {data:"SP_NOM"}
                ],
                "language" : {
                    "decimal":        "",
                    "emptyTable":     "Aucune données est disponnible",
                    "info":           "",
                    "infoEmpty":      "de 0 a 0 des 0 lignes",
                    "infoFiltered":   "(filtered from _MAX_ total lignes)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Afficher _MENU_ médicaments",
                    "loadingRecords": "Chargement...",
                    "processing":     "Processing...",
                    "search":         "Recherchez:",
                    "zeroRecords":    "Aucun Médicament trouvé dans votre recherche",
                    "paginate": {
                        "first":      "Début",
                        "last":       "Dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                },
                drawCallback: function () {
                  $( 'a.page-link', this.api().table().container() ).attr('href', '#!');
                }
            });
            
            $("#medicaments thead").hide()
            /*Fonction au click sur le boutton détails*/
            $('#medicaments').on('click', 'tr', function () {
                var data = table.row($(this).closest('tr')).data();
                var medicamentID = data['SP_CODE_SQ_PK'];
                window.location.href ="/medicaments/" + medicamentID;
            });
              
            $(".abecedaire").on('click' , 'a' , function(){
                
                $(this).parent().toggleClass('current').html($(this).html());
                // get the aphabet
                let $alpha = $(this).data('value');
                table.destroy();
                $('#medicaments tbody').empty(); 
                // Get Specialites of the selected alphabet
                table = $('#medicaments').DataTable({
                    responsive: true,
                    ajax : {
                        url : '/medicaments/alphabet/'+$alpha,
                        dataSrc : 'data'
                    },
                       "columns": [
                    {
                        data : "SP_CODE_SQ_PK",
                        "visible": false,
                        "searchable": false 
                    },
                    {data : "SP_NOM" }
                  ],

                    "language" : {
                        "decimal":        "",
                        "emptyTable":     "Aucune données est disponnible",
                        "info":           "",
                        "infoEmpty":      "de 0 a 0 des 0 lignes",
                        "infoFiltered":   "(filtered from _MAX_ total lignes)",
                        "infoPostFix":    "",
                        "thousands":      ",",
                        "lengthMenu":     "Afficher _MENU_ lignes",
                        "loadingRecords": "Chargement...",
                        "processing":     "Processing...",
                        "search":         "Recherchez:",
                        "zeroRecords":    "Aucun Médicament trouvé dans votre recherche",
                        "paginate": {
                            "first":      "Début",
                            "last":       "Dernier",
                            "next":       "Suivant",
                            "previous":   "Précédent"
                        },
                        "aria": {
                            "sortAscending":  ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        }
                    }
                });
                
            });

		});
	</script>

 <?php $__env->stopSection(); ?>
<?php echo $__env->make('bddm.layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\meds\meds_sp.blade.php ENDPATH**/ ?>