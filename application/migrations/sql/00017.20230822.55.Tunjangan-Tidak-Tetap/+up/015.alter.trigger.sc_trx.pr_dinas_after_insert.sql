create OR REPLACE function pr_dinas_after_insert() returns trigger
    language plpgsql
as
$$
declare
    vr_kddinas character(25);

begin

    update sc_trx.dinas set status='A' where new.status='I' and nodok=new.nodok;
    vr_kddinas:=trim(nodok) from sc_trx.lembur where nodok=new.nodok;

    --Dinas SMS
    insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
    select telepon,left(sms,160),pengirim from
        (select c.nohp1 as telepon,'
No. Dinas: '||a.nodok||'
Nama: '||b.nmlengkap||'
Tgl Awal: '||to_char(tgl_mulai,'DD-MM-YYYY')||' s/d Tgl Akhir: '||to_char(tgl_selesai,'DD-MM-YYYY')||'
Conf: Y/N
Ket Tujuan: '||tujuan_kota as sms,
                'OSIN' as pengirim
         from sc_trx.dinas a
                  left outer join sc_mst.karyawan b on a.nik=b.nik
                  left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
         where nodok=new.nodok
        ) as t1;
    return new;

end;
$$;

