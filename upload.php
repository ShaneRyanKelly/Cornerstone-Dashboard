<?php
$target_dir = "../../mysql/data/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
/*if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}*/
// Check if $uploadOk is set to 0 by an error

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname= "crst_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

    $sql = "LOAD DATA INFILE './". $_FILES["fileToUpload"]["name"]."' INTO TABLE sales 
   FIELDS TERMINATED BY '\t'
LINES TERMINATED BY '\r'
IGNORE 1 LINES
(var1, var2, var3, var4, var5, var6, var7, var8, var9, var10, var11, var12, var13, var14, @var15, var16, @var17, var18, var19, var20, var21, var22, var23, var24, var25, var26, var27, var28, var29, var30, var31, var32, var33, var34, var35, var36, var37, var38, var39, var40, var41) 
SET call_back_date = STR_TO_DATE(@var15, '%m/%d/%Y'),     
	date_added = STR_TO_DATE(@var17, '%m/%d/%Y')
";

    $result = $conn->query($sql) or die('Error querying database.');


$conn->close();
?>