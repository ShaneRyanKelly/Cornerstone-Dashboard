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
$dbname= "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

    $sql = "LOAD DATA INFILE './". $_FILES["fileToUpload"]["name"]."' INTO TABLE sales 
   FIELDS TERMINATED BY '\t'
LINES TERMINATED BY '\r'
IGNORE 1 LINES
(@var1, @var2) 
SET begin = STR_TO_DATE(@var1, '%m/%d/%Y'),     
end = STR_TO_DATE(@var2, '%m/%d/%Y')
";

    $result = $conn->query($sql) or die('Error querying database.');


$conn->close();
?>