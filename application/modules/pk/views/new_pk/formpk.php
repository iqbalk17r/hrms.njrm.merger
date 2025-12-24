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
                        <form action="<?php echo site_url('pk/pk/save_penilaian_karyawanew'); ?>" method="post">
                            <table id="example1" class="table table-bordered table-striped" data-page-length="-1" data-paging="false">
                                <h4>Penilaian Dari Atasan</h4>
                                <p style="color: red; font-weight: bold;">mohon untuk diisi*</p>
                                <thead>
                                    <tr>
                                        <th width="2%" class="text-center" rowspan="2" style="vertical-align: middle;">No.</th>
                                        <th width="25%" class="text-center" style="vertical-align: middle;" rowspan="2">
                                            Aspek yang Dinilai
                                        </th>
                                        <th class="text-center" colspan="5">Skor</th>
                                        <th class="text-center" style="vertical-align: middle;" rowspan="2">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;">1</th>
                                        <th class="text-center" style="vertical-align: middle;">2</th>
                                        <th class="text-center" style="vertical-align: middle;">3</th>
                                        <th class="text-center" style="vertical-align: middle;">4</th>
                                        <th class="text-center" style="vertical-align: middle;">5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($aspek as $aspect):
                                        $no++; ?>
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle; height: 27px;" width="2%"><?php echo $no; ?></td>
                                        <td width="25%" style="vertical-align: middle; height: 27px; line-height: 1.2;">
                                            <h5><?php echo $aspect->aspect_question; ?></h5>
                                        </td>
                                            <input type="hidden" name="kdaspek<?php echo $no; ?>" value="<?php echo $aspect->kd_aspect; ?>">
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 27px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="1" required>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 27px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="2">
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 27px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="3">
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 27px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="4">
                                        </td>
                                        <td class="text-center" style="vertical-align: middle; height: 27px;">
                                            <input type="radio" name="score<?php echo $no; ?>" value="5">
                                        </td>
                                        <td style="height: 27px;">
                                            <textarea name="keterangan<?php echo $no; ?>" id="keterangan<?php echo $no; ?>" style="width: 100%; resize: none; height: 30px; overflow: hidden;"
                                                class="form-control capital" maxlength="20" oninput="if(this.value.length > 20) this.value = this.value.slice(0, 20);"></textarea>
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
                        <p style="color: red; font-weight: bold; margin-bottom: 20px">mohon untuk dipilih salah satu*</p>
                        <h5 class='text-bold'>1. Status kerja Karyawan tersebut</h5>
                        <label for="kes" style="font-size: 16px;">TIDAK DILANJUTKAN
                            <input type="radio" name="kesimpulan" value="TIDAK DILANJUTKAN">
                        </label>
                        <h5 class='text-bold mt-3'>2. Status kerja Karyawan tersebut Dilanjutkan ke tahap</h5>
                        <label for="kes" style="margin-right: 20px; font-size: 16px;">PKWT
                            <input type="radio" class='me-5' name="kesimpulan" value="PKWT">
                        </label>
                        <label for="kes" style="font-size: 16px;">PKWTT
                            <input type="radio" name="kesimpulan" value="PKWTT">
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
                        <textarea name="catatan" id="catatan" style="width: 100%; resize: none;"
                            class="form-control capital"></textarea>
                            <div class="text-center" style="margin-top: 20px;">
                        <input type="hidden" name="nik" value="<?php echo isset($_GET['nik']) ? htmlspecialchars($_GET['nik']) : ''; ?>">
                        <input type="hidden" name="docno" value="<?php echo isset($_GET['docno']) ? htmlspecialchars($_GET['docno']) : ''; ?>">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
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