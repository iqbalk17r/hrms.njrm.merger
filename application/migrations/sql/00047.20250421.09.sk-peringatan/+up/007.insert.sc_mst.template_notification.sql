INSERT INTO sc_mst.template_notification (template_notification_content,template_notification_type,template_notification_modul,template_notification_procedure,template_notification_level,properties,"parameter") VALUES
	 ('🚨 Peringatan! 

🔊 #levelstep .
Dokumen *Berita Acara* dengan nomor 👉 #docno 👈
membutuhkan persetujuan anda, persetujuan dapat dilakukan pada Sistem HRMS.

Terima kasih.
HRMS','whatsapp','berita_acara',NULL,NULL,'{"#docno": "select trim(docno) as docno from sc_trx.v_berita_acara_approval where docno=''??'' ", "#levelstep": "select trim(description) as levelstep from sc_trx.v_berita_acara_approval where docno=''??''"}','{}');

INSERT INTO sc_mst.template_notification (template_notification_content,template_notification_type,template_notification_modul,template_notification_procedure,template_notification_level,properties,"parameter") VALUES
	 ('🚨 Peringatan! 

🔊 #levelstep .
Dokumen *Surat Peringatan* dengan nomor 👉 #docno 👈
membutuhkan persetujuan anda, persetujuan dapat dilakukan pada Sistem HRMS.

Terima kasih.
HRMS','whatsapp','sk_peringatan',NULL,NULL,'{"#docno": "select trim(docno) as docno from sc_trx.v_surat_peringatan_approval where docno=''??'' ", "#levelstep": "select trim(description) as levelstep from sc_trx.v_surat_peringatan_approval where docno=''??''"}','{}');
