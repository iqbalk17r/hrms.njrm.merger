<table id="reportedTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="1%">No</th>
            <th width="10%">Nama</th>
            <th width="8%">Departemen</th>
            <th width="5%">Jabatan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=0; foreach ($dtl as $key => $value) : $no++;?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $value->nmlengkap ?></td>											
                <td><?= $value->nmdept ?></td>											
                <td><?= $value->nmjabatan ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
    $("#reportedTable").dataTable();
</script>