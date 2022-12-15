<?php

	require_once '../../function/koneksi.php';
	require_once '../../function/session.php';

	$sql = "SELECT id_kat, kat
			FROM kat ORDER BY kat";
	$result = $koneksi->query($sql);

	$output = array('data' => array());

	if ($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {
	$id_kat = $row['id_kat'];
	//$button = '<a href="#editKategoriModal" role="button" class="btn btn-small btn-primary " id="editKategoriBtnModal" data-toggle="modal" onclick="editKategori('.$id_kat.')"> <i class="icon-pencil"></i>';
	$button = '<div class="btn-group">
         <button data-toggle="dropdown" class="btn btn-small btn-primary dropdown-toggle">Action <span class="caret"></span></button>
         <ul class="dropdown-menu">
             <li><a href="#editKategoriModal" onclick="editKategori('.$id_kat.')" data-toggle="modal"><i class="icon-pencil"></i> Edit</a></li>
             <li><a href="#hapusModalKategori" onclick="hapusKategori('.$id_kat.')" data-toggle="modal"><i class="icon-trash"></i> Hapus</a></li>
         </ul>
      </div>';

	$output['data'][] = array(
		$row['kat'],
		0,
		$button);
	}//while
	}//if
$koneksi->close();

echo json_encode($output);
?>