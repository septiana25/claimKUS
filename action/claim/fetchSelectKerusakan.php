<?php

	require_once '../../function/koneksi.php';
	require_once '../../function/setjam.php';
	require_once '../../function/session.php';


if ($_POST) {

	$cari = $_POST['cari'];
	// $cari = 100;

	$sql = "SELECT kerusakan FROM claim WHERE kerusakan LIKE '" . $cari . "%' AND kerusakan !='-' GROUP BY kerusakan ORDER BY id_brg ASC LIMIT 0,6";

	$result = $koneksi->query($sql);

	if ($result->num_rows > 0) {
?>

	<ul id="kersList">

<?php	
	while ($row = $result->fetch_array()) {
?>

	<li onClick="selectKers('<?php echo $row['kerusakan']; ?>')"><?php echo $row['kerusakan']; ?></li>

<?php
	}//while
	}//if
?>
	</ul>
<?php
}

// echo json_encode($output);
?>