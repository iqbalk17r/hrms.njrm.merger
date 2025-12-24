DELETE FROM sc_mst.option where kdoption IN ('V:U:L','V:WA:1','V:WA:2','V:WA:3','V:P:1','V:WEB:1','V:IG:1','V:M:1');
INSERT INTO sc_mst."option" (
    kdoption, nmoption, value1, value2, value3, status, keterangan,input_by, update_by, input_date, update_date, group_option
) VALUES
    ('V:U:L', 'Vcard Using Logo', 'YES', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD'),
    ('V:WA:1', 'Vcard Whatsapp 1', '0813-4808-7991', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD'),
    ('V:WA:2', 'Vcard Whatsapp 2', '0812-5152-6284', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD'),
    ('V:WA:3', 'Vcard Whatsapp 3', '0812-5152-6026', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD'),
    ('V:P:1', 'Vcard Phone 1', '0511-3266789', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD'),
    ('V:WEB:1', 'Vcard Web 1', 'nusantarajaya.co.id', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD'),
    ('V:IG:1', 'Vcard Instagram 1', 'nusantara_jaya.id', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD'),
    ('V:M:1', 'Vcard Mail 1', 'nusa.njrmbjm@nusantarajaya.co.id', NULL, NULL, 'T','Contact number vcard', 'SYSTEM', NULL, '2025-09-10 00:00:06', null, 'VCARD')
ON CONFLICT (kdoption,group_option) DO NOTHING;



