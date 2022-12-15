<?php
require_once '../../function/koneksi.php';
require_once '../../function/setjam.php';
require_once '../../function/session.php';

	$valid['success'] =  array('success' => false , 'messages' => array());

	if ($_POST) {
		
	$id_brg = $_POST["id_brg"];
	$nama   = $_SESSION['nama'];
	$tgl    = date("Y-m-d H:i:s");

	$cek_Dbrg = $koneksi->query("SELECT id_brg FROM detail_brg WHERE id_brg=$id_brg");

	$cek_brg = $koneksi->query("SELECT brg FROM barang WHERE id_brg=$id_brg");
	$row     = $cek_brg->fetch_array();
	$brg     = $row[0];
	$ket     ="Hapus ".$brg;

	if ($cek_Dbrg->num_rows >= 1) {
		$valid['success']  = 'cek_brg';
		$valid['messages'] = "<strong>Data Tidak Bisa Dihapus</strong>";
		
	}else{
		$query = "DELETE FROM barang WHERE id_brg=$id_brg";
		if ($koneksi->query($query) === TRUE) {
			$insertLog = $koneksi->query("INSERT INTO log (nama, tgl, ket, action) VALUES('$nama', '$tgl', '$ket', 'd')");
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

?>