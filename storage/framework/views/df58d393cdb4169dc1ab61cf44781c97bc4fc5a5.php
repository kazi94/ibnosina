<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery/css/jquery_ui.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome/css/font-awesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/Ionicons/css/ionicons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/adminlte2/css/AdminLTE.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/scrollbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/skins/skin-blue.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/select2/dist/css/select2.min.css')); ?>">
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
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Renseigner les Unités</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        


                        <div class="box-footer">

                            <form>
                                <?php
                                    $sacs = DB::table('sac_subactive')
                                        ->distinct()
                                        ->orderBy('sac_nom', 'asc')
                                        ->get();
                                ?>
                                <table class="table table-bordered text-center" id="unit1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Num :</th>
                                            <th>medic algerien</th>
                                            <th>dci algerien</th>
                                            <th>dci theriaque equiv</th>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>
                                                <td>
                                                    <input type="hidden" value="<?php echo e($sp['id']); ?> " name="sp[]">
                                                    <?php echo e($sp['medicament']); ?>

                                                </td>
                                                <td><?php echo e($sp['dci']); ?></td>
                                                <td>
                                                    
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <input type="submit" value="enregistrer" class="btn btn-primary">
                            </form>

                            <table class="table table-bordered text-center mmte">
                                <thead>
                                    <tr>
                                        <th>dci</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sacs = DB::table('sac_subactive')
                                            ->distinct()
                                            ->orderBy('sac_nom', 'asc')
                                            ->get();
                                    ?>


                                    <?php $__currentLoopData = $sacs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($sac->SAC_NOM); ?></td>
                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                            
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/select2/dist/js/select2.full.min.js')); ?>"> </script>
    <script src="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')); ?>"> </script>
    <script type="text/javascript">
        var table = $("#unit1").DataTable();
        var table1 = $(".mmte").DataTable();
        $('.select2').select2();
        $("form").on('submit', function(e) {
            e.preventDefault();

            var form = table.$('input, select');



            sendForm(form, "/admin/specialite1");

        });

        // Send Form Data via Ajax Method
        function sendForm(form, url) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data: form.serialize(), // send data form to server
                datatype: 'json',
                success: (data, status) => { //status = 'success'
                    // $.each(form, function(index, val) {
                    // 	if (val.type == 'select-one' && val.value) //TypeOf Select and option isSelected
                    // 		$(this).closest('tr').fadeOut('slow' , function(){
                    // 			$(this).remove();
                    // 		});
                    // });

                    // alert('Ajout Effectué avec succés');
                    console.log(data);

                },

                error: function(data, result, status) { // status = code d'erreur
                    alert(data.responseText);
                    // var errors = $.parseJSON(data.responseText);// because the reponse is a 'String' format , //responseText is when erros has been set
                    // $.each(errors.errors , function(key , value){
                    // 	for (i=0 ; i< value.length ; i++) //because each attribut has more than one error message
                    // 		alert(value[i]);
                    // });

                },
                complete: function(result, status) { //status = 'success'
                    if (window.console && window.console.log) { // check if console is availlable
                        console.log(result + status);
                    }
                }
            });
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\unite\create.blade.php ENDPATH**/ ?>