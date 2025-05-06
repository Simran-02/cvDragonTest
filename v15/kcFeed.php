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

                case 'getFeed':
                    $hideData = "(20,23,24,25,26,27,28,1,16,18,33,34)";
					$limit = isset($_GET['limit'])   ? $_GET['limit'] : 10;
                    $offset = isset($_GET['offset'])   ? $_GET['offset'] : 0;
                    $postType = isset($_GET['postType'])   ? $_GET['postType'] : 0;
                    $sortFilter = isset($_GET['sortFilter'])   ? $_GET['sortFilter'] : 1;
                    $sql = "SELECT  `kc-feed`.*,`kc-creators`.creatorName,`kc-creators`.creatorImage,  `kc-favorites`.`status` as liked FROM `kc-feed` LEFT JOIN `kc-favorites` ON `kc-feed`.`feedID`=`kc-favorites`.`feedID` AND `kc-favorites`.`id`=$id JOIN `kc-creators` ON `kc-creators`.id=`kc-feed`.postPostedBy WHERE `kc-feed`.status=1 AND `kc-feed`.postType NOT IN $hideData ";
                    if ($postType != 0) {
                        $sql = $sql . " AND  `kc-feed`.postType=$postType ";
                    }
                    if ($sortFilter == 1) {
                        $sql = $sql . "ORDER BY `kc-feed`.`postUploadDate` DESC LIMIT $limit OFFSET $offset";
                    } else {
                        $sql = $sql . "ORDER BY `kc-feed`.`postLikes` DESC LIMIT $limit OFFSET $offset";
                    }


                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);
                    break;

                case 'getMyFavouritePosts':
                    $offset = isset($_GET['offset'])   ? $_GET['offset'] : 0;
                    $limit = isset($_GET['limit'])   ? $_GET['limit'] : 10;
                    $sql = "SELECT `kc-feed`.*,`kc-creators`.creatorName,`kc-creators`.creatorImage FROM `kc-feed`  JOIN `kc-favorites` ON `kc-feed`.`feedID`=`kc-favorites`.`feedID` AND `kc-favorites`.`id`=$id JOIN `kc-creators` ON `kc-creators`.id=`kc-feed`.postPostedBy WHERE `kc-feed`.status=1 ORDER BY `kc-feed`.`postUploadDate` DESC LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);
                    break;


                case 'markFavourite':
                    $feedid = $_GET['feedid'];
                    $sql = "INSERT INTO `kc-favorites` SET feedID=$feedid,id=$id,status=1 ";
                    $result = mysqli_query($connection, $sql);
                    deliver_response(1);
                    break;


                case 'markUnFavourite':
                    $feedid = $_GET['feedid'];
                    $sql = "DELETE FROM `kc-favorites` WHERE feedID=$feedid AND id=$id";
                    $result = mysqli_query($connection, $sql);
                    deliver_response(1);
                    break;


                case 'sharePost':
                    $feedid = $_GET['feedid'];
                    $sql = "INSERT INTO `kc-shares` SET feedID=$feedid,id=$id,status=1 ";
                    $result = mysqli_query($connection, $sql);
                    deliver_response(1);
                    break;

                case 'getPostDetails':
                    $postID = isset($_GET['postID'])   ? $_GET['postID'] : 0;
                    $sql = "SELECT * FROM `kc-feed-main` WHERE postID=$postID and status=1";

                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);


                    break;

                case 'getFeedDetails':
                    $postID = isset($_GET['postID'])   ? $_GET['postID'] : 0;

                    $sql = "SELECT  `kc-feed`.*,`kc-creators`.creatorName,`kc-creators`.creatorImage,  `kc-favorites`.`status` as liked FROM `kc-feed` LEFT JOIN `kc-favorites` ON `kc-feed`.`feedID`=`kc-favorites`.`feedID` AND `kc-favorites`.`id`=$id JOIN `kc-creators` ON `kc-creators`.id=`kc-feed`.postPostedBy WHERE `kc-feed`.status=1 AND postID=$postID";

                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);


                    break;


                case 'getCustomizedFeed':
                    // Takes raw data from the request
                    $json = file_get_contents('php://input');

                    // Converts it into a PHP object
                    $data = json_decode($json);


                    $postEducationProfiles = $data->postEducationProfiles;
                    $postWorkProfiles = $data->postWorkProfiles;
                    $postSections =  $data->postSections;
                    $postType = $data->postType;


                    $offset = isset($_GET['offset'])   ? $_GET['offset'] : 0;
                    $limit = isset($_GET['limit'])   ? $_GET['limit'] : 10;

                    // $sql = "SELECT `kc-feed`.*, `kc-favorites`.`status` as liked FROM `kc-feed` LEFT JOIN `kc-favorites` ON `kc-feed`.`feedID`=`kc-favorites`.`feedID` AND `kc-favorites`.`id`=$id WHERE `kc-feed`.status=1";

                    $sql = "SELECT DISTINCT `kc-feed`.*,`kc-creators`.creatorName,`kc-creators`.creatorImage, `kc-favorites`.`status` as liked FROM `kc-feed` LEFT JOIN `kc-feed-educational-profiles` ON `kc-feed-educational-profiles`.`feedID`=`kc-feed`.`feedID`LEFT JOIN `kc-feed-work-profiles` ON `kc-feed-work-profiles`.`feedID`=`kc-feed`.`feedID`LEFT JOIN `kc-feed-sections` ON `kc-feed-sections`.`feedID`=`kc-feed`.`feedID` LEFT JOIN `kc-favorites` ON `kc-feed`.`feedID`=`kc-favorites`.`feedID` AND `kc-favorites`.`id`=1 JOIN `kc-creators` ON `kc-creators`.id=`kc-feed`.postPostedBy WHERE `kc-feed`.status=1   ";


                    if ($postEducationProfiles != '') {
                        $sql = $sql . " AND `kc-feed-educational-profiles`.`educationalProfileID` IN  ($postEducationProfiles) ";
                    }
                    if ($postSections != '') {
                        $sql = $sql . " AND `kc-feed-sections`.`sectionID` IN  ($postSections) ";
                    }
                    if ($postWorkProfiles != '') {
                        $sql = $sql . " AND `kc-feed-work-profiles`.`workProfileID` IN  ($postWorkProfiles) ";
                    }
                    if ($postType != null) {
                        $sql = $sql . " AND (postType IN ($postType)) ";
                    }

                    $sqlDate = " ORDER BY `kc-feed`.`postUploadDate` DESC LIMIT $limit OFFSET $offset";
                    $sql = $sql . $sqlDate;

                    echo $sql;

                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);


                    break;


                case 'getFilteredData':
                    $contents = $_GET['contents'];
                    $contents = json_decode($contents);
                    $limit = isset($_GET['limit'])   ? $_GET['limit'] : 10;
                    $offset = isset($_GET['offset'])   ? $_GET['offset'] : 0;
                    $postType = isset($_GET['postType'])   ? $_GET['postType'] : 0;

                    $sortFilter = isset($_GET['sortFilter'])   ? $_GET['sortFilter'] : 1;
                    $convertedData = implode(', ', $contents);


                    $sql = "SELECT DISTINCT `kc-feed`.*,`kc-creators`.creatorName,`kc-creators`.creatorImage, `kc-favorites`.`status` as liked FROM `kc-feed` JOIN `kc-feed-master-relation`  ON `kc-feed-master-relation`.`feedID`=`kc-feed`.`feedID`     LEFT JOIN `kc-favorites` ON `kc-feed`.`feedID`=`kc-favorites`.`feedID` AND `kc-favorites`.`id`=$id JOIN `kc-creators` ON `kc-creators`.id=`kc-feed`.postPostedBy WHERE `kc-feed-master-relation`.masterID IN ($convertedData) AND `kc-feed`.`status`=1  ";


                    if ($postType != 0) {
                        $sql = $sql . "AND `kc-feed`.`postType`= $postType";
                    }
                    if ($sortFilter == 1) {
                        $sql = $sql . " ORDER BY `kc-feed`.`postUploadDate` DESC LIMIT $limit OFFSET $offset";
                    } else {
                        $sql = $sql . " ORDER BY `kc-feed`.`postLikes` DESC LIMIT $limit OFFSET $offset";
                    }

//echo $sql;
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);



                    break;

                case 'getFeedCategories':

                    $sql = "SELECT * FROM `kc-main` WHERE status=1";


                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);
                    break;


                case 'getGuideCategories':
                    $sql = "SELECT * FROM `kc-main` WHERE status=1 and isGuide=1";


                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);
                    break;



                case 'getGalleryImages':
                    $postID = $_GET['postID'];

                    $sql = "SELECT * FROM `kc-feed-gallery` WHERE postID=$postID and status=1";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);
                    break;

                case 'getInterviewAnswers':
                    $postID = $_GET['postID'];

                    $sql = "SELECT * FROM `kc-feed-interview-qna` WHERE postID=$postID and status=1";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);
                    break;
            }
        }
    }
}
