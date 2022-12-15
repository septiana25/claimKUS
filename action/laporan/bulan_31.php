<?php

  $sql = "SELECT s.rak, s.brg,
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
)m ON s.brg=m.brg AND s.rak=m.rak
-- RIGHT JOIN(
--  SELECT rak, brg
--  FROM detail_brg
--  RIGHT JOIN barang USING(id_brg)
--  LEFT JOIN rak USING(id_rak)
--  GROUP BY rak, brg
-- )b ON k.brg=b.brg AND k.rak=b.rak
";
?>