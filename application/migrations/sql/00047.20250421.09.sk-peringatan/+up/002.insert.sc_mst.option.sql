INSERT INTO sc_mst."option" (
    kdoption, nmoption, value1, value2, value3, status, keterangan,
    input_by, update_by, input_date, update_date, group_option
) VALUES
    ('A:R:S:P', 'APPROVAL RULE SURAT PERINGATAN', 'I,AL,ALP,A,AP,B,BP,P', NULL, NULL, 'T',
     'Urutan approval surat peringatan eksternal', 'RKM', 'RKM', '2024-08-20 08:16:04.199', '2024-09-10 16:46:43.026', 'SURAT PERINGATAN'),
    ('U:L:S:P', 'USER LEGAL SURAT PERINGATAN', '23055', NULL, NULL, 'T',
     'User legal surat peringatan', 'RKM', 'RKM', '2024-08-20 08:16:04.199', '2024-09-10 16:46:43.026', 'SURAT PERINGATAN')
ON CONFLICT (kdoption) DO NOTHING;

INSERT INTO sc_mst."option" (
    kdoption, nmoption, value1, value2, value3, status, keterangan,
    input_by, update_by, input_date, update_date, group_option
) VALUES
    ('WA-SEND-APBA:MJKCNI', 'SEND APPROVAL BERITA ACARA', 'T', NULL, NULL, 'T',
     'KIRIM WA APPROVAL CNI', 'DK', NULL, '2024-01-31 21:37:38.636', '2024-01-31 21:37:38.636', 'WA'),
    ('WA-SEND-APSP:MJKCNI', 'SEND APPROVAL SURAT PERINGATAN', 'T', NULL, NULL, 'T',
     'KIRIM WA APPROVAL CNI', 'DK', NULL, '2024-01-31 21:37:38.636', '2024-01-31 21:37:38.636', 'WA')
ON CONFLICT (kdoption) DO NOTHING;

