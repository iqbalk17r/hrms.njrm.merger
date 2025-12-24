CREATE OR REPLACE FUNCTION sc_trx.tr_trx_sppb_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE 
	--author by fiky: 12/08/2017
	--update by fiky: 28/11/2018
	--PENAMBAHAN SMS
     vr_nomor char(12); 
     vr_cekprefix char(4);
     vr_nowprefix char(4);  
BEGIN		
	IF tg_op = 'INSERT' THEN

		IF (new.status='P') THEN
	
/* KIRIM KE ATASAN 1 */
			insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
			select nomorsms,left(sms,160),pengirim from 			
(select 
trim(coalesce(nohpatasan1,'')) as nomorsms,
'No.SPPB: '||trim(coalesce(nodok,''))||'
Nama: '||trim(coalesce(nmlengkap,''))||'
Item: ('||trim(coalesce(qty::text,''))||') '||trim(coalesce(item1,''))||'
Conf: APPROVED
Ket: '||trim(coalesce(ketitem1,'')) as sms,
	'OSIN' as pengirim from (
select a.*,b.nmlengkap as nmlengkap,b.nohp1 as nohpown,c.nmlengkap as nmatasan1,c.nohp1 as nohpatasan1,d.nmlengkap as nmatasan2,d.nohp1 as nohpatasan2,e.desc_barang as item1,e.keterangan as ketitem1,e.qtysppbminta as qty from sc_trx.sppb_mst a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	left outer join sc_mst.karyawan d on d.nik=b.nik_atasan2 
	left outer join sc_trx.sppb_dtl e on a.nik=e.nik and a.nodok=e.nodok and e.id=1
--where a.nodok='PPB18110007' and a.nik='1115.184'
where a.nodok=new.nodok and a.nik=new.nik
) as x ) as y;

/* KIRIM NOTIF KE PEMINTA */
			insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
			select nomorsms,left(sms,160),pengirim from 			
(select 
trim(coalesce(nohpown,'')) as nomorsms,
'No.SPPB: '||trim(coalesce(nodok,''))||'
Nama: '||trim(coalesce(nmlengkap,''))||'
Item: ('||trim(coalesce(qty::text,''))||') '||trim(coalesce(item1,''))||'
Conf: APPROVED
Ket: '||trim(coalesce(ketitem1,'')) as sms,
	'OSIN' as pengirim from (
select a.*,b.nmlengkap as nmlengkap,b.nohp1 as nohpown,c.nmlengkap as nmatasan1,c.nohp1 as nohpatasan1,d.nmlengkap as nmatasan2,d.nohp1 as nohpatasan2,e.desc_barang as item1,e.keterangan as ketitem1,e.qtysppbminta as qty from sc_trx.sppb_mst a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	left outer join sc_mst.karyawan d on d.nik=b.nik_atasan2 
	left outer join sc_trx.sppb_dtl e on a.nik=e.nik and a.nodok=e.nodok and e.id=1
where a.nodok=new.nodok and a.nik=new.nik
--where a.nodok='PPB18110007' and a.nik='1115.184'
) as x ) as y; 

