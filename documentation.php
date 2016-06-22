<?php
require ("header.php");
?>
<div class="dashboard-cont" style="padding-top:110px;">
	<div class="contacts-title">
	<h1 class="pull-left">Documentation</h1>
	<a class="pull-right" href="add_doc.php" class="add_button">Add Doc</a>
	</div>
<div class="dashboard-detail">
	<div class="search-cont">
	<div class="searchcont-detail">
		<div class="search-boxleft">
			<form action="client_search.php" method="post" >
				<label>Quick Search</label>
				<input id="search" name="frmSearch" type="text" placeholder="Search for specific documentation">
			</form>
			<div class="search-boxright pull-right"><a href="#">Submit</a></div>
		</div>
	</div>
	</div>
<div class="clear"></div>
<div class="documentation-detail">
<?php

require ("connection.php");
$result = mysqli_query($conn,"SELECT * FROM documentation");

if ($result->num_rows > 0) {
    // output data of each row
	
    while($row = $result->fetch_assoc()) {
		$temp = $row['title'];
		echo "<div class='doc-block'>";
		echo "<a href='http://localhost/crst_dashboard/edit_doc.php?title=$temp'><h2>".$row['title']."</h2></a>"."<p>Written by ".$row['user']." on ".$row['timestamp']."</p><br>";
		echo "<p>".$row['text']."</p>";
		echo "</div>";
    }
} else {
    echo "0 results";
}

$conn->close();

?>
</div>
</div>
</div>				
