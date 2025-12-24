-- DROP FUNCTION sc_pk.tr_kondite_tmp_rekap();

CREATE OR REPLACE FUNCTION sc_pk.tr_kondite_tmp_rekap()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by DK ::04/12/2023
    vr_nomor varchar;
    vr_cekprefix char(4);
    vr_nowprefix char(4);
   	vr_periode varchar;
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='F' and old.status='I') then
            vr_nomor:='KDT/'||new.periode||'/'||new.nik;

            insert into sc_pk.kondite_trx_rekap
            select branch,idbu,vr_nomor,periode,nik,nikatasan1,nikatasan2,f_score_k,f_ktg_fs,description,inputdate,inputby,updatedate,updateby,nodoktmp,'A',f_desc_fs,f_kdvalue_fs
            from sc_pk.kondite_tmp_rekap where nodok=new.nodok and nik=new.nik;
            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.nodok,0,vr_nomor,'PKPA');

            delete from sc_pk.kondite_tmp_rekap where nodok=new.nodok and nik=new.nik;

        elseif (new.status='F' and old.status='E') then
            vr_nomor:=new.nodoktmp;
           	vr_periode:=new.periode;
            delete from sc_pk.kondite_trx_rekap where nodok=vr_nomor and nik=new.nik and periode = vr_periode;

            insert into sc_pk.kondite_trx_rekap
            select branch,idbu,vr_nomor,periode,nik,nikatasan1,nikatasan2,f_score_k,f_ktg_fs,description,inputdate,inputby,updatedate,updateby,nodoktmp,'A',f_desc_fs,f_kdvalue_fs
            from sc_pk.kondite_tmp_rekap where nodok=new.nodok and nik=new.nik;

            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.nodok,0,vr_nomor,'PKPA');

            delete from sc_pk.kondite_tmp_rekap where nodok=new.nodok and nik=new.nik and periode = vr_periode;
        end if;

        RETURN NEW;
    END IF;

    return new;

end;
$function$
;
