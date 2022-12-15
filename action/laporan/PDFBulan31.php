<?php
$query = "SELECT s.rak, s.brg,
  IFNULL(saldo_awal, 0) AS s_awal,
  IFNULL(total_masuk,0) AS b_masuk,
  IFNULL(tgl_1, NULL) AS tgl_1, IFNULL(tgl_2, NULL) AS tgl_2,
  IFNULL(tgl_3, NULL) AS tgl_3, IFNULL(tgl_4, NULL) AS tgl_4,
  IFNULL(tgl_5, NULL) AS tgl_5, IFNULL(tgl_6, NULL) AS tgl_6,
  IFNULL(tgl_7, NULL) AS tgl_7, IFNULL(tgl_8, NULL) AS tgl_8,
  IFNULL(tgl_9, NULL) AS tgl_9, IFNULL(tgl_10, NULL) AS tgl_10,
  IFNULL(tgl_11, NULL) AS tgl_11, IFNULL(tgl_12, NULL) AS tgl_12,
  IFNULL(tgl_13, NULL) AS tgl_13, IFNULL(tgl_14, NULL) AS tgl_14,
  IFNULL(tgl_15, NULL) AS tgl_15, IFNULL(tgl_16, NULL) AS tgl_16,
  IFNULL(tgl_17, NULL) AS tgl_17,
  IFNULL(tgl_18, NULL) AS tgl_18, IFNULL(tgl_19, NULL) AS tgl_19,
  IFNULL(tgl_20, NULL) AS tgl_20, IFNULL(tgl_21, NULL) AS tgl_21,
  IFNULL(tgl_22, NULL) AS tgl_22, IFNULL(tgl_23, NULL) AS tgl_23,
  IFNULL(tgl_24, NULL) AS tgl_24, IFNULL(tgl_25, NULL) AS tgl_25,
  IFNULL(tgl_26, NULL) AS tgl_26, IFNULL(tgl_27, NULL) AS tgl_27,
  IFNULL(tgl_28, NULL) AS tgl_28, IFNULL(tgl_29, NULL) AS tgl_29,
  IFNULL(tgl_30, NULL) AS tgl_30, IFNULL(tgl_31, NULL) AS tgl_31,
  IFNULL(total_keluar,0) AS total_keluar,
  IFNULL(saldo_akhir, 0) AS s_akhir
FROM(
  SELECT rak, brg, saldo_awal, saldo_akhir
  FROM `detail_brg`
  JOIN saldo ON `detail_brg`.`id`=saldo.`id`
  JOIN barang ON `detail_brg`.`id_brg`=barang.`id_brg`
  JOIN rak ON detail_brg.`id_rak`=rak.`id_rak`
  WHERE MONTH(tgl)=$bulan AND YEAR(tgl)=$tahun
  GROUP BY rak, brg
)s 
LEFT JOIN(
  SELECT rak, brg, tgl, SUM(jml_klr) AS total_keluar,
    SUM( IF( DAY(tgl)=1, jml_klr, NULL)) AS tgl_1,
    SUM( IF( DAY(tgl)=2, jml_klr, NULL)) AS tgl_2,
    SUM( IF( DAY(tgl)=3, jml_klr, NULL)) AS tgl_3,
    SUM( IF( DAY(tgl)=4, jml_klr, NULL)) AS tgl_4,
    SUM( IF( DAY(tgl)=5, jml_klr, NULL)) AS tgl_5,
    SUM( IF( DAY(tgl)=6, jml_klr, NULL)) AS tgl_6,
    SUM( IF( DAY(tgl)=7, jml_klr, NULL)) AS tgl_7,
    SUM( IF( DAY(tgl)=8, jml_klr, NULL)) AS tgl_8,
    SUM( IF( DAY(tgl)=9, jml_klr, NULL)) AS tgl_9,
    SUM( IF( DAY(tgl)=10, jml_klr, NULL)) AS tgl_10,
    SUM( IF( DAY(tgl)=11, jml_klr, NULL)) AS tgl_11,
    SUM( IF( DAY(tgl)=12, jml_klr, NULL)) AS tgl_12,
    SUM( IF( DAY(tgl)=13, jml_klr, NULL)) AS tgl_13,
    SUM( IF( DAY(tgl)=14, jml_klr, NULL)) AS tgl_14,
    SUM( IF( DAY(tgl)=15, jml_klr, NULL)) AS tgl_15,
    SUM( IF( DAY(tgl)=16, jml_klr, NULL)) AS tgl_16,
    SUM( IF( DAY(tgl)=17, jml_klr, NULL)) AS tgl_17,
    SUM( IF( DAY(tgl)=18, jml_klr, NULL)) AS tgl_18,
    SUM( IF( DAY(tgl)=19, jml_klr, NULL)) AS tgl_19,
    SUM( IF( DAY(tgl)=20, jml_klr, NULL)) AS tgl_20,
    SUM( IF( DAY(tgl)=21, jml_klr, NULL)) AS tgl_21,
    SUM( IF( DAY(tgl)=22, jml_klr, NULL)) AS tgl_22,
    SUM( IF( DAY(tgl)=23, jml_klr, NULL)) AS tgl_23,
    SUM( IF( DAY(tgl)=24, jml_klr, NULL)) AS tgl_24,
    SUM( IF( DAY(tgl)=25, jml_klr, NULL)) AS tgl_25,
    SUM( IF( DAY(tgl)=26, jml_klr, NULL)) AS tgl_26,
    SUM( IF( DAY(tgl)=27, jml_klr, NULL)) AS tgl_27,
    SUM( IF( DAY(tgl)=28, jml_klr, NULL)) AS tgl_28,
    SUM( IF( DAY(tgl)=29, jml_klr, NULL)) AS tgl_29,
    SUM( IF( DAY(tgl)=30, jml_klr, NULL)) AS tgl_30,
    SUM( IF( DAY(tgl)=31, jml_klr, NULL)) AS tgl_31
  FROM detail_keluar
  LEFT JOIN keluar USING (id_klr)
  LEFT JOIN detail_brg USING(id)
  RIGHT JOIN barang USING(id_brg)
  LEFT JOIN rak USING(id_rak)
  WHERE MONTH(tgl)=$bulan AND YEAR(tgl)=$tahun
  GROUP BY rak, brg
)k ON k.brg=s.brg AND k.rak=s.rak
LEFT JOIN(
  SELECT rak, brg, tgl, SUM( IFNULL(jml_msk, 0)) AS total_masuk
  FROM detail_brg
  LEFT JOIN masuk USING(id)
  LEFT JOIN detail_masuk USING(id_msk)
  RIGHT JOIN barang USING(id_brg)
  LEFT JOIN rak USING(id_rak)
  WHERE MONTH(tgl)=$bulan AND YEAR(tgl)=$tahun
  GROUP BY rak, brg
)m ON s.brg=m.brg AND s.rak=m.rak";
$datas = $koneksi->query($query);


