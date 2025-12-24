

-------------------------------------------------- JANGAN DIJALANKAN --------------------------------------------------


-------------------------------------------------- SC_TMP.KARYAWAN --------------------------------------------------
ALTER TABLE sc_tmp.karyawan ADD COLUMN initial character(3);                                -- COMMENT IF ERROR --
--#
CREATE OR REPLACE FUNCTION sc_tmp.pr_nipnbi_after()
    RETURNS trigger AS
$BODY$
DECLARE
--created by Fiky ::03/04/2016
     vr_idabsen char(12);
     vr_nik char(12);
     vr_nomor char(12);
     vr_tglmasukkerja char(4);
BEGIN
    vr_idabsen:=trim(coalesce(idabsen,'')) from sc_tmp.karyawan where idabsen=new.idabsen and nik=new.nik;
    vr_nik:=trim(coalesce(nik,'')) from sc_tmp.karyawan where idabsen=new.idabsen and nik=new.nik;

    delete from sc_mst.penomoran where userid=vr_nik;
    delete from sc_mst.trxerror where userid=vr_nik;

    insert into sc_mst.penomoran
    (userid,dokumen,nomor,errorid,partid,counterid,xno)
    values(vr_nik,'NIP-PEGAWAI',' ',0,' ',1,0);

        vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=vr_nik;
        --ngambil dari yang baru menyisipkan ke sc_mst.karyawan dari tmp
        if (trim(vr_nomor)!='') or (not vr_nomor is null) then
            insert into sc_mst.karyawan (branch,nik,nmlengkap,callname,jk,neglahir,provlahir,kotalahir,tgllahir,kd_agama,stswn,stsfisik,ketfisik,noktp,ktp_seumurhdp,ktpdikeluarkan,tgldikeluarkan,status_pernikahan,gol_darah,
					negktp,provktp,kotaktp,kecktp,kelktp,alamatktp,negtinggal,provtinggal,kotatinggal,kectinggal,keltinggal,alamattinggal,nohp1,nohp2,npwp,tglnpwp,bag_dept,subbag_dept,jabatan,lvl_jabatan,
					grade_golongan,nik_atasan,nik_atasan2,status_ptkp,besaranptkp,tglmasukkerja,tglkeluarkerja,masakerja,statuskepegawaian,kdcabang,branchaktif,grouppenggajian,gajipokok,gajibpjs,namabank,
					namapemilikrekening,norek,tjshift,idabsen,email,bolehcuti,sisacuti,inputdate,inputby,updatedate,updateby,image,idmesin,cardnumber,status,tgl_ktp,costcenter,tj_tetap,gajitetap,gajinaker,
					tjlembur,tjborong,nokk,kdwilayahnominal,kdlvlgp,pinjaman,kdgradejabatan,deviceid,initial)
		select branch,to_char(tglmasukkerja,'MMYY')||'.'||vr_nomor as nik,
					nmlengkap,callname,jk,neglahir,provlahir,kotalahir,tgllahir,kd_agama,stswn,stsfisik,ketfisik,noktp,ktp_seumurhdp,ktpdikeluarkan,tgldikeluarkan,status_pernikahan,gol_darah,
					negktp,provktp,kotaktp,kecktp,kelktp,alamatktp,negtinggal,provtinggal,kotatinggal,kectinggal,keltinggal,alamattinggal,nohp1,nohp2,npwp,tglnpwp,bag_dept,subbag_dept,jabatan,lvl_jabatan,
					grade_golongan,nik_atasan,nik_atasan2,status_ptkp,besaranptkp,tglmasukkerja,tglkeluarkerja,masakerja,statuskepegawaian,kdcabang,branchaktif,grouppenggajian,gajipokok,gajibpjs,namabank,
					namapemilikrekening,norek,tjshift,idabsen,email,bolehcuti,sisacuti,inputdate,inputby,updatedate,updateby,image,idmesin,cardnumber,status,tgl_ktp,costcenter,tj_tetap,gajitetap,gajinaker,
					tjlembur,tjborong,nokk,kdwilayahnominal,kdlvlgp,pinjaman,kdgradejabatan,deviceid,initial
		  from sc_tmp.karyawan
		  where nik=new.nik;

		---reporting karyawan baru ke cuti balance
        /*
            insert into sc_trx.cuti_blc
            select vr_nomor||to_char(tglmasukkerja,'YYMM') as nik,cast(to_char(tglmasukkerja,'YYYY-MM-DD HH24:MI:SS')as date) as tanggal,
            vr_nomor||to_char(tglmasukkerja,'YYMM') as no_dokumen,0 as in_cuti,0 as out_cuti, 0 as sisacuti,'NEW' as doctype,'Jumlah Cuti:'||
            case when cast(to_char(tglmasukkerja,'dd') as numeric)<=15 then 13-to_number(to_char(tglmasukkerja,'MM'),'99')
             when cast(to_char(tglmasukkerja,'dd') as numeric)>15 then 12-to_number(to_char(tglmasukkerja,'MM'),'99')
             end||'||TGL:'||cast(to_char(tglmasukkerja+interval'1 YEAR','YYYY-MM-DD HH24:MI:SS')as date) as status from sc_tmp.karyawan where nik=vr_nik ;
        */
	    --Insert into table detail gaji
        /*
            select to_char(tglmasukkerja,'YYMM')  into vr_tglmasukkerja
            from sc_tmp.karyawan where nik=vr_nik ;
            insert into sc_mst.dtlgaji_karyawan (nik,no_urut,keterangan,nominal)
            select vr_nomor||vr_tglmasukkerja as nik,no_urut,keterangan,0 as nominal from sc_mst.detail_formula where tetap='T' and kdrumus='PR'
            and trim(vr_nomor||vr_tglmasukkerja||trim(cast(no_urut as character(3)))) not in (select trim(nik||trim(cast(no_urut as character(3)))) from sc_mst.dtlgaji_karyawan);
        */
            delete from sc_tmp.karyawan where nik=vr_nik;    --delete dari tmp setelah insert mst.karyawan
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,nomorakhir2,modul)
            values(vr_nik,'0',vr_nomor,vr_nomor,'KARYAWAN');

        else
        --select * from sc_trx.cuti_blc
        --select * from sc_mst.trxerror
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,nomorakhir2,modul)
            values(vr_nik,'1','','','KARYAWAN');
        end if;

    RETURN new;

