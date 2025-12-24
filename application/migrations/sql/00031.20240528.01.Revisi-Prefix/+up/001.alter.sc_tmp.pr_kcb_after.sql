-- Function: sc_tmp.pr_kcb_after()

-- DROP FUNCTION sc_tmp.pr_kcb_after();

CREATE OR REPLACE FUNCTION sc_tmp.pr_kcb_after()
  RETURNS trigger AS
$BODY$
declare

     vr_nomor char(30);
     vr_type char(12);
     vr_lastdoc numeric;
     vr_countfix integer;

begin

vr_type:=trim(coalesce(new.doctype,''));

--select * from sc_mst.nomor
--select * from sc_trx.koreksicb

			IF (vr_type='X') THEN /* CUTI KHUSUS */

					delete from sc_mst.penomoran where userid=new.nodok;
					
					
					insert into sc_mst.penomoran
						(userid,dokumen,nomor,errorid,partid,counterid,xno)
						values(new.nodok,'K-CK',' ',0,' ',1,0);

					vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;

					 if (trim(vr_nomor)!='') or (not vr_nomor is null) then

						--update sc_tmp.koreksicb set nodok=vr_nomor where status='P' and doctype='X';
						INSERT INTO sc_trx.koreksicb(
							nik,nodok,tgl_dok,status,tgl_awal,tgl_akhir,input_by,input_date,update_by,update_date,jumlahcuti,keterangan,docref,doctype,operator,nodoktmp)
						SELECT nik,vr_nomor,tgl_dok,'I' as status,tgl_awal,tgl_akhir,input_by,input_date,update_by,update_date,jumlahcuti,keterangan,docref,doctype,operator,nodoktmp

						from sc_tmp.koreksicb where nodok=new.nodok and new.doctype='X';

						delete from sc_tmp.koreksicb where new.doctype='X' and nodok=new.nodok;
					end if;

			ELSEIF(vr_type='Y') THEN /* CUTI BERSAMA */

					delete from sc_mst.penomoran where userid=new.nodok;
					
					

					insert into sc_mst.penomoran
						(userid,dokumen,nomor,errorid,partid,counterid,xno)
						values(new.nodok,'K-CB',' ',0,' ',1,0);

					vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;

					 if (trim(vr_nomor)!='') or (not vr_nomor is null) then
						INSERT INTO sc_trx.koreksicb(
							nik,nodok,tgl_dok,status,tgl_awal,tgl_akhir,input_by,input_date,update_by,update_date,jumlahcuti,keterangan,docref,doctype,operator,nodoktmp)
						SELECT nik,vr_nomor,tgl_dok,'I',tgl_awal,tgl_akhir,input_by,input_date,update_by,update_date,jumlahcuti,keterangan,docref,doctype,operator,nodoktmp
						from sc_tmp.koreksicb where new.doctype='Y' and nodok=new.nodok;

						delete from sc_tmp.koreksicb where new.doctype='Y' and nodok=new.nodok;
					end if;

			END IF;

return new;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.pr_kcb_after()
  OWNER TO postgres;
