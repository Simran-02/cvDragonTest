<?php
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");

$allTables = ['kc-videos', 'kc-articles', 'kc-faq', 'kc-qna', 'kc-tips'];

$id              = isset($_GET['id'])          ? $_GET['id'] : '';
$authkey         = isset($_GET['authkey'])     ? $_GET['authkey'] : '';
$date           = isset($_GET['date'])       ? $_GET['date'] : '';
$kcID            = isset($_GET['kcID'])        ? $_GET['kcID'] : '';
$kcMain          = isset($_GET['category'])   ? $_GET['category'] : '';
$data            = isset($_GET['data'])        ? $_GET['data'] : '';

if ($id) {
    if ($authkey) {
        if (usercheck($id, $authkey, $connection)) {
            switch ($data) {

                case 'getFilterMainCategoryOptions':

                    $response = array();
                    //get Main Categories
                    $sql = "SELECT * FROM `resource-master-main-category` WHERE mainCategoryID IN (1,2,4)";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['mainCategories'] = $json;

                    deliver_response($response);


                    break;

                case 'getFilterSubCategoryOptions':
                    $mainCategoryID = $_GET['mainCategoryID'];

                    $response = array();
                    //get Sub Categories
                    if ($mainCategoryID == '4') {

                        $sql = "SELECT * FROM `resource-master-sub-category` WHERE mainCategoryID=$mainCategoryID AND subCategoryID=10 ";
                    } else {

                        $sql = "SELECT * FROM `resource-master-sub-category` WHERE mainCategoryID=$mainCategoryID ";
                    }
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['subCategories'] = $json;

                    deliver_response($response);


                    break;



                case 'getFilterMainOptions':
                    $subCategoryID = $_GET['subCategoryID'];
                    $mainCategoryID = $_GET['mainCategoryID'];

                    $response = array();
                    //get Master Categories
                    $sql = "SELECT * FROM `resource-master` WHERE subCategoryID=$subCategoryID and mainCategoryID=$mainCategoryID";
					$sql = "SELECT `resource-master`.* FROM `resource-master` INNER JOIN  `kc-main` ON `kc-main`.kcMasterID = `resource-master`.masterID  WHERE`resource-master`.subCategoryID=$subCategoryID and `resource-master`.mainCategoryID=$mainCategoryID and `kc-main`.isFeed=1";

                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    $response['mainOptions'] = $json;

                    deliver_response($response);


                    break;
            }
        }
    }
}
