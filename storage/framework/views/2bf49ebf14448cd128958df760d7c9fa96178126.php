<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
	<style>
		.list-group{
			overflow-y: scroll;
			height: 200px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row" id="app1">
			<div class="offset-4 col-4 offset-sm-1 col-sm-10">
				<li class="list-group-item active">Chat Room <span class="badge  badge-pill badge-danger">{{ numberOfUsers }}</span> </li>
				<div class="badge badge-pill badge-primary">{{ typing }}</div>
				<ul class="list-group" v-chat-scroll>
				  <message
				  v-for="value,index in chat.message"
				  :key=value.index
				  :color= chat.color[index]
				  :user = chat.user[index]
				  :time = chat.time[index]
				  >
				  	{{ value }}
				  </message>
				</ul>
				  <input type="text" class="form-control" placeholder="Type your message here..." v-model='message' @keyup.enter='send'>
				  <br>
				  <a href='' class="btn btn-warning btn-sm" @click.prevent='deleteSession'>Delete Chats</a>
			</div>
		</div>
	</div>

	<script src="<?php echo e(asset('/js/app.js')); ?>"></script>
</body>
</html><?php /**PATH C:\laragon\www\anapharm\resources\views\chat.blade.php ENDPATH**/ ?>