<?php
include_once 'function/koneksi.php';
$post = $koneksi->real_escape_string($_POST["areaToko"]);
//$post = "a12";
$sql = "SELECT area_toko FROM claim WHERE area_toko LIKE '%".$post."%' GROUP BY area_toko";

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