<?php 
	define('SERVER_API_KEY', 'AIzaSyAZsD2YKh5uTm9fr6LQxyUYrCqnUpz2wyg');

	require 'DbConnect.php';
	$db = new DbConnect;
	$conn = $db->connect();
	$stmt = $conn->prepare('SELECT * FROM tokens');
	$stmt->execute();
//	$tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//	foreach ($tokens as $token) {
//		$registrationIds[] = $token['token'];
//	}

	 $tokens = ['eHUIpuA7FCs:APA91bHV_9K00MLzJLVKLiFvqmFpHJ_hHtsDSDVSeeb-q3alqbPuozbJzh6PoSHvGaX1jUikKeqEGb_WXaEM_QTtF6Xw7X8cSrFemGhMY0-92-7egeHyrjMtNvzwXdKxru3wsJlXDMfH'];
	
	$header = [
		'Authorization: Key=' . SERVER_API_KEY,
		'Content-Type: Application/json'
	];

	$msg = [
		'title' => 'Testing Notification',
		'body' => 'Testing Notification from localhost',
		'icon' => 'img/icon.png',
		'image' => 'img/d.png',
	];

	$payload = [
		'registration_ids' 	=> $tokens,
		'data'				=> $msg
	];

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode( $payload ),
	  CURLOPT_HTTPHEADER => $header
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}
 ?>