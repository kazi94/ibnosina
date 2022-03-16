<?php $__env->startSection('meta_robot'); ?> index,follow <?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?> Classes ATC | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('description'); ?> la liste des classes ATC. <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_title'); ?> Classes ATC | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_description'); ?> la liste des classes ATC. <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?> <?php echo e(url()->current()); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="bg-white col-sm-7 p-3 mt-3 mb-3 ml-sm-4 rounded shadow" style="color: black">
          <h2 style="">Liste des classes ATC</h2>
          <br>
            <div id="accordion" style="color: red">
              <?php $__currentLoopData = $r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="card" style="color: red">
                    <div class="card-header" style=" padding:0; "id="heading-<?php echo e($classe->CATC_CODE_PK); ?>">
                      <span class="mb-0">
                        <button class="btn btn-link collapsed" style="color: black" data-id="<?php echo e($classe->CATC_CODE_PK); ?>" data-toggle="collapse" href="#collapse-<?php echo e($classe->CATC_CODE_PK); ?>" aria-expanded="false" aria-controls="collapse-<?php echo e($classe->CATC_CODE_PK); ?>">
                          <i class="fa fa-plus-circle"></i> <?php echo e($classe->CATC_NOMF); ?>

                        </button>
                      </span>
                    </div>
                    
                  </div>
                
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="bg-white col-sm-4 mt-3 mb-3 ml-2 p-3 rounded shadow">
            <h3 id="classe"></h3>

            <table  id="medicaments" class="table table-striped">
                <thead>
                  <tr><th>Liste des médicaments</th></tr>
                </thead>
                <tbody>                                                                    
                </tbody>
            </table>                    
        </div>        
    </div>


<?php $__env->stopSection(); ?>
 <?php $__env->startSection('js_scripts'); ?>

  <script>
  jQuery(document).ready(function($) 
  {

    $('.row').on('click', 'button', function () 
    {
      $this = $(this);
      var isExpanded = $this.attr("aria-expanded");
      if (isExpanded == 'false') 
      {
        $this.attr("aria-expanded" , "true");
        $id = $this.data('id');
        $classe = $this.html();
        $nextDiv = $this.closest('div').next().length;
        if ( $nextDiv == 0 ) 
        {
          
          $.ajax({
            url: '/classes/'+$id,
          })
          .done((data) => 
          {
            $result="";
            
            if ( typeof data.medicaments != 'undefined' ) {
              // afficher les médicaments dasn le tableau
                $('#classe').html($classe);
                $('#medicaments > tbody').empty();
              $.each(JSON.parse(data.medicaments), function(index, val) {
                $('#medicaments > tbody').append(`
                    <tr>
                      <td> <a href='/medicaments/${val.sp_code_sq_pk}' > ${val.sp_nom} </a> </td>
                    </tr> 
                  `);
              });
            } else {

              $.each(data, function(index, val) 
              {
               $result+=`
                  <div class="card" style="color: black">
                    <div class="card-header" style=" padding:0; "id="heading-${val.CATC_CODE_PK}">
                      <span class="mb-0">
                        <button class="btn btn-link collapsed" style="color: black" data-id="${val.CATC_CODE_PK}"  data-toggle="collapse" data-target="#collapse-${val.CATC_CODE_PK}" aria-expanded="false" aria-controls="collapseOne">
                          <i class="fa fa-plus-circle"></i>  ${val.CATC_NOMF}
                        </button>
                      </span>
                    </div>
                  </div>`;

              });
              
              $card_bd1 =`<div class="card-body" style="color: black">${$result}</div>`;
              $this.closest('div').after(`<div id="collapse-${$id}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="color: black">${$card_bd1}</div>`);

            }
          })
          .fail(function(request, status, error) {
            alert(request.responseJSON.message);
          })
          .always(function() {
            console.log("complete");
          });              
        }
      }
    });                                 
  });
  </script>

 <?php $__env->stopSection(); ?>
<?php echo $__env->make('bddm.layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\meds\meds_atc.blade.php ENDPATH**/ ?>