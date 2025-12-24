INSERT INTO sc_mst.menuprg
    (branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES
    ('SBYNSA', 66, 'I.G.J', 'CHECKLIST', 'I.G', '0', 'S', false, 'fa-plus', '#', ''),
    ('SBYNSA', 1, 'I.G.J.1', 'MASTER PERIODE', 'I.G', 'I.G.J', 'P', false, 'fa-folder', 'ga/checklistmaster/periode', ''),
    ('SBYNSA', 2, 'I.G.J.2', 'MASTER LOKASI', 'I.G', 'I.G.J', 'P', false, 'fa-folder', 'ga/checklistmaster/lokasi', ''),
    ('SBYNSA', 3, 'I.G.J.3', 'MASTER PARAMETER', 'I.G', 'I.G.J', 'P', false, 'fa-folder', 'ga/checklistmaster/parameter', ''),
    ('SBYNSA', 4, 'I.G.J.4', 'JADWAL CHECKLIST', 'I.G', 'I.G.J', 'P', false, 'fa-folder', 'ga/checklist/jadwal', ''),
    ('SBYNSA', 5, 'I.G.J.5', 'REALISASI CHECKLIST', 'I.G', 'I.G.J', 'P', false, 'fa-folder', 'ga/checklist/realisasi', '')
ON CONFLICT (kodemenu)
DO UPDATE SET
    (branch, urut, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition) =
    (EXCLUDED.branch, EXCLUDED.urut, EXCLUDED.namamenu, EXCLUDED.parentmenu, EXCLUDED.parentsub, EXCLUDED.child, EXCLUDED.holdmenu, EXCLUDED.iconmenu, EXCLUDED.linkmenu, EXCLUDED.menuposition)
