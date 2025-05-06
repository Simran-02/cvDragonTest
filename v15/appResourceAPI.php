<?php
session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");
include("globals.php");
header("Content-Type:application/json");

//Get details from the url
$id            = isset($_GET['id'])         ? $_GET['id'] : '';
$authkey       = isset($_GET['authkey'])     ? $_GET['authkey'] : '';
$data          = isset($_GET['data'])         ? $_GET['data'] : '';
$publickey    = 'cvDragonPublicKey54321';
$date          = date("Y-m-d H:i:s");

if ($id) {
    if ($authkey) {
        if (usercheck($id, $authkey, $connection) || $authkey == $publickey) {
            switch ($data) {
                case "appConfig": {
                        $sql     = "SELECT configkey, configvalue, configvalueios, parameter FROM `cvDragonAppConfigNew` where version=15 and sendData=1";
                        $result = mysqli_query($connection, $sql);

                        $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        if ($json == null) {
                            $json = array();
                            // $json[0] = array();
                            // $json[0]['design'] = "99999";
                            // $json[0]['expiry'] = "2020-12-31";

                        }
						
					$serverTime = array(
									'configkey'		=> 'SERVERTIME',
									'configvalue'	  => '1',
									'configvalueios'   => '1',
									'parameter'		=> date('c', strtotime($date))
									);
						
						array_push($json,$serverTime);

						deliver_response($json);
                    }
                    break;

                case "verifyUserSocial": {

                        $socialID     = $_GET['socialID'];
                        $sql     = "SELECT id, authKey, categoryid, dateUpdated, playerID FROM `users` where socialid ='" . $socialID . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        deliver_response($row);
                    }
                    break;
                case "verifyUserMobile": {

                        $usermobile     = $_GET['usermobile'];

                        $sql     = "SELECT id, authKey, categoryid, dateUpdated, playerID FROM `users` where usermobile ='".$usermobile."' AND status=1";
						$result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);
						deliver_response($row);
                    }
                    break;
                case "verifyUserEmail": {

                        $userEmail     = $_GET['userEmail'];

                        $sql     = "SELECT id, authKey, categoryid, dateUpdated, playerID FROM `users` where userEmail ='".$userEmail."' AND status=1";
						$result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);
						deliver_response($row);

                    }
                    break;
                case "allSectionsBasic": {

                        $allSectionArray = array();
                        $sql     = "SELECT section, defaultSection, sectionContentApp, sectionDefaultContent, orderSection sectionName FROM `resource-section` where main=1 AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            deliver_response($allSectionArray);
                        }
                    }
                    break;

                case "allSectionTabs": {

                        $sectionTable     = $_GET['tabType'];
                        $allSectionArray = array();
                        $sql     = "SELECT section as categoryID, sectionName, idColumnName as postType FROM `resource-section` where main=3 AND sectionTable ='" . $sectionTable . "'  AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            deliver_response($allSectionArray);
                        }
                    }
                    break;

                case "allFAQsHelp": {

                        $allSectionArray = array();
                        $sql     = "SELECT * FROM `help-faq` where app=1 and  status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            deliver_response($allSectionArray);
                        }
                    }
                    break;
                case "allVideosHelp": {

                        $allSectionArray = array();
                        $sql     = "SELECT * FROM `help-videos` where  status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            deliver_response($allSectionArray);
                        }
                    }
                    break;
                case "allSections": {

                        $allSectionArray = array();
                        // $sql     = "SELECT * FROM `resource-section` where main=1 AND status=1";
                        $sql     = "SELECT section, defaultSection, sectionContentApp, sectionDefaultContent,orderSection sectionName FROM `resource-section` where main=1 AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            deliver_response($allSectionArray);
                        }
                    }
                    break;
                case "allDesigns": {

                        $allDesignArray = array();
                        $sql     = "SELECT * FROM `resource-profiledesign` where status=1 and app=1 and version like '%7%' and category!=4";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allDesignArray, $row);
                            }
                            deliver_response($allDesignArray);
                        }
                    }
                    break;
                case "allProfileSettings": {

                        $allProfileSettingsArray = array();
                        $sql     = "SELECT * FROM `resource-profilesetting` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allProfileSettingsArray, $row);
                            }
                            deliver_response($allProfileSettingsArray);
                        }
                    }
                    break;
                case "allProfileFonts": {

                        $allProfileFontsArray = array();
                        $sql     = "SELECT * FROM `resource-profilefont` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allProfileFontsArray, $row);
                            }
                            deliver_response($allProfileFontsArray);
                        }
                    }
                    break;
                case "TipSection": {
                        $sql     = "SELECT * FROM `resource-tips` where section ='" . $_GET['section'] . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        deliver_response($row);
                    }
                    break;

                case "allTips": {

                        $TipArray = array();
                        $sql     = "SELECT * FROM `resource-tips` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TipArray, $row);
                            }
                            deliver_response($TipArray);
                        }
                    }
                    break;
                case "allServices": {
					
                        $userCategory = $_GET['userCategory'];
                        $TipArray = array();
                        $sql     = "SELECT * FROM `resource-servicesNew` where `app`=1 and status=1 and `serviceCategory` like '%$userCategory%' order by `serviceOrder` DESC";
						//echo $sql;
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TipArray, $row);
                            }
                            deliver_response($TipArray);
                        }
                    }
                    break;

                case "IndividualService": {
                        $serviceID             = $_GET['serviceID'];

                        $sql     = "SELECT * FROM `resource-servicesNew` where serviceID = '" . $serviceID . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        deliver_response($row);
                    }
                    break;

                case "allUpcomingFeatures": {

                        $TipArray = array();
                        $sql     = "SELECT * FROM `resource-upcomingFeatures` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TipArray, $row);
                            }
                            deliver_response($TipArray);
                        }
                    }
                    break;

                case "FaqSection": {
                        $section             = $_GET['section'];

                        $sql     = "SELECT * FROM `resource-faqs` where section ='" . $section . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        deliver_response($row);
                    }
                    break;
                case "allFaqSection": {

                        $FAQArray = array();
                        $sql     = "SELECT * FROM `resource-faqs` where status=1";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($FAQArray, $row);
                            }
                            deliver_response($FAQArray);
                        }
                    }
                    break;
                case "keyPhrases": {

                        $keyPhrasesArray = array();
                        $section             = $_GET['section'];

                        $sql     = "SELECT * FROM `resource-all` where section  ='" . $section . "' AND status=1 ORDER BY keyitem ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($keyPhrasesArray, $row);
                            }
                            deliver_response($keyPhrasesArray);
                        } else {
                            deliver_response($keyPhrasesArray);
                        }
                    }
                    break;
                case "allNotifications": {

                        $userCategory = $_GET['userCategory'];

                        $allNotifications = array();
                        $sql     = "SELECT notificationID,displayImage FROM `notifications` where  status=1 and `notificationCategory` like '%$userCategory%' and `version` like '%7%' order by `notificationID` DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allNotifications, $row);
                            }
                        }
                        deliver_response($allNotifications);
                    }
                    break;

                case "showIndividualNotification": {

                        $notificationID = $_GET['notificationID'];
                        $Notifications = array();
                        $sql     = "SELECT * FROM `notifications` where notificationID='" . $notificationID . "' and status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($Notifications, $row);
                            }
                            deliver_response($Notifications);
                        }
                    }
                    break;

                case "getAppVersion": {

                        $version = '1.1';
                        deliver_response($version);
                    }
                    break;
                case "allkeyPhrases": {

                        $keyPhrasesArray = array();
                        $sql     = "SELECT * FROM `resource-all` WHERE status=1 ORDER BY keyitem ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($keyPhrasesArray, $row);
                            }
                            deliver_response($keyPhrasesArray);
                        } else {
                            deliver_response($keyPhrasesArray);
                        }
                    }
                    break;
                case "createUser": {
                        $userArray = array();
                        //all params
                        $id              = time() . rand(1, 10000);
                        $authkey         = md5(microtime() . rand());
                        $socialid        = $_GET['socialid'];
                        $socialType      = $_GET['socialType'];
                        $playerID        = $_GET['playerID'];

                        $contents        = urlImport($_GET['contents']);
                        $fullName        = ucwords(strtolower($contents['fullName']));
                        $emailAddressC    = $contents['emailAddress'];
						if($emailAddressC=='') { $emailAddress = 'NULL'; } else { $emailAddress = "'".$emailAddressC."'";}

                        $affiliateID    = $_GET['affiliateID'];
                        $countryCode    = $_GET['countryCode'];
                        $phoneNumber    = $_GET['phoneNumber'];
						if($phoneNumber=='') { $userPhone = 'NULL'; } else { $userPhone = "'".$countryCode.$phoneNumber."'";}

                        $profileName    = 'First Profile';

                        $sectionType    = $_GET['sectionType'];
                        if ($sectionType != 0) {

                            if ($sectionType == 1) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51106", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121", "51123", "51122");
                            }
                            if ($sectionType == 2) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51106", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121", "51123", "51123");
                            }
                            if ($sectionType == 3) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51104", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121");
                            }

                                if ($socialType == 5) {
                                    //insert into database
                                    //CURRENTLY ALL THE USERS ARE BEING MADE PREMIUM USERS
                                    $sql = "INSERT INTO `users` SET
                                        id				= '" . $id . "',
                                        categoryid		= 1, 
                                        affiliateID		= '" . $affiliateID . "',
                                        appLogin		= '" . $date . "',
                                        socialType 		= '" . $socialType . "',
                                        socialid		= '" . $socialid . "',
                                        authkey			= '" . $authkey . "',
                                        username		= '" . $id . "',
                                        playerID		= '" . $playerID . "',
                                        status		 	= 1";
                                } else {
                                    //insert into database
                                    $sql = "INSERT INTO `users` SET
                                        id				= '" . $id . "',
                                        categoryid		= 1, 
                                        affiliateID		= '" . $affiliateID . "',
                                        appLogin		= '" . $date . "',
                                        socialType 		= '" . $socialType . "',
                                        socialid		= '" . $socialid . "',
                                        authkey			= '" . $authkey . "',
                                        username		= '" . $id . "',
                                        playerID		= '" . $playerID . "',
                                        userEmail		= 	$emailAddress,
                                        usermobile		= 	$userPhone,
                                        status		 	= 1";
                                }

                                $qry = mysqli_query($connection, $sql);

                                if ($qry) {
                                    array_push($userArray, array('id' => $id, 'authkey' => $authkey));

                                    $sql = "INSERT INTO `user-basic` SET
id 				= '" . $id . "',
fullName		= '" . $fullName . "',
emailAddress	= '" . $emailAddressC . "',
countryCode		= '" . $countryCode . "',
phoneNumber		= '" . $phoneNumber . "',
profileImageUrl	= '" . $profileImageUrl . "',
dateCreated		= '" . $date . "',
status		 	= 1";
                         $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-contact` SET
id 				= '" . $id . "',
phoneNumber		= '" . $phoneNumber . "',
emailAddress	= '" . $emailAddressC . "',
location		= '" . $location . "', 
status 			= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-preference` SET
id 				= '" . $id . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-basic-info` SET
id 				= '" . $id . "',
cvFullName		= '" . $fullName . "',
nationality		= '',
gender			= '',
dateBirth		= '',
maritalStatus	= '',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-introduction` SET
id 				= '" . $id . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'classX',
refID			= 1,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'classXII',
refID			= 2,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'graduation',
refID			= 3,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);
                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'diploma',
refID			= 4,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);




                                    $cvParaSection = array_unique($sections);
                                    $cvParaSection = array_values($cvParaSection);
                                    $cvParaSection = json_encode($cvParaSection);

                                    $sql = "INSERT INTO `create-cvprofile` SET
id 				= '" . $id . "',
profileName		= '" . $profileName . "',
sections		= '" . $cvParaSection . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);
                                    $cvProfileID = mysqli_insert_id($connection);

                                    if ($cvProfileID) {
                                        $cvProfileSection = array_unique($sections);
                                        $cvProfileSection = array_values($cvProfileSection);
                                        $countProfileSection = count($cvProfileSection);

                                        for ($x = 0; $x < $countProfileSection; $x++) {
                                            $sql = "INSERT IGNORE INTO `create-cvprofilesection` SET 	
cvid		= '" . $cvProfileID . "',
id			= '" . $id . "',
section		= '" . $cvProfileSection[$x] . "', 
status		= 1";
                                            $qry = mysqli_query($connection, $sql);
                                        }

                                        $count = count($sections);
                                        for ($x = 0; $x < $count; $x++) {
                                            $sql = "INSERT IGNORE INTO `create-cvsection` SET 	
`id`			= '" . $id . "',
`section`		= '" . $sections[$x] . "', 
`status`		= 1";
                                            $qry = mysqli_query($connection, $sql);
                                        }
                                    }
                                }


                                //send app notification
                                sendNotification_firstTime($id, $connection);
                                //send app notification to admin
                                sendNotificationToAdmin('New App Registration', $fullName, $id);


                                //Check and Activate Subscription + Send Partner Notification
                               /* $affiliateUserID = partnerCodetoID($affiliateID, $connection);
                                if ($affiliateUserID) {
                                    activateSubscription($id, 7, 0, $connection);
                                    partner_sendNotification('New Registration', $fullName . ' has registered', '', $affiliateUserID, '', '', $connection);
                                }
*/
								if($emailAddressC!=''){
                                //Send Email
                                $sendEmailURL = $emailURL;
                                $fullData = array();
                                $fullData['name'] = $fullName;
                                $fullData['email'] = $emailAddress;

                                $contents = urlExport($fullData);
                                $url = $sendEmailURL . '?id=' . $id . '&authkey=' . $authkey . '&data=registration&contents=' . $contents;
                                $content = file_get_contents($url);
                                $result = json_decode($content, true);
								}
								if($phoneNumber!=''){
								//send WA
								$sendWAURL 				   = $sendWAURL;
								$fullWAData 				  = array();
								$fullWAData['phoneNumber']   = $countryCode.$phoneNumber;
								$fullWAData['userName']      = $fullName;
								$fullWAData['headerImage']   = 'https://cvdragon.com/data/facebook/resources/whycvDragon.jpg';
								$WATemplate               	  = 'welcomemessage';
								$WAcontent                   = urlExport($fullWAData);
								$entryID					 = 105486032380156;
								$url                         = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
								$content                     = file_get_contents($url);
								$result                      = json_decode($content, true);
								}
                                deliver_response($userArray);
                        }
                    }
                    break;

                case "createGuest": {
                        $userArray = array();
                        //all params
                        $id              = time() . rand(1, 10000);
                        $authkey         = md5(microtime() . rand());
                        $socialType      = 0;
                        $playerID        = $_GET['playerID'];

                        $contents        = urlImport($_GET['contents']);
                        $fullName        = filterThis($connection, $contents['fullName']);
                        $fullName        = ucwords(strtolower($fullName));

                        $profileName    = 'First Profile';

                        $sectionType    = $_GET['sectionType'];
                        if ($sectionType != 0) {

                            if ($sectionType == 1) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51106", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121", "51123", "51122");
                            }
                            if ($sectionType == 2) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51106", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121", "51123", "51123");
                            }
                            if ($sectionType == 3) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51104", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121");
                            }

                                    //insert into database
                                    $sql = "INSERT INTO `users` SET
                                        id				= '" . $id . "',
                                        categoryid		= 0, 
                                        appLogin		= '" . $date . "',
                                        socialType 		= '" . $socialType . "',
                                        authkey			= '" . $authkey . "',
                                        username		= '" . $id . "',
                                        playerID		= '" . $playerID . "',
                                        status		 	= 1";
                                }

                                $qry = mysqli_query($connection, $sql);

                                if ($qry) {
                                    array_push($userArray, array('id' => $id, 'authkey' => $authkey));

                                    $sql = "INSERT INTO `user-basic` SET
id 				= '" . $id . "',
fullName		= '" . $fullName . "',
countryCode		= 91,
profileImageUrl	= '" . $profileImageUrl . "',
dateCreated		= '" . $date . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-contact` SET
id 				= '" . $id . "',
status 			= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-preference` SET
id 				= '" . $id . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-basic-info` SET
id 				= '" . $id . "',
cvFullName		= '" . $fullName . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-introduction` SET
id 				= '" . $id . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'classX',
refID			= 1,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'classXII',
refID			= 2,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'graduation',
refID			= 3,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);
                                    $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'diploma',
