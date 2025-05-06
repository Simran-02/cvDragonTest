<?PHP
header("Content-Type:application/json");

	function urlImport($data)
		{
		$data = urldecode($data);
		$data = json_decode($data);
		$data = (array)$data;
		return $data;
		}

function sendMessage($passedData) {

    $headings = array('en' => $passedData['headings'] );
    $content  = array('en' => $passedData['content'] );
    $data 	 = array('makeRoute' => $passedData['route'], 'readData' => $passedData['readData'], );

    $fields = array(
        'app_id' 					=> "c4abfa3d-d6b0-4f30-bc6f-8dc0a8c6387a",
        //'app_id' 					=> "eaedce10-a634-47f4-a9be-302e3d4420b5",
        'include_player_ids' 		=> $passedData['playerID'],
        'headings' 				  => $headings,
        'contents' 				  => $content,
        'data' 					  => $data,
        'large_icon' 				=> $passedData['large_icon'],
        'big_picture' 			   => $passedData['big_picture'],
        'url' 					   => $passedData['url'],
        'android_accent_color' 	  => $passedData['icon_color'],
    );

    if(isset($passedData['buttons'])) {
        array_push($fields, array('buttons' => $passedData['buttons'], ));
    }

    
    $fields = json_encode($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic YTY5NDc1MDQtNjRjNy00MTZlLWE2ZWQtMzM2M2RlYzBlMDIw'
        //'Authorization: Basic YzA0MTc3MTktNWU0YS00YjkzLTkwZWItNWQ0NDEwMDU3ODQw'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

function sendMessageAll($passedData) {

    $headings = array('en' => $passedData['headings'] );
    $content  = array('en' => $passedData['content'] );
    $data 	 = array('makeRoute' => $passedData['route'], 'readData' => $passedData['readData'], );


    $fields = array(
        'app_id' 					=> "c4abfa3d-d6b0-4f30-bc6f-8dc0a8c6387a",
        'included_segments' 		 => $passedData['all'],
        'headings' 				  => $headings,
        'contents' 				  => $content,
        'data' 					  => $data,
        'large_icon' 				=> $passedData['large_icon'],
        'big_picture' 			   => $passedData['big_picture'],
        'url' 					   => $passedData['url'],
        'android_accent_color' 	  => $passedData['icon_color'],
    );

    if(isset($passedData['buttons'])) {
        array_push($fields, array('buttons' => $passedData['buttons'], ));
    }

    
    $fields = json_encode($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic YTY5NDc1MDQtNjRjNy00MTZlLWE2ZWQtMzM2M2RlYzBlMDIw'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

	$contents     = urlImport($_GET['contents']);
	$mode		 = $contents['mode'];
	$headings	 = $contents['headings'];
	$content	  = $contents['content'];
	$route		= $contents['route'];
	$readData	= $contents['readData'];
	$playerID	 = $contents['playerID'];
	$all	 	  = $contents['all'];
	$large_icon   = $contents['large_icon'];
	$big_picture  = $contents['big_picture'];
	$url  		  = $contents['url'];
	$icon_color   = $contents['icon_color'];

	
	
switch ($mode)
{
case "all":
{
	$dataToBePassed = array(
    'headings'			 => $headings, 
    'content'			  => $content, 
    'route'				=> $route, 
	'readData'				=> $readData, 
    'all'   			 	  => $all, 
    'large_icon' 		   => $large_icon, 
    'big_picture' 		  => $big_picture, 
    'url'	 			  => $url, 
    'icon_color' 		   => $icon_color, 
);


	$response 					= sendMessageAll($dataToBePassed);
	$return["allresponses"] 	  = $response;
	$return 					  = json_encode($return);
	
	print($return);

}
break;
case "custom":
{
$dataToBePassed = array(
    'headings'			 => $headings, 
    'content'			  => $content, 
    'route'				=> $route, 
	'readData'				=> $readData, 
    'playerID'   			 => $playerID, 
    'large_icon' 		   => $large_icon, 
    'big_picture' 		  => $big_picture, 
    'url'	 			  => $url, 
    'icon_color' 		   => $icon_color, 
);


	$response 					= sendMessage($dataToBePassed);
	$return["allresponses"] 	  = $response;
	$return 					  = json_encode($return);
	
	print($return);
}
break;
}
