<?php
class M_bpjs extends CI_Model{
	
	function q_listhpkaryawan(){
		return $this->db->query("select nik,replace(trim(nohp1),'08','+62') as hpya from sc_mst.karyawan where statuskepegawaian<>'KO' order by nik");
	}
	
	function q_list_sms($tgl){
		$q='select * from 
							(select "ID" as id,"SenderNumber" as no_pengirim,
							case 
							when trim(both '."'_'".' from "SenderNumber") in (select trim(both '."'_'".' from nohp1) from sc_mst.karyawan)then b.nmlengkap 
							end
							as nama,
							case
							when trim(both '."'_'".' from "SenderNumber") in (select trim(both '."'_'".' from nohp1) from sc_mst.karyawan)then '."'INTERN'".'
							else '."'UNKNOWN'".'
							end
							as ket,
							"TextDecoded" as isi_sms, to_char("ReceivingDateTime",'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_masuk
							from inbox a 
							left outer join sc_mst.karyawan b on trim(both '."'_'".' from a."SenderNumber")=trim(both '."'_'".' from b.nohp1)	
							where to_char("ReceivingDateTime",'."'mmYYYY'".')='."'$tgl'".' 
							order by "ReceivingDateTime" desc) as t1 
						where ket='."'INTERN'".'';
		return $this->db->query($q);
	}
	
	function q_list_outbox($tgl){
		$q='select * from 
		(select distinct "ID" as id, "DestinationNumber" as no_penerima,case
		when "DestinationNumber" in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when "DestinationNumber" in (select  nohp1 from sc_mst.karyawan)then b.nmlengkap 
			end
			as nama,
		case
		when "DestinationNumber" in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when "DestinationNumber" in (select  nohp1 from sc_mst.karyawan)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		case 
		when left("TextDecoded",4)='."'Disb'".' then '."'POIN'".'
		else
		"TextDecoded"
		end as isi_sms, 
		case
		when "Status"='."'SendingError'".' then '."'Pesan Gagal'".'
		when "Status"='."'SendingOKNoReport'".' then '."'Pesan Terkirim'".' 
		else '."'UNKNOWN REPORT'".'
		end as status,
		to_char("SendingDateTime",'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from public.sentitems a
		left outer join sc_mst.karyawan b on  a."DestinationNumber" = b.nohp1
		left outer join sc_mst.outlet c on a."DestinationNumber"=c.ownhp 
		where to_char("SendingDateTime",'."'mmYYYY'".')='."'$tgl'".' 
		order by "ID" desc)
		as t1
		where ket='."'INTERN'".' and isi_sms<>'."'POIN'".'';
		return $this->db->query($q);
		
		
		
	}

	function q_list_trash_inbox($tgl){
		$q='select * from
			(select id,no_pengirim,
			case 
			when no_pengirim in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			 where ownhp <>'."'+62'".')
			then c.outletname
			when no_pengirim in (select nohp1 from sc_mst.karyawan)then b.nmlengkap 
			end
			as nama,
			case
			when no_pengirim in (select distinct * from 
						(select ownhp from sc_mst.outlet 
						where ownhp <>'."'1'".')as t1
						 where ownhp <>'."'+62'".')
			then '."'OUTLET'".'
			when no_pengirim in (select nohp1 from sc_mst.karyawan)then '."'INTERN'".'
			else '."'UNKNOWN'".'
			end
			as ket,
			isi_sms, to_char(tanggal_masuk,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_masuk
			from sc_log.trash_sms a 
			left outer join sc_mst.karyawan b on a.no_pengirim=b.nohp1
			left outer join sc_mst.outlet c on a.no_pengirim=c.ownhp 
			where to_char(tanggal_masuk,'."'mmYYYY'".')='."'$tgl'".'
			order by tanggal_masuk desc) as t1
			where ket='."'INTERN'".''; 

		return $this->db->query($q);
	}
	
	function q_list_trash_outbox($tgl){
		$q='select * from
		(select id, no_penerima,case
		when no_penerima in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when no_penerima in (select nohp1 from sc_mst.karyawan)then b.nmlengkap 
			end
			as nama,
		case
		when no_penerima in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when no_penerima in (select nohp1 from sc_mst.karyawan)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		isi_sms,
		to_char(tanggal_kirim,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from sc_log.trash_outbox a
		left outer join sc_mst.karyawan b on a.no_penerima=b.nohp1
		left outer join sc_mst.outlet c on a.no_penerima=c.ownhp 
		where to_char(tanggal_kirim,'."'mmYYYY'".')='."'$tgl'".' 
		order by tanggal_kirim desc)as t1
		where ket='."'INTERN'".'';
		return $this->db->query($q);
	}
	
	
	function q_filter_inbox($tgl){
		$q='select * from (select "ID" as id, "SenderNumber" as no_pengirim, 
									case 
									when "SenderNumber" in (select distinct * from 
												(select ownhp from sc_mst.outlet 
												where ownhp <>'."'1'".')as t1
												 where ownhp <>'."'+62'".')
									then c.outletname
									when "SenderNumber" in (select nohp1 from sc_mst.karyawan)then b.nmlengkap
									else '."'No Name'".'								
									end
									as nama,
									case
									when "SenderNumber" in (select distinct * from 
												(select ownhp from sc_mst.outlet 
												where ownhp <>'."'1'".')as t1
												 where ownhp <>'."'+62'".')
									then '."'OUTLET'".'
									when "SenderNumber" in (select nohp1 from sc_mst.karyawan)then '."'INTERN'".'
									else '."'UNKNOWN'".'
									end
									as ket,
									"TextDecoded" as isi_sms, to_char("ReceivingDateTime",'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_masuk
									from inbox a 
									left outer join sc_mst.karyawan b on a."SenderNumber"=b.nohp1
									left outer join sc_mst.outlet c on a."SenderNumber"=c.ownhp 
		where to_char("ReceivingDateTime",'."'mmYYYY'".'='."'$tgl'".'
		order by "ReceivingDateTime" desc) as t1
		where ket='."'INTERN'".'';
		return $this->db->query($q);
	}
	
	function q_filter_outbox($awal1,$akhir1){
		$q='select * from 
		(select "ID" as id, "DestinationNumber" as no_penerima,case
		when "DestinationNumber" in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when "DestinationNumber" in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
		case
		when "DestinationNumber" in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when "DestinationNumber" in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		"TextDecoded" as isi_sms,
		case
		when "Status"='."'SendingError'".' then '."'Pesan Gagal'".'
		when "Status"='."'SendingOKNoReport'".' then '."'Pesan Terkirim'".' 
		else '."'UNKNOWN REPORT'".'
		end as status,
		to_char("SendingDateTime",'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from public.sentitems a
		left outer join sc_hrd.pegawai b on a."DestinationNumber"=b.telepon
		left outer join sc_mst.outlet c on a."DestinationNumber"=c.ownhp 
		where "SendingDateTime" between '."'$awal1'".' and '."'$akhir1'".' 
		order by "SendingDateTime" desc) as t1
		where ket='."'INTERN'".'';
		return $this->db->query($q);
	
	}
	
	function q_filter_list_trash_inbox($awal,$akhir){
		$q='select id,no_pengirim,
			case 
			when no_pengirim in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when no_pengirim in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
			case
			when no_pengirim in (select distinct * from 
						(select ownhp from sc_mst.outlet 
						where ownhp <>'."'1'".')as t1
						 where ownhp <>'."'+62'".')
			then '."'OUTLET'".'
			when no_pengirim in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
			else '."'UNKNOWN'".'
			end
			as ket,
			isi_sms, to_char(tanggal_masuk,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_masuk
			from sc_log.trash_sms a 
			left outer join sc_hrd.pegawai b on a.no_pengirim=b.telepon
			left outer join sc_mst.outlet c on a.no_pengirim=c.ownhp 
			where tanggal_masuk between '."'$awal'".' and '."'$akhir'".'
			order by tanggal_masuk desc'; 

		return $this->db->query($q);
	}
	
	function q_filter_list_trash_outbox($awal,$akhir){
		$q='select id, no_penerima,case
		when no_penerima in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when no_penerima in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
		case
		when no_penerima in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when no_penerima in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		isi_sms,
		to_char(tanggal_kirim,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from sc_log.trash_outbox a
		left outer join sc_hrd.pegawai b on a.no_penerima=b.telepon
		left outer join sc_mst.outlet c on a.no_penerima=c.ownhp 
		where tanggal_kirim between '."'$awal'".' and '."'$akhir'".' 
		order by tanggal_kirim desc';
		return $this->db->query($q);
	
	}
	
	function q_smskontrakpeg(){
		return $this->db->query('insert into outbox ("DestinationNumber","TextDecoded","CreatorID")'.
										"select telepon,left(isi_sms,160),'SISTEM' from (
								select telepon,'Kontrak '||desc_kontrak||' Anda berakhir tgl '||to_char(tglrem,'dd-mm-yyyy') as isi_sms from (
									select t1.*,t2.*,t3.nmlengkap,t3.telepon,t4.desc_kontrak from
									(select case
										when left(kodeopt,4)='REMB' then date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 	
										else date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 
										end as tglrem,* from sc_hrd.option
									where group_option='REMINDER') as t1
									left outer join (select * from sc_hrd.kontrak where kdkontrak<>'AD') as t2 on t2.tanggal2=t1.tglrem
									left outer join sc_hrd.pegawai t3 on t3.nip=t2.nip
									left outer join sc_hrd.ketkontrak t4 on t4.kdkontrak=t2.kdkontrak
									where t2.branch is not null
									) as x1) as x2");		
	}
	
	
	function q_smskontrakhrd(){
		return $this->db->query('insert into outbox ("DestinationNumber","TextDecoded","CreatorID")'.
										"select telepon,left(isi_sms,160),'SISTEM' from (
								select telepon,'Kontrak '||desc_kontrak||' '||nmlengkap||' berakhir tgl '||to_char(tglrem,'dd-mm-yyyy') as isi_sms from (
										select * from (select * from sc_hrd.notif_sms where dll='Y') as x1
										left outer join 
										(select t1.*,t2.*,t3.nmlengkap,t3.telepon as telppeg,t4.desc_kontrak from
											(select case
												when left(kodeopt,4)='REMB' then date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 	
												else date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 
												end as tglrem,* from sc_hrd.option
												where group_option='REMINDER') as t1
												left outer join (select * from sc_hrd.kontrak where kdkontrak<>'AD') as t2 on t2.tanggal2=t1.tglrem
												left outer join sc_hrd.pegawai t3 on t3.nip=t2.nip
												left outer join sc_hrd.ketkontrak t4 on t4.kdkontrak=t2.kdkontrak
												where t2.branch is not null
											) as x2 on x1 is not null
									) as y1) as y2");
	}	
	

	
	/*
	function q_list_outbox($tgl){
		$q='select * from 
		(select distinct "ID" as id, "DestinationNumber" as no_penerima,case
		when "DestinationNumber" in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when "DestinationNumber" in (select  telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
		case
		when "DestinationNumber" in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when "DestinationNumber" in (select  telepon from sc_hrd.pegawai)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		case 
		when left("TextDecoded",4)='."'Disb'".' then '."'POIN'".'
		else
		"TextDecoded"
		end as isi_sms, 
		case
		when "Status"='."'SendingError'".' then '."'Pesan Gagal'".'
		when "Status"='."'SendingOKNoReport'".' then '."'Pesan Terkirim'".' 
		else '."'UNKNOWN REPORT'".'
		end as status,
		to_char("SendingDateTime",'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from public.sentitems a
		left outer join sc_hrd.pegawai b on  a."DestinationNumber" = b.telepon
		left outer join sc_mst.outlet c on a."DestinationNumber"=c.ownhp 
		where to_char("SendingDateTime",'."'mmYYYY'".')='."'$tgl'".' 
		order by "ID" desc)
		as t1
		where ket='."'INTERN'".' and isi_sms<>'."'POIN'".'';
		return $this->db->query($q);
		
		
		
	}

	function q_list_trash_inbox($tgl){
		$q='select * from
			(select id,no_pengirim,
			case 
			when no_pengirim in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			 where ownhp <>'."'+62'".')
			then c.outletname
			when no_pengirim in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
			case
			when no_pengirim in (select distinct * from 
						(select ownhp from sc_mst.outlet 
						where ownhp <>'."'1'".')as t1
						 where ownhp <>'."'+62'".')
			then '."'OUTLET'".'
			when no_pengirim in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
			else '."'UNKNOWN'".'
			end
			as ket,
			isi_sms, to_char(tanggal_masuk,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_masuk
			from sc_log.trash_sms a 
			left outer join sc_hrd.pegawai b on a.no_pengirim=b.telepon
			left outer join sc_mst.outlet c on a.no_pengirim=c.ownhp 
			where to_char(tanggal_masuk,'."'mmYYYY'".')='."'$tgl'".'
			order by tanggal_masuk desc) as t1
			where ket='."'INTERN'".''; 

		return $this->db->query($q);
	}
	
	function q_list_trash_outbox($tgl){
		$q='select * from
		(select id, no_penerima,case
		when no_penerima in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when no_penerima in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
		case
		when no_penerima in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when no_penerima in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		isi_sms,
		to_char(tanggal_kirim,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from sc_log.trash_outbox a
		left outer join sc_hrd.pegawai b on a.no_penerima=b.telepon
		left outer join sc_mst.outlet c on a.no_penerima=c.ownhp 
		where to_char(tanggal_kirim,'."'mmYYYY'".')='."'$tgl'".' 
		order by tanggal_kirim desc)as t1
		where ket='."'INTERN'".'';
		return $this->db->query($q);
	}
	
	
	function q_filter_inbox($tgl){
		$q='select * from (select "ID" as id, "SenderNumber" as no_pengirim, 
									case 
									when "SenderNumber" in (select distinct * from 
												(select ownhp from sc_mst.outlet 
												where ownhp <>'."'1'".')as t1
												 where ownhp <>'."'+62'".')
									then c.outletname
									when "SenderNumber" in (select telepon from sc_hrd.pegawai)then b.nmlengkap
									else '."'No Name'".'								
									end
									as nama,
									case
									when "SenderNumber" in (select distinct * from 
												(select ownhp from sc_mst.outlet 
												where ownhp <>'."'1'".')as t1
												 where ownhp <>'."'+62'".')
									then '."'OUTLET'".'
									when "SenderNumber" in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
									else '."'UNKNOWN'".'
									end
									as ket,
									"TextDecoded" as isi_sms, to_char("ReceivingDateTime",'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_masuk
									from inbox a 
									left outer join sc_hrd.pegawai b on a."SenderNumber"=b.telepon
									left outer join sc_mst.outlet c on a."SenderNumber"=c.ownhp 
		where to_char("ReceivingDateTime",'."'mmYYYY'".'='."'$tgl'".'
		order by "ReceivingDateTime" desc) as t1
		where ket='."'INTERN'".'';
		return $this->db->query($q);
	}
	
	function q_filter_outbox($awal1,$akhir1){
		$q='select * from 
		(select "ID" as id, "DestinationNumber" as no_penerima,case
		when "DestinationNumber" in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when "DestinationNumber" in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
		case
		when "DestinationNumber" in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when "DestinationNumber" in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		"TextDecoded" as isi_sms,
		case
		when "Status"='."'SendingError'".' then '."'Pesan Gagal'".'
		when "Status"='."'SendingOKNoReport'".' then '."'Pesan Terkirim'".' 
		else '."'UNKNOWN REPORT'".'
		end as status,
		to_char("SendingDateTime",'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from public.sentitems a
		left outer join sc_hrd.pegawai b on a."DestinationNumber"=b.telepon
		left outer join sc_mst.outlet c on a."DestinationNumber"=c.ownhp 
		where "SendingDateTime" between '."'$awal1'".' and '."'$akhir1'".' 
		order by "SendingDateTime" desc) as t1
		where ket='."'INTERN'".'';
		return $this->db->query($q);
	
	}
	function q_filter_list_trash_inbox($awal,$akhir){
		$q='select id,no_pengirim,
			case 
			when no_pengirim in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when no_pengirim in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
			case
			when no_pengirim in (select distinct * from 
						(select ownhp from sc_mst.outlet 
						where ownhp <>'."'1'".')as t1
						 where ownhp <>'."'+62'".')
			then '."'OUTLET'".'
			when no_pengirim in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
			else '."'UNKNOWN'".'
			end
			as ket,
			isi_sms, to_char(tanggal_masuk,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_masuk
			from sc_log.trash_sms a 
			left outer join sc_hrd.pegawai b on a.no_pengirim=b.telepon
			left outer join sc_mst.outlet c on a.no_pengirim=c.ownhp 
			where tanggal_masuk between '."'$awal'".' and '."'$akhir'".'
			order by tanggal_masuk desc'; 

		return $this->db->query($q);
	}
	function q_filter_list_trash_outbox($awal,$akhir){
		$q='select id, no_penerima,case
		when no_penerima in (select distinct * from 
			(select ownhp from sc_mst.outlet 
			where ownhp <>'."'1'".')as t1
			where ownhp <>'."'+62'".')
			then c.outletname
			when no_penerima in (select telepon from sc_hrd.pegawai)then b.nmlengkap 
			end
			as nama,
		case
		when no_penerima in (select distinct * from 
					(select ownhp from sc_mst.outlet 
					where ownhp <>'."'1'".')as t1
					 where ownhp <>'."'+62'".')
		then '."'OUTLET'".'
		when no_penerima in (select telepon from sc_hrd.pegawai)then '."'INTERN'".'
		else '."'UNKNOWN'".'
		end
		as ket,
		isi_sms,
		to_char(tanggal_kirim,'."'DD-MM-YYYY HH24:MI:SS'".')as tanggal_kirim
		from sc_log.trash_outbox a
		left outer join sc_hrd.pegawai b on a.no_penerima=b.telepon
		left outer join sc_mst.outlet c on a.no_penerima=c.ownhp 
		where tanggal_kirim between '."'$awal'".' and '."'$akhir'".' 
		order by tanggal_kirim desc';
		return $this->db->query($q);
	
	}
	
	function q_smskontrakpeg(){
		return $this->db->query('insert into outbox ("DestinationNumber","TextDecoded","CreatorID")'.
										"select telepon,left(isi_sms,160),'SISTEM' from (
								select telepon,'Kontrak '||desc_kontrak||' Anda berakhir tgl '||to_char(tglrem,'dd-mm-yyyy') as isi_sms from (
									select t1.*,t2.*,t3.nmlengkap,t3.telepon,t4.desc_kontrak from
									(select case
										when left(kodeopt,4)='REMB' then date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 	
										else date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 
										end as tglrem,* from sc_hrd.option
									where group_option='REMINDER') as t1
									left outer join (select * from sc_hrd.kontrak where kdkontrak<>'AD') as t2 on t2.tanggal2=t1.tglrem
									left outer join sc_hrd.pegawai t3 on t3.nip=t2.nip
									left outer join sc_hrd.ketkontrak t4 on t4.kdkontrak=t2.kdkontrak
									where t2.branch is not null
									) as x1) as x2");		
	}
	function q_smskontrakhrd(){
		return $this->db->query('insert into outbox ("DestinationNumber","TextDecoded","CreatorID")'.
										"select telepon,left(isi_sms,160),'SISTEM' from (
								select telepon,'Kontrak '||desc_kontrak||' '||nmlengkap||' berakhir tgl '||to_char(tglrem,'dd-mm-yyyy') as isi_sms from (
										select * from (select * from sc_hrd.notif_sms where dll='Y') as x1
										left outer join 
										(select t1.*,t2.*,t3.nmlengkap,t3.telepon as telppeg,t4.desc_kontrak from
											(select case
												when left(kodeopt,4)='REMB' then date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 	
												else date(to_char(now(),'yyyymmdd'))+cast(value4 as integer) 
												end as tglrem,* from sc_hrd.option
												where group_option='REMINDER') as t1
												left outer join (select * from sc_hrd.kontrak where kdkontrak<>'AD') as t2 on t2.tanggal2=t1.tglrem
												left outer join sc_hrd.pegawai t3 on t3.nip=t2.nip
												left outer join sc_hrd.ketkontrak t4 on t4.kdkontrak=t2.kdkontrak
												where t2.branch is not null
											) as x2 on x1 is not null
									) as y1) as y2");
	}
	*/
}	