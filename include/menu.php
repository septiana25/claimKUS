<!-- BEGIN SIDEBAR -->
      <div class="sidebar-scroll">
          <div id="sidebar" class="nav-collapse collapse">

              <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
              <div class="navbar-inverse">
                  <form class="navbar-search visible-phone">
                      <input type="text" class="search-query" placeholder="Search" />
                  </form>
              </div>
              <!-- END RESPONSIVE QUICK SEARCH FORM -->
              <!-- BEGIN SIDEBAR MENU -->
              <ul class="sidebar-menu">
                  <!-- <li class="sub-menu" id="activeDashboard">
                      <a class="" href="dashboard.php">
                          <i class="icon-home"></i>
                          <span>Dashboard</span>
                      </a>
                  </li> -->
                  <?php
                  $transaksi = '
                  <li class="sub-menu" id="activeTransaksi">
                      <a href="javascript:;" class="">
                          <i class="icon-shopping-cart"></i>
                          <span>Transaksi</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li id="activeBarangMasuk"><a class="" href="barangMsk.php">Barang Masuk</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeBarangKeluar"><a class="" href="barangKlr.php">Barang Keluar</a><i class="icon-circle-arrow-right kanan"></i></li>
                      </ul>
                  </li>
                  ';

                  $claim = '
                  <li class="sub-menu" id="activeClaim">
                      <a href="javascript:;" class="">
                          <i class="fa fa-cubes"></i>
                          <span>Claim</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li id="activeTamabahClaim"><a class="" href="tambahClaim.php">Tambah Claim</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeDataClaim"><a class="" href="dataClaim.php?p=data">Data Claim</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeNotaPengganti"><a class="" href="notaPenggantian.php">Nota Penggantian</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeNotaTolakan"><a class="" href="notaTolakan.php">Nota Tolakan</a><i class="icon-circle-arrow-right kanan"></i></li>
                      </ul>
                  </li>
                  ';

                  $efaktur = '
                  <li class="sub-menu" id="activeEfaktur">
                      <a href="efaktur.php">
                          <i class="fa fa-sticky-note"></i>
                          <span>E-Faktur</span>
                      </a>
                  </li>
                  ';

                  $masterBarang ='
                  <li class="sub-menu" id="activeMaster">
                      <a href="javascript:;" class="">
                          <i class="icon-tasks"></i>
                          <span>Master Barang</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li id="activeBarang"><a class="" href="barang.php">Data Barang</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeKategori"><a class="" href="kategori.php">Kategori</a><i class="icon-circle-arrow-right kanan"></i></li>
                      </ul>
                  </li>
                  ';

                  $pengirim = '
                  <li class="sub-menu" id="activePengirim">
                      <a class="" href="pengirim.php">
                          <i class="fa fa-truck"></i>
                          <span>Pengirim</span>
                      </a>
                  </li>
                  ';

                  $laporan = '
                  <li class="sub-menu" id="activeLaporan">
                      <a href="javascript:;" class="">
                          <i class="fa fa-file-text"></i>
                          <span>Laporan</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li id="activeLaporanKeluar"><a class="" href="laporan.php">Laporan Keluar</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeLaporanFaktur"><a class="" href="faktur.php">Laporan Perfaktur</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeLaporanLimit"><a class="" href="cekLimit.php">Cek Limit Stock</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeKartu"><a class="" href="#">Kartu Stock</a><i class="icon-circle-arrow-right kanan"></i></li>
                      </ul>
                  </li>
                  ';

/*                  $laporanClaim = '
                  <li class="sub-menu" id="activeLaporan">
                      <a href="javascript:;" class="">
                          <i class="fa fa-file-text"></i>
                          <span>Laporan Claim</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li id="activeLaporanKeluar"><a class="" href="#">Laporan Keluar</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeLaporanFaktur"><a class="" href="#">Laporan Perfaktur</a><i class="icon-circle-arrow-right kanan"></i></li>
                          <li id="activeKartu"><a class="" href="#">Kartu Stock</a><i class="icon-circle-arrow-right kanan"></i></li>
                      </ul>
                  </li>
                  ';*/

                  $laporanClaim = '
                  <li class="sub-menu" id="activeLaporanClaim">
                      <a class="" href="laporanClaim.php">
                          <i class="fa fa-file-text"></i>
                          <span>Laporan Claim</span>
                      </a>
                  </li>
                  ';

                  $setting = '
                  <li class="sub-menu" id="activeSetting">
                      <a href="javascript:;" class="">
                          <i class="fa fa-cogs"></i>
                          <span>Setting</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li id="activeUser"><a class="" href="backup.php">Manajemen User</a><i class="icon-circle-arrow-right kanan"></i>
                          <li id="activeBackup"><a class="" href="dailyBackup.php">Backup Database</a><i class="icon-circle-arrow-right kanan"></i>
                          <li id="activeBackup"><a class="" href="backup.php">Log</a><i class="icon-circle-arrow-right kanan"></i>
                      </ul>
                  </li>
                  ';

                  if ($_SESSION['level'] == 'administrator') {
                    //echo $transaksi;
                    echo $claim;
                    //echo $efaktur;
                    echo $masterBarang;
                    //echo $pengirim;
                    //echo $laporan;
                    echo $laporanClaim;
                    echo $setting;

                  }

                  elseif ($_SESSION['level'] == 'user') {
                    // echo $transaksi;
                    // echo $efaktur;
                    // echo $masterBarang;
                    // echo $pengirim;
                    // echo $laporan;
                  }

                  elseif ($_SESSION['level'] == 'claim') {
                    //echo $claim;
                    echo $laporanClaim;
                  }
                  ?>

                  <li class="sub-menu">
                      <a  href="logout.php">
                          <i class="fa fa-key"></i>
                          <span>Log Out</span>
                      </a>
                  </li>
              </ul>
              <!-- END SIDEBAR MENU -->
          </div>
      </div>
      <!-- END SIDEBAR -->
