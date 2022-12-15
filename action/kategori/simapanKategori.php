<?php
require_once '../../function/koneksi.php';
require_once '../../function/session.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	
	$kat       = $_POST['kat'];
	$namaLogin = $_SESSION['nama'];
	$tgl1      = date("Y-m-d H:i:s");
	$ket       = "Kategori ".$kat;

	$cek_kat = $koneksi->query("SELECT kat FROM kat WHERE kat='$kat'");

	if ($cek_kat->num_rows == 1) {
	 	$valid['success']  = 'cek_kat';
		$valid['messages'] = "<strong>Error! </strong> Nama Kategori Sudah Ada";
	 }else{

		$kat = "INSERT INTO kat (kat) VALUES ('$kat')";

		if ($koneksi->query($kat) === TRUE) {
			$insertLog = $koneksi->query("INSERT INTO log (nama, tgl, ket, action) VALUES('$namaLogin', '$tgl1', '$ket', 't')");
			$valid['success'] = true;
			$valid['messages'] = "<strong>Success! </strong>Data Berhasil Disimpan";	
		}else{
			$valid['success'] = false;
		 	$valid['messages'] = "<strong>Error! </strong>Data Gagal Disimpan. ".$koneksi->error;
		}
	 }

	$koneksi->close();

	echo json_encode($valid);

}

?>