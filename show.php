<?php
require ("header.php");
?>
<div class="content">
<?php

require ("connection.php");
session_start();

$one = $_SESSION["client_name"];
$two = $_SESSION['project_name'];



$result1 = mysqli_query($conn,"SELECT job_id from job_ticket WHERE client_name='$one' and project_name='$two'");
if ($result1->num_rows > 0) {
	while($row1 = $result1->fetch_assoc()) {
		echo "Job ID: ".$row1['job_id'];
	}
}

$_SESSION["job_id"]=$row1['job_id'];

$conn->close();


exit();

?>
</div>

