<?php $__env->startSection('meta_robot'); ?> index,follow <?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?> Indications | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('description'); ?> la liste des indications. Vous pourrez chercher le médicament par le type d'indication. <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_title'); ?> Indications | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_description'); ?> la liste des indications. Vous pourrez chercher le médicament par le type d'indication. <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?> <?php echo e(url()->current()); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

            <div class="row">

		<div class="bg-white col-sm-7 p-3 mt-3 mb-3 ml-sm-4 rounded shadow">
            <h2 style="">Liste des Indications</h2>
            <br>

			<table  id="indications" class="table table-striped table-hover" style="width: auto;">	
                <thead>
                    <tr>
                        <td style="text-align: center;"><strong>Indications</strong></td>
                    </tr>
                </thead>				
				<tbody>
                    <?php $__currentLoopData = $indications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="text-align: center;cursor: pointer;"> 
                                <input type="hidden"  class='sacID' value="<?php echo e($indication->FIN_CDF_NAIN_CODE_FK_PK); ?> ">
                                <?php echo e($indication->cdf_nom); ?> 
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>					
		</div>
        <div class="bg-white col-sm-4 mt-3 mb-3 ml-2 p-3 rounded shadow">
            <h3 id="indic_title"></h3>

            <table  id="indic_sp" class="table table-striped">
                <tbody>
                                                                          
                </tbody>
            </table>                    
        </div>        
            </div>


<?php $__env->stopSection(); ?>


 <?php $__env->startSection('js_scripts'); ?>

    <script>
        jQuery(document).ready(function($) {
                    
            var table = $('#indications').DataTable({
                
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

            $('#indications').on('click', ' tbody tr td', function () {
                console.log('msg')
                var idSAC = $(this ).find(':first-child').val();
                var nomSAC = $(this).html();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url : '/indications/'+idSAC,
                    method :'GET',
                    datatype : 'json',
                    success : (data) => {
                        if (data) {
                            $('#indic_title').html(nomSAC);
                            $("#indic_sp > tbody").empty();
                            $.each(JSON.parse(data), function(index, val) {
                                $("#indic_sp > tbody").append(`
                                    <tr>
                                        <td style="text-align: center; cursor : pointer "> <a href='/medicaments/${val.SP_CODE_SQ_PK}'> ${val.SP_NOM} </a></td>
                                    </tr>
                                `);
                            });
                        }
                    },
                    error:function (request, status, error) {
                        alert(request.responseJSON.message);
                    }
                });                 
            });                                   
        });
    </script>

 <?php $__env->stopSection(); ?>
<?php echo $__env->make('bddm.layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\meds\meds_indic.blade.php ENDPATH**/ ?>