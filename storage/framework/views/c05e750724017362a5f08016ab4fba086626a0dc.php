<?php $__env->startSection('title'); ?> <?php echo e($sps_equiv['medicament']); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('meta_robot'); ?> noindex, nofollow <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
      
      <div class="col-sm-12 mt-1">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background-color: white">
              <li class="breadcrumb-item"><a href="www.hic-sante.com"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo e(route('medicaments.noms-commerciale')); ?>"><i class="fas fa-capsules"></i> Médicaments</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo e($sps_equiv['medicament']); ?> <span class="badge badge-danger">SP</span>  
               <?php echo ( isset($sps_equiv['dci_alg']) ) ? "(".$sps_equiv['dci_alg']."  <span class='badge badge-pill badge-success'>DCI</span> )" : ''; ?> 
              </li>
            </ol>     
         </nav>
        <button   title="Signaler un problème" type="button" class="btn btn-link btn-report" data-toggle="modal" data-target="#bug_report" ><i class="fa fa-bug"></i> Signaler !</button>
      </div>

  
        <?php if(isset($sps_equiv['medicament'])): ?>
          <div class="row d-flex justify-content-center">

            <div class="bg-white col-sm-8 p-3 m-3 rounded shadow table-responsive">

                <table  id="medicaments" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="alert alert-success">Liste des médicaments équivalents</th>
                        </tr>
                    </thead>            
                    <tbody>
                      <?php if(isset($sps_equiv['sps'])): ?>
                        <?php $__currentLoopData = $sps_equiv['sps']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if(isset($sp->SP_NOM)): ?>
                            <tr>
                              <td> <a href="<?php echo e(route('medicaments.monographie' , $sp->SP_CODE_SQ_PK)); ?>"> <?php echo e($sp->SP_NOM); ?> </a> </td>
                            </tr>
                              
                          <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                      <?php endif; ?>
                    </tbody>
                </table> 
               
            </div>
         </div>
        <?php endif; ?>
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
                    "search":         "Rechercher par dose",
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


<?php echo $__env->make('bddm.layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\meds\meds_equiv.blade.php ENDPATH**/ ?>