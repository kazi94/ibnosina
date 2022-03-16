<?php



//get json data
$stringData = $_POST["data"];
// user id to create for each user his log of alertes
$user_id = $_POST["user_id"];

//get file
$myFile = "../json/alerte" . $user_id . ".json";

//put chmod permission
$fh = fopen($myFile, 'w') or die("can't open file");
//store json format in file
fwrite($fh, $stringData);

//close the buffered file
fclose($fh);
