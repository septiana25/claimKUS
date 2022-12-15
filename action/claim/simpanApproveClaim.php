<?php
	require_once '../../function/koneksi.php';
	require_once '../../function/session.php';
	require_once '../../function/setjam.php';

	$id_claim      = $koneksi->real_escape_string($_POST['approveIdClaim']);
	$editKerusakan = $koneksi->real_escape_string($_POST['approveKerusakan']);
	$editKeputusan = $koneksi->real_escape_string($_POST['approveKeputusan']);
	// $editTread     = $koneksi->real_escape_string($_POST['editTread']);

	if ($editKeputusan == 'Tolak') {
		$nominalPusat = 0;
		$nominal = 0;

	}else{
		$nominalPusat   = $koneksi->real_escape_string($_POST['nominalPusat']);
		$nominal   = $koneksi->real_escape_string($_POST['approveNominal']);

	}

	$cekClaim = "SELECT no_urut FROM claim WHERE id_claim =$id_claim";
	$resClaim = $koneksi->query($cekClaim);
	$rowClaim = $resClaim->fetch_assoc();


	$nama = $_SESSION['nama'];
	$tgl = date("Y-m-d H:i:s");
	$ket ="No Urut ".$rowClaim['no_urut']." Approve ".$editKerusakan." & ". $editKeputusan ." & ". $nominal;

	$valid['success'] =  array('success' => false , 'messages' => array());

	if ($_POST) {

	$queryEditClaim = "UPDATE claim SET kerusakan= '$editKerusakan', keputusan= '$editKeputusan', nominal= '$nominal', nominal_pusat= '$nominalPusat' WHERE id_claim=$id_claim";
		
	if ($koneksi->query($queryEditClaim) === TRUE) {

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
?>