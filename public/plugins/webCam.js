
function take_snapshot() {
	Webcam.snap( function(data_uri) {
	document.getElementById('myPhoto').innerHTML = '<br><img src="'+data_uri+'"/>';
	document.getElementById('link').innerHTML = '<a href="'+data_uri+'" target="_blank" download="myPic.jpg">Download your Snap</a>';
	});
}
 
$('#takePic').on('click',function(){
	Webcam.set({
		width: 400,
		height: 400,
		// dest_width: 450,
		// dest_height: 450,				
		image_format: 'jpg',
		jpeg_quality: 90
	});
	Webcam.attach( '#MyDisplay' );
});

$('.turnOff').on('click',function(){
	Webcam.reset();
});