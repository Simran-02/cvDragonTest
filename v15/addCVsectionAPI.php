<?php
session_start();

include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");


$id 		    = isset($_GET['id']) 			  ? $_GET['id'] : '';
$authkey 	    = isset($_GET['authkey']) 		  ? $_GET['authkey'] : '';
$CVID 			= isset($_GET['CVID']) 			  ? $_GET['CVID'] : '';
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
			
			array_push($section_array, $sectionID);
			$section_array = array_unique($section_array);
			$section_array = array_values($section_array);
			sort($section_array);
			
			if(!empty($section_array)) { 
			
$section_array = json_encode($section_array);

$sql = " UPDATE `create-cvprofile` SET `sections` = '$section_array' WHERE `id`= $id AND `cvid`= $CVID AND `status`= 1";
$result1 = mysqli_query($connection, $sql);

if($result1) { 

$sql = "INSERT INTO  `create-cvprofilesection` (`id`, `cvid`,`section`,`subsection`,`status`)VALUES ($id, $CVID, $sectionID,'',1)";
$result2 = mysqli_query($connection, $sql);

if($result1) { 

$sql = "INSERT IGNORE INTO  `create-cvsection` (`section`,`id`,`status`) VALUES ($sectionID, $id, 1)";
$result3 = mysqli_query($connection, $sql);

}
}
		if($result1 && $result2 && $result3)
			{
				deliver_response(1);
			}
			else
			{
				deliver_response(1);
			}
			
			} else {
				
				deliver_response(1);
			}
		}
	}
}

?>