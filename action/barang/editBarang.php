<?php
require_once '../../function/koneksi.php';
require_once '../../function/setjam.php';
require_once '../../function/session.php';

	$valid['success'] =  array('success' => false , 'messages' => array());

	if ($_POST) {
		
	$id_kat = $_POST['id_kat'];
	$barang = $_POST['barang'];
	$id_brg = $_POST['editBarangId'];
	$nama = $_SESSION['nama'];
	$tgl = date("Y-m-d H:i:s");
	


	$cek_brg = $koneksi->query("SELECT brg FROM barang WHERE id_brg=$id_brg");
	$row     = $cek_brg->fetch_array();
	$brg = $row[0];
	$ket ="Edit ".$brg." Menjadi ".$barang;

		$query = "UPDATE barang SET brg ='$barang', id_kat=$id_kat WHERE id_brg=$id_brg";

		if ($koneksi->query($query) === TRUE) {
			$insertLog = $koneksi->query("INSERT INTO log (nama, tgl, ket, action) VALUES('$nama', '$tgl', '$ket', 'e')");
			$valid['success']  = true;
			$valid['messages'] = "<strong>Success! </strong>Data Berhasil Disimpan";
		}else{
			$valid['success']  = false;
			$valid['messages'] = "<strong>Error! </strong> Data Gagal Disimpan ".$koneksi->error;
		}

		$koneksi->close();

		echo json_encode($valid);
	}