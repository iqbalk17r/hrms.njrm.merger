INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, NULL, 'I.Z', 'PENJADWALAN', '0', '0', 'U', false, 'fa-calendar', '#', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, NULL, 'I.Z.A', 'AGENDA', 'I.Z', '0', 'S', false, 'fa-users', '#', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, NULL, 'I.Z.A.1', 'KONSELING', 'I.Z', 'I.Z.A', 'P', false, 'fa-comments', 'agenda/counseling', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, NULL, 'I.Z.A.2', 'ACARA', 'I.Z', 'I.Z.A', 'P', false, 'fa-certificate', 'agenda/event', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, NULL, 'I.Z.B', 'MASTER', 'I.Z', '0', 'S', false, 'fa-folder', '#', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, NULL, 'I.Z.B.1', 'RUANGAN', 'I.Z', 'I.Z.B', 'P', false, 'fa-bars', 'agenda/room', NULL);