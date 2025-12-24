/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 10/21/20, 9:47 AM
 *  * Last Modified: 10/21/20, 9:47 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

var save_method; //for save method string
var table;
"use strict";
function DatatableLegal(){
  // var lg = languageDatatable;
   var initTable = function () {
       var table = $('#legalDatatable');
       table.DataTable({
           "processing": true, //Feature control the processing indicator.
           "serverSide": true, //Feature control DataTables' server-side processing mode.
           "order": [], //Initial no order.
           "language":  languageDatatable(),
           "ajax": {
               "url": base('api/legality/reportlistDatatable'),
               "type": "POST",
               "data": function(data) {
                   data.tglrange = $('#tglrange').val();
                   data.fcoperator = $('#fcoperator').val();
               },
               "dataFilter": function(data) {
               var json = jQuery.parseJSON(data);
               json.draw = json.dataTables.draw;
               json.recordsTotal = json.dataTables.recordsTotal;
               json.recordsFiltered = json.dataTables.recordsFiltered;
               json.data = json.dataTables.data;
               return JSON.stringify(json); // return JSON string
           }
       },

       //Set column definition initialisation properties.
       "columnDefs": [
           {
               "targets": [ -1 ], //last column
               "orderable": false, //set not orderable
           },
       ],
       });

       //alert("CONTOL SINGA xx");
       //console.log("BASEURL" + base('assets/cok') );
       //console.log("SITE" + site('assets/cok'));


   }
    return initTable();
}



function reload_table()
{
    var table = $('#dtSBY');
    table.DataTable().ajax.reload(); //reload datatable ajax


}


/* NAMA OPERATOR */
var defaultInitialCoperator = " ";
$("#fcoperator").select2({
    theme: "bootstrap",
    width: 'auto',
    dropdownAutoWidth: true,
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


jQuery(document).ready(function() {
    $('#btn-filter').click(function(){ //button filter event click
        reload_table();
        $('#filter').modal('hide');
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        $('#idbu').val(null).trigger('change');
        reload_table();
        $('#filter').modal('hide');
    });

    //Date range picker
    $("#tgl").datepicker();
    $(".tglan").datepicker();
    $(".tglrange").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(".tglrange").on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
    });

    $(".tglrange").on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('#dtSBY').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
        "scrollX": true,
        "pageLength": 15,
        "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],
        "language":  languageDatatable(),
        "ajax": {
            "url": base('api/legality/reportlistDatatable'),
            "type": "POST",
            "data": function(data) {
                data.idbu = $('#idbu').val();
            },
            "dataFilter": function(data) {
                var json = jQuery.parseJSON(data);
                json.draw = json.dataTables.draw;
                json.recordsTotal = json.dataTables.recordsTotal;
                json.recordsFiltered = json.dataTables.recordsFiltered;
                json.data = json.dataTables.data;
                return JSON.stringify(json); // return JSON string
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
                "width": "100px"
            },
            { "width": "1%", "targets": 0 },
            { "width": "75px", "targets": 1 },
            { "width": "75px", "targets": 2 },
            { "width": "75px", "targets": 3 },
            { "width": "65px", "targets": 4 },
            { "width": "65px", "targets": 5 },
            { "width": "65px", "targets": 6 },
            { "width": "65px", "targets": 7 },
            { "width": "65px", "targets": 8 },
            { "width": "65px", "targets": 9 },
            { "width": "50px", "targets": 10 },
        ],

    });


    $('#dtSMG').DataTable({
        responsive: true,
        scrollX: true,
        pageLength: 5,
        lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language:  languageDatatable(),
    });
    $('#dtDMK').DataTable({
        responsive: true,
        scrollX: true,
        pageLength: 5,
        lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language:  languageDatatable(),
    });
    $('#dtNAS').DataTable({
        responsive: true,
        scrollX: true,
        pageLength: 5,
        lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language:  languageDatatable(),
    });
    $('#dtSKH').DataTable({
        responsive: true,
        scrollX: true,
        pageLength: 5,
        lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language:  languageDatatable(),
    });
    $('#dtJOG').DataTable({
        responsive: true,
        scrollX: true,
        pageLength: 5,
        lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language:  languageDatatable(),
    });
    $('#dtJKT').DataTable({
        responsive: true,
        scrollX: true,
        pageLength: 5,
        lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language:  languageDatatable(),
    });
});

/*
$(function() {
    DatatableLegal();
});*/
