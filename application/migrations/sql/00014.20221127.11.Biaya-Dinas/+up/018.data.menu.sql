INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
    (null, 10, 'I.T.B.26', 'DEKLARASI KASBON DINAS ', 'I.A', 'I.A.A', 'P', false, 'fa-money  ', '/trans/declarationcashbon', null),
    (null, 9, 'I.T.B.18', 'KASBON DINAS ', 'I.A', 'I.A.A', 'P', false, 'fa-money  ', '/trans/cashbon', null),
    (null, 0, 'I.A.A.0', 'TARIKAN FINGER', 'I.A', 'I.A.A', 'P', false, 'fa-bars  ', '/trans/finger', null)
ON CONFLICT ( kodemenu )
    DO NOTHING;
