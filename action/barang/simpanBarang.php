<?php
require_once '../../function/koneksi.php';
require_once '../../function/session.php';
require_once '../../function/setjam.php';

	$valid['success'] =  array('success' => false , 'messages' => array());
	
	if ($_POST) {
		
	$id_kat      = $_POST["id_kat"];
	$barang      = $_POST["barang"];
	//$barang      = 'GTX12';
	$nama = $_SESSION['nama'];
	$tgl = date("Y-m-d H:i:s");
	$ket ="Baru ".$barang;

	$cek_brg = $koneksi->query("SELECT brg FROM barang WHERE brg='$barang'");

	if ($cek_brg->num_rows == 1) {
		$valid['success']  = 'cek_brg';
		$valid['messages'] = "<strong>Error! </strong> Nama Barang Sudah Ada";
	}else{
		$query = "INSERT INTO barang (id_kat,
									  brg)
							   VALUES('$id_kat',
							   		  '$barang')";

		if ($koneksi->query($query) === TRUE) {
			$insertLog = $koneksi->query("INSERT INTO log (nama, tgl, ket, action) VALUES('$nama', '$tgl', '$ket', 't')");
			$valid['success']  = true;
			$valid['messages'] = "<strong>Success! </strong>Data Berhasil Disimpan";
		}else{
			$valid['success']  = false;
			$valid['messages'] = "<strong>Error! </strong> Data Gagal Disimpan ".$koneksi->error;
		}
		}

		$koneksi->close();

		echo json_encode($valid);
	}

?>