refID			= 4,
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);

                                    $cvParaSection = array_unique($sections);
                                    $cvParaSection = array_values($cvParaSection);
                                    $cvParaSection = json_encode($cvParaSection);

                                    $sql = "INSERT INTO `create-cvprofile` SET
id 				= '" . $id . "',
profileName		= '" . $profileName . "',
sections		= '" . $cvParaSection . "',
status		 	= 1";
                                    $qry = mysqli_query($connection, $sql);
                                    $cvProfileID = mysqli_insert_id($connection);

                                    if ($cvProfileID) {
                                        $cvProfileSection = array_unique($sections);
                                        $cvProfileSection = array_values($cvProfileSection);
                                        $countProfileSection = count($cvProfileSection);

                                        for ($x = 0; $x < $countProfileSection; $x++) {
                                            $sql = "INSERT IGNORE INTO `create-cvprofilesection` SET 	
cvid		= '" . $cvProfileID . "',
id			= '" . $id . "',
section		= '" . $cvProfileSection[$x] . "', 
status		= 1";
                                            $qry = mysqli_query($connection, $sql);
                                        }

                                        $count = count($sections);
                                        for ($x = 0; $x < $count; $x++) {
                                            $sql = "INSERT IGNORE INTO `create-cvsection` SET 	
`id`			= '" . $id . "',
`section`		= '" . $sections[$x] . "', 
`status`		= 1";
                                            $qry = mysqli_query($connection, $sql);
                                        }
                                    }
                                }

                                //send app notification
                                sendNotification_firstTime($id, $connection);
                                //send app notification to admin
                                sendNotificationToAdmin('New App Registration', $fullName, $id);

                            deliver_response($userArray);
                    }
                    break;

                case "createUser2": {
                        $userArray = array();
                        //all params
                        $id              = time() . rand(1, 10000);
                        $authkey         = md5(microtime() . rand());
                        $socialid        = $_GET['socialid'];
                        $socialType      = $_GET['socialType'];
                        $playerID        = $_GET['playerID'];

                        $contents        = urlImport($_GET['contents']);
                        $fullName        = ucwords(strtolower($contents['fullName']));
                        $emailAddress    = $contents['emailAddress'];

                        $affiliateID    = $_GET['affiliateID'];
                        $countryCode    = $_GET['countryCode'];
                        $phoneNumber    = $_GET['phoneNumber'];
                        $profileName    = 'First Profile';

                        $sectionType    = $_GET['sectionType'];
                        if ($sectionType != 0) {

                            if ($sectionType == 1) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51106", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121", "51123", "51122");
                            }
                            if ($sectionType == 2) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51106", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121", "51123", "51123");
                            }
                            if ($sectionType == 3) {
                                $sections = array("51099", "51100", "51101", "51102", "51103", "51104", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121");
                            }


                            if ($socialType == 5) {
                                //insert into database
                                //CURRENTLY ALL THE USERS ARE BEING MADE PREMIUM USERS
                                $sql = "INSERT INTO `users` SET
                                        id				= '" . $id . "',
                                        categoryid		= 1, 
                                        affiliateID		= '" . $affiliateID . "',
                                        socialType 		= '" . $socialType . "',
                                        socialid		= '" . $socialid . "',
                                        authkey			= '" . $authkey . "',
                                        username		= '" . $id . "',
                                        usermobile		= '" . $id . "',
                                        playerID		= '" . $playerID . "',
                                        status		 	= 1";


                            } else {
                                //insert into database
                                //CURRENTLY ALL THE USERS ARE BEING MADE PREMIUM USERS
                                $sql = "INSERT INTO `users` SET
                                        id				= '" . $id . "',
                                        categoryid		= 1, 
                                        affiliateID		= '" . $affiliateID . "',
                                        socialType 		= '" . $socialType . "',
                                        socialid		= '" . $socialid . "',
                                        authkey			= '" . $authkey . "',
                                        username		= '" . $id . "',
                                        playerID		= '" . $playerID . "',
                                        usermobile		= '" . "91" . $phoneNumber . "',
                                        status		 	= 1";
                            }

                            $qry = mysqli_query($connection, $sql);

                            if ($qry) {
                                array_push($userArray, array('id' => $id, 'authkey' => $authkey));

                                $sql = "INSERT INTO `user-basic` SET
id 				= '" . $id . "',
fullName		= '" . $fullName . "',
emailAddress	= '" . $emailAddress . "',
countryCode		= '" . $countryCode . "',
phoneNumber		= '" . $phoneNumber . "',
profileImageUrl	= '" . $profileImageUrl . "',
dateCreated		= '" . $date . "',
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);

                                $sql = "INSERT INTO `cv-contact` SET
id 				= '" . $id . "',
phoneNumber		= '" . $phoneNumber . "',
emailAddress	= '" . $emailAddress . "', 
location		= '" . $location . "', 
status 			= 1";
                                $qry = mysqli_query($connection, $sql);

                                $sql = "INSERT INTO `cv-preference` SET
id 				= '" . $id . "',
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);

                                $sql = "INSERT INTO `cv-basic-info` SET
