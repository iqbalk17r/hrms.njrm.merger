<style>
    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 70px;
        height: 70px;
        margin: -25px 0 0 -76px;
        border: 16px solid #ddd;
        border-radius: 50%;
        border-top: 16px solid #00a65a;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<legend><?= $title ?></legend>
<div class="row">
    <div class="col-xs-12">
        <div class="box" style="padding: 20px 0;">
            <div class="box-header">
                <?php if(!$querySize): ?>
                    <div style="text-align: center;">
                        <h3>HARAP RESTART SERVICE POSTGRES ANDA. LALU REFRESH KEMBALI HALAMAN INI!!!</h3>
                    </div>
                <?php elseif($install): ?>
                    <div style="text-align: center;">
                        <button id="install" class="btn btn-warning"><i class="fa fa-plus"></i>&nbsp; INSTALL LOG</a>
                    </div>
                    <div id="loader" style="display: none;"></div>
                <?php else: ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1"><i class="fa fa-search"></i>&nbsp; FILTER</a>
                <?php endif; ?>
            </div>
            <div class="box-body">
                <?php if($querySize && !$install): ?>
                    <table id="example1" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th style="width: 30px;">No</th>
                                <th>Tag</th>
                                <th>Username</th>
                                <th>Database Name</th>
                                <th>Client Address</th>
                                <th style="width: 100px;">Exec Time</th>
                                <th>Query</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($audit as $k => $v): ?>
                                <tr>
                                    <td style="text-align: center;"><?= $k + 1 ?></td>
                                    <td><?= $v['tag'] ?></td>
                                    <td><?= $v['username'] ?></td>
                                    <td><?= $v['datname'] ?></td>
                                    <td><?= $v['client_addr'] ?></td>
                                    <td><?= $v['crt_time'] ?></td>
                                    <td style="white-space: pre-wrap;"><?= $v['query'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    var isBeauty = false;

    $("#example1").dataTable({
        sorting: []
    });

    $("#install").click(function() {
        $('#install').attr('style', 'display: none;');
        $('#loader').attr('style', 'display: block;');
        $.post("dbLog/install", {},
        function(data) {
            alert("INSTALLATION SUCCESS");
            location.reload();
        });
    });

    function beautySql() {

    }
</script>
