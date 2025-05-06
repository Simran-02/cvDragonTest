<?php
session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");

//Get details from the url
$id            = isset($_GET['id'])         ? $_GET['id'] : '';
$authkey       = isset($_GET['authkey'])     ? $_GET['authkey'] : '';
$data          = isset($_GET['data'])         ? $_GET['data'] : '';
$publickey    = 'cvDragonPublicKey54321';
$date          = date("Y-m-d H:i:s");

if ($id) {
    if ($authkey) {
        if (usercheck($id, $authkey, $connection) || $authkey == $publickey) {
            switch ($data) {

                    //Get Help Videos Data

                case "allHelp": {

                        $allHelp = array();
                        $allSectionArray = array();
                        $sql     = "SELECT * FROM `help-videos` where  status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            $allHelp['help-videos'] = $allSectionArray;
                        }

                        //Get Help FAQ Data

                        $allSectionArray = array();
                        $sql     = "SELECT * FROM `help-faq` where  status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            $allHelp['help-faq'] = $allSectionArray;
                        }

                        //Get All Notifications Data

                        $allNotifications = array();
                        $sql     = "SELECT notificationID,displayImage FROM `notifications` where  status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allNotifications, $row);
                            }
                            $allHelp['notifications'] = $allSectionArray;
                            
                        }
					deliver_response($allHelp);
                    }
                    break;

                case "allResources": {
                        $allResources = array();
                        //get all public profile design resource-publicDesign
                        $allPublicProfileDesignArray = array();
                        $sql     = "SELECT * FROM `resource-publicDesign` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allPublicProfileDesignArray, $row);
                            }
                            $allResources['resource-publicDesign'] = $allPublicProfileDesignArray;
                        }


                        //Get All Section Data


                        $allSectionArray = array();
                        $sql     = "SELECT section, defaultSection, sectionContentApp,sectionInfoApp, sectionDefaultContent, sectionName, orderSection FROM `resource-section` where main=1 AND status=1";
                        // $sql     = "SELECT * FROM `resource-section` where main=1 AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allSectionArray, $row);
                            }
                            $allResources['resource-section'] = $allSectionArray;
                        }
                        //Get All Design Data

                        $allDesignArray = array();
                        $sql     = "SELECT * FROM `resource-profiledesign` where status=1 and app=1 and version like '%7%'";

                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allDesignArray, $row);
                            }
                            $allResources['resource-profiledesign'] = $allDesignArray;
                        }

                        //Get All ProfileSettings Data

                        $allProfileSettingsArray = array();
                        $sql     = "SELECT * FROM `resource-profilesetting` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allProfileSettingsArray, $row);
                            }
                            $allResources['resource-profilesetting'] = $allProfileSettingsArray;
                        }

                        //Get All Fonts Data

                        $allProfileFontsArray = array();
                        $sql     = "SELECT * FROM `resource-profilefont` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($allProfileFontsArray, $row);
                            }
                            $allResources['resource-profilefont'] = $allProfileFontsArray;
                        }

                        //Get All Tips Data

                        $TipArray = array();
                        $sql     = "SELECT * FROM `resource-tips` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TipArray, $row);
                            }
                            $allResources['resource-tips'] = $TipArray;
                        }
                        //Get All FAQs Data

                        $FAQArray = array();
                        $sql     = "SELECT * FROM `resource-faqs` where status=1";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($FAQArray, $row);
                            }
                            $allResources['resource-faqs'] = $FAQArray;
                        }
                        //Get All Key Phrases Data
                        $keyPhrasesArray = array();
                        $sql     = "SELECT * FROM `resource-all` WHERE status=1 ORDER BY keyitem ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($keyPhrasesArray, $row);
                            }
                            $allResources['resource-all'] = $keyPhrasesArray;
                            deliver_response($allResources);
                        }
                    }
                    break;

                case "allServices": {
                        //Get All Services Data

                        $allServices = array();
                        $TipArray = array();
                        $sql     = "SELECT * FROM `resource-servicesNew` where status=1 and app=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TipArray, $row);
                            }
                            $allServices['resource-services'] = $TipArray;
                        }
                        //Get All Upcoming Services Data

                        $TipArray = array();
                        $sql     = "SELECT * FROM `resource-upcomingFeatures` where status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($TipArray, $row);
                            }
                            $allServices['resource-upcomingFeatures'] = $TipArray;
                            deliver_response($allServices);
                        }
                    }
                    break;
                case "myAllData": {

                        $myAllData = array();
                        $sectionArray = array();
                        $sql     = "SELECT * FROM `create-cvsection` WHERE id ='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($sectionArray, $row);
                            }
                            $myAllData['create-cvsection'] = $sectionArray;
                        } else {
                            $myAllData['create-cvsection'] = array();
                        }



                        $ProfileArray = array();
                        $sql     = "SELECT * FROM `create-cvprofilesection` where id='" . $id . "' AND status=1";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProfileArray, $row);
                            }
                            $myAllData['create-cvprofilesection'] = $ProfileArray;
                        } else {
                            $myAllData['create-cvprofilesection'] = array();
                        }

                        $ProfileArray = array();
                        $sql     = "SELECT * FROM `create-cvprofile` where id='" . $id . "' AND status=1 ORDER BY dateUpdated";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($ProfileArray, $row);
                            }
                            $myAllData['create-cvprofile'] = $ProfileArray;
                        } else {
                            $myAllData['create-cvprofile'] = array();
                        }
                        deliver_response($myAllData);
                    }
                    break;


                default: {
                    }
                    echo 'Default Content';
            }
        }
    }
}
