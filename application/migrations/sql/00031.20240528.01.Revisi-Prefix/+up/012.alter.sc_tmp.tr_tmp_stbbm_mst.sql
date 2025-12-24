-- Function: sc_tmp.tr_tmp_stbbm_mst()

-- DROP FUNCTION sc_tmp.tr_tmp_stbbm_mst();

CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_stbbm_mst()
  RETURNS trigger AS
$BODY$
DECLARE 
	--author by fiky: 12/10/2017
	--update by fiky: 12/10/2017
     vr_nomor char(15); 
     vr_nomorfrom char(25); 
  
          vr_id_dtl numeric;
          vr_qtybbm numeric;
          vr_qtybbmkecil numeric;
     vr_kdgroup char(100);
     vr_kdsubgroup char(100);
     vr_stockcode char(100);
BEGIN		
	IF tg_op = 'INSERT' THEN
		--select * from sc_tmp.stbbm_mst where nodok is null
		/*IF NOT EXISTS(select * from sc_tmp.stpbk_mst where nodok=new.nodok and nik=new.nik) THEN
			insert into sc_tmp.stpbk_mst 
			(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby)
			(select branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby
			from sc_tmp.stbbm_mst where nodok=new.nodok and nik=new.nik);
		END IF; */
	
		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN

		IF (OLD.STATUS='I' AND NEW.STATUS='F') THEN
  

