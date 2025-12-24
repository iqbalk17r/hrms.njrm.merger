<script type="text/javascript">
    $(function() {

        $('#example1').dataTable({
            "paging": false,
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
<!-- resize table -->
<!-- <script>
    var table = $('#datatableMaster').DataTable();

    // Loop through each column and set the width
    table.columns().every(function() {

    // Get all cells (td) for this column and set the width
    this.nodes().to$().css('width', '150px');
    });
</script> -->

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
                                    <th>JABATAN</th>
                                    <th>TANGGAL MASUK</th>
                                    <th>TANGGAL BERAKHIR</th>
                                    <th>LAMA PKWT</th>
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
                                        <td><?php echo $row->selisih_tgl; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h4 class="mb-3">Kondite Selama masa kontrak (dalam hari)</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="datatableMaster" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td width="2%">1</td>
                                        <td>IZIN</td>
                                        <td><?php echo $kondite->ttlvalueip;  ?></td>
                                   </tr>
                                   <tr>
                                        <td width="2%">2</td>
                                        <td>SAKIT</td>
                                        <td><?php echo $kondite->ttlvaluesd; ?></td>
                                   </tr>
                                   <tr>
                                        <td width="2%">3</td>
                                        <td>ALPHA</td>
                                        <td><?php echo $kondite->ttlvalueal; ?></td>
                                   </tr>
                                   <tr>
                                        <td width="2%">4</td>
                                        <td>TERLAMBAT</td>
                                        <td><?php echo $kondite->ttlvaluetl; ?></td>
                                   </tr>
                                   <tr>
                                        <td width="2%">5</td>
                                        <td>PULANG AWAL</td>
                                        <td><?php echo $kondite->ttlvalueipa; ?></td>
                                   </tr>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h4>Nilai KPI</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="datatableMaster" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($kpi as $row):
                                    $no++; ?>
                                    <tr>
                                        <td width="2%"><?php echo $no; ?></td>
                                        <td><?php echo $row->periode_formatted; ?></td>
                                        <td><?php echo $row->tahun; ?></td>
                                        <td><?php echo $row->kpi_point; ?></td>
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
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <!--FORM PEMBUKA-->
                        <form action="<?php echo site_url('pk/pk/save_penilaian_karyawanupd'); ?>" method="post">
                            <table id="example#" class="table table-bordered table-striped" data-page-length="-1" data-paging="false">
                                <h4>Penilaian Dari Atasan</h4>
                                <p style="color: red; font-weight: bold;">mohon untuk diisi*</p>
                                       <thead>
                                    <tr>
                                        <th width="5%" class="text-center" rowspan="2" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;">No.</th>
                                        <th width="15%" class="text-center" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;" rowspan="2">
                                            Aspek yang Dinilai
                                        </th>
                                        <th class="text-center" colspan="5" style="height: 23px; line-height: 23px; padding: 0;">Skor</th>
                                        <th class="text-center" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;" rowspan="2">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;">1</th>
                                        <th class="text-center" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;">2</th>
                                        <th class="text-center" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;">3</th>
                                        <th class="text-center" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;">4</th>
                                        <th class="text-center" style="vertical-align: middle; height: 23px; line-height: 23px; padding: 0;">5</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <!-- <input type="radio" name="score1" value="1" checked> -->
                                    <?php
                                    $no = 0;
                                    foreach ($aspek as $aspect):
                                        $no++;  
                                        $selected_score = trim($aspect->score); // Nilai score yang sudah ada
                                        $existing_keterangan = $aspect->desc_aspect;
                                         // Keterangan yang sudah ada
                                    ?>
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle; height: 5px; line-height: 5px;" width="2%"><?php echo $no; ?></td>
                                        <td width="25%" style="vertical-align: middle; height: 5px; line-height: 5px;">
                                            <h5 style="vertical-align: middle; height: 5px; line-height: 5px;"><?php echo $aspect->aspect_question; ?></h5>
                                            <input type="hidden" name="kdaspek<?php echo $no; ?>" value="<?php echo $aspect->kd_aspect; ?>">
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 5px; line-height: 5px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="1" <?php echo ($selected_score == 1) ? 'checked' : '';  ?>>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 5px; line-height: 5px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="2" <?php echo ($selected_score == 2) ? 'checked' : ''; ?>>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 5px; line-height: 5px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="3" <?php echo ($selected_score == 3) ? 'checked' : ''; ?>>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 5px; line-height: 5px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="4" <?php echo ($selected_score == 4) ? 'checked' : ''; ?>>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 5px; line-height: 5px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="5" <?php echo ($selected_score == 5) ? 'checked' : ''; ?>>
                                        </td>
                                        <td style="vertical-align: middle; height: 5px; line-height: 5px;">
                                            <textarea name="keterangan<?php echo $no; ?>" id="keterangan<?php echo $no; ?>" style="width: 100%; resize: none; height: 30px; overflow: hidden;"
                                                class="form-control capital" maxlength="20" oninput="if(this.value.length > 20) this.value = this.value.slice(0, 20);"><?php echo htmlspecialchars($existing_keterangan); ?></textarea>
                                        </td>
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
                    <h4>Kesimpulan</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <p style="color: red; font-weight: bold; margin-bottom: 20px">Mohon untuk dipilih salah satu*</p>
                        
                        <h5 class="text-bold">1. Status kerja Karyawan tersebut</h5>
                        <label for="kes0" style="font-size: 16px;">TIDAK DILANJUTKAN
                            <input type="radio" name="kesimpulan" value="TIDAK DILANJUTKAN" <?php echo ($detail->summary == 'TIDAK DILANJUTKAN') ? 'checked' : ''; ?>>
                        </label>

                        <h5 class="text-bold mt-3">2. Status kerja Karyawan tersebut Dilanjutkan ke tahap</h5>
                        <label for="kes1" style="margin-right: 20px; font-size: 16px;">PKWT
                            <input type="radio" class="me-5" name="kesimpulan" value="PKWT" <?php echo ($detail->summary == 'PKWT') ? 'checked' : ''; ?>>
                        </label>
                        <label for="kes2" style="font-size: 16px;">PKWTT
                            <input type="radio" name="kesimpulan" value="PKWTT" <?php echo ($detail->summary == 'PKWTT') ? 'checked' : ''; ?>>
                        </label>
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
                    <h4>Catatan lain-lain</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <textarea name="catatan" style="width: 100%; resize: none;"
                            class="form-control"><?php echo $detail->description; ?></textarea>
                        <div class="text-center mt-5" style="margin-top: 20px;">
                        <input type="hidden" name="kddok" value="<?php echo $detail->kddok; ?>">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <button type="submit" class="btn-success" style="font-size: 20px; padding: 10px 20px;">Submit Perubahan</button>
                    </div><!-- /.box-body -->
                    <!--FORM PENUTUP-->
                    </form>
                </div><!-- /.box -->
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