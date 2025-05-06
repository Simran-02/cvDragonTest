<?php
session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");



$section        = array(1,51099,51105,51106,51107,51108,51110,51111,51112,51113,51114,51115,
					    51116,51117,51118,51119,51120,51122,51123,51125,51126,51104,51102);

$sectionTable   = array("default","cv-POA","cv-project","cv-internship","cv-trainings","cv-professional",
	                    "cv-certification","cv-technical","cv-publications","cv-patent","cv-achievements",
	                    "cv-awards","cv-association","cv-volunteer","cv-skills","cv-interests","cv-languages",
	                    "cv-academic-projects","cv-co-curricular-activities","cv-presentations",
	                    "cv-add-section","cv-work","cv-images");

$columnTable    = array("defaultid","poaid","projectid","internshipid","trainingid","professionalid","certificateid","technicalid",
                        "publishid","patentid","achieveid","awardid","associationid","volunteerid","skillid","interestid",
						"langid","academicid","activityid","activityid","addid","workid","imageid");

//Get details from the url

$id 				= isset($_GET['id']) 			   ? $_GET['id'] : '';
$authkey 		    = isset($_GET['authkey']) 		   ? $_GET['authkey'] : '';
$CVID 			    = isset($_GET['CVID']) 			   ? $_GET['CVID'] : '';
$refID 			    = isset($_GET['refID']) 		   ? $_GET['refID'] : '';
$sectionID 		    = isset($_GET['sectionID']) 	   ? $_GET['sectionID'] : '';


if($id) 
{   
	if($authkey) 
	{
		if(usercheck($id,$authkey,$connection)) 
		{
	
			if(array_search($sectionID, $section))
			{
				
				$key 			 = array_search($sectionID,$section);
				$table_name 	 = $sectionTable[$key];
				$column          = $columnTable[$key];				
				$qry 	         = "SELECT ".$column." FROM `".$table_name."` WHERE refID = ".$refID." AND id = ".$id." AND status=1";
				$result          = mysqli_query($connection, $qry);
				$row 	         = mysqli_fetch_assoc($result);
				$subsectionID    = $row[$column];

				
				$sql 	 = "SELECT subsection FROM `create-cvprofilesection` where 
							cvid  ='".$CVID."' AND 
							section ='".$sectionID."' AND 
							id ='".$id."' AND 
							status=1";
							
				$result  = mysqli_query($connection, $sql);
				$rowcount=mysqli_num_rows($result);
				if($rowcount!=0)
				{


					$row 	 = mysqli_fetch_assoc($result);

					$subsection_array = $row['subsection'];
					$subsection_array = json_decode($row['subsection']);

				//print_r($subsection_array);
				

					if(($key = array_search($subsectionID, $subsection_array)) !== false) 
					{	
					    unset($subsection_array[$key]);
					}
					$UpdatedSections 	= array_values($subsection_array);
					sort($UpdatedSections);
					$UpdatedSectionsNew 	= json_encode($UpdatedSections);

								$sql  = "UPDATE `create-cvprofilesection` SET subsection='".$UpdatedSectionsNew."' where id = '".$id."' and cvid = '".$CVID."' and section = '".$sectionID."' and status = 1";
												
								$qry 		= mysqli_query($connection, $sql);
								if($qry) { deliver_response(1); } else { deliver_response(0); } 
									
								//print_r($update_sql);
				}
				else
				{
					deliver_response(0);
				}
			}
		}
	}
}

?>