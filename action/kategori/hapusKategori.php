<?php
	require_once '../../function/koneksi.php';
	require_once '../../function/session.php';

	$valid['success'] =  array('success' => false , 'messages' => array());

	if ($_POST) {

	$id_kat = $_POST['id_kat'];

	$cek_kat =$koneksi->query("SELECT * FROM barang WHERE id_kat = $id_kat");
	if ($cek_kat->num_rows >= 1) {
		$valid['success']  = 'cek_kat';
		$valid['messages'] = "<strong>Data Tidak Boleh Dihapus</strong>";
	}else{
		$query = "DELETE FROM kat WHERE id_kat= $id_kat";
		if ($koneksi->query($query) === TRUE) {
			$valid['success']  = true;
			$valid['messages'] = "<strong>Data Berhasil Dihapus</strong>";
		}else{
			$valid['success']  = false;
			$valid['messages'] = "<strong>Data Gagal Dihapus </strong>".$koneksi->error;
		}
	}

	$koneksi->close();

	echo json_encode($valid);
	}