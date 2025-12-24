-- DROP FUNCTION sc_mst.pr_beri_nomor_after();

CREATE OR REPLACE FUNCTION sc_mst.pr_beri_nomor_after()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
DECLARE
	vr_urut numeric(15) :=0;
	vr_xno numeric(15) :=0;
	vr_nomor char(30) :='';
BEGIN
	vr_urut:= coalesce(docno,0) from sc_mst.nomor where dokumen=trim(new.dokumen) and part=trim(new.partid) for update;


	IF new.counterid>1 THEN
		vr_xno:=vr_urut+1;
	ELSE
		vr_xno:=vr_urut+new.counterid;
	END IF;

	vr_nomor:=trim(coalesce(prefix,''))||repeat('0',cast(coalesce(count3,0)-length(trim(cast(coalesce(vr_xno,0) as char(20)))) as integer))||trim(cast(coalesce(vr_xno,0) as char(20)))||trim(coalesce(sufix,''))
	from sc_mst.nomor where dokumen=trim(new.dokumen) and part=trim(new.partid) for update;

	update sc_mst.penomoran set nomor=vr_nomor where userid=trim(new.userid) and dokumen=trim(new.dokumen) and partid=trim(new.partid);

	update sc_mst.nomor set docno=docno+new.counterid where dokumen=trim(new.dokumen) and part=trim(new.partid);

	RETURN new;
END;
$function$
;