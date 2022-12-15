<?php
require_once '../../function/koneksi.php';
require_once '../../function/setjam.php';
require_once '../../function/session.php';
require_once '../../function/fungsi_rupiah.php';
require_once '../../function/tgl_indo.php';

if ($_POST) {

$idNota = $koneksi->real_escape_string($_POST['idNota']);


	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	
	$queryNota = "SELECT toko, total, keputusan, MONTH(tglNota) AS bulan , YEAR(tglNota) AS tahun, noReg
	FROM tblNota
	JOIN tblDetNota USING(idNota)
	LEFT JOIN claim USING(id_claim) WHERE idNota=$idNota GROUP BY toko";
	$resultNota = $koneksi->query($queryNota);
	$rowNota = $resultNota->fetch_array();	
	$bulanNota = $rowNota['bulan'] - 1;

	$queryPrint = "SELECT idNota, toko, brg, pattern, dot, jenis_claim, no_claim, nominal, total, no_urut, ket
	FROM tblNota
	JOIN tblDetNota USING(idNota)
	LEFT JOIN claim USING(id_claim)
	LEFT JOIN barang USING(id_brg) WHERE idNota=$idNota";
	$resultPrint = $koneksi->query($queryPrint);
	// $rowSatu = $resultPrint->fetch_array();

    echo '

<style type="text/css">
	.control-label {
		text-align: left;
		width: 300px;
	}

	label{
		display: block;
		margin-bottom: -10px; 
		font-size: 14px;
		font-weight: normal;
		line-height: 20px;
	}

	strong{
		font-weight: normal;
	}

	.titik2 {
		padding-left: 130px;
		margin-top: -20px;
		font-weight: bold;
	}

	#nota th, td{
		padding: 1px;
		margin: 1px;
		font-size: 14px;
	}

	label.oleh {
	    position: absolute;
	    margin-top: -145px;
	}

	label.tgl {
	    position: absolute;
	    margin-top: -122px;
	}

	label.noReg {
	    position: absolute;
	    margin-top: -99px;
	}

	.isi {
		padding-left: 82px;
		margin-top: -20px;
		font-weight: normal;
	}

	.mar{
		margin-top:-15px;
	}

	#mar{
		margin-top:-20px;
	}



</style>

    ';
if ($rowNota[2] == 'Tolak') 
{

	$tabel ='

			<table rules="none" border="1" width="100%">
				<thead>
				<tr>
					<td>
						<center>
							<h2>PT.KHARISMA UTAMA SENTOSA</h2>
							<p class="mar" id="mar">Kav.Industri Satria Raya No.9 Bandung 40224</p>
							<p class="mar">Phone : (022) 541.4550, (022) 541.0796 </p>
							<p style="text-decoration: underline; font-weight:bold;">TANDA TERIMA BERKAS CLAIM TOLAKAN</p>
							
						</center>
						<label class="control-label">
							<strong>Nama Toko</strong>
							<p class="titik2">: '.$rowNota[0].'</p>
						</label>

						<label class="control-label">
							<strong>Telah Terima Berupa</strong>
							<p class="titik2"> :</p>
						</label>

						<label class="oleh">
							<strong>Dicetak oleh</strong>
							<p class="isi">: '.$_SESSION['nama'].'</p>
						</label>

						<label class="tgl">
							<strong>Tanggal Cetak</strong>
							<p class="isi">: '.date("d-m-Y").'</p>
						</label>
						<label class="noReg">
							<strong>NO REG</strong>
							<p class="isi">: '.$rowNota['noReg'].'</p>
						</label>

						<table border="1" cellspacing="0" cellpadding="1" width="100%" id="nota">
							</thead>
								<tr>
									<th>NO</th>
									<th>TYPE</th>
									<th>NO.SERI</th>
									<th>NO.CLAIM</th>
									<th>KETERANGAN</th>
								</tr>';

								$no=1;
								while ($row = $resultPrint->fetch_array()) {
					  			$noSeri = $row['pattern'].'-'.$row['dot'].'-'.$row['jenis_claim'];

							$tabel .='
								<tr>
								    <td style="text-align:center;">'.$no.'</td>
								    <td style="text-align:left;">'.$row[2].'</td>
								    <td style="text-align:center;">'.$noSeri.'</td>
								    <td style="text-align:center;">'.$row[6].'</td>
								    <td style="text-align:center;">'.$row[10].'</td>
								</tr>
								';
							  	$no++;
								}

							$tabel .='								
							<thead>
						</table>

						<table width="100%">
								<tr>
									<th width="33%">Diterima Oleh,</th>
									<th width="33%">Bag.Claim</th>
									<th width="33%">Bag.Gudang</th>
								</tr>
							<tbody>
								<tr>
									<td style="padding-top:35px; text-align:center;">Nama Jelas dan Tanda Tangan</td>
									<td style="padding-top:35px; text-align:center;">Agus. S</td>
									<td style="padding-top:35px; text-align:center;">Budi atau Nana</td>
								</tr>	
							</tbody>
						</table>

						<table rules="none" border="1" width="100%"">
							<tr>
								<td>Ditanda tangani/stempel dan dikembaikan ke PT.KHARISMA UTAMA SENTOSA/ CV.KHARISMA TIARA ABADI</td>
							</tr>
						</table>
						<br />
					</td>
				</tr>

				</thead>
			</table>
	';
	 
}

