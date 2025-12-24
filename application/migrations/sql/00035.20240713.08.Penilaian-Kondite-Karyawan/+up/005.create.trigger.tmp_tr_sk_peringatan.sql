CREATE TRIGGER tr_sk_peringatan
  AFTER UPDATE
  ON sc_tmp.sk_peringatan
  FOR EACH ROW
  EXECUTE PROCEDURE sc_tmp.tr_sk_peringatan();