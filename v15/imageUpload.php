<?php
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");
header("Content-Type:application/json");

$cTime		= time();
$id 		   = isset($_POST['id']) 			 ? $_POST['id'] : '';
$authkey 	  = isset($_POST['authkey']) 		? $_POST['authkey'] : '';
$profileID 	= isset($_POST['profileID']) 	  ? $_POST['profileID'] : '';
$imageid 	= isset($_POST['imageid']) 	  ? $_POST['imageid'] : '';

$flag = "0";

if($id) {
	if($authkey) {
		if(usercheck($id,$authkey,$connection)) {

$id 	= $id;
$key   = $authkey;
$cvid  = $profileID;

if($id !="") {
	if($key !="") {	
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(@is_uploaded_file($_FILES['image']['tmp_name'])) {

$valid_exts 	= array("jpeg", "JPEG", "jpg", "JPG", "PNG", "png", "GIF", "gif");
$maxDimension  = 800;

$path 			= '../../../public/resources/profileImages/'; // upload directory
$imageSize 		= $_FILES['image']['size'];
$file_name 		= $_FILES['image']['tmp_name'];
$imageDetails 	= getimagesize($file_name);
$imageWidth 	= $imageDetails[0];
$imageHeight 	= $imageDetails[1];
$imageFormat	= $imageDetails['mime'];
$imageExt		= strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));



if ($imageFormat == 'image/jpeg') {

$imageFName		= $imageName.'.jpeg';

}
elseif ($imageFormat == 'image/gif') {

$imageFName		= $imageName.'.gif';

}
elseif ($imageFormat == 'image/png') {

$imageFName		= $imageName.'.png';

}

				if($imageid==''){
$imageName		= time().rand(1,100);
$imageFName		= $imageName.'.jpeg';
				}
				else{
				$imageName		= $imageid;
				$imageFName		= $imageName;
					
				}
$imagePath		= $path.$imageFName;

if($imageWidth >= $maxDimension || $imageHeight >= $maxDimension)
	{

	$rationWH = $imageWidth/$imageHeight;
		if($rationWH >1) 
			{
		$newWidth = $maxDimension;
		$newHeight = $maxDimension/$rationWH;
			} else {
		$newWidth = $maxDimension*$rationWH;
		$newHeight = $maxDimension;
			}
	} else { 
		$newWidth = $imageWidth;
		$newHeight = $imageHeight;
	}

    $src = imagecreatefromstring(file_get_contents($file_name));
    $dst = imagecreatetruecolor( $newWidth, $newHeight );
    imagecopyresampled( $dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight );
    imagedestroy( $src );
	
if ($imageFormat == 'image/jpeg') {

imagejpeg($dst, $imagePath, 75);

}
elseif ($imageFormat == 'image/gif') {

imagegif($dst, $imagePath);

}
elseif ($imageFormat == 'image/png') {

imagepng($dst, $imagePath);

}

    imagedestroy( $dst );
	
//update image table
$sql = "INSERT INTO `cv-images` SET
id 				= '".$id."',
refID 			= '".$cTime."', 
image			= '".$imageFName."',
status		 	= 1";
$qry 			= mysqli_query($connection, $sql);

$refid = $connection->insert_id;

UpdateSectionStatus($id,51102,$connection); AddSectionContent($id,51102,$connection); 

// update cv profile with image id
$sqlImage = "UPDATE `create-cvprofile` SET 
profilePicture	= '".$refid."' 
WHERE 
id 				= '".$id."' AND 
cvid			= '".$cvid."' 
AND status 		= 1";
$qryImage 		= mysqli_query($connection, $sqlImage);

if($qryImage) $flag = "1";

deliver_response($flag);

$checkNotification = checknotification($id,$connection);
if($checkNotification==1) { 

	$notifyStatus = notificationStatusDetails($id,$connection);
	if($notifyStatus['status']==1) 
	{ 

		if($notifyStatus['ui_profileimage']==0) 
		{

	//send WA
	$sendWAURL = $sendWAURL;
	$fullWAData = array();
	$fullWAData['phoneNumber']        = IDtoUserMobileWA($id, $connection);
	$fullWAData['userName']           = IDtoName($id, $connection);
	$fullWAData['mediaLink']      	  = 'https://cvdragon.com/public/resources/profileImages/'.$imageFName;
	$WATemplate               		   = 'profileimageuploaded';
	$WAcontent                        = urlExport($fullWAData);
	$entryID						  = 565567315637280;
	$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                          = file_get_contents($url);
	$result                           = json_decode($content, true);

	updatenotification($id,'ui_profileimage','1',$connection);

		}
	}
}
 ?>
 <?php }}}} ?> 
 <?php }}} ?>