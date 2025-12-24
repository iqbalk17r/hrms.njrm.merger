DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_rep' AND table_name = 'podtl' ) THEN
        create table sc_rep.podtl (
          fc_branch char (6)  not null ,
          fc_pono char (12)  not null ,
          fn_nomor numeric(4, 0) not null ,
          fc_stockcode char (20)  not null ,
          fv_stockname varchar (60)  not null ,
          fd_pricedate timestamp null ,
          fn_term numeric(3, 0) null ,
          fn_qty numeric(12, 2) null ,
          fc_extratype char (1)  not null ,
          fn_extra numeric(12, 2) null ,
          fc_kondisi char (1)  not null ,
          fm_formula real not null ,
          fm_pricelist money not null ,
          fn_disc1p numeric(4, 2) null ,
          fn_disc2p numeric(4, 2) null ,
          fn_disc3p numeric(4, 2) null ,
          fn_disc4p numeric(4, 2) null ,
          fm_discval money null ,
          fc_excludeppn char (3)  not null ,
          fn_xppn numeric(4, 2) not null ,
          fn_stdvol numeric(12, 2) not null ,
          fn_qtyvol numeric(12, 2) not null ,
          fn_extravol numeric(12, 2) not null ,
          fn_ttlvol numeric(12, 2) not null ,
          fm_brutto money not null ,
          fm_netto money not null ,
          fm_dpp money not null ,
          fm_ppn money not null ,
          fc_approved char (1)  null ,
          fc_approvedref char (7)  null ,
          fn_qtydelv numeric(12, 2) null ,
          fn_extradelv numeric(12, 2) null ,
          fc_reason char (1)  null ,
          fc_status char (1)  null ,
          fc_nodraft char (12)  null ,
          fc_depcode char (10)  null ,
          fc_matauang char (10)  null ,
          fm_kurs money not null ,
          fm_pricebykurs money not null ,
          fn_qtyoutbuff numeric(12, 2) null ,
          constraint podtl_pkey primary key  (fc_branch,fc_pono,fn_nomor,fc_stockcode)
        );
    END IF;
END
$$
