<?php
include("../../dbcnew.php");
include("../../functions.php");
include("../urls.php");

header("Content-Type:application/json");

$allTables = ['kc-videos','kc-articles','kc-faq','kc-qna','kc-tips'];

$id 		     = isset($_GET['id']) 		 ? $_GET['id'] : '';
$authkey 	    = isset($_GET['authkey']) 	? $_GET['authkey'] : '';
$date    	   = isset($_GET['date'])       ? $_GET['date'] : '';
$kcID 		   = isset($_GET['kcID']) 	   ? $_GET['kcID'] : '';
$kcMain 		 = isset($_GET['category'])   ? $_GET['category'] : '';
$data 		   = isset($_GET['data']) 	   ? $_GET['data'] : '';

if($id) 
{
	if($authkey) 
	{
		if(usercheck($id,$authkey,$connection)) 
		{	
			switch ($data) 
			{
			    case 'kcAll':
			    	$response = array();
			        $sql = "SELECT * FROM `kc-articles` WHERE `status` = 1";
			        $kcBlogs = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcBlogs[]=$row;
			        }

			        $sql = "SELECT * FROM `kc-faq` WHERE `status` = 1";
			        $kcFaq = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcFaq[]=$row;
			        }

			        $sql = "SELECT * FROM `kc-qna` WHERE `status` = 1";
			        $kcQna = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcQna[]=$row;
			        }
			        
			        $sql = "SELECT * FROM `kc-tips` WHERE `status` = 1";
			        $kcTips = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcTips[]=$row;
			        }
			        
			        $sql = "SELECT * FROM `kc-videos` WHERE `status` = 1";
			        $kcVideos = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcVideos[]=$row;
			        }
			        
			        $response["kc-articles"]=$kcBlogs;
			        $response["kc-faq"]=$kcFaq;
			        $response["kc-qna"]=$kcQna;
			        $response["kc-tips"]=$kcTips;
			        $response["kc-videos"]=$kcVideos;
			        //$response = json_encode($response, JSON_PRETTY_PRINT);
					deliver_response($response);

/*			        $filename = time();
			        $fp = fopen("$filename".'.json', 'w');
					fwrite($fp,$response);
					fclose($fp);
					if(file_exists("$filename".'.json'))
					{
						echo("1");
					}
					else
					{
						echo("0");
					}
*/
			        break;
			    case 'kcFirst':
			    	$response = array();
			        $sql = "SELECT * FROM `kc-articles` WHERE `status` = 1 ORDER BY uploadDate DESC LIMIT 5 OFFSET 0";
			        $kcBlogs = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcBlogs[]=$row;
			        }

			        $sql = "SELECT * FROM `kc-faq` WHERE `status` = 1 ORDER BY uploadDate DESC LIMIT 5 OFFSET 0";
			        $kcFaq = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcFaq[]=$row;
			        }

			        $sql = "SELECT * FROM `kc-qna` WHERE `status` = 1 ORDER BY uploadDate DESC LIMIT 5 OFFSET 0";
			        $kcQna = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcQna[]=$row;
			        }
			        
			        $sql = "SELECT * FROM `kc-tips` WHERE `status` = 1 ORDER BY uploadDate DESC LIMIT 5 OFFSET 0";
			        $kcTips = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcTips[]=$row;
			        }
			        
			        $sql = "SELECT * FROM `kc-videos` WHERE `status` = 1 ORDER BY uploadDate DESC LIMIT 5 OFFSET 0";
			        $kcVideos = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcVideos[]=$row;
			        }
			        
			        $response["kc-articles"]=$kcBlogs;
			        $response["kc-faq"]=$kcFaq;
			        $response["kc-qna"]=$kcQna;
			        $response["kc-tips"]=$kcTips;
			        $response["kc-videos"]=$kcVideos;
			        //$response = json_encode($response, JSON_PRETTY_PRINT);
					deliver_response($response);

/*			        $filename = time();
			        $fp = fopen("$filename".'.json', 'w');
					fwrite($fp,$response);
					fclose($fp);
					if(file_exists("$filename".'.json'))
					{
						echo("1");
					}
					else
					{
						echo("0");
					}
*/
			        break;
			    case 'kcRecent':
			    	$table = $allTables[$kcMain-1];
					$response = array();
			        $sql = "SELECT * FROM `$table` WHERE `uploadDate` >= $date AND `status` = 1 ORDER BY uploadDate DESC";
			        $kcMore = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcMore[]=$row;
			        }

			        $response[$table]=$kcMore;
					deliver_response($response);
			        break;

			    case 'kcMore':
			    	$table = $allTables[$kcMain-1];
			    	$limit = $_GET['limit'];
			    	$offset = $_GET['offset'];
					$response = array();
			        $sql = "SELECT * FROM `$table` WHERE `status` = 1 ORDER BY uploadDate DESC LIMIT $limit OFFSET $offset";
			        $kcMore = array();
			        $result = mysqli_query($connection,$sql);
			        while($row = mysqli_fetch_assoc($result))
			        {
			        	$kcMore[]=$row;
			        }

			        $response[$table]=$kcMore;
					deliver_response($response);
			        break;

			    case 'addFavouite':
			    	$sql = "INSERT INTO `kc-favorites` (`kcID`,`kcMain`,`id`,`status`) VALUES ($kcID,$kcMain,$id,1)";
			    	$result = mysqli_query($connection,$sql);
			    	if($result)
			    	{
			    		deliver_response("1");
			    	}
			    	else
			    	{
			    		deliver_response("0");
			    	}
			    	break;
			    case 'deleteFavourite':
			    	$sql = "UPDATE `kc-favorites` SET `status` = 0 WHERE id = $id AND kcID = $kcID AND kcMain = $kcMain";
			    	$result = mysqli_query($connection,$sql);
			    	if($result)
			    	{
			    		echo("1");
			    	}
			    	else
			    	{
			    		echo("0");
			    	}
			    	break;
			    case 'myFavourite':
			    	$sql ="SELECT * FROM `kc-favorites` WHERE id = $id AND `status` = 1";
			    	$result = mysqli_query($connection,$sql);
			    	$response = array();
			    	while($row = mysqli_fetch_assoc($result))
			    	{
			    		$response[]=$row;
			    	}
			    	print_r($response);
			    	break;
			    case 'particularPost':
			    	$table = $allTables[$kcMain-1];
			    	$sql = "SELECT * FROM `$table` WHERE kcID = $kcID AND `status` = 1";
			    	$result = mysqli_query($connection,$sql);
			    	$row = mysqli_fetch_assoc($result);
			    	print_r($row);
			    	break;
			}
		}
	}
}