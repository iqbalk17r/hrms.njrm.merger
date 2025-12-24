DO
$$
BEGIN
    /* schema temporary */
    /*
	UPDATE public.migrations SET version = 10;
    DROP VIEW IF EXISTS sc_trx.listlinkjadwalcuti;
    alter table sc_tmp.dinas rename column tanggal_berangkat to tgl_mulai;
    alter table sc_tmp.dinas alter column tgl_mulai type date using tgl_mulai::date;
    alter table sc_tmp.dinas rename column tanggal_pulang to tgl_selesai;
    alter table sc_tmp.dinas alter column tgl_selesai type date using tgl_selesai::date;
    
    alter table sc_trx.dinas rename column tanggal_berangkat to tgl_mulai;
    alter table sc_trx.dinas alter column tgl_mulai type date using tgl_mulai::date;
    alter table sc_trx.dinas rename column tanggal_pulang to tgl_selesai;
    alter table sc_trx.dinas alter column tgl_selesai type date using tgl_selesai::date;
    */
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'jam_mulai') THEN
        ALTER TABLE sc_tmp.dinas ADD jam_mulai TIME;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'jam_selesai') THEN
        ALTER TABLE sc_tmp.dinas ADD jam_selesai TIME;
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'status') THEN
        ALTER TABLE sc_tmp.dinas ALTER COLUMN status TYPE VARCHAR USING status::VARCHAR;
        UPDATE sc_tmp.dinas SET status = TRIM(status);
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'tujuan') THEN
        ALTER TABLE sc_tmp.dinas RENAME COLUMN tujuan TO tujuan_kota;
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'tujuan_kota') THEN
        ALTER TABLE sc_tmp.dinas ALTER COLUMN tujuan_kota TYPE VARCHAR USING tujuan_kota::VARCHAR;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'transportasi') THEN
        ALTER TABLE sc_tmp.dinas ADD transportasi VARCHAR;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'jenis_tujuan') THEN
        ALTER TABLE sc_tmp.dinas ADD jenis_tujuan VARCHAR;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'no_telp') THEN
        ALTER TABLE sc_tmp.dinas ADD no_telp VARCHAR;
    END IF;

    /* schema transaction */
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'jam_mulai') THEN
        ALTER TABLE sc_trx.dinas ADD jam_mulai TIME;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'jam_selesai') THEN
        ALTER TABLE sc_trx.dinas ADD jam_selesai TIME;
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'status') THEN
        ALTER TABLE sc_trx.dinas ALTER COLUMN status TYPE VARCHAR USING status::VARCHAR;
        UPDATE sc_trx.dinas SET status = TRIM(status);
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'tujuan') THEN
        ALTER TABLE sc_trx.dinas RENAME COLUMN tujuan TO tujuan_kota;
    END IF;
    IF EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'tujuan_kota') THEN
        ALTER TABLE sc_trx.dinas ALTER COLUMN tujuan_kota TYPE VARCHAR USING tujuan_kota::VARCHAR;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'transportasi') THEN
        ALTER TABLE sc_trx.dinas ADD transportasi VARCHAR;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'jenis_tujuan') THEN
        ALTER TABLE sc_trx.dinas ADD jenis_tujuan VARCHAR;
    END IF;
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'no_telp') THEN
        ALTER TABLE sc_trx.dinas ADD no_telp VARCHAR;
    END IF;
END
$$