/* KIRIM KE HRD  */
	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select telepon,sms,creator from (
	select telepon,(select
'No.SPPB: '||trim(coalesce(nodok,''))||'
Nama: '||trim(coalesce(nmlengkap,''))||'
Item: ('||trim(coalesce(qty::text,''))||') '||trim(coalesce(item1,''))||'
Conf: TELAH DISETUJUI ATASAN
Ket: '||trim(coalesce(ketitem1,'')) as sms from (
select a.*,b.nmlengkap as nmlengkap,b.nohp1 as nohpown,c.nmlengkap as nmatasan1,c.nohp1 as nohpatasan1,d.nmlengkap as nmatasan2,d.nohp1 as nohpatasan2,e.desc_barang as item1,e.keterangan as ketitem1,e.qtysppbminta as qty from sc_trx.sppb_mst a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	left outer join sc_mst.karyawan d on d.nik=b.nik_atasan2 
	left outer join sc_trx.sppb_dtl e on a.nik=e.nik and a.nodok=e.nodok and e.id=1
where a.nodok=new.nodok and a.nik=new.nik
--where a.nodok='PPB18110007' and a.nik='1115.184'
) as x ) as sms,'OSIN' as creator  from
	(select t0.*,trim(t3.nohp1) as telepon,t1.nodok,t1.nik,t1.nmlengkap,t1.tgl_kerja,t1.tgl_jam_mulai,t1.tgl_jam_selesai,t1.nik as nik,t1.nmijin_absensi,t1.type_ijin from sc_mst.notif_sms t0
	left outer join (select	case b.kdcabang	when 'SBYMRG' then 'Y'	end as kanwil_sby,
				case b.kdcabang	when 'SMGDMK' then 'Y'	end as kanwil_dmk,
				case b.kdcabang	when 'SMGCND' then 'Y'	end as kanwil_smg,
				case b.kdcabang	when 'JKTKPK' then 'Y'	end as kanwil_jkt,
				a.*,b.nmlengkap,c.nmijin_absensi from sc_trx.ijin_karyawan a
			left outer join sc_mst.karyawan b on a.nik=b.nik
			left outer join sc_mst.ijin_absensi c on a.kdijin_absensi=c.kdijin_absensi
			--where nodok='PPB18110007'
			where nodok=new.nodok 
			) as t1
			on t0.kanwil_sby=t1.kanwil_sby or
			t0.kanwil_smg=t1.kanwil_smg or
			t0.kanwil_dmk=t1.kanwil_dmk or
			t0.kanwil_jkt=t1.kanwil_jkt
	left outer join sc_mst.karyawan t3 on t0.nik=t3.nik		
	where ijin='Y') as t2 ) as t3
	where telepon is not null and sms is not null and creator is not null;


			END IF;

		RETURN new;
	ELSEIF tg_op = 'UPDATE' THEN

		
		IF (new.status='P' and old.status='A') THEN
			--update sc_trx.sppb_dtl set status='P' where nodok=new.nodok;
		ELSEIF (new.status='E' and old.status='A') THEN
			if not exists(select * from sc_tmp.sppb_mst where nodoktmp=new.nodok and status='E') then
				insert into sc_tmp.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype )
				(select branch,new.updateby,nodokref,nik,loccode,'E',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodok,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype 
				from sc_trx.sppb_mst where nodok=new.nodok);
				
				insert into sc_tmp.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.updateby,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodok,fromstock,id
				from sc_trx.sppb_dtl where nodok=new.nodok );
			end if;
		ELSEIF (new.status='C' and old.status='A') THEN
			if not exists(select * from sc_tmp.sppb_mst where nodoktmp=new.nodok and status='E') then
				insert into sc_tmp.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype )
				(select branch,new.cancelby,nodokref,nik,loccode,'C',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodok,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype 
				from sc_trx.sppb_mst where nodok=new.nodok );
				
				insert into sc_tmp.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.cancelby,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id
				from sc_trx.sppb_dtl where nodok=new.nodok);
			end if;
		ELSEIF (new.status='A' and old.status='A' AND NEW.whatsappsent = FALSE AND OLD.whatsappsent = FALSE) THEN /* TARIKAN APPROVAL KE TEMPORARY */
			--SELECT * FROM sc_mst.trxtype
			if not exists(select * from sc_tmp.sppb_mst where nodoktmp=new.nodok and nodok=new.approvalby) then
				insert into sc_tmp.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype )
				(select branch,new.approvalby,nodokref,nik,loccode,'A',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodok,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype 
				from sc_trx.sppb_mst where nodok=new.nodok);
				
				insert into sc_tmp.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.approvalby,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtybbm,'A' as status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodok,fromstock,id
				from sc_trx.sppb_dtl where nodok=new.nodok);
			end if;
			----select * from sc_trx.sppb_dtl;
			
		ELSEIF (new.status='C' and old.status='P') THEN
			update sc_trx.sppb_dtl set status='C' where nodok=new.nodok;
		ELSEIF (new.status='H' and old.status in ('P','S')) THEN   
			if not exists(select * from sc_tmp.sppb_mst where nodoktmp=new.nodok and nodok=new.hangusby) then
				insert into sc_tmp.sppb_mst 
				(branch,nodok,nodokref,nik,loccode,status,keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodoktmp,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype )
				(select branch,new.hangusby,nodokref,nik,loccode,'H',keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodok,hangusdate,hangusby,canceldate,cancelby,tgldok,itemtype 
				from sc_trx.sppb_mst where nodok=new.nodok);
				
				insert into sc_tmp.sppb_dtl 
				(branch,nodok,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtypokecil,qtybbm,qtybbmkecil,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodoktmp,fromstock,id)
				(select branch,new.hangusby,nik,kdgroup,kdsubgroup,stockcode,loccode,desc_barang,qtysppbkecil,qtysppbminta,qtyrefonhand,qtypo,qtypokecil,qtybbm,qtybbmkecil,status,satkecil,satminta,
				keterangan,inputdate,inputby,updatedate,updateby,approvaldate,approvalby,nodokref,nodok,fromstock,id
				from sc_trx.sppb_dtl where nodok=new.nodok);
			end if;
		ELSEIF (new.status='C' and old.status='A') THEN
			update sc_trx.sppb_dtl set status='C' where nodok=new.nodok;
		ELSEIF (new.status='R' and old.status='A') THEN
		/* RESEND SMS */
			insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
			select nomorsms,left(sms,160),pengirim from 			
(select 
trim(coalesce(nohpatasan1,'')) as nomorsms,
'No.SPPB: '||trim(coalesce(nodok,''))||'
Nama: '||trim(coalesce(nmlengkap,''))||'
Location: '||trim(coalesce(loccode))||'
Item: ('||trim(coalesce(qty::text))||') '||trim(coalesce(item1))||'
Conf: Y/N
Ket: '||trim(coalesce(ketitem1)) as sms,
	'OSIN' as pengirim from (
select a.*,b.nmlengkap as nmlengkap,b.nohp1 as nohpown,c.nmlengkap as nmatasan1,c.nohp1 as nohpatasan1,d.nmlengkap as nmatasan2,d.nohp1 as nohpatasan2,e.desc_barang as item1,e.keterangan as ketitem1,e.qtysppbminta as qty from sc_trx.sppb_mst a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	left outer join sc_mst.karyawan d on d.nik=b.nik_atasan2 
	left outer join sc_trx.sppb_dtl e on a.nik=e.nik and a.nodok=e.nodok and e.id=1
where a.nodok=new.nodok and a.nik=new.nik
) as x ) as y;
		
			update sc_trx.sppb_mst set status='A' where nodok=new.nodok and status='R';

		ELSEIF (new.status='C1' and old.status='A') THEN
		/* BATAL VIA MOBILE */
			update sc_trx.sppb_mst set status='C' where nodok=new.nodok and status='C1';
			update sc_trx.sppb_dtl set status='C' where nodok=new.nodok ;
			
		END IF; 
		RETURN NEW;
	ELSEIF tg_op = 'DELETE' THEN

		RETURN old;	
	END IF;
	
END;
$function$
;
