<?php
define('WB_TOKEN', '4221ad844de8e6aa54796716a910fa6b60e38847cb146');
define('WB_FROM', '50378405637');

    $to = $_POST['to'];
    $msg = $_POST['msg'];

function sendMessageCurl($to, $msg){
	
	$to = filter_var($to, FILTER_SANITIZE_NUMBER_INT);

	if (empty($to)) return false;

	$msg = urlencode($msg);

	$custom_uid = "unique-" . time() ;

	$url = "https://www.waboxapp.com/api/send/chat?token=" . WB_TOKEN . "&uid=" . WB_FROM . "&custom_uid=" . $custom_uid . "&to=" . $to . "&text=" . $msg;

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($curl);
	curl_close($curl);
   
	if ($result) return json_decode($result);

	return false;

}

function sendImageCurl($to, $url_image, $caption = '', $description = ''){
	
	$to = filter_var($to, FILTER_SANITIZE_NUMBER_INT);

	if (empty($to)) return false;

	$url_image = urlencode($url_image);
	$caption = urlencode($caption);
	$description = urlencode($description);
	

	$custom_uid = "unique-" . time() ;

	$url = "https://www.waboxapp.com/api/send/image?token=" . WB_TOKEN . "&uid=" . WB_FROM . "&custom_uid=" . $custom_uid . "&to=" . $to . "&url=" . $url_image."&caption=".$caption."&description=".$description;

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($curl);
	curl_close($curl);
   
	if ($result) return json_decode($result);

	return false;

}


// $msg = 'This is a sample message\n';

// $msg.='2.This is a sample message\nssss<br>sseddd';

//change 59312345678 to a phone number destination

$result = sendMessageCurl($to,$msg);
// $result = sendImageCurl($to, "https://i.pinimg.com/474x/13/73/ac/1373acc716eb02ff0df75655b19aa01b.jpg", "asa ", "asas");

print_r($result);