<?php

/** 
*** Enable debuging when you run into issues.
*** Important note: the errors shows in the headers.
*** when the image is rendered with the debugging
*** the image get's corrupted.
**/

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);




// Load the DB
$db = new SQLite3('test.db');

// allow cross origin requests.
function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

}
// Render Image duh!
function renderImage(){
	// Set image header
	header("Content-Type: image/png");

	// Load the image

	$sign = imagecreatefrompng("signature.png");

	// Transparent
	imagealphablending($sign, false);
	imagesavealpha($sign, true);
	
	// Display the image
	imagepng($sign);
	imagedestroy($sign);

}

// update the message as read
function updateRowAsRead($id, $db){
	// $db = new SQLite3('test.db'); 
	$now = date("Y.m.d h:i:sa");
	// echo $now;
	
	// Get the user IP addr

	$ip = $_SERVER['REMOTE_ADDR'];

	// Get the browser

	$browser =  $_SERVER['HTTP_USER_AGENT'];

	// Get the languages

	$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	// $lant = "kaki";
	// Get the reffer url

	// $referer = $_SERVER['HTTP_REFERER'];
	// $referer = "kaki";
	// Get the current page url

	$current = $_SERVER['REQUEST_URI'];

	// $query = "INSERT INTO mails(rdate, ip, ua, lang, url) VALUES('$now', '$ip', '$browser', '$lang', '$referer') WHERE id = $id";
	$query = "UPDATE mails SET rdate='$now', ip='$ip', ua='$browser', lang='$lang', url='$current' WHERE id='$id'";
	$db->exec($query);

}


if($_GET['somewhatsecurelol']) {
	$token = $_GET['somewhatsecurelol'];
	if($token == "lol"){
		cors();
		$addr =  $_GET['addr'];
		$title =  $_GET['title'];
		$now = date("Y.m.d h:i:sa");
		$db->exec("INSERT INTO mails(title, addr, sdate) VALUES('$title', '$addr', '$now')");
		$id = $db->lastInsertRowID();
		echo $id;
	}

} else {
	if($_GET['signature']) {
	// check if the id is ok 
	$base_id = $_GET['signature'];
	$query = "SELECT EXISTS(SELECT * FROM mails WHERE id = $base_id)";
	$result = $db->query($query);
	$sanity = $result->fetchArray();
		if($sanity[0] ==  1){
			// echo "Exists \r\n";
			$query = "SELECT * FROM mails WHERE id = $base_id";
			$result = $db->query($query);
			$meta = $result->fetchArray();
			// print_r($meta); 
			$eTitle = $meta['title'];
			$eAddr = $meta['addr'];
			updateRowAsRead($base_id, $db);
			renderImage();

		} else {
			echo "Doesn't exists";
		}

	} else {
		renderImage();
	}
}




if(!is_file($newfile))
	$contents = "Kaki";
	file_put_contents($newfile, $contents);
}
*/


// Exit gracefully
$db->close();
unset($db);

?>


