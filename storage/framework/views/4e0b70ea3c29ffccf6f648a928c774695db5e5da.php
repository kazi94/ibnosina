<?php $__env->startSection('meta_robot'); ?> noindex, nofollow <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <div class="row">
      <?php if(isset($results['0']->SAC_NOM)): ?>
        <h3 class="p-4"><i><u>Substance Active : <?php echo e($results['0']->SAC_NOM); ?></u></i></h3>
      <?php endif; ?>
    </div>
          <div class="row d-flex justify-content-center">
            <div class="bg-white col-sm-8 p-3 m-3 rounded shadow table-responsive">
                <table  id="medicaments" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="alert alert-success">Liste des médicaments</th>
                        </tr>
                    </thead>            
                    <tbody>
                      <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td> <a href="<?php echo e(route('medicaments.monographie' , $sp->SP_CODE_SQ_PK)); ?>"> <?php echo e($sp->SP_NOM); ?> </a> </td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table> 
               
            </div>
         </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_scripts'); ?>

  <script>
  $(document).ready(function() {
    $('#medicaments').DataTable({
                "responsive" :true,
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
  </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('bddm.layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\meds\sac_equiv.blade.php ENDPATH**/ ?>