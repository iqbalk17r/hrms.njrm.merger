create OR REPLACE function sc_trx.pr_stspeg_after() returns trigger
    language plpgsql
as
$$

declare

--created by: Fiky Ashariza 28-04-2016

--update by : Bagos 19-06-2023
--Penambahan status

begin



	IF
(TG_OP = 'INSERT') THEN

	IF (new.status='B') then

					IF (new.kdkepegawaian='KO') THEN --keluar kerja

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=new.tgl_selesai
	where nik = new.nik;

	delete
	from sc_mst.regu_opr
	where nik = new.nik;

	delete
	from sc_trx.dtljadwalkerja
	where nik = new.nik
	  and tgl > new.tgl_selesai;

	delete
	from sc_trx.uangmakan
	where nik = new.nik
	  and tgl > new.tgl_selesai;

	DELETE FROM sc_mst.user WHERE nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='HL') THEN--HARIAN LEPAS

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='KK') THEN --KONTRAK

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='PK') THEN --PKWT PERCOBAAN

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='P1') THEN --PKWT 1

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='P2') THEN --PKWT 2

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='P3') THEN --PKWT 3

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='P4') THEN --PKWT 4

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='P5') THEN --PKWT 5

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='KT') THEN --KARYAWAN TETAP

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='MG') THEN --MAGANG

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='KP') THEN --PENSIUN

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='OJ') THEN --OJT

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='H2') THEN --PELAKSANA

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	ELSEIF
	(new.kdkepegawaian='H1') THEN --HONORER

	update sc_mst.karyawan
	set statuskepegawaian=new.kdkepegawaian,
	    tglkeluarkerja=null
	where nik = new.nik;

	END IF;

	END IF;

	RETURN NEW;

	ELSEIF
(TG_OP = 'UPDATE') THEN

			IF (new.status='B' and old.status='A') then

				IF (new.kdkepegawaian='KO') THEN --keluar kerja

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=new.tgl_selesai
where nik = new.nik;

delete
from sc_mst.regu_opr
where nik = new.nik;

delete
from sc_trx.dtljadwalkerja
where nik = new.nik
  and tgl > new.tgl_selesai;

delete
from sc_trx.uangmakan
where nik = new.nik
  and tgl > new.tgl_selesai;

DELETE FROM sc_mst.user WHERE nik = new.nik;

ELSEIF
(new.kdkepegawaian='HL') THEN--HARIAN LEPAS

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='KK') THEN --KONTRAK

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='PK') THEN --PKWT PERCOBAAN

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='P1') THEN --PKWT 1

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='P2') THEN --PKWT 2

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='P3') THEN --PKWT 3

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='P4') THEN --PKWT 4

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='P5') THEN --PKWT 5

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='KT') THEN --KARYAWAN TETAP

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='MG') THEN --MAGANG

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='KP') THEN --PENSIUN

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='OJ') THEN --OJT

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='H2') THEN --PELAKSANA

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

ELSEIF
(new.kdkepegawaian='H1') THEN --HONORER

update sc_mst.karyawan
set statuskepegawaian=new.kdkepegawaian,
    tglkeluarkerja=null
where nik = new.nik;

END IF;

END IF;



RETURN NEW;

END IF;



end;

$$;

alter function sc_trx.pr_stspeg_after() owner to postgres;

