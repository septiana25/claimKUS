<?php
      require_once 'function/koneksi.php';
      require_once 'function/setjam.php';
      require_once 'function/session.php';
      $tahun          = date("Y");
      $bulan          = date("m");
      //$bulan1          = 7;
/*$cek_saldo = $koneksi->query("SELECT id_saldo FROM saldo WHERE MONTH(tgl)=$bulan AND YEAR(tgl)=$tahun");
if ($cek_saldo->num_rows >=1 ) {*/
    require_once 'include/header.php';
    require_once 'include/menu.php';
      echo "<div class='div-request div-hide'>barang</div>";
?>

      <!-- BEGIN PAGE -->  
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                   <h3 class="page-title">
                    Data Barang
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           Master Barang
                           <span class="divider">/</span>
                       </li>
                       <li class="active">
                          Data Barang
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
                        <a href="#addModalMasuk" role="button" class="btn btn-primary tambah" id="addBarangBtnModal" data-toggle="modal"> <i class=" icon-plus"></i>Tambah Data</a>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <!-- <a href="javascript:;" class="icon-remove"></a> -->
                            </span>
                    </div>
                    <div class="widget-body">
                        <table class="table table-striped table-bordered" id="tabelBarang">
                            <thead>
                            <tr>
                                <th width="13%">Lokasi Rak</th>
                                <th>Nama Barang</th>
                                <th width="20%">Saldo Awal</th>
                                <th width="20%">Saldo Akhir</th>
                                <?php
                                if ($_SESSION['level'] == "administrator") {
                                  echo '<th width="15%" class="hidden-phone">Action</th>';
                                }
                                ?> 
                            </tr>
                            </thead>
                            <tbody>
                        
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE widget-->
                </div>
                <!-- END ADVANCED TABLE widget-->
            </div>

            <!-- BEGIN MODAL TAMBAH BARANG-->
              <div id="addModalMasuk" class="modal modal-form hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      <h3 id="myModalLabel1" class="center"><i class="icon-plus-sign-alt"></i> FORM INPUT DATA BARANG</h3>
                  </div>
                  <form class="cmxform form-horizontal" id="submitBarang" action="action/barang/simpanBarang.php" method="POST" >
                      <div class="modal-body modal-full tinggi">
                          <div class="control-group ">
                              <label class="control-label"><strong>Kategori</strong><p class="titik2">:</p></label>
                              <div class="controls">
                                <select id="kategori" name="id_kat" class="choiceChosen" data-placeholder="Pilih Kategori..." >
                                <option value=""></option>
                                <?php
                                $kat = $koneksi->query("SELECT id_kat, kat FROM kat ORDER BY kat ASC");
                                while ($kat1 = $kat->fetch_array()) {
                                  //echo "<option value='".$kat1[0]."'>$kat1[1]</option>";
                                  echo '<option value="'.$kat1[0].'">'.$kat1[1].'</option>';
                                }
                                ?>
                                </select>
                              </div>
                          </div>
                          <div class="control-group ">
                              <label for="cname" class="control-label"><strong>Nama Barang</strong><p class="titik2">:</p></label>
                              <div class="controls">
                                  <input class="span12 " id="barang" name="barang" type="text"  placeholder="Nama Barang" onkeydown="upperCaseF(this)"/>
                              </div>
                          </div>
                          <div class="control-group">
                            <div id="pesan"></div>
                          </div>
                      </div>
                      <div class="modal-footer">

                          <button class="btn btn-primary" id="simpanBarangBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-floppy-o"></i> Simpan</button>
                          <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Close</button>
                      </div>
                  </form>
              </div>
                <!-- END MODAL TAMBAH BARANG-->

                <!-- BEGIN MODAL EDIT BARANG-->
              <div id="editModalBarang" class="modal modal-form hide fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      <h3 id="myModalLabel1" class="center"><i class="icon-edit-sign"></i> FORM EDIT DATA BARANG</h3>
                  </div>
                  <form class="cmxform form-horizontal" id="editBarangForm" action="action/barang/editBarang.php" method="POST" >
                      <div class="modal-body modal-full tinggi">
                          <div class="control-group ">
                              <label class="control-label"><strong>Kategori</strong><p class="titik2">:</p></label>
                              <div class="controls">
                                <select id="editKategori" name="id_kat" class="span12" data-placeholder="Pilih Kategori..." >
                                <option value=""></option>
                                <?php
                                $kat = $koneksi->query("SELECT id_kat, kat FROM kat ORDER BY kat ASC");
                                while ($kat1 = $kat->fetch_array()) {
                                  //echo "<option value='$kat1[0]'>$kat1[1]</option>";
                                  echo '<option value="'.$kat1[0].'">'.$kat1[1].'</option>';
                                }
                                ?>
                                </select>
                              </div>
                          </div>
                          <div class="control-group ">
                              <label for="cname" class="control-label"><strong>Nama Barang</strong><p class="titik2">:</p></label>
                              <div class="controls">
                                  <input class="span12 " id="editBarang" name="barang" type="text"  placeholder="Nama Barang" onkeydown="upperCaseF(this)"/>
                              </div>
                          </div>
                          <div class="control-group">
                            <div id="edit-pesan"></div>
                          </div>
                      </div>
                      <div class="modal-footer">

                          <button class="btn btn-primary" id="editBarangBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-floppy-o"></i> Simpan</button>
                          <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Close</button>
                      </div>
                  </form>
              </div>
                <!-- END MODAL EDIT BARANG-->

              <!-- BEGIN MODAL HAPUS MASUK-->
              <div id="hapusModalBarang" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      <h3 class="center" id="myModalLabel1"><i class="icon-trash"></i> HAPUS DATA BARANG</h3>
                  </div>
                  <div class="modal-body">
                      <p id="pesanHapus" style="color: #dc5d3a"></p>

                  </div>
                  <div class="modal-footer">
                      <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Close</button>
                      <button class="btn btn-danger" id="hapusBarangBtn" type="submit" data-loading-text="Loading..." autocomplete="off" ><i class="fa fa-trash"></i> Hapus</button>
                  </div>
              </div>
              <!-- END MODAL HAPUS MASUK-->            
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->

<?php require_once 'include/footer.php'; ?>

  <script src="jsAction/barang.js"></script>
  
  <script src="assets/chosen/chosen1.jquery.min.js"></script>

  <?php
/*  }else{
    include_once 'saldo.php';
  }*/
?>