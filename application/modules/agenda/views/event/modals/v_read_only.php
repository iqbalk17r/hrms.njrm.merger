<?php
// var_dump($agendaData);
// die();
?>


<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4">Nomor Agenda</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" name="agenda_name" id="agenda_id" value="<?php echo $transaction->agenda_id ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Nama Agenda</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" name="agenda_name" id="agenda_name" value="<?php echo $transaction->agenda_name ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Tipe Agenda</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" name="agenda_type" id="agenda_type" value="<?php echo $transaction->agenda_type_name ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Tipe Penyelenggara</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" name="organizer_type" id="organizer_type" value="<?php echo $transaction->organizer_type_name ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Nama Penyelenggara</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" name="organizer_name" id="organizer_name" value="<?php echo $transaction->organizer_name ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Jumlah Peserta</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" name="organizer_name" id="organizer_name" value="<?php echo $transaction->participant_count ?>" readonly>
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
                <div class="form-group">
                    <label class="col-sm-4">Lokasi</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" name="location" id="location" value="<?php echo $transaction->location ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea name="description" id="description" class="form-control text-uppercase" cols="30" rows="9" readonly><?php echo $transaction->description ?></textarea>
                    </div>
                </div>
                <?php if (!is_null($agendaData) && $agendaData->nik == trim($this->session->userdata('nik'))) { ?>
                    <div class="form-group">
                        <label class="col-sm-4">Konfirmasi Undangan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase"
                                   value="<?php echo $agendaData->confirm_status_text ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Kehadiran Acara</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase"
                                   value="<?php echo $agendaData->attend_status_text ?>" readonly>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="modal-footer">
            <div class="btn-toolbar">
                <button type="button" class="btn btn-warning pull-left close-modal" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
