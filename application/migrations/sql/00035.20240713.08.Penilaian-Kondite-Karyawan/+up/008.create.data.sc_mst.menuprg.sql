INSERT INTO sc_mst.menuprg
    (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
	('SBYNSA',3,'I.F.D','KONDITE KARYAWAN','I.F','false','S',false,'fa fa-folder','#',NULL),
	('SBYNSA',1,'I.F.D.1','FORM -KONDITE','I.F','I.F.D','P',false,'fa fa-folder','/pk/form_kondite',NULL),
	('SBYNSA',2,'I.F.D.2','REPORT KONDITE','I.F','I.F.D','P',false,'fa fa-folder','/pk/report_kondite',NULL)
ON CONFLICT
    DO NOTHING ;