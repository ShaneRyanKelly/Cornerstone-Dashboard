<?php
require ("header.php");
?>
<?php
require ("connection.php");

session_start();

$occurence = $_POST['occurence'];
$day = "None";
$date = $_POST['date'];

if($occurence == "Weekly"){
	$day = $_POST['day'];
}

if($occurence != "Weekly" && $occurence != "Once"){
	$day = "None";
}

$client_name = $_POST['client'];
$vendor_name = $_POST['vendor'];

$text = $_POST['text'];

$user = $_SESSION['user'];

$sql = "INSERT INTO reminder(user,date,text,vendor_name,client_name,occurence,current_day) VALUES ('$user','$date','$text','$vendor_name','$client_name','$occurence','$day')";
$result = $conn->query($sql) or die('Error querying database.');
 
$conn->close();
header("location: http://localhost/crst_dashboard/reminders.php ");
exit();
?>