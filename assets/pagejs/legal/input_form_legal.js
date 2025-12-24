/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 10/21/20, 9:47 AM
 *  * Last Modified: 10/21/20, 9:47 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

function readMaster(id){
    save_method = 'input';
    //Ajax Load data from ajax
    $.ajax({
        url : base('api/legality/read_tmp_master_legality') + '?docno=' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            //var v_nominal = (data.nominal != null ? Math.round(data.nominal.replace(',','.')) : "0");
            //var v_nik = (data.nik != null ? data.nik.trim() : "");
            if(data){
                $('[name="type"]').val('INPUT');
                $('[name="docno"]').val(data.dataread.docno).prop("readonly", true);
                $('[name="coperatorname"]').val(data.dataread.coperatorname);
                $('[name="nmdocname"]').val(data.dataread.nmdocname).prop("readonly", true);
                $('[name="nmstatus"]').val(data.dataread.nmstatus).prop("readonly", true);
                $('[name="nmbu"]').val(data.dataread.nmbux).prop("readonly", true);
                $('[name="docref"]').val(data.dataread.docref);
                $('[name="docrefname"]').val(data.dataread.docrefname);
                $('[name="description"]').val(data.dataread.description);
                // Fetch the preselected item, and add to the control
                var doctypeSelect = $('#doctype');
                $.ajax({
                    type: 'GET',
                    url: base('api/globalmodule/option_trxtype_by_id') + '?var=' + data.dataread.doctype.toString().trim(),
                    dataType: 'json',
                    delay: 250,
                }).then(function (dataX) {
                    // create the option and append to Select2
                    var option = new Option(dataX.items[0].uraian, dataX.items[0].kdtrx, true, true);
                    doctypeSelect.append(option).trigger('change');

                    // manually trigger the `select2:select` event
                    doctypeSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: dataX
                        }
                    });
                });

                // Fetch the preselected item, and add to the control
                var coperatorSelect = $('#coperator');
                $.ajax({
                    type: 'GET',
                    url: base('api/globalmodule/option_mcustomer_by_id') + '?var=' + data.dataread.coperator.toString().trim(),
                    dataType: 'json',
                    delay: 250,
                }).then(function (dataX) {
                    // create the option and append to Select2
                    var option = new Option(dataX.items[0].custname, dataX.items[0].custcode, true, true);
                    coperatorSelect.append(option).trigger('change');

                    // manually trigger the `select2:select` event
                    coperatorSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: dataX
                        }
                    });
                });

                // Fetch the preselected item, and add to the control
                var idbuSelect = $('#idbu');
                $.ajax({
                    type: 'GET',
                    url: base('api/globalmodule/option_idbu_by_id') + '?var=' + data.dataread.idbu.toString().trim(),
                    dataType: 'json',
                    delay: 250,
                }).then(function (dataX) {
                    // create the option and append to Select2
                    var option = new Option(dataX.items[0].desc_cabang, dataX.items[0].kdcabang, true, true);
                    idbuSelect.append(option).trigger('change');

                    // manually trigger the `select2:select` event
                    idbuSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: dataX
                        }
                    });
                });
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

