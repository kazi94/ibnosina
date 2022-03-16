<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <section class="content">


            <?php if(session()->has('message')): ?>
                <p class="alert alert-success" id="message" style="display: none;"><?php echo e(session('message')); ?></p>
            <?php endif; ?>

            <div class="row">

                <div class="col-sm-12 ">

                    <div class="box box-info">

                        <div class=" row box-title">
                            <div class="col-md-9">
                                <h4 class="modal-title m-1" style="">Posez votre question | Donnez votre avis | Signalez
                                    un
                                    bug... <b>BREF!</b> CONTACTEZ NOUS !</h4>
                                <h5 class="ml-2 text-green">Nous vous répondrons dans les plus brefs délais</h5>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="col-sm-6">

                                <form action="<?php echo e(route('report_bug')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>


                                    <label for="NomAct">Votre Nom svp !</label>
                                    <input type="text" name="nom" id="" class="form-control">

                                    <label for="NomAct">A quel Sujet ?</label>
                                    <input type="text" name="sujet" id="" class="form-control">

                                    <label for="Description">Plus de détails</label>
                                    <textarea class="form-control" rows="5" cols="25" name="description"
                                        placeholder="Précisez votre signalement"></textarea>
                                    <div>
                                        <label for="file">Rajoutez une image ou une capture d'écran dans votre
                                            signalement</label>
                                        <input type="file" value="charger capture d'écran" class="mt-2" name="photo" id=""
                                            type="">
                                    </div>


                                    <input type="submit" value="Signaler !" class="btn btn-danger float-right">

                                </form>

                            </div>
                            <div class="col-sm-6 d-sm-none">

                                <img src="<?php echo e(asset('images/support.png')); ?>" alt="" width="100%">
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </section>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/toastr/toastr.js')); ?>"></script>
    <script>
        $(function() {
            if ($("#message").text()) {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.success($("#message").text());
            }
        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bugs.blade.php ENDPATH**/ ?>