<?php
	require_once '../../function/koneksi.php';
	require_once '../../function/session.php';

	$valid['success'] =  array('success' => false , 'messages' => array());

	if ($_POST) {

	$id_kat = $_POST['editKategoriId'];
	$kat 	= $_POST['kat'];

	$query = "UPDATE kat SET kat ='$kat' WHERE id_kat=$id_kat";

	if ($koneksi->query($query) === TRUE) {
		$valid['success']  = true;
		$valid['messages'] = "<strong>Success! </strong>Data Berhasil Diubah";
	}else{
		$valid['success']  = false;
		$valid['messages'] = "<strong>Error! </strong> Data Gagal Diubah ".$koneksi->error;
	}

	$koneksi->close();

	echo json_encode($valid);
	}