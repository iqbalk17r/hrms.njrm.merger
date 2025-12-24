DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_rep' AND table_name = 'cashbon' ) THEN
        CREATE TABLE sc_rep.cashbon (
            fc_branch char (6),
            fc_nik char (6),
            fv_cashbonid varchar (8),
            fv_dutieid varchar (8),
            fv_status char (1),
            fv_paymenttype char (1),
            fv_formatpaymenttype varchar (20),
            fv_type varchar (3),
            fv_formattype varchar (25),
            fn_totalcashbon numeric (20,2),
            fv_flag varchar (3),
            fv_voucher varchar (20),
            fc_inputby char(6),
            fd_inputdate timestamp,
            fc_updateby char(6),
            fd_updatedate timestamp,
            fc_approveby char(6),
            fd_approvedate timestamp,
            CONSTRAINT cashbon_pkey PRIMARY KEY (fc_branch,fc_nik,fv_cashbonid)
        );
    END IF;
END
$$
