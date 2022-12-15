<?php require_once 'function/koneksi.php';
      require_once 'function/setjam.php';
      require_once 'function/session.php';
      require_once 'function/fungsi_rupiah.php';

      $tahun          = date("Y");
      $tahun1          = date("y");
      $bulan          = date("m");
      /* $arrBLN         = ['JAN', 'FEB', 'MAR', 'APR', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];
      $register       = $arrBLN[(int)$bulan - 1].'/'.$tahun.'/'; */

      // $cek_saldo = $koneksi->query("SELECT id_saldo FROM saldo WHERE MONTH(tgl)=$bulan AND YEAR(tgl)=$tahun");
      // if ($cek_saldo->num_rows >=1 ) {

      require_once 'include/header.php';
?>
      <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
      <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<?php
      require_once 'include/menu.php';

      //query barang
      
      //query rak

        

      if ($_GET['p'] == "print") {
        $id_c = $_GET['id'];
        $queryCekClaim = "SELECT toko, keputusan  FROM claim WHERE id_claim=$id_c";
        $resultCekClaim = $koneksi->query($queryCekClaim);
        $rowCek = $resultCekClaim->fetch_array();
        $toko      = $rowCek['toko'];
        $keputusan = $rowCek['keputusan'];

        //cek no urut_reg terbesar


        echo "<div class='div-request div-hide'>Nota</div>";
      ?> 

      <!-- BEGIN PAGE -->  
      <div id="main-content">

         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                   <h3 class="page-title">
                     Cetak Nota Penggantian / Tolakan

                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Transaksi Barang</a>
                           <span class="divider">/</span>
                       </li>
                       <li class="active">
                           Cetak Nota Penggantian
                       </li>

                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <div id="hapus-pesan"></div>
            <!-- BEGIN ADVANCED TABLE widget-->
            <div class="row-fluid">
                <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget red">
                    <div class="widget-title">
                        <!-- <a href="#myModal1" role="button" class="btn btn-primary tambah" id="addBarangKlrBtnModal" data-toggle="modal"> <i class=" icon-plus"></i>Tambah Data</a> -->
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <!-- <a href="javascript:;" class="icon-remove"></a> -->
                            </span>
                    </div>
                    <div class="widget-body">
                      <?php
                        $no = 1;
                        $queryClaim = "SELECT id_claim, no_urut, no_claim, brg, pattern, dot, jenis_claim, nominal FROM claim JOIN barang USING(id_brg) WHERE nota='N' AND toko='$toko' AND keputusan='$keputusan' LIMIT 0,10";
                        $resultClaim = $koneksi->query($queryClaim);
                        $cekRow = $resultClaim->num_rows;
                        // echo "total Row ".$cekRow;
                        if ($resultClaim->num_rows == 0) {
                          echo '<div class="hiddenBtn div-hide">hiddenBtn</div>';
                        }

                        $queryNoReg = "SELECT noReg FROM tblNota ORDER BY idNota DESC LIMIT 0,1";
                        $resultNoReg = $koneksi->query($queryNoReg);
                        $rowNoReg = $resultNoReg->fetch_array();
                        $nourut      = $rowNoReg['noReg'];
                        $noarray = explode("/", $nourut);
                        /* if (date("m") == 12) {
                          $date = "JAN";
                        }else{
                          $date = date("M") + 1;
                        } */
                        //$date = date("M", strtotime("next month"));
			$date = date("M");

                        if($noarray[1] == date("Y")){
                            if($noarray[0] == strtoupper($date)){
                                
                                $pjnNo = strlen($noarray[2]+1);
                                if($pjnNo == 1){
                                    $noAwal = "00";
                                }else if($pjnNo == 2){
                                    $noAwal = "0";
                                }else{
                                    $noAwal = '';
                                }
                                $noNext = intval($noarray[2])+1;
                                $register= strtoupper($date)."/".date("Y")."/";
                                $noReg = $noAwal.$noNext;
                            }else{
                                $register= strtoupper($date)."/".date("Y")."/";
                                $noReg = "001";
                            }
                        }else{
                            $register= strtoupper($date)."/".date("Y")."/";
                            $noReg = "001";
                        }

                      ?>
                      <form class="cmxform form-horizontal" action="action/claim/simpanNotaPenggantian.php" id="submitNota" method="POST">
                      <!-- Hitung id Claim  -->
                        <input id="totalID" name="totalID" type="hidden" value="<?php echo $cekRow; ?>" />
                        
                          <table class="table">
                            <tr>
                              <th>Nama Toko</th>
                              <th colspan="2">No Register</th>
                              <th></th>
                              <th>Keputusan</th>
                            </tr>
                            <tbody>
                              <tr>

                                <td>
                                  <input id="toko" name="toko" type="text" class="input-xlarge" value="<?php echo $toko; ?>" readonly="true" />
                                </td>

                                <!-- <td>
                                  <div class="input-append date datepicker" id="dp3" data-date="<?php echo date("d-m-Y") ?>" data-date-format="dd-mm-yyyy">
                                    <input id="tgl" name="tgl" class="input-small" size="16" type="text" value="<?php echo date("d-m-Y") ?>" readonly="">
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                  </div>
                                    <input id="noReg" name="noReg" type="text" class="input-small" value="" minlength="3" maxlength="3" placeholder="3 Digit Terakhir" />
                                    <p class="help-block catatan">*KTA0717 3 Digit Terakhir</p>

                                </td> -->
                                <td>
                                  <input id="register" name="register" type="hidden" class="input-small" value="<?=$register?>" />
                                  <input id="noReg" name="noReg" type="hidden" class="input-small" value="<?=$noReg?>"/>
                                </td>
                                <td>
                                  <span class="label label-default"><?=$register?></span>
                                  <span class="label label-default"><?=$noReg?></span>
                                </td>
                                <td>
                                  <input id="keputusan" name="keputusan" type="hidden" class="input-small" value="<?= $keputusan; ?>" />
                                </td>

                                <td>
                                  <span class="label label-success"><?= $keputusan; ?></span>
                                </td>

                              </tr>
                            </tbody>
                          </table>
  
                          <table class="table table-striped table-bordered" id="">
                              <thead>
                              <!-- <tr>
                                <th colspan="5"></th>
                                <th colspan="5"><center>Kerusakan</center></th>
                                <th></th>
                              </tr> -->

                              <tr>
                                  <th >No</th>
                                  <th >Type</th>
                                  <th >No Seri</th>
                                  <!-- <th >No Claim</th> -->
                                  <!-- <th >No CM</th> -->
                                  <th >Tgl CM</th>
                                  <th >Nominal</th>
                                  <th >Keterangan</th>

                              </tr>
                              </thead>
                              <tbody>
                              
                              <?php
                                /*<td>'.$row['no_claim'].'</td>*/
                                $total = "";
                                while ($row = $resultClaim->fetch_array()) {
                                $noSeri = $row['pattern'].'-'.$row['dot'];
                                echo '
                                <tr>
                                  <td>'.$no.'</td>
                                  <td>'.$row['brg'].'</td>
                                  <td>'.$noSeri.'
                                  <input id="noSeri'.$no.'" name="noSeri'.$no.'" type="hidden" value="'.$noSeri.'" />
                                  </td>

                                  <input id="id_claim'.$no.'" name="id_claim'.$no.'" type="hidden" value="'.$row['id_claim'].'" />

                                  <td style="display: none">
                                  <input id="noCM'.$no.'" name="noCM'.$no.'" type="hidden" value="-" maxlength="9" class="input-small" placeholder="Credit Memo" required="true" readonly/>
                                      
                                  </td>
                                  <td>
                                  <div class="input-append date datepicker" id="dp3" data-date="'.date("d-m-Y").'" data-date-format="dd-mm-yyyy">
                                    <input id="tglCM'.$no.'" name="tglCM'.$no.'" class="input-small" size="16" type="text" value="'.date("d-m-Y").'" readonly="">
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                  </div>
                                  </td>';

                                  if (preg_match("/[a-z]/i", $row['nominal'])) {//[a-z] semua hufuf. i huruf besar & kecil

                                    echo '<td style="text-align: right;">'.$row['nominal'].'</td>
					  <td>-</td>';
                                    $subTotal = 0;
                                    
                                  }else{
                                  
                                    echo '<td style="text-align: right;">'.format_rupiah($row['nominal']).'</td>'; 
                                
				                            $subTotal = $row['nominal'];
                                  }

                                  //<td style="text-align: right;">'.format_rupiah($row['nominal']).'</td>

                                echo '
                                  <td>
                                    <input id="ket'.$no.'" name="ket'.$no.'" type="text" class="input-medium" placeholder="Keterangan" required="true" onkeydown="HurufBesar(this)"/>
                                  </td>
                                </tr>';
                                $total +=$subTotal;
                                $no++;
                                 } ?>
                                
                                  <input id="total" name="total" type="hidden" class="input-small" value="<?php echo $total; ?>" />

                                <tr>
                                  <td colspan="4" style="text-align: center; font-weight: bold;">Total</td>
                                  <td style="text-align: right; font-weight: bold;"><?php echo format_rupiah($total); ?></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td colspan="7" style="text-align: center;" class="print">
                                    <button class="btn btn-primary" id="simpanNotaBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-floppy-o"></i> Simpan</button>
                                  </td>
                                </tr>
                              </tbody>
                          </table>
                      </form>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE widget-->
                </div>
            </div>
            <!-- END ADVANCED TABLE widget-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->

      <?php
      }else{
        echo "<div class='div-request div-hide'>dataClaim</div>";
?>
    <!-- TABEL DATA CLAIM -->

      <!-- BEGIN PAGE -->  
      <div id="main-content">

         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                   <h3 class="page-title">
                    Data Claim
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Transaksi Barang</a>
                           <span class="divider">/</span>
                       </li>
                       <li class="active">
                           Claim
                       </li>

                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <div id="hapus-pesan"></div>
            <!-- BEGIN ADVANCED TABLE widget-->
            <div class="row-fluid">
                <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget red">
                    <div class="widget-title">
                        <a href="#myModalLaporan" role="button" class="btn btn-primary tambah" id="addBarangKlrBtnModal" data-toggle="modal" onclick="laporanProses()"> <i class=" fa fa-file-text-o "></i> Laporan Proses</a>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <!-- <a href="javascript:;" class="icon-remove"></a> -->
                            </span>
                    </div>
                    <div class="widget-body">

                        <table class="table table-striped table-bordered" id="tabelClaim">
                            <thead>
                            <!-- <tr>
                              <th colspan="5"></th>
                              <th colspan="5"><center>Kerusakan</center></th>
                              <th></th>
                            </tr> -->
                            <tr>
                                <th>No Urut</th>
                                <th>No Claim</th>
                                <th>Tanggal</th>
                                <th>Toko</th>
                                <th>Sales</th>
                                <th>Ukuran</th>
                                <th>Kerusakan</th>
                                <th>Keputusan</th>
                                <th>Nominal</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                        
                            </tbody>
                        </table>
                    </div>

                  <!-- BEGIN MODAL APPROVE CLAIM-->
                    <div id="modalApprove" class="modal modal-form hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel1" class="center"><i class="fa fa-check-square-o"></i> Approve Claim</h3>
                        </div>
                        <form class="cmxform form-horizontal" id="submitApproveClaim" action="action/claim/simpanApproveClaim.php" method="POST" >
                            <div class="modal-body modal-full">

                            <div class="modal-loading" style="width:50px; margin:auto;">
                              <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                              <span class="sr-only">Loading...</span>
                            </div>

                              <div class="control-group">
                                  <label class="control-label">Toko</label>
                                  <div class="controls">
                                    <input class="span7" id="approveToko" name="approveToko" type="text" readonly="true">
                                  </div>
                              </div>
                              <div class="control-group">
                                  <label class="control-label">Ukuran</label>
                                  <div class="controls">
                                    <input class="span10" id="approveUkuran" name="approveUkuran" type="text" readonly="true">
                                  </div>
                              </div>

                              <div class="control-group">
                                  <label class="control-label">No Seri</label>
                                  <div class="controls">
                                    <input class="span10" id="approveNoSeri" name="approveNoSeri" type="text" readonly="true">
                                  </div>
                              </div>

                              <div class="control-group">
                                  <label class="control-label">Kerusakan</label>
                                  <div class="controls">
                                    <input class="span10" id="approveKerusakan" name="approveKerusakan" type="text" placeholder="Input Kerusakan" autocomplete="off" onkeydown="HurufBesar(this)">
                                  </div>
                                  <div id="suggesstion-box"></div>
                              </div>

                              <div class="control-group">
                                  <label class="control-label">Keputusan</label>
                                  <div class="controls">
                                    <select id="approveKeputusan" name="approveKeputusan" class="span7" tabindex="1">
                                      <option value="">Pilih Keputusan</option>
                                      <option value="Ganti BL GT">Ganti BL GT</option>
                                      <option value="Ganti BD GT">Ganti BD GT</option>
                                      <option value="Ganti FLAP">Ganti FLAP</option>
                                      <option value="Ganti BL IRC">Ganti BL IRC</option>
                                      <option value="Ganti BD IRC">Ganti BD IRC</option>
                                      <option value="Ganti BL ZENEOS">Ganti BD ZENEOS</option>
                                      <option value="Kompensasi BL GT">Kompensasi BL GT</option>
                                      <option value="Kompensasi BD GT">Kompensasi BD GT</option>
                                      <option value="Kompensasi BL IRC">Kompensasi BL IRC</option>
                                      <option value="Kompensasi BD IRC">Kompensasi BD IRC</option>
                                      <option value="Kompensasi BL ZENEOS">Kompensasi BL ZENEOS</option>
                                      <option value="GOODWILL">GOODWILL</option>
                                      <option value="Tolak">Tolak</option>
                                    </select>
                                  </div>
                              </div>                              

                              <!-- <div class="control-group">
                                  <label class="control-label"> Tread Dept</label>
                                  <div class="controls">
                                    <input class="span10" id="editTread" name="editTread" type="text" placeholder="Input Tread Dept">
                                  </div>
                              </div> -->
                              <div class="control-group">
                                  <label class="control-label">Nominal GT</label>
                                  <div class="controls">
                                    <input class="span7" id="nominalPusat" name="nominalPusat" type="text" placeholder="Input Besar Nominal Goodyear" onkeydown="HurufBesar(this)">
                                  </div>
                              </div>
                              <div class="control-group">
                                  <label class="control-label">Nominal</label>
                                  <div class="controls">
                                    <input class="span7" id="approveNominal" name="approveNominal" type="text" placeholder="Input Besar Nominal/Jenis Penggantian" onkeydown="HurufBesar(this)">
                                    <p class="help-block catatan">*Jika Tolak Isi 0. *Bisa Mengetikan Huruf</p>
                                  </div>
                              </div>

                                <div class="control-group">
                                  <div id="approve-pesan"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" id="simpanApproveClaimBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-floppy-o"></i> Simpan</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Close</button>
                            </div>
                        </form>
                    </div>
                  <!-- END MODAL APPROVE CLAIM-->

                  <!-- BEGIN MODAL EDIT CLAIM-->
                    <div id="modalEdit" class="modal modal-form hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel1" class="center"><i class="fa fa-edit"></i> Edit Claim</h3>
                        </div>
                        <form class="cmxform form-horizontal" id="submitEditClaim" action="action/claim/simpanEditClaim.php" method="POST" >
                            <div class="modal-body modal-full">
                            <div class="modal-loading" style="width:50px; margin:auto;">
                              <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                              <span class="sr-only">Loading...</span>
                            </div>
                            <div class="control-group">
                                  <label class="control-label">No Claim</label>
                                  <div class="controls">
                                    <input class="span7" id="editNoClaim" name="editNoClaim" type="text" placeholder="Input No Claim">
                                  </div>
                              </div>
                              <div class="control-group">
                                  <label class="control-label">Toko</label>
                                  <div class="controls">
                                    <input class="span7" id="editToko" name="editToko" type="text" placeholder="Input Toko">
                                  </div>
                              </div>
                              <div class="control-group">
                                  <label class="control-label">Ukuran</label>
                                  <div class="controls">
                                    <select id="editUkuran" name="editUkuran" class="span12">
                                    <option value="">Pilih Ukuran</option>
                                    <?php
                                    $ukuran = $koneksi->query("SELECT id_brg, brg FROM barang ORDER BY brg ASC");
                                    while ($brg = $ukuran->fetch_array()) {
                                      echo '<option value="'.$brg[0].'">'.$brg[1].'</option>';
                                    }
                                    ?>
                                    </select>
                                  </div>
                              </div>

                              <div class="control-group">
                                  <label class="control-label">Pattern</label>
                                  <div class="controls">
                                    <input class="span7" id="editPattern" name="editPattern" type="text" placeholder="Input Pattern">
                                  </div>
                              </div>

                              <div class="control-group">
                                  <label class="control-label">DOT</label>
                                  <div class="controls">
                                    <input class="span7" id="editDOT" name="editDOT" type="text" placeholder="Input DOT">
                                  </div>
                              </div><div class="control-group">
                                  <label class="control-label">Jenis Claim</label>
                                  <div class="controls">
                                    <input class="span7" id="editTahun" name="editTahun" type="text" minlength="4" maxlength="4" placeholder="Input Tahun Produksi" onkeyup="validAngka(this)">
                                  </div>
                              </div>

                                <div class="control-group">
                                  <div id="edit-pesan"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" id="simpanEditClaimBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-floppy-o"></i> Simpan</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Close</button>
                            </div>
                        </form>
                    </div>
                  <!-- END MODAL EDIT CLAIM-->

                  <!-- BEGIN MODAL LAPORAN CLAIM-->
                    <div id="myModalLaporan" class="modal modal-form hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel1" class="center"><i class="fa fa-edit"></i> Lihat Laporan Masih Proses</h3>
                        </div>
                        <form class="cmxform form-horizontal" id="submitLaporanProses" action="action/claim/laporanProses.php" method="POST" >
                            <div class="modal-body modal-full">
                              <div class="control-group">
                                  <label class="control-label">Pilih Bulan</label>
                                  <div class="controls">
                                      <select id="bulan" name="bulan" class="span10 " data-placeholder="Choose a Category" tabindex="1" >
                                          <option value="">Pilih Bulan...</option>
                                          <option value="1">Januari</option>
                                          <option value="2">Februari</option>
                                          <option value="3">Maret</option>
                                          <option value="4">April</option>
                                          <option value="5">Mei</option>
                                          <option value="6">Juni</option>
                                          <option value="7">Juli</option>
                                          <option value="8">Agustus</option>
                                          <option value="9">September</option>
                                          <option value="10">Oktober</option>
                                          <option value="11">November</option>
                                          <option value="12">Desember</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="control-group">
                                  <label class="control-label">Pilih Tahun</label>
                                  <div class="controls">
                                      <select id="tahun" name="tahun" class="span10 " data-placeholder="Choose a Category" tabindex="1">
                                          <option value="">Pilih Tahun...</option>
                                          <option value="2017">2017</option>
                                          <option value="2018">2018</option>
                                          <option value="2019">2019</option>
                                          <option value="2020">2020</option>
                                          <option value="2021">2021</option>
                                          <option value="2022">2022</option>
                                          <option value="2023">2023</option>
                                      </select>
                                  </div>
                              </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" id="laporanProsesBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-search"></i> Cari</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Close</button>
                            </div>
                        </form>
                    </div>
                  <!-- END MODAL LAPORAN CLAIM-->

                  <!-- BEGIN MODAL HAPUS MASUK-->
                    <div id="hapusModalClaim" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 class="center" id="myModalLabel1"><i class="icon-trash"></i> HAPUS DATA CLAIM</h3>
                        </div>
                        <div class="modal-body">
                            <p id="pesanHapus" style="color: #dc5d3a"></p>

                        </div>
                        <div class="modal-footer div-hide">
                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Close</button>
                            <button class="btn btn-danger" id="hapusClaimBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-trash"></i> Hapus</button>
                        </div>
                    </div>
                  <!-- END MODAL HAPUS MASUK-->  

                </div>
                <!-- END EXAMPLE TABLE widget-->
                </div>
            </div>
            <!-- END ADVANCED TABLE widget-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->

    <?php 
      }//end page
    require_once 'include/footer.php'; 
    ?>
    <script src="jsAction/dataClaim.js"></script>
    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <?php 
    // }else{
    //   if ($_SESSION['level'] == 'administrator') {
    //     include_once 'saldo.php';
        
    //   }else{
        
    //   }
    // }//end cek saldo

    ?>
