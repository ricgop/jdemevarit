
<?php
$target_dir = "pics/";
$rec_id = $_SESSION['$recid'];
$fileInfo = pathinfo($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$picture_ok = false;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $picture_error = "Nahraný soubor není obrázek.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $picture_error = "Omlouváme se, ale došlo k chybě. Kontaktujte prosím administrátora.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 3000000) {
    $picture_error = "Obrázek musí být menší, než 3MB.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $picture_error = "Omlouváme se, podporované formáty obrázků jsou pouze <strong>JPG, JPEG, PNG & GIF.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $rec_id . '.' . $fileInfo['extension'])) {
        $picture_ok = true;
    } else {
        $picture_error = "Omlouváme se, ale došlo k chybě. Zkuste to prosím znovu.";
    }
}
?>
