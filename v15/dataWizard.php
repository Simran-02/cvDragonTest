<?php
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");

$allTables = ['kc-videos', 'kc-articles', 'kc-faq', 'kc-qna', 'kc-tips'];

$id              = isset($_GET['id'])          ? $_GET['id'] : '';
$authkey         = isset($_GET['authkey'])     ? $_GET['authkey'] : '';
$date           = isset($_GET['date'])       ? $_GET['date'] : '';
$data            = isset($_GET['data'])        ? $_GET['data'] : '';

if ($id) {
    if ($authkey) {
        if (usercheck($id, $authkey, $connection)) {
            switch ($data) {

                case 'getTop100Data':

                    $response = array();
                    //Get Soft Skills
                    $sql = "SELECT * FROM `resource-master` WHERE subCategoryID=5 ORDER BY masterUsed DESC LIMIT 100 ";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['softSkills'] = $json;

                    //Get Technical Skills
                    $sql = "SELECT * FROM `resource-master` WHERE subCategoryID=6 ORDER BY masterUsed DESC LIMIT 100";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['technicalSkills'] = $json;
                    //Get Interests

                    $sql = "SELECT * FROM `resource-master` WHERE subCategoryID=8 ORDER BY masterUsed DESC LIMIT 100";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['interests'] = $json;

                    //Get Languages

                    $sql = "SELECT * FROM `resource-master` WHERE subCategoryID=9 ORDER BY masterUsed DESC LIMIT 100";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['languages'] = $json;

                    deliver_response($response);


                    break;

                case "getProfileBasedData":

                    $educationalProfile = isset($_GET['educationalProfile']) ? $_GET['educationalProfile'] : 0;
                    $workProfile = isset($_GET['workProfile']) ? $_GET['workProfile'] : 0;

                    $response = array();

                    $sql = "SELECT DISTINCT master.* FROM `resource-mapping-master` as mapping JOIN `resource-master` AS master ON master.masterID=mapping.masterIDSecond WHERE mappingCategory IN (1,2) AND masterIDFirst IN ($educationalProfile,$workProfile) AND master.subCategoryID=5 ORDER BY master.masterUsed DESC";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['softSkills'] = $json;

                    $sql = "SELECT DISTINCT master.* FROM `resource-mapping-master` as mapping JOIN `resource-master` AS master ON master.masterID=mapping.masterIDSecond WHERE mappingCategory IN (1,2) AND masterIDFirst IN ($educationalProfile,$workProfile) AND master.subCategoryID=6 ORDER BY master.masterUsed DESC";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['technicalSkills'] = $json;



                    deliver_response($response);
                    break;

                case 'getTop100JD':

                    $response = array();
                    //Get Soft Skills
                    $sql = "SELECT * FROM `resource-master` WHERE subCategoryID=11 ORDER BY masterUsed DESC LIMIT 100 ";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['JD'] = $json;



                    deliver_response($response);


                    break;

                case "getProfileBasedJD":
                    $workProfile = isset($_GET['workProfile']) ? $_GET['workProfile'] : 0;

                    $response = array();

                    $sql = "SELECT DISTINCT master.* FROM `resource-mapping-master` as mapping JOIN `resource-master` AS master ON master.masterID=mapping.masterIDSecond WHERE mappingCategory IN (3) AND masterIDFirst IN ($workProfile) AND master.subCategoryID=11 ORDER BY master.masterUsed DESC";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['JD'] = $json;
                    deliver_response($response);
                    break;


                case 'getProfiles':

                    $response = array();
                    //Get Educational Profiles
                    $sql = "SELECT * FROM `resource-master-sub-category` WHERE mainCategoryID IN (1,5,6)";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['educationalProfiles'] = $json;

                    //Get Work Profiles
                    $sql = "SELECT * FROM `resource-master-sub-category` WHERE mainCategoryID=2";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['workProfiles'] = $json;


                    deliver_response($response);


                    break;

                case 'getSpecializations':
                    $subCategoryID = $_GET['subCategoryID'];

                    $response = array();
                    //Get Specializations
                    $sql = "SELECT * FROM `resource-master` WHERE subCategoryID=$subCategoryID";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['specializations'] = $json;


                    deliver_response($response);


                    break;
                case 'getSearchBasedSpecializations':
                    $searchTerm              = isset($_GET['searchTerm'])          ? $_GET['searchTerm'] : '';

                    $response = array();
                    if ($searchTerm != '') {
                        //Get Specializations

                        $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID=2 AND master.masterName LIKE '%$searchTerm%'";

                        $result = mysqli_query($connection, $sql);
                        $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        if ($json == null) {
                            $json = array();
                        }
                        $response['specializations'] = $json;


                        deliver_response($response);
                    } else {
                        deliver_response($response);
                    }

                    break;


                case 'getSearchAndCategoryBasedKeyPhrases':
                    $searchTerm              = isset($_GET['searchTerm'])          ? $_GET['searchTerm'] : '';
                    $mainCategoryID              = isset($_GET['mainCategoryID'])          ? $_GET['mainCategoryID'] : '';
                    $subCategoryID              = isset($_GET['subCategoryID'])          ? $_GET['subCategoryID'] : '';

                    $response = array();
                    if ($searchTerm == '' & $subCategoryID == 0 &  $mainCategoryID == 0) {
                        //Get Specializations

                        $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID IN (1,2) ";
                    } else if ($searchTerm != '' & $subCategoryID == 0 &  $mainCategoryID == 0) {
                        //Get Specializations

                        $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID IN (1,2) AND (sub.subCategoryName LIKE '%$searchTerm%' OR masterName LIKE '%$searchTerm%' OR masterSearchRefrence LIKE '%$searchTerm%' OR subCategorySearchRefrence LIKE '%$searchTerm%'  )";
                    } else if ($searchTerm != '' & $subCategoryID != 0) {
                        //Get Specializations

                        $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID=$mainCategoryID AND master.subCategoryID=$subCategoryID AND (master.masterName LIKE '%$searchTerm%' OR masterSearchRefrence LIKE '%$searchTerm%' )";
                    } else if ($searchTerm != '' & $subCategoryID == 0) {
                        //Get Specializations
                        if ($mainCategoryID == 5) {
                            $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID IN (5,6)  AND (sub.subCategoryName LIKE '%$searchTerm%' OR masterName LIKE '%$searchTerm%')";
                        } else {
                            $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID=$mainCategoryID  AND (sub.subCategoryName LIKE '%$searchTerm%' OR masterName LIKE '%$searchTerm%' OR masterSearchRefrence LIKE '%$searchTerm%' OR subCategorySearchRefrence LIKE '%$searchTerm%'  )";
                        }
                    } else if ($searchTerm == '' & $subCategoryID == 0) {
                        //Get Specializations
                        if ($mainCategoryID == 5) {

                            $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID IN (5,6) ORDER BY master.masterUsed DESC LIMIT 50";
                        } else {

                            $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID=$mainCategoryID ORDER BY master.masterUsed DESC LIMIT 50";
                        }
                    } else {
                        //Get Specializations

                        $sql = "SELECT masterID,subCategoryName,masterName FROM `resource-master` as master JOIN `resource-master-sub-category` as sub ON master.subCategoryID=sub.subCategoryID  WHERE master.mainCategoryID=$mainCategoryID AND master.subCategoryID=$subCategoryID ORDER BY master.masterUsed DESC LIMIT 50";
                    }
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['keyphrases'] = $json;
                    deliver_response($response);

                    break;


                case 'updateUserWizardData':
                    $wizardProfile = isset($_GET['wizardProfile'])   ? $_GET['wizardProfile'] : 0;

                    $wizardWorkExp = isset($_GET['wizardWorkExp'])   ? $_GET['wizardWorkExp'] : 0;

                    $contents = json_decode($_GET['wizardContents']);
                    $wizardEducationProfile = $contents->wizardEducationProfile;
                    $wizardWorkProfile = $contents->wizardWorkProfile;
                    $wizardEducationSpecialization = $contents->wizardEducationSpecialization;
                    $wizardWorkSpecialization = $contents->wizardWorkSpecialization;




                    $sql = "UPDATE `user-basic` SET wizardProfile=$wizardProfile,
                            wizardWorkExp=$wizardWorkExp,
                            wizardEducationProfile='$wizardEducationProfile',
                            wizardWorkProfile='$wizardWorkProfile',
                            showWizard=1,
                            wizardEducationSpecialization='$wizardEducationSpecialization',
                            wizardWorkSpecialization='$wizardWorkSpecialization' WHERE id=$id";
                    $result = mysqli_query($connection, $sql);
                    deliver_response(1);

                    break;



                case 'updateUserWizardBasicData':

                    $wizardDOB = isset($_GET['wizardDOB'])   ? $_GET['wizardDOB'] : '0000-00-00';
                    $wizardGender = isset($_GET['wizardGender'])   ? $_GET['wizardGender'] : '';
                    $wizardContactNumber = isset($_GET['wizardContactNumber'])   ? $_GET['wizardContactNumber'] : 0;
                    $wizardEmail = isset($_GET['wizardEmail'])   ? $_GET['wizardEmail'] : 0;

                    $sql = "UPDATE `cv-contact` SET phoneNumber='$wizardContactNumber',
                                emailAddress='$wizardEmail' WHERE id=$id";


                    $result = mysqli_query($connection, $sql);

                    $sql = "UPDATE `cv-basic-info` SET dateBirth='$wizardDOB',
                                gender='$wizardGender' WHERE id=$id";
                    $result = mysqli_query($connection, $sql);

                    deliver_response(1);
                    break;
            }
        }
    }
}