var save_method; //for save method string
var table;
var editor;
function DatatableEditor(){
    // var lg = languageDatatable;
    var initTableEditor = function () {
        var idsesi = $('#docno').val().trim();
        var table = $('#dtEditor');
        table.DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "language":  languageDatatable(),
            "ajax": {
                "url": base('api/legality/loadTmpLegalDetail'),
                "type": "POST",
                "dataFilter": function(data) {
                    var json = jQuery.parseJSON(data);
                    json.draw = json.dataTables.draw;
                    json.recordsTotal = json.dataTables.recordsTotal;
                    json.recordsFiltered = json.dataTables.recordsFiltered;
                    json.data = json.dataTables.data;

                    var hidden = json.dataTables.recordsTotal;
                    console.log(hidden);
                    if (hidden > 0) {
                        $('.insv').prop("disabled",true);
                        document.getElementById('btnSave').style.visibility = 'hidden';
                        document.getElementById('finaldata').style.visibility = 'visible';
                        console.log('btnSave Hidden');
                    } else {
                        $('.insv').prop("disabled",false);
                        document.getElementById('btnSave').style.visibility = 'visible';
                        document.getElementById('finaldata').style.visibility = 'hidden';
                        console.log('btnSave not Hidden');
                    }
                    return JSON.stringify(json); // return JSON string
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
                {
                    width: '75px',
                    targets: -4,
                    render: function(data, type, full, meta) {
                        var nmoperationcategory = {
                            NEGOSIASI: {'title': 'NEGOSIASI', 'class': ' badge badge-success'},
                            KLARIFIKASI: {'title': 'KLARIFIKASI', 'class': ' badge badge-primary'},
                            SP1: {'title': 'SP1', 'class': ' badge badge-danger'},
                            SP2: {'title': 'SP2', 'class': ' label-light-danger'},
                            SP3: {'title': 'SP3', 'class': ' label-light-danger'},
                            SOMASI: {'title': 'SOMASI', 'class': ' badge badge-warning'},
                        };
                        if (typeof nmoperationcategory[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="label label-lg font-weight-bold' + nmoperationcategory[data].class + ' label-inline">' + nmoperationcategory[data].title + '</span>';
                    },
                },
            ],
        });

        //alert("CONTOL SINGA xx");
        //console.log("BASEURL" + base('assets/cok') );
        //console.log("SITE" + site('assets/cok'));

        /* console.log("DatatableEditor Is RUnning");
         editor = new $.fn.DataTable.Editor( {
             ajax: base('api/legality/loadTmpLegalDetail') + '?docno=' + idsesi,
             table: "#dtEditor",
             template: "#customForm",
             fields: [ {
                 label: "Dokumen Number:",
                 name: "docno"
             }, {
                 label: "Date Operation:",
                 name: "dateoperation"
             }
             ]
         } );*/


        /*$('#dtEditor').DataTable( {
            dom: "Bfrtip",
            ajax: base('api/legality/loadTmpLegalDetail') + '?docno=' + idsesi,
            columns: [
                { data: null, render: function ( data, type, row ) {
                        // Combine the first and last names into a single table field
                        return data.first_name+' '+data.last_name;
                    } },
                { data: "position" },
                { data: "office" },
                { data: "extn" },
                { data: "start_date" },
                { data: "salary", render: $.fn.DataTable.render.number( ',', '.', 0, '$' ) }
            ],
            select: false,
            buttons: [
                /!*{ extend: "create", editor: editor },
                { extend: "remove", editor: editor }*!/
            ]
        } );*/

    }
    return initTableEditor();
}

function ValidasiForm(){
    /* $('#form').bootstrapValidator({
         message: 'This value is not valid',
         feedbackIcons: {
             valid: 'glyphicon glyphicon-ok',
             invalid: 'glyphicon glyphicon-remove',
             validating: 'glyphicon glyphicon-refresh'
         },
         excluded: [':disabled']

     });*/

   // $("input:text").focus(function() { $(this).select(); } );
    $('#form').bootstrapValidator({
        live: 'disabled',
        message: 'Nilai tidak valid',
        cache: false,
        feedbackIcons: {
            valid: 'fa fa-check-circle',
            invalid: 'fa fa-times-circle',
            validating: 'fa fa-spell-check'
        },
        excluded: [':disabled'],
        fields: {
            docno: {
                validators: {
                    notEmpty: {
                        message: 'Tidak Boleh Kosong'
                    }
                }
            },
            doctype: {
                validators: {
                    notEmpty: {
                        message: 'Tidak Boleh Kosong'
                    }
                }
            },
            coperator: {
                validators: {
                    notEmpty: {
                        message: 'Tidak Boleh Kosong'
                    }
                }
            },
            idbu: {
                validators: {
                    notEmpty: {
                        message: 'Tidak Boleh Kosong'
                    }
                }
            },
            docrefname: {
                validators: {
                    notEmpty: {
                        message: 'Tidak Boleh Kosong'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'Tidak Boleh Kosong'
                    }
                }
            },
        }
    });

}

function save()
{
    var save_method; //for save method string
    var validator = $('#form').data('bootstrapValidator');
    validator.validate();
    //console.log( validator.isValid());

    if (validator.isValid())
    {
        $.ajax({
            url : base('api/legality/save_initialize_master'),
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                $('[name="type"]').val('EDIT');
                $('[name="docno"]').val(data.dataread.docno).prop("readonly", true);
                $('[name="docref"]').val(data.dataread.docref);
                $('[name="docrefname"]').val(data.dataread.docrefname);

                if ($('[name="coperator"]').val()==='OTHER') {
                    $('[name="coperatorname"]').val(data.dataread.coperatorname).prop("readonly", false);
                } else {
                    $('[name="coperatorname"]').val(data.dataread.coperatorname).prop("readonly", true);
                }

                $('[name="nmdocname"]').val(data.dataread.nmdocname);
                $('[name="nmstatus"]').val(data.dataread.nmstatus);
                $('[name="nmbu"]').val(data.dataread.nmbux);
                $('[name="description"]').val(data.dataread.description);

                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Failed To Loading Data");
            }
        });
        console.log("Test !!" + validator.isValid())
    } else {
        console.log("Ada data yang belum terpenuhi !!"+ validator.isValid());
    }
}



