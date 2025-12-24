CREATE TRIGGER tr_sk_peringatan
  AFTER UPDATE
  ON sc_trx.sk_peringatan
  FOR EACH ROW
  EXECUTE PROCEDURE sc_trx.tr_sk_peringatan();