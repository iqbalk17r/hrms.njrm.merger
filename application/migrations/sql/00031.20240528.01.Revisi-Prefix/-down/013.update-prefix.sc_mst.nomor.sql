
--Update prefix ijin karyawan 
UPDATE sc_mst.nomor
SET count3=4, prefix='IK22', sufix='', docno=7386, userid='12345       ', modul='', periode='2021', cekclose='F  ', group_nomor=NULL
WHERE dokumen='IJIN-KARYAWAN' AND part='';


--Update prefix Cuti Karyawan

UPDATE sc_mst.nomor
SET count3=4, prefix='CT22', sufix='', docno=2023, userid='12345       ', modul='', periode='2021', cekclose='F  ', group_nomor=NULL
WHERE dokumen='CUTI-KARYAWAN' AND part='';

--Update prefix Dinas Karyawan

UPDATE sc_mst.nomor
SET count3=4, prefix='DL22', sufix='', docno=15790, userid='1115.184    ', modul='', periode='2021', cekclose='T  ', group_nomor=NULL
WHERE dokumen='DINAS-LUAR' AND part='';


--Update prefix Deklarasi Kasbon 

UPDATE sc_mst.nomor
SET count3=4, prefix='DC23', sufix='', docno=1966, userid='0418.318    ', modul='', periode='2023', cekclose='T  ', group_nomor=NULL
WHERE dokumen='DECLCASHB' AND part='';

--Update prefix Cuti Bersama

UPDATE sc_mst.nomor
SET count3=4, prefix='CB22', sufix='', docno=7, userid='66666       ', modul='', periode='2021', cekclose='T  ', group_nomor=NULL
WHERE dokumen='CUTI-BERSAMA' AND part='';


--Update prefix Koreksi Cuti Bersama 

UPDATE sc_mst.nomor
SET count3=4, prefix='KCB', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='K-CB' AND part='';


--Update prefix Koreksi Cuti Karyawan

UPDATE sc_mst.nomor
SET count3=4, prefix='KCK2405', sufix='', docno=43, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='K-CK' AND part='';


--Update prefix Lembur Karyawan

UPDATE sc_mst.nomor
SET count3=4, prefix='LBR22', sufix='', docno=3421, userid='12345       ', modul='', periode='2021', cekclose='F  ', group_nomor=NULL
WHERE dokumen='LEMBUR' AND part='';


--Update prefix Pengajuan Perawatan Asset

UPDATE sc_mst.nomor
SET count3=4, prefix='PAS2204', sufix='', docno=1, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PERAWATAN-ASSET' AND part='';


--Update prefix SPK Perawatan Asset

UPDATE sc_mst.nomor
SET count3=4, prefix='PSPK1801', sufix='', docno=10, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PERAWATAN-SPK' AND part='';

--Update prefix Form Uji Kir

UPDATE sc_mst.nomor
SET count3=4, prefix='KR1808', sufix=NULL, docno=16, userid='FIKY        ', modul=NULL, periode='201801', cekclose='F  ', group_nomor=NULL
WHERE dokumen='KIR' AND part='';


--Update prefix Form SIM

UPDATE sc_mst.nomor
SET count3=4, prefix='KS1808', sufix=NULL, docno=3, userid='FIKY        ', modul=NULL, periode='201801', cekclose='F  ', group_nomor=NULL
WHERE dokumen='SIM' AND part='';

--Update prefix SK Memo

UPDATE sc_mst.nomor
SET count3=4, prefix='SKMM1808', sufix='', docno=1, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PER_SKMEMO' AND part='';


--Update prefix Input Mutasi Asset

UPDATE sc_mst.nomor
SET count3=4, prefix='SAMM1808', sufix='', docno=1, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PER_MTAS' AND part='';


--Update prefix Serah Terima Asset

UPDATE sc_mst.nomor
SET count3=4, prefix='STMA1808', sufix='', docno=1, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='MTAS_ST' AND part='';

--Update prefix SPPB

UPDATE sc_mst.nomor
SET count3=4, prefix='PPB2405', sufix='', docno=1, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PO_SPPB' AND part='';


--Update prefix Pembelian (PO)

UPDATE sc_mst.nomor
SET count3=4, prefix='PO1812', sufix='', docno=1, userid='66666       ', modul='', periode='201706', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PO_ATK' AND part='';


--Update prefix Permintaan Barang Keluar

UPDATE sc_mst.nomor
SET count3=4, prefix='PBK2402', sufix='', docno=1, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='STG_PBK' AND part='';


--Update prefix Bukti Barang Keluar

UPDATE sc_mst.nomor
SET count3=4, prefix='BBK1811', sufix='', docno=1, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='STG_BBK' AND part='';


--Update prefix Bukti Barang Masuk

UPDATE sc_mst.nomor
SET count3=4, prefix='BBM1811', sufix='', docno=1, userid='66666       ', modul='', periode='201706', cekclose='T  ', group_nomor=NULL
WHERE dokumen='STBBM' AND part='';


--Update prefix Transfer antar gudang

UPDATE sc_mst.nomor
SET count3=4, prefix='TRG1711', sufix='', docno=1, userid='66666       ', modul='', periode='201706', cekclose='T  ', group_nomor=NULL
WHERE dokumen='ITEMTRANS' AND part='';

--Update prefix Mutasi

UPDATE sc_mst.nomor
SET count3=4, prefix='MT', sufix='', docno=154, userid='66666       ', modul='', periode='201608', cekclose='F  ', group_nomor=NULL
WHERE dokumen='MUTASI' AND part='';

--Update prefix Status Pegawai

UPDATE sc_mst.nomor
SET count3=4, prefix='STSPG', sufix='', docno=1770, userid='123         ', modul='', periode='201601', cekclose='F  ', group_nomor=NULL
WHERE dokumen='STATUS-PEG' AND part='';

--Update prefix Asuransi Kendaraan 

UPDATE sc_mst.nomor
SET count3=4, prefix='BC1808', sufix=NULL, docno=3, userid='FIKY        ', modul=NULL, periode='201801', cekclose='F  ', group_nomor=NULL
WHERE dokumen='BC_ASN_K' AND part='';

--Update prefix Pinjaman 

UPDATE sc_mst.nomor
SET count3=4, prefix='PKRD1908', sufix=NULL, docno=1, userid='66666       ', modul=NULL, periode='201901', cekclose='T  ', group_nomor=NULL
WHERE dokumen='P_PINJAMAN' AND part='';

--Update prefix Arsip

UPDATE sc_mst.nomor
SET count3=4, prefix='AC2011', sufix='', docno=14, userid='FIKY        ', modul='', periode='201808', cekclose='F  ', group_nomor=NULL
WHERE dokumen='ARSIP_DOC' AND part='';

-- Update prefix Cashbon 

UPDATE sc_mst.nomor
SET count3=4, prefix='CB23', sufix='', docno=3, userid='0418.318    ', modul='', periode='2023', cekclose='T  ', group_nomor=NULL
WHERE dokumen='CASHBON' AND part='';

--Update prefix Kenaikan Grade 

UPDATE sc_mst.nomor
SET count3=4, prefix='KG', sufix='', docno=0, userid='            ', modul='', periode='', cekclose='F  ', group_nomor=NULL
WHERE dokumen='KENAIKAN-GRADE' AND part='';


