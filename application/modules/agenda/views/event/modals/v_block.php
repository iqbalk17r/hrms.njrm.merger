<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
        </div>
        <div class="modal-body">
            <h4><?php echo $message?></h4>
        </div>
        <div class="modal-footer">
            <div class="btn-toolbar">
                <button type="button" class="btn btn-warning close-modal" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>