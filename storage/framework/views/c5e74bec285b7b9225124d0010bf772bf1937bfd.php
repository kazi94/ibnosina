 <!DOCTYPE html>

 <html>

 
 <?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

 <body <?php if(strpos(url()->current(), '/appointement') != false): ?> onload="init();" <?php endif; ?>
     class="hold-transition skin-blue sidebar-mini  <?php if(strpos(url()->current(),
     '/patient') != false): ?> sidebar-collapse <?php endif; ?>">
     <!-- <div class="se-pre-con"></div> -->
     <div>
         <p class="roleMedecin" style="display: none;">
             <?php if(Auth::user()->role->medecin_presc): ?>
                 <?php echo e(Auth::user()->role->medecin_presc); ?>

             <?php endif; ?>
         </p>
         <p class="rolePharmacien" style="display: none;">
             <?php if(Auth::user()->role->analyse_ph): ?><?php echo e(Auth::user()->role->analyse_ph); ?>

             <?php endif; ?>
         </p>
     </div>
     <div class="wrapper" id="app">
         <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
         <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <?php echo $__env->make('layouts.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <?php echo $__env->yieldContent('content'); ?>

         <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

     </div>


     <?php echo $__env->yieldContent('script'); ?>
     
 </body>

 </html>
<?php /**PATH C:\laragon\www\anapharm\resources\views/layouts/model-table.blade.php ENDPATH**/ ?>