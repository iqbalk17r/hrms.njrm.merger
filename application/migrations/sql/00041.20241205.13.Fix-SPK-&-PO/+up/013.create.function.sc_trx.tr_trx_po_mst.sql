-- DROP FUNCTION sc_trx.tr_trx_po_mst();

CREATE OR REPLACE FUNCTION sc_trx.tr_trx_po_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::26/07/2017
--update by Fiky ::23/04/2018
--penambahan itemtype barang
     vr_nomor char(12); 
     vr_cekprefix char(12);
     vr_nowprefix char(12);
begin    

    IF TG_OP ='INSERT' THEN 
        
        
    RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN

        IF (new.status='E' and old.status in ('A','A1','A2','A3','A4','A5','A6')) THEN
			if not exists(select * from sc_tmp.po_mst where  nodok in (select trim(nodok) from sc_tmp.po_mst where nodoktmp=new.nodok)) then
				insert into sc_tmp.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.updateby,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodok,'E' as status,itemtype from sc_trx.po_mst where nodok=new.nodok);
				
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.updateby,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'E' as status,pkp,unitprice from sc_trx.po_dtl where nodok=new.nodok);

				insert into sc_tmp.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,status)
				(select branch,new.updateby,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,'M' as status from sc_trx.po_dtlref where nodok=new.nodok);
			end if;
		ELSEIF (new.status='A' and old.status='A') THEN
			if not exists(select * from sc_tmp.po_mst where  nodok in (select trim(nodok) from sc_tmp.po_mst where nodoktmp=new.nodok)) then
				insert into sc_tmp.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.updateby,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodok,'A' as status,itemtype from sc_trx.po_mst where nodok=new.nodok);
				
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.updateby,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'A' as status,pkp,unitprice from sc_trx.po_dtl where nodok=new.nodok);

				insert into sc_tmp.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,status)
				(select branch,new.updateby,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,'A' as status from sc_trx.po_dtlref where nodok=new.nodok);
			end if;

		ELSEIF (new.status='C' and old.status='A') THEN
			if not exists(select * from sc_tmp.po_mst where  nodok in (select trim(nodok) from sc_tmp.po_mst where nodoktmp=new.nodok)) then
				insert into sc_tmp.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.cancelby,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodok,'C' as status,itemtype from sc_trx.po_mst where nodok=new.nodok);
				
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.cancelby,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'C' as status,pkp,unitprice from sc_trx.po_dtl where nodok=new.nodok);

				insert into sc_tmp.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,status)
				(select branch,new.cancelby,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,'C' as status from sc_trx.po_dtlref where nodok=new.nodok);
			end if;	
		ELSEIF (new.status='H' and old.status='P') THEN
			if not exists(select * from sc_tmp.po_mst where  nodok in (select trim(nodok) from sc_tmp.po_mst where nodoktmp=new.nodok)) then
				insert into sc_tmp.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.hangusby,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodok,'H' as status,itemtype from sc_trx.po_mst where nodok=new.nodok);
				
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.hangusby,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'H' as status,pkp,unitprice from sc_trx.po_dtl where nodok=new.nodok);

				insert into sc_tmp.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,status)
				(select branch,new.hangusby,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta,qtykecil,
				qtyterima,qtyterima_kecil,'H' as status from sc_trx.po_dtlref where nodok=new.nodok);
				
			end if;

		ELSEIF (new.status='E' and old.status='A') THEN
			if not exists(select * from sc_tmp.po_mst where  nodok in (select trim(nodok) from sc_tmp.po_mst where nodoktmp=new.nodok)) then
				insert into sc_tmp.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.updateby,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodok,'E' as status,itemtype from sc_trx.po_mst where nodok=new.nodok);
				
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.updateby,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'E' as status,pkp,unitprice from sc_trx.po_dtl where nodok=new.nodok);

				insert into sc_tmp.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,status)
				(select branch,new.updateby,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,'M' as status from sc_trx.po_dtlref where nodok=new.nodok);
			end if;
		
		ELSEIF (new.status='AF1' and old.status='F') THEN
			if exists (select * from sc_trx.po_mst_lampiran where nodok in (new.nodok)) then
				delete from sc_trx.po_mst_lampiran where nodok in (new.nodok);
			end if;
			if EXISTS (select * from sc_trx.po_detail_lampiran where nodok in (new.nodok)) then
				delete from sc_trx.po_detail_lampiran where nodok in (new.nodok);
			end if;
			if EXISTS (select * from sc_trx.po_lampiran where nodok in (new.nodok)) then
				delete from sc_trx.po_lampiran where nodok in (new.nodok);
			end if;
			INSERT INTO sc_trx.po_mst_lampiran
			select * from sc_tmp.po_mst_lampiran where nodok in (new.nodok);
			DELETE FROM sc_tmp.po_mst_lampiran where nodok in (new.nodok);
			INSERT INTO sc_trx.po_detail_lampiran
			select * from sc_tmp.po_detail_lampiran where nodok in (new.nodok);
			DELETE FROM sc_tmp.po_detail_lampiran where nodok in (new.nodok);
			INSERT INTO sc_trx.po_lampiran
			select * from sc_tmp.po_lampiran where nodok in (new.nodok);
			DELETE FROM sc_tmp.po_lampiran where nodok in (new.nodok);

		ELSEIF (new.status='F' and old.status='P') THEN
		    UPDATE sc_trx.po_mst SET status='AF1' where nodok=new.nodok;

		ELSEIF (new.status='E' and old.status in ('AF1','AF2','AF3','AF4','AF5','AF6','QA')) THEN
			if not exists(select * from sc_tmp.po_mst where  nodok in (select trim(nodok) from sc_tmp.po_mst where nodoktmp=new.nodok)) then
				insert into sc_tmp.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.updateby,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,
				ttldiskon,ttldpp,ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodok,'E' as status,itemtype from sc_trx.po_mst where nodok=new.nodok);
				
				insert into sc_tmp.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.updateby,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,
				exppn,ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'E' as status,pkp,unitprice from sc_trx.po_dtl where nodok=new.nodok);

				insert into sc_tmp.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,status)
				(select branch,new.updateby,nodokref,nik,kdgroup,kdsubgroup,stockcode,id,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,keterangan,qtyminta_tmp,qtyminta_tmp_kecil,
				qtyterima,qtyterima_kecil,'M' as status from sc_trx.po_dtlref where nodok=new.nodok);

			end if;
		END IF;
		
	RETURN NEW;
	END IF;
    return new;
end;
$function$
;
