<?php

  $sql = "SELECT s.rak, s.brg,
  IFNULL(saldo_awal, 0) AS s_awal,
  IFNULL(total_masuk,0) AS b_masuk,
  IFNULL(tgl_1, ' ') AS tgl_1, IFNULL(tgl_2, ' ') AS tgl_2,
  IFNULL(tgl_3, ' ') AS tgl_3, IFNULL(tgl_4, ' ') AS tgl_4,
  IFNULL(tgl_5, ' ') AS tgl_5, IFNULL(tgl_6, ' ') AS tgl_6,
  IFNULL(tgl_7, ' ') AS tgl_7, IFNULL(tgl_8, ' ') AS tgl_8,
  IFNULL(tgl_9, ' ') AS tgl_9, IFNULL(tgl_10, ' ') AS tgl_10,
  IFNULL(tgl_11, ' ') AS tgl_11, IFNULL(tgl_12, ' ') AS tgl_12,
  IFNULL(tgl_13, ' ') AS tgl_13, IFNULL(tgl_14, ' ') AS tgl_14,
  IFNULL(tgl_15, ' ') AS tgl_15, IFNULL(tgl_16, ' ') AS tgl_16,
  IFNULL(tgl_17, ' ') AS tgl_17,
  IFNULL(tgl_18, ' ') AS tgl_18, IFNULL(tgl_19, ' ') AS tgl_19,
  IFNULL(tgl_20, ' ') AS tgl_20, IFNULL(tgl_21, ' ') AS tgl_21,
  IFNULL(tgl_22, ' ') AS tgl_22, IFNULL(tgl_23, ' ') AS tgl_23,
  IFNULL(tgl_24, ' ') AS tgl_24, IFNULL(tgl_25, ' ') AS tgl_25,
  IFNULL(tgl_26, ' ') AS tgl_26, IFNULL(tgl_27, ' ') AS tgl_27,
  IFNULL(tgl_28, ' ') AS tgl_28, IFNULL(tgl_29, ' ') AS tgl_29,
  IFNULL(tgl_30, ' ') AS tgl_30,
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
    SUM( IF( DAY(tgl)=1, jml_klr, ' ')) AS tgl_1,
    SUM( IF( DAY(tgl)=2, jml_klr, ' ')) AS tgl_2,
    SUM( IF( DAY(tgl)=3, jml_klr, ' ')) AS tgl_3,
    SUM( IF( DAY(tgl)=4, jml_klr, ' ')) AS tgl_4,
    SUM( IF( DAY(tgl)=5, jml_klr, ' ')) AS tgl_5,
    SUM( IF( DAY(tgl)=6, jml_klr, ' ')) AS tgl_6,
    SUM( IF( DAY(tgl)=7, jml_klr, ' ')) AS tgl_7,
    SUM( IF( DAY(tgl)=8, jml_klr, ' ')) AS tgl_8,
    SUM( IF( DAY(tgl)=9, jml_klr, ' ')) AS tgl_9,
    SUM( IF( DAY(tgl)=10, jml_klr, ' ')) AS tgl_10,
    SUM( IF( DAY(tgl)=11, jml_klr, ' ')) AS tgl_11,
    SUM( IF( DAY(tgl)=12, jml_klr, ' ')) AS tgl_12,
    SUM( IF( DAY(tgl)=13, jml_klr, ' ')) AS tgl_13,
    SUM( IF( DAY(tgl)=14, jml_klr, ' ')) AS tgl_14,
    SUM( IF( DAY(tgl)=15, jml_klr, ' ')) AS tgl_15,
    SUM( IF( DAY(tgl)=16, jml_klr, ' ')) AS tgl_16,
    SUM( IF( DAY(tgl)=17, jml_klr, ' ')) AS tgl_17,
    SUM( IF( DAY(tgl)=18, jml_klr, ' ')) AS tgl_18,
    SUM( IF( DAY(tgl)=19, jml_klr, ' ')) AS tgl_19,
    SUM( IF( DAY(tgl)=20, jml_klr, ' ')) AS tgl_20,
    SUM( IF( DAY(tgl)=21, jml_klr, ' ')) AS tgl_21,
    SUM( IF( DAY(tgl)=22, jml_klr, ' ')) AS tgl_22,
    SUM( IF( DAY(tgl)=23, jml_klr, ' ')) AS tgl_23,
    SUM( IF( DAY(tgl)=24, jml_klr, ' ')) AS tgl_24,
    SUM( IF( DAY(tgl)=25, jml_klr, ' ')) AS tgl_25,
    SUM( IF( DAY(tgl)=26, jml_klr, ' ')) AS tgl_26,
    SUM( IF( DAY(tgl)=27, jml_klr, ' ')) AS tgl_27,
    SUM( IF( DAY(tgl)=28, jml_klr, ' ')) AS tgl_28,
    SUM( IF( DAY(tgl)=29, jml_klr, ' ')) AS tgl_29,
    SUM( IF( DAY(tgl)=30, jml_klr, ' ')) AS tgl_30
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