END;
$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
ALTER FUNCTION sc_tmp.pr_nipnbi_after()
    OWNER TO postgres;
-------------------------------------------------- END OF: SC_TMP.KARYAWAN --------------------------------------------------
--#
--#
-------------------------------------------------- SC_MST.KARYAWAN --------------------------------------------------
ALTER TABLE sc_mst.karyawan ADD COLUMN initial character(3);                                -- COMMENT IF ERROR --
--#
CREATE OR REPLACE FUNCTION sc_mst.pr_del_karyawan()
    RETURNS trigger AS
$BODY$
DECLARE

BEGIN
	--vr_status:=trim(status) from sc_mst.karyawan where nik=new.nik for update;
	if (new.status='D') and (old.status='' or old.status is NULL) then
		insert into sc_his.karyawan_del (branch,nik,nmlengkap,callname,jk,neglahir,provlahir,kotalahir,tgllahir,kd_agama,stswn,stsfisik,ketfisik,noktp,ktp_seumurhdp,ktpdikeluarkan,
		tgldikeluarkan,status_pernikahan,gol_darah,negktp,provktp,kotaktp,kecktp,kelktp,alamatktp,negtinggal,provtinggal,kotatinggal,kectinggal,keltinggal,alamattinggal,nohp1,nohp2,
		npwp,tglnpwp,bag_dept,subbag_dept,jabatan,lvl_jabatan,grade_golongan,nik_atasan,nik_atasan2,status_ptkp,besaranptkp,tglmasukkerja,tglkeluarkerja,masakerja,statuskepegawaian,
		kdcabang,branchaktif,grouppenggajian,gajipokok,gajibpjs,namabank,namapemilikrekening,norek,tjshift,idabsen,email,bolehcuti,sisacuti,inputdate,inputby,updatedate,updateby,image,
		idmesin,cardnumber,status,tgl_ktp,costcenter,tj_tetap,gajitetap,gajinaker,tjlembur,tjborong,nokk,tgl_delete,delete_by,nokk,kdwilayahnominal,kdlvlgp,pinjaman,kdgradejabatan,deviceid,initial)
        select branch,nik,nmlengkap,callname,jk,neglahir,provlahir,kotalahir,tgllahir,kd_agama,stswn,stsfisik,ketfisik,noktp,ktp_seumurhdp,ktpdikeluarkan,
		tgldikeluarkan,status_pernikahan,gol_darah,negktp,provktp,kotaktp,kecktp,kelktp,alamatktp,negtinggal,provtinggal,kotatinggal,kectinggal,keltinggal,alamattinggal,nohp1,nohp2,
		npwp,tglnpwp,bag_dept,subbag_dept,jabatan,lvl_jabatan,grade_golongan,nik_atasan,nik_atasan2,status_ptkp,besaranptkp,tglmasukkerja,tglkeluarkerja,masakerja,statuskepegawaian,
		kdcabang,branchaktif,grouppenggajian,gajipokok,gajibpjs,namabank,namapemilikrekening,norek,tjshift,idabsen,email,bolehcuti,sisacuti,inputdate,inputby,updatedate,updateby,image,
		idmesin,cardnumber,status,tgl_ktp,costcenter,tj_tetap,gajitetap,gajinaker,tjlembur,tjborong,nokk,to_timestamp(to_char(now(),'yyyy-mm-dd HH:MI:SS'),'yyyy-mm-dd HH:MI:SS'),updateby,nokk,kdwilayahnominal,kdlvlgp,pinjaman,kdgradejabatan,deviceid,initial
        from sc_mst.karyawan
        where nik=new.nik;

        delete from sc_mst.karyawan where nik=new.nik;
        delete from sc_trx.riwayat_keluarga where nik=new.nik;
        delete from sc_trx.riwayat_pengalaman where nik=new.nik;
        delete from sc_trx.riwayat_pendidikan where nik=new.nik;
        delete from sc_trx.bpjs_karyawan where nik=new.nik;
        delete from sc_trx.riwayat_kesehatan where nik=new.nik;
	end if;
	RETURN new;

