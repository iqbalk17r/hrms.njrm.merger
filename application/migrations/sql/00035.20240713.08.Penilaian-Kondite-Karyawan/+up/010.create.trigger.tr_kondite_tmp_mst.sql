create trigger tr_kondite_tmp_mst after
insert
    or
update
    on
    sc_pk.kondite_tmp_rekap for each row execute procedure sc_pk.tr_kondite_tmp_rekap()