/*

select * from sc_trx.stbbm_mst
select * from sc_mst.nomor
select * from sc_mst.penomoran
insert into sc_mst.nomor VALUES
('STBBM','',4,'BBM170618','',0,'66666','','201706','T')
--delete from sc_mst.nomor where dokumen='STBBM';
*/
/* PENOMORAN BBM */
			delete from sc_mst.trxerror where userid=new.nodok; 
			delete from sc_mst.penomoran where userid=new.nodok and dokumen='AJ_ATK';
			delete from sc_mst.penomoran where userid=new.nodok and dokumen='STBBM';

			
			
			 
			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.nodok,'STBBM',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok and dokumen='STBBM';

			IF (new.nodoktype='AJS') then	
				/* PENOMORAN AJUSTMENT */
				
			
				
				insert into sc_mst.penomoran 
				(userid,dokumen,nomor,errorid,partid,counterid,xno)
				values(new.nodok,'AJ_ATK',' ',0,' ',1,0);
				vr_nomorfrom:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok and dokumen='AJ_ATK';
			
				insert into sc_trx.stbbm_mst
				(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom)
				(select branch,vr_nomor,vr_nomorfrom ,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'A' as status,nodokfrom from sc_tmp.stbbm_mst where nodok=new.nodok);


				insert into sc_trx.stbbm_dtl
				(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
				exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
				(select branch,vr_nomor,vr_nomorfrom,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
				exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'A' as status from sc_tmp.stbbm_dtl where nodok=new.nodok);

				insert into sc_trx.stbbm_dtlref
				(branch,nodok,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
				(select branch,vr_nomor,vr_nomorfrom,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'A' as status from sc_tmp.stbbm_dtlref where nodok=new.nodok);
			ELSE  
				insert into sc_trx.stbbm_mst
				(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom)
				(select branch,vr_nomor,nodokref ,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'A' as status,nodokfrom from sc_tmp.stbbm_mst where nodok=new.nodok);


				insert into sc_trx.stbbm_dtl
				(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
				exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
				(select branch,vr_nomor,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
				exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'A' as status from sc_tmp.stbbm_dtl where nodok=new.nodok);

				insert into sc_trx.stbbm_dtlref
				(branch,nodok,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
				(select branch,vr_nomor,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'A' as status from sc_tmp.stbbm_dtlref where nodok=new.nodok);
			END IF;
			
			
			delete from sc_tmp.stbbm_mst where nodok=new.nodok;
			delete from sc_tmp.stbbm_dtl where nodok=new.nodok;
			delete from sc_tmp.stbbm_dtlref where nodok=new.nodok;

			delete from sc_mst.trxerror where modul='TMPSTBBM';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','TMPSTBBM');
	
		ELSEIF (OLD.STATUS='E' AND NEW.STATUS='F') THEN
			delete from sc_trx.stbbm_mst where nodok=new.nodoktmp;
			delete from sc_trx.stbbm_dtl where nodok=new.nodoktmp;
			delete from sc_trx.stbbm_dtlref where nodok=new.nodoktmp;

			--select * from sc_tmp.stbbm_mst
			insert into sc_trx.stbbm_mst
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'A' as status,nodokfrom from sc_tmp.stbbm_mst where nodok=new.nodok);


			insert into sc_trx.stbbm_dtl
			(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'A' as status from sc_tmp.stbbm_dtl where nodok=new.nodok);

			insert into sc_trx.stbbm_dtlref
			(branch,nodok,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'A' as status from sc_tmp.stbbm_dtlref where nodok=new.nodok);
			

			/* update agar tidak mengubah qty */
			update sc_tmp.stbbm_dtl set status='X' where nodok=new.nodok;
			update sc_tmp.stbbm_dtlref set status='X' where nodok=new.nodok;

			
			delete from sc_tmp.stbbm_mst where nodok=new.nodok;
			delete from sc_tmp.stbbm_dtl where nodok=new.nodok;
			delete from sc_tmp.stbbm_dtlref where nodok=new.nodok;

			delete from sc_mst.trxerror where modul='TMPSTBBM';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,new.nodoktmp,'','TMPSTBBM');

		ELSEIF (OLD.STATUS='C' AND NEW.STATUS='F') THEN
			delete from sc_trx.stbbm_mst where nodok=new.nodoktmp;
			delete from sc_trx.stbbm_dtl where nodok=new.nodoktmp;
			delete from sc_trx.stbbm_dtlref where nodok=new.nodoktmp;

			--select * from sc_tmp.stbbm_mst
			insert into sc_trx.stbbm_mst
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'C' as status,nodokfrom from sc_tmp.stbbm_mst where nodok=new.nodok);


			insert into sc_trx.stbbm_dtl
			(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'C' as status from sc_tmp.stbbm_dtl where nodok=new.nodok);

			insert into sc_trx.stbbm_dtlref
			(branch,nodok,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'C' as status from sc_tmp.stbbm_dtlref where nodok=new.nodok);
			

			/* update agar tidak mengubah qty */
			----update sc_tmp.stbbm_dtl set status='X' where nodok=new.nodok;
			---update sc_tmp.stbbm_dtlref set status='X' where nodok=new.nodok;

			delete from sc_tmp.stbbm_dtlref where nodok=new.nodok;
			delete from sc_tmp.stbbm_dtl where nodok=new.nodok;
			delete from sc_tmp.stbbm_mst where nodok=new.nodok;
			
			

			delete from sc_mst.trxerror where modul='TMPSTBBM';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,new.nodoktmp,'','TMPSTBBM');

		ELSEIF (OLD.STATUS='A' AND NEW.STATUS='F') THEN
			delete from sc_trx.stbbm_mst where nodok=new.nodoktmp;
			delete from sc_trx.stbbm_dtl where nodok=new.nodoktmp;
			delete from sc_trx.stbbm_dtlref where nodok=new.nodoktmp;


			if ((select coalesce(sum(qtybbm),0) from sc_tmp.stbbm_dtl where nodok=new.nodok)=0) then

			insert into sc_trx.stbbm_mst
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'C' as status,nodokfrom from sc_tmp.stbbm_mst where nodok=new.nodok);


			insert into sc_trx.stbbm_dtl
			(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'C' AS status from sc_tmp.stbbm_dtl where nodok=new.nodok);

			insert into sc_trx.stbbm_dtlref
			(branch,nodok,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'C' AS status from sc_tmp.stbbm_dtlref where nodok=new.nodok);
			
			else
			--select * from sc_tmp.stbbm_mst
			insert into sc_trx.stbbm_mst
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'P' as status,nodokfrom from sc_tmp.stbbm_mst where nodok=new.nodok);


			insert into sc_trx.stbbm_dtl
			(branch,nodok,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,qtyonhand,satminta,satkecil,disc1,disc2,disc3,disc4,
			exppn,nbrutto,ndiskon,ndpp,nppn,nnetto,pkp,unitprice,pricelist,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'P' as status from sc_tmp.stbbm_dtl where nodok=new.nodok);

			insert into sc_trx.stbbm_dtlref
			(branch,nodok,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,status)
			(select branch,new.nodoktmp,nodokref,fromcode,loccode,kdgroup,kdsubgroup,stockcode,id,desc_barang,qtyrec,qtyreckecil,qtybbm,qtybbmkecil,satminta,satkecil,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbm_tmp,qtybbmkecil_tmp,'P' as status from sc_tmp.stbbm_dtlref where nodok=new.nodok);
			

			/* update agar tidak mengubah qty */
			----update sc_tmp.stbbm_dtl set status='X' where nodok=new.nodok;
			---update sc_tmp.stbbm_dtlref set status='X' where nodok=new.nodok;

			/* MENGURANGI STOCK ALLOCATED  SETELAH DELETE */
			--select * from sc_mst.stkgdw
			--select * from sc_tmp.stbbm_dtlref
			update sc_mst.stkgdw a set onhand=coalesce(a.onhand,0)+coalesce(b.qtybbmkecil,0)
			from sc_tmp.stbbm_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
			and a.stockcode=b.stockcode and b.nodok=new.nodok and  b.nodokref=new.nodokref and b.id=b.id;


			FOR vr_id_dtl,vr_kdgroup,vr_kdsubgroup,vr_stockcode,vr_qtybbmkecil,vr_qtybbm in select id,kdgroup,kdsubgroup,stockcode,qtybbmkecil,qtybbm from sc_tmp.stbbm_dtl where nodok=new.nodok order by id asc
				LOOP
				--select * from sc_trx.stbbm_MST
				--select * from sc_tmp.stbbm_dtlref
				insert into sc_trx.stgblco
				(branch,loccode,kdgroup,kdsubgroup,stockcode,trxdate,doctype,docno,docref,qty_in,qty_out,qty_sld,hist,ctype)
				(select branch,loccode,kdgroup,kdsubgroup,stockcode,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp as trxdate,'BBM' AS doctype,nodoktmp as docno,nodokref as docref,
				qtybbmkecil,0 as qty_out,0 as qty_sld,'' as hist,'' as ctype from sc_tmp.stbbm_dtl
				where nodok=new.nodok and id=vr_id_dtl and kdgroup=vr_kdgroup and kdsubgroup=vr_kdsubgroup and stockcode=vr_stockcode);

				IF (trim(new.nodoktype)='TRG') THEN
					update sc_trx.itemtrans_dtl set qtybbm=coalesce(qtybbm,0)+coalesce(vr_qtybbm,0)
					where nodok=new.nodokref and kdgroup=vr_kdgroup and kdsubgroup=vr_kdsubgroup and stockcode=vr_stockcode;

				END IF;

			END LOOP;
			end if;
			--select * from sc_trx.stgblco
			
			delete from sc_tmp.stbbm_mst where nodok=new.nodok;
			delete from sc_tmp.stbbm_dtl where nodok=new.nodok;
			delete from sc_tmp.stbbm_dtlref where nodok=new.nodok;

			delete from sc_mst.trxerror where modul='TMPSTBBM';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,new.nodoktmp,'','TMPSTBBM');	

		ELSEIF (OLD.STATUS='P' AND NEW.STATUS='A') THEN
			/*UPDATE sc_trx.stbbm_mst SET STATUS='A' WHERE
			NODOK=NEW.NODOKTMP AND NIK=NEW.NIK AND KDGROUP=NEW.KDGROUP AND KDSUBGROUP=NEW.KDSUBGROUP AND STOCKCODE=NEW.STOCKCODE;*/
		END IF;

				/* TRIGER PEMBATALAN STATUS MASTER KETIKA DIREJECT SEMUA ITEM 
		IF EXISTS(SELECT * FROM SC_TRX.STPBK_MST WHERE STATUS='A' AND NODOK=NEW.NODOKTMP) THEN
			IF NOT EXISTS (SELECT * FROM SC_TMP.stbbm_mst WHERE NODOK=NEW.NODOK AND (STATUS='A' OR STATUS='P' OR STATUS='I')) THEN
				UPDATE SC_TMP.STPBK_MST SET STATUS='C' WHERE NODOK=NEW.NODOK;
			ELSEIF EXISTS (SELECT * FROM SC_TMP.stbbm_mst WHERE NODOK=NEW.NODOK AND STATUS='A') THEN
				UPDATE SC_TMP.STPBK_MST SET STATUS='A' WHERE NODOK=NEW.NODOK;
				
			END IF;
		END IF;*/
		
		RETURN NEW;
	ELSEIF tg_op = 'DELETE' THEN
			/*IF ( old.status='C') THEN
				update sc_tmp.stbbm_dtl set 
				qtybbm=(coalesce(old.qtybbm,0)-coalesce(old.qtybbm,0)), 
				qtybbmkecil=-coalesce(qtybbmkecil,0)-coalesce(old.qtybbmkecil,0)
				where nodok=old.nodok and nodokref=old.nodokref and kdgroup=old.kdgroup and kdsubgroup=old.kdsubgroup and stockcode=old.stockcode;
			
				update sc_trx.po_dtlref set 
				qtyterima=coalesce(old.qtybbm,0)-coalesce(old.qtybbm,0),
				qtyterima_kecil=coalesce(qtyterima_kecil,0)-coalesce(old.qtybbmkecil,0)
				where nodok=old.nodokref and kdgroup=old.kdgroup and kdsubgroup=old.kdsubgroup and stockcode=old.stockcode and id=old.id;

				delete from sc_mst.trxerror where userid=new.nodok and modul='STBBM';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(old.nodok,0,old.nodok,'','STBBM');
		
			END IF;*/
		RETURN old;	
	END IF;

END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_tmp_stbbm_mst()
  OWNER TO postgres;
