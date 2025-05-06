<?php
session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");
include("globals.php");

header("Content-Type:application/json");

//Get details from the url
$id         = isset($_GET['id'])         ? $_GET['id'] : '';
$authkey     = isset($_GET['authkey'])     ? $_GET['authkey'] : '';
$data         = isset($_GET['data'])         ? $_GET['data'] : '';
$publickey    = 'cvDragonPublicKey54321';
$blankArray    =    array();
$date          = date("Y-m-d H:i:s");
if ($id) {
    if ($authkey) {
        if (usercheck($id, $authkey, $connection) || $authkey == $publickey) {

            switch ($data) {
                case "myResume": {

                        $array       = array();
                        $resume     = $_GET['resume'];

                        $sql     = "SELECT * FROM `cv-resumedownload` where resume ='" . $resume . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        array_push($array, $row);
                        deliver_response($array);
                    }
                    break;
                case "MyResumeList": {

                        $myResumeArray = array();
                        $sql     = "SELECT * FROM `cv-resumedownload` where id='" . $id . "' AND status=1 ORDER BY created DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($myResumeArray, $row);
                            }
                            deliver_response($myResumeArray);
                        }
                    }
                    break;
                case "myCover": {
                        $array       = array();
                        $cover     = $_GET['cover'];

                        $sql     = "SELECT * FROM `create-clprofile` where clid ='" . $cover . "' AND id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        array_push($array, $row);
                        deliver_response($array);
                    }
                    break;
                case "mySubscription": {

                        $SubscriptionArray = array();
                        $sql     = "SELECT * FROM `user-subscription` where id ='" . $id . "' AND status=1 ORDER BY expiry ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($SubscriptionArray, $row);
                            }
                            deliver_response($SubscriptionArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;
                case "myAssociateSubscription": {

                        $AssociateSubscriptionArray = array();
                        $sql     = "SELECT * FROM `associate-subscription` where id ='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AssociateSubscriptionArray, $row);
                            }
                            deliver_response($AssociateSubscriptionArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;
                case "myAllSubscriptions": {
                        $subscription                       = array();
                        $AssociateSubscriptionArray         = array();
                        $SubscriptionArray                  = array();

                        $sql     = "SELECT * FROM `associate-subscription` where id ='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);

                        $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        if ($json == null) {
                            $json = array();
                            // $json[0] = array();
                            // $json[0]['design'] = "99999";
                            // $json[0]['expiry'] = "2020-12-31";

                        }

                        array_push($subscription, array('AssociateSubscription' => $json));

                        $sql     = "SELECT * FROM `user-subscription` where id ='" . $id . "' AND status=1 ORDER BY expiry ASC";
                        $resultS = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($resultS)) {
                            array_push($SubscriptionArray, $row);
                        }
                        array_push($subscription, array('Subscription' => $SubscriptionArray));


                        deliver_response($subscription);
                    }
                    break;
                case "myProofReadAll": {

                        $proofread                      = array();
                        $proofReadAssociateArray         = array();
                        $proofReadArray                  = array();

                        $sql     = "SELECT * FROM `user-proofRead` where id='" . $id . "' AND status=1  ORDER BY dateRequest DESC";
                        $result = mysqli_query($connection, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            array_push($proofReadArray, $row);
                        }
                        array_push($proofread, array('ProofRead' => $proofReadArray));


                        $proofReadAssociateArray = array();
                        $sql     = "SELECT * FROM `associate-proofRead` where id='" . $id . "' AND status=1  ORDER BY dateRequest DESC";
                        $result = mysqli_query($connection, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            array_push($proofReadAssociateArray, $row);
                        }
                        array_push($proofread, array('AssociateProofRead' => $proofReadAssociateArray));

                        deliver_response($proofread);
                    }
                    break;
                case "myOrders": {

                        $OrderArray = array();
                        $sql     = "SELECT * FROM `orders` where id='" . $id . "' AND status=1  ORDER BY sn DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($OrderArray, $row);
                            }
                            deliver_response($OrderArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "myProofRead": {

                        $proofReadArray = array();
                        $sql     = "SELECT * FROM `user-proofRead` where id='" . $id . "' AND status=1  ORDER BY dateRequest DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($proofReadArray, $row);
                            }
                            deliver_response($proofReadArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "myAssociateProofRead": {

                        $proofReadAssociateArray = array();
                        $sql     = "SELECT * FROM `associate-proofRead` where id='" . $id . "' AND status=1  ORDER BY dateRequest DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($proofReadAssociateArray, $row);
                            }
                            deliver_response($proofReadAssociateArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "myProofReadOrderDetails": {

                        $proofReadArray = array();
                        $sql     = "SELECT * FROM `user-proofRead` where id='" . $id . "' AND orderid='" . $_GET['orderid'] . "'  AND status=1  ORDER BY dateRequest DESC";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        array_push($proofReadArray, $row);
                        deliver_response($proofReadArray);
                    }
                    break;

                case "basic": {
                        $array       = array();
						$appVersionApp = $_GET['appVersion'];
                        //$sql 	= "SELECT * FROM `user-basic` where id ='".$id."' AND status=1";
                        $sql     = "SELECT `users`.referenceID, `users`.openCount, `users`.webLoginFlag, `users`.webLogin, `users`.appLogin, `users`.username, `users`.categoryid, `users`.socialType, `user-basic`.* FROM `users` INNER JOIN  `user-basic` ON `user-basic`.id = `users`.id WHERE `users`.id ='" . $id . "' AND `users`.status=1";

                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        array_push($array, $row);
						
						$openCount = $row['openCount']+1;
                        $sql = "UPDATE `users` SET 	
                            webLoginFlag	= 0, 
                            appVersion		= '" . $appVersionApp . "', 
                            appLogin		= '" . $date . "', 
                            openCount		= '" . $openCount . "' 
                            WHERE 
                            id 				= '" . $id . "' AND 
                            status			= 1
                            ";
                        $qry         = mysqli_query($connection, $sql);
                        if ($qry) {
                            $array[0]['appVersion'] = $appVersion;
                            $array[0]['appForceUpdate'] = $forceUpdate;
                            if (is_numeric($array[0]['wizardEducationProfile']) == 1) {
                                $sql = "SELECT subCategoryName FROM `resource-master-sub-category` WHERE subCategoryID = " . $array[0]['wizardEducationProfile'];
                                $result = mysqli_query($connection, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $array2 = array();
                                array_push($array2, $row);
                                $array[0]['wizardEducationProfileName'] = $array2[0]['subCategoryName'];
                            } else {
                                $array[0]['wizardEducationProfileName'] = $array[0]['wizardEducationProfile'];
                            }

                            if (is_numeric($array[0]['wizardWorkProfile']) == 1) {
                                $sql = "SELECT subCategoryName FROM `resource-master-sub-category` WHERE subCategoryID = " . $array[0]['wizardWorkProfile'];
                                $result = mysqli_query($connection, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $array2 = array();
                                array_push($array2, $row);
                                $array[0]['wizardWorkProfileName'] = $array2[0]['subCategoryName'];
                            } else {
                                $array[0]['wizardWorkProfileName'] = $array[0]['wizardWorkProfile'];
                            }

                            if (is_numeric($array[0]['wizardEducationSpecialization']) == 1) {
                                $sql = "SELECT masterName FROM `resource-master` WHERE masterID = " . $array[0]['wizardEducationSpecialization'];
                                $result = mysqli_query($connection, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $array2 = array();
                                array_push($array2, $row);
                                $array[0]['wizarEducationalSpecializationName'] = $array2[0]['masterName'];
                            } else {
                                $array[0]['wizarEducationalSpecializationName'] = $array[0]['wizardEducationSpecialization'];
                            }

                            if (is_numeric($array[0]['wizardWorkSpecialization']) == 1) {
                                $sql = "SELECT masterName FROM `resource-master` WHERE masterID = " . $array[0]['wizardWorkSpecialization'];
                                $result = mysqli_query($connection, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $array2 = array();
                                array_push($array2, $row);
                                $array[0]['wizardWorkSpecializationName'] = $array2[0]['masterName'];
                            } else {
                                $array[0]['wizardWorkSpecializationName'] = $array[0]['wizardWorkSpecialization'];
                            }


                            deliver_response($array);
                        }
                    }
                    break;

                case "account": {
                        $array       = array();
                        $sql     = "SELECT id, authkey, categoryid, socialid, socialType,username, status FROM `users` WHERE id ='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);

                        array_push($array, $row);
                        deliver_response($array);
                    }
                    break;
                case "myALLsections": {

                        $sectionArray = array();
                        $sql     = "SELECT * FROM `create-cvsection` WHERE id ='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($sectionArray, $row);
                            }
                            deliver_response($sectionArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "mySubSections": {

                        $ProfileArray = array();
                        $sql     = "SELECT * FROM `create-cvprofilesection` where id='" . $id . "' AND cvid='" . $_GET['CVID'] . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProfileArray, $row);
                            }
                            deliver_response($ProfileArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;
                case "allSubSections": {

                        $ProfileArray = array();
                        $sql     = "SELECT * FROM `create-cvprofilesection` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProfileArray, $row);
                            }
                            deliver_response($ProfileArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvProfile": {

                        $ProfileArray = array();
                        $sql     = "SELECT * FROM `create-cvprofile` where id='" . $id . "' AND status=1 ORDER BY dateUpdated";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProfileArray, $row);
                            }
                            deliver_response($ProfileArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvCover": {

                        $CoverArray = array();
                        $sql     = "SELECT * FROM `create-clprofile` where id='" . $id . "' AND status=1 ORDER BY dateCreated";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($CoverArray, $row);
                            }
                            deliver_response($CoverArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvBasic": {

                        $array       = array();
                        $sql         = "SELECT * FROM `cv-basic-info` where id='" . $id . "' AND status=1";
                        $result      = mysqli_query($connection, $sql);
                        $row         = mysqli_fetch_assoc($result);

                        array_push($array, $row);
                        deliver_response($array);
                    }
                    break;

                case "cvContact": {

                        $array       = array();
                        $sql         = "SELECT * FROM `cv-contact` where id='" . $id . "' AND status=1";
                        $result      = mysqli_query($connection, $sql);
                        $row         = mysqli_fetch_assoc($result);

                        array_push($array, $row);
                        deliver_response($array);
                    }
                    break;

                case "cvImages": {

                        $ImageArray = array();
                        $sql     = "SELECT * FROM `cv-images` where id='" . $id . "' AND status=1 ORDER BY imageid DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ImageArray, $row);
                            }
                            deliver_response($ImageArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "deleteImage": {
                        $imageID = $_GET['imageID'];

                        $sql     = "UPDATE `cv-images` set status=0 where id='" . $id . "' and refID = '" . $imageID . "'";
                        $result = mysqli_query($connection, $sql);

                        if ($result) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;

                case "deleteSignature": {

                        $sql     = "UPDATE `cv-preference` set signature='' where id='" . $id . "' and status=1";
                        $result = mysqli_query($connection, $sql);

                        if ($result) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;

                case "cvIntroduction": {

                        $array       = array();
                        $sql         = "SELECT * FROM `cv-introduction` where id='" . $id . "' AND status=1";
                        $result      = mysqli_query($connection, $sql);
                        $row         = mysqli_fetch_assoc($result);

                        if ($row['id']) {
                            array_push($array, $row);
                            deliver_response($array);
                        } else {
                            deliver_response($array);
                        }
                    }
                    break;

                case "cvWork": {

                        $WorkArray = array();
                        $sql     = "SELECT * FROM `cv-work` where id='" . $id . "' AND status=1  ORDER BY dateJoined DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($WorkArray, $row);
                            }
                            deliver_response($WorkArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvProject": {

                        $ProjectArray = array();
                        $sql     = "SELECT * FROM `cv-project` where id='" . $id . "' AND status=1 ORDER by projectid ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProjectArray, $row);
                            }
                            deliver_response($ProjectArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvAcademicProject": {

                        $AcademicProjectArray = array();
                        $sql     = "SELECT * FROM `cv-academic-projects` where id='" . $id . "' AND status=1 ORDER BY created ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AcademicProjectArray, $row);
                            }
                            deliver_response($AcademicProjectArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvPOA": {

                        $POAArray = array();
                        $sql     = "SELECT * FROM `cv-POA` where id='" . $id . "' AND status=1 ORDER BY created ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($POAArray, $row);
                            }
                            deliver_response($POAArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvAddSection": {

                        $AddSectionArray = array();
                        $sql     = "SELECT * FROM `cv-add-section` where id='" . $id . "' AND status=1 ORDER BY created ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AddSectionArray, $row);
                            }
                            deliver_response($AddSectionArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvCoCurricular": {

                        $CoCurricularArray = array();
                        $sql     = "SELECT * FROM `cv-co-curricular-activities` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($CoCurricularArray, $row);
                            }
                            deliver_response($CoCurricularArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvPresentations": {

                        $CoCurricularArray = array();
                        $sql     = "SELECT * FROM `cv-presentations` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($CoCurricularArray, $row);
                            }
                            deliver_response($CoCurricularArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvInternship": {

                        $ProjectArray = array();
                        $sql     = "SELECT * FROM `cv-internship` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProjectArray, $row);
                            }
                            deliver_response($ProjectArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvTraining": {

                        $TrainingArray = array();
                        $sql     = "SELECT * FROM `cv-trainings` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TrainingArray, $row);
                            }
                            deliver_response($TrainingArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvProfessional": {

                        $ProfessionalArray = array();
                        $sql     = "SELECT * FROM `cv-professional` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProfessionalArray, $row);
                            }
                            deliver_response($ProfessionalArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvEducation": {

                        $EducationArray = array();
                        $sql     = "SELECT * FROM `cv-education` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($EducationArray, $row);
                            }
                            deliver_response($EducationArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvCertificate": {

                        $CertificateArray = array();
                        $sql     = "SELECT * FROM `cv-certification` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($CertificateArray, $row);
                            }
                            deliver_response($CertificateArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvTechnical": {

                        $TechnicalArray = array();
                        $sql     = "SELECT * FROM `cv-technical` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TechnicalArray, $row);
                            }
                            deliver_response($TechnicalArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvPublication": {

                        $PublishArray = array();
                        $sql     = "SELECT * FROM `cv-publications` where id='" . $id . "' AND status=1 ORDER BY publishDate DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($PublishArray, $row);
                            }
                            deliver_response($PublishArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvPatent": {

                        $PatentArray = array();
                        $sql     = "SELECT * FROM `cv-patent` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($PatentArray, $row);
                            }
                            deliver_response($PatentArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvAchievement": {

                        $AchievementArray = array();
                        $sql     = "SELECT * FROM `cv-achievements` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AchievementArray, $row);
                            }
                            deliver_response($AchievementArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvAwards": {

                        $AwardArray = array();
                        $sql     = "SELECT * FROM `cv-awards` where id='" . $id . "' AND status=1 ORDER BY year DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AwardArray, $row);
                            }
                            deliver_response($AwardArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvAssociation": {

                        $AssociationArray = array();
                        $sql     = "SELECT * FROM `cv-association` where id='" . $id . "' AND status=1 ORDER BY dateJoining DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AssociationArray, $row);
                            }
                            deliver_response($AssociationArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvVolunteer": {

                        $VolunteerArray = array();
                        $sql     = "SELECT * FROM `cv-volunteer` where id='" . $id . "' AND status=1 ORDER BY dateJoining DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($VolunteerArray, $row);
                            }
                            deliver_response($VolunteerArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvSkills": {

                        $SkillsArray = array();
                        $sql     = "SELECT * FROM `cv-skills` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($SkillsArray, $row);
                            }
                            deliver_response($SkillsArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvInterests": {

                        $InterestsArray = array();
                        $sql     = "SELECT * FROM `cv-interests` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($InterestsArray, $row);
                            }
                            deliver_response($InterestsArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvLanguage": {

                        $LanguageArray = array();
                        $sql     = "SELECT * FROM `cv-languages` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($LanguageArray, $row);
                            }
                            deliver_response($LanguageArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "cvPreference": {
                        $array       = array();
                        $sql     = "SELECT * FROM `cv-preference` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        $row = mysqli_fetch_assoc($result);

                        array_push($array, $row);
                        deliver_response($array);
                    }
                    break;
                case "fetchAllSections": {
                        $allSectionTable = array("cv-POA", "cv-project", "cv-internship", "cv-trainings", "cv-professional", "cv-certification", "cv-technical", "cv-publications", "cv-patent", "cv-achievements", "cv-awards", "cv-association", "cv-volunteer", "cv-skills", "cv-interests", "cv-languages", "cv-academic-projects", "cv-co-curricular-activities", "cv-presentations", "cv-add-section", "cv-work", "cv-images", "cv-basic-info", "cv-contact", "cv-introduction", "cv-education", "cv-preference");

                        $parent_array = array();

                        for ($i = 0; $i < count($allSectionTable); $i++) {
                            $table_name = $allSectionTable[$i];
                            $tableArray = array();
                            $qry = "SELECT * FROM `" . $table_name . "` WHERE id = " . $id . " AND status = 1";
                            $result = mysqli_query($connection, $qry);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    array_push($tableArray, $row);
                                }
                                $parent_array[$table_name] = $tableArray;
                            }
                        }
                        deliver_response($parent_array);
                    }
                    break;
                case "deleteProfile":
                    $cvid        = $_GET['profileID']; {
                        $sql = "UPDATE `create-cvprofile` SET
                        status			= 0
                        WHERE 
                        id 				= '" . $id . "' AND 
                        cvid			= '" . $cvid . "' AND
                        status			= 1
                        ";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {

                            $sql = "UPDATE `create-cvprofilesection` SET 	
                        status			= 0
                        WHERE 
                        id 				= '" . $id . "' AND 
                        cvid			= '" . $cvid . "' AND 
                        status			= 1
                        ";
                            $qry         = mysqli_query($connection, $sql);
                            if ($qry) {

                                $sql     = "SELECT status FROM `create-cvprofile` where cvid ='" . $cvid . "' AND id = '" . $id . "'";
                                $result = mysqli_query($connection, $sql);
                                $row     = mysqli_fetch_assoc($result);

                                if ($row['status'] == 0) {
                                    deliver_response(1);
                                } else {
                                    deliver_response(0);
                                }
                            }
                        }
                    }

                    break;

                case "checkWorkShopRegistration": {
                        $contents     = urlImport($_GET['contents']);
                        $sessionDetails         = $contents['sessionDetails'];

                        $sql     = "
                        SELECT * FROM sessionApplication WHERE sessionDetails='$sessionDetails' and status=1 and id=$id ";

                        // echo $sql;
                        $qry = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($qry) > 0) {
                            $json = mysqli_fetch_all($qry, MYSQLI_ASSOC);
                            deliver_response($json);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;
                case "registeredWorkshops": {
                        $sql = "SELECT  * FROM `sessionApplication` as application  JOIN sessionDetails as d ON application.sessionCategory=d.sessionCategory  WHERE id=$id GROUP BY application.sessionCategory";


                        // echo $sql;
                        $qry = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($qry) > 0) {
                            $json = mysqli_fetch_all($qry, MYSQLI_ASSOC);
                            deliver_response($json);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;
                case "orderForWorkshop": {
                        $contents     = urlImport($_GET['contents']);
                        $orderID         = $contents['orderid'];
                        $orderStatus         = $contents['orderStatus'];
                        $netAmount         = $contents['netAmount'];
                        $sql     = "
                        INSERT INTO `orders` SET 
                        orderid='$orderID',
                        orderStatus='$orderStatus',
                        platform=2,
                        id=$id,
                        paymentMode='RazorPay',
                        netAmount='$netAmount',
                        orderFor='Session',
                        transactionDate	='$date',
                        status=1
                        ";

                        $qry = mysqli_query($connection, $sql);
                        deliver_response(1);
                    }
                    break;
                case "registerForWorkshop": {
                        $contents     = urlImport($_GET['contents']);
                        $sessionCategory         = $contents['sessionCategory'];
                        $sessionDetails         = $contents['sessionDetails'];
                        $sessionName         = $contents['sessionName'];
                        $sessionPhone         = $contents['sessionPhone'];
                        $sessionEmail         = $contents['sessionEmail'];
                        $pricePaid         = $contents['pricePaid'];
                        $orderid         = $contents['orderid'];

                        $sql     = "
                        INSERT INTO `sessionApplication` SET 
                        sessionCategory=$sessionCategory,
                        sessionDetails='$sessionDetails',
                        sessionName='$sessionName',
                        sessionPhone='$sessionPhone',
                        sessionEmail='$sessionEmail',
                        pricePaid='$pricePaid',
                        orderId='$orderid',
                        referralCode='APP123',
                        id=$id,
                        sessionDate='$date',
                        status=1
                        ";

                        $qry = mysqli_query($connection, $sql);
                        deliver_response(1);
                    }
                    break;
                case "activateSubscription": {

                        $contents     = urlImport($_GET['contents']);
                        //print_r($contents);
                        $securityVoucher  = $contents['securityVoucher'];
                        $securityKey      = $contents['securityKey'];
                        $fullName          = $contents['fullName'];
                        $phoneNumber       = $contents['phoneNumber'];
                        $emailAddress      = $contents['emailAddress'];

                        $sql                = "SELECT * from `resource-securityKeys` where securityVoucher = '" . $securityVoucher . "' AND securityKey = '" . $securityKey . "' AND status =1 AND id=0";
						//echo $sql;
                        $sql_query          = mysqli_query($connection, $sql);
                        $VoucherDetails     = mysqli_fetch_assoc($sql_query);
						//print_r($VoucherDetails);

                        //print_r($VoucherDetails);
                        if ($VoucherDetails['status'] == 1) {

                            $design             = $VoucherDetails['design'];
                            $timePeriod         = $VoucherDetails['timePeriod'];
                            $assignTo           = $VoucherDetails['assignTo'];
                            $design            = $VoucherDetails['design'];
                            $assignTo          = $VoucherDetails['assignTo'];
                            $activate          = date("Y/m/d");
                            $addtime           = strtotime($activate);
                            $expiry             = date("Y-m-d", strtotime("+ $timePeriod days", $addtime));

                            if ($design == 0) {

                                $sql                 = "SELECT * FROM `user-subscription` where id ='" . $id . "' AND status=1";
                                $result             = mysqli_query($connection, $sql);
                                $row                 = mysqli_fetch_assoc($result);

                                if ($row['id']) {
                                    deliver_response('fail1');
                                } else {

                                    //creating subscription
                                    $sql = "INSERT INTO `user-subscription` SET 	
                                    orderid				= '" . $securityVoucher . "',
                                    id					= '" . $id . "',
                                    design				= '" . $design . "',
                                    activate			= '" . $activate . "',
                                    expiry				= '" . $expiry . "',
                                    securityKey			= '" . $securityKey . "',
                                    dateCreated			= '" . $date . "',
                                    status				= 1";
                                    $qry                 = mysqli_query($connection, $sql);


                                    //Use Voucher
                                    $sql = "UPDATE `resource-securityKeys` SET
                                    id				= '" . $id . "'
                                    WHERE 
                                    securityVoucher	= '" . $securityVoucher . "' AND
                                    securityKey	  = '" . $securityKey . "' 
                                    AND status 		= 1";
                                    $qry             = mysqli_query($connection, $sql);


                                    //updating category
                                    $sql = "UPDATE `users` SET
                                    categoryid		= 2 
                                    WHERE 
                                    id 				= '" . $id . "' 
                                    AND status 		= 1";
                                    $qry             = mysqli_query($connection, $sql);

                                    //adding orders

                                    $sql = "INSERT IGNORE INTO `orders` SET 	
                                            orderid				= '" . $securityVoucher . "',
                                            id					= '" . $id . "',
                                            orderStatus			= 'Success',
                                            paymentMode			= 'promotion',
                                            currency			= 'INR',
                                            orderFor			= 'resumeDesign',
                                            offer_type			= '" . $assignTo . "',
                                            design				= '" . $design . "',
                                            transactionDate		= '" . $activate . "',
                                            status				= 1";
                                    $qry                 = mysqli_query($connection, $sql);

                                    // if Direct Activation else update id in voucher details
                                    $sql = "UPDATE `userVoucherDetails` SET
                                            id              = '" . $id . "',
                                            userName        = '" . $fullName . "',
                                            userEmail       = '" . $emailAddress . "',
                                            userPhone       = '" . $phoneNumber . "'
                                            WHERE
                                            voucherSN 		= '" . $securityVoucher . "'  AND
                                            voucherCode		= '" . $securityKey . "'  AND 
                                            status 			= 1";
                                    $qry             = mysqli_query($connection, $sql);


                                    deliver_response($VoucherDetails);
                                }
                            } else {

						$sql                 = "SELECT * FROM `associate-subscription` where id ='" . $id . "' AND design ='" . $design . "' AND status=1";
						//echo $sql;
						$result                = mysqli_query($connection, $sql);
						$row                 = mysqli_fetch_assoc($result);

                                if ($row['id']) {
                                    deliver_response('fail2');
                                } else {

                                    //creating subscription
                                    $sql = "INSERT INTO `associate-subscription` SET 	
                                            orderid				= '" . $securityVoucher . "',
                                            id					= '" . $id . "',
                                            design				= '" . $design . "',
                                            activate			= '" . $activate . "',
                                            expiry				= '" . $expiry . "',
                                            securityKey			= '" . $securityKey . "',
                                            dateCreated			= '" . $date . "',
                                            status				= 1";
                                    $qry                 = mysqli_query($connection, $sql);


                                    //Use Voucher
                                    $sql = "UPDATE `resource-securityKeys` SET
                                            id				= '" . $id . "'
                                            WHERE 
                                            securityVoucher	= '" . $securityVoucher . "' 
                                            AND status 		= 1";
                                    $qry             = mysqli_query($connection, $sql);


                                    //updating category
                                    $sql = "UPDATE `users` SET
                                            categoryid		= 1 
                                            WHERE 
                                            id 				= '" . $id . "' 
                                            AND status 		= 1";
                                    $qry             = mysqli_query($connection, $sql);

                                    //adding orders

                                    $sql = "INSERT IGNORE INTO `orders` SET 	
                                            orderid				= '" . $securityVoucher . "',
                                            id					= '" . $id . "',
                                            orderStatus			= 'Success',
                                            paymentMode			= 'Associate',
                                            currency			= 'INR',
                                            orderFor			= 'resumeDesign',
                                            offer_type			= '" . $assignTo . "',
                                            design				= '" . $design . "',
                                            transactionDate		= '" . $activate . "',
                                            status				= 1";
                                    $qry                 = mysqli_query($connection, $sql);


                                    // if Direct Activation else update id in voucher details
                                    $sql = "UPDATE `userVoucherDetails` SET
                                            id              = '" . $id . "',
                                            userName        = '" . $fullName . "',
                                            userEmail       = '" . $emailAddress . "',
                                            userPhone       = '" . $phoneNumber . "'
                                            WHERE
                                            voucherSN 		= '" . $securityVoucher . "'  AND
                                            voucherCode		= '" . $securityKey . "'  AND 
                                            status 			= 1";
                                    $qry             = mysqli_query($connection, $sql);


                                    deliver_response($VoucherDetails);
                                }
                            }
                        } else {
                            deliver_response('fail3');
                        }
                    }
                    break;
                case "requestAssociateSubscription": {
                        $design              = $_GET['design'];
                        $securityVoucher     = rand(1,9).rand(10000,99999);
                        $securityKey         = '7827'.'-'.rand(1000,9999).'-'.rand(1000,9999).'-'.rand(1000,9999);
						$activate		 	= date("y-m-d");
						$expiry			  = date('y-m-d', strtotime('+30 days'));
if($design>0) { 
                        $sql = "INSERT INTO `associate-subscription` SET
                                id				= '" . $id . "',
                                design			= '" . $design . "',  
                                orderid			= '" . $securityVoucher . "',  
                                securityKey		= '" . $securityKey . "',  
                                activate		= '" . $activate . "',  
                                expiry			= '" . $expiry . "',  
                                status		 	= 2";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
} else {
                            deliver_response(0);
}
				}
                    break;

                case "myRequestAssociateSubscription": {

                        $AssociateSubscriptionArray = array();
                        $sql     = "SELECT * FROM `associate-subscription` where id ='" . $id . "' AND status=0";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($AssociateSubscriptionArray, $row);
                            }
                            deliver_response($AssociateSubscriptionArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;

                case "requestAssociateProofRead": {
                        $resume         = $_POST['designID'];

                        $sql = "INSERT INTO `associate-proofRead` SET
                                id				= '" . $id . "',
                                resume			= '" . $resume . "',  
                                dateRequest		= '" . $date . "',
                                status		 	= 1";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;

                case "requestSaveResume": {

                        $profileID         = $_GET['cvid'];
                        $designID         = $_GET['designID'];
						$userAuth 		  = $authkey;

         $sql     = "SELECT `instituteadmin-userdata`.*, `cv-resumedownload`.* FROM `cv-resumedownload` INNER JOIN  `instituteadmin-userdata` USING(id) WHERE `cv-resumedownload`.profileID ='" . $profileID . "' and `cv-resumedownload`.profileDesign ='" . $designID . "' and `cv-resumedownload`.id ='" . $id . "' GROUP BY `cv-resumedownload`.id order by `cv-resumedownload`.created DESC LIMIT 1";
                        $result = mysqli_query($connection, $sql);
                        $row     = mysqli_fetch_assoc($result);
			
			$userName 		= $row['cvFullName'];
			$sn 			= $row['sn'];
			$batch 		= $row['batch'];
			$institute 	= $row['institute'];
			$department 	= $row['department'];
			$cvid	 		= $row['profileID'];
			$resume   		= $row['resume'];

$fileName = $userName.'-'.$sn.'.pdf';
$filePath = $batch.'/'.$institute.'/'.$department.'/';
$webLink = 'https://cvdragon.com/';

$url = $webLink.'publicPDF.php?url='.$webLink.'publicResume.php';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/x-www-form-urlencoded",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "option=associateSave&filePath=$filePath&fileName=$fileName&id=$id&authkey=$userAuth&resume=$resume&cvid=$cvid";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
//var_dump($resp);


$sql 			 = "UPDATE `instituteadmin-userdata` SET  `resume` = '".$fileName."' WHERE id = ".$id." AND status=1";
$qry             = mysqli_query($connection, $sql);

		if($qry) {deliver_response(1);}
		else {deliver_response(0);}


                        
                    }
                    break;

                case "addPlayerID":
                    $playerID        = $_GET['playerID']; {
                        if ($playerID != '') {
                            $sql = "UPDATE `users` SET
                            playerID			= '" . $playerID . "' 
                            WHERE 
                            id 				= '" . $id . "' AND 
                            status			= 1
";
                            $qry             = mysqli_query($connection, $sql);
                            if ($qry) {
                                deliver_response(1);
                            } else {
                                deliver_response(0);
                            }
                        } else {
                            deliver_response(0);
                        }
                    }

                    break;

                case "addUserPlayerID":
                    $playerID        = $_GET['playerID'];
                    $platform        = $_GET['platform'];
                    if ($playerID != '') {
                        $sql = "UPDATE `users` SET
                                playerID			= '" . $playerID . "' ,
                                mobilePlatform            = '" . $platform . "' 
                                WHERE 
                                id 				= '" . $id . "' AND 
                                status			= 1";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    } else {
                        deliver_response(0);
                    }


                    break;

                case "getAssociateInstituteData": {
                        $instituteArray = array();
                        $instituteID        = $_GET['instituteID'];
                        $sql     = "SELECT * FROM `instituteadmin-userdata` where id ='" . $id . "' AND institute ='" . $instituteID . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            array_push($instituteArray, $row);
                            deliver_response($instituteArray);
                        } else {
                            deliver_response($blankArray);
                        }
                    }
                    break;
                case "associateInstituteData": {
                        $contents     = urlImport($_GET['contents']);
                        $cvFullName          = $contents['cvFullName'];
                        $dateBirth           = $contents['dateBirth'];
                        $preferredLocation   = $contents['preferredLocation'];
                        $gender              = $contents['gender'];
                        $mobile              = $contents['mobile'];
                        $whatsApp            = $contents['whatsApp'];
                        $email               = $contents['email'];
                        $batch               = $contents['batch'];
                        $image               = $contents['image'];
                        $department          = $contents['department'];
                        $institute           = $contents['institute'];
                        $backlog             = $contents['backlog'];
                        $workexp             = $contents['workexp'];
                        $classX              = $contents['classX'];
                        $classXII            = $contents['classXII'];
                        $graduation          = $contents['graduation'];
                        $softSkill           = $contents['softSkill'];
                        $technicalSkill      = $contents['technicalSkill'];
                        $lang                = $contents['lang'];
                        $softSkills          = array(0, 0, 0, 0, 0);
                        $technicalSkills     = array(0, 0, 0, 0, 0);
                        $language            = array(0, 0, 0, 0, 0);
                        $sn                  = $contents['sn'];

                        for ($i = 0; $i < count($softSkill); $i++) {
                            $softSkills[$i] = $softSkill[$i];
                        }
                        for ($i = 0; $i < count($technicalSkill); $i++) {
                            $technicalSkills[$i] = $technicalSkill[$i];
                        }

                        for ($i = 0; $i < count($lang); $i++) {
                            $language[$i] = $lang[$i];
                        }



                        if ($sn > 0) {
                            $sql = "UPDATE `instituteadmin-userdata` SET 
		`dateBirth`        = '" . $dateBirth . "',
		`preferredLocation`= '" . $preferredLocation . "',
		`gender`           = '" . $gender . "', 
		`mobile`           = " . $mobile . ",
		`whatsApp`         = " . $whatsApp . ",
		`email`            = '" . $email . "',
		`batch`            = " . $batch . ",
		`department`       = " . $department . ",
		`image`       	   = '" . $image . "',
		`softSkills1`      = " . $softSkills[0] . ", 
		`softSkills2`      = " . $softSkills[1] . ",
		`softSkills3`      = " . $softSkills[2] . ",
		`softSkills4`      = " . $softSkills[3] . ",
		`softSkills5`      = " . $softSkills[4] . ",
		`technicalSkills1` = " . $technicalSkills[0] . ", 
		`technicalSkills2` = " . $technicalSkills[1] . ", 
		`technicalSkills3` = " . $technicalSkills[2] . ", 
		`technicalSkills4` = " . $technicalSkills[3] . ", 
		`technicalSkills5` = " . $technicalSkills[4] . ", 
		`language1`        = " . $language[0] . ", 
		`language2`        = " . $language[1] . ",
		`language3`        = " . $language[2] . ",
		`language4`        = " . $language[3] . ",
		`language5`        = " . $language[4] . ",
		`backlog`          = " . $backlog . ",
		`workexp`          = " . $workexp . ",
		`classX`           = " . $classX . ",
		`classXII`         = '" . $classXII . "',
		`graduation`       = " . $graduation . " WHERE `sn` = " . $sn . " AND id = " . $id . " AND status=1";

                            $result = mysqli_query($connection, $sql);
                            if ($result) {
                                deliver_response(1);
                            } else {
                                deliver_response(0);
                            }
                        } else {


                            $sql = "INSERT INTO `instituteadmin-userdata` (`dateBirth`,`preferredLocation`,`gender`,`mobile`,`whatsApp`,`email`,`batch`,`department`,`institute`,`image`,`softSkills1`,`softSkills2`,`softSkills3`,`softSkills4`,`softSkills5`,`technicalSkills1`,`technicalSkills2`,`technicalSkills3`,`technicalSkills4`,`technicalSkills5`,`language1`,`language2`,`language3`,`language4`,`language5`,`backlog`,`workexp`,`classX`,`classXII`,`graduation`,`cvFullName`,`id`,`dateCreated`,`status`)
VALUES('" . $dateBirth . "','" . $preferredLocation . "','" . $gender . "'," . $mobile . "," . $whatsApp . ",'" . $email . "'," . $batch . "," . $department . "," . $institute . ",'" . $image . "'," . $softSkills[0] . "," . $softSkills[1] . "," . $softSkills[2] . "," . $softSkills[3] . "," . $softSkills[4] . "," . $technicalSkills[0] . "," . $technicalSkills[1] . "," . $technicalSkills[2] . "," . $technicalSkills[3] . "," . $technicalSkills[4] . "," . $language[0] . "," . $language[1] . "," . $language[2] . "," . $language[3] . "," . $language[4] . "," . $backlog . "," . $workexp . "," . $classX . "," . $classXII . ",'" . $graduation . "','" . $cvFullName . "','" . $id . "','" . $date . "',1)";

                            $result = mysqli_query($connection, $sql);
                            $insertID = mysqli_insert_id($connection);

                            if ($insertID) {
                                deliver_response(1);
                            } else {
                                deliver_response(0);
                            }
                        }
                    }

                    break;
                case "createPublicProfile": {

                        $username                = $_GET['username'];
                        $publicProfile           = $_GET['publicProfile'];
                        $publicProfileDesign     = $_GET['publicProfileDesign'];


                        $sql = "UPDATE `users` SET
username		= '" . $username . "'
WHERE 
id				= '" . $id . "' AND 
status 			= 1";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            $usernamestatus = 1;
                            //send app notification
							
       	$details			 	 = array();
       	$details['title'] 		= 'Your Public Profile';
       	$details['description']  = 'You can also share your profile link along with your resume, click to view your profile';
       	$details['buttonName']   = 'View Profile';
       	$details['image'] 		= '';
       	$details['redirectLink'] = $profileURL . $username;
       	$details['route'] 		= $profileURL . $username;
       	$details['url'] 		  = $profileURL . $username;
		$id					  = $id;

		sendNotificationPopUp($details,$id,$connection);
							/*
                            sendNotification(
                                'Your Public Profile!!',
                                'You can also share your profile link along with your resume, click to view your profile',
                                '',
                                $id,
                                '',
                                $profileURL . $username,
                                $connection
                            ); 
							*/
                        } else {
                            $usernamestatus = 0;
                        }

                        $sql = "UPDATE `user-basic` SET
publicProfile	= '" . $publicProfile . "', 
publicProfileDesign	= '" . $publicProfileDesign . "' 
WHERE 
id				= '" . $id . "' AND 
status 			= 1";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            $publicprofilestatus = 1;
                        } else {
                            $publicprofilestatus = 0;
                        }

                        deliver_response($usernamestatus . $publicprofilestatus);
                    }
                    break;
                case "addUserNotification": {

                        $contents           = urlImport($_GET['contents']);
                        $userName          = $contents['userName'];
                        $userMobile        = $contents['userMobile'];
                        $userEmail            = $contents['userEmail'];
                        $notificationID    = $_GET['notificationID'];

                        $sql = "INSERT INTO `user-notification` SET 
						id 				= '" . $id . "',
						notificationID  = '" . $notificationID . "', 
						userName		= '" . $userName . "',
						userEmail		= '" . $userEmail . "',
						userMobile		= '" . $userMobile . "',
						dateRequest		= '" . $date . "',
						status			= 1";

                        $qry = mysqli_query($connection, $sql);

                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
                case "updateCVFullName": {
                        $contents     = urlImport($_GET['contents']);

                        $cvFullName            = $contents['cvFullName'];

                        $sql = "UPDATE `cv-basic-info` SET
cvFullName		= '" . $cvFullName . "', 
verified		= 1
WHERE 
id				= '" . $id . "' AND 
status 			= 1";
                        $qry             = mysqli_query($connection, $sql);

                        $sql = "UPDATE `user-basic` SET
fullName		= '" . $cvFullName . "' 
WHERE 
id				= '" . $id . "' AND 
status 			= 1";
                        $qry             = mysqli_query($connection, $sql);

                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;

                case "updateProfileName": {
                        $contents     = urlImport($_GET['contents']);

                        $newName            = $contents['newName'];
                        $cvid            = $contents['cvid'];

                        $sql = "UPDATE `create-cvprofile` SET `profileName`= '" . $newName . "' WHERE cvid=$cvid and id =$id";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
                case "updateSectionOrder": {
                        $contents     = urlImport($_GET['contents']);

                        $sectionOrder    = json_encode($contents['sectionOrder']);
						if(empty($sectionOrder)) {$sectionOrder='';}
                        $cvid            = $contents['cvid'];

                        $sql = "UPDATE `create-cvprofile` SET `sectionOrder`= '" . $sectionOrder . "' WHERE cvid=$cvid and id =$id";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
                case "updateUserInternational": {
                        $isInternational                   =    isset($_GET['isInternational']) ? $_GET['isInternational'] : '0';


                        $sql = "UPDATE `user-basic` SET
                                isInternational		= '" . $isInternational . "' 
                                WHERE 
                                id				= '" . $id . "' AND 
                                status 			= 1";
                        $qry             = mysqli_query($connection, $sql);

                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
                case "updateEducationStatus": {

                        $educationCategory            = $_GET['educationCategory'];
                        $educationStatus              = $_GET['educationStatus'];

                        $sql = "UPDATE `cv-education` SET
remove			= '" . $educationStatus . "' 
WHERE 
id				= '" . $id . "' AND 
category		= '" . $educationCategory . "' AND 
status 			= 1";
                        $qry             = mysqli_query($connection, $sql);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
                case "MyVoucherList": {

                        $myEmail     = $_GET['email'];
                        $myPhone     = $_GET['phone'];

                        $myVoucherArray = array();

                        $sql     = "SELECT * FROM `userVoucherDetails` where  userPhone='" . $myPhone . "' AND id=0  AND status=1 AND userPhone!='' ORDER BY sn DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($myVoucherArray, array('voucherDetails' => $row));
                            }
                        }

                        $sql     = "SELECT * FROM `userVoucherDetails` where userEmail='" . $myEmail . "' AND id=0  AND status=1 AND userEmail!='' ORDER BY sn DESC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($myVoucherArray, array('voucherDetails' => $row));
                            }
                        }

                        deliver_response($myVoucherArray);
                    }
                    break;
                case 'getTaskStatus':

                    $sql     = "SELECT * FROM `usersTaskCompleted` where id='" . $id . "' AND (taskApprovedStatus=1 OR taskApprovedStatus=0)  AND status=1 ";
                    $result = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($result) > 0) {
                    } else {
                        deliver_response(0);
                    }
                case 'getTaskStatusArray':
                    $sql     = "SELECT * FROM `usersTaskCompleted` where id='" . $id . "'   AND status=1  ORDER BY taskCompletedDate DESC";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);

                    break;
                case "markTaskCompleted":
                    $googleImage     	= trim($_GET['googleImage']);
                    $facebookImage     = trim($_GET['facebookImage']);
                    $youtubeImage     = trim($_GET['youtubeImage']);
                    $linkedInImage     = trim($_GET['linkedInImage']);
                    $instagramImage     = trim($_GET['instagramImage']);
                    $twitterImage     = trim($_GET['twitterImage']);
                    $playStoreImage     = trim($_GET['playStoreImage']);
                    $sql = "INSERT INTO `usersTaskCompleted` SET 
                    id 				= '" . $id . "',
                    googleImage          = '" . $googleImage . "', 
                    facebookImage		    = '" . $facebookImage . "',
                    youtubeImage	    	= '" . $youtubeImage . "',
                    linkedInImage	    	= '" . $linkedInImage . "',
                    playStoreImage	    	= '" . $playStoreImage . "',
                    instagramImage	    	= '" . $instagramImage . "',
                    twitterImage	    	= '" . $twitterImage . "',
                    taskApprovedStatus		= 0,
                    status			= 1";

                    $qry = mysqli_query($connection, $sql);

                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    }



                    break;


                case "generateResumeID":
                    $resume                =     rand(1, 1000) . time();
                    $profileID     = $_GET['profileID'];
                    $ProfileSections     = $_GET['ProfileSections'];
                    $sectionsBreak     = $_GET['sectionsBreak'];
                    $profileDesign     = $_GET['profileDesign'];
                    $profileSetting     = $_GET['profileSetting'];
                    $profileFont     = $_GET['profileFont'];
                    $fontSize     = $_GET['fontSize'];
                    $logoFormatC     = $_GET['logoFormat']; if($logoFormatC==1) {$logoFormat==0;} else {$logoFormat==1;}
                    $imageFormatC     = $_GET['imageFormat']; if($imageFormatC==1) {$imageFormat==0;} else {$imageFormat==1;}
                    $backGroundFormat = $_GET['backGroundFormat'];
                    $workTimeFormat     = $_GET['workTimeFormat'];
                    $imageLink     = $_GET['imageLink'];
                    $introId     = $_GET['introId'];
                    $isPublic     = $_GET['isPublic'];
                    $qrCodeFormat     = isset($_GET['qrCodeFormat']) ? $_GET['qrCodeFormat'] : '0';
                    $dobFormat     = $_GET['dobFormat'];
                    $designFormat     = $_GET['designFormat'];

                    $sql = "SELECT * FROM `cv-resumedownload` WHERE  
                    id 				= '" . $id . "' AND
                    profileID          = '" . $profileID . "' AND 
                    ProfileSections		    = '" . $ProfileSections . "' AND
                    profileDesign	    	= '" . $profileDesign . "' AND
                    isPublic	    	= '" . $isPublic . "' AND
                    imageLink	    	= '" . $imageLink . "' AND
                    introid	    	= '" . $introId . "' AND
                    workTimeFormat	    	= '" . $workTimeFormat . "' AND
                    imageFormat	    	= '" . $imageFormat . "' AND
                    logoFormat	    	= '" . $logoFormat . "' AND
					backGroundFormat	= '" . $backGroundFormat . "' AND
                    fontSize	    	= '0' AND
                    profileFont	    	= '" . $profileFont . "' AND
                    qrCodeFormat	    	= '" . $qrCodeFormat . "' AND
                    sectionsBreak	    	= '" . $sectionsBreak . "' AND
                    profileSetting	    	= '" . $profileSetting . "' AND
                    status			= 1";

                    $qry = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($qry) > 0) {
						
                        $row     = mysqli_fetch_assoc($qry);
						UpdateUserPreviewCount($row['resumeid'],$connection);
						UpdateDesignDownload($profileDesign,$connection);

                        deliver_response(1);
                    } else {

                        $sql = "INSERT INTO `cv-resumedownload` SET 
                        id 				= '" . $id . "',
                        resume 				= '" . $resume . "',
                        profileID          = '" . $profileID . "', 
                        ProfileSections		    = '" . $ProfileSections . "',
                        profileDesign	    	= '" . $profileDesign . "',
                        isPublic	    	= '" . $isPublic . "',
                        imageLink	    	= '" . $imageLink . "',
                        workTimeFormat	    	= '" . $workTimeFormat . "',
                        imageFormat	    	= '" . $imageFormat . "',
                        logoFormat	    	= '" . $logoFormat . "',
                        fontSize	    	= '0',
                        introid	    	= '" . $introId . "',
						backGroundFormat    = '" . $backGroundFormat . "',
                        profileFont	    	= '" . $profileFont . "',
                        qrCodeFormat	    	= '" . $qrCodeFormat . "',
                        sectionsBreak	    	= '" . $sectionsBreak . "',
                        profileSetting	    	= '" . $profileSetting . "',
                        status			= 1";

                        $qry = mysqli_query($connection, $sql);

//if($id==14889791841417){ 
if(1==2){ 
                            sendNotificationCustom(
                                'Anniversary offer',
                                'Buy 10 years PRO subscription for Rs. 500 only',
                                'services',
                                $id,
                                'https://cvdragon.com/public/img/campaignsFiles/AnnOffer/PosterforEmail1.jpg',
                                'https://cvdragon.com/open/AnniversaryOffer',
                                'Purchase Now',
                                $connection
                            );
}
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }





                    break;

                case "updatePublicProfileSettings":
                    $showMobile     = $_GET['showMobile'];
                    $showProfile     = $_GET['showProfile'];
                    $showEmail     = $_GET['showEmail'];
                    $sql = "UPDATE `user-basic` SET 
                    showMobile          = '" . $showMobile . "', 
                    showProfile		    = '" . $showProfile . "',
                    showEmail	    	= '" . $showEmail . "'
                    WHERE id =$id";

                    $qry = mysqli_query($connection, $sql);

                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    }
                    break;

                case "updatePreferenceSettings":

					$showFeatureNotification     = $_GET['showFeatureNotification'];
                    $showFeatureWorkshops     	= $_GET['showFeatureWorkshops'];
                    $showFeatureJobs     		 = $_GET['showFeatureJobs'];
                    $showFeatureArticles     	 = $_GET['showFeatureArticles'];
                    $showFeatureTips     		 = $_GET['showFeatureTips'];
                    $showFeatureFAQs     		 = $_GET['showFeatureFAQs'];
					
                    $sql = "UPDATE `user-basic` SET 
                    showFeatureNotification         = '" . $showFeatureNotification . "', 
                    showFeatureWorkshops		    = '" . $showFeatureWorkshops . "',
                    showFeatureJobs          		= '" . $showFeatureJobs . "', 
                    showFeatureArticles		    	= '" . $showFeatureArticles . "',
                    showFeatureTips		    		= '" . $showFeatureTips . "',
                    showFeatureFAQs	    			= '" . $showFeatureFAQs . "'
                    WHERE id =$id";

                    $qry = mysqli_query($connection, $sql);

                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    }
/*
       	$details			 	 = array();
       	$details['title'] 		= 'Student Free Subscription';
       	$details['description']  = 'Claim your 1 year Free Premium Subscription';
       	$details['buttonName']   = 'Claim Now';
       	$details['image'] 		= 'https://cvdr.in/public/img/offers/SFS/SFS.jpg';
       	$details['redirectLink'] = 'https://cvdr.in/offers/SFS/AppDirect';
       	$details['route'] 		= 'https://cvdr.in/offers/SFS/AppDirect';
       	$details['url'] 		  = 'https://cvdr.in/offers/SFS/AppDirect';
		$id					  = $id;

		sendNotificationPopUp($details,$id,$connection);
*/

                    break;

                case "updateShowNameOfSection":
                    $newName     = $_GET['newName'];
                    $section     = $_GET['section'];
                    $sql = "UPDATE `create-cvprofilesection` SET showName='$newName' WHERE `section`= 
                        $section AND status=1 AND  id=$id";

                    $qry = mysqli_query($connection, $sql);

                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    }
                    break;

                case "updateSelectedIntro":
                    $cvid     = $_GET['cvid'];
                    $introId     = $_GET['introId'];
                    $sql =   "UPDATE `create-cvprofile` SET intro = $introId WHERE id=$id AND cvid=$cvid AND status=1";
                    $qry = mysqli_query($connection, $sql);
                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    }
                    break;

                case "updateNotificationSettings":
                    $notiHelp		 = $_GET['notiHelp'];
                    $notiDesign		= $_GET['notiDesign'];
                    $notiOther		= $_GET['notiOther'];
                    $notiPlacement	= $_GET['notiPlacement'];
                    $DND			= $_GET['DND'];
                    $DNE			= $_GET['DNE'];
                    $DNW			= $_GET['DNW'];
					
                    $sql = "UPDATE `user-basic` SET 
                        notiHelp          = '" . $notiHelp . "', 
                        notiOther		    = '" . $notiOther . "',
                        notiDesign		    = '" . $notiDesign . "',
                        DND		    = '" . $DND . "',
                        DNE		    = '" . $DNE . "',
                        DNW		    = '" . $DNW . "',
                        notiPlacement	    	= '" . $notiPlacement . "'
                        WHERE id =$id";

                    $qry = mysqli_query($connection, $sql);

                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    }
                    break;

                case "updateEducationVisibility":
                    $eduid     = $_GET['eduid'];
                    $visibility     = $_GET['visibility'];
                    $sql = "UPDATE `cv-education` SET visibility=$visibility  WHERE id =$id AND eduid=$eduid";
                    $qry = mysqli_query($connection, $sql);


                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    }
                    break;

                case "updateSubsectionOrder":
                    $subsections     = urlImport($_GET['subsections']);
                    $tablename     = $_GET['tablename'];
                    $time = date('Y-m-d H:i:s');
                    $minutes_to_add = 1;
                    $time = new DateTime();
                    foreach ($subsections as $refID) {
                        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                        $stamp = $time->format('Y-m-d H:i:s');
                        $sql = "UPDATE $tablename SET created='$stamp'  WHERE id =$id AND refID=$refID";
                        $qry = mysqli_query($connection, $sql);
                    }
                    deliver_response(1);
                    break;

                case "deleteUser":
                    $reasons  = $_GET['reasons'];
					//store reason for account delete
					
				  $sql = "INSERT INTO `user-feedback` SET 
						  feedback	= '" . $reasons . "', 
						  mode		= 'Delete', 
						  id 		= '" . $id . "', 
						  status 	= 1";
				  $qry       = mysqli_query($connection, $sql);

                    if ($qry) {

                    $sql = "UPDATE `user-basic` SET status=2 WHERE id =$id AND status=1";
                    $qry = mysqli_query($connection, $sql);

                    $sql = "UPDATE `users` SET status=2 WHERE id =$id AND status=1";
                    $qry = mysqli_query($connection, $sql);

                    if ($qry) {
                        deliver_response(1);
                    } else {
                        deliver_response(0);
                    } } 
					else { deliver_response(0);}
                    break;

                case "feedback":
                    $reasons  = $_GET['reasons'];
                    $rating   = $_GET['rating'];
                    

				  $sql = "INSERT INTO `user-feedback` SET 
						  feedback	= '" . $reasons . "', 
						  rating	= '" . $rating . "', 
						  mode		= 'Feedback', 
						  id 		= '" . $id . "', 
						  status 	= 1";
				  $qry       = mysqli_query($connection, $sql);

                    if ($qry) {
						$sql = "UPDATE `user-basic` SET showOptionFeedback=0 WHERE id =$id AND status=1";
						$qry = mysqli_query($connection, $sql);
						
                    	if ($qry) {deliver_response(1);} else {deliver_response(0);}
					} 
					else {deliver_response(0);}
                    break;

                case "paymentStatus":

                    $contents           = urlImport($_GET['contents']);
                    $services            = $contents['services'];
                    $TotalServices       = count($services);
                    //echo $new;


                    $date                       =     date("Y/m/d");
                    $orderid                    =    $contents['txn_id'];
                    $platform                   =    2;
                    $currency                   =    isset($contents['currency']) ? $contents['currency'] : 'INR';
                    $orderStatus                =    $contents['message'];
                    $paymentMode                =    'RazorPay';
                    $netAmount                  =    $contents['total_amount'];
                    $transactionDate            =    date("Y-m-d H:i:s");

                    $sql = "INSERT INTO `orders` SET 	
                            orderid				= '" . $orderid . "',
                            id					= '" . $id . "',
                            orderStatus			= '" . $orderStatus . "',
                            currency			= '" . $currency . "',
                            platform			= '" . $platform . "',
                            paymentMode			= '" . $paymentMode . "',
                            netAmount			= '" . $netAmount . "',
                            transactionDate		= '" . $transactionDate . "',
                            status				= 1";
                    $qry                 = mysqli_query($connection, $sql);

                    if ($qry) {
                        if ($orderStatus == 'Success') {
                            $notificationMsg = '';
                            if ($currency == "INR") {
                                $notificationMsg = 'We have received a payment of ' . $netAmount . ' rupees';
                            } else {
                                $notificationMsg = 'We have received a payment of USD ' . $netAmount;
                            }
                            //send app notification
                            sendNotification(
                                'Yeah! Payment Received',
                                $notificationMsg,
                                'subscribe',
                                $id,
                                '',
                                '',
                                $connection
                            );

                            for ($x = 0; $x < $TotalServices; $x++) {
                                $seviceID = $services[$x]->serviceID;
                                switch ($seviceID) {
                                    case "1":
										updateUserCategory(3,$id,$connection);

                                        break;
                                    case "2":
                                        $year          = $services[$x]->years;
                                        $duration    = $year * 365;
                                        $amount       = $services[$x]->amount;

                                        activateAssociateSubscription($id, $duration, $design, $connection);
										updateUserCategory(3,$id,$connection);

                                        break;
                                    case "9":
                                        $amount       = $services[$x]->amount;

                                        $sql = "INSERT INTO `user-proofRead` SET 	
                                        orderid				= '" . $orderid . "',
                                        id					= '" . $id . "',
                                        dateRequest			= '" . $transactionDate . "',
                                        status				= 1";
                                        $qry                 = mysqli_query($connection, $sql);
                                        if ($qry) {

                                            //send app notification
                                            sendNotification(
                                                'Woohoo!! Proofread Service Purchased',
                                                'Our Team will get in touch with you shortly',
                                                'subscribe',
                                                $id,
                                                '',
                                                '',
                                                $connection
                                            );

//send WA
	$dataWA = IDtoUserMobileWATransactional($id,$connection);
	if($dataWA['status']==1) {
	$sendWAURL = $sendWAURL;
	$serviceName = 'Proofread Service, Our Expert will get in touch with you shortly';
	$fullWAData = array();
	$fullWAData['phoneNumber']   = $dataWA['usermobile'];
	$fullWAData['userName']      = $dataWA['fullName'];
	$fullWAData['message']       = $serviceName;
	$WATemplate               	  = 'generalservicepurchase';
	$WAcontent                   = urlExport($fullWAData);
	$entryID					 = 105486032380156;
	$url                         = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                     = file_get_contents($url);
	$result                      = json_decode($content, true);
	}

                                        }

                                        break;
                                    case "19":
                                        $amount       = $services[$x]->amount;

                                        $sql = "INSERT INTO `user-proofRead` SET 	
                                        orderid				= '" . $orderid . "',
                                        id					= '" . $id . "',
                                        dateRequest			= '" . $transactionDate . "',
                                        status				= 1";
                                        $qry                 = mysqli_query($connection, $sql);
                                        if ($qry) {

                                            //send app notification
                                            sendNotification(
                                                'Woohoo!! LinkedIn Service Purchased',
                                                'Our Team will get in touch with you shortly',
                                                'subscribe',
                                                $id,
                                                '',
                                                '',
                                                $connection
                                            );

//send WA
	$dataWA = IDtoUserMobileWATransactional($id,$connection);
	if($dataWA['status']==1) {
	$sendWAURL = $sendWAURL;
	$serviceName = 'LinkedIn Profile Service, Our Expert will get in touch with you shortly';
	$fullWAData = array();
	$fullWAData['phoneNumber']   = $dataWA['usermobile'];
	$fullWAData['userName']      = $dataWA['fullName'];
	$fullWAData['message']       = $serviceName;
	$WATemplate               	  = 'generalservicepurchase';
	$WAcontent                   = urlExport($fullWAData);
	$entryID					 = 105486032380156;
	$url                         = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                     = file_get_contents($url);
	$result                      = json_decode($content, true);
	}

                                        }

                                        break;
                                    case "14":
									
                                       		 changeNameRequest($id,$connection);

                                            //send app notification
                                            sendNotification(
                                                'Name Change Request Activated',
                                                'You can now update your Name from Settings',
                                                'subscribe',
                                                $id,
                                                '',
                                                '',
                                                $connection
                                            );

//send WA
	$dataWA = IDtoUserMobileWATransactional($id,$connection);
	if($dataWA['status']==1) {
	$sendWAURL = $sendWAURL;
	$serviceName = 'Name Change Service';
	$fullWAData = array();
	$fullWAData['phoneNumber']   = $dataWA['usermobile'];
	$fullWAData['userName']      = $dataWA['fullName'];
	$fullWAData['message']       = $serviceName;
	$WATemplate               	  = 'generalservicepurchase';
	$WAcontent                   = urlExport($fullWAData);
	$entryID					 = 105486032380156;
	$url                         = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                     = file_get_contents($url);
	$result                      = json_decode($content, true);
	}


                                        break;
                                    case "12":
                                        $duration   = 30;
                                        $design      = 0;
                                        $amount       = $services[$x]->amount;
                                        activateSubscription($id, $duration, $design, $connection);
										updateUserCategory(3,$id,$connection);

                                        break;
									case "3":
										$duration   = 30;
										$design      = 0;
										$amount       = $services[$x]->amount;
										activateSubscription($id, $duration, $design, $connection);
										updateUserCategory(3,$id,$connection);

//send WA
	$dataWA = IDtoUserMobileWATransactional($id,$connection);
	if($dataWA['status']==1) {
	$sendWAURL = $sendWAURL;
	$fullWAData = array();
	$fullWAData['phoneNumber']   		  = $dataWA['usermobile'];
	$fullWAData['userName']      		 = $dataWA['fullName'];
	$fullWAData['subscriptionDuration'] = $duration.' Days';
	$fullWAData['subscriptionAmount']   = 199;
	$WATemplate               	  		 = 'subscriptionpurchase';
	$WAcontent                   		  = urlExport($fullWAData);
	$entryID					 		= 105486032380156;
	$url                         		= $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                     		= file_get_contents($url);
	$result                      		 = json_decode($content, true);
	}

									 break;
									 
									case "4":
										$duration   = 365;
										$design      = 0;
										$amount       = $services[$x]->amount;
										activateSubscription($id, $duration, $design, $connection);
										updateUserCategory(3,$id,$connection);

//send WA
	$dataWA = IDtoUserMobileWATransactional($id,$connection);
	if($dataWA['status']==1) { 
	$sendWAURL = $sendWAURL;
	$fullWAData = array();
	$fullWAData['phoneNumber']   		  = $dataWA['usermobile'];
	$fullWAData['userName']      		 = $dataWA['fullName'];
	$fullWAData['subscriptionDuration'] = $duration.' Days';
	$fullWAData['subscriptionAmount']   = 499;
	$WATemplate               	  		 = 'subscriptionpurchase';
	$WAcontent                   		  = urlExport($fullWAData);
	$entryID					 		= 105486032380156;
	$url                         		= $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                     		= file_get_contents($url);
	$result                      		 = json_decode($content, true);
	}

									 break;
									 
									case "5":
										$duration   = 3650;
										$design      = 0;
										$amount       = $services[$x]->amount;
										activateSubscription($id, $duration, $design, $connection);
										updateUserCategory(4,$id,$connection);

//send WA
	$dataWA = IDtoUserMobileWATransactional($id,$connection);
	if($dataWA['status']==1) { 
	$sendWAURL = $sendWAURL;
	$serviceName = 'Lifetime Access Plan, kindly Resync your application';
	$fullWAData = array();
	$fullWAData['phoneNumber']   = $dataWA['usermobile'];
	$fullWAData['userName']      = $dataWA['fullName'];
	$fullWAData['message']       = $serviceName;
	$WATemplate               	  = 'generalservicepurchase';
	$WAcontent                   = urlExport($fullWAData);
	$entryID					 = 105486032380156;
	$url                         = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
	$content                     = file_get_contents($url);
	$result                      = json_decode($content, true);
	}

									 break;
									 
                                    default: {
                                            $seviceID          = $services[$x]->serviceID;
                                            $amount            = $services[$x]->amount;

                                            $sql = "INSERT INTO `user-servicePurchased` SET 	
                                                    orderid				= '" . $orderid . "',
                                                    id					= '" . $id . "',
                                                    service				= '" . $seviceID . "',
                                                    amount				= '" . $amount . "',
                                                    dateCreated			= '" . $transactionDate . "',
                                                    status				= 1";
                                            $qry                 = mysqli_query($connection, $sql);
                                            if ($qry) {

                                                //send app notification
                                                sendNotification(
                                                    'Woohoo!! Service Purchased',
                                                    'Our Team will get in touch with you shortly',
                                                    'subscribe',
                                                    $id,
                                                    '',
                                                    '',
                                                    $connection
                                                );

                                            }
                                        }
                                }
                            }

                            //send Response 
                            deliver_response(1);
                        } else {
                            $notificationMsg = '';
                            if ($currency == "INR") {
                                $notificationMsg =  'Your payment amounting to ' . $netAmount . ' rupees could not be completed';
                            } else {
                                $notificationMsg =  'Your payment amounting to USD ' . $netAmount . ' could not be completed';
                            }
                            //send app notification
                            sendNotification(
                                'Oops! Payment Failed',
                                $notificationMsg,
                                'subscribe',
                                $id,
                                '',
                                '',
                                $connection
                            );

                            //send Response 
                            deliver_response(0);
                        }
                    }


                    break;
                case "SessionCertificate": {

                        $sessionPhone    =  filterThis($connection, $_GET['sessionPhone']);
                        $useremail    =  filterThis($connection, $_GET['useremail']);
                        $sessionCategory    =  filterThis($connection, $_GET['sessionCategory']);

                        //Fetch Resume Setting
                        $webLink    = $baseURL;
                        $url         = $webLink . '?id='.$id.'&authkey='.$authkey.'&sessionPhone=' . $sessionPhone . '&sessionCategory=' . $sessionCategory . '&data=mySessionDetails';
                        $content    = file_get_contents($url);
                        $myDetails  = json_decode($content, true);

                        if ($myDetails['status']) {
                            if ($myDetails['sessionAttended'] == 1) {
                                if ($myDetails['id']) {

                                    $certificateDetails            = getAuth($myDetails['id'], $connection);
                                    $id                          = $certificateDetails['id'];
                                    $authkey                        = $certificateDetails['authkey'];
                                    $webLink                      = $websiteURL;
                                    $fullData                     = array();
                                    $fullData['sessionName']      = $myDetails['sessionName'];
                                    $fullDatasessionDate          = explode(' ', $myDetails['sessionDetails']);
                                    $fullData['sessionDate']      = $fullDatasessionDate[0];
                                    $fullData['certificateIssued'] = $myDetails['certificateIssued'];
                                    $fullData['certificateType']  = $myDetails['certificateType'];
                                    $fullData['sessionCategory']  = $myDetails['sessionCategory'];
                                    $contents                     = urlExport($fullData);
                                    $link                         = $webLink . 'public/resources/sessionConducted/certificate.php?contents=' . $contents;
                                    $postdata                     = http_build_query(
                                        array(
                                            'id' => $id,
                                            'authkey' => $authkey,
                                            'pdfTitle' => 'Certificate',
                                            'pdfSubject' => 'Certificate of Participation',
                                            'pdfName' => $id,
                                            'pdfLocation' => 'sessionConducted/Certificate',
                                            'pdfOption' => 'save',
                                            'pdfURL' => urlencode($link)
                                        )
                                    );
                                    $opts = array('http' =>
                                    array(
                                        'method'  => 'POST',
                                        'header'  => 'Content-Type: application/x-www-form-urlencoded',
                                        'content' => $postdata
                                    ));

                                    $context  = stream_context_create($opts);
                                    $result = file_get_contents($webLink . 'generatePDF.php', false, $context);
                                    deliver_response(1);
                                }
                            }
                        }
                    }
                    break;

                case "changeMobileNumber": {

                        $userInfo = array();
                        $mobile          = $_GET['mobile'];
                        $usermobile      = '91'.$mobile;
                        $countryCode     = $_GET['countryCode'];
                        $otp             = rand(1000, 9999);
						$id         	  = mobileToID($usermobile, $connection);
                           
						$userInfo['mobile'] = $mobile;
						$userInfo['otp'] = $otp;


						if ($id) {
						$userInfo['id'] = $id; 
						
						deliver_response($userInfo);
						
 						} else { 
						
						$userInfo['id'] = "0";
						
                        //send SMS
                        $sendSMSURL = $SMSURL;
                        $fullSMSData = array();
                        $fullSMSData['SMSSender']          = 'CVDRGN';
                        $fullSMSData['countryCode']        = $countryCode;
                        $fullSMSData['phoneNumber']        = $mobile;
                        $fullSMSData['SMSContent']
                            = 'Your OTP for cvDragon Login is ' . $otp . ' Team cvDragon';
                        $fullSMSData['route']               = '4';
                        $SMScontent                         = urlExport($fullSMSData);
                        $url                                 = $sendSMSURL . '?id=&authkey=&data=OTP&contents=' . $SMScontent;
                        $content                             = file_get_contents($url);
                        $result                             = json_decode($content, true);

/*
						// send WA
						$sendWAURL = $sendWAURL;
						$fullWAData = array();
						$fullWAData['phoneNumber']        = $mobile;
						$fullWAData['OTP']      	  	  = $otp;
						$WATemplate               		  = 'otpmessage';
						$WAcontent                        = urlExport($fullWAData);
						$entryID						  = 105486032380156;
						$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
						$content                          = file_get_contents($url);
						$result                           = json_decode($content, true);
*/	
                        deliver_response($userInfo);
					
                         } 
                    }
                    break;

                case "updateMobileNumber": {


                        $newMobile          = $_GET['newMobile'];
                        $mobileWithCC = "91" . $newMobile;

                        $sql = "UPDATE users SET usermobile=$mobileWithCC WHERE id=$id and status=1";
                        $qry                 = mysqli_query($connection, $sql);
                        $sql = "UPDATE `user-basic` SET phoneNumber=$newMobile WHERE id=$id and status=1";
                        $qry                 = mysqli_query($connection, $sql);

                        deliver_response(1);
                    }
                    break;
                case "changeBaseInformation": {
					
                        $userInfo = array();
                        $information     = $_GET['information'];
                        $informationType = $_GET['informationType'];
                        $informationMode = $_GET['informationMode'];

						if($informationType=='mobile') { $id = mobileToID($information, $connection);}
						if($informationType=='email')  { $id = emailToID($information, $connection); }
						if($informationType=='social') { $id = socialToID($information, $connection);}

						if ($id) {
						if($informationMode==1) { 
						if($informationType=='mobile') { 
                        if ($information == '919331024674' || $information == '919163942424' ||  $information == '919883124674') { 
                            
                        if ($information == '919331024674') { 
						$userInfo['id'] 	 = $id;
						$userInfo['otp'] 	= 1111;
							
/*
// send WA
						$sendWAURL = $sendWAURL;
						$fullWAData = array();
						$fullWAData['phoneNumber']        = '919331024674';
						$fullWAData['OTP']      	  	  = '1111';
						$WATemplate               		  = 'otpmessage';
						$WAcontent                        = urlExport($fullWAData);
						$entryID						  = 105486032380156;
						$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
						$content                          = file_get_contents($url);
						$result                           = json_decode($content, true);
*/
						deliver_response($userInfo);

}
						
                        elseif ($information == '919163942424') { 
						$userInfo['id'] 	 = $id;
                        $otp            	= 2222;
						$userInfo['otp'] 	= $otp;

                        //send SMS
                        $sendSMSURL = $SMSURL;
                        $fullSMSData = array();
                        $fullSMSData['SMSSender']          = 'CVDRGN';
                        $fullSMSData['countryCode']        = 91;
                        $fullSMSData['phoneNumber']        = $information;
                        $fullSMSData['SMSContent']
                            = 'Your OTP for cvDragon Login is ' . $otp . ' Team cvDragon';
                        $fullSMSData['route']               = '4';
                        $SMScontent                         = urlExport($fullSMSData);
                        $url                                 = $sendSMSURL . '?id=&authkey=&data=OTP&contents=' . $SMScontent;
						//echo $url;
                        $content                             = file_get_contents($url);
                        $result                             = json_decode($content, true);

                        deliver_response($userInfo);

}
						
                        elseif ($information == '919883124674') { 
						$userInfo['id'] 	 = $id;
						$userInfo['otp'] 	= 7827;
							
/*						// send WA
						$sendWAURL = $sendWAURL;
						$fullWAData = array();
						$fullWAData['phoneNumber']        = '919883124674';
						$fullWAData['OTP']      	  	  = '7827';
						$WATemplate               		  = 'otpmessage';
						$WAcontent                        = urlExport($fullWAData);
						$entryID						  = 105486032380156;
						$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
						$content                          = file_get_contents($url);
						$result                           = json_decode($content, true);
*/
						deliver_response($userInfo);

}
												
                       } else {
						
                        $otp            	= rand(1000, 9999);
						$userInfo['id'] 	 = $id;
						$userInfo['otp'] 	= $otp;

                        //send SMS
                        $sendSMSURL = $SMSURL;
                        $fullSMSData = array();
                        $fullSMSData['SMSSender']          = 'CVDRGN';
                        $fullSMSData['countryCode']        = 91;
                        $fullSMSData['phoneNumber']        = $information;
                        $fullSMSData['SMSContent']
                            = 'Your OTP for cvDragon Login is ' . $otp . ' Team cvDragon';
                        $fullSMSData['route']               = '4';
                        $SMScontent                         = urlExport($fullSMSData);
                        $url                                 = $sendSMSURL . '?id=&authkey=&data=OTP&contents=' . $SMScontent;
						//echo $url;
                        $content                             = file_get_contents($url);
                        $result                             = json_decode($content, true);
							
/*						// send WA
						$sendWAURL = $sendWAURL;
						$fullWAData = array();
						$fullWAData['phoneNumber']        = $information;
						$fullWAData['OTP']      	  	  = $otp;
						$WATemplate               		  = 'otpmessage';
						$WAcontent                        = urlExport($fullWAData);
						$entryID						  = 105486032380156;
						$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
						$content                          = file_get_contents($url);
						$result                           = json_decode($content, true);
	*/
                       // if ($result) { deliver_response($userInfo); } else {deliver_response(0);} 
                        deliver_response($userInfo);

    }
					   }
						if($informationType=='email') { 

                        $otp            	= rand(1000, 9999);
						$userInfo['id'] 	 = $id;
						$userInfo['otp'] 	= $otp;
						
                                    //send email
                                    $sendEmailURL = $emailURL;
                                    $emailSubject = "OTP to login to cvDragon Application";
                                    $emailContent = "
            <p>Hi, Please use the below OTP to Login to your cvDragon Application Account</p>
			<p style='font-size:1.5em;'>$otp</p>
            <br>
            <p>For any assistance, feel free to reach out to us: <a href='mailto:info@cvdragon.com'><strong>Email Us</strong><a> or WhatsApp us at <a href='wa.me/919883124674'><strong>9883124674</strong></a></p>

            <p>Team<br>cvDragon</p>
            ";


                                    $fullData = array();
                                    $fullData['email']              = $information;
                                    $fullData['emailSubject']       = $emailSubject;
                                    $fullData['emailContent']       = $emailContent;

                                    $contents             = urlExport($fullData);

                                    $url               = $sendEmailURL . '?id=' . $id . '&authkey=' . $authkey . '&data=custome&contents=' . $contents;
									$content             = file_get_contents($url);
                                    $result             = json_decode($content, true);

                        if ($result) { deliver_response($userInfo); } else {deliver_response(0);} 
						}
						if($informationType=='social') { 
						
						$userInfo['id'] = $id;
						deliver_response($userInfo);
						
						}
						} else { 
						
						$userInfo['id'] = $id;
						deliver_response($userInfo);
						}
 						} else { 
						
						if($informationType=='mobile') { 

                        $otp            	= rand(1000, 9999);
						$userInfo['id'] 	 = "0";
						$userInfo['otp'] 	= $otp;

                        //send SMS
                        $sendSMSURL = $SMSURL;
                        $fullSMSData = array();
                        $fullSMSData['SMSSender']          = 'CVDRGN';
                        $fullSMSData['countryCode']        = 91;
                        $fullSMSData['phoneNumber']        = $information;
                        $fullSMSData['SMSContent']
                            = 'Your OTP for cvDragon Login is ' . $otp . ' Team cvDragon';
                        $fullSMSData['route']               = '4';
                        $SMScontent                         = urlExport($fullSMSData);
                        $url                                 = $sendSMSURL . '?id=&authkey=&data=OTP&contents=' . $SMScontent;
                        $content                             = file_get_contents($url);
                        $result                             = json_decode($content, true);
/*
						// send WA
						$sendWAURL = $sendWAURL;
						$fullWAData = array();
						$fullWAData['phoneNumber']        = $information;
						$fullWAData['OTP']      	  	  = $otp;
						$WATemplate               		  = 'otpmessage';
						$WAcontent                        = urlExport($fullWAData);
						$entryID						  = 105486032380156;
						$url                              = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey='.$authkey.'&WATemplate='.$WATemplate.'&contents='.$WAcontent;
						$content                          = file_get_contents($url);
						$result                           = json_decode($content, true);
	*/	
                        deliver_response($userInfo);
				
                         } 
						if($informationType=='email') { 

                        $otp            	= rand(1000, 9999);
						$userInfo['id'] 	 = "0";
						$userInfo['otp'] 	= $otp;

                                    //send email
                                    $sendEmailURL = $emailURL;
                                    $emailSubject = "OTP to login to cvDragon Application";
                                    $emailContent = "
            <p>Hi, Please use the below OTP to connect your email address to your cvDragon Application Account</p>
			<p style='font-size:1.5em;'>$otp</p>
            <br>
            <p>For any assistance, feel free to reach out to us: <a href='mailto:info@cvdragon.com'><strong>Email Us</strong><a> or WhatsApp us at <a href='wa.me/919883124674'><strong>9883124674</strong></a></p>

            <p>Team<br>cvDragon</p>
            ";

                                    $fullData = array();
                                    $fullData['email']              = $information;
                                    $fullData['emailSubject']       = $emailSubject;
                                    $fullData['emailContent']       = $emailContent;

                                    $contents             = urlExport($fullData);

                                    $url               = $sendEmailURL . '?id=' . $id . '&authkey=' . $authkey . '&data=custome&contents=' . $contents;
									$content             = file_get_contents($url);
                                    $result             = json_decode($content, true);

                        deliver_response($userInfo);
						
                         } 
						if($informationType=='social') { 

						$userArray = array();
                        //all params
                        $id              = time() . rand(1, 10000);
                        $authkey         = md5(microtime() . rand());
                        $socialid        = $_GET['information'];
                        $socialType      = 5;
                        $playerID        = '';

                        $contents        = urlImport($_GET['contents']);
                        $fullName        = 'Your Name';
                        $emailAddressC    = '';
						if($emailAddressC=='') { $emailAddress = 'NULL'; } else { $emailAddress = "'".$emailAddressC."'";}

                        $affiliateID    = $_GET['affiliateID'];
                        $countryCode    = $_GET['countryCode'];
                        $phoneNumber    = $_GET['phoneNumber'];
						if($phoneNumber=='') { $userPhone = 'NULL'; } else { $userPhone = "'".$countryCode.$phoneNumber."'";}

                        $profileName    = 'First Profile';

                        if (1==1) {

                        $sections 	   = array("51099", "51100", "51101", "51102", "51103", "51106", "51108", "51109", "51110", "51111", "51114", "51118", "51119", "51120", "51121", "51123", "51122");

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
                                        status		 	= 1";

                                $qry = mysqli_query($connection, $sql);

                                if ($qry) {

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

									deliver_response($id);
                        }
						
						
														 } 
												 
											 } 
										 
										 
									}
                    break;

                case "updateBaseInformation": {


                        $information     = $_GET['information'];
                        $informationType = $_GET['informationType'];

						if($informationType=='mobile') {
						$informationWCC = substr($information,2);

                        $sql = "UPDATE `users` SET usermobile='".$information."', categoryid=1  WHERE id=$id and status=1 and categoryid=0";
                        $qry = mysqli_query($connection, $sql);

					//send WA
					$dataWA = IDtoUserMobileWATransactional($id,$connection);
					if($dataWA['status']=1) 
					{ 
					$sendWAURL 				   = $sendWAURL;
					$fullWAData 				  = array();
					$fullWAData['phoneNumber']   = $information;
					$fullWAData['userName']      = $dataWA['fullName'];
					$fullWAData['headerImage']   = 'https://cvdragon.com/data/facebook/resources/whycvDragon.jpg';
					$WATemplate               	  = 'welcomemessage';
					$WAcontent                   = urlExport($fullWAData);
					$entryID					 = 105486032380156;
					$url                         = $sendWAURL.'?entryID='.$entryID.'&id='.$id.'&authkey=1&WATemplate='.$WATemplate.'&contents='.$WAcontent;
					$content                     = file_get_contents($url);
					$result                      = json_decode($content, true);

					updatenotification($id,'ui_welcomemessage',1,$connection);

					}

						if($qry) { 
													 
                        $sql = "UPDATE `user-basic` SET phoneNumber=$informationWCC WHERE id=$id and status=1";
                        $qry = mysqli_query($connection, $sql);

						deliver_response(1); } 
						
						else { deliver_response(0); }
												
                         } 
						if($informationType=='email') { 

                        $sql = "UPDATE `users` SET userEmail='".$information."', categoryid=1  WHERE id=$id and status=1 and categoryid=0";
                        $qry = mysqli_query($connection, $sql);


                                //Send Email
								$fullName = getName($id,$connection);
                                $sendEmailURL = $emailURL;
                                $fullData = array();
                                $fullData['name'] = $fullName;
                                $fullData['email'] = $information;

                                $contents = urlExport($fullData);
                                $url = $sendEmailURL . '?id=' . $id . '&authkey=' . $authkey . '&data=registration&contents=' . $contents;
                                $content = file_get_contents($url);
                                $result = json_decode($content, true);


						if($qry) { 
													 
                        $sql = "UPDATE `user-basic` SET emailAddress='".$information."' WHERE id=$id and status=1";
                        $qry = mysqli_query($connection, $sql);

						deliver_response(1); } 
						
						else { deliver_response(0); }
						
                         } 
						if($informationType=='social') {

                        $sql = "UPDATE `users` SET socialid='".$information."', categoryid=1  WHERE id=$id and status=1 and categoryid=0";
                        $qry = mysqli_query($connection, $sql);

						if($qry) { deliver_response(1); } else { deliver_response(0); }
						
						 } 

                    }
                    break;
                case "myDocumentAdd": {
                        $contents     = urlImport($_GET['contents']);

                        $documentTitle	    = $contents['documentTitle'];
                        $documentLocation    = $contents['documentLocation'];
                        $documentSection    = $contents['documentSection'];
                        $documentSubSection    = $contents['documentSubSection'];
						
                        $sql     = "
                        INSERT INTO `user-documents` SET 
                        documentTitle		= '$documentTitle',
                        documentLocation	= '$documentLocation',
                        documentSection		= '$documentSection',
                        documentSubSection	= '$documentSubSection',
                        id					= $id,
                        date		= '$date',
                        status				= 1
                        ";
					    $qry = mysqli_query($connection, $sql);
                        deliver_response(1);
                    }
                    break;
                case "myDocuments": {

                        $array       = array();

                        $sql     = "SELECT * FROM `user-documents` where id ='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
						
						if (mysqli_num_rows($result) > 0) {
						
						while ($row = mysqli_fetch_assoc($result)) {
						array_push($array, $row);
						}
						deliver_response($array);
						} else {
						deliver_response($array);
						}
                    }
                    break;
                 case "myDocumentEdit": {
                        $contents     = urlImport($_GET['contents']);

                        $documentID	    = $_GET['documentID'];
                        $documentTitle	    = $contents['documentTitle'];
                        $documentLocation    = $contents['documentLocation'];
                        $documentSection    = $contents['documentSection'];
                        $documentSubSection    = $contents['documentSubSection'];
						
                        $sql     = "
                        UPDATE `user-documents` SET 
                        documentTitle		= '$documentTitle',
                        documentLocation	= '$documentLocation',
                        documentSection		= '$documentSection',
                        documentSubSection	= '$documentSubSection',
                        id					= $id,
                        date				= '$date',
                        status				= 1
						where 
						documentID			= $documentID
                        ";

                        $result = mysqli_query($connection, $sql);

                        if ($result) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;

                case "myDocumentDelete": {
                        $documentID	    = $_GET['documentID'];
						
                        $sql     = "
                        UPDATE `user-documents` SET 
                        status				= 0
						where 
						documentID			= $documentID
                        ";

                        $result = mysqli_query($connection, $sql);

                        if ($result) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
					
                case "myDocumentDeleteFile": {
                        $documentLocation	    = $_GET['documentLocation'];
						unlink($documentLocation);
                        deliver_response(1);
                    }
                    break;



                default: {
                    }
                    echo 'Default Content';
            }
        }
    }
}
