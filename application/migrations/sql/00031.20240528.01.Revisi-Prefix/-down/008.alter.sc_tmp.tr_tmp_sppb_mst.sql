-- Function: sc_tmp.tr_tmp_sppb_mst()

-- DROP FUNCTION sc_tmp.tr_tmp_sppb_mst();

CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_sppb_mst()
  RETURNS trigger AS
$BODY$
DECLARE 
	--author by fiky: 12/08/2017
	--update by fiky: 28/11/2018
	--TRIGER SMS SPPB
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);  
     vr_qtypo numeric;  
     vr_lastdoc numeric;
BEGIN		
	IF tg_op = 'INSERT' THEN
			

		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
		
		IF (new.status='A' and old.status='I') THEN
			delete from sc_mst.penomoran where userid=new.nodok;
			delete from sc_mst.trxerror where userid=new.nodok;    

			vr_lastdoc:= case 
			when max((right(trim(nodok),4))) is null or max((right(trim(nodok),4)))='' then '0'::numeric
			else max((right(trim(nodok),4)))::numeric end lastdoc
			from sc_trx.sppb_mst
			where to_char(tgldok,'yyyymm')=to_char(new.tgldok,'yyyymm');

			update sc_mst.nomor set  prefix='PPB'||to_char(new.tgldok,'YYMM') ,docno=vr_lastdoc where dokumen='PO_SPPB';
			
			/*
			select trim(split_part(trim(prefix),'PPB',2)) as cekprefix into vr_cekprefix from sc_mst.nomor where dokumen='PO_SPPB';
			select to_char(now(),'YYMM') as cekbulan into vr_nowprefix;
			if(vr_nowprefix<>vr_cekprefix) then 
				update sc_mst.nomor set prefix='PPB'||vr_nowprefix,docno=0 where dokumen='PO_SPPB';
			end if;
			*/
			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.nodok,'PO_SPPB',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;
			
			insert into sc_trx.sppb_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,tgldok,itemtype)
			(select branch,vr_nomor,nodokref,nik,loccode,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,tgldok,itemtype
			from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);

			insert into sc_trx.sppb_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
			keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
			(select branch,vr_nomor,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,'A' as status,satkecil,satminta,
			keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
			from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik);

			insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
			select nomorsms,left(sms,160),pengirim from 			
(select 
trim(coalesce(nohpatasan1,'')) as nomorsms,
'No.SPPB: '||trim(coalesce(vr_nomor,''))||'
Nama: '||trim(coalesce(nmlengkap,''))||'
Item: ('||trim(coalesce(qty::text))||') '||trim(coalesce(item1))||'
Conf: Y/N
Ket: '||trim(coalesce(ketitem1)) as sms,
	'OSIN' as pengirim from (
select a.*,b.nmlengkap as nmlengkap,b.nohp1 as nohpown,c.nmlengkap as nmatasan1,c.nohp1 as nohpatasan1,d.nmlengkap as nmatasan2,d.nohp1 as nohpatasan2,e.desc_barang as item1,e.keterangan as ketitem1,e.qtysppbminta as qty from sc_tmp.sppb_mst a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	left outer join sc_mst.karyawan d on d.nik=b.nik_atasan2 
	left outer join sc_tmp.sppb_dtl e on a.nik=e.nik and a.nodok=e.nodok and e.id=1
where a.nodok=new.nodok and a.nik=new.nik
) as x ) as y;


			delete from sc_mst.trxerror where modul='TMPSPPB' and userid=new.nodok;
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','TMPSPPB');

			perform sc_trx.pr_capture_approvals_system();

			delete from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='A' and old.status='E') THEN
			delete from sc_trx.sppb_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.sppb_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.sppb_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok,itemtype)
			(select branch,new.nodoktmp,nodokref,nik,loccode,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok,itemtype
			from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);
			--select * from sc_tmp.sppb_dtl
			insert into sc_trx.sppb_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
			keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
			(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,'A' as status,satkecil,satminta,
			keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
			from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik);



			
			delete from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik;

		ELSEIF (new.status='F' and old.status='A') THEN
			delete from sc_trx.sppb_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.sppb_dtl where nodok=new.nodoktmp and nik=new.nik;
			IF NOT EXISTS (select * from sc_tmp.sppb_dtl  where nodok=new.nodok and nik=new.nik and status='P') THEN
				insert into sc_trx.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'C' as status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,new.nodok,to_char(now(),'YYYY-MM-DD HH24:mi:ss')::timestamp without time zone,tgldok,itemtype  from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.sppb_dtl
												/* qty qtysppbminta = qty qtybbm*/
				insert into sc_trx.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,
				satminta,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtysppbkecil,0),coalesce(qtypo,0),coalesce(qtyrefonhand,0),coalesce(qtypo,0),coalesce(qtybbm,0),'C' as status,satkecil,
				satminta,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
				from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik );
				
				update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodoktmp and status!='C';
			ELSE
				insert into sc_trx.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'P' as status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.sppb_dtl
												/* qty qtysppbminta = qty qtybbm*/
				insert into sc_trx.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,
				satminta,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtysppbkecil,0),coalesce(qtysppbminta,0),coalesce(qtyrefonhand,0),coalesce(qtypo,0),coalesce(qtybbm,0),status,satkecil,
				satminta,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
				from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik );
				
				update sc_trx.approvals_system set status='U',asstatus='P' where docno = new.nodoktmp and status!='U';	
			END IF;
