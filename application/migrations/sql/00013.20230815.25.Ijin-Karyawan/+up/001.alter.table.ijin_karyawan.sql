DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'ijin_karyawan' AND column_name = 'tgl_mulai') THEN
            ALTER TABLE IF EXISTS sc_trx.ijin_karyawan ADD COLUMN tgl_mulai DATE;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'ijin_karyawan' AND column_name = 'tgl_selesai') THEN
            ALTER TABLE IF EXISTS sc_trx.ijin_karyawan ADD COLUMN tgl_selesai DATE;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'ijin_karyawan' AND column_name = 'tgl_mulai') THEN
            ALTER TABLE IF EXISTS sc_tmp.ijin_karyawan ADD COLUMN tgl_mulai DATE;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'ijin_karyawan' AND column_name = 'tgl_selesai') THEN
            ALTER TABLE IF EXISTS sc_tmp.ijin_karyawan ADD COLUMN tgl_selesai DATE;
        END IF;
    END
$$;

create OR REPLACE function sc_tmp.pr_ijin_after() returns trigger
    language plpgsql
as
$$
declare

    vr_nomor char(30);

begin
    --vr_status:=trim(coalesce(status,'')) from sc_tmp.cuti where branch=new.branch and kddokumen=new.kddokumen for update;
--vr_nomor

--alter table sc_trx.ijin_karyawan add column kendaraan character (20),add column nopol character (12),add column nikpengikut character (12);
--alter table sc_tmp.ijin_karyawan add column kendaraan character (20),add column nopol character (12),add column nikpengikut character (12);
    delete from sc_mst.penomoran where userid=new.nodok;
    insert into sc_mst.penomoran
    (userid,dokumen,nomor,errorid,partid,counterid,xno)
    values(new.nodok,'IJIN-KARYAWAN',' ',0,' ',1,0);

    vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;
    if (trim(vr_nomor)!='') or (not vr_nomor is null) then
        INSERT INTO sc_trx.ijin_karyawan(
            nodok,nik,kddept,kdsubdept,kdlvljabatan,kdjabatan,tgl_dok,tgl_kerja,kdijin_absensi,tgl_jam_mulai,tgl_jam_selesai,
            durasi,keterangan,input_by,update_by,nmatasan,
            input_date,update_date,status,approval_date,approval_by,delete_by,delete_date,cancel_by,cancel_date,type_ijin,kendaraan,nopol,nikpengikut,tgl_mulai, tgl_selesai
        )
        SELECT vr_nomor,nik,kddept,kdsubdept,kdlvljabatan,kdjabatan,tgl_dok,tgl_kerja,kdijin_absensi,tgl_jam_mulai,tgl_jam_selesai,
               durasi,keterangan,input_by,update_by,nmatasan,
               input_date,update_date,'I' as status,approval_date,approval_by,delete_by,delete_date,cancel_by,cancel_date,type_ijin,kendaraan,nopol,nikpengikut,tgl_mulai, tgl_selesai

        from sc_tmp.ijin_karyawan where nodok=new.nodok and nik=new.nik;

        delete from sc_tmp.ijin_karyawan where nodok=new.nodok and nik=new.nik;

    end if;

    return new;

end;
$$;
