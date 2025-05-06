<?php 

session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");
header("Content-Type:application/json");

$sectionID      = array(51099,51105,51106,51107,51108,51110,51111,51112,51113,51114,51115,
					    51116,51117,51118,51119,51120,51122,51123,51125,51126,51104,51102,51100,51101,51121,51103,51109);

$sectionTable   = array("cv-POA","cv-project","cv-internship","cv-trainings",
							"cv-professional",
	                    "cv-certification","cv-technical","cv-publications","cv-patent","cv-achievements",
	                    "cv-awards","cv-association","cv-volunteer","cv-skills","cv-interests","cv-languages",
	                    "cv-academic-projects","cv-co-curricular-activities","cv-presentations",
	                    "cv-add-section","cv-work","cv-images","cv-basic-info","cv-contact","cv-preference","cv-introduction","cv-education");

$columnTable    = array("poaid","projectid","internshipid","trainingid", 
	                    "professionalid","certificateid","technicalid",
                        "publishid","patentid","achieveid","awardid",
                        "associationid","volunteerid","skillid","interestid",
						"langid","academicid","activityid","activityid","addid",
						"workid","imageid",`id`,`id`,`prefid`,`introid`,`eduid`);


$id 		 = isset($_GET['id']) 			   ? $_GET['id'] : '';
$authkey     = isset($_GET['authkey']) 		   ? $_GET['authkey'] : '';
$contents 	 = urlImport($_GET['contents']);

$sections_array    = array_keys($contents);

sort($sections_array);

$sections = json_encode($sections_array);

$profileName = isset($_GET['profileName']) 			   ? $_GET['profileName'] : '';

$profileName = json_decode($profileName);

if($id) 
{   
	if($authkey) 
	{
		if(usercheck($id,$authkey,$connection))
		{	
						// Inserting new row in create-cvprofile
			$sql = "INSERT INTO `create-cvprofile` 
			(
				`id`, 
				`profileName`, 
				`sections`, 
				`status`
			)
			VALUES 
			(
				$id,
				'".$profileName."',
				'".$sections."',
				1
			)";

			$result1 = mysqli_query($connection,$sql);
			$CVID = mysqli_insert_id($connection);

			deliver_response($CVID);

			foreach ($contents as $key => $value)
			{
				$section_id = $key;
				$subsections = $value;

				if(array_search($section_id,$sectionID))
				{
					$pos = array_search($section_id,$sectionID);
				}

				$sectionName = $sectionTable[$pos];
				$sectionColumn = $columnTable[$pos];

				$subsection_array = array();

				for ($j = 0; $j <count($subsections) ; $j++) 
				{
					
					$sql = "SELECT ".$sectionColumn." FROM `".$sectionName."`WHERE refID  = ".$subsections[$j]." AND id = ".$id.";";
					$result = mysqli_query($connection,$sql);
					$row = mysqli_fetch_array($result);
					array_push($subsection_array,$row[$sectionColumn]);

				}

				if(count($subsections)==0)
				{
					$response = "";
				}
				else
				{
					sort($subsection_array);
					$response = json_encode($subsection_array);					
				}
				
				$qry = "INSERT INTO `create-cvprofilesection`
				(
					`cvid`, 
					`id`, 
					`section`, 
					`subsection`,
					`status`
				)
				VALUES 
				(
					$CVID,
					$id,
					$section_id,
					'$response',
					1
				);";

				$result2 = mysqli_query($connection,$qry);
	
			}
		}
	}
}