<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AnaPharm</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <link rel="manifest" href="<?php echo e(asset('css/fonts.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('plugins/adminlte2/css/AdminLTE.min.css')); ?>">
</head>

<body class="hold-transition login-page" style="    height: auto;
    background: #ffffff;
    background-repeat: no-repeat;
    background-image: url(<?php echo e(asset('/images/bg_login.jpg')); ?>) 
    background-position: center; background-size: cover; ">
    <div class=" login-box">
        <div class="login-logo">
            <a href="/" style="color:white"><b>Ana</b><b><span style="color:#0cac00">PHARM</span><strong
                        style="color:red">Dz</strong></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Connectez vous pour utiliser l'application</p>

            <form method="POST" action="<?php echo e(route('login')); ?>" autocomplete="off">
                <?php echo e(csrf_field()); ?>

                <?php if($errors->has('email')): ?>
                    <span class="help-block">
                        <strong class="text-red"><?php echo e($errors->first('email')); ?></strong>
                    </span>
                <?php endif; ?>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" required placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" required placeholder="Mots de passe"
                        autocomplete="off">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat text-bold">Je me
                            connecte</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            
            <!-- /.social-auth-links -->
            <p>Vous avez oublié vos identifiants?</p>
            <p>Contactez nous à l'adresse mail <b>contact@hic-sante.com</b></p>
            
            

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <!-- <script src="/plugins/jquery/js/jquery.min.js"></script> -->
    <!-- Bootstrap 3.3.7 -->
    <!-- <script src="/plugins/bootstrap/dist/js/bootstrap.min.js"></script> -->
    <!-- iCheck -->

</body>

</html>
<?php /**PATH C:\laragon\www\anapharm\resources\views/auth/login.blade.php ENDPATH**/ ?>