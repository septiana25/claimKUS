<?php

	require_once '../../function/koneksi.php';
	require_once '../../function/setjam.php';
	require_once '../../function/session.php';


	$tahun          = date("Y");
	$bulan          = date("m");
	$sql = "SELECT id_brg, brg
			FROM barang ORDER BY brg ASC";


	$result = $koneksi->query($sql);

	$output = array('data' => array());

	if ($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {
	$id_brg = $row['id_brg'];
	//$id = $row[1];
	//$tgl = TanggalIndo($row['tgl']);
	//$tgl = tgl_indo($row[2]);
	// $button = '<div class="btn-group">
 //                 <button data-toggle="dropdown" class="btn btn-small btn-primary dropdown-toggle">Action <span class="caret"></span></button>
 //                 <ul class="dropdown-menu">
 //                     <li><a href="#"><i class="icon-edit"></i> Edit</a></li>                                         
 //                 </ul>
 //               </div>';
	//$button = '<a href="#editModalBarang" role="button" class="btn btn-small btn-primary tambah" id="editBarangBtnModal" data-toggle="modal" onclick="editBarang('.$id_brg.')"> <i class="icon-pencil"></i>';

	$button = '<div class="btn-group">
         <button data-toggle="dropdown" class="btn btn-small btn-primary dropdown-toggle">Action <span class="caret"></span></button>
         <ul class="dropdown-menu">
             <li><a href="#editModalBarang" onclick="editBarang('.$id_brg.')" data-toggle="modal"><i class="icon-pencil"></i> Edit</a></li>
             <li><a href="#hapusModalBarang" onclick="hapusBarang('.$id_brg.')" data-toggle="modal"><i class="icon-trash"></i> Hapus</a></li>
         </ul>
      </div>';
	   


	$output['data'][] = array(
		0,
		$row['brg'],
		0,
		0,
		$button);
	}//while
	}//if
$koneksi->close();

echo json_encode($output);
?>