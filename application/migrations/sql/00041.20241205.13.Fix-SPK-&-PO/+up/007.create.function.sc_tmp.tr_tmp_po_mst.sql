-- DROP FUNCTION sc_tmp.tr_tmp_po_mst();

CREATE OR REPLACE FUNCTION sc_tmp.tr_tmp_po_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::26/07/2017
--update by Fiky ::16/04/2018
--ubah penambahan itemtype
     vr_nomor char(12); 
     vr_cekprefix char(12);
     vr_nowprefix char(12);
     vr_cekpodtl numeric;
     vr_cekpodtl_nullprice numeric;
     vr_cekpodtlref numeric;
     vr_cekpodtlref_m numeric;
     vr_ceksupplier numeric;
     vr_id_dtl numeric;
     vr_kdgroup char(100);
     vr_kdsubgroup char(100);
     vr_stockcode char(100);
     vr_satkecil char(100);
begin    

	IF TG_OP ='INSERT' THEN 
		
		
	RETURN NEW;
	ELSEIF TG_OP ='UPDATE' THEN

		IF (new.status='A' and old.status='I') THEN
			
			select count(*) into vr_cekpodtl from sc_tmp.po_dtl where nodok=new.nodok;
			select count(*) into vr_cekpodtl_nullprice from sc_tmp.po_dtl where nodok=new.nodok  and coalesce(ttlbrutto,0)=0;
			select count(*) into vr_cekpodtlref from sc_tmp.po_dtlref where nodok=new.nodok;
			select count(*) into vr_cekpodtlref_m from sc_tmp.po_dtlref where nodok=new.nodok and status='M';
			select count(*) into vr_ceksupplier from sc_tmp.po_mst where nodok=new.nodok and (kdsupplier='' or  kdsupplier is null);

			IF((vr_cekpodtl=0 ) or (vr_cekpodtl_nullprice>0))THEN				
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,2,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='I' where nodok=new.nodok;
			ELSEIF(vr_cekpodtlref<>vr_cekpodtlref_m) THEN	
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,3,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='I' where nodok=new.nodok;
			ELSEIF(vr_ceksupplier>0) THEN	
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,4,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='I' where nodok=new.nodok;

			ELSE
				delete from sc_mst.penomoran where userid=new.nodok;
				delete from sc_mst.trxerror where userid=new.nodok;    
				--UPDATE "sc_tmp"."po_mst" SET "status" = 'A' WHERE "nodok" = '1115.184 '
				---select * from sc_mst.nomor
				---select * from sc_tmp.po_mst
				
				insert into sc_mst.penomoran 
				(userid,dokumen,nomor,errorid,partid,counterid,xno)
				values(new.nodok,'PO_ATK',' ',0,' ',1,0);
				vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;

				insert into sc_trx.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,vr_nomor,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,'QA' as status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
				
				insert into sc_trx.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,vr_nomor,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'A' as status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);
				
				insert into sc_trx.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id)
				(select branch,vr_nomor,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,'A' as status,keterangan,id
				from sc_tmp.po_dtlref where nodok=new.nodok);

				/* update ini tidak mengurangi stock sppb */
				update sc_tmp.po_dtlref set status='' where nodok=new.nodok;

				delete from sc_tmp.po_mst where nodok=new.nodok;
				delete from sc_tmp.po_dtl where nodok=new.nodok;
				delete from sc_tmp.po_dtlref where nodok=new.nodok;

				delete from sc_mst.trxerror where modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,0,vr_nomor,'','TMPPO');
			END IF;
			
		ELSEIF (new.status='A' and old.status='E') THEN
			select count(*) into vr_cekpodtl from sc_tmp.po_dtl where nodok=new.nodok;
			select count(*) into vr_cekpodtl_nullprice from sc_tmp.po_dtl where nodok=new.nodok  and coalesce(ttlbrutto,0)=0;
			select count(*) into vr_cekpodtlref from sc_tmp.po_dtlref where nodok=new.nodok;
			select count(*) into vr_cekpodtlref_m from sc_tmp.po_dtlref where nodok=new.nodok and status='M';
			select count(*) into vr_ceksupplier from sc_tmp.po_mst where nodok=new.nodok and (kdsupplier='' or  kdsupplier is null);

			IF((vr_cekpodtl=0) or (vr_cekpodtl_nullprice>0))THEN				
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,52,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='E' where nodok=new.nodok;
			ELSEIF(vr_cekpodtlref<>vr_cekpodtlref_m) THEN	
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,53,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='E' where nodok=new.nodok;
			ELSEIF(vr_ceksupplier>0) THEN	
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,54,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='E' where nodok=new.nodok;

			ELSE

				delete from sc_trx.po_mst where nodok=new.nodoktmp;
				delete from sc_trx.po_dtl where nodok=new.nodoktmp;
				delete from sc_trx.po_dtlref where nodok=new.nodoktmp;
				
				insert into sc_trx.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,'A' as status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
				
				insert into sc_trx.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'A' as status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

				insert into sc_trx.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id)
				(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,'A' as status,keterangan,id
				from sc_tmp.po_dtlref where nodok=new.nodok);
				
				/* update ini tidak mengurangi stock sppb */
				update sc_tmp.po_dtlref set status='' where nodok=new.nodok;
				
				delete from sc_tmp.po_mst where nodok=new.nodok;
				delete from sc_tmp.po_dtl where nodok=new.nodok;
				delete from sc_tmp.po_dtlref where nodok=new.nodok;


				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,0,new.nodoktmp,'','TMPPO');
			END IF;
		ELSEIF (new.status='F' and old.status not in ('C','H')) THEN
			delete from sc_trx.po_mst where nodok=new.nodoktmp;
			delete from sc_trx.po_dtl where nodok=new.nodoktmp;
			delete from sc_trx.po_dtlref where nodok=new.nodoktmp;
			
			insert into sc_trx.po_mst 
			(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
			ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
			(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
			ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,'P' as status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
			
			insert into sc_trx.po_dtl
			(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
			ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
			(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
			ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'P' as status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

			insert into sc_trx.po_dtlref
			(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id)
			(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,'P' as status,keterangan,id
			from sc_tmp.po_dtlref where nodok=new.nodok);

			--select * from sc_tmp.po_dtl
			--select * from sc_tmp.po_mst
			FOR vr_id_dtl,vr_kdgroup,vr_kdsubgroup,vr_stockcode,vr_satkecil in select id,kdgroup,kdsubgroup,stockcode,satkecil from sc_tmp.po_dtl where nodok=new.nodok order by id asc
				LOOP
			--(branch, jenisprice, kdgroup, kdsubgroup, stockcode, kdgroupsupplier, kdsupplier, kdsubsupplier, kdcabangsupplier, pricedate, satkecil)
				IF NOT EXISTS (select * from sc_mst.pricelst where  kdgroup=vr_kdgroup and kdsubgroup=vr_kdsubgroup and stockcode=vr_stockcode and
						kdgroupsupplier=new.kdgroupsupplier and  kdsupplier=new.kdsupplier and kdsubsupplier=new.kdsubsupplier and kdcabangsupplier=new.kdsubsupplier and satkecil=vr_satkecil) THEN 

						
						insert into sc_mst.pricelst
						(branch,jenisprice,kdgroup,kdsubgroup,stockcode,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pricedate,
						satkecil,qtykecil,payterm,unitprice,disc1,disc2,disc3,disc4,updateby,updatedate,nodokref,pkp,exppn,status)
						(select a.branch,'I' as jenisprice,a.kdgroup,a.kdsubgroup,a.stockcode,b.kdgroupsupplier,b.kdsupplier,b.kdsubsupplier,b.kdcabangsupplier,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp pricedate,a.satkecil,round(coalesce(a.qtykecil,0)/coalesce(a.qtykecil,0)) as qtykecil,
						coalesce(b.payterm,0) as payterm
						,round(coalesce(a.ttlbrutto,0)/coalesce(a.qtykecil,0)) as unitprice,a.disc1,a.disc2,a.disc3,a.disc4,a.updateby,a.updatedate,(b.nodoktmp),b.pkp,b.exppn,'I' 
						from sc_tmp.po_dtl a 
						left outer join sc_tmp.po_mst b on a.nodok=b.nodok
						where a.nodok=new.nodok and a.kdgroup=vr_kdgroup and a.kdsubgroup=vr_kdsubgroup and a.stockcode=vr_stockcode and a.id=vr_id_dtl);

					---select * from sc_mst.pricelst
					---select * from sc_mst.pricelst
				END IF;
			END LOOP;
			


			/* update ini tidak mengurangi stock sppb */
			update sc_tmp.po_dtlref set status='' where nodok=new.nodok;
			
			delete from sc_tmp.po_mst where nodok=new.nodok;
			delete from sc_tmp.po_dtl where nodok=new.nodok;
			delete from sc_tmp.po_dtlref where nodok=new.nodok;
				
		ELSEIF (new.status='F' and old.status='C') THEN
			delete from sc_trx.po_mst where nodok=new.nodoktmp;
			delete from sc_trx.po_dtl where nodok=new.nodoktmp;
			delete from sc_trx.po_dtlref where nodok=new.nodoktmp;
			
			insert into sc_trx.po_mst 
			(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
			ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
			(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
			ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,'C' as status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
			
			insert into sc_trx.po_dtl
			(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
			ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
			(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
			ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'C' as status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

			insert into sc_trx.po_dtlref
			(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id)
			(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,'C' as status,keterangan,id
			from sc_tmp.po_dtlref where nodok=new.nodok);

			/* update ini tidak mengurangi stock sppb */
			update sc_tmp.po_dtlref set status='M' where nodok=new.nodok;
			
			delete from sc_tmp.po_mst where nodok=new.nodok;
			delete from sc_tmp.po_dtl where nodok=new.nodok;
			delete from sc_tmp.po_dtlref where nodok=new.nodok;
			/*HANGUS PO BERDASARKAN QTY YG DI RECEIPT */	
		ELSEIF (new.status='F' and old.status='H') THEN

			delete from sc_trx.po_mst where nodok=new.nodoktmp;
			delete from sc_trx.po_dtl where nodok=new.nodoktmp;
			delete from sc_trx.po_dtlref where nodok=new.nodoktmp;
			
			if exists(select * from sc_tmp.po_dtlref where coalesce(qtyterima,0)>0 and nodok=new.nodok) then
					insert into sc_trx.po_mst 
					(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
					ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
					(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
					ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,'H' as status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
					
					insert into sc_trx.po_dtl
					(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
					ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
					(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,coalesce(qtyreceiptkecil,0) as qtyreceiptkecil,satkecil,coalesce(qtyreceipt,0) as qtyreceipt,satminta,coalesce(qtyreceipt,0) as qtyreceipt,coalesce(qtyreceiptkecil,0) as qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
					ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'H' as status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

					insert into sc_trx.po_dtlref
					(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id,qtyminta_tmp,qtyminta_tmp_kecil,qtyterima,qtyterima_kecil)
					(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtyterima_kecil,0) as qtykecil,satkecil,coalesce(qtyterima,0) as qtyminta,satminta,'H' as status,keterangan,id,qtyminta_tmp,qtyminta_tmp_kecil,qtyterima,qtyterima_kecil
					from sc_tmp.po_dtlref where nodok=new.nodok);

					/* insert ke history */
					delete from sc_his.po_mst where nodok=new.nodoktmp;
					delete from sc_his.po_dtl where nodok=new.nodoktmp;
					delete from sc_his.po_dtlref where nodok=new.nodoktmp;
							
					insert into sc_his.po_mst 
					(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
					ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
					(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
					ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,'H' as status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
					
					insert into sc_his.po_dtl
					(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
					ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
					(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,coalesce(qtyreceiptkecil,0) as qtyreceiptkecil,satkecil,coalesce(qtyreceipt,0) as qtyreceipt,satminta,coalesce(qtyreceipt,0) as qtyreceipt,coalesce(qtyreceiptkecil,0) as qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
					ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'H' as status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

					insert into sc_his.po_dtlref
					(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id,qtyminta_tmp,qtyminta_tmp_kecil,qtyterima,qtyterima_kecil)
					(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,coalesce(qtyterima_kecil,0),satkecil,coalesce(qtyterima,0),satminta,'H' as status,keterangan,id,qtyminta_tmp,qtyminta_tmp_kecil,qtyterima,qtyterima_kecil
					from sc_tmp.po_dtlref where nodok=new.nodok);


					/* update ini tidak mengurangi stock sppb */
					update sc_tmp.po_dtlref set status='H' where nodok=new.nodok;
			
			else 
					insert into sc_trx.po_mst 
					(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
					ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
					(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
					ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,'C' as status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
					
					insert into sc_trx.po_dtl
					(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
					ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
					(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
					ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,'C' as status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

					insert into sc_trx.po_dtlref
					(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id,qtyminta_tmp,qtyminta_tmp_kecil,qtyterima,qtyterima_kecil)
					(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,'C' as status,keterangan,id,qtyminta_tmp,qtyminta_tmp_kecil,qtyterima,qtyterima_kecil
					from sc_tmp.po_dtlref where nodok=new.nodok);

					/* update ini tidak mengurangi stock sppb */
					update sc_tmp.po_dtlref set status='M' where nodok=new.nodok;


					
			end if;



			
			
			
			delete from sc_tmp.po_mst where nodok=new.nodok;
			delete from sc_tmp.po_dtl where nodok=new.nodok;
			delete from sc_tmp.po_dtlref where nodok=new.nodok;
			
		ELSEIF (new.status='' and old.status!='') THEN	

				update sc_tmp.po_mst a 
				set 
				ttldiskon=round(round(round(a.ttlbrutto)*a.disc1/100)+round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))+round(round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))*round(a.disc3/100))),
				ttldpp=
				case when coalesce(b.pkp,'')='YES' then
				round(round(a.ttlbrutto-round(round(round(a.ttlbrutto)*a.disc1/100)+round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))+round(round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))*round(a.disc3/100))))/1.1)
				else 0 end,
				ttlppn=
				case when coalesce(b.pkp,'')='YES' then
				round(round(round(a.ttlbrutto-round(round(round(a.ttlbrutto)*a.disc1/100)+round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))+round(round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))*round(a.disc3/100))))/1.1)*(10::numeric/100))
				else 0 end,
				ttlnetto=
					case 
					when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
					round(b.ttlbrutto-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100)))/1.1) +
					round(round(round(b.ttlbrutto-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100))))/1.1)*(10::numeric/100))
					when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
					round(coalesce(b.ttlbrutto,0)-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100))))
					else round(coalesce(b.ttlbrutto,0)-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100))))
					end,
				status=old.status
				from sc_tmp.po_mst b 
				left outer join (select a.* 
					from sc_mst.pricelst a,
					(select kdgroup,kdsubgroup,stockcode,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,qtykecil,satkecil,max(pricedate) as pricedate from sc_mst.pricelst 
					group by kdgroup,kdsubgroup,stockcode,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,qtykecil,satkecil) b where a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode 
					and a.kdgroupsupplier=b.kdgroupsupplier and a.kdsupplier=b.kdsupplier and a.kdsubsupplier=b.kdsubsupplier and a.kdcabangsupplier=b.kdcabangsupplier and a.pricedate=b.pricedate) c 
				on b.kdgroupsupplier=c.kdgroupsupplier and b.kdsupplier=c.kdsupplier and b.kdsubsupplier=c.kdsubsupplier and b.kdcabangsupplier=c.kdcabangsupplier 
				where a.nodok=b.nodok and a.nodok=new.nodok; 

				
				/*
				select * from sc_tmp.po_mst
				update sc_tmp.po_mst a 
				set 
				ttldiskon=round(round(round(a.ttlbrutto)*a.disc1/100)+round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))+round(round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))*round(a.disc3/100))),
				ttldpp=
				case when coalesce(b.pkp,'')='YES' then
				round(round(a.ttlbrutto-round(round(round(a.ttlbrutto)*a.disc1/100)+round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))+round(round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))*round(a.disc3/100))))/1.1)
				else 0 end,
				ttlppn=
				case when coalesce(b.pkp,'')='YES' then
				round(round(round(a.ttlbrutto-round(round(round(a.ttlbrutto)*a.disc1/100)+round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))+round(round(round(round(a.ttlbrutto)*a.disc1/100)*round(a.disc2/100))*round(a.disc3/100))))/1.1)*(10::numeric/100))
				else 0 end,
				ttlnetto=
					case 
					when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='EXC' then
					round(b.ttlbrutto-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100)))/1.1) +
					round(round(round(b.ttlbrutto-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100))))/1.1)*(10::numeric/100))
					when coalesce(b.pkp,'')='YES' and coalesce(b.exppn,'')='INC' then
					round(coalesce(b.ttlbrutto,0)-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100))))
					else round(coalesce(b.ttlbrutto,0)-round(round(round(b.ttlbrutto)*b.disc1/100)+round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))+round(round(round(round(b.ttlbrutto)*b.disc1/100)*round(b.disc2/100))*round(b.disc3/100))))
					end,
				status=old.status
				from sc_tmp.po_mst b
				where a.nodok=b.nodok and a.nodok=new.nodok; */

				update sc_tmp.po_dtl a set pkp=b.pkp,exppn=b.exppn,status='' 
				from sc_tmp.po_mst b 
				where a.nodok=new.nodok and a.id=a.id;

				--select * from sc_tmp.po_mst
				--select * from sc_tmp.po_dtl
		ELSEIF (new.status in ('A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'AF1', 'AF2', 'AF3', 'AF4', 'AF5', 'AF6', 'FP') and old.status='E') THEN
			select count(*) into vr_cekpodtl from sc_tmp.po_dtl where nodok=new.nodok;
			select count(*) into vr_cekpodtl_nullprice from sc_tmp.po_dtl where nodok=new.nodok  and coalesce(ttlbrutto,0)=0;
			select count(*) into vr_cekpodtlref from sc_tmp.po_dtlref where nodok=new.nodok;
			select count(*) into vr_cekpodtlref_m from sc_tmp.po_dtlref where nodok=new.nodok and status='M';
			select count(*) into vr_ceksupplier from sc_tmp.po_mst where nodok=new.nodok and (kdsupplier='' or  kdsupplier is null);

			IF((vr_cekpodtl=0) or (vr_cekpodtl_nullprice>0))THEN				
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,52,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='E' where nodok=new.nodok;
			ELSEIF(vr_ceksupplier>0) THEN	
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,54,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='E' where nodok=new.nodok;

			ELSE

				delete from sc_trx.po_mst where nodok=new.nodoktmp;
				delete from sc_trx.po_dtl where nodok=new.nodoktmp;
				delete from sc_trx.po_dtlref where nodok=new.nodoktmp;
				
				insert into sc_trx.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,new.status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
				
				insert into sc_trx.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,new.status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

				insert into sc_trx.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id)
				(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,new.status,keterangan,id
				from sc_tmp.po_dtlref where nodok=new.nodok);
				
				/* update ini tidak mengurangi stock sppb */
				-- update sc_tmp.po_dtlref set status='' where nodok=new.nodok;
				
				delete from sc_tmp.po_mst where nodok=new.nodok;
				delete from sc_tmp.po_dtl where nodok=new.nodok;
				delete from sc_tmp.po_dtlref where nodok=new.nodok;


				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,0,new.nodoktmp,'','TMPPO');
			END IF;		
		ELSEIF (new.status in ('P') and old.status='H') THEN
			select count(*) into vr_cekpodtl from sc_tmp.po_dtl where nodok=new.nodok;
			select count(*) into vr_cekpodtl_nullprice from sc_tmp.po_dtl where nodok=new.nodok  and coalesce(ttlbrutto,0)=0;
			select count(*) into vr_cekpodtlref from sc_tmp.po_dtlref where nodok=new.nodok;
			select count(*) into vr_cekpodtlref_m from sc_tmp.po_dtlref where nodok=new.nodok and status='M';
			select count(*) into vr_ceksupplier from sc_tmp.po_mst where nodok=new.nodok and (kdsupplier='' or  kdsupplier is null);

			IF((vr_cekpodtl=0) or (vr_cekpodtl_nullprice>0))THEN				
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,52,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='E' where nodok=new.nodok;
			ELSEIF(vr_ceksupplier>0) THEN	
				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,54,new.nodok,'','TMPPO');
				update sc_tmp.po_mst set status='E' where nodok=new.nodok;

			ELSE

				delete from sc_trx.po_mst where nodok=new.nodoktmp;
				delete from sc_trx.po_dtl where nodok=new.nodoktmp;
				delete from sc_trx.po_dtlref where nodok=new.nodoktmp;
				
				insert into sc_trx.po_mst 
				(branch,nodok,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,status,itemtype)
				(select branch,new.nodoktmp,nodokref,loccode,podate,kdgroupsupplier,kdsupplier,kdsubsupplier,kdcabangsupplier,pkp,disc1,disc2,disc3,disc4,exppn,ttlbrutto,ttldiskon,ttldpp,
				ttlppn,ttlnetto,payterm,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,hangusdate,hangusby,canceldate,cancelby,nodoktmp,new.status,itemtype from sc_tmp.po_mst where nodok=new.nodok);
				
				insert into sc_trx.po_dtl
				(branch,nodok,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,status,pkp,unitprice)
				(select branch,new.nodoktmp,kdgroup,kdsubgroup,stockcode,loccode,nodokref,desc_barang,qtykecil,satkecil,qtyminta,satminta,qtyreceipt,qtyreceiptkecil,disc1,disc2,disc3,disc4,exppn,
				ttlbrutto,ttldiskon,ttldpp,ttlppn,ttlnetto,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,id,new.status,pkp,unitprice from sc_tmp.po_dtl where nodok=new.nodok);

				insert into sc_trx.po_dtlref
				(branch,nodok,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,status,keterangan,id)
				(select branch,new.nodoktmp,nodokref,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtykecil,satkecil,qtyminta,satminta,new.status,keterangan,id
				from sc_tmp.po_dtlref where nodok=new.nodok);
				
				/* update ini tidak mengurangi stock sppb */
				-- update sc_tmp.po_dtlref set status='' where nodok=new.nodok;
				
				delete from sc_tmp.po_mst where nodok=new.nodok;
				delete from sc_tmp.po_dtl where nodok=new.nodok;
				delete from sc_tmp.po_dtlref where nodok=new.nodok;


				delete from sc_mst.trxerror where userid=new.nodok and modul='TMPPO';
				insert into sc_mst.trxerror
				(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
				(new.nodok,0,new.nodoktmp,'','TMPPO');
			END IF;		
		END IF;
			
		
	RETURN NEW;
	END IF;
/*
select * from sc_tmp.po_mst
select * from sc_trx.po_mst
--truncate sc_tmp.po_mst,sc_trx.po_mst
select * from sc_mst.nomor
select * from sc_mst.penomoran
insert into sc_mst.nomor VALUES
('PO_ATK','',4,'PO170618','',0,'66666','','201706','T')
--delete from sc_mst.nomor where dokumen='PO_ATK';
*/
    return new;
        
end;
$function$
;
