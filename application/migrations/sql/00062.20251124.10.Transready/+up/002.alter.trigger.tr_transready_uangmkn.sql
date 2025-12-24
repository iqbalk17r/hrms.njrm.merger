drop trigger tr_transready_uangmkn on sc_trx.transready;
create trigger tr_transready_uangmkn after
insert or update
    on
    sc_trx.transready for each row execute procedure sc_trx.tr_transready_uangmkn()