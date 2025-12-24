CREATE TABLE d_transaksi..t_replication_declarationcashbon_component_notin (
    fc_branch char (6),
    fv_declarationid varchar (8),
    fv_componentid varchar (20),
    fv_componentname varchar (100),
    fd_perday datetime,
    fn_nominal numeric (20,2),
    ft_description text,
    fc_inputby char(6),
    fd_inputdate datetime,
    fc_updateby char(6) null,
    fd_updatedate datetime null
    CONSTRAINT [replication_declarationcashbon_component_notin_pkey] PRIMARY KEY  CLUSTERED
    (
        [fc_branch],
        [fv_declarationid],
        [fv_componentid]
    )
);