function savedet()
{
   // alert("show Save Detail");
        var fd = new FormData(document.getElementById('formdetail'));
        var files = $('#attachment')[0].files;

        // Check file selected or not
        //if(files.length > 0 ){
            fd.append('file',files[0]);

            $.ajax({
                url: base('api/legality/save_initialize_detail'),
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(response){
                   // fd.reset();
                    //console.log(response.status + " JANCOK")
                    if(response.status === true){
                        $('#modal-lg-detail').modal('hide');
                        reload_table();
                    } else {
                        alert("Gagal menyimpan dokumen, silahkan cek input");
                    }

                },
            });
         //   console.log("saveDetail");
        // }else{
        //     alert("Please select a file.");
        // }
}

function deleteDetail()
{
    // alert("show Save Detail");
    var fd = new FormData(document.getElementById('formdetail'));
    var files = $('#attachment')[0].files;

    // Check file selected or not
    if(files.length > 0 ){
        fd.append('file',files[0]);

        $.ajax({
            url: base('api/legality/save_initialize_detail'),
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(response){
                // fd.reset();
                //console.log(response.status + " JANCOK")
                if(response.status === true){
                    $('#modal-lg-detail').modal('hide');
                    reload_table();
                } else {
                    alert("Gagal menyimpan dokumen, silahkan cek input");
                }

            },
        });
        console.log("saveDetail");
    }else{
        alert("Please select a file.");
    }
}

function reload_table()
{
    var table = $('#dtEditor');
    table.DataTable().ajax.reload(); //reload datatable ajax


}

function detailLegalInput(docno,id) {
    console.log(docno + ' KONTIL ' + id);
    $('#modal-lg-detail').modal('show');

    //$('[name="docno"]').val(response.data.docno);
    //$('[name="docref"]').val(response.data.docref);
    //$('[name="dateoperation"]').val(response.data.dateoperation);
    $('[name="type"]').val('INPUT').prop("readonly",true);
    $('[name="operationcategory"]').val('').prop("disabled",false);
    $('[name="dateoperation"]').val('').prop("disabled",false);
    $('[name="progress"]').val('').prop("readonly",false);;
    $('[name="attachment"]').prop("disabled",false);
    $('#saveDetail').show();
    $('#finalDetail').hide();
    $('#deleteDetail').hide()
}

function detailLegalApprove(docno,id,type) {
    console.log(docno + ' KONTIL ' +  type);
    $('#saveDetail').hide();
    $('#finalDetail').hide();
    $('#deleteDetail').hide();
    $('#modal-lg-detail').modal('show');


    $.ajax({
        url : base('api/legality/check_tmp_legal_detail') + '?docno=' + docno + '&id=' + id  ,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
            $('[name="type"]').val(type).prop("readonly",true);
            $('[name="docno"]').val(response.data.docno).prop("readonly",true);
            $('[name="sort"]').val(response.data.sort).prop("readonly",true);
            $('[name="docref"]').val(response.data.docref).prop("readonly",true);
            $('[name="dateoperation"]').val(response.data.dateoperation).prop("disabled",true);
            var operationcategorySelect = $('#operationcategory').prop("disabled",true);
            $.ajax({
                type: 'GET',
                url: base('api/globalmodule/option_trxtype_ktg_by_id') + '?var=' + response.data.operationcategory.toString().trim(),
                dataType: 'json',
                delay: 250,
            }).then(function (dataX) {
                // create the option and append to Select2
                var option = new Option(dataX.items[0].uraian, dataX.items[0].kdtrx, true, true);
                operationcategorySelect.append(option).trigger('change');

                // manually trigger the `select2:select` event
                operationcategorySelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: dataX
                    }
                });
            });
            $('[name="progress"]').val(response.data.progress).prop("readonly",true);;
            $('[name="attachment"]').val(response.data.attachment).prop("disabled",true);
            if (type==='FINAL'){
                $('#saveDetail').hide();
                $('#finalDetail').show();
                $('#deleteDetail').hide();
            } else if (type==='DELETE') {
                $('#saveDetail').hide();
                $('#finalDetail').hide();
                $('#deleteDetail').show();
            } else {
                $('#saveDetail').hide();
                $('#finalDetail').hide();
                $('#deleteDetail').hide();
            }

            console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log("Failed To Loading Data");
        }
    });
}



