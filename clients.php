<?php
require ("header.php");
?>
<div class="dashboard-cont" style="padding-top:110px;">
	<div class="contacts-title">
	<h1 class="pull-left">Clients</h1>
	<a class="pull-right" href="add_client.php" class="add_button">Add Client</a>
	</div>
<div class="dashboard-detail">
	<div class="search-cont">
	<div class="searchcont-detail">
		<div class="search-boxleft">
				<label>Quick Search</label>
				<input id="search" name="frmSearch" type="text" placeholder="Search for a specific client">
				<div class="contacts-title">
				<a id = 'advanced_search_button' class="pull-right" href="#" class="add_button" onclick = 'addField()'>Advanced Search</a>
				</div>
		<form class = 'advanced_search_area' action = 'advanced_search_clients.php' method = 'post'>
		<input id = 'advanced_search_submit' style = 'display: none' type = 'submit' name = 'submit_form_advanced'>
		</form>
		</div>
	</div>
	</div>
<div class="clear"></div>



<?php

require ("connection.php");

$result = mysqli_query($conn,"SELECT * FROM sales WHERE type = 'Client'");


echo " <div id = 'table-scroll' class='allcontacts-table'><table id = 'table' border='0' cellspacing='0' cellpadding='0' class='table-bordered allcontacts-table' >"; // start a table tag in the HTML
echo "<tbody>";
echo "<tr valign='top'><th class='allcontacts-title'>All Clients<span class='allcontacts-subtitle'></span></th></tr>";
echo "<tr valign='top'><td colspan='2'><table id = 'client_table' border='0' cellspacing='0' cellpadding='0' class='table-striped main-table contacts-list'><thead><tr valign='top' class='contact-headers'><th id = 'client_name' class='maintable-thtwo data-header' data-name='client_name' data-index='0'>Client Name</th><th id = 'contact_name' class='maintable-thtwo data-header' data-name='contact_name' data-index='1'>Business</th><th id = 'address' class='maintable-thtwo data-header' data-name='client_add' data-index='2'>Address</th><th id = 'phone' class='maintable-thtwo data-header' data-name='contact_phone' data-index='3'>Phone</th><th id = 'email' class='maintable-thtwo data-header' data-name='contact_email' data-index='4'>City</th><th id = 'website' class='maintable-thtwo data-header' data-name='website' data-index='5'>Title</th><th id = 'category' class='maintable-thtwo data-header' data-name='category' data-index='6'>Email</th><th id = 'title' class='maintable-thtwo data-header' data-name='title' data-index='7'>Website</th></tr></thead><tbody>";


if ($result->num_rows > 0) {
    // output data of each row
	
    while($row = $result->fetch_assoc()) {
		
		$website = $row['web_address'];
		$email = $row['email1'];
		
		if(strlen($website) >= 15){
			$website = substr($website, 0, 15) . "<br>" . "...";
		}
		if(strlen($email) >= 15){
			$email = substr($email, 0, 15) . "<br>" . "...";
		}

		$foo=array();
		array_push($foo, $row['full_name']);
		array_push($foo, $row['address_line_1']);
		$str = serialize($foo);
		echo "<tr class = 'hoverTab'><td><a href = 'edit_client.php?client_info=$str'>".$row["full_name"]."</a></td><td>".  $row["business"]."</td><td>". $row["address_line_1"]. "</td><td>". $row["phone"] . "</td><td>". $row["city"]. "</td><td>". $row["title"]. "</td><td>" .$email."</td><td>". $website . "</td></tr>";
    }
	echo "</tbody></table></td></tr></tbody></table></div>";
} else {
    echo "0 results";
}

$conn->close();

?>
<div class="allcontacts-breadcrumbs">
	<div class="allcontacts-breadcrumbsleft pull-left page-control">
	<nav>
		<ul class = "pagination" id = "pag">
			<li id = 'prev_button' class = 'previous' style = 'display:none;' onclick = "prevPage();">Prev</li>
		</ul>
	</nav>
	</div>
	<div class="items-per-page-cont pull-right">
		<label>Clients Per Page</label>
		<select class="per-page-val" id = "item_count" onchange = "changeCount()">
			<option value="10">10</option>
			<option value="25">25</option>
			<option value="50">50</option>
			<option value="100">100</option>
		</select>
	</div>
</div>
</div>
</div>

<!--- script for making table sortable --->
<script src="sorttable.js"></script>
<script type="text/javascript" src="jquery-latest.js"></script> 
<script type="text/javascript" src="jquery.tablesorter.js"></script> 
<script>
var fields = [false, false];

