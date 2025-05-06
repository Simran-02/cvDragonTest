<?php
function cleantext($searchkey, $replacewith)
{
	$searchkey = preg_replace('/[^a-zA-Z0-9 ]/s', ' ', $searchkey);
	$searchkey = preg_replace('/\s+/', ' ', $searchkey);
	$searchkey = strtolower(str_replace(" ", $replacewith, $searchkey));
	return $searchkey;
}
?>
<?php
function filterThisLimit($connection, $string)
{
	$value = mysqli_real_escape_string($connection, $string);
	return $value;
}
?>
<?php
function filterThis($connection, $string)
{
	$value = mysqli_real_escape_string($connection, $string);
	$value = htmlspecialchars($value);
	return $value;
}
?>
<?php
function clean($string)
{
	$string = str_replace(' ', '', $string); // Replaces all spaces.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>
<?php
function createHP($password)
{
	$salted = '123456TPFPasswordKey123456';
	$hashed = crypt($salted, $password);
	return $hashed;
}
?>
<?php
function generateUser($string)
{
	$string = str_replace(' ', '.', $string); // Replaces all spaces.

	return strtolower(preg_replace('/[^A-Za-z0-9\-.]/', '', $string)); // Removes special chars.
}
?>
<?php
function createLink($string)
{
	$string = str_replace(' ', '-', $string); // Replaces all spaces.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>
<?php
function IDtoName($id, $connection)
{
	$sql		= "SELECT cvFullName from `cv-basic-info` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['cvFullName'];
}
?>
<?php
function IDtoImage($id, $connection)
{
	$sql		= "SELECT image from `cv-images` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['image'];
}
?>
<?php
function IDtoPlayerID($id, $connection)
{
	if($id>0) 
	{
	$sql		= "SELECT playerID from `users` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['playerID'];
	} else { return ''; }
}
?>
<?php
function IDtoPartner_PlayerID($id, $connection)
{
	$sql		= "SELECT caPlayerID from `partnerDetails` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['caPlayerID'];
}
?>
<?php
function IDtoFirstProfile($id, $connection)
{
	$sql		= "SELECT cvid from `create-cvprofile` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['cvid'];
}
?>
<?php
function partnerCodetoID($code, $connection)
{
	$sql		= "SELECT id from `partnerMore` where moreReferralCode = '" . $code . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['id'];
}
?>
<?php
function IDtoUserMobile($id, $connection)
{
	$sql		= "SELECT usermobile from `users` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['usermobile'];
}
?>
<?php
function IDtoUserMobileWA($id, $connection)
{
	$sql		= "SELECT `users`.usermobile FROM `users` INNER JOIN  `user-basic` ON `user-basic`.id = `users`.id WHERE `users`.id ='" . $id . "' AND `user-basic`.DNW=0";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['usermobile'];
}
?>
<?php
function IDtoUserMobileWATransactional($id, $connection)
{
	$sql		= "SELECT `users`.usermobile, `user-basic`.fullName, `users`.status FROM `users` INNER JOIN  `user-basic` ON `user-basic`.id = `users`.id WHERE `users`.id ='" . $id . "' AND `user-basic`.DNW!=2";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function IDtoUserEmail($id, $connection)
{
	$sql		= "SELECT emailAddress from `user-basic` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['emailAddress'];
}
?>
<?php
function mobileToID($usermobile, $connection)
{
	$sql		= "SELECT id from `users` where usermobile = '" . $usermobile . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['id'];
}
?>
<?php
function mobileToWADetails($usermobile, $connection)
{
	$sql		= "SELECT `users`.id, `user-basic`.fullName, `user-basic`.DNW, `users`.status FROM `users` INNER JOIN  `user-basic` ON `user-basic`.id = `users`.id WHERE `users`.usermobile ='" . $usermobile . "' AND `users`.status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function contactToUserDetails($userPhone, $userEmail, $connection)
{
	$string1 = "SELECT * from `supportCalls` WHERE ";
    if($userPhone!='' or $userPhone!=0) { $string2 = "`userPhone` = '$userPhone' AND ";}
	if($userEmail!='') { $string3 = "`userEmail` = '$userEmail' AND ";}
    $string4 = "status=1";
    
    $sql		= $string1.$string2.$string3.$string4;
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function emailToID($userEmail, $connection)
{
	$sql		= "SELECT id from `users` where userEmail = '" . $userEmail . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['id'];
}
?>
<?php
function socialToID($socialid, $connection)
{
	$sql		= "SELECT id from `users` where socialid = '" . $socialid . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['id'];
}
?>
<?php
function sessionName($sessionCategory, $connection)
{
	$sql		= "SELECT sessionName from `sessionDetails` where sessionCategory = '" . $sessionCategory . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['sessionName'];
}
?>
<?php
function checknotification($id,$connection)
{
	$sql 			= "SELECT messageStatus from `resource-storage` WHERE id='".$id."' order by date DESC LIMIT 1";
	$sql_query	  = mysqli_query($connection, $sql);
	$fetch 		  = mysqli_fetch_assoc($sql_query);
	if($fetch['status']=='sent') { return 0; } else { return 1; }
}
?>
<?php
function getMobileFromMessage($messageID,$connection)
{
        	$sql		= "SELECT `data` from `resource-storage` where messageID ='".$messageID."'  AND status=1";
			$sql_query	= mysqli_query($connection, $sql);
			$fetch 		= mysqli_fetch_assoc($sql_query);
			return $fetch;
}
?>
<?php
function updatenotification($id,$notificationtype,$notificationvalue,$connection)
{
$sql2 = "UPDATE `supportCalls` SET ".$notificationtype." = '".$notificationvalue."' WHERE id='".$id."' and status=1";
$qry2 = mysqli_query($connection, $sql2);
return 1;
}
?>
<?php
function notificationStatus($id,$conditiontype,$conditionvalue,$notificationtype,$notificationvalue,$connection)
{
$sql = "SELECT `supportCalls`.userName,  `users`.usermobile, `users`.status FROM `supportCalls` INNER JOIN  `users` ON `users`.id = `supportCalls`.id WHERE `supportCalls`.".$conditiontype." = '".$conditionvalue."' AND `supportCalls`.".$notificationtype." = '".$notificationvalue."' AND `users`.id='".$id."' AND `users`.usermobile is NOT NULL AND `supportCalls`.DNW=0 AND`users`.status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function notificationStatusDetails($id,$connection)
{
$sql = "SELECT `supportCalls`.*,  `users`.usermobile, `users`.status FROM `supportCalls` INNER JOIN  `users` ON `users`.id = `supportCalls`.id WHERE  `users`.id='".$id."' AND `users`.usermobile is NOT NULL AND `supportCalls`.DNW=0 AND`users`.status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function IDtoAffiliateID($id, $connection)
{
	$sql		= "SELECT affiliateID from `users` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['affiliateID'];
}
?>
<?php
function IDtoReferralCode($id, $connection)
{
	$sql		= "SELECT moreReferralCode from `partnerMore` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['moreReferralCode'];
}
?>
<?php
function IDtoPartnerID($id, $connection)
{
	$sql		= "SELECT id from `partnerMore` where moreReferralCode !=''  AND status = 1 and moreReferralCode = 
			(SELECT affiliateID from `users` where id = '" . $id . "' AND status = 1)
			";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['id'];
}
?>
<?php
function mobileToEmail($mobile, $connection)
{
	$usermobile = '91' . $mobile;
	$sql		= "SELECT emailAddress from `user-basic` where id = 
			(SELECT id from `users` where usermobile = '" . $usermobile . "' AND status = 1)
			";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['emailAddress'];
}
?>
<?php
function idToEmail($id, $connection)
{
	$sql		= "SELECT emailAddress from `user-basic` where id = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['emailAddress'];
}
?>
<?php
function referralCodetoID($referralCode, $connection)
{
	$sql		= "SELECT id from `partnerMore` where moreReferralCode = '" . $referralCode . "' and moreReferralCode !=''  AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['id'];
}
?>
<?php
function IDreferralCodetoID($id, $connection)
{
	$sql		= "SELECT id from `partnerMore` where moreReferralCode = (SELECT caReferredBy FROM partnerDetails WHERE id=$id) and moreReferralCode !=''  AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['id'];
}
?>
<?php
function addSubscriptionPointsPartners($id, $points, $connection)
{
	$sql		= "UPDATE `partnerStatus` SET caPoints =caPoints+$points, caSubscriptions = caSubscriptions+$points where id = '" . $id . "' AND status=1";
	$sql_query  = mysqli_query($connection, $sql);
}
?>
<?php
function storeData($entry,$id,$mobile,$reference,$response,$data,$messageID,$messageStatus,$connection)
{
		$sql = "INSERT INTO `resource-storage` SET 	
				id					= '".$id."',
				reference			= '" .$reference. "',
				response			= '" .$response. "',
				data				= '" .$data . "',
				entry				= '" .$entry . "',
				mobile				= '" .$mobile . "',
				messageID			= '" .$messageID . "',
				messageStatus		= '" .$messageStatus . "',
				status				= 1";
				$qry 				= mysqli_query($connection, $sql);
				if($qry) {return 1;} else {return 0;}
}
?>
<?php
function storeDataUpdate($messageID,$messageStatus,$connection)
{
		$sql = "UPDATE `resource-storage` SET 	
				messageStatus		= '" . $messageStatus . "' where 
				messageID			= '" . $messageID . "' and status = 1";
				$qry 				= mysqli_query($connection, $sql);
				if($qry) {return 1;} else {return 0;}
}
?>
<?php
function storeDataContext($entry,$id,$mobile,$reference,$response,$data,$messageID,$messageReferenceID,$messageStatus,$connection)
{
		$sql = "INSERT INTO `resource-storage` SET 	
				id					= '" . $id . "',
				reference			= '" . $reference . "',
				response			= '" . $response . "',
				data				= '" . $data . "',
				entry				= '" . $entry . "',
				mobile				= '" . $mobile . "',
				messageID			= '" . $messageID . "',
				messageReferenceID	= '" . $messageReferenceID . "',
				messageStatus		= '" . $messageStatus . "',
				status				= 1";
				$qry 				= mysqli_query($connection, $sql);
				if($qry) {return 1;} else {return 0;}
}
?>
<?php
function subscribeStatus($id,$column,$value,$connection)
{
		$sql = "UPDATE `user-basic` SET 	
				$column		= '" . $value . "' where 
				id			= '" . $id . "' and status = 1";
				$qry 				= mysqli_query($connection, $sql);
				if($qry) {return 1;} else {return 0;}
}
?>
<?php
function generateOffer($offerService,$offerAmount,$offerDuration,$id,$offerName,$offerMobile,$offerExpiry,$connection)
{
		$offerID 		   = time();
		$date	   		  = date("Y-m-d H:i:s");
		$offerStatus	   = 'activated';
		
		$sql = "INSERT INTO `user-offers` SET 	
				offerID					= '" . $offerID . "',
				offerService			= '" . $offerService . "',
				offerAmount				= '" . $offerAmount . "',
				offerDuration			= '" . $offerDuration . "',
				id						= '" . $id . "',
				offerName				= '" . $offerName . "',
				offerMobile				= '" . $offerMobile . "',
				offerExpiry				= '" . $offerExpiry . "',
				offerStatus				= '" . $offerStatus . "',
				dateCreated				= '" . $date . "',
				status					= 1";
				$qry 				= mysqli_query($connection, $sql);
				if($qry) {return $offerID;} else {return 0;}
}
?>
<?php
function referralCodetoName($moreReferralCode, $connection)
{
	$sql 	= "SELECT `partnerDetails`.caName,  `partnerDetails`.caPlayerID FROM `partnerDetails` INNER JOIN  `partnerMore` ON `partnerMore`.id = `partnerDetails`.id WHERE `partnerMore`.moreReferralCode ='" . $moreReferralCode . "' AND `partnerDetails`.status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function deliver_response($data)
{
	$json_response 		= json_encode($data);
	echo $json_response;
}
?>
<?php
function subscriptionStatus($id, $connection)
{
	$sql		= "SELECT userPremium,userAssociate,userPremiumExpiry,userAssociateExpiry from `supportCalls` where id = '" . $id . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	$details = array();
	if($fetch['userPremium']==1) 
	{ 
		$duration = (strtotime($fetch['userPremiumExpiry'])-time()); 
		if($duration>0) 
			{ 
			$daysPremium = floor($duration/86400); 
			$statementPremium ='Your PRO Subscription will expire in '.$daysPremium.' days';
			} 
		else 
			{ 
			$statementPremium ='Your PRO Subscription expired on '.$fetch['userPremiumExpiry']; 
			} 
	} else 
	{
			$statementPremium ='You do not have any active Subscription';
	}
			array_push($details,$statementPremium);
	if($fetch['userAssociate']==1) 
	{ 
		$duration = (strtotime($fetch['userAssociateExpiry'])-time()); 
		if($duration>0) 
			{ 
			$daysAssociate = floor($duration/86400); 
			$statementAssociate ='Your Institute Subscription will expire in '.$daysAssociate.' days';
			} 
		else 
			{ 
			$statementAssociate ='Your Institute Subscription expired on: '.$fetch['userAssociateExpiry']; 
			} 
	} else 
	{
			$statementAssociate ='You do not have any active Institute Subscription';
	}
			array_push($details,$statementAssociate);
	return $details;
}
?>
<?php
function SocialUserCheck($id, $connection)
{
	$sql		= "SELECT * from `users` where socialid = '" . $id . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function MobileUserCheck($usermobile, $connection)
{
	$sql		= "SELECT * from `users` where usermobile = '" . $usermobile . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function webLogin($id, $connection)
{
	$date	   = date("Y-m-d H:i:s");
	$sql		= "UPDATE `users` SET webLoginFlag =1, webLogin = '" . $date . "' where id = '" . $id . "' AND status=1";
	$sql_query  = mysqli_query($connection, $sql);
}
?>
<?php
function updateUserCategory($categoryID,$id,$connection)
{
	$sql		= "UPDATE `users` SET categoryID = '" . $categoryID . "' where id = '" . $id . "' AND status=1";
	$sql_query  = mysqli_query($connection, $sql);
}
?>
<?php
function affiliateID($id, $connection)
{
	$sql		= "SELECT status from `users` where referenceID = '" . $id . "'";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function GenUserCheck($username, $password, $connection)
{
	$sql		= "SELECT * from `users` where username = '" . $username . "' AND userPassword = '" . $password . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function OnlyUserCheck($username, $connection)
{
	$sql		= "SELECT username from `users` where username = '" . $username . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function usercheck($id, $authkey, $connection)
{
	$sql		= "SELECT status from `users` where id = '" . $id . "' AND authkey = '" . $authkey . "'";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function GlobalUserCheck($emailAddress, $phoneNo, $connection)
{
	$sql		= "SELECT * from `user-basic` where emailAddress = '" . $emailAddress . "' OR phoneNumber = '" . $phoneNo . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function UpdateSectionStatus($id, $section, $connection)
{
	$sql		= "UPDATE `create-cvsection` SET contentStatus =1 where id = '" . $id . "' AND section = '" . $section . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
}
?>
<?php
function UpdateDesignDownload($designid,$connection)
{
	$sql		= "UPDATE `resource-profiledesign` SET downloadTimes =downloadTimes+1 where designid = '" . $designid . "'";
	$sql_query	= mysqli_query($connection, $sql);
}
?>
<?php
function UpdateUserPreviewCount($resumeid,$connection)
{
	$sql		= "UPDATE `cv-resumedownload` SET count =count+1 where resumeid = '" . $resumeid . "'";
	$sql_query	= mysqli_query($connection, $sql);
}
?>
<?php
function AddSectionContent($id, $section, $connection)
{
	$sql		= "UPDATE `create-cvsection` SET contentAdded =contentAdded+1 where id = '" . $id . "' AND section = '" . $section . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
}
?>
<?php
function DeleteSectionContent($id, $section, $connection)
{
	$sql		= "UPDATE `create-cvsection` SET contentAdded =contentAdded-1 where id = '" . $id . "' AND section = '" . $section . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
}
?>
<?php
function checkAssociateName($id, $connection)
{
	$sql		= "SELECT associateName from `resource-assoicates` where associateID = '" . $id . "' AND status = 1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['associateName'];
}
?>
<?php
function GetArrayPartAll($fullArray, $part)
{
	$name = array();
	foreach ($fullArray as $inner_array) {
		array_push($name, $inner_array[$part]);
	}
	return $name;
}
?>
<?php
function searchForId($id, $array, $position1, $position2)
{
	foreach ($array as $key => $val) {
		if ($val[$position1] === $id) {
			$postiion = $key;
			$partner = $array[$key][$position2];
			return $partner;
		}
	}
	return null;
}
?>
<?php
function accountType($value)
{
	switch ($value) {
		case "1": {
				echo 'fail';
			}
			break;
		case "2": {
				echo 'basic';
			}
			break;
		default: {
				echo 'success';
			}
			break;
	}
}
?>
<?php
function genderStatus($value)
{
	switch ($value) {
		case "M": {
				echo 'Male';
			}
			break;
		case "F": {
				echo 'Female';
			}
			break;
	}
}
?>
<?php
function expStatus($value)
{
	switch ($value) {
		case "0": {
				echo 'Fresher';
			}
			break;
		case "1": {
				echo 'Experienced';
			}
			break;
		default: {
				echo 'Fresher';
			}
			break;
	}
}
?>
<?php
function dataStatus($value)
{
	switch ($value) {
		case "0": {
				echo 'pending';
			}
			break;
		case "1": {
				echo 'success';
			}
			break;
		default: {
				echo 'pending';
			}
			break;
	}
}
?>
<?php
function NumbertoValue($value)
{
	switch ($value) {
		case "0": {
				echo 'No';
			}
			break;
		case "1": {
				echo 'Yes';
			}
			break;
		case "2": {
				echo 'In Process';
			}
			break;
		default: {
				echo 'No';
			}
			break;
	}
}
?>
<?php
function pictureURL($picture)
{
	if ($picture != '') {
		echo $picture;
	} else {
		echo '/public/img/user.png';
	}
}
?>
<?php
function ImageName($id, $connection)
{
	$sql		= "SELECT image from `cv-images` where imageid = '" . $id . "' AND status=1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['image'];
}
?>
<?php
function cleanEditor($workProfile)
{
	$workProfile 	= preg_replace('/(<[^>]+) style=".*?"/i', '$1', $workProfile);
	$workProfile 	= preg_replace('/(<[^>]+) class=".*?"/i', '$1', $workProfile);
	$workProfile	= preg_replace("/<p(.*?)>/", "<div$1>", $workProfile);
	$workProfile 	= str_replace("</p>", "</div>", $workProfile);
	return $workProfile;
}
?>
<?php
function firstName($fullName)
{
	$Name = explode(" ", $fullName);
	$firstName = ucfirst($Name[0]);
	return $firstName;
}
?>
<?php
function getName($id, $connection)
{
	$sql		= "SELECT fullName from `user-basic` where id = '" . $id . "' AND status =1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['fullName'];
}
?>
<?php
function getAuth($id, $connection)
{
	$sql		= "SELECT id,username,authkey from `users` where id = '" . $id . "' OR username = '" . $id . "' AND status =1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function isPublic($id, $connection)
{
	$sql		= "SELECT fullName, publicProfile, publicProfileStatus from `user-basic` where id = '" . $id . "' and showProfile=1 AND status =1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function usernameCheck($username, $connection)
{
	$sql		= "SELECT status from `users` where username = '" . $username . "' AND status =1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['status'];
}
?>
<?php
function getSectionName($id, $connection,$userId = "1")
{
	$query="SELECT DISTINCT section,showName FROM `create-cvprofilesection` WHERE status=1 and showName!='' and id=$userId and status=1";
     // echo $query;
     $result = mysqli_query($connection, $query);
     $jsonOfNewNames   = mysqli_fetch_all($result, MYSQLI_ASSOC);
     $newNameArray=array();
     foreach($jsonOfNewNames as $newName){
         if($newName['showName']!=''){
             $newNameArray[$newName['section']]=$newName['showName'];
         }
     }
	if(array_key_exists($id, $newNameArray)){
		return $newNameArray[$id];
	}	
	else{
		$sql		= "SELECT sectionName from `resource-section` where section = '" . $id . "' AND status =1";
		$sql_query	= mysqli_query($connection, $sql);
		$fetch 		= mysqli_fetch_assoc($sql_query);
		return $fetch['sectionName'];
	}
}
?>
<?php
function getSectionID($link, $connection)
{
	$sql		= "SELECT section from `resource-section` where sectionLink = '" . $link . "' AND status =1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['section'];
}
?>
<?php
function generateKey()
{
	$key1 = rand(1000, 9999);
	$key2 = rand(1000, 9999);
	$key3 = rand(1000, 9999);
	$key = $key1 . '-' . $key2 . '-' . $key3;
	return $key;
}
?>
<?php
function generateVoucher()
{
	$key1 = rand(100, 999);
	$key2 = rand(100, 999);
	$key = $key1 . $key2;
	return $key;
}
?>
<?php
function dobFormat($date,$format)
{
	switch ($format) {
		case "0": {
	$originalDate = $date;
	$newDate = date("d-m-Y", strtotime($originalDate));
	return $newDate;
			}
			break;
		case "1": {
	$date1 = $date;
	$date2 = date("Y/m/d");
	
	$ts1 = strtotime($date1);
	$ts2 = strtotime($date2);
	
	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);
	
	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);
	
	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
	$age = (int)($diff/12);
	return $age.' years';
			}
			break;
		case "2": {
	$originalDate = $date;
	$newDate = date("d F Y", strtotime($originalDate));
	return $newDate;
			}
			break;
		default: {
	$originalDate = $date;
	$newDate = date("d-m-Y", strtotime($originalDate));
	return $newDate;
			}
			break;
	}
}
?>
<?php
function dateFormat($date)
{
	$originalDate = $date;
	$newDate = date("d-m-Y", strtotime($originalDate));
	return $newDate;
}
?>
<?php
function showMonthYear($date)
{
	$originalDate = $date;
	$newDate = date("M Y", strtotime($originalDate));
	return $newDate;
}
?>
<?php
function showFullDate($date)
{
	$originalDate = $date;
	$newDate = date("F Y", strtotime($originalDate));
	return $newDate;
}
?>
<?php
function showYear($date)
{
	$originalDate = $date;
	$newDate = date("Y", strtotime($originalDate));
	return $newDate;
}
?>
<?php
function AddTime($date)
{
	$originalDate = $date;
	$newDate = date("Y-M-d H:i:s", strtotime($originalDate) + 750 * 60);;
	return $newDate;
}
?>
<?php
function checkVoucher($securityVoucher, $connection)
{
	$sql		= "SELECT status from `resource-securityKeys` where securityVoucher = '" . $securityVoucher . "' AND status =1 AND id=0";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['status'];
}
?>
<?php
function getVoucherDetails($securityVoucher, $connection)
{
	$sql		= "SELECT assignTo,design,timePeriod,message,note from `resource-securityKeys` where securityVoucher = '" . $securityVoucher . "' AND status =1";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch;
}
?>
<?php
function checkSecurityKey($securityVoucher, $securityKey, $connection)
{
	$sql		= "SELECT status from `resource-securityKeys` where securityVoucher = '" . $securityVoucher . "' AND securityKey = '" . $securityKey . "' AND status =1 AND id=0";
	$sql_query	= mysqli_query($connection, $sql);
	$fetch 		= mysqli_fetch_assoc($sql_query);
	return $fetch['status'];
}
?>
<?php
function subscriptionDesignAccess($value)
{
	switch ($value) {
		case "0": {
				echo 'All design access';
			}
			break;
		default: {
				echo 'Premium template';
			}
			break;
	}
}
?>
<?php
function activateClaimSubscription($id,$email,$phone,$connection)
{
$sql1 = "UPDATE `offerRegistration` SET id='".$id."', activation=1 WHERE offerEmail='".$email."' and offerPhone='".$phone."' and status=1";
$qry1 = mysqli_query($connection, $sql1);
	
$sql2 = "UPDATE `user-basic` SET showFeatureFreeSubscription = 1 WHERE (id='".$id."' OR emailAddress='".$email."' OR phoneNumber='".$phone."') and status=1";
$qry2 = mysqli_query($connection, $sql2);
	
$sql3 = "UPDATE `users` SET webLoginFlag = 1 WHERE id='".$id."' and status=1";
$qry3 = mysqli_query($connection, $sql3);
return 1;
}
?>
<?php
function changeNameRequest($id,$connection)
{
$sql2 = "UPDATE `cv-basic-info` SET verified = 0 WHERE id='".$id."' and status=1";
$qry2 = mysqli_query($connection, $sql2);
return 1;
}
?>
<?php
function urlExport($data)
{
	$data = json_encode($data);
	$data = urlencode($data);
	return $data;
}
?>
<?php
function urlImport($data)
{
	$data = urldecode($data);
	$data = json_decode($data);
	$data = (array)$data;
	return $data;
}
?>
<?php
function checkExpiry($expiry)
{
	$expiry			=	strtotime($expiry);
	$current		=	strtotime(date("Y/m/d"));
	if ($expiry > $current) {
		$status	= 1;
	} else {
		$status = 0;
	}
	return $status;
}
?>
<?php
function accountCategoryType($value)
{
	switch ($value) {
		case "1": {
				echo '<button disabled class="btn btn-mini btn-warning">FREE</button>';
			}
			break;
		case "2": {
				echo '<button disabled class="btn btn-mini btn-success">BASIC</button>';
			}
			break;
		case "3": {
				echo '<button disabled class="btn btn-mini btn-success">PREMIUM</button>';
			}
			break;
		case "10": {
				echo '<button disabled class="btn btn-mini btn-inverse">SUPER ADMIN</button>';
			}
			break;
		case "11": {
				echo '<button disabled class="btn btn-mini btn-inverse">ADMIN</button>';
			}
			break;
		case "12": {
				echo '<button disabled class="btn btn-mini btn-primary">ARTICLES</button>';
			}
			break;
		case "13": {
				echo '<button disabled class="btn btn-mini btn-primary">CONTENT</button>';
			}
			break;
		case "14": {
				echo '<button disabled class="btn btn-mini btn-primary">SUPPORT</button>';
			}
			break;
		case "15": {
				echo '<button disabled class="btn btn-mini btn-primary">SALES</button>';
			}
			break;
		case "16": {
				echo '<button disabled class="btn btn-mini btn-primary">PROOF READER</button>';
			}
			break;
		case "19": {
				echo '<button disabled class="btn btn-mini btn-danger">AFFILIATE</button>';
			}
			break;
		case "20": {
				echo '<button disabled class="btn btn-mini btn-danger">ASSOCIATE</button>';
			}
			break;
		case "21": {
				echo '<button disabled class="btn btn-mini btn-danger">RESELLER</button>';
			}
			break;
		case "22": {
				echo '<button disabled class="btn btn-mini btn-danger">PARTNER ADMIN</button>';
			}
			break;
		case "27": {
				echo '<button disabled class="btn btn-mini btn-danger">PARTNER COORDINATOR</button>';
			}
			break;
		case "23": {
				echo '<button disabled class="btn btn-mini btn-danger">SUPPORT TEAM</button>';
			}
			break;
		case "24": {
				echo '<button disabled class="btn btn-mini btn-danger">SUPPORT & PARTNER ADMIN</button>';
			}
			break;
		case "25": {
				echo '<button disabled class="btn btn-mini btn-danger">KC ADMIN</button>';
			}
			break;
			case "26": {
				echo '<button disabled class="btn btn-mini btn-danger">KC & PARTNER ADMIN</button>';
			}
			break;
	}
}
?>
<?php
function SocialAccountType($value)
{
	switch ($value) {
		case "1": {
				echo '<button disabled class="btn btn-mini btn-inverse"><i class="fa fa-user-circle"></i></button>';
			}
			break;
		case "2": {
				echo '<button disabled class="btn btn-mini btn-inverse"><i class="fa fa-facebook"></i></button>';
			}
			break;
		case "3": {
				echo '<button disabled class="btn btn-mini btn-inverse"><i class="fa fa-google"></i></button>';
			}
			break;
		case "4": {
				echo '<button disabled class="btn btn-mini btn-inverse"><i class="fa fa-linkedin"></i></button>';
			}
			break;
	}
}
?>
<?php
function SocialAccountLink($value, $id)
{
	switch ($value) {
		case "1": {
				echo '<a href="" target="_blank"><button class="btn btn-mini btn-inverse">e</button></a>';
			}
			break;
		case "2": {
				echo '<a href="https://www.facebook.com/' . $id . '" target="_blank"><button class="btn btn-mini btn-inverse">F</button></a>';
			}
			break;
		case "3": {
				echo '<a href="https://plus.google.com/' . $id . '" target="_blank"><button class="btn btn-mini btn-inverse">G</button></a>';
			}
			break;
		case "4": {
				echo '<a href="https://www.linkedin.com/in/' . $id . '" target="_blank"><button class="btn btn-mini btn-inverse">in</button></a>';
			}
			break;
	}
}
?>
<?php
function checkSuperAdmin($category)
{
	$admin 		= array("10");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAdminOnly($category)
{
	$admin 		= array("0", "10", "11");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAdmin($category)
{
	$admin 		= array("0", "10", "11", "12", "13", "14", "15", "16");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAdminArticle($category)
{
	$admin 		= array("0", "10", "11", "12");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAdminContent($category)
{
	$admin 		= array("0", "10", "11", "13");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAdminSupport($category)
{
	$admin 		= array("0", "10", "11", "14");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAdminSales($category)
{
	$admin 		= array("0", "10", "11", "15");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAdminProofReader($category)
{
	$admin 		= array("0", "10", "11", "16");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkCCAAdmin($category)
{
	$admin 		= array("0", "10", "22");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkKCAdmin($category)
{
	$admin 		= array("0", "10", "11", "25","26");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkPartnerAdmin($category)
{
	$admin 		= array("0", "10", "22","26");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkPartnerAdminCoordinator($category)
{
	$admin 		= array("0", "10", "27");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkSupportAdmin($category)
{
	$admin 		= array("0", "10", "23");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkSupportPartnerAdmin($category)
{
	$admin 		= array("0", "10", "24");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAssociate($category)
{
	$admin 		= array("0", "10", "20");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkAffiliate($category)
{
	$admin 		= array("0", "10", "19");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php
function checkReseller($category)
{
	$admin 		= array("0", "10", "21");
	if (in_array($category, $admin)) {
		return 1;
	} else {
		return 0;
	}
}
?>
<?php //specific admin data fetch 
?>
<?php
function totalResumesViewed($showFor, $connection)
{
	if ($showFor == 1) {
		$sql		= "SELECT status from `cv-resumedownload` where status=1";
		$sql_query	= mysqli_query($connection, $sql);
		$fetch 		= mysqli_num_rows($sql_query);
		return $fetch;
	} else {
		$sql		= "SELECT status from `cv-resumedownload` where id = '" . $showFor . "' AND status =1";
		$sql_query	= mysqli_query($connection, $sql);
		$fetch 		= mysqli_num_rows($sql_query);
		return $fetch;
	}
}
?>
<?php
function totalUsersRegistered($showFor, $connection)
{
	if ($showFor == 1) {
		$sql		= "SELECT status from `users` where status=1";
		$sql_query	= mysqli_query($connection, $sql);
		$fetch 		= mysqli_num_rows($sql_query);
		return $fetch;
	} else {
		$sql		= "SELECT status from `associate-subscription` where design = '" . $showFor . "' AND status =1";
		$sql_query	= mysqli_query($connection, $sql);
		$fetch1 		= mysqli_num_rows($sql_query);

		$sql		= "SELECT status from `user-subscription` where design = '" . $showFor . "' AND status =1";
		$sql_query	= mysqli_query($connection, $sql);
		$fetch2 		= mysqli_num_rows($sql_query);

		$fetch = $fetch1 + $fetch2;


		return $fetch;
	}
}
?>
<?php
function totalUsersDeleted($status,$connection)
{
		$sql		= "SELECT COUNT(status) as count from `users` where status=$status";
		$sql_query	= mysqli_query($connection, $sql);
		$fetch 		= mysqli_fetch_assoc($sql_query);
		return $fetch['count'];
}
?>
<?php
function partnerType($value)
{
	switch ($value) {
		case "affiliate": {
				return 'Affiliate';
			}
			break;
		case "campus": {
				return 'Campus Ambassador';
			}
			break;
		case "business": {
				return 'Business Development';
			}
			break;
		case "marketing": {
				return 'Marketing';
			}
			break;
		case "alumni": {
				return 'Alumni';
			}
			break;
		case "1": {
				return 'Affiliate';
			}
			break;
		case "2": {
				return 'Campus Ambassador';
			}
			break;
		case "3": {
				return 'Business Development';
			}
			break;
		case "4": {
				return 'Marketing';
			}
			break;
		case "6": {
				return 'Alumni';
			}
			break;
	}
}
?>
<?php
function partnerCategory($value)
{
	switch ($value) {
		case "affiliate": {
				return '1';
			}
			break;
		case "campus": {
				return '2';
			}
			break;
		case "business": {
				return '3';
			}
			break;
		case "marketing": {
				return '4';
			}
			break;
		default: {
				return '1';
			}
			break;
	}
}
?>
<?php
function associateNotifications($ids, $param, $array)
{
	$result = array();
	for ($i = 0; $i < count($ids); $i++) {
		for ($j = 0; $j < count($array); $j++) {
			if ($array[$j]['sn'] == $ids[$i]) {
				$result[$ids[$i]] = $array[$j][$param];
			}
		}
	}
	return $result;
}
?>
<?php
function sendEmailTemplate(
	$template,
	$fullName,
	$emailAddress
) {

              $sendEmailURL = 'https://cvdragon.com/data/email/index.php';
              $fullData = array();
              $fullData['name']                  = $fullName;
              $fullData['email']                 = $emailAddress;
              $contents                          = urlExport($fullData);
              $url                               = $sendEmailURL . '?id=' . $id . '&authkey=' . $authkey . '&data=' . $template . '&contents=' . $contents;
              $content                           = file_get_contents($url);
              $result                            = json_decode($content, true);
			  return $result;
}
?>
<?php // ================================= ALL APP NOTIFICATIONS START ========================== 
?>
<?php
function sendNotificationPopUp(
	$details,
	$id,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/app/notificationsPopUp.php';
	$playerID = IDtoPlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['headings']		= $details['title'];
		$fullAppData['content']		 = $details['description'];
		$fullAppData['route']		   = $details['route'];
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $details['image'];
		$fullAppData['url']     		 = $details['url'];
		$fullAppData['icon_color']      = '971C4B';
        $fullAppData['showPopup'] 	   = 1;
        $fullAppData['title'] 	 	   = $details['title'];
        $fullAppData['buttonName']   	  = $details['buttonName'];
        $fullAppData['description']  	 = $details['description'];
        $fullAppData['imageUrl'] 	 	= $details['image'];
        $fullAppData['redirectLink'] 	= $details['redirectLink'];

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		//echo $url;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function sendNotification(
	$headings,
	$content,
	$route,
	$id,
	$big_picture,
	$url,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/app/notificationsPopUp.php';
	$playerID = IDtoPlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= $headings;
		$fullAppData['content']		 = $content;
		$fullAppData['route']		   = $route;
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $big_picture;
		$fullAppData['url']     		 = $url;
		$fullAppData['icon_color']      = '971C4B';
        $fullAppData['showPopup'] 	   = 1;
        $fullAppData['title'] 	 	   = $headings;
        $fullAppData['buttonName']   	  = 'Okay';
        $fullAppData['description']  	 = $content;
        $fullAppData['imageUrl'] 	 	= $big_picture;
        $fullAppData['redirectLink'] 	= $url;

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function sendNotificationCustom(
	$headings,
	$content,
	$route,
	$id,
	$big_picture,
	$url,
	$button,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/app/notificationsPopUp.php';
	$playerID = IDtoPlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= $headings;
		$fullAppData['content']		 = $content;
		$fullAppData['route']		   = $route;
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $big_picture;
		$fullAppData['url']     		 = $url;
		$fullAppData['icon_color']      = '971C4B';
        $fullAppData['showPopup'] 	   = 1;
        $fullAppData['title'] 	 	   = $headings;
        $fullAppData['buttonName']   	  = $button;
        $fullAppData['description']  	 = $content;
        $fullAppData['imageUrl'] 	 	= $big_picture;
        $fullAppData['redirectLink'] 	= $url;

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function sendNotificationLink(
	$headings,
	$content,
	$route,
	$id,
	$big_picture,
	$url,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php';
	$playerID = IDtoPlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= $headings;
		$fullAppData['content']		 = $content;
		$fullAppData['route']		   = $route;
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $big_picture;
		$fullAppData['url']     		 = $url;
		$fullAppData['icon_color']      = '971C4B';
		
		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function sendNotificationToAll(
	$headings,
	$content,
	$route,
	$big_picture,
	$url,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php';
	$fullAppData = array();
		$fullAppData['mode']			= 'all';
		$fullAppData['all']			 = array('Subscribed Users');
		$fullAppData['headings']		= $headings;
		$fullAppData['content']		 = $content;
		$fullAppData['route']		   = $route;
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $big_picture;
		$fullAppData['url']     		 = $url;
		$fullAppData['icon_color']      = '971C4B';

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
}
?>
<?php
function sendNotificationToPlayerID(
	$headings,
	$content,
	$route,
	$playerID,
	$big_picture,
	$url,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php';
	$playerID = $playerID;
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= $headings;
		$fullAppData['content']		 = $content;
		$fullAppData['route']		   = $route;
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $big_picture;
		$fullAppData['url']     		 = $url;
		$fullAppData['icon_color']      = '971C4B';

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function sendNotification_websiteLogin($id, $connection)
{
	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php';
	$playerID = IDtoPlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= 'login to cvDragon Website?';
		$fullAppData['content']		 = 'Ensure all your app data is synced to avoid data loss';
		$fullAppData['route']		   = 'profiles';
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = '';
		$fullAppData['url']     		 = '';
		$fullAppData['icon_color']      = '971C4B';

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function sendNotification_firstTime($id, $connection)
{
	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php';
	$playerID = IDtoPlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= 'Welcome to cvDragon';
		$fullAppData['content']		 = 'NextGen Resume Builder application - Build your resume in 3 simple steps';
		$fullAppData['route']		   = 'support';
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = '';
		$fullAppData['url']     		 = '';
		$fullAppData['icon_color']      = '971C4B';

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function sendNotificationToAdmin($headings, $content, $id)
{

	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php';
	$playerID = IDtoPlayerID('14889791841417', $connection);
	$fullAppData = array();

	$fullAppData['mode']			= 'custom';
	$fullAppData['headings']		= $headings;
	$fullAppData['content']		 = $content;
	$fullAppData['route']		   = '';
	$fullAppData['playerID']		= array('9d55dd4e-d43a-44f1-bb49-37271f462440','4f5b7038-24d4-49c2-b739-7c1d3ed5fbef');
	$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
	$fullAppData['big_picture']     = '';
	$fullAppData['url']     		 = 'https://cvdragon.com/profile/' . $id;
	$fullAppData['icon_color']      = '971C4B';

	$Notificationcontent				= urlExport($fullAppData);
	$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
	$content 							= file_get_contents($url);
	$result 							 = json_decode($content, true);
	$result 							 = json_decode($result['allresponses'], true);
	return $result['recipients'];
}
?>
<?php
function sendSubscriptionNotification_Admin($headings, $content, $id)
{
	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php'; 
	$playerID = IDtoPlayerID('14889791841417', $connection);
	$fullAppData = array();
// Add $connection in the main function
	$fullAppData['mode']			= 'custom';
	$fullAppData['headings']		= $headings;
	$fullAppData['content']		 = $content;
	$fullAppData['route']		   = '';
	$fullAppData['playerID']		= array('9d55dd4e-d43a-44f1-bb49-37271f462440');
	//$fullAppData['playerID']		= array($playerID);
	$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
	$fullAppData['big_picture']     = '';
	$fullAppData['url']     		 = 'https://cvdragon.com/profile/' . $id;
	$fullAppData['icon_color']      = '971C4B';

	$Notificationcontent				= urlExport($fullAppData);
	$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
	$content 							= file_get_contents($url);
	$result 							 = json_decode($content, true);
	$result 							 = json_decode($result['allresponses'], true);
	return $result['recipients'];
}
?>
<?php
function sendNotificationToReferrer($fullName, $affiliateID)
{
/*
	$sendNotificationURL = 'https://cvdragon.com/data/app/notifications.php';
	$fullAppData = array();

	$fullAppData['mode']			= 'custom';
	$fullAppData['headings']		= $headings;
	$fullAppData['content']		 = $content;
	$fullAppData['route']		   = '';
	$fullAppData['playerID']		= array("5809c6cb-6953-4301-bb36-8bfcf4bf6135");
	$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
	$fullAppData['big_picture']     = '';
	$fullAppData['url']     		 = 'https://cvdragon.com/profile/' . $id;
	$fullAppData['icon_color']      = '971C4B';

	$Notificationcontent				= urlExport($fullAppData);
	$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
	$content 							= file_get_contents($url);
	$result 							 = json_decode($content, true);
	$result 							 = json_decode($result['allresponses'], true);
	return $result['recipients'];
*/
}
?>
<?php // ================================= ALL APP NOTIFICATIONS ENDS ========================== 
?>
<?php // ================================= ALL PARTNER NOTIFICATIONS START ========================== 
?>
<?php
function partner_sendNotificationBulk(
	$headings,
	$content,
	$route,
	$playerIDs,
	$big_picture,
	$url,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/PartnerApp/notifications.php';
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= $headings;
		$fullAppData['content']		 = $content;
		$fullAppData['route']		   = $route;
		$fullAppData['playerID']		= $playerIDs;
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $big_picture;
		$fullAppData['url']     		 = $url;
		$fullAppData['icon_color']      = '971C4B';

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function partner_sendNotification(
	$headings,
	$content,
	$route,
	$id,
	$big_picture,
	$url,
	$connection
) {
	$sendNotificationURL = 'https://cvdragon.com/data/PartnerApp/notifications.php';
	$playerID = IDtoPartner_PlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= $headings;
		$fullAppData['content']		 = $content;
		$fullAppData['route']		   = $route;
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = $big_picture;
		$fullAppData['url']     		 = $url;
		$fullAppData['icon_color']      = '971C4B';

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function partner_sendNotification_firstTime($id, $connection)
{
	$sendNotificationURL = 'https://cvdragon.com/data/PartnerApp/notifications.php';
	$playerID = IDtoPartner_PlayerID($id, $connection);
	$fullAppData = array();
	if ($playerID) {
		$fullAppData['mode']			= 'custom';
		$fullAppData['headings']		= 'Welcome to cvDragon Partner Program';
		$fullAppData['content']		 = 'We are glad you are here';
		$fullAppData['route']		   = 'support';
		$fullAppData['playerID']		= array($playerID);
		$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
		$fullAppData['big_picture']     = '';
		$fullAppData['url']     		 = '';
		$fullAppData['icon_color']      = '971C4B';

		$Notificationcontent				= urlExport($fullAppData);
		$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
		$content 							= file_get_contents($url);
		$result 							 = json_decode($content, true);
		$result 							 = json_decode($result['allresponses'], true);
		return $result['recipients'];
	} else {
		return 0;
	}
}
?>
<?php
function partner_sendNotificationToAdmin($headings, $content, $type)
{
	$sendNotificationURL = 'https://cvdragon.com/data/PartnerApp/notifications.php';
	switch ($type) {
		case "0": {
				//$playerIDs = array("3de1d04d-3b8f-4948-9b54-cc476af6fe44","35dcba15-7006-4408-8e98-93a164469206","e358871d-ba64-4fea-b594-c89b75f4fcd8", "f042561e-5f6c-45a5-9dd4-fd8c11621640");
				$playerIDs = array();
				
			}
			break;
		case "1": {
				//$playerIDs = array("3de1d04d-3b8f-4948-9b54-cc476af6fe44","4a4c4db2-7dc2-4100-abdd-5c5df6abe3b6","ffe536a5-8d7c-4bf3-b909-9c25d3d70943","35dcba15-7006-4408-8e98-93a164469206");
				$playerIDs = array();
				
			}
			break;
		case "2": {
				//$playerIDs = array("3de1d04d-3b8f-4948-9b54-cc476af6fe44","4a4c4db2-7dc2-4100-abdd-5c5df6abe3b6","ffe536a5-8d7c-4bf3-b909-9c25d3d70943","35dcba15-7006-4408-8e98-93a164469206");
				$playerIDs = array();
			}
			break;
		case "3": {
				//$playerIDs = array("3de1d04d-3b8f-4948-9b54-cc476af6fe44","4a4c4db2-7dc2-4100-abdd-5c5df6abe3b6","ffe536a5-8d7c-4bf3-b909-9c25d3d70943","35dcba15-7006-4408-8e98-93a164469206");
				$playerIDs = array();
			}
			break;
		case "4": {
				//$playerIDs = array("3de1d04d-3b8f-4948-9b54-cc476af6fe44","4a4c4db2-7dc2-4100-abdd-5c5df6abe3b6","ffe536a5-8d7c-4bf3-b909-9c25d3d70943","35dcba15-7006-4408-8e98-93a164469206");
				$playerIDs = array();
			}
			break;
		default: {
				//$playerIDs = array("3de1d04d-3b8f-4948-9b54-cc476af6fe44","4a4c4db2-7dc2-4100-abdd-5c5df6abe3b6","ffe536a5-8d7c-4bf3-b909-9c25d3d70943","35dcba15-7006-4408-8e98-93a164469206");
				$playerIDs = array();
			}
			break;
	}

	$fullAppData = array();

	$fullAppData['mode']			= 'custom';
	$fullAppData['headings']		= $headings;
	$fullAppData['content']		 = $content;
	$fullAppData['route']		   = '';
	$fullAppData['playerID']		= array('9d55dd4e-d43a-44f1-bb49-37271f462440','4f5b7038-24d4-49c2-b739-7c1d3ed5fbef');
	$fullAppData['large_icon']      = 'https://cvdragon.com/public/img/notifications/large_icon.png';
	$fullAppData['big_picture']     = '';
	$fullAppData['url']     		 = '';
	$fullAppData['icon_color']      = '971C4B';

	$Notificationcontent				= urlExport($fullAppData);
	$url 								= $sendNotificationURL . '?id=1&authkey=1&contents=' . $Notificationcontent;
	$content 							= file_get_contents($url);
	$result 							 = json_decode($content, true);
	$result 							 = json_decode($result['allresponses'], true);
	//return $result['recipients'];

}
?>
<?php // ================================= ALL PARTNER NOTIFICATIONS ENDS ========================== 
?>
<?php // ================================= ALL CAMPUS NOTIFICATIONS STARTS ========================== 
?>
<?php // ================================= ALL CAMPUS NOTIFICATIONS ENDS ========================== 
?>
<?php
function activateSubscription($id, $duration, $design, $connection)
{
	$sql 				= "SELECT * FROM `user-subscription` where id ='" . $id . "' AND status=1";
	$result			 = mysqli_query($connection, $sql);
	$row 				= mysqli_fetch_assoc($result);

	if ($row['status']) {

		$securityKey 		=    $row['securityKey'];
		$expiryOld		  =	strtotime($row['expiry']);
		$current			=	strtotime(date("Y/m/d"));

		if ($expiryOld > $current) {
			$activate = $expiryOld;
		} else {
			$activate = $current;
		}
		$activate		   =	date('Y/m/d', $activate);
		$addtime		    = 	strtotime($activate);
		$expiry 		     = date("Y-m-d", strtotime("+" . $duration . " days", $addtime));

		//updateing subscription
		$sql = "UPDATE `user-subscription` SET 	
				design				= '" . $design . "',
				expiry				= '" . $expiry . "'
				WHERE 
				id					= '" . $id . "' AND
				status				= 1";
		$qry 				= mysqli_query($connection, $sql);

		//updating category
		$sql = "UPDATE `users` SET
				categoryid		= 2,  
				webLoginFlag		= 1 
				WHERE 
				id 				= '" . $id . "' 
				AND status 		= 1";
		$qry 			= mysqli_query($connection, $sql);

		if ($qry) {

			sendNotification(
				'Premium Subscription Activated for '.$duration.' Days',
				'Create and Download your resume in our Premium Designs',
				'subscribe',
				$id,
				'https://cvdr.in/public/img/offers/SFO/SFO.jpeg',
				'',
				$connection
			);


			return 1;
		} else {
			return 0;
		}
	} else {

		$securityKey 		= '5150-' . generateKey();
		$activate	   	   = date("Y/m/d");
		$addtime			= strtotime($activate);
		$expiry 		     = date("Y-m-d", strtotime("+" . $duration . " days", $addtime));

		//creating subscription
		$sql = "INSERT INTO `user-subscription` SET 	
				id					= '" . $id . "',
				design				= '" . $design . "',
				activate			= '" . $activate . "',
				expiry				= '" . $expiry . "',
				securityKey			= '" . $securityKey . "',
				dateCreated			= '" . $date . "',
				status				= 1";
		$qry 				= mysqli_query($connection, $sql);

		//updating category
		$sql = "UPDATE `users` SET
				categoryid		= 2 , 
				webLoginFlag		= 1 
				WHERE 
				id 				= '" . $id . "' 
				AND status 		= 1";
		$qry 			= mysqli_query($connection, $sql);

		if ($qry) {

			sendNotification(
				'Premium Subscription Activated for '.$duration.' Days',
				'Create and Download your resume in our Premium Designs',
				'subscribe',
				$id,
				'https://cvdr.in/public/img/offers/SFO/SFO.jpeg',
				'',
				$connection
			);


			return 1;
		} else {
			return 0;
		}
	}
}
?>
<?php
function activateSubscriptionWithOrder($id, $duration, $design, $connection, $price)
{
	$sql 				= "SELECT * FROM `user-subscription` where id ='" . $id . "' AND status=1";
	$result			 = mysqli_query($connection, $sql);
	$row 				= mysqli_fetch_assoc($result);
	$current			=	strtotime(date("Y/m/d"));

	if ($row['status']) {

		$securityKey 		=    $row['securityKey'];
		$expiryOld		  =	strtotime($row['expiry']);


		if ($expiryOld > $current) {
			$activate = $expiryOld;
		} else {
			$activate = $current;
		}
		$activate		   =	date('Y/m/d', $activate);
		$addtime		    = 	strtotime($activate);
		$expiry 		     = date("Y-m-d", strtotime("+" . $duration . " days", $addtime));

		//updateing subscription
		$sql = "UPDATE `user-subscription` SET 	
				design				= '" . $design . "',
				expiry				= '" . $expiry . "'
				WHERE 
				id					= '" . $id . "' AND
				status				= 1";
		$qry 				= mysqli_query($connection, $sql);

		//updating category
		$sql = "UPDATE `users` SET
				categoryid		= 3, 
				webLoginFlag		= 1 
				WHERE 
				id 				= '" . $id . "' 
				AND status 		= 1";
		$qry 			= mysqli_query($connection, $sql);

		if ($qry) {

			sendNotification(
				'Premium Subscription Activated for '.$duration.' Days',
				'Create and Download your resume in our Premium Designs',
				'subscribe',
				$id,
				'https://cvdr.in/public/img/offers/SFO/SFO.jpeg',
				'',
				$connection
			);

			$orderId = time();
			$sql = "INSERT INTO `orders` SET 	
					id					= '" . $id . "',
					orderid				= '$orderId',
					orderStatus			= 'Success',
					paymentMode			= 'Admin Panel',
					netAmount			= '" . $price . "',
					design				= '" . $design . "',
					transactionDate			= '" . $current . "',
					status				= 1";
			$qry 	= mysqli_query($connection, $sql);
			return 1;
		} else {
			return 0;
		}
	} else {

		$securityKey 		= '5150-' . generateKey();
		$activate	   	   = date("Y/m/d");
		$addtime			= strtotime($activate);
		$expiry 		     = date("Y-m-d", strtotime("+" . $duration . " days", $addtime));

		//creating subscription
		$sql = "INSERT INTO `user-subscription` SET 	
				id					= '" . $id . "',
				design				= '" . $design . "',
				activate			= '" . $activate . "',
				expiry				= '" . $expiry . "',
				securityKey			= '" . $securityKey . "',
				dateCreated			= '" . $date . "',
				status				= 1";
		$qry 				= mysqli_query($connection, $sql);

		//updating category
		$sql = "UPDATE `users` SET
				categoryid		= 2 , 
				webLoginFlag		= 1 
				WHERE 
				id 				= '" . $id . "' 
				AND status 		= 1";
		$qry 			= mysqli_query($connection, $sql);

		if ($qry) {

			sendNotification(
				'Premium Subscription Activated for '.$duration.' Days',
				'Create and Download your resume in our Premium Designs',
				'subscribe',
				$id,
				'https://cvdr.in/public/img/offers/SFO/SFO.jpeg',
				'',
				$connection
			);

			$orderId = time();
			$sql = "INSERT INTO `orders` SET 	
					id					= '" . $id . "',
					orderid				= '$orderId',
					orderStatus			= 'Success',
					paymentMode			= 'Admin Panel',
					netAmount			= '" . $price . "',
					design				= '" . $design . "',
					transactionDate			= '" . $current . "',
					status				= 1";
			$qry 	= mysqli_query($connection, $sql);


			return 1;
		} else {
			return 0;
		}
	}
}
?>
<?php
function activateSubscriptionRequest($id,$design,$connection)
{
	$sql 				= "SELECT * FROM `associate-subscription` where id ='" . $id . "' AND design ='" . $design . "' AND status=2";
	$result			 = mysqli_query($connection, $sql);
	$row 				= mysqli_fetch_assoc($result);

	if ($row['status']==2) {

		//updateing subscription
		$sql = "UPDATE `associate-subscription` SET 	
				status				= 1 
				WHERE 
				id					= '" . $id . "' AND
				design				= '" . $design . "' AND
				status				= 2";
		$qry 				= mysqli_query($connection, $sql);
		if ($qry) {

		//updateing subscription
		$sql = "DELETE FROM `associate-subscription` 
				WHERE 	
				id					= '" . $id . "'  AND
				status				= 2";
		$qry 				= mysqli_query($connection, $sql);

		//updating category
		$sql = "UPDATE `users` SET
				categoryid		= 2, 
				webLoginFlag		= 1 
				WHERE 
				id 				= '" . $id . "' 
				AND status 		= 1";
		$qry 			= mysqli_query($connection, $sql);

		if ($qry) {

			sendNotification(
				'Institute Subscription Activated',
				'Create and Download your resume in our Premium Designs',
				'subscribe',
				$id,
				'https://cvdr.in/public/img/offers/SFO/SFO.jpeg',
				'',
				$connection
			);

			$orderId = time();
			$sql = "INSERT INTO `orders` SET 	
					id					= '" . $id . "',
					orderid				= '$orderId',
					orderStatus			= 'Success',
					paymentMode			= 'Admin Panel',
					netAmount			= 0,
					design				= '" . $design . "',
					transactionDate			= '" . $current . "',
					status				= 1";
			$qry 	= mysqli_query($connection, $sql);
			return 1;
	}}}
}
?>
<?php
function activateAssociateSubscription($id, $duration, $design, $connection)
{
	$sql 				= "SELECT * FROM `associate-subscription` where id ='" . $id . "' AND status=1";
	$result			 = mysqli_query($connection, $sql);
	$row 				= mysqli_fetch_assoc($result);

	if ($row['status']) {

		$securityKey 		=    $row['securityKey'];
		$expiryOld		  =	strtotime($row['expiry']);
		$current			=	strtotime(date("Y/m/d"));

		if ($expiryOld > $current) {
			$activate = $expiryOld;
		} else {
			$activate = $current;
		}
		$activate		   =	date('Y/m/d', $activate);
		$addtime		    = 	strtotime($activate);
		$expiry 		     = date("Y-m-d", strtotime("+" . $duration . " days", $addtime));

		//updateing subscription
		$sql = "UPDATE `associate-subscription` SET 	
expiry				= '" . $expiry . "'
WHERE 
id					= '" . $id . "' AND
status				= 1";
		$qry 				= mysqli_query($connection, $sql);

		//updating category
		$sql = "UPDATE `users` SET
categoryid		= 2 , 
webLoginFlag		= 1 
WHERE 
id 				= '" . $id . "' 
AND status 		= 1";
		$qry 			= mysqli_query($connection, $sql);

		if ($qry) {

			sendNotification(
				'Woohoo!! Institute Subscription Activated for '.$duration.' days',
				'Create and Download your resume in your Institute Design',
				'subscribe',
				$id,
				'',
				'',
				$connection
			);


			return 1;
		} else {
			return 0;
		}
	} else {

		$securityKey 		= '5100-' . generateKey();
		$activate	   	   = date("Y/m/d");
		$design			 = $design;
		$addtime			= strtotime($activate);
		$expiry 		     = date("Y-m-d", strtotime("+" . $duration . " days", $addtime));

		//creating subscription
		$sql = "INSERT INTO `associate-subscription` SET 	
id					= '" . $id . "',
design				= '" . $design . "',
activate			= '" . $activate . "',
expiry				= '" . $expiry . "',
securityKey			= '" . $securityKey . "',
dateCreated			= '" . $date . "',
status				= 1";
		$qry 				= mysqli_query($connection, $sql);

		//updating category
		$sql = "UPDATE `users` SET
categoryid		= 3 , 
webLoginFlag		= 1 
WHERE 
id 				= '" . $id . "' 
AND status 		= 1";
		$qry 			= mysqli_query($connection, $sql);

		if ($qry) {

			sendNotification(
				'Woohoo!! Institute Subscription Activated for '.$duration.' days',
				'Create and Download your resume in your Institute Design',
				'subscribe',
				$id,
				'',
				'',
				$connection
			);


			return 1;
		} else {
			return 0;
		}
	}
}
?>
<?php
function institutedesigncv($mobile,$connection)
{
        	
            if(strlen($mobile)==12) { $mobileNumber = substr($mobile,2); }
            $data       = array();
            $sql		= "SELECT * from `instituteadmin-userdata` where mobile = '".$mobileNumber."' AND status = 1";
			$sql_query	= mysqli_query($connection, $sql);
			$fetch 		= mysqli_fetch_assoc($sql_query);
            if($fetch['resume']!='') {            
            $data['mediaLinkType']           =   'document';
            $data['mediaLinkTypeReference']  =   'link';
            $data['mediaLinkName']           =   'https://cvdragon.com/public/resources/associatePanel/resumes/'.$fetch['batch'].'/'.$fetch['institute'].'/'.$fetch['department'].'/'.$fetch['resume'];
			$data['message']                 =   'Your Institute Resume';
            } else {
            $data['mediaLinkType']           =   'text';
            $data['mediaLinkTypeReference']  =   '';
            $data['mediaLinkName']           =   '';
			$data['message']                 =   'It seems you are not registered with cvDragon or have not filled in any section. \ud83e\uddd0\n\n*Register on the application and create your CV to preview it in your institute design*';
            }
            return $data; 
            
}
?>
