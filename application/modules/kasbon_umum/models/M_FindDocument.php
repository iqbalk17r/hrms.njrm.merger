<?php

class M_FindDocument extends CI_Model
{
    function q_temporary_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_tmp.cashbon_component_po')
                ->num_rows() > 0;
    }
    function q_transaction_exists($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.cashbon_component_po')
                ->num_rows() > 0;
    }
    function q_temporary_create($value){
        return $this->db
            ->insert('sc_tmp.cashbon_component_po', $value);
    }

    function q_temporary_delete($where){
        return $this->db
            ->where($where)
            ->delete('sc_tmp.cashbon_component_po');
    }

    function q_temporary_read_where($clause=null){
        return $this->db->query(<<<'SQL'
SELECT *,
       SPLIT_PART(REGEXP_REPLACE(pricelist::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS pricelistformat,
       SPLIT_PART(REGEXP_REPLACE(netto::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nettoformat,
       SPLIT_PART(REGEXP_REPLACE(sumnetto::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS sumnettoformat
       FROM (
SELECT
      COALESCE(TRIM(a.branch), '') AS branch,
      COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
      COALESCE(TRIM(a.pono), '') AS pono,
      nomor AS nomor,
      COALESCE(TRIM(a.stockcode), '') AS stockcode,
      COALESCE(TRIM(a.stockname), '') AS stockname,
      qty AS qty,
      pricelist AS pricelist,
      brutto AS brutto,
      netto AS netto,
      ppn AS ppn,
      dpp AS dpp,
      SUM(netto) OVER(PARTITION BY COALESCE(TRIM(a.cashbonid), '')) AS sumnetto,
      COALESCE(TRIM(a.inputby), '') AS inputby
  FROM sc_tmp.cashbon_component_po a
  LEFT OUTER JOIN sc_tmp.cashbon b on b.cashbonid = a.cashbonid
  ORDER BY a.pono ASC, a.nomor ASC
    ) AS a
WHERE TRUE
SQL
            .$clause
        );
    }

    function q_transaction_read_where($clause=null){
        return $this->db->query(<<<'SQL'
SELECT *,
       SPLIT_PART(REGEXP_REPLACE(pricelist::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS pricelistformat,
       SPLIT_PART(REGEXP_REPLACE(netto::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nettoformat,
       SPLIT_PART(REGEXP_REPLACE(sumnetto::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS sumnettoformat
       FROM (
SELECT
      COALESCE(TRIM(a.branch), '') AS branch,
      COALESCE(TRIM(a.cashbonid), '') AS cashbonid,
      COALESCE(TRIM(a.pono), '') AS pono,
      nomor AS nomor,
      COALESCE(TRIM(a.stockcode), '') AS stockcode,
      COALESCE(TRIM(a.stockname), '') AS stockname,
      qty AS qty,
      pricelist AS pricelist,
      brutto AS brutto,
      netto AS netto,
      ppn AS ppn,
      dpp AS dpp,
      SUM(netto) OVER(PARTITION BY COALESCE(TRIM(a.cashbonid), '')) AS sumnetto,
      COALESCE(TRIM(a.inputby), '') AS inputby
  FROM sc_trx.cashbon_component_po a
  LEFT OUTER JOIN sc_trx.cashbon b on b.cashbonid = a.cashbonid
  ORDER BY a.pono ASC, a.nomor ASC
    ) AS a
WHERE TRUE
SQL
            .$clause
        );
    }


    function q_master_search_po_where($clause=null) {
        return $this->db->query(<<<'SQL'
SELECT * FROM (
      SELECT distinct on (a.pono)
          COALESCE(TRIM(a.pono), '') AS id,
          COALESCE(TRIM(a.operator), '') AS text,
          COALESCE(TO_CHAR(a.podate, 'dd-mm-yyyy'), '') AS podate
      FROM sc_trx.pomst a
      INNER JOIN sc_trx.podtl b ON COALESCE(TRIM(a.pono), '') = COALESCE(TRIM(b.pono), '')
      where postatus = 'P'
ORDER BY a.pono desc
    ) AS a
WHERE TRUE
SQL
            .$clause
        );
    }


    function q_master_po_txt_where($clause = null){
        return $this->db->query($this->q_master_po_where($clause));
    }

    function q_master_po_where($clause=null) {
        return $this->db->query(<<<'SQL'
SELECT
    *,
    SPLIT_PART(REGEXP_REPLACE(ttlnetto::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nettoformat,
    SUM(nettosum::int) OVER(PARTITION BY postatus) AS sumtotal
FROM (
         SELECT
             COALESCE(TRIM(a.pono), '') AS pono,
             COALESCE(TRIM(a.operator), '') AS operator,
             COALESCE(TRIM(a.postatus), '') AS postatus,
             COALESCE(TRIM(a.potipe), '') AS potipe,
             COALESCE(TRIM(a.employee), '') AS employee,
             COALESCE(TRIM(a.shiptype), '') AS shiptype,
             COALESCE(TRIM(a.shipterm), '') AS shipterm,
             a.itempo AS itempo,
             a.itemappreq AS itemappreq,
             a.itemappved AS itemappved,
             a.itempo AS itempo,
             a.itemappreq AS itemappreq,
             a.itemappved AS itemappved,
             a.itemappdelv AS itemappdelv,
             a.itempodelv AS itempodelv,
             a.itempodel AS itempodel,
             a.agepo AS agepo,
             COALESCE(TRIM(a.suppcode), '') AS suppcode,
             COALESCE(TRIM(a.custcode), '') AS custcode,
             COALESCE(TRIM(a.shipto), '') AS shipto,
             a.totalvol as totalvol,
             a.ttlbrutto AS ttlbrutto,
             a.ttldisc AS ttldisc,
             a.ttlnetto AS ttlnetto,
             a.ttldpp AS ttldpp,
             a.ttlppn AS ttlppn,
             COALESCE(TRIM(a.approvedby1), '') AS approvedby1,
             COALESCE(TRIM(a.approvedby2), '') AS approvedby2,
             flagprint,
             COALESCE(TRIM(a.note), '') AS note,
             ppn,
             COALESCE(TRIM(a.idbu), '') AS idbu,
             COALESCE(TRIM(a.ordertipe), '') AS ordertipe,
             COALESCE(TRIM(a.payto), '') AS payto,
             taxref,
             oappn,
             oaxppn,
             oattlbrutto,
             oattlnetto,
             oattldpp,
             oattlppn,
             printed,
             COALESCE(TRIM(a.inputby), '') AS inputby,
             inputdate,
             COALESCE(TRIM(a.updateby), '') AS updateby,
             updatedate,
             COALESCE(TRIM(a.ponotemp), '') AS ponotemp,
             COALESCE(TRIM(a.cancelby), '') AS cancelby,
             canceldate,
             COALESCE(TRIM(a.hangusby), '') AS hangusby,
             hangusdate,
             SPLIT_PART(REGEXP_REPLACE(ttlnetto::MONEY::VARCHAR, '[Rp\.]', '', 'g'), ',', 1) AS nettosum
         FROM sc_trx.pomst a
         ORDER BY a.pono
     ) AS a
WHERE TRUE
SQL
            .$clause
        );
    }

    function q_master_po_detail_txt_where($clause = null){
        return $this->db->query($this->q_master_po_detail_where($clause));
    }

    function q_master_po_detail_where($clause=null) {
        return $this->db->query(<<<'SQL'
SELECT 
    *, 
    SPLIT_PART(REGEXP_REPLACE(netto::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS nettoformat,
    SPLIT_PART(REGEXP_REPLACE(pricelist::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS pricelistformat,
    SPLIT_PART(REGEXP_REPLACE(brutto::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS bruttoformat,
    SPLIT_PART(REGEXP_REPLACE(dpp::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS dppformat,
    SPLIT_PART(REGEXP_REPLACE(ppn::MONEY::VARCHAR, '[Rp]', '', 'g'), ',', 1) AS ppnformat
FROM (
    SELECT
      COALESCE(TRIM(a.pono), '') AS pono,
      a.nomor AS nomor,
      COALESCE(TO_CHAR(a.pricedate, 'dd-mm-yyyy'), '') AS pricedate,
      COALESCE(TRIM(a.stockcode), '') AS stockcode,
      COALESCE(TRIM(a.stockname), '') AS stockname,
      a.qty as qty,
      a.pricelist as pricelist,
      a.netto as netto,
      a.brutto as brutto,
      a.dpp as dpp,
      a.ppn as ppn,
      COALESCE(TRIM(a.matauang), '') as matauang,
      a.kurs as kurs,
      a.pricebykurs as pricebykurs,
      a.qtyoutbuff as qtyoutbuff
    FROM sc_trx.podtl a
    ORDER BY a.pono ASC, a.nomor ASC
    ) AS a
WHERE TRUE
SQL
            .$clause
        );
    }

    function q_master_document_po($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_trx.pomst');
    }

    function q_selected_document($clause=null) {
        return $this->db->query(<<<'SQL'
SELECT
    *,
    STRING_AGG (pono,', ') OVER (PARTITION BY inputby) AS selectedpono
FROM (
    SELECT DISTINCT ON (a.pono)
        COALESCE(TRIM(a.pono), '') AS pono,
        COALESCE(TRIM(b.inputby), '') AS inputby
    FROM sc_trx.pomst a
    LEFT OUTER JOIN sc_tmp.cashbon_component_po b ON a.pono = b.pono
    ) AS a
WHERE TRUE
SQL
            .$clause
        );
    }
}
