-- Function: sc_tmp.tr_tmp_stpbk_mst()

-- DROP FUNCTION sc_tmp.tr_tmp_stpbk_mst();

CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_stpbk_mst()
  RETURNS trigger AS
$BODY$
DECLARE 
	--author by fiky: 12/08/2017
	--update by fiky: 12/08/2017
	vr_nomor character(20);
	vr_lastdoc numeric;
	vr_cekprefix char(4);
	vr_nowprefix char(4);  
	vr_onhand_p numeric;
	vr_onhand_r numeric;
     
BEGIN		
	IF tg_op = 'INSERT' THEN
		--select * from sc_tmp.stpbk_mst
		--select * from sc_tmp.stpbk_dtl
	/*
		IF NOT EXISTS(select * from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik) THEN
			insert into sc_tmp.stpbk_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby)
			(select branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby
			from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik);
		END IF;
	*/
	
		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
		
		IF (new.status='A' and old.status='I') THEN
			delete from sc_mst.penomoran where userid=new.nodok;
			delete from sc_mst.trxerror where userid=new.nodok;  
					
			vr_lastdoc:= case 
			when max((right(trim(nodok),4))) is null or max((right(trim(nodok),4)))='' then '0'::numeric
			else max((right(trim(nodok),4)))::numeric end lastdoc
			from sc_trx.stpbk_mst
			where to_char(tgldok,'yyyymm')=to_char(new.tgldok,'yyyymm');

			update sc_mst.nomor set  prefix='PBK'||to_char(new.tgldok,'YYMM') ,docno=vr_lastdoc where dokumen='STG_PBK';
			
			/*
			select * from sc_trx.stpbk_mst
			where to_char(inputdate,'yyyymm')='201712';

			update sc_trx.stpbk_mst a set tgldok=to_char(b.inputdate,'yyyy-mm-dd')::date from sc_trx.stpbk_mst b
			where a.nodok=b.nodok and a.nik=b.nik;

			select * from sc_mst.nomor
			update sc_mst.nomor set docno=vr_lastdoc where dokumen='STG_PBK';

			select case 
			when max((right(trim(nodok),4))) is null or max((right(trim(nodok),4)))='' then '0'::numeric
			else max((right(trim(nodok),4)))::numeric end lastdoc
			from sc_trx.stpbk_mst
			where to_char(tgldok,'yyyymm')='201801';

			select trim(split_part(trim(prefix),'PBK',2)) as cekprefix into vr_cekprefix from sc_mst.nomor where dokumen='STG_PBK';
			select to_char(new.tgldok,'YYMM') as cekbulan into vr_nowprefix;
			if(vr_nowprefix<>vr_cekprefix) then 
				update sc_mst.nomor set prefix='PBK'||vr_nowprefix,docno=0 where dokumen='STG_PBK';
			end if;

			*/

			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.nodok,'STG_PBK',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;
			
			insert into sc_trx.stpbk_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,tgldok)
			(select branch,vr_nomor,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,tgldok
			from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
			--select * from sc_tmp.stpbk_dtl
			insert into sc_trx.stpbk_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,qtypo,id)
			(select branch,vr_nomor,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,qtypo,id
			from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik);
			
			
			delete from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='A' and old.status='E') THEN
			delete from sc_trx.stpbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stpbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.stpbk_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok)
			(select branch,new.nodoktmp,nodokref,nik,loccode,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok
			from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
			--select * from sc_tmp.stpbk_dtl
			insert into sc_trx.stpbk_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id)
			(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id
			from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik);

			delete from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='F' and old.status='C') THEN
			delete from sc_trx.stpbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stpbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.stpbk_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok)
			(select branch,new.nodoktmp,nodokref,nik,loccode,'C',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok
			from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
			--select * from sc_tmp.stpbk_dtl
			insert into sc_trx.stpbk_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id)
			(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id
			from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik);

			delete from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='X' and old.status='C') THEN
			delete from sc_trx.stpbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stpbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.stpbk_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok)
			(select branch,new.nodoktmp,nodokref,nik,loccode,'C',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok
			from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
			--select * from sc_tmp.stpbk_dtl
			insert into sc_trx.stpbk_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id)
			(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id
			from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik);

			delete from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='F' and old.status='A') THEN
			delete from sc_trx.stpbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stpbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.stpbk_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok)
			(select branch,new.nodoktmp,nodokref,nik,loccode,'P',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok
			from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
			--select * from sc_tmp.stpbk_dtl
			insert into sc_trx.stpbk_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id)
			(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id
			from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik);

			delete from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='C' and old.status='P') THEN
			--delete from sc_trx.stgblcbr where docno=new.nodok and doctype='BBK';		
		ELSEIF (new.status='I' and old.status='I') THEN --UBAH PADA SAAT INPUT
			update sc_tmp.stpbk_dtl 
			set loccode=new.loccode
			where nodok=new.nodok and nik=new.nik;
			----select * from sc_mst.stkgdw
			update sc_tmp.stpbk_dtl a
			set qtyonhand=coalesce(b.onhand,0) from sc_mst.stkgdw b
			where a.loccode=b.loccode and a.branch=b.branch and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode;
			--alter table sc_mst.stkgdw add column kdgroup character (25) ,add column kdsubgroup character(25)
		ELSEIF (new.status='F' and old.status='H') THEN --HANGUS PERMINTAAN 

			--vr_onhand_p:=count(*) from sc_trx.stpbk_dtl where status='P'  and coalesce(qtyonhand,0)=0 and nodok=new.nodok and nik=new.nik;
			--vr_onhand_r:=count(*) from sc_trx.stpbk_dtl where status='P'  and coalesce(qtyonhand,0)=0 and nodok=new.nodok and nik=new.nik;
			/* BATAL JIKA NODOKTMP TIDAK ADA DI REV MASTER BBK SAMA SKALI*/
			if not exists (select * from sc_trx.stbbk_mst where nodokref=new.nodoktmp) then
				delete from sc_trx.stpbk_mst where nodok=new.nodoktmp and nik=new.nik;
				delete from sc_trx.stpbk_dtl where nodok=new.nodoktmp and nik=new.nik;

				insert into sc_trx.stpbk_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,tgldok)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'C',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,tgldok
				from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.stpbk_dtl
												/* qty pbk = qty bbk*/
				insert into sc_trx.stpbk_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtybbk,qtybbk,qtyonhand,'C',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id
				from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik );

				delete from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik;
				delete from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik;
			else
				/* KETIKA BARANG SUDAH PERNAH DI PROSES*/
				delete from sc_trx.stpbk_mst where nodok=new.nodoktmp and nik=new.nik;
				delete from sc_trx.stpbk_dtl where nodok=new.nodoktmp and nik=new.nik;

				insert into sc_trx.stpbk_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'U',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,tgldok
				from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.stpbk_dtl
												/* qty pbk = qty bbk*/
				insert into sc_trx.stpbk_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtybbk,qtybbk,qtyonhand,'U',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id
				from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik );

				/* delete history pbk jika ada*/
				delete from sc_his.stpbk_mst where nodok=new.nodoktmp and nik=new.nik;
				delete from sc_his.stpbk_dtl where nodok=new.nodoktmp and nik=new.nik;
				
				insert into sc_his.stpbk_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,tgldok)
				(select branch,new.nodoktmp,nodokref,nik,loccode,'H',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,updatedate,updateby,tgldok
				from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik);
				--select * from sc_tmp.stpbk_dtl
				insert into sc_his.stpbk_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id)
				(select branch,new.nodoktmp,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,qtypo,id
				from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik );


				delete from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik;
				delete from sc_tmp.stpbk_dtl where nodok=new.nodok and nik=new.nik;
			end if;
			
		END IF; 
		RETURN NEW;
	ELSEIF tg_op = 'DELETE' THEN
			
			--update sc_trx.stpbk_mst set status='A'
		RETURN old;	
	END IF;
	
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_tmp_stpbk_mst()
  OWNER TO postgres;