/*

var defaultInitial = " and jenistrx='I.D.A.1_TYPE'";
$("#doctype").select2({
    placeholder: "Pilih Type",
    allowClear: true,
    ajax: {
        url: base('api/globalmodule/list_trxtype'),
        type: 'POST',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                _search_: params.term, // search term
                _page_: params.page,
                _draw_: true,
                _start_: 1,
                _perpage_: 2,
                _paramglobal_: 'defaultInitial',
            };
        },
        processResults: function(data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function(markup) {
        return markup;
    }, // let our custom formatter work
    minimumInputLength: 0,
    templateResult: formatRepo, // omitted for brevity, see the source of this page
    templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
});


function formatRepo(repo) {
    if (repo.loading) return repo.text;
    var markup = "<div class='select2-result-repository__title'>" + repo.kdtrx + "</div>";
  /!*  if (repo.uraian) {
        markup += "<div class='select2-result-repository__description'>" + repo.uraian + "</div>";
    }*!/
    return markup;
}

function formatRepoSelection(repo) {
    return repo.kdtrx || repo.text;
}
*/

/* DOKUMEN TYPE */
    var defaultInitial = " and jenistrx='I.D.A.1_TYPE'";
    $("#doctype").select2({
        placeholder: "Pilih Dokumen Type",
        allowClear: true,
        ajax: {
            url: base('api/globalmodule/option_trxtype'),
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _search_: params.term, // search term
                    _page_: params.page,
                    _draw_: true,
                    _start_: 1,
                    _perpage_: 2,
                    _paramglobal_: defaultInitial,
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 0,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    }).on('change click', function() {
        // console.log('coperator >> on.change');
       // $('#coperator').val(null).trigger('change');
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository__title'>" + repo.kdtrx + " || " + repo.uraian + "</div>";
        return markup;
    }
    function formatRepoSelection(repo) {
        return repo.uraian || repo.text;
    }


/* NAMA OPERATOR */
    var defaultInitialCoperator = " ";
    $("#coperator").select2({
        placeholder: "Pilih Pelanggan",
        allowClear: true,
        ajax: {
            url: base('api/globalmodule/option_mcustomer'),
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _search_: params.term, // search term
                    _page_: params.page,
                    _draw_: true,
                    _start_: 1,
                    _perpage_: 2,
                    _paramglobal_: defaultInitialCoperator,
                    _buildInitiator_: defaultInitialCoperator,
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 0,
        templateResult: formatRepoCoperator,
        templateSelection: formatRepoSelectionCoperator
    });
    function formatRepoCoperator(repo) {
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository__title'>" + repo.custcode + " || " + repo.custname + "</div>";
        return markup;
    }
    function formatRepoSelectionCoperator(repo) {
        return repo.custname || repo.text;
    }

$('#coperator').on('change click', function() {

    console.log('OPERATOR ON CLICK' + $(this).val());
    if ($(this).val().trim()==='OTHER') {
        $('[name="coperatorname"]').prop("readonly", false);
    } else {
        $('[name="coperatorname"]').prop("readonly", true);
    }
});
/* NANTI BUAT SELEKSI
    $("#coperator").on('change click', function() {
        var buildInitiator =  $('#doctype').val();

        console.log(buildInitiator);
        if (buildInitiator==='PA') {
            $("#coperator").select2({
                placeholder: "Pilih Terlapor",
                allowClear: true,
                ajax: {
                    url: base('api/globalmodule/option_mcustomer'),
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            _search_: params.term, // search term
                            _page_: params.page,
                            _draw_: true,
                            _start_: 1,
                            _perpage_: 2,
                            _paramglobal_: defaultInitialCoperator,
                            _buildInitiator_: defaultInitialCoperator,
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: false
                },
                escapeMarkup: function(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 0,
                templateResult: formatRepoCoperator,
                templateSelection: formatRepoSelectionCoperator
            });
            function formatRepoCoperator(repo) {
                if (repo.loading) return repo.text;
                var markup = "<div class='select2-result-repository__title'>" + repo.custcode + " || " + repo.custname + "</div>";
                return markup;
            }
            function formatRepoSelectionCoperator(repo) {
                return repo.custname || repo.text;
            }
        } else if (buildInitiator==='PI') {
            function formatRepoCoperator(repo) {
                if (repo.loading) return repo.text;
                var markup = "<div class='select2-result-repository__title'>" + repo.custcode + " || " + repo.custname + "</div>";
                return markup;
            }
            function formatRepoSelectionCoperator(repo) {
                return repo.custname || repo.text;
            }
        }
    });*/




/* PILIH WILAYAH */
    var defaultInitialIdbu = " ";
    $("#idbu").select2({
        placeholder: "Pilih Wilayah",
        allowClear: true,
        ajax: {
            url: base('api/globalmodule/option_idbu'),
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _search_: params.term, // search term
                    _page_: params.page,
                    _draw_: true,
                    _start_: 1,
                    _perpage_: 2,
                    _paramglobal_: defaultInitialCoperator,
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 0,
        templateResult: formatRepoidbu,
        templateSelection: formatRepoSelectionidbu
    });
    function formatRepoidbu(repo) {
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository__title'>" + repo.id + " || " + repo.desc_cabang + "</div>";
        return markup;
    }
    function formatRepoSelectionidbu(repo) {
        return repo.desc_cabang || repo.text;
    }

/* START KATEGORI PENANGANAN */
var defaultInitialOperationCategory = " and jenistrx='I.D.A.1_KTG'";
$("#operationcategory").select2({
    placeholder: "Pilih Dokumen Kategori Penanganan",
    allowClear: true,
    ajax: {
        url: base('api/globalmodule/option_trxtype'),
        type: 'POST',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                _search_: params.term, // search term
                _page_: params.page,
                _draw_: true,
                _start_: 1,
                _perpage_: 2,
                _paramglobal_: defaultInitialOperationCategory,
            };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function(markup) {
        return markup;
    }, // let our custom formatter work
    minimumInputLength: 0,
    templateResult: formatRepoOperationCategory,
    templateSelection: formatRepoSelectionOperationCategory
});

function formatRepoOperationCategory(repo) {
    if (repo.loading) return repo.text;
    var markup = "<div class='select2-result-repository__title'>" + repo.kdtrx + " || " + repo.uraian + "</div>";
    return markup;
}
function formatRepoSelectionOperationCategory(repo) {
    return repo.uraian || repo.text;
}

/* END KATEGORI PENANGANAN */


function finalisasi_entry(){

    var url= base('api/legality/finalisasi_entry');
    var confirmText = "Data akan di proses, Ada yakin ?";
    if(confirm(confirmText)) {
        $('#finaldata').prop('disabled',true);
        console.log('HOI JANCOK');

        $.ajax({
            type:"GET",
            dataType: 'json',
            url:url,
            success:function (data) {
                // Here goes something...
                if (data.status){
                    alert(data.messages);
                    // In iFrame
                    //window.parent.triggerCompleteParent();
                    window.parent.$('#fortriggerframe').trigger('click');
                    $('#finaldata').prop('disabled',false);
                } else {
                    alert(data.messages);
                    $('#finaldata').prop('disabled',false);
                }
                console.log('DATA ENTRY KOMPLIT');
            },
        });
    }
    return false;
}

$(document).ready(function() {

    /*$('#dateoperation').daterangepicker({
        singleDatePicker:true,
        locale: {
            format: 'dd-mm-YYYY'
        }
    })*/
    var valueToScroll = 80;
    $(".card").scrollTop(valueToScroll);

//With animation

    $(".card").animate({ scrollTop: valueToScroll }, { duration: 200 } );
    $('#dateoperation').daterangepicker({
        singleDatePicker:true,
        showDropdowns: true,
        timePicker: false,
        timePicker24Hour: false,
        startDate: moment().add(0, 'day'),
        minDate: moment(),
        locale: {
            //format: 'DD-MM-YYYY H:mm'
            format: 'DD-MM-YYYY'
        }
    });
    bsCustomFileInput.init();
    DatatableEditor();
    ValidasiForm();
    readMaster();
    //pilihDokumenType();
    //pilihCoperator();

    $('.intl').change(function () {
        /*$.ajax({
            url : base('api/legality/save_initialize_master'),
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                // var v_nominal = (data.nominal != null ? Math.round(data.nominal.replace(',','.')) : "0");
                // var v_nik = (data.nik != null ? data.nik.trim() : "");

                // $('[name="type"]').val('EDIT');
                // $('[name="docno"]').val(data.dataread.docno).prop("readonly", true);
                // $('[name="docref"]').val(data.dataread.docref);
                // $('[name="docrefname"]').val(data.dataread.docrefname);

                if ($('[name="coperator"]').val()==='OTHER') {
                    $('[name="coperatorname"]').val(data.dataread.coperatorname).prop("readonly", false);
                } else {
                    $('[name="coperatorname"]').val(data.dataread.coperatorname).prop("readonly", true);
                }

                $('[name="nmdocname"]').val(data.dataread.nmdocname);
                $('[name="nmstatus"]').val(data.dataread.nmstatus);
                $('[name="nmbu"]').val(data.dataread.nmbux);

                console.log($('[name="coperator"]').val());
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Failed To Loading Data");
            }
        });*/

    });



});
/*

$(function() {
    DatatableLegal();
});*/
