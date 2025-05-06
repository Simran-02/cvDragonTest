<?php
// Call Functions
function urlExport($data)
{
$data = json_encode($data);
$data = urlencode($data);
return $data;
}
?>
<?php
$sendNotificationURL = $notificationURL;
$fullAppData = array();
$headings = 'Check';


	$fullAppData['mode']			= 'custom';
	$fullAppData['headings']		= $headings;
	$fullAppData['content']		 = 'Check';
	$fullAppData['route']		   = '';
	$fullAppData['playerID']		= array("34c334d1-e205-420a-be7b-c9538ba11aa6","15a7fe66-e738-4f23-97ed-794ae4b0fa33","8746e95e-a9d1-485a-a7b9-d55b5506baaf","d7a4929d-4ecb-4916-adcc-e979692a5380");
	$fullAppData['large_icon']      = $imageURL.'notifications/large_icon.png';
	$fullAppData['big_picture']     = '';
	$fullAppData['url']     		 = $profileURL.$id;
	$fullAppData['icon_color']      = '971C4B';

$Notificationcontent				= urlExport($fullAppData);
$url 								= $sendNotificationURL.'?id=1&authkey=1&contents='.$Notificationcontent;
$content 							= file_get_contents($url);
$result 							 = json_decode($content, true);
$result 							 = json_decode($result['allresponses'], true);
print_r($result);
echo '<br> Number of App Notifications Sent: ';
echo $result['recipients'];

?>