id 				= '" . $id . "',
cvFullName		= '" . $fullName . "',
nationality		= '',
gender			= '',
dateBirth		= '',
maritalStatus	= '',
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);

                                $sql = "INSERT INTO `cv-introduction` SET
id 				= '" . $id . "',
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);

                                $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'classX',
refID			= 1,
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);

                                $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'classXII',
refID			= 2,
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);

                                $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'graduation',
refID			= 3,
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);
                                $sql = "INSERT INTO `cv-education` SET
id 				= '" . $id . "',
category		= 'diploma',
refID			= 4,
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);


                                $cvParaSection = array_unique($sections);
                                $cvParaSection = array_values($cvParaSection);
                                $cvParaSection = json_encode($cvParaSection);

                                $sql = "INSERT INTO `create-cvprofile` SET
id 				= '" . $id . "',
profileName		= '" . $profileName . "',
sections		= '" . $cvParaSection . "',
status		 	= 1";
                                $qry = mysqli_query($connection, $sql);
                                $cvProfileID = mysqli_insert_id($connection);

                                if ($cvProfileID) {
                                    $cvProfileSection = array_unique($sections);
                                    $cvProfileSection = array_values($cvProfileSection);
                                    $countProfileSection = count($cvProfileSection);

                                    for ($x = 0; $x < $countProfileSection; $x++) {
                                        $sql = "INSERT IGNORE INTO `create-cvprofilesection` SET 	
cvid		= '" . $cvProfileID . "',
id			= '" . $id . "',
section		= '" . $cvProfileSection[$x] . "', 
status		= 1";
                                        $qry = mysqli_query($connection, $sql);
                                    }

                                    $count = count($sections);
                                    for ($x = 0; $x < $count; $x++) {
                                        $sql = "INSERT IGNORE INTO `create-cvsection` SET 	
`id`			= '" . $id . "',
`section`		= '" . $sections[$x] . "', 
`status`		= 1";
                                        $qry = mysqli_query($connection, $sql);
                                    }
                                }
                            }

                                //send app notification
                                sendNotification_firstTime($id, $connection);
                                //send app notification to admin
                                sendNotificationToAdmin('New App2 Registration', $fullName, $id);


								if($emailAddress!=''){
                                //Send Email
                                $sendEmailURL = $emailURL;
                                $fullData = array();
                                $fullData['name'] = $fullName;
                                $fullData['email'] = $emailAddress;

                                $contents = urlExport($fullData);
                                $url = $sendEmailURL . '?id=' . $id . '&authkey=' . $authkey . '&data=registration&contents=' . $contents;
                                $content = file_get_contents($url);
                                $result = json_decode($content, true);
								}
								if($phoneNumber!=''){
								//send WA
								$sendWAURL 				   = $sendWAURL;
								$fullWAData 				  = array();
								$fullWAData['phoneNumber']   = '91'.$phoneNumber;
								$fullWAData['userName']      = $fullName;
								$fullWAData['headerImage']   = 'https://cvdragon.com/data/facebook/resources/whycvDragon.jpg';
								$WATemplate               	  = 'welcomemessage';
								$WAcontent                   = urlExport($fullWAData);
								$entryID					 = 105486032380156;
								$url                         = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
								$content                     = file_get_contents($url);
								$result                      = json_decode($content, true);

								updatenotification($id,'ui_welcomemessage',1,$connection);
								}
                                deliver_response($userArray);
                        }
                    }
                    break;

                case "apiHandler": {

                        // $contents     = urlImport($_GET['api']);
                        $api         = $_GET['api'];

                        $sql = "INSERT INTO `apiHandler` SET
                        id 				= '" . $id . "',
                        api				= '" . $api . "',
                        dateCreated		= '" . $date . "',
                        status		 	= 1";
                        $qry             = mysqli_query($connection, $sql);
                        $apiID            =  mysqli_insert_id($connection);

                        deliver_response(array('apiID' => $apiID, 'dateCreated' => $date));

                       /* sendNotification(
                            'Data Sync Error',
                            'There has been an error while synchronizing your data',
                            'Profile',
                            $id,
                            '',
                            '',
                            $connection
                        ); */

                        //send app notification to admin
                        sendNotificationToAdmin('Data Sync Error', 'Click to view User', $id);
                    }
                    break;

                case "apiHandler": {

                        // $contents     = urlImport($_GET['api']);
                        $api         = $_GET['api'];

                        $sql = "INSERT INTO `apiHandler` SET
                        id 				= '" . $id . "',
                        api				= '" . $api . "',
                        dateCreated		= '" . $date . "',
                        status		 	= 1";
                        $qry             = mysqli_query($connection, $sql);
                        $apiID            =  mysqli_insert_id($connection);

                        deliver_response(array('apiID' => $apiID, 'dateCreated' => $date));

                       /* sendNotification(
                            'Data Sync Error',
                            'There has been an error while synchronizing your data',
                            'Profile',
                            $id,
                            '',
                            '',
                            $connection
                        ); */

                        //send app notification to admin
                        sendNotificationToAdmin('Data Sync Error', 'Click to view User', $id);
                    }
                    break;

                case "apiHandlerStatus": {

                        $apiID             = $_GET['apiID'];

                        $sql     = "SELECT resolve FROM `apiHandler` where apiID ='" . $apiID . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        deliver_response($row);
                    }
                    break;

                case "getInstituteDetails": {

                        $designID             = $_GET['designID'];

                        $sql     = "SELECT * FROM `resource-institutes` where design ='" . $designID . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        deliver_response($row);
                    }
                    break;

                case "getAllInstituteDetails": {

			$AllInstituteDetails = array();
            $searchTerm 	   = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : "";
			$limit 			= isset($_GET['limit']) ? $_GET['limit'] : 20;
			$offset 		   = isset($_GET['offset']) ? $_GET['offset'] : 0;

                        if ($searchTerm != "") {
			$sql = "SELECT instituteID,instituteName,instituteLogo,location,design FROM `resource-institutes` where status=1 and (instituteName LIKE '%$searchTerm%' OR location LIKE '%$searchTerm%') LIMIT $limit OFFSET $offset";
                        } else {
			$sql = "SELECT instituteID,instituteName,instituteLogo,location,design FROM `resource-institutes` where status=1 and active=1 LIMIT $limit OFFSET $offset";
						}
			$result = mysqli_query($connection, $sql);
			if (mysqli_num_rows($result) > 0) {

				while ($row = mysqli_fetch_assoc($result)) {
					array_push($AllInstituteDetails, $row);
				}
				deliver_response($AllInstituteDetails);
			}
                    }
                    break;

                case "getAllDepartments": {

                        $AllDepartments = array();

                        $sql     = "SELECT * FROM `resource-institutes-department` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AllDepartments, $row);
                            }
                            deliver_response($AllDepartments);
                        }
                    }
                    break;
                case "verifyUserNotification": {

                        $notificationID     = $_GET['notificationID'];

                        $sql     = "SELECT status FROM `user-notification` where notificationID ='" . $notificationID . "' AND id = '" . $id . "'  AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        deliver_response($row['status']);
                    }
                    break;
                case "getTablesStructure": {
                        $structure = $queries;
                        deliver_response($structure);
                    }
                    break;

                case "allSectionDetails": {

                        $allSectionData      = array();
                        $text = "";

                        // cvBasic

                        $sql         = "SELECT * FROM `cv-basic-info` where id='" . $id . "' AND status=1";
                        $result     = mysqli_query($connection, $sql);
                        $row         = mysqli_fetch_assoc($result);

                        $allSectionData['51100'] = $row;
                        // $text = $text . $row['title'] . " ";
                        //cvContact

                        // $sql         = "SELECT * FROM `cv-contact` where id='" . $id . "' AND status=1";
                        // $result     = mysqli_query($connection, $sql);
                        // $row         = mysqli_fetch_assoc($result);

                        // $allSectionData['51101'] = $row;

                        //cvImages

                        // $ImageArray = array();
                        // $sql     = "SELECT * FROM `cv-images` where id='" . $id . "' AND status=1 ORDER BY imageid DESC";
                        // $result = mysqli_query($connection, $sql);
                        // if (mysqli_num_rows($result) > 0) {

                        //     while ($row = mysqli_fetch_assoc($result)) {
                        //         array_push($ImageArray, $row);
                        //     }

                        //     $allSectionData['51102'] = $ImageArray;
                        // }


                        //cvIntroduction

                        $sql         = "SELECT introduction,title,introid FROM `cv-introduction` where id='" . $id . "' AND status=1";
                        $result     = mysqli_query($connection, $sql);
                        $row         = mysqli_fetch_assoc($result);

                        $allSectionData['51103'] = $row;
                        $text = $text . $row['introduction'] . " ";
                        $text = $text . $row['title'] . " ";

                        //cvWork

                        // $WorkArray = array();
                        // $sql     = "SELECT wordid,organization,designation,location,workProfile FROM `cv-work` where id='" . $id . "' AND status=1  ORDER BY dateJoined DESC";
                        // $result = mysqli_query($connection, $sql);
                        // if (mysqli_num_rows($result) > 0) {

                        //     while ($row = mysqli_fetch_assoc($result)) {
                        //         array_push($WorkArray, $row);
                        //         $text = $text . $row['organization'] . " ";
                        //         $text = $text . $row['designation'] . " ";
                        //     }

                        //     $allSectionData['51104'] = $WorkArray;
                        // }

                        //cvProject

                        $ProjectArray = array();
                        $sql     = "SELECT projectid,description FROM `cv-project` where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProjectArray, $row);

                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51105'] = $ProjectArray;
                        }

                        //cvAcademicProject

                        $AcademicProjectArray = array();
                        $sql     = "SELECT academicid,description FROM `cv-academic-projects` where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AcademicProjectArray, $row);
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51122'] = $AcademicProjectArray;
                        }
                        //cvPOA

                        $POAArray = array();
                        $sql     = "SELECT poaid,description FROM `cv-POA` where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                // $text = $text . $row['title'] . " ";
                                $text = $text . $row['description'] . " ";
                                array_push($POAArray, $row);
                            }

                            $allSectionData['51099'] = $POAArray;
                        }

                        //cvCoCurricular

                        $CoCurricularArray = array();
                        $sql     = "SELECT activityid,title,description FROM `cv-co-curricular-activities` where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($CoCurricularArray, $row);
                                $text = $text . $row['title'] . " ";
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51123'] = $CoCurricularArray;
                        }

                        //cvPresentations

                        $CoCurricularArray = array();
                        $sql     = "SELECT activityid,title,description FROM `cv-presentations` where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($CoCurricularArray, $row);
                                $text = $text . $row['title'] . " ";
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51125'] = $CoCurricularArray;
                        }

                        //cvInternship

                        $ProjectArray = array();
                        $sql     = "SELECT internshipid,description FROM `cv-internship` where id='" . $id . "' AND status=1 order by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProjectArray, $row);

                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51106'] = $ProjectArray;
                        }

                        //cvTraining

                        $TrainingArray = array();
                        $sql     = "SELECT trainingid,description FROM `cv-trainings` where id='" . $id . "' AND status=1 ORDER by number DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TrainingArray, $row);
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51107'] = $TrainingArray;
                        }

                        //cvProfessional

                        // $ProfessionalArray = array();
                        // $sql     = "SELECT `professionalid`,`course`,`organization`,`university` FROM `cv-professional` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        // $result = mysqli_query($connection, $sql);
                        // if (mysqli_num_rows($result) > 0) {

                        //     while ($row = mysqli_fetch_assoc($result)) {
                        //         array_push($ProfessionalArray, $row);
                        //         $text = $text . $row['course'] . " ";
                        //         $text = $text . $row['organization'] . " ";
                        //         $text = $text . $row['university'] . " ";
                        //     }

                        //     $allSectionData['51108'] = $ProfessionalArray;
                        // }

                        //cvEducation

                        // $EducationArray = array();
                        // $sql     = "SELECT `eduid`,`institute`,`location`,`university`,`specialization` FROM `cv-education` where id='" . $id . "' AND status=1";
                        // $result = mysqli_query($connection, $sql);
                        // if (mysqli_num_rows($result) > 0) {

                        //     while ($row = mysqli_fetch_assoc($result)) {
                        //         array_push($EducationArray, $row);
                        //         $text = $text . $row['institute'] . " ";
                        //         $text = $text . $row['location'] . " ";
                        //         $text = $text . $row['university'] . " ";
                        //         $text = $text . $row['specialization'] . " ";
                        //     }

                        //     $allSectionData['51109'] = $EducationArray;
                        // }

                        //cvCertificate

                        // $CertificateArray = array();
                        // $sql     = "SELECT `certificateid`,`certificate`,`authority` FROM `cv-certification` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        // $result = mysqli_query($connection, $sql);
                        // if (mysqli_num_rows($result) > 0) {

                        //     while ($row = mysqli_fetch_assoc($result)) {
                        //         array_push($CertificateArray, $row);
                        //         $text = $text . $row['certificate'] . " ";
                        //         $text = $text . $row['authority'] . " ";
                        //     }

                        //     $allSectionData['51110'] = $CertificateArray;
                        // }

                        //cvTechnical

                        $TechnicalArray = array();
                        $sql     = "SELECT `technicalid`,`technical`,`type`,`level`,`description` FROM `cv-technical`  where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TechnicalArray, $row);
                                $text = $text . $row['technical'] . " ";
                                $text = $text . $row['type'] . " ";
                                $text = $text . $row['level'] . " ";
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51111'] = $TechnicalArray;
                        }

                        //cvPublication

                        $PublishArray = array();
                        $sql     = "SELECT `publishid`,`title`,`publisher`,`description` FROM `cv-publications` where id='" . $id . "' AND status=1 ORDER BY publishDate DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($PublishArray, $row);
                                $text = $text . $row['title'] . " ";
                                $text = $text . $row['publisher'] . " ";
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51112'] = $PublishArray;
                        }

                        // //cvPatent

                        // $PatentArray = array();
                        // $sql     = "SELECT `patentid`,`title`,`patentOffice`,`patentStatus`,`patentApplication`,`description` FROM `cv-patent`  where id='" . $id . "' AND status=1 ORDER by patentDate DESC";
                        // $result = mysqli_query($connection, $sql);
                        // if (mysqli_num_rows($result) > 0) {

                        //     while ($row = mysqli_fetch_assoc($result)) {
                        //         array_push($PatentArray, $row);
                        //         $text = $text . $row['title'] . " ";
                        //         $text = $text . $row['patentOffice'] . " ";
                        //         $text = $text . $row['patentStatus'] . " ";
                        //         $text = $text . $row['patentApplication'] . " ";
                        //         $text = $text . $row['description'] . " ";
                        //     }

                        //     $allSectionData['51113'] = $PatentArray;
                        // }

                        //cvAchievement

                        $AchievementArray = array();
                        $sql     = "SELECT `achieveid`,`achievement`,`description` FROM `cv-achievements` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AchievementArray, $row);
                                $text = $text . $row['achievement'] . " ";
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51114'] = $AchievementArray;
                        }

                        //cvAwards

                        $AwardArray = array();
                        $sql     = "SELECT `awardid`,`title`,`organization`,`description` FROM `cv-awards` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AwardArray, $row);
                                $text = $text . $row['title'] . " ";
                                $text = $text . $row['organization'] . " ";
                                $text = $text . $row['description'] . " ";
                            }

                            $allSectionData['51115'] = $AwardArray;
                        }

                        //cvAssociation

                        $AssociationArray = array();
                        $sql     = "SELECT `associationid`,`description` FROM `cv-association` where id='" . $id . "' AND status=1 ORDER BY dateJoining DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {

                                $text = $text . $row['description'] . " ";
                                array_push($AssociationArray, $row);
                            }

                            $allSectionData['51116'] = $AssociationArray;
                        }

                        //cvVolunteer

                        $VolunteerArray = array();
                        $sql     = "SELECT `volunteerid`,`description` FROM `cv-volunteer` where id='" . $id . "' AND status=1 ORDER BY dateJoining DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                // $text = $text . $row['organization'] . " ";
                                // $text = $text . $row['cause'] . " ";
                                // $text = $text . $row['role'] . " ";
                                $text = $text . $row['description'] . " ";
                                array_push($VolunteerArray, $row);
                            }

                            $allSectionData['51117'] = $VolunteerArray;
                        }

                        //cvSkills

                        $SkillsArray = array();
                        $sql     = "SELECT `skillid`,`skill`,`description` FROM `cv-skills` where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                $text = $text . $row['skill'] . " ";
                                $text = $text . $row['description'] . " ";
                                array_push($SkillsArray, $row);
                            }

                            $allSectionData['51118'] = $SkillsArray;
                        }

                        //cvInterests

                        $InterestsArray = array();
                        $sql     = "SELECT `interestid`,`interest`,`level` FROM `cv-interests` where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                $text = $text . $row['interest'] . " ";
                                $text = $text . $row['level'] . " ";
                                array_push($InterestsArray, $row);
                            }

                            $allSectionData['51119'] = $InterestsArray;
                        }

                        //cvLanguage

                        $LanguageArray = array();
                        $sql     = "SELECT `langid`,`language` FROM `cv-languages`  where id='" . $id . "' AND status=1 ORDER by created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                $text = $text . $row['language'] . " ";
                                array_push($LanguageArray, $row);
                            }

                            $allSectionData['51120'] = $LanguageArray;
                        }

                        //cvPreference

                        // $sql     = "SELECT * FROM `cv-preference` where id='" . $id . "' AND status=1";
                        // $result = mysqli_query($connection, $sql);
                        // $row = mysqli_fetch_assoc($result);

                        // $allSectionData['51121'] = $row;
                        // $allSectionData['text'] = array($text);


                        //Return All Data
                        deliver_response($allSectionData);
                    }
                    break;


                case "userCompulsoryData": {

                        $userCompulsoryData = array();
                        $cvid = $_GET['cvid'];

                        //subSections
                        if ($cvid > 0) {
                            $ProfileArray = array();
                            $sql     = "SELECT section,subsection FROM `create-cvprofilesection` where id='" . $id . "' AND cvid='" . $cvid . "' AND status=1";
                            $result = mysqli_query($connection, $sql);
                            if (mysqli_num_rows($result) > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $ProfileArray[$row['section']] = json_decode($row['subsection']);
                                }
                                $userCompulsoryData['subSections'] = $ProfileArray;
                            }
                        }



                        //sections

                        $sectionArray = array();
                        $sql     = "SELECT section,sectionTable,idColumnName FROM `resource-section` WHERE main=1 and status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($sectionArray, $row);
                            }

                            $userCompulsoryData['sections'] = $sectionArray;
                        }



                        deliver_response($userCompulsoryData);
                    }
                    break;
                case "getWorkshops": {

                        $sql     = "SELECT * FROM `sessionDetails`WHERE public=1 and status=1 ORDER BY sessionDetails ASC";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        deliver_response($row);
                    }
                    break;

                default: {
                    }
                    echo 'Default Content';
            }
        }
    }
}
