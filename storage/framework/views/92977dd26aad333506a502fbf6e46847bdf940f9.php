<!DOCTYPE html>
    <html lang="en-US">
    	<head>
    		<meta charset="utf-8">
    	</head>
    	<body>
    		<h2>Rapport de bug</h2>
    		<p> M.<b><?php echo e($nom); ?></b>  
    			<br> 

			<h3>Sujet</h3>
			<p><?php echo e($sujet); ?></p>
			<br>
			<h3>description</h3>
			<p><?php echo e($description); ?></p>
			<br>
			<h3>photo</h3>
			<img src="<?php echo e($photo); ?>" width='100%' height='100%'>
    	</body>
    </html><?php /**PATH C:\laragon\www\anapharm\resources\views\emails\bugs_report.blade.php ENDPATH**/ ?>