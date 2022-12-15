<?php
include_once 'function/koneksi.php';
$post = $koneksi->real_escape_string($_POST["jenis_claim"]);
//$post = "a12";
$sql = "SELECT jenis_claim FROM claim WHERE jenis_claim LIKE '%".$post."%' GROUP BY jenis_claim";

$result = $koneksi->query($sql);
$data = array();
if ($result->num_rows > 0) {
	while ($row = $result->fetch_array()) {
		$data[] = $row[0];
	}
}
	$koneksi->close();
	echo json_encode($data);
?>