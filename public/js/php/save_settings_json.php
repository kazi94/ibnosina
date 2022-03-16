<?php

	//get file
	$myFile = "../json/general_settings.json";

	//put chmod permission
	$fh = fopen($myFile, 'w') or die("can't open file");

	//get json data
	$stringData = $_GET["data"];

	//store json format in file
	fwrite($fh, $stringData);

	//close the buffered file
	fclose($fh);
?>