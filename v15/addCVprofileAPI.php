<?php 

session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");

$sectionID      = array(51099,51105,51106,51107,51108,51110,51111,51112,51113,51114,51115,
					    51116,51117,51118,51119,51120,51122,51123,51125,51126,51104,51102);

$sectionTable   = array("cv-POA","cv-project","cv-internship","cv-trainings","cv-professional",
	                    "cv-certification","cv-technical","cv-publications","cv-patent","cv-achievements",
	                    "cv-awards","cv-association","cv-volunteer","cv-skills","cv-interests","cv-languages",
	                    "cv-academic-projects","cv-co-curricular-activities","cv-presentations",
	                    "cv-add-section","cv-work","cv-images");

$columnTable    = array("poaid","projectid","internshipid","trainingid","professionalid","certificateid","technicalid",
                        "publishid","patentid","achieveid","awardid","associationid","volunteerid","skillid","interestid",
						"langid","academicid","activityid","activityid","addid","workid","imageid");

//Get details from the url

$id 		 = isset($_GET['id']) 			   ? $_GET['id'] : '';
$authkey     = isset($_GET['authkey']) 		   ? $_GET['authkey'] : '';
$contents 	 = urlImport($_GET['contents']);
$sections    = json_encode($contents['sections']);
$subSections = json_encode($contents['subSection']);
$profileName = $contents['profileName'];

if($id) 
{   
	if($authkey) 
	{
		if(usercheck($id,$authkey,$connection))
		{	
			// Inserting new row in create-cvprofile
			$insert_qry = "INSERT IGNORE INTO `create-cvprofile` 
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

			// Fetching CV Id
			mysqli_query($connection,$insert_qry);

			$fetch_CV_query =   "SELECT `cvid` FROM 
								`create-cvprofile` WHERE 
								`id`          = $id AND 
								`profileName` = '$profileName' AND 
								`status`      = 1";
														
			//print($fetch_CV_query);
			
			$result  = mysqli_query($connection,$fetch_CV_query);

			$row     = mysqli_fetch_assoc($result);

			$CVID    = $row['cvid'];
			//print($CVID);				

			// Adding in respective tables

			$subSections = $contents['subSection'];

			foreach ($subSections as $currentSection => $currentSubSection)
			{  

				$key        = array_search($currentSection,$sectionID); 
				$table_name = $sectionTable[$key];
				$column     = $columnTable[$key];
				$response   = array();

				for ($i = 0; $i <count($currentSubSection) ; $i++) 
				{
					$subsection_qry       = "SELECT ".$column." FROM `"
											.$table_name."`WHERE 
											refID  = ".$currentSubSection[$i]." AND 
										  	id = ".$id.";";
					
					//print($subsection_qry."<br>");
					$result_subsection    = mysqli_query($connection,$subsection_qry);
					$row_subsection       = mysqli_fetch_assoc($result_subsection);
					$current_subsectionID = $row_subsection[$column];

					if($current_subsectionID)
					{
					array_push($response, $current_subsectionID);
					}
				}

				$response    = json_encode($response);

				$section_qry = "INSERT IGNORE INTO `create-cvprofilesection`
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
					$currentSection,
					'$response',
					1
				);";
				//print($section_qry);
				mysqli_query($connection,$section_qry);
	 
			}
		}
	}
}
