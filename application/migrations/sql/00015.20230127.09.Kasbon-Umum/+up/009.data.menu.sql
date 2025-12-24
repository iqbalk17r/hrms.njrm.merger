INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
    (null, 1, 'I.K.A', 'KASBON', 'I.K', 'false', 'S', false, 'fas fa-sign-out', '#', null),
    (null, 98, 'I.K', 'KASBON UMUM', 'false', 'false', 'U', false, 'fas fa-ticket', '#', null),
    (null, 1, 'I.K.A.1', 'KOMPONEN', 'I.K', 'I.K.A', 'P', false, 'fas fa-list', 'kasbon_umum/ComponentCashbon/index', null),
    (null, 2, 'I.K.B', 'DEKLARASI', 'I.K', 'false', 'S', false, 'fas fa-sign-in', '#', null),
    (null, 2, 'I.K.A.2', 'KASBON', 'I.K', 'I.K.A', 'P', false, 'fas fa-money', '/kasbon_umum/cashbon', null),
    (null, 1, 'I.K.B.1', 'DEKLARASI KASBON', 'I.K', 'I.K.B', 'P', false, 'fas fa-file', '/kasbon_umum/declarationcashbon', null),
    (null, 3, 'I.K.A.3', 'SALDO KASBON', 'I.K', 'I.K.A', 'P', false, 'fa-balance-scale', 'kasbon_umum/balancecashbon/index', null)
ON CONFLICT ( kodemenu )
    DO NOTHING;