else{

	$tabel ='
			<table rules="none" border="1" width="100%">
				<thead>
				<tr>
					<td>
						<center>
							<h2 style="font-size:28px; color:red;">PT.KHARISMA UTAMA SENTOSA</h2>
							<h2 style="margin-top: -18px;">Penggantian Claim '.$BulanIndo[(int)$bulanNota].' '.$rowNota['tahun'].'</h2>
							<p style="text-decoration: underline; font-weight:bold;">TANDA TERIMA</p>
							
						</center>
						<label class="control-label">
							<strong>Nama Toko</strong>
							<p class="titik2">: '.$rowNota[0].'</p>
						</label>

						<label class="control-label">
							<strong>Nominal</strong>
							<p class="titik2">: Rp. '.format_rupiah($rowNota[1]).'</p>
						</label>

						<label class="oleh">
							<strong>Dicetak oleh</strong>
							<p class="isi">: '.$_SESSION['nama'].'</p>
						</label>

						<label class="tgl">
							<strong>Tanggal Cetak</strong>
							<p class="isi">: '.date("d-m-Y").'</p>
						</label>
						<label class="noReg">
							<strong>NO REG</strong>
							<p class="isi">: '.$rowNota['noReg'].'</p>
						</label>

						<table border="1" cellspacing="0" cellpadding="1" width="100%" id="nota">
							</thead>
								<tr>
									<th>NO</th>
									<th>TYPE</th>
									<th>NO.SERI</th>
									<th>NO.CLAIM</th>
									<th>JML (RP)/PENGGANTIAN</th>
								</tr>';

								$no=1;
								while ($row = $resultPrint->fetch_array()) {
					  			$noSeri = $row['pattern'].'-'.$row['dot'].'-'.$row['jenis_claim'];

							$tabel .='
								<tr>
								    <td style="text-align:center;">'.$no.'</td>
								    <td style="text-align:left;">'.$row[2].'</td>
								    <td style="text-align:center;">'.$noSeri.'</td>
								    <td style="text-align:center;">'.$row[6].'</td>';

									if (preg_match("/[a-z-]/i", $row['nominal'])) {//[a-z] semua hufuf. i huruf besar & kecil

										$tabel .= '<td style="text-align:right;">'.$row['nominal'].'</td>';
										
									}else{
									
										$tabel .= '<td style="text-align:right;"> Rp. '.format_rupiah($row['nominal']).'</td>';

									}

							$tabel .='</tr>';
								    //<td style="text-align:right;">'.format_rupiah($row[7]).'</td>
							  	$no++;
								}

							$tabel .='	
								<tr>
									<td colspan="4" style="text-align:center; font-weight:bold">TOTAL</td>
									<td style="text-align:right; font-weight:bold;"> Rp. '.format_rupiah($rowNota[1]).'</td>
								</tr>							
							<thead>
						</table>

						<p style="margin-top: auto;">Keterangan</p>
						<p style="margin-top: -12; padding-left: 28px;">- Ditanda tangani / stempel toko & dikembalikan ke PT.Kharisma Utama Sentosa</p>

						<table width="100%">
								<tr>
									<th width="50%">MENGETAHUI</th>
									<th width="50%">MENYETUJUI</th>
								</tr>
							<tbody>
								<tr>
									<td style="padding-top:35px; text-align:center;">PT.KHARISMA UTAMA SENTOSA</td>
									<td style="padding-top:35px; text-align:center;">Tanda Tangan & Stempel</td>
								</tr>	
							</tbody>
						</table>

					</td>
				</tr>

				</thead>
			</table>
	';

}// END Keputusan Ganti dan Ganti SC



	$koneksi->close();
	echo $tabel;

}

?>
