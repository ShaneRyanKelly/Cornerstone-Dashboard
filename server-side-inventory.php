<?php
/*
Follow this tutorial for further clarification --> https://coderexample.com/datatable-demo-server-side-in-phpmysql-and-ajax/
*/
$sql = "";
$totalData = "";
$totalFiltered = "";
if($_POST['function'] ==1){
	// getting total number records without any search
	require("connection.php");
	global $sql, $totalData, $totalFiltered;
	$sql = "SELECT * FROM inventory";
	$query=mysqli_query($conn, $sql);
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


	$sql = "SELECT * FROM inventory WHERE 1=1";
}


require("connection.php");
// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;
$columns = array(
// datatable column index  => database column name
	0 => 'material_id',
	1=> 'material',
	2 =>'vendor',
	3 => 'location',
	4=> 'material_color',
	5=> 'quantity',
	6=> 'per_box',

);

	if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" AND ( material_id LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR material LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR vendor LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR location LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR material_color LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR quantity LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR per_box LIKE '%".$requestData['search']['value']."%' ";
	}

	//getting records as per search parameters
	for ($i = 0; $i < count($columns); $i++) {
		if( !empty($requestData['columns'][$i]['search']['value']) ){   //each column name search
		    $sql.=" AND ".$columns[$i]."  LIKE '%".$requestData['columns'][$i]['search']['value']."%' ";
		}
	}

	$jsonsql = $sql;

	$query=mysqli_query($conn, $sql) or die (mysqli_error($conn));
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

	/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
	$query=mysqli_query($conn, $sql);

	$data = array();
	while( $row=mysqli_fetch_array($query) ) {  // preparing an array
		$nestedData=array();
		$nestedData[] = $row["material_id"];
		$nestedData[] = $row["material"];
		$nestedData[] = $row["vendor"];
		$nestedData[] = $row["location"];
		$nestedData[] = $row["material_color"];
		$nestedData[] = $row["quantity"];
		$nestedData[] = $row["per_box"];
		
		$data[] = $nestedData;
	}


$json_data = array(
			"sql"							=> $jsonsql,
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>