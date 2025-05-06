<?php
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");


$id              = isset($_GET['id'])          ? $_GET['id'] : '';
$authkey         = isset($_GET['authkey'])     ? $_GET['authkey'] : '';
$data            = isset($_GET['data'])        ? $_GET['data'] : '';

if ($id) {
    if ($authkey) {
        if (usercheck($id, $authkey, $connection)) {
            switch ($data) {

                case 'getRecommendationCategories':

                    $response = array();
                    $sql = "SELECT * FROM `correction-category` WHERE status=1";
                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {
                        $json = array();
                    }
                    deliver_response($json);
                    break;
                case 'getCorretionCount':
                    $response = array();

                    $sql = "SELECT correctionID FROM `correction-main` as main WHERE main.status=1 AND main.correctionExecuted=0 AND id=$id ";
                    $result = mysqli_query($connection, $sql);
                    $response['nonEexcuted'] = mysqli_num_rows($result);
                    $sql = "SELECT correctionID FROM `correction-main` as main WHERE main.status=1 AND id=$id ";
                    $result = mysqli_query($connection, $sql);
                    $response['total'] = mysqli_num_rows($result);
                    deliver_response($response);

                    break;


                case 'getCorretions':
                    $response = array();
                    $sectionID              = isset($_GET['sectionID'])          ? $_GET['sectionID'] : '';
                    $category              = isset($_GET['category'])          ? $_GET['category'] : '0';
                    $executed              = isset($_GET['executed'])          ? $_GET['executed'] : '0';

                    $sql = "SELECT main.correctionID, main.correctionSectionID,section.sectionName,main.correctionCustomDescription,main.correctionRefrence,main.correctionIndex,main.correctionHTML, main.correctionColumn,main.correctionTableID, main.correctionOldStatement, main.correctionNewStatement, main.correctionDate ,category.categoryName,main.correctionCategory,  main.correctionQueryCategory,  status.statusName, description.description FROM `correction-main` as main JOIN `correction-category` as category JOIN `correction-status` as status JOIN `correction-description` as description JOIN `resource-section`  as section ON main.correctionSectionID=section.section AND main.correctionCategory=category.categoryID AND main.correctionStatus=status.statusID AND main.correctionDescription=description.descriptionID   WHERE main.status=1 AND main.correctionExecuted=$executed AND id=$id ";

                    if ($sectionID != "0") {
                        $sql = $sql . "AND main.correctionSectionID=$sectionID";
                    }
                    if ($category != "0") {
                        $sql = $sql . "AND main.correctionCategory=$category";
                    }

                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    if ($json == null) {

                        $json = array();
                        deliver_response($json);
                    } else {
                        $responseJson = array();
                        foreach ($json as $value) {
                            if ($value['correctionRefrence'] == 1) {
                                $sql = "SELECT * FROM `correction-references` WHERE correctionID = " . $value['correctionID'];
                                $result = mysqli_query($connection, $sql);
                                $refrences = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                $value['refrenceValues'] = $refrences;
                            } else {
                                $value['refrenceValues'] = array();
                            }

                            if ($value['correctionIndex'] == 1) {
                                $sql = "SELECT * FROM `correction-proofread-indexing` WHERE correctionID = " . $value['correctionID'] . " ORDER BY startIndex ASC";
                                $result = mysqli_query($connection, $sql);
                                $refrences = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                $value['indexValues'] = $refrences;
                            } else {
                                $value['indexValues'] = array();
                            }

                            array_push($responseJson, $value);
                            # code...
                        }
                        deliver_response($responseJson);
                    }


                    break;
                case 'executeCorrectionMobile':
                    $response = array();
                    $correctionID   = isset($_GET['correctionID'])          ? $_GET['correctionID'] : '';

                    $sql = "SELECT * FROM   `correction-main` as main JOIN  `resource-section`  as section ON main.correctionSectionID=section.section WHERE main.status=1 AND main.correctionExecuted=0 AND id=$id  AND main.correctionID =$correctionID";

                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    if ($json != null) {
                        $data = $json[0];
                        $finalQuery = "UPDATE `correction-main` SET correctionExecuted=1 , correctionStatus=1 WHERE id=$id AND correctionID=$correctionID ";
                        $res = mysqli_query($connection, $finalQuery);
                        if ($res) {
                            deliver_response(1);
                        } else {
                            deliver_response(3);
                        }
                    } else {
                        deliver_response(4);
                    }
                    break;


                case 'executeCorrection':
                    $response = array();
                    $correctionID              = isset($_GET['correctionID'])          ? $_GET['correctionID'] : '';

                    $sql = "SELECT * FROM   `correction-main` as main JOIN  `resource-section`  as section ON main.correctionSectionID=section.section WHERE main.status=1 AND main.correctionExecuted=0 AND id=$id  AND main.correctionID =$correctionID";

                    $result = mysqli_query($connection, $sql);
                    $json = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    if ($json != null) {
                        $data = $json[0];
                        if ($data['correctionCategory'] == 5) {
                            $finalQuery = "UPDATE `correction-main` SET correctionExecuted=1 , correctionStatus=1 WHERE id=$id AND correctionID=$correctionID ";
                            $res = mysqli_query($connection, $finalQuery);
                            if ($res) {
                                deliver_response(1);
                                //make web login flag 1
                            } else {
                                deliver_response(3);
                            }
                        } else {

                            if ($data['correctionQueryCategory'] == 2) {
                                //update
                                //check if the same data is present
                                $sql = "SELECT * FROM `" . $data["sectionTable"] . "` WHERE " . $data["correctionColumn"] . " = '" . $data["correctionOldStatement"] . "' AND " . $data["idColumnName"] . " = '" . $data["correctionTableID"] . "'  AND id=$id AND status=1 ";
                                $oldData = mysqli_query($connection, $sql);
                                if (mysqli_num_rows($oldData) == 1) {
                                    $updateSQL = "UPDATE  `" . $data["sectionTable"] . "` SET " . $data["correctionColumn"] . " = '" . $data["correctionNewStatement"] .
                                        "' WHERE " . $data["idColumnName"] . " = '" . $data["correctionTableID"] . "'  AND id=$id AND status=1 ";
                                    //run update sql
                                    $res = mysqli_query($connection, $updateSQL);

                                    if ($res) {
                                        $finalQuery = "UPDATE `correction-main` SET correctionExecuted=1 , correctionStatus=1 WHERE id=$id AND correctionID=$correctionID ";
                                        $res = mysqli_query($connection, $finalQuery);
                                        if ($res) {
                                            deliver_response(1);
                                            //make web login flag 1
                                        } else {
                                            deliver_response(3);
                                        }
                                    } else {
                                        deliver_response(2);
                                    }
                                } else {
                                    deliver_response(0);
                                }
                            }
                            if ($data['correctionQueryCategory'] == 3) {
                                //delete
                                //check if the same data is present
                                $finalQuery = "UPDATE `correction-main` SET correctionExecuted=1 , correctionStatus=1 WHERE id=$id AND correctionID=$correctionID ";
                                $res = mysqli_query($connection, $finalQuery);
                                if ($res) {
                                    deliver_response(1);
                                    //make web login flag 1
                                } else {
                                    deliver_response(3);
                                }
                            }
                            if ($data['correctionQueryCategory'] == 1) {
                                //insert
                                //check if the same data is present
                                $sql = "SELECT * FROM `" . $data["sectionTable"] . "` WHERE " . $data["correctionColumn"] . " = '" . $data["correctionOldStatement"] . "' AND " . $data["idColumnName"] . " = '" . $data["correctionTableID"] . "'  AND id=$id AND status=1 ";
                                $oldData = mysqli_query($connection, $sql);
                                if (mysqli_num_rows($oldData) == 1) {
                                    $updateSQL = "UPDATE  `" . $data["sectionTable"] . "` SET " . $data["correctionColumn"] . " = '" . $data["correctionNewStatement"] .
                                        "' WHERE " . $data["idColumnName"] . " = '" . $data["correctionTableID"] . "'  AND id=$id AND status=1 ";
                                    //run update sql
                                    $res = mysqli_query($connection, $updateSQL);

                                    if ($res) {
                                        $finalQuery = "UPDATE `correction-main` SET correctionExecuted=1 , correctionStatus=1 WHERE id=$id AND correctionID=$correctionID ";
                                        $res = mysqli_query($connection, $finalQuery);
                                        if ($res) {
                                            deliver_response(1);
                                            //make web login flag 1
                                        } else {
                                            deliver_response(3);
                                        }
                                    } else {
                                        deliver_response(2);
                                    }
                                } else {
                                    deliver_response(0);
                                }
                            }
                        }
                    } else {
                        deliver_response(4);
                    }
                    break;
                case 'rejectCorrection':
                    $response = array();
                    $correctionID              = isset($_GET['correctionID'])          ? $_GET['correctionID'] : '';

                    $finalQuery = "UPDATE `correction-main` SET correctionExecuted=1 , correctionStatus=2 WHERE id=$id AND correctionID=$correctionID ";
                    $res = mysqli_query($connection, $finalQuery);
                    if ($res) {
                        deliver_response(1);
                    } else {
                        deliver_response(3);
                    }

                    break;


                case 'requestRecommendationsFromEC2':
                    $apiBody = file_get_contents('php://input');
                    $apiBody = json_decode($apiBody, true);
                    $list_to_sent_to_AWS = array();
                    foreach ($apiBody as $body) {
                        $sql = "INSERT INTO `correction-main` SET ";
                        foreach ($body as $key => $value) {
                            $sql = $sql . " $key='$value' ,";
                        }
                        $sql = $sql . " id=$id";
                        // print_r($sql);
                        $res = mysqli_query($connection, $sql);
                        $correction_id = mysqli_insert_id($connection);
                        $correctionOldStatement = $body['correctionOldStatement'];
                        array_push($list_to_sent_to_AWS, array('correctionID' => $correction_id, 'correctionOldStatement' => $correctionOldStatement));
                    }
                    $fields = json_encode($list_to_sent_to_AWS);

                    //
                    // A very simple PHP example that sends a HTTP POST to a remote site
                    //

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, "http://3.7.69.109/requestGrammerCheck");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                    ));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    // In real life you should use something like:
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, 
                    //          http_build_query(array('postvar1' => 'value1')));

                    // Receive server response ...
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $server_output = curl_exec($ch);

                    curl_close($ch);

                    deliver_response($server_output);
                    break;


                case 'updateRecommendationsFromEC2':
                    $apiBody = file_get_contents('php://input');
                    $apiBody = json_decode($apiBody, true);
                    // print_r($apiBody);
                    foreach ($apiBody as $body) {
                        $sql = "UPDATE   `correction-main` SET status=1,correctionHTML= \"" . $body['correctionHTML'] . "\", correctionNewStatement  = \"" . $body['correctionNewStatement'] . "\" WHERE correctionID= " . $body['correctionID'];
                        // print_r($sql);
                        $res = mysqli_query($connection, $sql);
                        if (count($body['indexValues']) > 0) {
                            $sql = "UPDATE `correction-main` SET correctionIndex=1 WHERE correctionID= " . $body['correctionID'];
                            $res = mysqli_query($connection, $sql);
                            // print_r($sql);
                            $indexValues = $body['indexValues'];
                            foreach ($indexValues as $indexing) {
                                $sql = "INSERT INTO `correction-proofread-indexing` SET  ";
                                foreach ($indexing as $key => $value) {
                                    # code...
                                    $sql = $sql . " $key=\"$value\" ,";
                                }
                                $sql = $sql . " status=1";
                                // print_r($sql);
                                $res = mysqli_query($connection, $sql);
                            }
                        }
                    }
                    deliver_response(1);

                    break;
            }
        }
    }
}
