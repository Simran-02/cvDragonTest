<?php
session_start();
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

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
        if (usercheck($id, $authkey, $connection)) {

            switch ($data) {
                case "addChat": {

                        $contents = urlImport($_GET['contents']);
                        //print_r($contents);
                        $senderID = $contents['senderID'];
						$senderName = IDtoName($senderID, $connection);
                        $receiverID = $contents['receiverID'];
                        $chat = $contents['chat'];
                        $type = $contents['type'];

                        $sql = "INSERT INTO `help-chat` SET
                        senderID = '" . $senderID . "',
                        receiverID = '" . $receiverID . "',
                        chat = '" . $chat . "',
                        type = '" . $type . "',
                        dateCreated = '" . $date . "',
                        dateUpdated = '" . $date . "',
                        status = 1";
                        $qry = mysqli_query($connection, $sql);
                        $chatID = mysqli_insert_id($connection);



                        if ($chatID != 0) {
                            deliver_response(1);

                           /* sendNotification(
                                'Message Received',
                                'We have received your message, Kindly give us 24 hrs to resolve your issue',
                                'support',
                                $id,
                                '',
                                '',
                                $connection
                            );
							*/
                            //send app notification to admin
                           sendNotificationToAdmin('Help Query by '.$senderName, $chat, $id);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;

                case "user-chat-individual": {

                        $chatListArray = array();

                        //Chat List
                        $sql = "SELECT * FROM `help-chat` where ((receiverID ='" . $id . "' OR senderID ='" . $id . "') OR (receiverID =1 AND senderID =1)) AND status=1 ORDER by dateCreated ASC";
                        $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                array_push($chatListArray, $row);
                            }
                        }


                        deliver_response($chatListArray);
                    }
                    break;
                default: {
                    }
                    echo 'Default Content';
            }
        }
    }
}