class PDF extends FPDF{

	function Header(){
		global $title;
		$w = $this->GetStringWidth($title)+6;
    	$this->SetX((420-$w)/2);
		// Logo
	    //$this->Image('../../function/api/fpdf/tutorial/logo.png',10,6,30);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Thickness of frame (1 mm)
    	$this->SetLineWidth(1);
	    // Title
	    $this->Cell($w,10,$title,0,0,'C');
	    // Line break
	    $this->Ln(20);
	}

	// Load data
	function LoadData($file)
	{
	    // Read file lines
	    $lines = file($file);
	    $data = array();
	    foreach($lines as $line)
	        $data[] = explode(';',trim($line));
	    return $data;
	}


	// function Chapter($num, $label){
	//     // Arial 12
	//     $this->SetFont('Times','B',12);
	//     // Background color
	//     $this->SetFillColor(200,220,255);
	//     // Title
	//     $this->Cell(0,6,"Chapter $num $label",0,1,'L',true);
	//     // Line break
	//     $this->Ln(4);
	// }

	function Mybody($file, $type, $datas){
		if ($type=='file') {
		    // Read text file
		    $txt = file_get_contents($file);
		    // Times 12
		    $this->SetFont('Times','',12);
		    // Output justified text
		    $this->MultiCell(0,5,$txt);
		    // Line break
		    $this->Ln();
		}else if ($type=='csv') {
		    // Column widths
		    $w = array(40, 35, 40, 45);
		    // Header
		    for($i=0;$i<count($datas);$i++)
		        $this->Cell($w[$i],7,$datas[$i],1,0,'C');
		    $this->Ln();
		    // Data
		    foreach($file as $row)
		    {
		        $this->Cell($w[0],6,$row[0],'LR');
		        $this->Cell($w[1],6,$row[1],'LR');
		        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
		        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
		        $this->Ln();
		    }
		    // Closing line
		    $this->Cell(array_sum($w),0,'','T');
		}else if($type == 'database'){
			$this->Ln();
			$this->SetFont('Times','B',10);
			$this->Cell(14,5,'Rak',1,0,'C');
			$this->Cell(75,5,'Nama Barang',1,0,'C');
			$this->Cell(14,5,'S.Awal',1,0,'C');
			$this->Cell(14,5,'B.Masuk',1,0,'C');
			$this->Cell(8,5,'1',1,0,'C');
			$this->Cell(8,5,'2',1,0,'C');
			$this->Cell(8,5,'3',1,0,'C');
			$this->Cell(8,5,'4',1,0,'C');
			$this->Cell(8,5,'5',1,0,'C');
			$this->Cell(8,5,'6',1,0,'C');
			$this->Cell(8,5,'7',1,0,'C');
			$this->Cell(8,5,'8',1,0,'C');
			$this->Cell(8,5,'9',1,0,'C');
			$this->Cell(8,5,'10',1,0,'C');
			$this->Cell(8,5,'11',1,0,'C');
			$this->Cell(8,5,'12',1,0,'C');
			$this->Cell(8,5,'13',1,0,'C');
			$this->Cell(8,5,'14',1,0,'C');
			$this->Cell(8,5,'15',1,0,'C');
			$this->Cell(8,5,'16',1,0,'C');
			$this->Cell(8,5,'17',1,0,'C');
			$this->Cell(8,5,'18',1,0,'C');
			$this->Cell(8,5,'19',1,0,'C');
			$this->Cell(8,5,'20',1,0,'C');
			$this->Cell(8,5,'21',1,0,'C');
			$this->Cell(8,5,'22',1,0,'C');
			$this->Cell(8,5,'23',1,0,'C');
			$this->Cell(8,5,'24',1,0,'C');
			$this->Cell(8,5,'25',1,0,'C');
			$this->Cell(8,5,'26',1,0,'C');
			$this->Cell(8,5,'27',1,0,'C');
			$this->Cell(8,5,'28',1,0,'C');
			$this->Cell(8,5,'29',1,0,'C');
			$this->Cell(8,5,'30',1,0,'C');
			$this->Cell(8,5,'31',1,0,'C');
			$this->Cell(14,5,'T.Keluar',1,0,'C');
			$this->Cell(14,5,'S.Akhir',1,0,'C');
			$this->Ln();
			while ($row = $datas->fetch_array()) {
				$this->Cell(14,5,$row[0],1,0,'C');
				$this->Cell(75,5,$row[1],1,0,'L');
				$this->Cell(14,5,$row[2],1,0,'C');
				$this->Cell(14,5,$row[3],1,0,'C');
				$this->Cell(8,5,$row[4],1,0,'C');
				$this->Cell(8,5,$row[5],1,0,'C');
				$this->Cell(8,5,$row[6],1,0,'C');
				$this->Cell(8,5,$row[7],1,0,'C');
				$this->Cell(8,5,$row[8],1,0,'C');
				$this->Cell(8,5,$row[9],1,0,'C');
				$this->Cell(8,5,$row[10],1,0,'C');
				$this->Cell(8,5,$row[11],1,0,'C');
				$this->Cell(8,5,$row[12],1,0,'C');
				$this->Cell(8,5,$row[13],1,0,'C');
				$this->Cell(8,5,$row[14],1,0,'C');
				$this->Cell(8,5,$row[15],1,0,'C');
				$this->Cell(8,5,$row[16],1,0,'C');
				$this->Cell(8,5,$row[17],1,0,'C');
				$this->Cell(8,5,$row[18],1,0,'C');
				$this->Cell(8,5,$row[19],1,0,'C');
				$this->Cell(8,5,$row[20],1,0,'C');
				$this->Cell(8,5,$row[21],1,0,'C');
				$this->Cell(8,5,$row[22],1,0,'C');
				$this->Cell(8,5,$row[23],1,0,'C');
				$this->Cell(8,5,$row[24],1,0,'C');
				$this->Cell(8,5,$row[25],1,0,'C');
				$this->Cell(8,5,$row[26],1,0,'C');
				$this->Cell(8,5,$row[27],1,0,'C');
				$this->Cell(8,5,$row[28],1,0,'C');
				$this->Cell(8,5,$row[29],1,0,'C');
				$this->Cell(8,5,$row[30],1,0,'C');
				$this->Cell(8,5,$row[31],1,0,'C');
				$this->Cell(8,5,$row[32],1,0,'C');
				$this->Cell(8,5,$row[33],1,0,'C');
				$this->Cell(8,5,$row[34],1,0,'C');
				$this->Cell(14,5,$row[35],1,0,'C');
				$this->Cell(14,5,$row[36],1,0,'C');
				$this->Ln();
			}
			/*foreach ($datas as $row) {
				$this->Cell(20,7,$row['id_det_klr'],1,0,'C');
				$this->Cell(25,7,$row['id_klr'],1,0,'C');
				$this->Cell(25,7,$row['id'],1,0,'C');
				$this->Cell(25,7,$row['jml_klr'],1,0,'C');
				$this->Cell(25,7,$row['jam'],1,0,'C');
				$this->Ln();
			}
*/		}

	}

	function Layout($num, $label, $file, $type, $datas){
		
		//$this->Chapter($num,$label);
		$this->Mybody($file,$type,$datas);
	}

	function Footer(){
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Times','',12);
	    // Page number
	    $this->Cell(0,10,$this->PageNo(),0,0,'R');
	}
}
?>