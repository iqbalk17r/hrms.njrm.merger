<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <form id="update-agenda" class="form update-agenda" action="<?php echo $formAction ?>" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
                <h5 class="modal-title" id="myModalLabel"><?php echo $agendaData->begin_date_reformat.' s/d '.$agendaData->end_date_reformat ?></h5>
            </div>
            <div class="modal-body">
                <table class="table table-hover dataTable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Regu</th>
                        <th>Shift Ke</th>
                        <th>Nama Jam Kerja</th>
                        <th>Jam Kerja</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transaction as $index => $item) { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $item->date_format; ?></td>
                            <td><?php echo $item->group_name; ?></td>
                            <td><?php echo $item->shiftid; ?></td>
                            <td><?php echo $item->workhour_name; ?></td>
                            <td><?php echo $item->entry_hour.' - '.$item->leave_hour; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar">
                    <button type="button" class="btn btn-warning pull-right close-modal" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </form>
</div>

