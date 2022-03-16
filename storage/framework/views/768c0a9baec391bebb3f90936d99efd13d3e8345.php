<?php $__env->startSection('title'); ?> Substances Actives | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('meta_robot'); ?> index,follow <?php $__env->stopSection(); ?>
<?php $__env->startSection('description'); ?> la liste des substance actives. Vous pouvez chercher les médicaments par le nom de la substance active. <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_title'); ?> Substances Actives | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_description'); ?> la liste des substance actives. Vous pouvez chercher les médicaments par le nom de la substance active. <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?> <?php echo e(url()->current()); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

            <div class="row">

		<div class="bg-white col-sm-7 p-3 mt-3 mb-3 ml-4 rounded shadow">
            <h2 style="">Liste des Substances Actives</h2>
            <br>

			<table  id="substances" class="table table-striped table-hover" style="">	
                <thead>
                    <tr>
                        <td style="text-align: center;"><strong>Susbstance Actives</strong></td>
                    </tr>
                </thead>				
				<tbody>
                    <?php $__currentLoopData = $substances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $substance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="text-align: center;cursor: pointer;"> 
                                <input type="hidden"  class='sacID' value="<?php echo e($substance->SAC_CODE_SQ_PK); ?> ">
                                <?php echo e($substance->SAC_NOM); ?> 
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>					
		</div>
        <div class="bg-white col-sm-4 mt-3 mb-3 ml-2 p-3 rounded shadow">
            <h3 id="sac_title"></h3>

            <table  id="sac_sp" class="table table-striped">
                <tbody>
                                                                          
                </tbody>
            </table>                    
        </div>        
            </div>


<?php $__env->stopSection(); ?>


 <?php $__env->startSection('js_scripts'); ?>

    <script>
        jQuery(document).ready(function($) {
                    
            var table = $('#substances').DataTable({
                "responsive" :true,
                "language" : {
                    "decimal":        "",
                    "emptyTable":     "Aucune données est disponnible",
                    "info":           "",
                    "infoEmpty":      "de 0 a 0 des 0 lignes",
                    "infoFiltered":   "(filtered from _MAX_ total lignes)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Afficher _MENU_ substances",
                    "loadingRecords": "Chargement...",
                    "processing":     "Processing...",
                    "search":         "Recherchez:",
                    "zeroRecords":    "Aucune substance active trouvée",
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

            $('#substances').on('click', 'tbody tr td', function () {

                var idSAC = $(this ).find(':first-child').val();
                var nomSAC = $(this).html();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url : '/substances/'+idSAC+'&&null',
                    method :'GET',
                    datatype : 'json',
                    success : (data) => {
                        console.log(data);
                        if (data) {
                            $('#sac_title').html(nomSAC);
                            $("#sac_sp > tbody").empty();
                            $.each(data, function(index, val) {
                                $("#sac_sp > tbody").append(`
                                    <tr>
                                        <td style="text-align: center; cursor : pointer "> <a href='/medicaments/${val.SP_CODE_SQ_PK}' > ${val.SP_NOM} </a></td>
                                    </tr>
                                `);
                            });
                        }
                    },
                    error:function (jqXHR, textStatus) {
        
                        console.log( "Request failed: " + textStatus +" "+jqXHR );
                    }
                });                 
            });                                   
        });
    </script>

 <?php $__env->stopSection(); ?>
<?php echo $__env->make('bddm.layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\meds\meds_sac.blade.php ENDPATH**/ ?>