function addField(){
	for(var i = 0; i < fields.length; i++){
		var fieldCount = i + 1;
		if(fields[i] == false && i == 0){
			$(".advanced_search_area").append("<div class = 'field" + fieldCount + "'><input name = 'state' type = 'text' placeholder = 'Enter state'><img src = 'images/x_button.png' width = '25' height = '25' onclick = removeField('.field" + fieldCount + "')></div>");
			document.getElementById("advanced_search_button").innerHTML = "Add Field";
			document.getElementById("advanced_search_submit").style.display = "block";
			fields[i] = true;
			break;
		}
		else if(fields[i] == false && i == 1){
			$(".advanced_search_area").append("<div class = 'field" + fieldCount + "'><input name = 'city' type = 'text' placeholder = 'Enter city'><img src = 'images/x_button.png' width = '25' height = '25' onclick = removeField('.field" + fieldCount + "')></div>");
			fields[i] = true;
			break;
		}
	}
}
function removeField(x){
	for(var i = 0; i < fields.length; i++){
		var number = i + 1;
		if(x == ".field" + number){
			$(x).remove();
			fields[i] = false;
			break;
		}
	}
	
	var allFalse = true;
	for(var i = 0; i < fields.length; i++){
		if(fields[i] == true){
			allFalse = false;
		}
	}
	
	if(allFalse == true){
		document.getElementById("advanced_search_button").innerHTML = "Advanced Search";
		document.getElementById("advanced_search_submit").style.display = "none";
	}
}
var numPerPage = 10;
var subtractValue = 3;
var prevSubValue = 4;

$("#search").keyup(function(){
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#client_table tbody tr"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
               $(this).hide();
            else
               $(this).show();                
        });
    }); 
	
$(document).ready(function() 
    { 
        $("#client_table").tablesorter(); 
		pageCreator();
    } 
); 
function pageCreator(){
	$('table.table-striped.main-table.contacts-list').each(function() {
		var currentPage = 0;
		numPerPage = parseInt(document.getElementById('item_count').value);
		var $table = $(this);
		var $ul = $('ul.pagination');
		$table.bind('repaginate', function() {
			$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
		});
		$table.trigger('repaginate');
		var numRows = $table.find('tbody tr').length;
		var numPages = Math.ceil(numRows / numPerPage);
		var count = 1;
		for (var page = 0; page < numPages; page++) {
			var i = $('<li id = id' + count + ' class = "current"></li>').text(page + 1).bind('click', {
				newPage: page
			}, function(event) {
				currentPage = event.data['newPage'];
				$table.trigger('repaginate');
				$(this).addClass('clickable').siblings().removeClass('clickable');
			}).appendTo($ul).addClass('current');
			count = count + 1;
		}
		if(numPages > 5){
			$("<li id = 'next_button' class = 'next' onclick = nextPage();>Next</li>").appendTo($ul);
		}
	});
	document.getElementById("id1").className = "current clickable";
	var ul = document.getElementById("pag");
	
	if(ul.childNodes.length > 5){
		for(var i = 6; i < ul.childNodes.length - 1; i++){
			ul.children[i].style.display = "none";
			document.getElementById("next_button").style.display = "inline";
		}
	}
}
function changeCount(){
	numPerPage = parseInt(document.getElementById('item_count').value);
	$('#pag').empty();
	$("<li id = 'prev_button' class = 'previous' style = 'display:none;' onclick = prevPage();>Prev</li>").appendTo("#pag");
	subtractValue = 1;
	prevSubValue = 2;
	pageCreator();
}
function prevPage(){
	document.getElementById("next_button").style.display = "inline";
	var ul = document.getElementById("pag");
	var length1 = ul.childNodes.length - prevSubValue;
	var oldDisplayIndex = 0;
	for(var i = length1; i >= 1; i--){
		if(ul.children[i].style.display == "inline"){
			oldDisplayIndex = i;
			break;
		}
	}
	
	var newDisplayIndex = 0;
	for(var i = oldDisplayIndex; i >= 1; i--){
		newDisplayIndex = i;
		if(ul.children[i].style.display == "none"){
			break;
		}
		else{
			ul.children[i].style.display = "none";
		}
	}
	
	var count = 0;
	var lastIndex = 0;
	for(var i = newDisplayIndex; i >= 1; i--){
		lastIndex = i;
		if(count == 5){
			break;
		}
		else{
			//alert("Hi");
			ul.children[i].style.display = "inline";
			count = count + 1;
		}
	}
	if(lastIndex == 1){
		document.getElementById("prev_button").style.display = "none";
	}
}
function nextPage(){
	document.getElementById("prev_button").style.display = "inline";
	var ul = document.getElementById("pag");
	
	var displayCount = 0;
	var lastIndexCheck = 0;
	for(var i = 1; i < ul.childNodes.length - 1; i++){
		if(ul.children[i].style.display != "none"){
			displayCount++;
		}
		lastIndexCheck = i;
		if(displayCount == 5){
			break;
		}
	}
	if(lastIndexCheck != ul.childNodes.length - 2){
		var oldDisplayIndex = 0;
		for(var i = 1; i < ul.childNodes.length - 1; i++){
			if(ul.children[i].style.display != "none"){
				oldDisplayIndex = i;
				break;
			}
		}
		
		var newDisplayIndex = 0;
		for(var i = oldDisplayIndex; i < ul.childNodes.length - 1; i++){
			if(ul.children[i].style.display == "none"){
				newDisplayIndex = i;
				break;
			}
			else{
				ul.children[i].style.display = "none";
			}
		}
		
		var count = 0;
		var lastIndex = 0;
		for(var i = newDisplayIndex; i < (ul.childNodes.length - subtractValue); i++){
			if(count == 5){
				break;
			}
			else{
				ul.children[i].style.display = "inline";
				count = count + 1;
				lastIndex = i;
			}
			if(i == ul.childNodes.length){
				break;
			}
		}
		if(count < 5 || ul.children[lastIndex + 1].className == "next"){
			document.getElementById("next_button").style.display = "none";
		}
	}
}
</script>

	

	

						