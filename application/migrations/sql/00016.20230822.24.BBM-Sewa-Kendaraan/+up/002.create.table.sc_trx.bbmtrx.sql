create table IF NOT EXISTS sc_trx.bbmtrx
(
    branch            char(6),
    nik               char(12) not null,
    tgl               date     not null,
    checkin           time,
    checkout          time,
    nominal           numeric,
    keterangan        text,
    tgl_dok           date,
    dok_ref           char(25),
    rencanacallplan   integer,
    realisasicallplan integer,
    primary key (nik, tgl)
);
