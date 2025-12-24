CREATE TABLE d_transaksi..t_replication_cashbon_component_po (
    fc_branch char (6)  not null ,
    fv_cashbonid varchar (8),
    fv_dutieid varchar (8),
    fv_type varchar (12),
    fc_pono char (12)  not null ,
    fn_nomor numeric(4, 0) not null,
    fc_stockcode char (20)  not null ,
    fv_stockname varchar (60)  not null ,
    fn_qty numeric(12, 2) null ,
    fm_pricelist money not null ,
    fm_brutto money not null ,
    fm_netto money not null ,
    fm_dpp money not null ,
    fm_ppn money not null ,
    fc_inputby char(6),
    fd_inputdate datetime,
    fc_updateby char(6),
    fd_updatedate datetime null,
    CONSTRAINT [replication_cashbon_component_po_pkey] PRIMARY KEY  CLUSTERED
    (
        [fc_branch],
        [fv_cashbonid],
        [fc_pono],
        [fn_nomor]
    )
);
