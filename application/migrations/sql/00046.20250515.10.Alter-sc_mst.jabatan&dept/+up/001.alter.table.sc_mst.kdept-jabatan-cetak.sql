ALTER TABLE sc_mst.jabatan ADD jabatan_cetak varchar NULL;
ALTER TABLE sc_mst.departmen ADD dept_cetak varchar NULL;


UPDATE sc_mst.jabatan
SET jabatan_cetak = 'HRGA Manager'
WHERE kdjabatan = 'HR01  ';

UPDATE sc_mst.jabatan
SET jabatan_cetak = 'HRGA Supervisor'
WHERE kdjabatan = 'HR02  ';

UPDATE sc_mst.jabatan
SET jabatan_cetak = 'IT Developer Supervisor'
WHERE kdjabatan = 'IT02  ';

UPDATE sc_mst.jabatan
SET jabatan_cetak = 'IT Manager'
WHERE kdjabatan = 'IT01  ';

UPDATE sc_mst.jabatan
SET jabatan_cetak = 'IT Operational'
WHERE kdjabatan = 'IT08  ';

UPDATE sc_mst.jabatan
SET jabatan_cetak = 'IT Operational Supervisor'
WHERE kdjabatan = 'IT07  ';

UPDATE sc_mst.departmen
SET dept_cetak = 'HRGA'
WHERE kddept = 'HA';

UPDATE sc_mst.departmen
SET dept_cetak = 'IT Group'
WHERE kddept = 'IT';

UPDATE sc_mst.departmen
SET dept_cetak = 'IT'
WHERE kddept = 'TI';
