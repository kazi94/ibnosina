<html>

<body>
    <h2></h2>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Erreurs 503
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 503</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! <?php echo e($exception->getMessage()); ?></h3>

                    <p>
                        Le site est en maitenance !! , Revenez plus tard !
                    </p>

                    
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</body>

</html>
<?php /**PATH C:\laragon\www\anapharm\resources\views\errors\503.blade.php ENDPATH**/ ?>