INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 2, 'T.S.A.2', 'MASTER DOCUMENT', 'T.S', 'T.S.A', 'P', false, 'fa fa-folder', '/admin/dokumen', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 3, 'T.S.A.3', 'PENGAJUAN PPD', 'T.S', 'T.S.A', 'P', false, 'fa fa-envelope', '/user/wo', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 4, 'T.S.A.4', 'MAPPED DOCUMENT', 'T.S', 'T.S.A', 'P', false, 'fa fa-folder', '/user/dokumen', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 1, 'T.S.A.1', 'DASHBOARD', 'T.S', 'T.S.A', 'P', false, 'fa fa-tachometer', '/admin', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 5, 'T.S.A.5', 'DAFTAR OTORISASI', 'T.S', 'T.S.A', 'P', false, 'fa fa-lock', '/otorisasi', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 6, 'T.S.A.6', 'MASTER IM', 'T.S', 'T.S.A', 'P', false, 'fa fa-file-pdf-o', '/user/im', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 7, 'T.S.A.7', 'FILE GAMBAR', 'T.S', 'T.S.A', 'P', false, 'fa fa-file-image-o', '/user/gambar', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 8, 'T.S.A.8', 'FILE VIDEO', 'T.S', 'T.S.A', 'P', false, 'fa fa-file-video-o', '/user/video', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 1, 'T.S.A', 'DOKUMEN', 'T.S', 'false', 'S', false, 'fa-share', '#', NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL, 11, 'T.S', 'DCMS', 'false', 'false', 'U', false, 'fa fa-tv', '#', NULL);


INSERT INTO sc_mst.menuprg 
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) 
VALUES(NULL, 4, 'I.F.E', 'KONTRAK KARYAWAN', 'I.F', 'false', 'S', false, 'fa fa-check-square-o', '#', NULL);
INSERT INTO sc_mst.menuprg 
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) 
VALUES(NULL, 2, 'I.F.E.1', 'APPROVAL ATASAN', 'I.F', 'I.F.E', 'P', false, 'fas fa-thumbs-up', 'pk/list_pk', NULL);
INSERT INTO sc_mst.menuprg 
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) 
VALUES(NULL, 1, 'I.F.E.2', 'PENILAIAN KARYAWAN', 'I.F', 'I.F.E', 'P', false, 'fa-star', 'pk/list_pkpen', NULL);

--============================ Menu Reminder ==========================
INSERT INTO sc_mst.menuprg (
    branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition
) VALUES (
    NULL, 3, 'I.L.R', 'REMINDER', 'I.L', 'false', 'S', false, 'fa fa-bell', '#', NULL
);

INSERT INTO sc_mst.menuprg (
    branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition
) VALUES (
    NULL, 1, 'I.L.R.1', 'REMINDER', 'I.L', 'I.L.R', 'P', false, 'fa fa-pie-chart', '/reminder/reminder', NULL
);

--berita acara & surat peringatan

INSERT INTO sc_mst.menuprg (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) VALUES('', 1, 'I.T.C.1', 'BERITA ACARA', 'I.T', 'I.T.C', 'P', false, 'fa-calendar-o', '/trans/sberitaacara', 'LEFT  ');
INSERT INTO sc_mst.menuprg (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) VALUES('', 6, 'I.T.C.7', 'TRACKING DOKUMEN', 'I.T', 'I.T.C', 'P', false, 'fa-bars', '/trans/tracking', 'LEFT  ');
INSERT INTO sc_mst.menuprg (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) VALUES('', 2, 'I.T.C.2 ', 'SURAT PERINGATAN', 'I.T', 'I.T.C', 'P', false, 'fa-bars', '/trans/skperingatan', 'LEFT  ');
INSERT INTO sc_mst.menuprg (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) VALUES('', 3, 'I.T.C', 'DOKUMEN & UMUM', 'I.T', '0', 'S', false, 'fa-calendar-o', '#', 'LEFT  ');