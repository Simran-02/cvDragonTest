<?php
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");
header("Content-Type:application/json");

$id 		   = isset($_POST['id']) 			 ? $_POST['id'] : '';
$authkey 	  = isset($_POST['authkey']) 		? $_POST['authkey'] : '';
$data	 	 = isset($_POST['data']) 		   ? $_POST['data'] : '';
$message 	  = isset($_POST['message']) 		? $_POST['message'] : '';
$date         = date("Y-m-d H:i:s");

if($id) {
	if($authkey) {
		if(usercheck($id,$authkey,$connection)) {
$id 	= $id;
$key   = $authkey;

			
if($id !="") {
	if($key !="") {	
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(@is_uploaded_file($_FILES['document']['tmp_name'])) {


	
$extensions 	= array("jpeg", "JPEG", "jpg", "JPG", "PNG", "png", "GIF", "gif", "pdf", "doc", "docx","svg");
$path 			= '../../../public/resources/documentUpload/'; // upload directory
$link			= $documentURL;
$fileExt		 = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION));
$fileSize		= $file_size =$_FILES['document']['size'];


				if(in_array($fileExt,$extensions)){
					if($fileSize < 2097152) {
	
 	
$fileNameOriginal= $_FILES['document']['name'];
$fileName	    = time().rand(1,100);
$fileFullName	= $fileName.'.'.$fileExt;
$uploadfile 	  = $path.$fileFullName;
$response	  	= $link.$fileFullName;


if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadfile)) {

	
            switch ($data) {
                case "chatDocument": {
						$chat = array();
						$chat['fileName'] = $fileNameOriginal;
						$chat['link'] 	 = $response;
						$chat['message']  = $message;
						$chatContent	  = json_encode($chat);
                        $type = 2;

                        $sql = "INSERT INTO `help-chat` SET
                        senderID = '" . $id . "',
                        receiverID = 1,
                        chat = '" . $chatContent . "',
                        type = '" . $type . "',
                        dateCreated = '" . $date . "',
                        dateUpdated = '" . $date . "',
                        status = 1";
                        $qry = mysqli_query($connection, $sql);
                        $chatID = mysqli_insert_id($connection);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
                case "chatDocumentPartner": {
						$senderCategory   = isset($_POST['senderCategory']) ? $_POST['senderCategory'] : '';
						$chat = array();
						$chat['fileName'] = $fileNameOriginal;
						$chat['link'] 	 = $response;
						$chat['message']  = $message;
						$chatContent	  = json_encode($chat);
                        $type = 2;

                        $sql = "INSERT INTO `partnerHelpChat` SET
                        senderID = '" . $id . "',
                        senderCategory = '" . $senderCategory . "',
                        receiverID = 1,
                        chat = '" . $chatContent . "',
                        type = '" . $type . "',
                        dateUpdated = '" . $date . "',
                        status = 1";
                        $qry = mysqli_query($connection, $sql);
                        $chatID = mysqli_insert_id($connection);
                        if ($qry) {
                            deliver_response(1);
                        } else {
                            deliver_response(0);
                        }
                    }
                    break;
                case "myDocument": {
                            deliver_response($response);
                    }
                    break;
                case "signature": {

						$sql = "UPDATE `cv-preference` SET 
						signature	= '".$response."' 
						WHERE 
						id 			= '".$id."' AND 
						status 		= 1";
						$qry 		= mysqli_query($connection, $sql);
                        if($qry) { 
						deliver_response($response); 
						
						} else { deliver_response(0); }
                   
				    }
                    break;
                default: {
                    }
                    echo 'Default Content';
            }
	
	
	
?>
<?php } ?> 
<?php }} ?> 
<?php }}}} ?> 
<?php }}} ?>