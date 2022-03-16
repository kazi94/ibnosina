<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery/css/jquery_ui.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <?php if(count($errors) > 0): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="alert alert-danger"><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div class="alert alert-danger" style="display: none;"></div>
        <?php if(session()->has('message')): ?>
            <p class="alert alert-success"><?php echo e(session('message')); ?></p>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8 col-xs-12 col-md-offset-2">
                <div class="box box-info">

                    <div class="box-header with-border">
                        <h3 class="box-title">Renseigner les voies d'administration</h3>
                    </div>

                    <div class="box-body" id="">
                        <table class="table table-bordered text-center" id="unit1">
                            <form action="" method="">

                                <thead class="thead-dark">
                                    <tr>
                                        <th>Num :</th>
                                        <th>Spécialité</th>
                                        <th>Voie(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->index + 1); ?></td>
                                            <td>
                                                <input type="hidden" name="sp_id[]"
                                                    value="<?php echo e($sp->sp_code_sq_pk); ?>"><?php echo e($sp->sp_nom); ?>

                                            </td>
                                            <td>
                                                <select name="voies_id[<?php echo e($sp->sp_code_sq_pk); ?>][]"
                                                    class="form-control select2 select2-hidden-accessible" multiple=""
                                                    data-placeholder="Voies..." style="width: 100%;" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $voies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($voie->CDF_CODE_PK); ?>"><?php echo e($voie->CDF_NOM); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </form>
                        </table>
                        <input type="submit" class="btn btn-primary pull-right" value="enregistrer">
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"> </script>
    <!-- <script src="<?php echo e(asset('/plugins/datatables.net/js/jquery.dataTables.min.js')); ?>"> </script>
            <script src="<?php echo e(asset('/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script> -->
    <script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>

    <script src="<?php echo e(asset('plugins/select2/dist/js/select2.full.min.js')); ?>"> </script>
    <script type="text/javascript">
        var table = $("#unit1").DataTable({
            drawCallback: function() {
                $('.select2').select2();
            }
        });

        $("input:submit").click(function(e) {
            var form = table.$("input,select"); // get all data
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/admin/medicaments",
                method: 'post',
                data: form.serialize(), // send data to server
                datatype: 'json',
                success: (data, status) => { //status = 'success'
                    if (status == "success") {
                        alert("Ajout effectué avec succés");

                    }
                },
                error: function(data, result, status) { // status = 'un code d'erreur'
                    alert("Erreur : " + data);
                },
                complete: function(result, status) { //status = 'success'
                    if (window.console && window.console.log) { // check if console is availlable
                        console.log(result + status);
                    }
                }
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\voie\show.blade.php ENDPATH**/ ?>