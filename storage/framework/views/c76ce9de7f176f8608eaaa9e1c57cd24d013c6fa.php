<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" media="print" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome/css/font-awesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/Ionicons/css/ionicons.css')); ?>')}}">
    <link rel="stylesheet" href="<?php echo e(asset('css/AdminLTE.css')); ?>">
    <title>Act Médical</title>
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
                        Centre Hospitalier Universitaire De Tlemcen.
                        <small class="pull-right">Date: <?php echo now(); ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <strong>Patient:</strong>Patient:
                    <address>
                        <strong><?php echo e($consultation[0]->n); ?>, <?php echo e($consultation[0]->pp); ?>.</strong><br>
                        <?php echo e($consultation[0]->date_naissance); ?>,<?php echo $consultation[0]->ville ?? '.'; ?> <br>
                        <?php echo $consultation[0]->num_tel_1 ? 'Phone: (213)' . $consultation[0]->num_tel_1 : ''; ?>

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Act médical # <?php echo e($consultation[0]->act_medicale_id); ?></b><br>
                    <b>Date Act:</b> <?php echo e($consultation[0]->date_act); ?><br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <h2 class="page-header">

            </h2>
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 ">
                    <table class="table table-striped">
                        <tr class="alert alert-success">
                            <th>Nom act</th>
                        </tr>
                        <tr>
                            <td><?php echo e($consultation[0]->nom); ?></td>
                        </tr>

                        <tr class="alert alert-success">
                            <th>Description</th>
                        </tr>
                        <tr>
                            <td><?php echo e($consultation[0]->description); ?></td>
                        </tr>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>

</html>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\print\print_act.blade.php ENDPATH**/ ?>