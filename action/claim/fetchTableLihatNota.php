<?php
	require_once '../../function/koneksi.php';
	require_once '../../function/setjam.php';
	require_once '../../function/session.php';
	require_once '../../function/fungsi_rupiah.php';

	$idNota = $_POST['idNota'];

	$query = "SELECT no_urut, brg, pattern, dot, jenis_claim, no_claim, nominal
	FROM tblNota 
	JOIN tblDetNota USING(idNota)
	JOIN claim USING(id_claim)
	JOIN barang USING(id_brg)
	WHERE idNota=$idNota";

	$result = $koneksi->query($query);

	$output = array('data' => array());

	if ($result->num_rows > 0) {

		while ($row = $result->fetch_array()) {
			$noSeri = $row[2].'-'.$row[3].'-'.$row[4];

			if (preg_match("/[a-z-]/i", $row['nominal'])) {//[a-z] semua hufuf. i huruf besar & kecil

				$nominal = $row['nominal'];
				
			}else{
			
				$nominal = format_rupiah($row['nominal']);

			}
	
			$output['data'][] = array(
				$row[0],
				$row[1],
				$noSeri,
				$row[5],
				$nominal);
		}
	}
	$koneksi->close();

	echo json_encode($output);

?>
