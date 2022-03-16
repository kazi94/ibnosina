  <head>
      <title><?php echo $__env->yieldContent('title'); ?></title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik:wght@50&display=swap"> -->
      <link rel="shortcut icon" href="<?php echo e(asset('images/logo.png')); ?>" type="image/x-icon">
      <link rel="stylesheet" href="<?php echo e(asset('css/fonts.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('css/fontawesome-free-5.15.1-web/css/all.min.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('plugins/vendors.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('css/icheck.css')); ?>">
      <?php echo $__env->yieldContent('script_css'); ?>
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  </head>
<?php /**PATH C:\laragon\www\anapharm\resources\views\layouts\head.blade.php ENDPATH**/ ?>