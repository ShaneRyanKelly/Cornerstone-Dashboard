<script src="sorttable.js"></script>
<?php
require ("header.php");
?>
<div class="dashboard-cont" style="padding-top:110px;">
	<div class="contacts-title">
	<h1 class="pull-left">Sales</h1>
	</div>
<div class="dashboard-detail">
	
<div class="clear"></div>
<?php
require ("connection.php");

$result = mysqli_query($conn,"SELECT job_ticket.job_id, job_ticket.client_name, job_ticket.project_name, job_ticket.due_date, job_ticket.estimate_number, mail_data.records_total FROM job_ticket INNER JOIN mail_data ON job_ticket.job_id = mail_data.job_id AND mail_data.processed_by = ''");

echo " <div class='allcontacts-table'><table border='0' cellspacing='0' cellpadding='0' class='table-bordered allcontacts-table' >"; // start a table tag in the HTML
echo "<tbody>";
echo "<tr valign='top'><th class='allcontacts-title'>Job Tickets in Process<span class='allcontacts-subtitle'></span></th></tr>";
echo "<tr valign='top'><td colspan='2'><table border='0' cellspacing='0' cellpadding='0' class='table-striped main-table contacts-list'><tbody><tr valign='top' class='contact-headers'><th class='maintable-thtwo data-header' data-name='job_id' data-index='0'>Job ID</th><th class='maintable-thtwo data-header' data-name='client_name' data-index='1'>Client Name</th><th class='maintable-thtwo data-header' data-name='project_name' data-index='2'>Job Name</th><th class='maintable-thtwo data-header' data-name='due_date' data-index='3'>Due Date</th><th class='maintable-thtwo data-header' data-name='estimate_number' data-index='4'>Estimate #</th><th class='maintable-thtwo data-header' data-name='records_total' data-index='5'>Total Records</th><th class='maintable-thnine'>Actions</th></tr>";

if ($result->num_rows > 0) {
    // output data of each row
	
    while($row = $result->fetch_assoc()) {
		$foo = $row['job_id'];
		echo "<tr><td>".$row["job_id"]."</td><td>".  $row["client_name"]."</td><td>". $row["project_name"]. "</td><td>". $row["due_date"]. "</td><td>". $row["estimate_number"]."</td><td>". $row["records_total"]. "</td><th>"."<a href='http://localhost/crst_dashboard/edit_job.php?job_id=$foo'>"."Edit"."</a></th></tr>";
    }
	echo "</tbody></table></td></tr></tbody></table></div>";
} else {
    echo "0 results";
}
//class='paginated'
?>
<div class="allcontacts-breadcrumbs">
	<div class="allcontacts-breadcrumbsleft pull-left page-control">
		<nav>
			<ul class="pagination">
				<li class="current"><a class="page" href="#">1<span class="sr-only">(current)</span></a></li>
				<li><a class="page" href="#">2<span class="sr-only">(current)</span></a></li>
				<li><a class="page" href="#">3<span class="sr-only">(current)</span></a></li>
				<li><a class="page" href="#">4<span class="sr-only">(current)</span></a></li>
				<li><a class="page" href="#">5<span class="sr-only">(current)</span></a></li>
				<li><a class="next" href="#">Next<span class="sr-only">(current)</span></a></li>
			</ul>
		</nav>
	</div>
	<div class="items-per-page-cont pull-right">
		<label>Jobs Per Page</label>
		<select class="per-page-val">
			<option value="10">10</option>
			<option value="25">25</option>
			<option value="50">50</option>
			<option value="100">100</option>
		</select>
	</div>
</div>
</div>
</div>
<script>
$('table.sortable').each(function() {
    var currentPage = 0;
    var numPerPage = 10;
    var $table = $(this);
    $table.bind('repaginate', function() {
        $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
    });
    $table.trigger('repaginate');
    var numRows = $table.find('tbody tr').length;
    var numPages = Math.ceil(numRows / numPerPage);
    var $pager = $('<div class="pager"></div>');
    for (var page = 0; page < numPages; page++) {
        $('<span class="page-number"></span>').text(page + 1).bind('click', {
            newPage: page
        }, function(event) {
            currentPage = event.data['newPage'];
            $table.trigger('repaginate');
            $(this).addClass('active').siblings().removeClass('active');
        }).appendTo($pager).addClass('clickable');
    }
    $pager.insertBefore($table).find('span.page-number:first').addClass('active');
});

$("#search").keyup(function(){
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#table tbody tr"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
               $(this).hide();
            else
               $(this).show();                
        });
    }); 

</script>