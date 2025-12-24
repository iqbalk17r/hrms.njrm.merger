DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'jabatan' AND column_name = 'bbm' ) THEN
            ALTER TABLE sc_mst.jabatan ADD bbm varchar ;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_mst' AND table_name = 'jabatan' AND column_name = 'sewakendaraan' ) THEN
            ALTER TABLE sc_mst.jabatan ADD sewakendaraan varchar ;
        END IF;

        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'SMR';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'AE' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'SMR';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'DMK';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'AE' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'DMK';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'RMBG';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'AE' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'RMBG';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'PKL';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'AE' AND trim(kddept) = 'NRU' AND trim(kdsubdept) = 'PKL';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'NRS' AND trim(kdsubdept) = 'SLO';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'AE' AND trim(kddept) = 'NRS' AND trim(kdsubdept) = 'SLO';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'NRS' AND trim(kdsubdept) = 'JGJ';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'AE' AND trim(kddept) = 'NRS' AND trim(kdsubdept) = 'JGJ';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'NRS' AND trim(kdsubdept) = 'SBY';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'AE' AND trim(kddept) = 'NRS' AND trim(kdsubdept) = 'SBY';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'KLTR' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'ACU';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'KLTR' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'ACS';
        UPDATE sc_mst.jabatan SET bbm = 'T', sewakendaraan = 'T' WHERE trim(kdjabatan) = 'KLTR' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'APST';
        UPDATE sc_mst.jabatan SET bbm = 'F', sewakendaraan = 'F' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'ACU';
        UPDATE sc_mst.jabatan SET bbm = 'F', sewakendaraan = 'F' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'ACS';
        UPDATE sc_mst.jabatan SET bbm = 'F', sewakendaraan = 'F' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'APST';
        UPDATE sc_mst.jabatan SET bbm = 'F', sewakendaraan = 'F' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'AKNT';
        UPDATE sc_mst.jabatan SET bbm = 'F', sewakendaraan = 'F' WHERE trim(kdjabatan) = 'SPV' AND trim(kddept) = 'KEU' AND trim(kdsubdept) = 'PMBL';
    END
$$;