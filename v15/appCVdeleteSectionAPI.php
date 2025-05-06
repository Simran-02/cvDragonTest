<?php
session_start();

include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");

//Get details from the url
$id 		    = isset($_GET['id']) 			  ? $_GET['id'] : '';
$authkey 	    = isset($_GET['authkey']) 		  ? $_GET['authkey'] : '';
$CVID 			= isset($_GET['CVID']) 			  ? $_GET['CVID'] : '';
//$refID 			= isset($_GET['refID']) 		  ? $_GET['refID'] : '';
$sectionID 		= isset($_GET['sectionID']) 	  ? $_GET['sectionID'] : '';


if($id) 
{
	if($authkey) 
	{
		if(usercheck($id,$authkey,$connection)) 
		{

			$sql = "SELECT `sections` FROM 
			`create-cvprofile` WHERE 
			`id` = $id AND
			`cvid` = $CVID AND
			`status` = 1";

			$result = 	mysqli_query($connection, $sql);

			$row = mysqli_fetch_array($result);

			$section_array = $row['sections'];

			$section_array = json_decode($section_array);

			if(($key = array_search($sectionID, $section_array)) !== false) 
			{	
			    unset($section_array[$key]);
			}

			sort($section_array);

			$section_array = json_encode($section_array);

			$sql = " UPDATE `create-cvprofile` SET `sections` = '$section_array' WHERE `id`= $id AND `cvid`= $CVID AND `status`= 1";

			$result1 = mysqli_query($connection, $sql);

			$sql = " DELETE FROM `create-cvprofilesection` WHERE `section` = $sectionID AND `id`= $id AND `cvid`= $CVID AND status = 1";

			$result2 = mysqli_query($connection,$sql);
			
			if($result1 && $result2)
			{
				deliver_response(1);
			}
			else
			{
				deliver_response(0);
			}
		}
	}
}