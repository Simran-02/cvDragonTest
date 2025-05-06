<?php
session_start();

include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");
//DEFAULT PARAMS

$GSection       = array(
	51099, 51105, 51106, 51107, 51108, 51110, 51111, 51112, 51113, 51114, 51115,
	51116, 51117, 51118, 51119, 51120, 51122, 51123, 51125, 51126, 51104, 51102
);

$GSectionTable  = array(
	"cv-POA", "cv-project", "cv-internship", "cv-trainings", "cv-professional", "cv-certification",
	"cv-technical", "cv-publications", "cv-patent", "cv-achievements", "cv-awards", "cv-association",
	"cv-volunteer", "cv-skills", "cv-interests", "cv-languages", "cv-academic-projects",
	"cv-co-curricular-activities", "cv-presentations", "cv-add-section", "cv-work", "cv-images"
);

$DSection       = array(51100, 51101, 51121);
$DSectionTable  = array("cv-basic-info", "cv-contact", "cv-preference");

$DMSection      = array(51103, 51109);
$DMSectionTable = array("cv-introduction", "cv-education");

//Get details from the url
$id 		    = isset($_GET['id']) 			  ? $_GET['id'] : '';
$authkey 	    = isset($_GET['authkey']) 		  ? $_GET['authkey'] : '';
$CVID 			= isset($_GET['CVID']) 			  ? $_GET['CVID'] : '';
$refID 			= isset($_GET['refID']) 		  ? $_GET['refID'] : '';
$sectionID 		= isset($_GET['sectionID']) 	  ? $_GET['sectionID'] : '';

$contents 		= (array)json_decode($_GET['contents']);
//print_r($contents);
//Section selection
if (in_array($sectionID, $GSection)) {
	$flag = 'G';     //General section can create, edit, delete
}
if (in_array($sectionID, $DSection)) {
	$flag = 'D';     //Default section can only be edited
}
if (in_array($sectionID, $DMSection)) {
	$flag = 'DM';    //Default sections can be created only once and then only be updated

}

//echo $flag;
//Checking user credentials

if ($id) {
	if ($authkey) {
		if (usercheck($id, $authkey, $connection)) {

			// switch to respective case:

			switch ($flag) {

				case 'G':

					// Step 1 :- Add data in respective section table

					$key 			= array_search($sectionID, $GSection);
					$table_name 	 = $GSectionTable[$key];

					$values		     = '';
					$columns		 	= '';

					$size_of_content = count($contents);

					$check		     = 1;

					foreach ($contents as $column => $value) {

						if ($check  ===	$size_of_content) {
							$columns	=	$columns . $column;
							$values = $values . "\"" . $value . "\"";
						} else {
							$columns = $columns . $column . ",";
							$values = $values . "\"" . $value . "\"" . ", ";
						}

						$check	=	$check + 1;
					}

					$sql 			 = "INSERT INTO `" . $table_name . "` (" . $columns . ")" . " VALUES " . "(" . $values . ")";
					//print_r($sql);
					$qry			 = 	mysqli_query($connection, $sql);
					$subSectionID 	=	mysqli_insert_id($connection);

					deliver_response(1);

					// step 2 :- add subsectionId created, in subsection array of that profile 


					$sql 	= "SELECT subsection FROM `create-cvprofilesection` where cvid  ='" . $CVID . "' AND section ='" . $sectionID . "' AND id ='" . $id . "' AND status=1";
					$result = mysqli_query($connection, $sql);
					$row 	= mysqli_fetch_assoc($result);

					$rowsubSectionChk 	= $row['subsection'];
					$subSectionChk 		= json_decode($rowsubSectionChk);
					if (is_array($subSectionChk)) {
						$subSection = $subSectionChk;
					} else {
						$subSection = array();
					}
					array_push($subSection, $subSectionID);

					$subSection 		= array_unique($subSection);
					$subSection 		= array_values($subSection);
					sort($subSection);
					$uploadSubSection 	= json_encode($subSection);

					$sql = "UPDATE `create-cvprofilesection` SET
					subsection		= '" . $uploadSubSection . "'
					WHERE 
					id 				= '" . $id . "' AND 
					section			= '" . $sectionID . "' AND 
					cvid			= '" . $CVID . "' AND
					status 			= 1";
					$qry 			= mysqli_query($connection, $sql);

					// step 3 :- increase count and set status to 1

					if ($qry) {
						UpdateSectionStatus($id, $sectionID, $connection);
						AddSectionContent($id, $sectionID, $connection);
					}

					break;

				case 'D':

					$key 			  = array_search($sectionID, $DSection);
					$table_name 	   = $DSectionTable[$key];

					$column_value_pair = '';
					$size_of_content   = count($contents);
					$check			   = 1;


					foreach ($contents as $column => $value) {
						if ($check === $size_of_content) {
							$column_value_pair = $column_value_pair . $column . " = " . "\"" . $value . "\"";
						} else {
							$column_value_pair = $column_value_pair . $column . " = " . "\"" . $value . "\"" . ", ";
						}

						$check = $check + 1;
					}


					$sql			 = 	"UPDATE `" . $table_name . "` SET " . $column_value_pair . " WHERE refID = " . $refID . " AND id = " . $id . " AND status = 1";
					//echo $sql;
					$qry 			 = 	mysqli_query($connection, $sql);

					if ($qry) {
						UpdateSectionStatus($id, $sectionID, $connection);
						deliver_response(1);
					} else {
						deliver_response(0);
					}


					break;

				case 'DM':

					$key 		= array_search($sectionID, $DMSection);
					$table_name = $DMSectionTable[$key];

					$values		 = $id . ',' . $refID . ',1,';
					$columns		= 'id,refID,status,';

					$size_of_content = count($contents);

					$check = 1;

					foreach ($contents as $column => $value) {
						if ($check === $size_of_content) {
							$columns = $columns . $column;
							$values = $values . "\"" . $value . "\"";
						} else {
							$columns	= $columns . $column . ",";
							$values	 = $values . "\"" . $value . "\"" . ",";
						}

						$check = $check + 1;
					}

					$sql			 =  "INSERT IGNORE INTO `" . $table_name . "` (" . $columns . ")" . " VALUES " . "(" . $values . ")";
					$qry			 = 	mysqli_query($connection, $sql);
					$subSectionID 	=	mysqli_insert_id($connection);

					deliver_response(1);

					// No need to increase count because will have always one row just need to update status from 0 to 1 for the first insert.
					if ($qry) {
						UpdateSectionStatus($id, $sectionID, $connection);
					}
					break;
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
