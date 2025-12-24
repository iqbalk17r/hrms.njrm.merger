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
               "url": base('api/legality/listDatatable'),
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

function loadModal()
{

    var $modal = $('.lod');
    var ada = $('#cektmplegal').val();

    if (ada>0){
        $modal.find('iframe').attr('src',base('legal/legality/input_form_legal'));
        $modal.modal({show:true});
    } else {
        $modal.modal({show:false});
    }

    function triggerCompleteParent () {
        var $modal = $('.lod');
        $modal.modal({show:false});
        location.replace(base('api/legality/form_legal'));
        //$(document).trigger('complete');
        console.log("triggerCompleteParent");
    }

    $('#fortriggerframe').on('click', function () {
        location.replace(base('legal/legality/form_legal'));
    } );

    $('.buttonLoadModal').on('click', function () {
        //$('#loadMe').modal({show:true});

        //$('#loadMe').modal({show:true});

        /*$modal.find('iframe').load(function() {
            $('#loadMe').modal({show:false});
        });*/
        //$(".embeding").find('iframe').attr("src",el.attr('data-url'));
        var el = $(this);
        $modal.find('iframe').attr('src',el.attr('data-url'));
        console.log(el.attr('data-url'));
        $modal.modal({show:true});
       /* $modal.load(el.find('iframe').attr('src','data-url'), '', function(){
            $modal.modal();
        } );*/
    } );

    $('#buttonDismiss').on('click', function () {
        alert('Data tidak akan di proses, Anda yakin?');
    });

    $modal.on('hidden.bs.modal', function () {
        // do something…
        $.ajax({
            url : base('api/legality/clearTmpLegal')+ '?var=' + 'nothaveVar',
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //reload_table();
                var tablex = $('#legalDatatable');
                tablex.DataTable().ajax.reload(); //reload datatable ajax
                //alert(data.messages);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Failed To Loading Data");
            }
        });


    })

    /*$('.lod').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
        var xd = $(this);
        xd.find('iframe').attr('src','data-url');
        console.log(xd.attr('data-url'));
    })*/

   /* var $modal = $('.lod');
    $('.buttonLoadModal').on('click', function () {
        var el = $(this);
        el.find('iframe').attr('src','data-url')
        console.log(el.attr('data-url'));
        $modal.load(el.attr('src','data-url'), '', function(){
            $modal.modal();
        } );
    } );*/
}

function reload_table()
{
    var table = $('#legalDatatable');
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
    DatatableLegal();
    loadModal();

    $('#btn-filter').click(function(){ //button filter event click
        reload_table();
        $('#filter').modal('hide');
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        // Fetch the preselected item, and add to the control
        var coperatorSelect = $('#fcoperator');
        var option = new Option('','', true, true);
        coperatorSelect.append(option).trigger('change');

        // manually trigger the `select2:select` event
        coperatorSelect.trigger({
            type: 'select2:select',
        });
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
});

/*
$(function() {
    DatatableLegal();
});*/
