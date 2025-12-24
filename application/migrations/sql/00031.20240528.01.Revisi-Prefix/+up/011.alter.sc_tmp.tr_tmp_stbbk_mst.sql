-- Function: sc_tmp.tr_tmp_stbbk_mst()

-- DROP FUNCTION sc_tmp.tr_tmp_stbbk_mst();

CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_stbbk_mst()
  RETURNS trigger AS
$BODY$
DECLARE 
	--author by fiky: 12/08/2017
	--update by fiky: 12/08/2017
	--TRIGER PENOMORAN FINAL BBK
     vr_nomor char(12); 
    
     vr_nomorfrom char(14);  
BEGIN		
	IF tg_op = 'INSERT' THEN
		--select * from sc_trx.stbbk_mst
		--select * from sc_trx.stbbk_dtl
		
		--select * from sc_tmp.stbbk_mst
		--select * from sc_tmp.stbbk_dtl
		--select * from sc_mst.trxerror
		delete from sc_mst.trxerror where userid=new.nodok and modul='TMPSTBBK';
		insert into sc_mst.trxerror
		(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
		(new.nodok,1,new.nodokref,'','TMPSTBBK');
		
	
		IF NOT EXISTS(select * from sc_tmp.stbbk_mst where nodok=new.nodok and nodokref=new.nodokref and status='I') THEN
			update sc_tmp.stbbk_mst a set
			nik=b.nik,
			loccode=b.loccode
			from sc_trx.stbbk_mst b where b.nodok=new.nodokref and a.nodok=new.nodok ;

		/*	delete from sc_tmp.stbbk_dtl where nodok=new.nodok and nodokref=new.nodokref;
			insert into sc_tmp.stbbk_dtl 
			(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref)
			(select branch,new.nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'I',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref
			from sc_trx.stbbk_dtl where nodok=new.nodokref); */
		END IF;
			
		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN
		delete from sc_mst.trxerror where userid=new.nodok and modul='TMPSTBBK';
		insert into sc_mst.trxerror
		(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
		(new.nodok,1,new.nodokref,'','TMPSTBBK'); 
		
		IF (new.status='A' and old.status='I') THEN
			delete from sc_mst.trxerror where userid=new.nodok; 
			---delete from sc_mst.penomoran where userid=new.nodok and dokumen='AJ_ATK';
			delete from sc_mst.penomoran where userid=new.nodok;
			delete from sc_mst.trxerror where userid=new.nodok;    
			
			
			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.nodok,'STG_BBK',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;

			IF (NEW.NODOKTYPE='PBK') THEN
				update sc_trx.stpbk_dtl a set qtybbk=coalesce(a.qtybbk,0)+coalesce(b.qtybbk,0)
				from sc_tmp.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
				and a.stockcode=b.stockcode and b.nodok=new.nodok  and b.nodokref=new.nodokref and a.nodok=new.nodokref;

				insert into sc_trx.stbbk_mst 
				(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
				ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
				(select branch,vr_nomor,nodokref,loccode,nik,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
				ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'A' as status,nodokfrom,nik
				from sc_tmp.stbbk_mst where nodok=new.nodok);
				--select * from sc_tmp.stbbk_dtl
				
				/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
				---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
				
				insert into sc_trx.stbbk_dtl 
				(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
				(select branch,vr_nomor,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'A' as status,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
				from sc_tmp.stbbk_dtl where nodok=new.nodok);

			ELSEIF (NEW.NODOKTYPE='AJS') THEN
				update sc_tmp.stbbk_dtl set status='F' where nodok=new.nodok and nodokref=new.nodokref;
				/* PENOMORAN AJUSTMENT */
				
				
				insert into sc_mst.penomoran 
				(userid,dokumen,nomor,errorid,partid,counterid,xno)
				values(new.nodok,'AJ_ATK',' ',0,' ',1,0);
				vr_nomorfrom:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok and dokumen='AJ_ATK';

				insert into sc_trx.stbbk_mst 
				(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
				ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
				(select branch,vr_nomor,vr_nomorfrom,loccode,nik,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
				ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'A' as status,nodokfrom,nik
				from sc_tmp.stbbk_mst where nodok=new.nodok);
							
				/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
				---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
				
				insert into sc_trx.stbbk_dtl 
				(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
				(select branch,vr_nomor,vr_nomorfrom,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'A' as status,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
				from sc_tmp.stbbk_dtl where nodok=new.nodok);
			
				
			END IF;


			
			delete from sc_tmp.stbbk_mst where nodok=new.nodok ;
			delete from sc_tmp.stbbk_dtl where nodok=new.nodok ;

			/*insert sukses ke trxerror*/
			delete from sc_mst.trxerror where userid=new.nodok and modul='TMPSTBBK';
			insert into sc_mst.trxerror
			(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
			(new.nodok,0,vr_nomor,'','TMPSTBBK');
			
		ELSEIF (new.status='A' and old.status='E') THEN
			delete from sc_trx.stbbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stbbk_dtl where nodok=new.nodoktmp and nik=new.nik;


			
			IF (NEW.NODOKTYPE='PBK') THEN
				/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
				update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
				
				update sc_trx.stpbk_dtl a set qtybbk=coalesce(a.qtybbk,0)-coalesce(b.qtybbk,0)+coalesce(b.qtybbk,0)
				from sc_tmp.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
				and a.stockcode=b.stockcode and b.nodok=new.nodok  and b.nodokref=new.nodokref and a.nodok=new.nodokref;
							
				/*update sc_mst.stkgdw a set 
				allocated=coalesce(allocated,0)+coalesce(b.qtybbk,0) --, tmpalloca=coalesce(a.tmpalloca,0)-coalesce(b.qtybbk,0)
				from sc_tmp.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
				and a.stockcode=b.stockcode and b.status='A' and b.nodok=new.nodok and  b.nodokref=new.nodokref; */
			ELSEIF (NEW.NODOKTYPE='AJS') THEN
				update sc_tmp.stbbk_dtl set status='F' where nodok=new.nodok and nodokref=new.nodokref;
			END IF;

			insert into sc_trx.stbbk_mst 
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'A' as status,nodokfrom,nik
			from sc_tmp.stbbk_mst where nodok=new.nodok);
			--select * from sc_tmp.stbbk_dtl
			
			/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
			---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
			
			insert into sc_trx.stbbk_dtl 
			(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
			(select branch,new.nodoktmp,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'A' as status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
			from sc_tmp.stbbk_dtl where nodok=new.nodok);

			delete from sc_tmp.stbbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stbbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='C' and old.status='C') THEN
			delete from sc_trx.stbbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stbbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.stbbk_mst 
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'C' as status,nodokfrom,nik
			from sc_tmp.stbbk_mst where nodok=new.nodok);
			--select * from sc_tmp.stbbk_dtl
			
			/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
			---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
			
			insert into sc_trx.stbbk_dtl 
			(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
			(select branch,new.nodoktmp,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'C' as status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
			from sc_tmp.stbbk_dtl where nodok=new.nodok);
			

			/*update sc_mst.stkgdw a set tmpalloca=coalesce(tmpalloca,0)-coalesce(b.qtybbk,0)
			from sc_tmp.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
			and a.stockcode=b.stockcode; */


			delete from sc_tmp.stbbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stbbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='F' and old.status='A') THEN
			delete from sc_trx.stbbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stbbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			IF NOT EXISTS(select * from sc_tmp.stbbk_dtl where nodok=new.nodok and nik=new.nik and status='P') THEN 
				
				/* JIKA KESELURUHAN ITEM DIBATALKAN */
					insert into sc_trx.stbbk_mst 
						(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
						ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
						(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
						ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'C' as status,nodokfrom,nik
						from sc_tmp.stbbk_mst where nodok=new.nodok);
						--select * from sc_tmp.stbbk_dtl
						
						/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
						---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
						
						insert into sc_trx.stbbk_dtl 
						(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
						inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
						(select branch,new.nodoktmp,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'C' as status,keterangan,inputdate,
						inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
						from sc_tmp.stbbk_dtl where nodok=new.nodok);
						
				/* UPDATE STPBK SAAT PEMBATALAN SAJA*/
			IF (NEW.NODOKTYPE='PBK') THEN
				/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
				update sc_trx.stpbk_dtl a set qtybbk=coalesce(a.qtybbk,0)-coalesce(b.qtybbk,0)
				from sc_tmp.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
				and a.stockcode=b.stockcode and b.nodok=new.nodok  and b.nodokref=new.nodokref and a.nodok=new.nodokref;
			ELSEIF (NEW.NODOKTYPE='AJS') THEN
				update sc_tmp.stbbk_dtl set status='C' where nodok=new.nodok and nodokref=new.nodokref;
				update sc_tmp.stbbk_dtl set status='F' where nodok=new.nodok and nodokref=new.nodokref;
			END IF;
		ELSE
						insert into sc_trx.stbbk_mst 
						(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
						ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
						(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
						ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'P' as status,nodokfrom,nik
						from sc_tmp.stbbk_mst where nodok=new.nodok);
						--select * from sc_tmp.stbbk_dtl
						
						/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
						---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
						
						insert into sc_trx.stbbk_dtl 
						(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
						inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
						(select branch,new.nodoktmp,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'P' as status,keterangan,inputdate,
						inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
						from sc_tmp.stbbk_dtl where nodok=new.nodok);
						
						IF (NEW.NODOKTYPE='PBK') THEN
							/* insert ke stgblco */
							insert into sc_trx.stgblco (branch,loccode,kdgroup,kdsubgroup,stockcode,trxdate,doctype,docno,docref,qty_in,qty_out,qty_sld,hist,ctype)
							(select branch,loccode,kdgroup,kdsubgroup,stockcode,inputdate,'BBK',nodoktmp,nodokref,0 as qty_in,qtybbk as qty_out,0 as qty_sld,'' as hist,'' as ctype from sc_tmp.stbbk_dtl where 
							status='P' and nodok=new.nodok and  nodokref=new.nodokref);
	
							/* MENGURANGI STOCK ALLOCATED  SETELAH DELETE */
							update sc_mst.stkgdw a set allocated=coalesce(a.allocated,0)-coalesce(b.qtybbk,0)
							from sc_trx.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
							and a.stockcode=b.stockcode and b.nodok=new.nodoktmp and  b.nodokref=new.nodokref;
						ELSEIF (NEW.NODOKTYPE='AJS') THEN
							insert into sc_trx.stgblco (branch,loccode,kdgroup,kdsubgroup,stockcode,trxdate,doctype,docno,docref,qty_in,qty_out,qty_sld,hist,ctype)
							(select branch,loccode,kdgroup,kdsubgroup,stockcode,inputdate,'BBK',nodoktmp,nodokref,0 as qty_in,qtybbk as qty_out,0 as qty_sld,'' as hist,'' as ctype from sc_tmp.stbbk_dtl where 
							status='P' and nodok=new.nodok and  nodokref=new.nodokref);
							
							update sc_tmp.stbbk_dtl set status='F' where nodok=new.nodok and nodokref=new.nodokref;
						END IF;


		END IF;

				
			delete from sc_tmp.stbbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stbbk_dtl where nodok=new.nodok and nik=new.nik;

			
		ELSEIF (new.status='F' and old.status='C') THEN
			delete from sc_trx.stbbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stbbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.stbbk_mst 
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'C' as status,nodokfrom,nik
			from sc_tmp.stbbk_mst where nodok=new.nodok);
			--select * from sc_tmp.stbbk_dtl
			
			/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
			---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
			
			insert into sc_trx.stbbk_dtl 
			(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
			(select branch,new.nodoktmp,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'C' as status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
			from sc_tmp.stbbk_dtl where nodok=new.nodok);
			
							
			IF (NEW.NODOKTYPE='PBK') THEN
				/* UPDATE STPBK SAAT PEMBATALAN SAJA*/
				update sc_trx.stpbk_dtl a set qtybbk=coalesce(a.qtybbk,0)-coalesce(b.qtybbk,0)
				from sc_tmp.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
				and a.stockcode=b.stockcode and b.nodok=new.nodok  and b.nodokref=new.nodokref and a.nodok=new.nodokref;

			ELSEIF (NEW.NODOKTYPE='AJS') THEN	
				update sc_tmp.stbbk_dtl set status='F' where nodok=new.nodok and nodokref=new.nodokref;
			END IF;
			
			delete from sc_tmp.stbbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stbbk_dtl where nodok=new.nodok and nik=new.nik;
		ELSEIF (new.status='C' and old.status='P') THEN
			--delete from sc_trx.stgblcbr where docno=new.nodok and doctype='BBK';		
		ELSEIF (new.status='I' and old.status='I') THEN --UBAH PADA SAAT INPUT
			update sc_tmp.stbbk_dtl 
			set loccode=new.loccode
			where nodok=new.nodok and nik=new.nik;
			----select * from sc_mst.stkgdw
			update sc_tmp.stbbk_dtl a
			set qtyonhand=coalesce(b.onhand,0) from sc_mst.stkgdw b
			where a.loccode=b.loccode and a.branch=b.branch and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode;
			--alter table sc_mst.stkgdw add column kdgroup character (25) ,add column kdsubgroup character(25)
		ELSEIF (new.status='F' and old.status='H') THEN --HANGUS BBK 
			delete from sc_trx.stbbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_trx.stbbk_dtl where nodok=new.nodoktmp and nik=new.nik;

			insert into sc_trx.stbbk_mst 
			(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
			(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
			ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'H' as status,nodokfrom,nik
			from sc_tmp.stbbk_mst where nodok=new.nodok);
			--select * from sc_tmp.stbbk_dtl
			
			/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
			---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
			
			insert into sc_trx.stbbk_dtl 
			(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
			(select branch,new.nodoktmp,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'H' as status,keterangan,inputdate,
			inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
			from sc_tmp.stbbk_dtl where nodok=new.nodok);
						


			/* delete history pbk jika ada*/
			delete from sc_his.stbbk_mst where nodok=new.nodoktmp and nik=new.nik;
			delete from sc_his.stbbk_dtl where nodok=new.nodoktmp and nik=new.nik;
			
			insert into sc_his.stbbk_mst 
				(branch,nodok,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
				ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,status,nodokfrom,nik)
				(select branch,new.nodoktmp,nodokref,loccode,nodokopr,nodokdate,nodoktype,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,
				ttldpp,ttlppn,ttlnetto,pkp,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,'C' as status,nodokfrom,nik
				from sc_tmp.stbbk_mst where nodok=new.nodok);
				--select * from sc_tmp.stbbk_dtl
				
				/*UPDATE DETAIL TERLEBIH DAHULU AGAR TIDAK KENA TRIGER DELETE*/
				---update sc_tmp.stbbk_dtl set status='A' where nodok=new.nodok and nik=new.nik;
				
			insert into sc_his.stbbk_dtl 
				(branch,nodok,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,status,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik)
				(select branch,new.nodoktmp,nodokref,kdgroup,kdsubgroup,stockcode,id,nodoktype,loccode,desc_barang,qtypbk,qtybbk,qtyonhand,'C' as status,keterangan,inputdate,
				inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,qtybbk_tmp,nik
				from sc_tmp.stbbk_dtl where nodok=new.nodok);


			delete from sc_tmp.stbbk_mst where nodok=new.nodok and nik=new.nik;
			delete from sc_tmp.stbbk_dtl where nodok=new.nodok and nik=new.nik;
		
						/* MENGURANGI STOCK ALLOCATED  SETELAH DELETE */
			update sc_mst.stkgdw a set allocated=coalesce(a.allocated,0)-coalesce(b.qtybbk,0)
			from sc_trx.stbbk_dtl b where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
			and a.stockcode=b.stockcode and b.nodok=new.nodoktmp and  b.nodokref=new.nodokref;
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
('STG_BBK','',4,'BBK1706','',0,'66666','','201606','T')
--delete from sc_mst.nomor where dokumen='STG_PBK';
*/
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_tmp_stbbk_mst()
  OWNER TO postgres;
