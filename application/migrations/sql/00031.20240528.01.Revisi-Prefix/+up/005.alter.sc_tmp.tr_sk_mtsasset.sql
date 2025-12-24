-- Function: sc_tmp.tr_sk_mtsasset()

-- DROP FUNCTION sc_tmp.tr_sk_mtsasset();

CREATE OR REPLACE FUNCTION sc_tmp.tr_sk_mtsasset()
  RETURNS trigger AS
$BODY$
declare
--created by Fiky ::26/07/2017
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);
begin    

	IF TG_OP ='INSERT' THEN 
		delete from sc_mst.penomoran where userid=new.nodok;
		delete from sc_mst.trxerror where userid=new.nodok;    

		select trim(split_part(trim(prefix),'SKMM',2)) as cekprefix into vr_cekprefix from sc_mst.nomor where dokumen='PER_SKMEMO';
		
		insert into sc_mst.penomoran 
		(userid,dokumen,nomor,errorid,partid,counterid,xno)
		values(new.nodok,'PER_SKMEMO',' ',0,' ',1,0);
		vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;
		
		insert into sc_his.sk_mtsasset
		(nodok,nodokref,kdbarang,kdgudang,userpakai,oldkdgudang,olduserpakai,nosk,tgldok,tglev,keterangan,status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby)
		(select vr_nomor,nodokref,kdbarang,kdgudang,userpakai,oldkdgudang,olduserpakai,nosk,tgldok,tglev,keterangan,'A' as status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby
		from sc_tmp.sk_mtsasset where nodok=new.nodok);
		
		delete from sc_tmp.sk_mtsasset where nodok=new.nodok;
		
		
	RETURN NEW;
	ELSEIF TG_OP ='UPDATE' THEN
	
			
		
	RETURN NEW;
	END IF;
/*
select * from sc_tmp.sk_mtsasset
select * from sc_his.sk_mtsasset
--truncate sc_tmp.sk_mtsasset,sc_his.sk_mtsasset
select * from sc_mst.nomor
insert into sc_mst.nomor VALUES
('PER_SKMEMO','',4,'SKMM1706','',0,'66666','','201606','T')
--delete from sc_mst.nomor where dokumen='PER_SKMEMO';
*/
     
    
    return new;
        
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_sk_mtsasset()
  OWNER TO postgres;
