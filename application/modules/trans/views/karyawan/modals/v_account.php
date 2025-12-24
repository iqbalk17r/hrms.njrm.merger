<style>
    #content {
        height: 500px;
    }
    pre.ql-syntax{
        background-color: white !important;
    }
</style>
<div class="modal-dialog modal-dialog-scrollable <?php echo (isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel"><?php echo(isset($modalTitle) ? $modalTitle : 'Header') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div data-scroll="true" data-height="400">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Aplikasi</th>
                            <th>Username</th>
                            <th>Password</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($accountList as $index => $item) { ?>
                            <tr>
                                <td><?php echo $item['application'] ?></td>
                                <td><?php echo $item['username'] ?></td>
                                <td><?php echo $item['password'] ?></td>
                            </tr>
                        <?php } ?>
                        <!-- Add more user rows as needed -->
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="modal-footer m-1 p-1">
                <button type="button" class="btn btn-sm btn-primary " data-dismiss="modal">Tutup
                </button>
            </div>

    </div>
</div>