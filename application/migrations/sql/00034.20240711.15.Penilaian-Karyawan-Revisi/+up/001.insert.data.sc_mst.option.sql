INSERT INTO sc_mst."option" (kdoption,nmoption,value1,value2,value3,status,keterangan,input_by,update_by,input_date,update_date,group_option) VALUES
	 ('PKPARP','SETUP RANGE PERIOD','SEMESTER',NULL,NULL,'T','SETUP RENTANG PERIODE(SEMESTER/FREE di value1)','MIGRATION',NULL,now(),NULL,'PKPA')
ON CONFLICT
    DO NOTHING;