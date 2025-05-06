<?php
session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");



$allGSection = array(50000,51099,51105,51106,51107,51108,51110,51111,51112,51113,51114,51115,51116,51117,51118,51119,51120,51122,51123,51125,51126,51104,51102,51100,51101,51121,51103,51109);

$allGSectionTable = array("cv-default","cv-POA","cv-project","cv-internship","cv-trainings","cv-professional","cv-certification","cv-technical","cv-publications","cv-patent","cv-achievements","cv-awards","cv-association","cv-volunteer","cv-skills","cv-interests","cv-languages","cv-academic-projects","cv-co-curricular-activities","cv-presentations","cv-add-section","cv-work","cv-images","cv-basic-info","cv-contact","cv-preference","cv-introduction","cv-education");

//Get details from the url
$id 			= isset($_GET['id']) 			 ? $_GET['id'] : '';
$authkey 	    = isset($_GET['authkey']) 		 ? $_GET['authkey'] : '';
$CVID 			= isset($_GET['CVID']) 			 ? $_GET['CVID'] : '';
$refID 			= isset($_GET['refID']) 		 ? $_GET['refID'] : '';
$sectionID 		= isset($_GET['sectionID']) 	 ? $_GET['sectionID'] : '';

//$contents 		= (array)json_decode($_GET['contents']);
$contents 		= (array)json_decode($_GET['contents']);

if($id) {
	if($authkey) {
		if(usercheck($id,$authkey,$connection)) {
			if(array_search($sectionID,$allGSection)){
					$key = array_search($sectionID,$allGSection);
// Only updatable
						$table_name = $allGSectionTable[$key];

						$column_value_pair	= '';

						$size_of_content = count($contents);

						$check=1;

					foreach($contents as $column => $value){

						if($check===$size_of_content)
						{
							
							$column_value_pair=$column_value_pair.$column. " = "."\"".$value."\"";
						}
						else
						{
							$column_value_pair=$column_value_pair.$column. " = "."\"".$value."\"".", ";
						}

						$check=$check+1;
					}
					
					$sql	= "UPDATE `".$table_name."` SET ".$column_value_pair." WHERE refID = ".$refID." and id = ".$id." and status = 1";

					$qry 	= mysqli_query($connection, $sql);
					
					if($qry) { UpdateSectionStatus($id,$sectionID,$connection); deliver_response(1); } else { deliver_response(0); } 

			}
$checkNotification = checknotification($id,$connection);
if($checkNotification==1) { 

	$notifyStatus = notificationStatusDetails($id,$connection);
	if($notifyStatus['status']==1) 
	{ 

		if($notifyStatus['sectionCount'].$notifyStatus['ui_cvcreation']==20) 
		{

	//send WA
	$sendWAURL = $sendWAURL;
	$fullWAData = array();
	$fullWAData['phoneNumber']        = IDtoUserMobileWA($id, $connection);
	$fullWAData['userName']           = IDtoName($id, $connection);
	$WATemplate               		   = 'cvcreation';
	$WAcontent                        = urlExport($fullWAData);
	$entryID						  = 105486032380156;
	$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                          = file_get_contents($url);
	$result                           = json_decode($content, true);
		

	//send WA
	$sendWAURL = $sendWAURL;
	$fullWAData = array();
	$fullWAData['phoneNumber']        = IDtoUserMobileWA($id, $connection);
	$fullWAData['userName']           = IDtoName($id, $connection);
	$fullWAData['mediaLink']      	  = '1021294262481988';
	$WATemplate               		   = 'diwali_offer';
	$WAcontent                        = urlExport($fullWAData);
	$entryID						  = 105486032380156;
	$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                          = file_get_contents($url);
	$result                           = json_decode($content, true);


	updatenotification($id,'ui_cvcreation','1',$connection);

		}
		if($notifyStatus['sectionCount'].$notifyStatus['ui_digitalprofile']==100) 
		{

	//send WA
	$sendWAURL = $sendWAURL;
	$fullWAData = array();
	$fullWAData['phoneNumber']        = IDtoUserMobileWA($id, $connection);
	$fullWAData['userName']           = IDtoName($id, $connection);
	$WATemplate               		   = 'viewdigitalprofile';
	$WAcontent                        = urlExport($fullWAData);
	$entryID						  = 105486032380156;
	$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                          = file_get_contents($url);
	$result                           = json_decode($content, true);
	
	updatenotification($id,'ui_digitalprofile','1',$connection);

		}
		if($notifyStatus['sectionCount'].$notifyStatus['ui_offerfirst']==70) 
		{

	//send WA
	$sendWAURL = $sendWAURL;
	$fullWAData = array();
	$fullWAData['phoneNumber']        = IDtoUserMobileWA($id, $connection);
	$fullWAData['userName']           = IDtoName($id, $connection);
	$WATemplate               		   = 'offerfirst';
	$WAcontent                        = urlExport($fullWAData);
	$entryID						  = 105486032380156;
	$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                          = file_get_contents($url);
	$result                           = json_decode($content, true);
	
	updatenotification($id,'ui_offerfirst','1',$connection);
		}
		}

}
		}
	}
}
?>