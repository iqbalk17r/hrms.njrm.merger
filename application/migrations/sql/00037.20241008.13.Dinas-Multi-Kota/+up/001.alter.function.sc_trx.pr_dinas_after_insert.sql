create OR REPLACE function sc_trx.pr_dinas_after_insert() returns trigger
    language plpgsql
as
$$
declare
vr_kddinas character(25);

begin

update sc_trx.dinas set status='A' where new.status='I' and nodok=new.nodok;
return new;

end;
$$;