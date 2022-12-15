<?php
	require_once '../../function/koneksi.php';
	require_once '../../function/session.php';
	require_once '../../function/setjam.php';

	$id_claim    = $koneksi->real_escape_string($_POST['editIdClaim']);
	$editToko    = $koneksi->real_escape_string($_POST['editToko']);
	$editUkuran  = $koneksi->real_escape_string($_POST['editUkuran']);
	$editPattern = $koneksi->real_escape_string($_POST['editPattern']);
	$editDOT     = $koneksi->real_escape_string($_POST['editDOT']);
	$editTahun   = $koneksi->real_escape_string($_POST['editTahun']);

	$cekClaim = "SELECT no_urut FROM claim WHERE id_claim =$id_claim";
	$resClaim = $koneksi->query($cekClaim);
	$rowClaim = $resClaim->fetch_assoc();

	$nama = $_SESSION['nama'];
	$tgl = date("Y-m-d H:i:s");
	$ket ="No Urut ".$rowClaim['no_urut']." Edit Claim";

	$valid['success'] =  array('success' => false , 'messages' => array());

	if ($_POST) {

	$queryEditClaim = "UPDATE claim SET toko= '$editToko', id_brg= '$editUkuran', pattern= '$editPattern', dot= '$editDOT', jenis_claim= '$editTahun' WHERE id_claim=$id_claim";
		
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