END;
$BODY$
    LANGUAGE plpgsql VOLATILE
    COST 100;
ALTER FUNCTION sc_mst.pr_del_karyawan()
    OWNER TO postgres;
-------------------------------------------------- END OF: SC_MST.KARYAWAN --------------------------------------------------
--#
--#
-------------------------------------------------- SC_HIS.KARYAWAN_DEL --------------------------------------------------
ALTER TABLE sc_his.karyawan_del ADD COLUMN kdwilayahnominal character(12);                  -- COMMENT IF ERROR --
--#
ALTER TABLE sc_his.karyawan_del ADD COLUMN kdlvlgp character(6);                            -- COMMENT IF ERROR --
--#
ALTER TABLE sc_his.karyawan_del ADD COLUMN pinjaman numeric(18,2);                          -- COMMENT IF ERROR --
--#
ALTER TABLE sc_his.karyawan_del ADD COLUMN kdgradejabatan character(6);                     -- COMMENT IF ERROR --
--#
ALTER TABLE sc_his.karyawan_del ADD COLUMN deviceid character varying;                      -- COMMENT IF ERROR --
--#
ALTER TABLE sc_his.karyawan_del ADD COLUMN initial character(3);                            -- COMMENT IF ERROR --
-------------------------------------------------- END OF: SC_HIS.KARYAWAN_DEL --------------------------------------------------
--#
--#
-------------------------------------------------- SC_MST.LV_M_KARYAWAN --------------------------------------------------
CREATE OR REPLACE VIEW sc_mst.lv_m_karyawan AS
    SELECT x.branch,
        x.nik,
        x.nmlengkap,
        x.callname,
        x.jk,
        x.neglahir,
        x.provlahir,
        x.kotalahir,
        x.tgllahir,
        x.kd_agama,
        x.stswn,
        x.stsfisik,
        x.ketfisik,
        x.noktp,
        x.ktp_seumurhdp,
        x.ktpdikeluarkan,
        x.tgldikeluarkan,
        x.status_pernikahan,
        x.gol_darah,
        x.negktp,
        x.provktp,
        x.kotaktp,
        x.kecktp,
        x.kelktp,
        x.alamatktp,
        x.negtinggal,
        x.provtinggal,
        x.kotatinggal,
        x.kectinggal,
        x.keltinggal,
        x.alamattinggal,
        x.nohp1,
        x.nohp2,
        x.npwp,
        x.tglnpwp,
        x.bag_dept,
        x.subbag_dept,
        x.jabatan,
        x.lvl_jabatan,
        x.grade_golongan,
        x.nik_atasan,
        x.nik_atasan2,
        x.status_ptkp,
        x.besaranptkp,
        x.tglmasukkerja,
        x.tglkeluarkerja,
        x.masakerja,
        x.statuskepegawaian,
        x.kdcabang,
        x.branchaktif,
        x.grouppenggajian,
        x.gajipokok,
        x.gajibpjs,
        x.namabank,
        x.namapemilikrekening,
        x.norek,
        x.tjshift,
        x.idabsen,
        x.email,
        x.bolehcuti,
        x.sisacuti,
        x.inputdate,
        x.inputby,
        x.updatedate,
        x.updateby,
        x.image,
        x.idmesin,
        x.cardnumber,
        x.status,
        x.tgl_ktp,
        x.costcenter,
        x.tj_tetap,
        x.gajitetap,
        x.gajinaker,
        x.tjlembur,
        x.tjborong,
        x.nokk,
        x.kdwilayahnominal,
        x.nmjabatan,
        x.nmdept,
        x.nmsubdept,
        x.nmlvljabatan,
        x.nmgrade,
        x.nmagama,
        x.namanegara,
        x.nmprovlahir,
        x.nmkotalahir,
        x.nmprovktp,
        x.nmkotaktp,
        x.nmkecktp,
        x.nmdesaktp,
        x.nmprovtinggal,
        x.nmkotatinggal,
        x.nmkectinggal,
        x.nmdesatinggal,
        x.nmatasan1,
        x.nmatasan2,
        x.nmwilayahnominal,
        x.kdwilayah_gp,
        x.kdlvlgp,
        x.tglmasukkerja1,
        x.tglkeluarkerja1,
        x.tgllahir1,
        x.tglptkp,
        x.tglktp1,
        x.tjborong1,
        x.tjshift1,
        x.tjlembur1,
        x.nmcabang,
        x.masakerja1,
        x.tahunmasakerja,
        x.pinjaman,
        x.nmstatus_pernikahan,
        x.nmstatus_ptkp,
        x.nmbank,
        x.kdgradejabatan,
        x.nmgradejabatan,
        x.deviceid,
        x.initial
    FROM ( SELECT a.branch,
        a.nik,
        a.nmlengkap,
        a.callname,
        a.jk,
        a.neglahir,
        a.provlahir,
        a.kotalahir,
        a.tgllahir,
        a.kd_agama,
        a.stswn,
        a.stsfisik,
        a.ketfisik,
        a.noktp,
        a.ktp_seumurhdp,
        a.ktpdikeluarkan,
        a.tgldikeluarkan,
        a.status_pernikahan,
        a.gol_darah,
        a.negktp,
        a.provktp,
        a.kotaktp,
        a.kecktp,
        a.kelktp,
        a.alamatktp,
        a.negtinggal,
        a.provtinggal,
        a.kotatinggal,
        a.kectinggal,
        a.keltinggal,
        a.alamattinggal,
        a.nohp1,
        a.nohp2,
        a.npwp,
        a.tglnpwp,
        a.bag_dept,
        a.subbag_dept,
        a.jabatan,
        a.lvl_jabatan,
        a.grade_golongan,
        a.nik_atasan,
        a.nik_atasan2,
        a.status_ptkp,
        a.besaranptkp,
        a.tglmasukkerja,
        a.tglkeluarkerja,
        a.masakerja,
        a.statuskepegawaian,
        a.kdcabang,
        a.branchaktif,
        a.grouppenggajian,
        a.gajipokok,
        a.gajibpjs,
        a.namabank,
        a.namapemilikrekening,
        a.norek,
        a.tjshift,
        a.idabsen,
        a.email,
        a.bolehcuti,
        a.sisacuti,
        a.inputdate,
        a.inputby,
        a.updatedate,
        a.updateby,
        a.image,
        a.idmesin,
        a.cardnumber,
        a.status,
        a.tgl_ktp,
        a.costcenter,
        a.tj_tetap,
        a.gajitetap,
        a.gajinaker,
        a.tjlembur,
        a.tjborong,
        a.nokk,
        a.kdwilayahnominal,
        a.kdlvlgp,
        a.kdgradejabatan,
        COALESCE(a.pinjaman, 0::numeric)::numeric(18,2) AS pinjaman,
        b.nmjabatan,
        c.nmdept,
        d.nmsubdept,
        e.nmlvljabatan,
        f.nmgrade,
        g1.nmagama,
        g2.namanegara,
        g3.namaprov AS nmprovlahir,
        g4.namakotakab AS nmkotalahir,
        g6.nmnikah AS nmstatus_pernikahan,
        g7.nmnikah AS nmstatus_ptkp,
        g8.nmbank,
        h1.namaprov AS nmprovktp,
        h2.namakotakab AS nmkotaktp,
        h3.namakec AS nmkecktp,
        h4.namakeldesa AS nmdesaktp,
        i1.namaprov AS nmprovtinggal,
        i2.namakotakab AS nmkotatinggal,
        i3.namakec AS nmkectinggal,
        i4.namakeldesa AS nmdesatinggal,
        f1.nmlengkap AS nmatasan1,
        f2.nmlengkap AS nmatasan2,
        k1.nmwilayahnominal,
        k1.kdwilayah AS kdwilayah_gp,
        k3.nmgradejabatan,
        to_char(a.tglmasukkerja::timestamp with time zone, 'dd-mm-yyyy'::text) AS tglmasukkerja1,
        to_char(a.tglkeluarkerja::timestamp with time zone, 'dd-mm-yyyy'::text) AS tglkeluarkerja1,
        to_char(a.tgllahir::timestamp with time zone, 'dd-mm-yyyy'::text) AS tgllahir1,
        to_char(a.tgldikeluarkan::timestamp with time zone, 'dd-mm-yyyy'::text) AS tglptkp,
        to_char(a.tgl_ktp::timestamp with time zone, 'dd-mm-yyyy'::text) AS tglktp1,
            CASE
                WHEN a.tjborong = 't'::bpchar THEN 'YA'::text
                WHEN a.tjborong = 'f'::bpchar OR a.tjborong IS NULL THEN 'TIDAK'::text
                ELSE NULL::text
            END AS tjborong1,
            CASE
                WHEN a.tjshift = 't'::bpchar THEN 'YA'::text
                WHEN a.tjshift = 'f'::bpchar OR a.tjshift IS NULL THEN 'TIDAK'::text
                ELSE NULL::text
            END AS tjshift1,
            CASE
                WHEN a.tjlembur = 't'::bpchar THEN 'YA'::text
                WHEN a.tjlembur = 'f'::bpchar OR a.tjlembur IS NULL THEN 'TIDAK'::text
                ELSE NULL::text
            END AS tjlembur1,
        k2.desc_cabang AS nmcabang,
        age(a.tglmasukkerja::timestamp with time zone) AS masakerja1,
        floor(date_part('day'::text, now() - a.tglmasukkerja::timestamp without time zone::timestamp with time zone) / 365::double precision) AS tahunmasakerja,
        a.deviceid,
        a.initial
        FROM sc_mst.karyawan a
        LEFT JOIN sc_mst.departmen c ON a.bag_dept = c.kddept
        LEFT JOIN sc_mst.subdepartmen d ON a.subbag_dept = d.kdsubdept AND d.kddept = c.kddept
        LEFT JOIN sc_mst.jabatan b ON a.subbag_dept = d.kdsubdept AND d.kddept = b.kddept AND a.jabatan = b.kdjabatan
        LEFT JOIN sc_mst.lvljabatan e ON a.lvl_jabatan = e.kdlvl
        LEFT JOIN sc_mst.jobgrade f ON a.grade_golongan = f.kdgrade
        LEFT JOIN sc_mst.karyawan f1 ON a.nik_atasan = f1.nik
        LEFT JOIN sc_mst.karyawan f2 ON a.nik_atasan2 = f2.nik
        LEFT JOIN sc_mst.agama g1 ON a.kd_agama = g1.kdagama
        LEFT JOIN sc_mst.negara g2 ON a.neglahir = g2.kodenegara
        LEFT JOIN sc_mst.provinsi g3 ON a.provlahir = g3.kodeprov
        LEFT JOIN sc_mst.kotakab g4 ON a.kotalahir = g4.kodekotakab AND g4.kodeprov = g3.kodeprov
        LEFT JOIN sc_mst.negara g5 ON a.negktp = g5.kodenegara
        LEFT JOIN sc_mst.status_nikah g6 ON a.status_pernikahan = g6.kdnikah
        LEFT JOIN sc_mst.status_nikah g7 ON a.status_ptkp = g7.kdnikah
        LEFT JOIN sc_mst.bank g8 ON a.namabank = g8.kdbank
        LEFT JOIN sc_mst.provinsi h1 ON a.provktp = h1.kodeprov
        LEFT JOIN sc_mst.kotakab h2 ON a.kotaktp = h2.kodekotakab AND h2.kodeprov = h1.kodeprov
        LEFT JOIN sc_mst.kec h3 ON a.kecktp = h3.kodekec
        LEFT JOIN sc_mst.keldesa h4 ON a.kelktp = h4.kodekeldesa
        LEFT JOIN sc_mst.provinsi i1 ON a.provtinggal = i1.kodeprov
        LEFT JOIN sc_mst.kotakab i2 ON a.kotatinggal = i2.kodekotakab AND i2.kodeprov = i1.kodeprov
        LEFT JOIN sc_mst.kec i3 ON a.kectinggal = i3.kodekec
        LEFT JOIN sc_mst.keldesa i4 ON a.keltinggal = i4.kodekeldesa
        LEFT JOIN sc_mst.m_wilayah_nominal k1 ON a.kdwilayahnominal = k1.kdwilayahnominal
        LEFT JOIN sc_mst.kantorwilayah k2 ON k2.kdcabang = a.kdcabang
        LEFT JOIN sc_mst.m_grade_jabatan k3 ON k3.kdgradejabatan = a.kdgradejabatan) x;

ALTER TABLE sc_mst.lv_m_karyawan OWNER TO postgres;

COMMENT ON VIEW sc_mst.lv_m_karyawan
    IS '
    Create By :Fiky Ashariza
    Update Clue
    ALTER VIEW a_view ALTER COLUMN ts SET DEFAULT now();
    INSERT INTO a_view(id) VALUES(2);  -- ts will receive the current time
    ';
-------------------------------------------------- END OF: SC_MST.LV_M_KARYAWAN --------------------------------------------------
