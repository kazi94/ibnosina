<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/css/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/css/Ionicons/css/ionicons.css">
    <link rel="stylesheet" href="/css/AdminLTE.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/skins/skin-yellow.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="/plugins/iCheck/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
</head>
<body>
	<table class="table table-hover">
		<tr>
            <td><a href="<?php echo e(url('acceuil')); ?>"> <span class="glyphicon glyphicon-home"></span>Acceuil</a></td>
            <td><a href="<?php echo e(url('article/create')); ?>"><span class="glyphicon glyphicon-edit">Nouveau article</a></td>
            <td><a href="<?php echo e(url('articles')); ?>"><span class="glyphicon glyphicon-edit">article</a></td>
			<td><a href="<?php echo e(url('a-propos')); ?>"> <span class="glyphicon glyphicon-envelope">A-propos</a></td>
		</tr>
	</table>
	
	<?php echo $__env->yieldContent('content'); ?>
</body>
</html><?php /**PATH C:\laragon\www\anapharm\resources\views\layouts\master.blade.php ENDPATH**/ ?>