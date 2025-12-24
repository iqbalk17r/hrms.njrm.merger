-- Function: sc_tmp.tr_sim_mst()

-- DROP FUNCTION sc_tmp.tr_sim_mst();

CREATE OR REPLACE FUNCTION sc_tmp.tr_sim_mst()
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
			INSERT INTO SC_MST.nomor 
			(dokumen,part,count3,prefix,docno,userid,periode,cekclose)
			values
			('SIM','',4,'KS1805',0,'FIKY','201801','F');
			select * from sc_mst.penomoran	
			select * from sc_his.sim_mst
			select * from sc_mst.mbarang
			*/
		if (new.status='F' and old.status='I') then
			delete from sc_mst.penomoran where userid=new.docno;
			delete from sc_mst.trxerror where userid=new.docno;  

			
			insert into sc_mst.penomoran 
			(userid,dokumen,nomor,errorid,partid,counterid,xno)
			values(new.docno,'SIM',' ',0,' ',1,0);
			vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.docno and dokumen='SIM';
		
			insert into sc_his.sim_mst
			(docno,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select vr_nomor,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,'A' as status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.sim_mst where docno=new.docno);

			delete from sc_tmp.sim_mst where docno=new.docno;
		elseif (new.status='F' and old.status='E') then
			delete from sc_his.sim_mst where docno=new.docnotmp;
			
			insert into sc_his.sim_mst
			(docno,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select new.docnotmp,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,'A' as status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.sim_mst where docno=new.docno);

			delete from sc_tmp.sim_mst where docno=new.docno;
		elseif (new.status='F' and old.status='A') then
			delete from sc_his.sim_mst where docno=new.docnotmp;
			--select * from sc_mst.sim
			insert into sc_his.sim_mst
			(docno,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select new.docnotmp,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,'P' as status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.sim_mst where docno=new.docno);

			update sc_mst.sim set expsim=new.expsim, datecreate=new.datecreate,ttlvalue=new.ttlvalue where nik=new.nik and typesim=new.typesim;
			
			delete from sc_tmp.sim_mst where docno=new.docno;
		elseif (new.status='F' and old.status='C') then
			delete from sc_his.sim_mst where docno=new.docnotmp;
			
			insert into sc_his.sim_mst
			(docno,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
			(select new.docnotmp,docdate,docref,nik,docsim,typesim,datecreate,expsim,old_docsim,old_expsim,reminder,reminderdate,namapengurus,contactpengurus,ttlvalue,description,'C' as status,
		        inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp from sc_tmp.sim_mst where docno=new.docno);
		        
			delete from sc_tmp.sim_mst where docno=new.docno;			
		end if;
	
			
	RETURN NEW;
	END IF;
    
    
    return new;
        
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_sim_mst()
  OWNER TO postgres;
