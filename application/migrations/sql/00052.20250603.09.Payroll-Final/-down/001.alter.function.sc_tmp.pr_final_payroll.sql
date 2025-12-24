create OR REPLACE function sc_tmp.pr_final_payroll() returns trigger
    language plpgsql
as
$$
declare
/*
update date : 14-02-2019
update by : Fiky
case : penghilangan departemen pada saat summary
*/
    vr_nomor char(30);
    vr_nomor2 char(30);
    vr_nomor3 char(30);
    vr_statussetup char(30);

begin

    IF (new.status='P' and old.status='F') then
        /*delete from sc_mst.penomoran where userid=new.nodok;
        insert into sc_mst.penomoran
                (userid,dokumen,nomor,errorid,partid,counterid,xno)
                values(new.nodok,'PAYROLL',' ',0,' ',1,0);

        vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;*/
--select *,status from sc_mst.option where kdoption='PAYROL01';
        vr_statussetup:=coalesce(trim(status),'') from sc_mst.option where kdoption='PAYROL01';
        vr_nomor:=trim(kddept) from sc_tmp.payroll_rekap where nodok=new.nodok;
        if (trim(vr_nomor)!='') or (not vr_nomor is null) then

            vr_nomor2:=to_char(periode_akhir,'YYMM') from sc_tmp.payroll_rekap where nodok=new.nodok ;
            --vr_nomor3='PR'||vr_nomor2||vr_nomor;
            vr_nomor3='PR'||vr_nomor||vr_nomor2;

            delete from sc_trx.payroll_rekap where nodok=vr_nomor3;
            delete from sc_trx.payroll_master where nodok=vr_nomor3;
            delete from sc_trx.payroll_detail where nodok=vr_nomor3;
        end if;
        --select * from sc_trx.payroll_rekap;
        --select * from sc_trx.payroll_rekap;
        --select * from sc_trx.payroll_rekap;
        /* INI PAYROLLNYA */
        INSERT INTO sc_trx.payroll_rekap(
            nodok,total_upah,total_pendapatan,total_potongan,total_deposit,
            input_date,input_by,update_date,update_by,status,approval_date,approval_by,delete_by,delete_date,cancel_by,cancel_date,periode_mulai,periode_akhir,kddept,nodoktmp)
        select vr_nomor3,total_upah,total_pendapatan,total_potongan,total_deposit,
               input_date,input_by,update_date,update_by,status,approval_date,approval_by,delete_by,delete_date,cancel_by,cancel_date,periode_mulai,periode_akhir,kddept,nodoktmp
        from sc_tmp.payroll_rekap where nodok=new.nodok ;

        insert into sc_trx.payroll_master (nodok,nik,total_upah,total_pendapatan,total_potongan,input_date,approval_date,input_by,approval_by,delete_by,cancel_by,
                                           update_date,delete_date,cancel_date,update_by,periode_mulai,periode_akhir,total_deposit,sisa_cuti,tmp_cuti,kddept,status)
        select vr_nomor3 as nodok,nik,total_upah,total_pendapatan,total_potongan,input_date,approval_date,input_by,approval_by,delete_by,cancel_by,
               update_date,delete_date,cancel_date,update_by,periode_mulai,periode_akhir,total_deposit,sisa_cuti,tmp_cuti,kddept,new.status as status
        from sc_tmp.payroll_master where nodok=new.nodok ;

        insert into sc_trx.payroll_detail(
            nodok,nik,no_urut,tipe,aksi_tipe,aksi,taxable,tetap,deductible,regular,cash,status,keterangan,nominal,input_date,approval_date,input_by,
            approval_by,delete_by,cancel_by,update_date,delete_date,cancel_date,update_by)
        select vr_nomor3 as nodok,nik,no_urut,tipe,aksi_tipe,aksi,taxable,tetap,deductible,regular,cash,'P' as status,keterangan,nominal,input_date,null as approval_date,input_by,
               null as approval_by,null as delete_by,null as cancel_by,update_date,null as delete_date,null as cancel_date,update_by from sc_tmp.payroll_detail
        where nodok=new.nodok ;

        /* INI KOMPONEN PENGIKUTNYA */

        --select * from sc_trx.cek_lembur
        --select * from sc_tmp.cek_lembur
        --detail lembur ganti sc_trx.cek_lembur
        insert into sc_trx.cek_lembur (nodok,nik,nodok_ref,tgl_nodok_ref,tplembur,tgl_kerja,jam_mulai,jam_selesai,jam_mulai_absen,
                                       jam_selesai_absen,jumlah_jam,jumlah_jam_absen,
                                       status,keterangan,input_date,approval_date,input_by,approval_by,delete_by,cancel_by,update_date,delete_date,cancel_date,update_by,
                                       nominal,kdjamkerja,tgl_jadwal,gajipokok,periode_gaji,nikmap,nodoktmp)
        select vr_nomor3 as nodok,nik,nodok_ref,tgl_nodok_ref,tplembur,tgl_kerja,jam_mulai,jam_selesai,jam_mulai_absen,
               jam_selesai_absen,jumlah_jam,jumlah_jam_absen,
               status,keterangan,input_date,approval_date,input_by,approval_by,delete_by,cancel_by,update_date,delete_date,cancel_date,update_by,
               nominal,kdjamkerja,tgl_jadwal,gajipokok,periode_gaji,nikmap,nodoktmp from sc_tmp.cek_lembur
        where nodok=new.nodok;
        --select * from sc_trx.cek_absen
        --select * from sc_tmp.cek_absen
        --sc_trx.potongan_absen ganti sc_trx.cek_absen
        insert into sc_trx.cek_absen(nodok ,nik ,nodok_ref ,tgl_nodok_ref ,tgl_kerja ,kdijin ,kdtrx ,nominal ,status ,keterangan ,
                                     input_by ,approval_by ,input_date ,approval_date ,delete_by ,cancel_by ,update_date ,delete_date ,
                                     cancel_date,update_by ,shiftke ,flag_cuti ,cuti_nominal ,jam_masuk_absen ,jam_pulang_absen ,urut,gajipokok,periode_gaji,nikmap,nodoktmp)
        select  vr_nomor3 as nodok ,nik ,nodok_ref ,tgl_nodok_ref ,tgl_kerja ,kdijin ,kdtrx ,nominal ,status ,keterangan ,
                input_by ,approval_by ,input_date ,approval_date ,delete_by ,cancel_by ,update_date ,delete_date ,
                cancel_date,update_by ,shiftke ,flag_cuti ,cuti_nominal ,jam_masuk_absen ,jam_pulang_absen ,urut,gajipokok,periode_gaji,nikmap,nodoktmp from sc_tmp.cek_absen
        where nodok=new.nodok;
        --select * from sc_tmp.cek_borong
        --select * from sc_trx.cek_borong
        insert into sc_trx.cek_borong(nodok,nik,nodok_ref,tgl_dok,periode,tgl_kerja,total_upah,status,keterangan,input_date,approval_date,input_by,approval_by,
                                      delete_by,cancel_by,update_date,delete_date,cancel_date,update_by,urut,nodoktmp)
        select vr_nomor3 as nodok,nik,nodok_ref,tgl_dok,periode,tgl_kerja,total_upah,status,keterangan,input_date,approval_date,input_by,approval_by,
               delete_by,cancel_by,update_date,delete_date,cancel_date,update_by,urut,nodoktmp from sc_tmp.cek_borong
        where nodok=new.nodok;
        --select * from sc_tmp.cek_shift
        --select * from sc_trx.cek_shift
        insert into sc_trx.cek_shift(nodok,nik,tpshift,tgl_kerja,kdjam_kerja,jam_mulai,jam_selesai,jam_mulai_absen,jam_selesai_absen,status,keterangan,input_date,approval_date,input_by,approval_by,
                                     delete_by,cancel_by,update_date,delete_date,cancel_date,update_by,nominal,urut,nodoktmp)
        select vr_nomor3 as nodok,nik,tpshift,tgl_kerja,kdjam_kerja,jam_mulai,jam_selesai,jam_mulai_absen,jam_selesai_absen,status,keterangan,input_date,approval_date,input_by,approval_by,
               delete_by,cancel_by,update_date,delete_date,cancel_date,update_by,nominal,urut,nodoktmp from sc_tmp.cek_shift
        where nodok=new.nodok;
        /* ubah pinjaman */
        update sc_trx.payroll_pinjaman_inq set docref=vr_nomor3 where docref=new.nodok;

        delete from sc_tmp.payroll_rekap where nodok=new.nodok ;
        delete from sc_tmp.payroll_master where nodok=new.nodok ;
        delete from sc_tmp.payroll_detail where nodok=new.nodok;
        delete from sc_tmp.cek_lembur where nodok=new.nodok ;
        delete from sc_tmp.cek_absen where nodok=new.nodok ;
        delete from sc_tmp.cek_borong where nodok=new.nodok;
        delete from sc_tmp.cek_shift where nodok=new.nodok ;


    end if;

    return new;

end;
$$;