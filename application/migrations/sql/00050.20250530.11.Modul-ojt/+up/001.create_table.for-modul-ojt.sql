begin transaction;

CREATE TABLE sc_pk.master_ojt
(
  kddok character varying(20) NOT NULL,
  kdcontract character(20) NOT NULL,
  nik character(12) NOT NULL,
  nik_panelist character(12) NOT NULL,
  notes text,
  inputdate timestamp without time zone,
  inputby character(12),
  updatedate timestamp without time zone,
  updateby character(25),
  approvedate timestamp without time zone,
  approveby character(25),
  cancelappr boolean DEFAULT false,
  canceldate timestamp without time zone,
  cancelby character(25),
  status character(12) DEFAULT 'N'::bpchar,
  CONSTRAINT master_ojt_pkey PRIMARY KEY (kddok)
);

CREATE TABLE sc_pk.detail_ojt
(
  detailid serial NOT NULL,
  kddok character(20) NOT NULL,
  kd_aspect character(10) NOT NULL,
  score text NOT NULL,
  assesor character(20),
  CONSTRAINT detail_ojt_pkey PRIMARY KEY (detailid)
);

CREATE TABLE sc_pk.rekap_ojt
(
  id serial NOT NULL,
  kddok character varying(50) NOT NULL,
  presentation_date date NOT NULL,
  knowledge text NOT NULL,
  skill text NOT NULL,
  attitude text NOT NULL,
  recommendation text NOT NULL,
  conclusion text NOT NULL,
  inputdate timestamp without time zone DEFAULT now(),
  updatedate timestamp without time zone,
  inputby character varying(20),
  updateby character varying(20),
  CONSTRAINT rekap_ojt_pkey PRIMARY KEY (id)
);

CREATE TABLE sc_pk.score_aspect_ojt
(
  kd_aspect character varying(10) NOT NULL,
  aspect_name character varying(10) NOT NULL,
  aspect_desc text NOT NULL,
  "position" integer NOT NULL,
  active boolean DEFAULT true,
  kd_aspect_parent character varying(10),
  CONSTRAINT score_aspect_ojt_pkey PRIMARY KEY (kd_aspect)
);

CREATE TABLE sc_pk.score_aspect_parent_ojt
(
  kd_aspect character varying(10) NOT NULL,
  aspect_question text NOT NULL,
  "position" integer NOT NULL,
  active boolean DEFAULT true,
  type boolean DEFAULT true,
  CONSTRAINT score_aspect_parent_ojt_pkey PRIMARY KEY (kd_aspect)
);

INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M001', 'Baik', 'Mampu menyampaikan atau menjelaskan alur proses kerja pada jabatan dan bagiannya dengan baik dan 
jelas. Serta mampu mengenal titik atau area penting dalam proses kerjanya yang dapat berpengaruh 
kepada customer atau next process dalam alur proses kerjanya, dan berusaha mencari solusi saat terjadi 
masalah (menjalankan instruksi kerja dengan baik).', 1, true, 'D001');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M002', 'Cukup', 'Mampu menjelaskan proses kerja pada jabatan dan bagiannya, tetapi kurang mengerti bila terjadi 
masalah pada alur proses kerjanya (instruksi kerja belum berjalan dengan baik).', 2, true, 'D001');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M003', 'Kurang', 'Tidak mampu menjelaskan alur proses kerja pada jabatan dan bagiannya (mengabaikan instruksi kerja 
yang ada).', 3, true, 'D001');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M004', 'Baik', 'Mampu melakukan rencana tugas sendiri yang terkait dengan tugas dan tanggung jawabnya, mampu 
memahami instruksi dengan jelas dan mengatur segala tugas (memahami komponen penting dan 
mendesak) serta memiliki kontrol terhadap tugas dan tanggung jawab pribadinya. Memahami dan 
mengerti alur struktur organisasi pada divisinya', 1, true, 'D002');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M005', 'Cukup', 'Cukup mampu melakukan tugas (sesuai dengan instruksi kerja) dan cukup memiliki pengendalian 
terhadap tugas tanggung jawab yang dibebankan padanya.', 2, true, 'D002');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M006', 'Kurang', 'Kurang dalam melakukan tugas tanggung jawabnya dan kurang dalam kontrol terhadap tugas yang 
dilakukannya.', 3, true, 'D002');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M007', 'Baik', 'Memperhatikan program K3L dalam lingkungan kerjanya, seperti peduli pada pemakaian APD pada 
pekerja, memperhatikan kondisi lingkungan kondusif untuk bekerja, melakukan pengawasan dan 
kontrol pada titik yang dapat menyebabkan kecelakaan kerja.', 1, true, 'D003');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M008', 'Cukup', 'Cukup memperhatikan program K3L dalam lingkungan kerjanya, tetapi kurang dalam melakukan 
pengawasan dan kontrol terhadap lingkungan kerjanya', 2, true, 'D003');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M009', 'Kurang', 'Kurang dalam pemahaman terhadap program K3L dan cenderung menyepelekan.', 3, true, 'D003');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M010', 'Baik', 'Sangat mampu melaksanakan kerja sesuai prosedur kerja dan instruksi kerjanya.', 1, true, 'D004');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M011', 'Cukup', 'Cukup mampu melakukan kerja sesuai prosedur kerja dan instruksi kerjanya.', 2, true, 'D004');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M012', 'Kurang', 'Kurang mampu dalam melakukan kerja sesuai prosedur kerja dan instruksi kerjanya.', 3, true, 'D004');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M013', 'Baik', 'Penguasaan diri saat presentasi baik, non text book , dan ada kontak mata dengan audiens.', 1, true, 'D006');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M014', 'Cukup', 'Penguasaan diri saat presentasi baik tetapi masih text book , dan kurang terjadi kontak mata dengan
audiens.', 2, true, 'D006');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M015', 'Kurang', 'Kurang dalam penguasaan saat presentasi, sangat text book dan tidak terjadi kontak mata dengan 
audiens.', 3, true, 'D006');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M016', 'Baik', 'Mampu menyampaikan materi dengan runtut dan mengelola forum tanya jawab dengan baik.', 1, true, 'D007');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M017', 'Cukup', 'Cukup mampu menyampaikan materi dengan runtut, tetapi masih kurang dalam menanggapi tanya
jawab dengan audiens.', 2, true, 'D007');
INSERT INTO sc_pk.score_aspect_ojt
(kd_aspect, aspect_name, aspect_desc, "position", active, kd_aspect_parent)
VALUES('M018', 'Kurang', 'Kurang mampu dalam penyampaian materi, tidak runtut dan tidak mampu menanggapi tanya jawab dari 
audiens.', 3, true, 'D007');

INSERT INTO sc_pk.score_aspect_parent_ojt
(kd_aspect, aspect_question, "position", active, "type")
VALUES('D001', 'A. Pemahaman Proses', 1, true, true);
INSERT INTO sc_pk.score_aspect_parent_ojt
(kd_aspect, aspect_question, "position", active, "type")
VALUES('D002', 'B. Pengaturan Kinerja Pribadi', 2, true, true);
INSERT INTO sc_pk.score_aspect_parent_ojt
(kd_aspect, aspect_question, "position", active, "type")
VALUES('D003', 'C. Pemahaman dan Realisasi K3L dalam lingkungan Kerjanya', 3, true, true);
INSERT INTO sc_pk.score_aspect_parent_ojt
(kd_aspect, aspect_question, "position", active, "type")
VALUES('D004', 'D. Pemahaman dan Pelaksanaan Prosedur Kerja / Instruksi Kerja', 4, true, true);
INSERT INTO sc_pk.score_aspect_parent_ojt
(kd_aspect, aspect_question, "position", active, "type")
VALUES('D005', 'E. Hal - hal yang Perlu Ditingkatkan dan Masukan', 5, true, false);
INSERT INTO sc_pk.score_aspect_parent_ojt
(kd_aspect, aspect_question, "position", active, "type")
VALUES('D006', 'A. Kepercayaan Diri', 6, true, true);
INSERT INTO sc_pk.score_aspect_parent_ojt
(kd_aspect, aspect_question, "position", active, "type")
VALUES('D007', 'B. Komunikasi', 7, true, true);


INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL,5,'I.F.F','KARYAWAN OJT','I.F','false','S',false,'fa fa-check-square-o','#',NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL,1,'I.F.F.1','PENILAIAN PANELIST','I.F','I.F.F','P',false,'fa-star','ojt/list_ojtpen',NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL,2,'I.F.F.2','APPROVAL HRGA','I.F','I.F.F','P',false,'fas fa-thumbs-up','ojt/list_ojtappr',NULL);
INSERT INTO sc_mst.menuprg
(branch, urut, kodemenu, namamenu, parentmenu, parentsub, child, holdmenu, iconmenu, linkmenu, menuposition)
VALUES(NULL,3,'I.F.F.3','HASIL PENILAIAN','I.F','I.F.F','P',false,'fa-folder','ojt/result_ojt',NULL);

commit;
