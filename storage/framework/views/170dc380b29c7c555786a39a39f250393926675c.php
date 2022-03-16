<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="screen"  />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" type="text/css" media="print"  />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome/css/font-awesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/Ionicons/css/ionicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/AdminLTE.css')); ?>">
    <title>Prescription#<?php echo e($prescription[0]->p_id); ?></title>
</head>
<body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <img src="<?php echo e(asset('/images/logo_chut.png')); ?>" style="width: 40px; height: 40px;">
              <?php echo e($prescription[0]->hopital); ?>, <?php if(strlen( $prescription[0]->hopital ) > 20): ?> 
                  <br/>
              <?php endif; ?> <?php echo e($prescription[0]->service); ?>.
              <small class="pull-right">Date: <?php echo now(); ?></small>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Patient:
            <address>
              <strong><?php echo e($prescription[0]->p_nom); ?>, <?php echo e($prescription[0]->p_prenom); ?>.</strong><br>
              <?php echo e($prescription[0]->p_dn); ?> <?php echo ($prescription[0]->ville) ?? '.'; ?> <br>
              <?php echo (($prescription[0]->p_num1) ? "Phone: (213)".$prescription[0]->p_num1 : ''); ?>

          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            Médecin Prescripteur:
            <address>
              <strong><?php echo e($prescription[0]->name); ?> <?php echo e($prescription[0]->prenom); ?>.</strong><br>
              <?php echo e($prescription[0]->hopital); ?>, <?php echo e($prescription[0]->service); ?><br>
              <?php echo e($prescription[0]->specialite); ?>, <?php echo e($prescription[0]->grade); ?><br>
              <?php echo (($prescription[0]->telephone) ? "Phone: (213)".$prescription[0]->telephone : ''); ?><br>
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>prescription #<?php echo e($prescription[0]->p_id); ?></b><br>
            <b>Date prescription:</b> <?php echo e($prescription[0]->date_prescription); ?><br>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        </body>
        <script src="<?php echo e(asset('plugins/jquery/js/jquery.js')); ?>"></script>
        <script type="text/javascript">
        $(window).on("load",function(){
        window.print();
        });
        </script>
    </html><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\print_conciliation.blade.php ENDPATH**/ ?>