/* SMS SISA */
			
			delete from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='F' and old.status='C') THEN
			delete from sc_trx.sppb_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.sppb_dtl where nodok=new.nodoktmp and nik=new.nik;


			insert into sc_trx.sppb_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,cancelby,canceldate,tgldok,itemtype)
			(select branch,new.nodoktmp,nodokref,nik,loccode,'C',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,new.nodok,to_char(now(),'YYYY-MM-DD HH24:mi:ss')::timestamp without time zone,tgldok,itemtype
			from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);
			--select * from sc_tmp.sppb_dtl
			insert into sc_trx.sppb_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
			keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
			(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,'C' as status,satkecil,satminta,
			keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
			from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik);

			update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodoktmp and status!='C';

			delete from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik;
		
		ELSEIF (new.status='C' and old.status='P') THEN
			--delete from sc_trx.stgblcbr where docno=new.nodok and doctype='BBK';	
			update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodoktmp and status!='C';	
		ELSEIF (new.status='I' and old.status='I') THEN --UBAH PADA SAAT INPUT
			update sc_tmp.sppb_dtl 
			set loccode=new.loccode
			where nodok=new.nodok and nik=new.nik;
			--alter table sc_mst.stkgdw add column kdgroup character (25) ,add column kdsubgroup character(25)
		ELSEIF (new.status='F' and old.status='H') THEN --HANGUS BBK 
			delete from sc_trx.sppb_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.sppb_dtl where nodok=new.nodoktmp and nik=new.nik;

			select sum(coalesce(qtypo,0)) into vr_qtypo from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik and nodoktmp=new.nodoktmp;
			IF (vr_qtypo<=0) THEN
				insert into sc_trx.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'C' as status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.sppb_dtl
												/* qty qtysppbminta = qty qtybbm*/
				insert into sc_trx.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,
				satminta,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtysppbkecil,0),coalesce(qtypo,0),coalesce(qtyrefonhand,0),coalesce(qtypo,0),coalesce(qtybbm,0),'C' as status,satkecil,
				satminta,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
				from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik );
			ELSE
				insert into sc_trx.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'H' as status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,
				hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.sppb_dtl
												/* qty qtysppbminta = qty qtybbm*/
				insert into sc_trx.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtypokecil,qtybbm,qtybbmkecil,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtypokecil,0),coalesce(qtypo,0),coalesce(qtyrefonhand,0),coalesce(qtypo,0),coalesce(qtypokecil,0),coalesce(qtybbm,0),coalesce(qtybbmkecil,0),'H' as status,satkecil,
				satminta,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
				from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik );

							/* delete history pbk jika ada*/
				delete from sc_his.sppb_mst where nodok=new.nodoktmp and nik=new.nik;
				delete from sc_his.sppb_dtl where nodok=new.nodoktmp and nik=new.nik;
				
				insert into sc_his.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,tgldok,itemtype)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'H',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,updatedate,updateby,tgldok,itemtype
				from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.sppb_dtl
				insert into sc_his.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtypokecil,qtybbm,qtybbmkecil,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtysppbkecil,0),coalesce(qtysppbminta,0),coalesce(qtyrefonhand,0),coalesce(qtypo,0),coalesce(qtypokecil,0),coalesce(qtybbm,0),coalesce(qtybbmkecil,0),'H' as status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
				from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik );
			END IF;

			update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodoktmp and status!='C';
			
			delete from sc_tmp.sppb_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.sppb_dtl where nodok=new.nodok and nik=new.nik;
		
			
		END IF; 
		RETURN NEW;
	ELSEIF tg_op = 'DELETE' THEN

		RETURN old;	
	END IF;

/*
select * from sc_tmp.stpbk
select * from sc_trx.stpbk

select * from sc_mst.nomor
insert into sc_mst.nomor VALUES
('PO_SPPB','',4,'PPB1706','',0,'66666','','201606','T')
--delete from sc_mst.nomor where dokumen='PO_SPPB';
*/
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_tmp_sppb_mst()
  OWNER TO postgres;
