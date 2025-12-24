create OR REPLACE function sc_tmp.pr_generate_transready(vr_tglawal character, vr_tglakhir character, vr_kdcabang character) returns timestamp without time zone
    language plpgsql
as
$$
DECLARE
    vr_nik              char(12);
    vr_badgenumber      char(12);
    vr_tgl_min_masuk    timestamp without time zone;
    vr_tgl_max_pulang   timestamp without time zone;
    vr_jam_masuk_absen  time without time zone;
    vr_jam_pulang_absen time without time zone;
    vr_kdjamkerja       char(12);
    vr_jam_masuk        time without time zone;
    vr_jam_pulang       time without time zone;
    vr_shiftke          char(12);
    vr_tgl              char(12);
    vr_kdregu           char(20);
    vr_jam_masuk_min    time without time zone;
    vr_jam_pulang_min   time without time zone;
    vr_jam_masuk_max    time without time zone;
    vr_jam_pulang_max   time without time zone;


BEGIN
    --vr_keluarkerja:=to_char(tglakhirfix,'YYYYMM');
    --select * from sc_trx.transready limit 1
    --FOR listNik IN select distinct nik from sc_trx.dtljadwalkerja where to_char(tgl,'YYYYMM')=$1 and case when xnik<>'' then nik=xnik else nik<>'' end order by nik
    delete
    from sc_trx.transready
    where to_char(tgl, 'YYYY-MM-DD') between vr_tglawal and vr_tglakhir
      and nik in (select nik from sc_mst.karyawan where kdcabang = vr_kdcabang)
      and editan <> 't';

    FOR vr_nik,vr_tgl IN
        select distinct a.nik,
                        to_char(tgl, 'YYYY-MM-DD')
        from sc_trx.dtljadwalkerja a
                 left outer join sc_mst.jam_kerja b on a.kdjamkerja=b.kdjam_kerja
                 left outer join sc_mst.karyawan c on a.nik=c.nik
        where  (to_char(tgl,'YYYY-MM-DD') between vr_tglawal and vr_tglakhir) and c.kdcabang=vr_kdcabang AND coalesce(c.statuskepegawaian,'')<>'KO' and coalesce(a.kdjamkerja,'OFF')!='OFF'
        order by nik,to_char(tgl,'YYYY-MM-DD')

        LOOP


        --FOR vr_urut IN select no_urut from sc_mst.detail_formula where kdrumus='PR' order by no_urut asc
        --LOOP

        --insert into dumy(nik) values (vr_nik);

            select
                kdjamkerja,jam_masuk,jam_masuk_min,jam_masuk_max,jam_pulang,jam_pulang_min,jam_pulang_max,shiftke,
                case
                    when shiftke='2' and kdharimasuk='H-' then cast(to_char((cast(a.tgl as date)- integer '1'),'YYYY-MM-DD')||' '||to_char(b.jam_masuk_min,'HH24:MI:SS') as timestamp)
                    else cast(to_char((cast(a.tgl as date)),'YYYY-MM-DD')||' '||to_char(b.jam_masuk_min,'HH24:MI:SS') as timestamp)
                    end as tgl_min_masuk,
                case
                    when shiftke='3' and kdharipulang='H+' then cast(to_char((cast(a.tgl as date)+ integer '1'),'YYYY-MM-DD')||' '||to_char(b.jam_pulang_max,'HH24:MI:SS') as timestamp)
                    else cast(to_char((cast(a.tgl as date)),'YYYY-MM-DD')||' '||to_char(b.jam_pulang_max,'HH24:MI:SS') as timestamp)
                    end as tgl_max_pulang,a.kdregu
            into
                vr_kdjamkerja,vr_jam_masuk,vr_jam_masuk_min,vr_jam_pulang_max,vr_jam_pulang,vr_jam_pulang_min,vr_jam_pulang_max,vr_shiftke,vr_tgl_min_masuk,vr_tgl_max_pulang,vr_kdregu
            from sc_trx.dtljadwalkerja a,sc_mst.jam_kerja b, sc_mst.karyawan d
            where a.kdjamkerja=b.kdjam_kerja  and a.nik=d.nik
              and to_char(tgl,'YYYY-MM-DD')=vr_tgl and a.nik=vr_nik
            group by a.nik,tgl,kdjamkerja,jam_masuk,jam_masuk_min,jam_masuk_max,jam_pulang,jam_pulang_min,jam_pulang_max,kdharimasuk,kdharipulang,shiftke
            order by shiftke,a.tgl,a.nik;


            select min(checktime) as jam_masuk,max(checktime) as jam_pulang into vr_jam_masuk_absen,vr_jam_pulang_absen  from sc_tmp.checkinout a,sc_mst.karyawan b
            where a.badgenumber=b.idabsen and  cast(to_char(a.checktime,'YYYY-MM-DD hh24:mi:ss') as timestamp)>= vr_tgl_min_masuk
              and cast(to_char(a.checktime,'YYYY-MM-DD hh24:mi:ss') as timestamp) <=vr_tgl_max_pulang and b.nik=vr_nik
            group by b.nik;


            /*
             select min(checktime) as jam_masuk,max(checktime) as jam_pulang,b.idabsen into vr_jam_masuk_absen,vr_jam_pulang_absen,vr_badgenumber  from sc_tmp.checkinout a,sc_mst.karyawan b
                where a.badgenumber=b.idabsen and to_char(checktime,'yyyy-mm-dd')=vr_tgl and b.nik=vr_nik
                group by b.nik,b.idabsen;*/


            --select * from sc_trx.transready limit 10
            --select * from sc_trx.dtljadwalkerja limit 10
            --select * from sc_tmp.checkinout where badgenumber='005'
            --select * from sc_mst.karyawan where nmlengkap like '%WIWIK%'

            --insert into dumy(nik,sembarang,tgl) values (vr_nik,vr_kdjamkerja,cast(vr_tgl as date));
            insert into sc_trx.transready(badgenumber,nik,tgl,kdjamkerja,jam_masuk,jam_masuk_min,jam_pulang,jam_pulang_max,shiftke,jam_masuk_absen,jam_pulang_absen,kdregu)
            values (vr_badgenumber,vr_nik,cast(vr_tgl as date),vr_kdjamkerja,vr_jam_masuk,vr_jam_masuk_min,vr_jam_pulang,vr_jam_pulang_max,vr_shiftke, vr_jam_masuk_absen,vr_jam_pulang_absen,vr_kdregu);



        END LOOP;

    RETURN vr_tgl;
END;
$$;