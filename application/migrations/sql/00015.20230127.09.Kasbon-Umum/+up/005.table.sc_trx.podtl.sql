DO
$$
BEGIN
    IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'podtl' ) THEN
        create table sc_trx.podtl (
            branch char (6)  not null ,
            pono char (12)  not null ,
            nomor numeric(4, 0) not null ,
            stockcode char (20)  not null ,
            stockname varchar (60)  not null ,
            pricedate timestamp null ,
            term numeric(3, 0) null ,
            qty numeric(12, 2) null ,
            extratype char (1)  not null ,
            extra numeric(12, 2) null ,
            kondisi char (1)  not null ,
            formula real not null ,
            pricelist money not null ,
            disc1p numeric(4, 2) null ,
            disc2p numeric(4, 2) null ,
            disc3p numeric(4, 2) null ,
            disc4p numeric(4, 2) null ,
            discval money null ,
            excludeppn char (3)  not null ,
            xppn numeric(4, 2) not null ,
            stdvol numeric(12, 2) not null ,
            qtyvol numeric(12, 2) not null ,
            extravol numeric(12, 2) not null ,
            ttlvol numeric(12, 2) not null ,
            brutto money not null ,
            netto money not null ,
            dpp money not null ,
            ppn money not null ,
            approved char (1)  null ,
            approvedref char (7)  null ,
            qtydelv numeric(12, 2) null ,
            extradelv numeric(12, 2) null ,
            reason char (1)  null ,
            status char (1)  null ,
            nodraft char (12)  null ,
            depcode char (10)  null ,
            matauang char (10)  null ,
            kurs money not null ,
            pricebykurs money not null ,
            qtyoutbuff numeric(12, 2) null ,
            constraint podtl_pkey primary key  (branch,pono,nomor,stockcode)
        );
    END IF;
END
$$
