<?php //echo $highchart->kpi->series; die();?>

<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;

        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
    .ml-3{
        margin-left: 3px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <center><h3 class="box-title text-center">Informasi Karyawan</h3></center>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>

                </div>
                <?php 
                date_default_timezone_set('Asia/Jakarta');
                //print_r($default); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->nik ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->nmlengkap ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Sub departemen</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->nmsubdept ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->nmjabatan ?>">
                                </div>
                            </div>
                            <?php if ($default->employee->nik_atasan == $default->employee->nik_atasan2 ){ ?>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Atasan</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->nmatasan ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                 <label for="staticEmail" class="col-sm-2 col-form-label">Status PTKP</label>
                                 <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->employee->status_ptkp) ?>">
                                </div>
                                </div>
                                <div class="form-group row">
                                 <label for="staticEmail" class="col-sm-2 col-form-label">Kantor Wilayah</label>
                                 <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->kanwil) ?>">
                                </div>
                              </div>
                            <?php }else{ ?>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Atasan 1</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->nmatasan ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Atasan 2</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->nmatasan2 ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                 <label for="staticEmail" class="col-sm-2 col-form-label">Status PTKP</label>
                                 <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->employee->status_ptkp) ?>">
                                </div>
                                </div>
                                <div class="form-group row">
                                 <label for="staticEmail" class="col-sm-2 col-form-label">Kantor Wilayah</label>
                                 <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->kanwil) ?>">
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                        <div class="col-md-6">
                            <!-- <?php //print_r($default); ?> -->
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Status Kontrak</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->contract->nmkepegawaian ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">No. Kontrak</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->contract->kdkepegawaian == 'KT') ? '-' : $default->contract->nodok; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Periode Kontrak</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->contract->kdkepegawaian =='KT') ? '' : $default->contract->period ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Sisa Cuti</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $default->employee->sisacuti ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Batas Cuti</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->contract->leave_limit) ?>">
                                </div>
                            </div>
                       
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Status SP</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->datasp->enddate <= strtotime(date('d-m-Y')) ? $default->datasp->docname : '-'); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Periode SP</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo ($default->datasp->enddate <= strtotime(date('d-m-Y')) ? ($default->periodesp) : '-' )  ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Masa Kerja</label>
                                   <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php 
                                        $kta_awal = array('years','year','mons','mon','days','day');
                                        $kta_akhir = array('tahun','tahun','bulan','bulan','hari','hari');
                                        $pesan= str_replace($kta_awal,$kta_akhir,($default->masakerja)); echo $pesan  ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <center><h3 class="box-title">Kondite</h3></center>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool refresh" data-action="conditee" title="Perbarui data" onclick="refreshData('conditee')"><i class="fa fa-refresh"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>

                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>Tipe Grafik</label>
                        <select name="conditee" class="form-control">
                            <?php foreach ($highchart->chartTypes as $index => $chartType) {
                                echo '<option value="'.$chartType.'">'.$chartType.'</option>';
                            } ?>
                        </select>
                    </div>
                    <figure class="highcharts-figure">
                        <div id="conditee"></div>
                    </figure>
                </div>
                <div class="box-footer">
                    <a href="<?php echo $url->conditee ?>" class="btn btn-sm btn-success bg-light-danger pull-right">SELENGKAPNYA</a>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <center><h3 class="box-title">KPI</h3></center>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool refresh" data-action="kpi" title="Perbarui data"><i class="fa fa-refresh"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>

                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label>Tipe Grafik</label>
                        <select name="kpi" class="form-control">
                            <?php foreach ($highchart->chartTypes as $index => $chartType) {
                                echo '<option value="'.$chartType.'">'.$chartType.'</option>';
                            } ?>
                        </select>
                    </div>
                    <figure class="highcharts-figure">
                        <div id="kpi"></div>
                    </figure>
                </div>
                <div class="box-footer">
                    <a href="<?php echo $url->kpi ?>" class="btn btn-sm btn-success bg-light-danger pull-right">SELENGKAPNYA</a>
                </div>

            </div>
        </div>
         <!-- tabel sp -->
          <!-- <?php //var_dump($leveljbt);
            //die(); ?> -->
        <script>console.log('leveljbt: <?php echo $leveljbt; ?>');</script>
        <?php if (!in_array($leveljbt, ['D', 'E', 'F', 'G'])): ?>
            <div class="col-md-12">
                <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <center><h3 class="box-title">Daftar Penilaian Karyawan</h3></center>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool refresh" data-action="conditee" title="Perbarui data" onclick="refreshData('conditee')"><i class="fa fa-refresh"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    </div>

                </div>

                <div class="box-body">
                    <div class="table-responsive">
                    <table id="t_pk" class="display nowrap table table-striped no-margin" style="width:100%">
                        <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th width="10%">NIK</th>
                            <th width="10%">Nama</th>
                            <th width="5%">Bagian</th>
                            <th width="5%">Jenis</th>
                            <th width="10%">Akhir</th>
                            <th width="10%">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_pk as $k => $v):?>
                            <tr>
                            <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                            <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                            <td><?php echo trim($v->nmlengkap);?></td>
                            <td><?php echo trim($v->nmdept);?></td>
                            <td><?php echo trim($v->nmkepegawaian);?></td>
                            <td><?php echo trim($v->tgl_selesai1);?></td>
                            <td><?php echo empty($v->deskappr) ? 'BELUM DINILAI' : $v->deskappr; ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Modal Edit / Detail-->
