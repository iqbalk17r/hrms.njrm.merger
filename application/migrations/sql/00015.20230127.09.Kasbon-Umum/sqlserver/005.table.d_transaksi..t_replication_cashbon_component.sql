CREATE TABLE d_transaksi..t_replication_cashbon_component (
    fc_branch char (6),
    fv_cashbonid varchar (8),
    fv_componentid varchar (20),
    fv_componentname varchar (100),
    fn_nominal numeric (20,2),
    fn_quantityday numeric (20),
    fn_totalcashbon numeric (20,2),
    ft_description text,
    fc_inputby char(6),
    fd_inputdate datetime,
    fc_updateby char(6) null,
    fd_updatedate datetime null
    CONSTRAINT [replication_cashbon_component_pkey] PRIMARY KEY  CLUSTERED
    (
        [fc_branch],
        [fv_cashbonid],
        [fv_componentid]
    )
);
