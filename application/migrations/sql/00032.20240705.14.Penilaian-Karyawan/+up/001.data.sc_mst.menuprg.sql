INSERT INTO sc_mst.menuprg
    (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
	('SBYNSA',5,'I.F','PENILAIAN KARYAWAN','','false','U',false,'fa-folder','#',NULL),
	('SBYNSA',2,'I.F.B','PERFORMA APPRAISAL','I.F','false','S',false,'fa fa-folder','#',NULL),
	('SBYNSA',1,'I.F.A.1','FORM PA','I.F','I.F.B','P',false,'fa fa-folder','/pk/form_pk',NULL),
	('SBYNSA',2,'I.F.A.2','PA REPORT','I.F','I.F.B','P',false,'fa fa-folder','pk/pk/form_report_pa',NULL)
ON CONFLICT
    DO NOTHING ;

