INSERT INTO sc_mst.menuprg (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
    ('SBYNSA', 4, 'I.A.A.2   ', 'REKAPAN DTL UM', 'I.A', 'I.A.A', 'P', false, 'fa-calendar', '/trans/uang_makan/index_final_um', null)
ON CONFLICT (kodemenu)
DO UPDATE SET
    namamenu = excluded.namamenu,
    parentmenu = excluded.parentmenu,
    parentsub = excluded.parentsub,
    child = excluded.child,
    holdmenu = excluded.holdmenu,
    iconmenu = excluded.iconmenu,
    linkmenu = excluded.linkmenu,
    menuposition = excluded.menuposition;