<div class="modal fade" id="modify-data" data-backdrop="static" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true"></div>
<script>
    var conditee;
    var kpi;
    var ConditeeChartComponent; // Declare globally
    var KpiChartComponent; // Declare globally
    function loadmodal(url) {
        $('div#modify-data')
            .empty()
            .load(url, {}, function (response, status, xhr) {
                if (status === 'error') {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success m-1',
                            cancelButton: 'btn btn-sm btn-warning m-1',
                            denyButton: 'btn btn-sm btn-danger m-1',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Gagal Memuat Detail',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                } else {
                    Swal.close()
                    $('div#modify-data').modal('show');
                }
            });
    }

    function getData(){
            $.getJSON('<?php echo site_url('dashboard/seriesData') ?>', {
                type: 'dashboard'
            })
                .done(function(data) {
                    console.log("API response received:", data); // Log the JSON response to the console
                    ConditeeChartComponent.setDataSeriesFromApi(data);
                    ConditeeChartComponent.updateChart();
                    $('select[name=\'conditee\']').prop("disabled", false);
                    ConditeeChartComponent.updateChartType($('select[name=\'conditee\']').val());
                    KpiChartComponent.setDataSeriesFromApi(data);
                    KpiChartComponent.updateChart();
                    $('select[name=\'kpi\']').prop("disabled", false);
                    KpiChartComponent.updateChartType($('select[name=\'kpi\']').val());
                })
                .fail(function(xhr, status, thrown) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-default ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Gagal Memuat Data',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr
                            .statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function() {});
                });
        }

    function refreshData(action) {
        if (typeof ConditeeChartComponent === 'undefined' || typeof KpiChartComponent === 'undefined') {
            console.error('Chart components are not initialized. Please ensure they are initialized before calling refreshData.');
            return;
        }
        if (action === 'conditee') {
            getData();
        } else if (action === 'kpi') {
            getData();
        } else {
            console.error('Action is invalid:', action);
        }
    }

    $( document ).ready(function() {

        $('table#table-document-list tbody').on('click', 'td a.popupv3', function () {
            var row = $(this);
            $.getJSON(row.attr('data-href'), {
                type: 'dashboard'
            })
                .done(function(data) {
                    window.location.href = data.next
                })
                .fail(function(xhr, status, thrown) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-default ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Gagal Memuat Status',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr
                            .statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function() {});
                });
        });
        $('table#table-document-list tbody').on('click', 'td a.popupv2', function () {
            var row = $(this);
            Swal.fire({
                icon: 'info',
                position:'middle',
                title: "Harap tunggu data sedang di proses, jangan tutup halaman ini",
                allowEscapeKey: false,
                allowOutsideClick:false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            loadmodal(row.data('href'))
        })

        $('select[name=\'conditee\']').select2().on('change', function(){
            if($(this).val() != null){
                ConditeeChartComponent.updateChartType($(this).val())
            }
        })
        $('select[name=\'kpi\']').select2().on('change', function(){
            if($(this).val() != null){
                KpiChartComponent.updateChartType($(this).val())
            }
        })
        ConditeeChartComponent = {
            initHighcharts: function() {
                this.chart = new Highcharts.Chart({
                    credits: {
                        enabled: false
                    },
                    chart: {
                        renderTo : 'conditee',
                        type: 'column'
                    },
                    title: {
                        align: 'center',
                        text: 'Kondite <?php echo addslashes(ucwords(strtolower($default->employee->nmlengkap.' '.$default->period))) ?>'
                    },
                    subtitle: {
                        align: 'left',
                        // text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        crosshair: true,
                        type: 'category',
                        labels: {
                            style: {
                                fontSize:12,
                            }
                        },
                    },
                    yAxis: {
                        crosshair: true,
                        title: {
                            text: 'Total poin'
                        },
                        labels: {
                            style: {
                                fontSize:12
                            }
                        },

                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                        enabled: true,
                        formatter: function() {
                            if (typeof this.point !== "undefined" && this.point.drilldown) {
                                return '<span style="font-size:12px">' + this.y.toFixed(2) + '</span>';
                            } else {
                                return '<span style="font-size:12px">' + this.y + '</span>';
                            }
                        }
                    }
                        }
                    },


                    tooltip: {
                        headerFormat: '<span style="font-size:16px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color};font-size:14px">{point.name}:</span> <b style="font-size:14px">{point.y:.0f}</b><br/>'
                    },

                    drilldown: {
                        breadcrumbs: {
                            position: {
                                align: 'right'
                            }
                        },
                        series:<?php echo $highchart->conditee->drilldown ?>
                    },
                    series: []
                });
                this.chart.showLoading();
            },
            setDataSeriesFromApi: function(data) {
                this.dataSeriesFromApi = [{
                    name: 'Kondite',
                    id: 'conditeeSeries',
                    colorByPoint: false,
                    data : data.highchart.conditee.series
                }]
            },
            updateChart: function() {
                while (this.chart.series.length > 0) {
                    this.chart.series[0].remove();
                }
                this.dataSeriesFromApi.forEach(function(serie) {
                    this.chart.addSeries(serie, false);
                }.bind(this));
                this.chart.redraw();
                this.chart.hideLoading();
            },
            updateChartType: function(selectedType) {
                this.chart.series[0].update({
                    type: selectedType
                });
            },
        }
        KpiChartComponent = {
            initHighcharts: function() {
                this.chart = new Highcharts.Chart({
                    credits: {
                        enabled: false
                    },
                    chart: {
                        renderTo : 'kpi',
                        type: 'column'
                    },
                    title: {
                        align: 'center',
                        text: 'KPI <?php echo addslashes(ucwords(strtolower($default->employee->nmlengkap.' '.$default->period))) ?>'
                    },
                    subtitle: {
                        align: 'left',
                        // text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            style: {
                                fontSize:12
                            }
                        },
                    },
                    yAxis: {
                        title: {
                            text: 'Total poin'
                        },
                        labels: {
                            style: {
                                fontSize:12
                            }
                        },
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '<span style="font-size:10px">{point.y:.2f}</span>'
                            }
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:16px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color};font-size:14px">{point.name}:</span> <b style="font-size:14px">{point.y:.2f}</b><br/>'
                    },

                    series: [],
                });
                this.chart.showLoading();
            },
            setDataSeriesFromApi: function(data) {
                this.dataSeriesFromApi = [{
                    name: 'KPI',
                    id: 'kpiSeries',
                    colorByPoint: false,
                    data : data.highchart.kpi.series
                }]
            },
            updateChart: function() {
                while (this.chart.series.length > 0) {
                    this.chart.series[0].remove();
                }
                this.dataSeriesFromApi.forEach(function(serie) {
                    this.chart.addSeries(serie, false);
                }.bind(this));
                this.chart.redraw();
                this.chart.hideLoading();
            },
            updateChartType: function(selectedType) {
                this.chart.series[0].update({
                    type: selectedType
                });
            },
        }
        ConditeeChartComponent.initHighcharts();
        KpiChartComponent.initHighcharts();
        $('select[name=\'conditee\']').prop("disabled", true);
        $('select[name=\'kpi\']').prop("disabled", true);

        function getData(){
            $.getJSON('<?php echo site_url('dashboard/seriesData') ?>', {
                type: 'dashboard'
            })
                .done(function(data) {
                    console.log("API response received:", data); // Log the JSON response to the console
                    ConditeeChartComponent.setDataSeriesFromApi(data);
                    ConditeeChartComponent.updateChart();
                    $('select[name=\'conditee\']').prop("disabled", false);
                    ConditeeChartComponent.updateChartType($('select[name=\'conditee\']').val());
                    KpiChartComponent.setDataSeriesFromApi(data);
                    KpiChartComponent.updateChart();
                    $('select[name=\'kpi\']').prop("disabled", false);
                    KpiChartComponent.updateChartType($('select[name=\'kpi\']').val());
                })
                .fail(function(xhr, status, thrown) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-default ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Gagal Memuat Data',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr
                            .statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function() {});
                });
        }
        getData();
        setInterval(function() {
            getData();
        }, 1800000); // 30 minutes in milliseconds
    });

</script>
