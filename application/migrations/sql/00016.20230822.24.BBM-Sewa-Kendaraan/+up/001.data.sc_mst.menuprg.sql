INSERT INTO sc_mst.menuprg
    (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
    ('SBYNSA', 4, 'I.T.B.30  ', 'TARIK BBM', 'I.A', 'I.A.A', 'P', false, 'fa-car', '/trans/bbm', null),
    ('SBYNSA', 5, 'I.T.B.31  ', 'SEWA KENDARAAN', 'I.A', 'I.A.A', 'P', false, 'fa-car', '/trans/sewakendaraan', null)
ON CONFLICT (kodemenu)
DO NOTHING;
