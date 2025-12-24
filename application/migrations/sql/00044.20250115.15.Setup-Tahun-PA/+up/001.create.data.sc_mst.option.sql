INSERT INTO sc_mst."option" (kdoption,nmoption,value1,value2,value3,status,keterangan,input_by,update_by,input_date,update_date,group_option) VALUES
	 ('PKPAPY','SETUP TAHUN PERIOD','',NULL,1,'T','SETUP TAHUN PERIODE(TAHUN SEKARANG dikurangi value 3)','MIGRATION',NULL,now(),NULL,'PKPA')
ON CONFLICT DO NOTHING;
