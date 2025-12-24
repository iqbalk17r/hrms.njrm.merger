<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">NIK</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="nik" value="<?php echo trim($employee->nik); ?>"
                                           class="form-control" style="text-transform:uppercase"
                                           readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="kdlvl1" value="<?php echo trim($employee->nmlengkap); ?>" class="form-control" style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Department</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="department1"
                                           value="<?php echo trim($employee->nmdept); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="jabatan1"
                                           value="<?php echo trim($employee->nmjabatan); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="jabatan1"
                                           value="<?php echo trim($employee->mergephone); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Penyelenggara</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="atasan1"
                                           value="<?php echo trim($transaction->organizer_name); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal mulai</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="begin_date" id="begin_date" value="<?php echo $transaction->begin_date ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal selesai</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="end_date" id="end_date" value="<?php echo $transaction->end_date ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">Lokasi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="location" id="location" value="<?php echo $transaction->location ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Pretest</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="pretest" id="pretest"  value="<?php echo $result->pretest ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Posttest</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="posttest" id="posttest"  value="<?php echo $result->posttest ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group hide">
                                <label class="col-sm-4">Nilai</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="score" id="score"  value="<?php echo $result->score ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Hasil</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="result_text" id="result_text"  value="<?php echo $result->result_text ?>" readonly>
                                </div>
                            </div>
                            <?php if($transaction->agenda_type == 'COACH') { ?>
                                <div class="form-group">
                                    <label class="col-sm-4">Sertifikat</label>
                                    <div class="col-sm-8">
                                        <a target="_blank" class="btn btn-md btn-linkedin "  href="<?php echo base_url($result->sertificate ) ?>" >Unduh sertifikat</a>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar">
                    <button type="button" class="btn btn-warning cancel" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>

</div>