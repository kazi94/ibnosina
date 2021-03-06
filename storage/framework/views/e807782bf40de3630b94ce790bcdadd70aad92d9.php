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
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/Ionicons/css/ionicons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/adminlte2/css/AdminLTE.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/iCheck/square/all.css')); ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway|Roboto|Barlow:wght@300|Rubik:wght@50&display=swap">
</head>

<body class="hold-transition login-page" style="    height: auto;
    background: #ffffff;
    background-repeat: no-repeat;
    background-image: url(/images/bg_login.jpg);
    background-position: center;
    background-size: cover;
">
    <div class="login-box">
        <div class="login-logo">
            <a href="/" style="color:white"><b>Ana</b><b><span style="color:#0cac00">PHARM</span></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Connectez vous pour utiliser l'application</p>

            <form method="POST" action="<?php echo e(route('login')); ?>" autocomplete="off">
                <?php echo e(csrf_field()); ?>

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" required placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <?php if($errors->has('email')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                <?php endif; ?>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" required placeholder="Mots de passe">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Je me connecte</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            
            <!-- /.social-auth-links -->
            <p>Vous avez oubli?? vos identifiants?</p>
            <p>Contactez nous ?? l'adresse mail <b>contact@hic-sante.com</b></p>
            
            

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?php echo e(asset('plugins/jquery/js/dist/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/iCheck/icheck.min.js')); ?>"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });

    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\anapharm\resources\views\auth\login1.blade.php ENDPATH**/ ?>