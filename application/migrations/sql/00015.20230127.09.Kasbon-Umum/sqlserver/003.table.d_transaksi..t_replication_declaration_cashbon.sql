CREATE TABLE d_transaksi..t_replication_declaration_cashbon(
    fc_branch char (6),
    fc_nik char (6),
    fv_fullname varchar (100),
    fv_declarationid varchar (8),
    fv_cashbonid varchar (8),
    fv_dutieid varchar (8),
    fv_status char (1),
    fv_paymenttype char (1),
    fn_totalcashbon numeric (20,2),
    fn_totaldeclaration numeric (20,2),
    fn_returnamount numeric (20,2),
    fv_flag varchar (3),
    fv_voucher varchar (20),
    fc_inputby char(6),
    fd_inputdate datetime,
    fc_updateby char(6),
    fd_updatedate datetime null,
    fc_approveby char(6),
    fd_approvedate datetime null,
    CONSTRAINT [replication_declaration_cashbon_pkey] PRIMARY KEY  CLUSTERED
    (
       [fc_branch],
       [fc_nik],
       [fv_declarationid],
       [fv_cashbonid]
    )
);
