<?php
header("Content-Type:application/json");

$cTime        = time();
$flag = "0";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (@is_uploaded_file($_FILES['image']['tmp_name'])) {

        $valid_exts     = array("jpeg", "JPEG", "jpg", "JPG", "PNG", "png", "GIF", "gif");
        $maxDimension  = 800;

        $path             = '../../../public/resources/userTaskUploads/'; // upload directory
        $imageSize         = $_FILES['image']['size'];
        $file_name         = $_FILES['image']['tmp_name'];
        $imageDetails     = getimagesize($file_name);
        $imageWidth     = $imageDetails[0];
        $imageHeight     = $imageDetails[1];
        $imageFormat    = $imageDetails['mime'];
        $imageExt        = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $imageName        = time() . rand(1, 100);
        $imageFName        = $imageName . '.jpeg';

        if ($imageFormat == 'image/jpeg') {

            $imageFName        = $imageName . '.jpeg';
        } elseif ($imageFormat == 'image/gif') {

            $imageFName        = $imageName . '.gif';
        } elseif ($imageFormat == 'image/png') {

            $imageFName        = $imageName . '.png';
        }

        $imagePath        = $path . $imageFName;

        if ($imageWidth >= $maxDimension || $imageHeight >= $maxDimension) {

            $rationWH = $imageWidth / $imageHeight;
            if ($rationWH > 1) {
                $newWidth = $maxDimension;
                $newHeight = $maxDimension / $rationWH;
            } else {
                $newWidth = $maxDimension * $rationWH;
                $newHeight = $maxDimension;
            }
        } else {
            $newWidth = $imageWidth;
            $newHeight = $imageHeight;
        }

        $src = imagecreatefromstring(file_get_contents($file_name));
        $dst = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
        imagedestroy($src);

        if ($imageFormat == 'image/jpeg') {

            imagejpeg($dst, $imagePath, 75);
        } elseif ($imageFormat == 'image/gif') {

            imagegif($dst, $imagePath);
        } elseif ($imageFormat == 'image/png') {

            imagepng($dst, $imagePath);
        }

        imagedestroy($dst);


        echo ($imageFName);

?>
 <?php }
} ?> 
