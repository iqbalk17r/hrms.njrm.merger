create trigger tr_tmp_perawatanspk_pembayaran after
insert
    or
update
    on
    sc_tmp.perawatanspk_pembayaran for each row execute procedure sc_tmp.tr_perawatanspk_pembayaran();