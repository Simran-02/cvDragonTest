<?php
session_start();

include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");
//DEFAULT PARAMS

$GSection       = array(51099,51105,51106,51107,51108,51110,51111,51112,51113,51114,51115,
						51116,51117,51118,51119,51120,51122,51123,51125,51126,51104,51102);

$GSectionTable  = array("cv-POA","cv-project","cv-internship","cv-trainings","cv-professional","cv-certification",
	                    "cv-technical","cv-publications","cv-patent","cv-achievements","cv-awards","cv-association",
	                    "cv-volunteer","cv-skills","cv-interests","cv-languages","cv-academic-projects",
	                    "cv-co-curricular-activities","cv-presentations","cv-add-section","cv-work","cv-images");
$columnTable    = array("poaid","projectid","internshipid","trainingid","professionalid","certificateid","technicalid",
                        "publishid","patentid","achieveid","awardid","associationid","volunteerid","skillid","interestid",
						"langid","academicid","activityid","activityid","addid","workid","imageid");

//Get details from the url
$id 		    = isset($_GET['id']) 			  ? $_GET['id'] : '';
$authkey 	    = isset($_GET['authkey']) 		  ? $_GET['authkey'] : '';
$CVID 			= isset($_GET['CVID']) 			  ? $_GET['CVID'] : '';
$refID 			= isset($_GET['refID']) 		  ? $_GET['refID'] : '';
$sectionID 		= isset($_GET['sectionID']) 	  ? $_GET['sectionID'] : '';


if($id) 
{
	if($authkey) 
	{
		if(usercheck($id,$authkey,$connection)) 
		{

			$key 			 = array_search($sectionID,$GSection);
			$table_name 	 = $GSectionTable[$key];
			$column_name     = $columnTable[$key];


			$sql = "SELECT `$column_name` FROM `$table_name` WHERE refID = ".$refID." AND id = ".$id." AND status = 1";

			$result = mysqli_query($connection,$sql);

			$row = mysqli_fetch_array($result);

			$subsectionID = $row[$column_name];

			$sql 	 = "SELECT subsection FROM `create-cvprofilesection` where 
			cvid  ='".$CVID."' AND 
			section ='".$sectionID."' AND 
			id ='".$id."' AND 
			status=1";

			$result  = mysqli_query($connection, $sql);
			$row 	 = mysqli_fetch_array($result);
			$subsection_array = $row['subsection'];

			if($subsection_array==null)
			{
				$subsection_array = array();
			}
			else
			{
				$subsection_array = json_decode($row['subsection']);			
			}

			array_push($subsection_array, $subsectionID);

			$UpdatedSections = array_values($subsection_array);
			sort($UpdatedSections);
			$UpdatedSectionsNew 	= json_encode($UpdatedSections);

			$sql  = "UPDATE `create-cvprofilesection` SET subsection='".$UpdatedSectionsNew."' where id = '".$id."' and cvid = '".$CVID."' and section = '".$sectionID."' and status = 1";
												
			$qry  = mysqli_query($connection, $sql);
			if($qry) { deliver_response(1); } else { deliver_response(0); } 
		}
	}
}
									
