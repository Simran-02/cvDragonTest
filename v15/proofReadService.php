<?php
session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");
include("globals.php");
header("Content-Type:application/json");

//Get details from the url
$id            = (isset($_GET['id']))         ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
$authkey       = isset($_GET['authkey'])     ? $_GET['authkey'] : (isset($_POST['authkey']) ? $_POST['authkey'] : '');
$data          = isset($_GET['data'])         ? $_GET['data'] : (isset($_POST['data']) ? $_POST['data'] : '');
$publickey    = 'cvDragonPublicKey54321';
$date          = date("Y-m-d H:i:s");

if ($id) {
    if ($authkey) {
        if (usercheck($id, $authkey, $connection) || $authkey == $publickey) {
            switch ($data) {
                case "sendProofReadDatatoServer": {

                        $proofReadData = ($_POST['proofReadData']);
                        $userID = $_POST['userID'];
                        //creating subscription
                        $proofReadData = urlencode($proofReadData);
                        $sql = "INSERT INTO `proofReadData` SET  id = $userID,data = '$proofReadData'";
                        $qry                 = mysqli_query($connection, $sql);
                        deliver_response(1);
                    }
                    break;

                case "getProofReadDataFromServer": {
                        //creating subscription
                        $sql = "SELECT * FROM  `proofReadData` WHERE id=$id AND usedStatus=0 AND status=1 ORDER BY dateCreated DESC LIMIT 1";
                        $qry                 = mysqli_query($connection, $sql);
                        $json = mysqli_fetch_all($qry, MYSQLI_ASSOC);

                        if ($json == null) {
                            $json = array();
                            deliver_response($json);
                            // $json[0] = array();
                            // $json[0]['design'] = "99999";
                            // $json[0]['expiry'] = "2020-12-31";

                        } else {
                            $dataString = urldecode($json[0]['data']);
                            $array = json_decode($dataString);
                            deliver_response($array);
                        }
                    }
                    break;

                case "requestProofRead": {
                        $cvid = $_GET['cvid'];
                        // https: //cvdragon.com/directlogin/15947313604466/42cf7bad94f0032bd0c07b81793f04d5
                        // https: //cvdragon.com/data/app/v2/appResourceAPI.php?id=15947313604466&authkey=42cf7bad94f0032bd0c07b81793f04d5&data=allSectionDetails

                        $url                                 = "https://cvdragon.com/data/app/v2/appResourceAPI.php?id=$id&authkey=$authkey&data=allSectionDetails";
                        $content1                             = file_get_contents($url);
                        $allSectionData                             = json_decode($content, true);


                        // https: //cvdragon.com/data/app/v2/appResourceAPI.php?id=15947313604466&authkey=42cf7bad94f0032bd0c07b81793f04d5&data=userCompulsoryData&cvid=12084
                        $url                                 = "https://cvdragon.com/data/app/v2/appResourceAPI.php?id=$id&authkey=$authkey&data=userCompulsoryData&cvid=12084";
                        $content2                           = file_get_contents($url);
                        $userCompulsoryData                          = json_decode($content, true);


                        $url                                 = "http://35.154.154.227:80?id=$id&authkey=$authkey&cvid=$cvid";
                        $content3                           = file_get_contents($url);
                        print_r($content3);
                    }
                    break;

                case "accept_change": {
                        $tableName = $_GET['tableName'];
                        $newData = $_GET['newData'];
                        $idColumn = $_GET['idColumn'];
                        $idData = $_GET['idData'];
                        $dataColumn = $_GET['dataColumn'];
                        $sql = "UPDATE `$tableName` SET  $dataColumn = '$newData' WHERE $idColumn=$idData";
                        $qry                 = mysqli_query($connection, $sql);
                        deliver_response(1);
                    }
                    break;

                case "reject_change": {
                        $tableName = $_GET['tableName'];
                        $oldData = $_GET['oldData'];
                        $newData = $_GET['newData'];
                        $sql = "INSERT INTO proofReadRejectData SET id=$id,rejectTable='$tableName', rejectOld='$oldData', rejectNew='$newData' ";
                        $qry                 = mysqli_query($connection, $sql);
                        deliver_response(1);
                    }
                    break;


                case "complete_proofread": {
                        $proofReadID = $_GET['proofReadID'];
                        $sql = "UPDATE `proofReadData` SET  usedStatus = 1 WHERE proofReadID=$proofReadID";
                        $qry                 = mysqli_query($connection, $sql);
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
