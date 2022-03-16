<!DOCTYPE html>
<html lang="">


<?php echo $__env->make('layouts.head1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body class="hold-transition skin-blue sidebar-mini <?php if(strpos(url()->current(), '/patient') !=
    false): ?> sidebar-collapse <?php endif; ?>">

    <div id="app">
        <p class="roleMedecin" style="display: none;"><?php echo e(Auth::user()->role->medecin_presc); ?></p>
        <p class="rolePharmacien" style="display: none;"><?php echo e(Auth::user()->role->analyse_ph); ?></p>
    </div>

    <div class="wrapper">

        
        <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <?php echo $__env->make('layouts.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <?php echo $__env->yieldContent('content'); ?>


        
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <script src="<?php echo e(asset('plugins/vendors.js')); ?>"></script>
    <script src="<?php echo e(asset('js/model.js')); ?>"></script>

    <?php echo $__env->yieldContent('script'); ?>
    <script>
        $(function() {

            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })
        });

    </script>
    <script src="<?php echo e(asset('plugins/select2/dist/js/select2.full.min.js')); ?>"> </script>
    <script src="<?php echo e(asset('plugins/fastclick.js')); ?>"> </script>
    <script>
        $(function() {
            FastClick.attach(document.body);
            //Initialize Select2 Elements
            $('.select2').select2();
        });

    </script>

</body>

</html>
<?php /**PATH C:\laragon\www\anapharm\resources\views\layouts\model1.blade.php ENDPATH**/ ?>