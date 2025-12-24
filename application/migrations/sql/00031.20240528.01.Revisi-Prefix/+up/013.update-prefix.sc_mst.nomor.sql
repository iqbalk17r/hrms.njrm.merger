
--Update prefix ijin karyawan 

UPDATE sc_mst.nomor
SET count3=10, prefix='IK', sufix='', docno=0, userid='12345       ', modul='', periode='2021', cekclose='F  ', group_nomor=NULL
WHERE dokumen='IJIN-KARYAWAN' AND part='';

--Update prefix Cuti Karyawan

UPDATE sc_mst.nomor
SET count3=10, prefix='CT', sufix='', docno=0, userid='12345       ', modul='', periode='2021', cekclose='F  ', group_nomor=NULL
WHERE dokumen='CUTI-KARYAWAN' AND part='';

--Update prefix Dinas Karyawan

UPDATE sc_mst.nomor
SET count3=10, prefix='DL', sufix='', docno=0, userid='1115.184    ', modul='', periode='2021', cekclose='T  ', group_nomor=NULL
WHERE dokumen='DINAS-LUAR' AND part='';


--Update prefix Deklarasi Kasbon 

UPDATE sc_mst.nomor
SET count3=10, prefix='DC', sufix='', docno=0, userid='0418.318    ', modul='', periode='2023', cekclose='T  ', group_nomor=NULL
WHERE dokumen='DECLCASHB' AND part='';

--Update prefix Cuti Bersama

UPDATE sc_mst.nomor
SET count3=10, prefix='CB', sufix='', docno=0, userid='66666       ', modul='', periode='2021', cekclose='T  ', group_nomor=NULL
WHERE dokumen='CUTI-BERSAMA' AND part='';


--Update prefix Koreksi Cuti Bersama 

UPDATE sc_mst.nomor
SET count3=9, prefix='KCB', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='K-CB' AND part='';


--Update prefix Koreksi Cuti Karyawan

UPDATE sc_mst.nomor
SET count3=9, prefix='KCK', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='K-CK' AND part='';


--Update prefix Lembur Karyawan

UPDATE sc_mst.nomor
SET count3=9, prefix='LBR', sufix='', docno=0, userid='12345       ', modul='', periode='2021', cekclose='F  ', group_nomor=NULL
WHERE dokumen='LEMBUR' AND part='';


--Update prefix Pengajuan Perawatan Asset

UPDATE sc_mst.nomor
SET count3=9, prefix='PAS', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PERAWATAN-ASSET' AND part='';


--Update prefix SPK Perawatan Asset

UPDATE sc_mst.nomor
SET count3=8, prefix='PSPK', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PERAWATAN-SPK' AND part='';

--Update prefix Form Uji Kir

UPDATE sc_mst.nomor
SET count3=10, prefix='KR', sufix='', docno=0, userid='FIKY        ', modul='', periode='201801', cekclose='F  ', group_nomor=NULL
WHERE dokumen='KIR' AND part='';


--Update prefix Form SIM

UPDATE sc_mst.nomor
SET count3=10, prefix='KS', sufix='', docno=0, userid='FIKY        ', modul='', periode='201801', cekclose='F  ', group_nomor=NULL
WHERE dokumen='SIM' AND part='';

--Update prefix SK Memo

UPDATE sc_mst.nomor
SET count3=8, prefix='SKMM', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PER_SKMEMO' AND part='';


--Update prefix Input Mutasi Asset

UPDATE sc_mst.nomor
SET count3=8, prefix='SAMM', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PER_MTAS' AND part='';


--Update prefix Serah Terima Asset

UPDATE sc_mst.nomor
SET count3=8, prefix='STMA', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='MTAS_ST' AND part='';

--Update prefix SPPB

UPDATE sc_mst.nomor
SET count3=9, prefix='PPB', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PO_SPPB' AND part='';


--Update prefix Pembelian (PO)

UPDATE sc_mst.nomor
SET count3=10, prefix='PO', sufix='', docno=0, userid='66666       ', modul='', periode='201706', cekclose='T  ', group_nomor=NULL
WHERE dokumen='PO_ATK' AND part='';


--Update prefix Permintaan Barang Keluar

UPDATE sc_mst.nomor
SET count3=9, prefix='PBK', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='STG_PBK' AND part='';


--Update prefix Bukti Barang Keluar

UPDATE sc_mst.nomor
SET count3=9, prefix='BBK', sufix='', docno=0, userid='66666       ', modul='', periode='201606', cekclose='T  ', group_nomor=NULL
WHERE dokumen='STG_BBK' AND part='';


--Update prefix Bukti Barang Masuk

UPDATE sc_mst.nomor
SET count3=9, prefix='BBM', sufix='', docno=0, userid='66666       ', modul='', periode='201706', cekclose='T  ', group_nomor=NULL
WHERE dokumen='STBBM' AND part='';


--Update prefix Transfer antar gudang

UPDATE sc_mst.nomor
SET count3=9, prefix='TRG', sufix='', docno=0, userid='66666       ', modul='', periode='201706', cekclose='T  ', group_nomor=NULL
WHERE dokumen='ITEMTRANS' AND part='';

--Update prefix Mutasi

UPDATE sc_mst.nomor
SET count3=10, prefix='MT', sufix='', docno=0, userid='66666       ', modul='', periode='201608', cekclose='F  ', group_nomor=NULL
WHERE dokumen='MUTASI' AND part='';

--Update prefix Status Pegawai

UPDATE sc_mst.nomor
SET count3=7, prefix='STSPG', sufix='', docno=0, userid='123         ', modul='', periode='201601', cekclose='F  ', group_nomor=NULL
WHERE dokumen='STATUS-PEG' AND part='';

--Update prefix Asuransi Kendaraan 

UPDATE sc_mst.nomor
SET count3=10, prefix='BC', sufix=NULL, docno=0, userid='FIKY        ', modul=NULL, periode='201801', cekclose='F  ', group_nomor=NULL
WHERE dokumen='BC_ASN_K' AND part='';

--Update prefix Pinjaman 

UPDATE sc_mst.nomor
SET count3=8, prefix='PKRD', sufix=NULL, docno=0, userid='66666       ', modul=NULL, periode='201901', cekclose='T  ', group_nomor=NULL
WHERE dokumen='P_PINJAMAN' AND part='';

--Update prefix Arsip

UPDATE sc_mst.nomor
SET count3=10, prefix='AC', sufix='', docno=0, userid='FIKY        ', modul='', periode='201808', cekclose='F  ', group_nomor=NULL
WHERE dokumen='ARSIP_DOC' AND part='';

-- Update prefix Cashbon 

UPDATE sc_mst.nomor
SET count3=9, prefix='CBN', sufix='', docno=0, userid='0418.318    ', modul='', periode='2023', cekclose='T  ', group_nomor=NULL
WHERE dokumen='CASHBON' AND part='';

--Update prefix Kenaikan Grade 

UPDATE sc_mst.nomor
SET count3=10, prefix='KG', sufix='', docno=0, userid='            ', modul='', periode='', cekclose='F  ', group_nomor=NULL
WHERE dokumen='KENAIKAN-GRADE' AND part='';


