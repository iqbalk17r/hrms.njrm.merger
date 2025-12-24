-- Function: sc_tmp.tr_mtsasset_st()

-- DROP FUNCTION sc_tmp.tr_mtsasset_st();

CREATE OR REPLACE FUNCTION sc_tmp.tr_mtsasset_st()
  RETURNS trigger AS
$BODY$
declare
--created by Fiky ::26/07/2017
--triger penomoran mutasi asset referensi mutasi
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);
begin    

	IF TG_OP ='INSERT' THEN 
		delete from sc_mst.penomoran where userid=new.nodok;
		delete from sc_mst.trxerror where userid=new.nodok;    

		select trim(split_part(trim(prefix),'STMA',2)) as cekprefix into vr_cekprefix from sc_mst.nomor where dokumen='MTAS_ST';
		select to_char(now(),'YYMM') as cekbulan into vr_nowprefix;
		if(vr_nowprefix<>vr_cekprefix) then 
			update sc_mst.nomor set prefix='STMA'||vr_nowprefix,docno=0 where dokumen='MTAS_ST';
		end if;
		insert into sc_mst.penomoran 
		(userid,dokumen,nomor,errorid,partid,counterid,xno)
		values(new.nodok,'MTAS_ST',' ',0,' ',1,0);
		vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;
		
		insert into sc_his.mtsasset_st
		(nodok,nodokref,kdbarang,kdgudang,userpakai,usertau,oldkdgudang,olduserpakai,nosk,tgldok,tglev,keterangan,status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby)
		(select vr_nomor,nodokref,kdbarang,kdgudang,userpakai,usertau,oldkdgudang,olduserpakai,nosk,tgldok,tglev,keterangan,'A' as status,inputdate,inputby,updatedate,updateby,approvaldate,approvalby
		from sc_tmp.mtsasset_st where nodok=new.nodok);
		
		delete from sc_tmp.mtsasset where nodok=new.nodok;
		
		
	RETURN NEW;
	ELSEIF TG_OP ='UPDATE' THEN
	
			
		
	RETURN NEW;
	END IF;
/*
select * from sc_tmp.mtsasset
select * from sc_his.mtsasset
--truncate sc_tmp.sk_mtsasset,sc_his.mtsasset
select * from sc_mst.nomor
insert into sc_mst.nomor VALUES
('MTAS_ST','',4,'STMA1706','',0,'66666','','201606','T')
--delete from sc_mst.nomor where dokumen='MTAS_ST';
*/
     
    
    return new;
        
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sc_tmp.tr_mtsasset_st()
  OWNER TO postgres;
