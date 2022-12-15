<?php
require_once '../../function/koneksi.php';
require_once '../../function/session.php';
require_once '../../function/setjam.php';

	$valid['success'] = array('success' => false, 'messages' => array());

	if ($_POST) {
		$tgl       = date('Y-m-d', strtotime($_POST['tgl']));
		$no_claim   = $koneksi->real_escape_string($_POST['no_claim']);
		$no_urut   = $koneksi->real_escape_string($_POST['no_urut']);
		$daerah    = $koneksi->real_escape_string($_POST['daerah']);
		$dealer    = $koneksi->real_escape_string($_POST['dealer']);
		$toko      = $koneksi->real_escape_string($_POST['toko']);
		$areaToko  = $koneksi->real_escape_string($_POST['areaToko']);
		$sales     = $koneksi->real_escape_string($_POST['sales']);
		$id_brg    = $koneksi->real_escape_string($_POST['brg']);
		$pattern   = $koneksi->real_escape_string($_POST['pattern']);
		$dot       = $koneksi->real_escape_string($_POST['dot']);
		$jenis_claim     = $koneksi->real_escape_string($_POST['jenis_claim']);
		//die();  echo $areaToko;
		// $kerusakan = $koneksi->real_escape_string($_POST['kerusakan']);
		// $tread     = $koneksi->real_escape_string($_POST['tread']);
		// $keputusan = $koneksi->real_escape_string($_POST['keputusan']);
		// if ($keputusan == "Tolak") {
		// 	$nominal = 0;
		// }else{
		// 	$nominal = $koneksi->real_escape_string($_POST['nominal']);
		// }
		// $crown     = $_POST['crown'];
		// $sidewall  = $_POST['sidewall'];
		// $bead      = $_POST['bead'];
		// $inner     = $_POST['inner'];
		// $outher    = $_POST['outher'];
		// $dot   		= $_POST['dot'];
		// $serial   	= $_POST['serial'];
		// $crown   	= $_POST['crown'];
		// $sidewall   = $_POST['sidewall'];
		// $bead   	= $_POST['bead'];
		// $inner   	= $_POST['inner'];
		// $outher   	= $_POST['outher'];
		// $keputusan  = $_POST['keputusan'];

		// echo "tgl $tgl <br>";
		// echo "no_claim $no_claim <br>";
		// echo "daerah $daerah <br>";
		// echo "dealer $dealer <br>";
		// echo "toko $toko <br>";
		// echo "brg $brg <br>";
		// echo "brand $brand <br>";
		// echo "dot $dot <br>";
		// echo "serial $serial <br>";
		// echo "crown $crown <br>";
		// echo "sidewall $sidewall <br>";
		// echo "bead $bead <br>";
		// echo "inner $inner <br>";
		// echo "outher $outher <br>";
		// echo "keputusan $keputusan <br>";

		$query = "INSERT INTO claim (no_claim,
									 no_urut,
									 tgl, 
									 daerah,
									 dealer,
									 toko,
									 area_toko,
									 sales,
									 id_brg,
									 pattern,
									 dot,
									 jenis_claim,
									 kerusakan,
									 tread,
									 keputusan,
									 nominal)
							  VALUES('$no_claim',
							  		 '$no_urut',
							  		 '$tgl',
							  		 '$daerah', 
							  		 '$dealer',
							  		 '$toko',
									 '$areaToko',
							  		 '$sales',
							  		 '$id_brg',
							  		 '$pattern',
							  		 '$dot',
							  		 '$jenis_claim',
							  		 '-',
							  		 '0',
							  		 'Proses',
							  		 '0')";
									   //die();  echo $query;
		if ($koneksi->query($query) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "<strong>Success! </strong>Data Berhasil Disimpan";
		}else{
			$valid['success']  = false;
			$valid['messages'] = "<strong>Error! </strong> Data Gagal Disimpan ".$koneksi->error;
		}

		$koneksi->close();
		echo json_encode($valid);
	}
?>