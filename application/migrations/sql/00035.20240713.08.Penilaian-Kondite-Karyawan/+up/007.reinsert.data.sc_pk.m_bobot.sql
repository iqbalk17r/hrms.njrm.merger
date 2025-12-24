DELETE FROM sc_pk.m_bobot WHERE kdcategory = 'KONDITE';
INSERT INTO sc_pk.m_bobot (branch,idbu,kdcategory,kdvalue,description,value1,value2,value3,value4,value5,cgroup,inputdate,inputby,updatedate,updateby,status,chold) VALUES
	 ('SBYNSA','AR','KONDITE','SK','SANGAT KURANG','21.5','','1','','','PA',now(),'MIGRATION',NULL,NULL,NULL,NULL),
	 ('SBYNSA','AR','KONDITE','K','KURANG','22.99','21.51','2','1.01','','PA',now(),'MIGRATION',NULL,NULL,NULL,NULL),
	 ('SBYNSA','AR','KONDITE','C','CUKUP','23.99','23','3','2.01','','PA',now(),'MIGRATION',NULL,NULL,NULL,NULL),
	 ('SBYNSA','AR','KONDITE','B','BAGUS','24.99','24','4','3.01','','PA',now(),'MIGRATION',NULL,NULL,NULL,NULL),
	 ('SBYNSA','AR','KONDITE','SB','SANGAT BAGUS','25','25','5 ','4.01','','PA',now(),'MIGRATION',NULL,NULL,NULL,NULL),
	 ('SBYNSA','AR','KONDITE','KUOTA','KUOTA','25','25',NULL,NULL,'','PA',now(),'MIGRATION',NULL,NULL,NULL,NULL)
ON CONFLICT
    DO NOTHING ;