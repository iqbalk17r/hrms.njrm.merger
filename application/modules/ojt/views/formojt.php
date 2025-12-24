<script type="text/javascript">
    $(function() {

        $('#example1').dataTable({
            "paging": true,
            "pageLength": 3,
            "lengthMenu": [
                [3, 6, 9, -1],
                [3, 6, 9, "Semua"]
            ],
            "searching": false,
            "ordering": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ daftar penilaian",
            }
        });
        // $("#datatableMaster").dataTable();

        $("#example3").dataTable();
        $("#example4").dataTable();
        $(".inputfill").selectize();
        $('.tglYM').datepicker({
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });

        $('form').on('focus', 'input[type=number]', function(e) {
            $(this).on('mousewheel.disableScroll', function(e) {
                e.preventDefault()
            })
        })
    });
</script>
<style>
    .selectize-input {
        overflow: visible;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .selectize-input.dropdown-active {
        min-height: 30px;
        line-height: normal;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .selectize-dropdown,
    .selectize-input,
    .selectize-input input {
        min-height: 30px;
        line-height: normal;
    }

    .loading .selectize-dropdown-content:after {
        content: 'loading...';
        height: 30px;
        display: block;
        text-align: center;
    }

    .grey-label {
        color: grey;
    }
</style>
<legend><?php echo $title; ?></legend>

<?php echo $message; ?>

<div class="row">
    <div class="col-sm-12">
        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default"
            style="margin:10px; color:#000000;">Kembali</a>
        <?php if ($userhr > 0 and $approver > 0 and trim($dtlrow['status']) == 'A') { ?>
            <a href="<?php
                        $enc_nik = bin2hex($this->encrypt->encode(trim($dtlrow['nik'])));
                        $enc_periode = bin2hex($this->encrypt->encode(trim($dtlrow['periode'])));
                        echo site_url("pk/pk/approval_input_pa/$enc_nik/$enc_periode"); ?>" class="btn btn-success pull-right"
                onclick="return confirm('Apakah Approval Data Ini??')" style="margin:10px; color:#ffffff;"><i
                    class="fa fa-check"></i> Approval </a>
        <?php } ?>
    </div>
</div>
</br>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h4>Identitas Pekerja</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="datatableMaster" class="table table-bordered table-striped">     
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>BAGIAN</th>
                                    <th>DiORIENTASIKAN SEBAGAI</th>
                                    <th>ORIENTASI SEJAK</th>
                                    <th>TANGGAL BERAKHIR</th>
                                    <th>LAMA KERJA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 0;
                                foreach ($infoumum as $row):
                                   ?>
                                    <tr>
                                        <td><?php echo $row->nmlengkap  ; ?></td>
                                        <td><?php echo $row->nik; ?></td>
                                        <td><?php echo $row->nmdept; ?></td>
                                        <td><?php echo $row->nmjabatan; ?></td>
                                        <td><?php echo $row->tglmasukkerja1; ?></td>
                                        <td><?php echo $row->tgl_selesai1 ?></td>
                                        <td><?php echo $row->masakerja; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h4>POINT EVALUASI ORIENTASI</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <!--FORM PEMBUKA-->
                        <form action="<?php echo site_url('ojt/ojt/save_penilaian_karyawanew'); ?>" method="post">
                            <table id="example1" class="table table-bordered table-striped" data-page-length="-1" data-paging="false">
                            <?php foreach ($aspek_grouped as $group): 
                                    $parent = $group['parent'];
                                    $children = $group['child'];
                                ?>
                                    <!-- Judul Parent -->
                                    <tr style="background:#eee;">
                                        <td colspan="3">
                                            <strong><?= $parent['question'] ?></strong>
                                        </td>
                                    </tr>

                                    <?php if ($parent['type'] == 't'): ?>
                                    <!-- Radio Button -->
                                    <?php
                                        $options = [
                                            1 => 'Baik',
                                            2 => 'Cukup',
                                            3 => 'Kurang'
                                        ];
                                        foreach ($options as $val => $label):
                                    ?>
                                    <tr>
                                        <td width="100">
                                            <label>
                                                <input type="radio" name="aspek[<?= $parent['kd'] ?>]" value="<?= $val ?>" required
                                                    <?= (isset($parent['score']) && $parent['score'] == $val) ? 'checked' : '' ?>>
                                                <strong><?= $label ?></strong>
                                            </label>
                                        </td>
                                        <td colspan="2"><?= isset($children[$label]) ? $children[$label] : '' ?></td>
                                    </tr>
                                    <?php endforeach; ?>

                                    <?php else: ?>
                                    <!-- Isian Jawaban -->
                                    <tr>
                                        <td colspan="3">
                                            <textarea  class="form-control capital" name="aspek[<?= $parent['kd'] ?>]" style="width:100%; height:60px;" required></textarea>

                                            <h4 class="m-5" style="margin-top:20px; margin-bottom:20px;">POINT PRESENTASI</h4>
                                        </td>
                                    </tr>

                                    

                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h4>ANALISA REKOMENDASI</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <textarea name="catatan" id="catatan" style="width: 100%; resize: none;"
                            class="form-control capital" required></textarea>
                            <div class="text-center" style="margin-top: 20px;">
                        <input type="hidden" name="nik" value="<?php echo isset($_GET['nik']) ? htmlspecialchars($_GET['nik']) : ''; ?>">
                        <input type="hidden" name="docno" value="<?php echo isset($_GET['docno']) ? htmlspecialchars($_GET['docno']) : ''; ?>">
                        <button type="submit" class="btn-success" style="font-size: 20px; padding: 10px 20px;">Submit Penilaian</button>
                    </div><!-- /.box-body -->
                    <!--FORM PENUTUP-->
                    </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</div>
</div><!--/ nav -->

<script>
    //Date range picker
    $("#tgl").datepicker();
    $(".tglan").datepicker();

    function capitalizeFirstWord(element) {
        const text = element.innerText;
        element.innerText = text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    const elements = document.querySelectorAll(".capitalize-first");
    elements.forEach(capitalizeFirstWord);

    $(".capital").each(function() {
        var text = $(this).val();
        $(this).val(text.charAt(0).toUpperCase() + text.slice(1).toLowerCase());
    });
</script>