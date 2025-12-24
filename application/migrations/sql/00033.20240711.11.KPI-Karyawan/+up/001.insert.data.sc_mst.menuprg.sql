INSERT INTO sc_mst.menuprg
    (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
	('SBYNSA',1,'I.F.C.1','IMPORT KPI','I.F','I.F.C','P',false,'fa-folder','pk/pk/form_kpi',NULL),
	('SBYNSA',4,'I.F.C','KPI','I.F','false','S',false,'fa fa-folder','#',NULL),
	('SBYNSA',2,'I.F.C.2','REPORT KPI','I.F','I.F.C','P',false,'fa-folder','pk/pk/form_report_kpi',NULL),
	('SBYNSA',3,'I.F.C.3','REKAP KPI TAHUNAN','I.F','I.F.C','P',false,'fa-folder','pk/pk/form_report_kpi_yearly',NULL)
ON CONFLICT
    DO NOTHING ;