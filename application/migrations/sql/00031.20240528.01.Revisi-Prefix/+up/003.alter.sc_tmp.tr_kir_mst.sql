-- Function: sc_tmp.tr_kir_mst()

-- DROP FUNCTION sc_tmp.tr_kir_mst();

CREATE OR REPLACE FUNCTION sc_tmp.tr_kir_mst()
  RETURNS trigger AS
$BODY$
declare
--created by Fiky ::18/05/2018
     vr_nomor char(12);  
     vr_cekprefix char(4);
     vr_nowprefix char(4);
begin    

	IF TG_OP ='INSERT' THEN 

	RETURN NEW;
	ELSEIF TG_OP ='UPDATE' THEN
			
			/* NO RESOURCE UPDATE 
			select * from sc_mst.nomor	
			select * from sc_mst.penomoran	
			select * from sc_his.kir_mst
			select * from sc_mst.mbarang
			*/
		if (new.status='F' and old.status='I') then
			delete from sc_mst.penomoran where userid=new.docno;
			delete from sc_mst.trxerror where userid=new.docno;  

			

			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.docno,'KIR',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.docno and dokumen='KIR';
		
			insert into sc_his.kir_mst
			(docno,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select vr_nomor,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,'A' as status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.kir_mst where docno=new.docno);

			delete from sc_tmp.kir_mst where docno=new.docno;
		elseif (new.status='F' and old.status='E') then
			delete from sc_his.kir_mst where docno=new.docnotmp;
			
			insert into sc_his.kir_mst
			(docno,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select docnotmp,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,'A' as status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.kir_mst where docno=new.docno);

			delete from sc_tmp.kir_mst where docno=new.docno;
		elseif (new.status='F' and old.status='A') then
			delete from sc_his.kir_mst where docno=new.docnotmp;
			
			insert into sc_his.kir_mst
			(docno,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select docnotmp,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,'P' as status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.kir_mst where docno=new.docno);

			update sc_mst.mbarang set expkir=new.expkir, docujikir=new.docujikir where nodok=new.stockcode;
			
			delete from sc_tmp.kir_mst where docno=new.docno;
		elseif (new.status='F' and old.status='C') then
			delete from sc_his.kir_mst where docno=new.docnotmp;
			
			insert into sc_his.kir_mst
			(docno,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select docnotmp,docdate,docref,kdgroup,kdsubgroup,stockcode,docujikir,expkir,old_docujikir,old_expkir,reminder,reminderdate,
			namapengurus,contactpengurus,ttlvalue,description,'C' as status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.kir_mst where docno=new.docno);

			delete from sc_tmp.kir_mst where docno=new.docno;			
		end if;
	
			
	RETURN NEW;
	END IF;
    
    
    return new;
        
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_kir_mst()
  OWNER TO postgres;
