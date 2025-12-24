create table IF NOT EXISTS sc_trx.detail_borong
(
    nodok         char(12) not null,
    nik           char(12) not null,
    nodok_ref     char(12) not null,
    tgl_dok       date,
    periode       char(6),
    tgl_kerja     date,
    total_upah    numeric(18, 2),
    status        char(3),
    keterangan    text,
    input_date    timestamp,
    approval_date timestamp,
    input_by      char(20),
    approval_by   char(20),
    delete_by     char(20),
    cancel_by     char(20),
    update_date   timestamp,
    delete_date   timestamp,
    cancel_date   timestamp,
    update_by     varchar(20),
    urut          serial
);