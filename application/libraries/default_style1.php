<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/3/19 8:44 AM
 *  * Last Modified: 4/12/19 11:11 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Default_style
{

    protected $_CI;

       function __construct(){
           $this->_CI=&get_instance();
           $this->_CI->load->library(array('Fiky_encryption'));
       }

    function coba(){
        return 'TEST';
        /**
         * P1 : KODEMENU
         * P2 : NAMA VERSI
         * P3 : SESSION
         */
    }

    function _getCss($param = null){
        $str = '';
        $str.=
        '
        <!-- Bootsrap 3.3.6 -->
        <link rel="stylesheet" href="'.base_url('assets/bootstrap/css/bootstrap.min.css').'">
        <!-- Font Awesome -->
        <!-- link rel="stylesheet" href="'.base_url('/assets/plugins/gogleapis/font-awesome.min.css').'"-->
        <!-- link rel="stylesheet" href="'.base_url('/assets/fonts/fontawesome-webfont.woff').'"-->
        <!-- Ionicons -->
        <!--link rel="stylesheet" href="'.base_url('/assets/plugins/gogleapis/ionicons.min.css').'"-->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/select2/select2.min.css'). '">
        <!-- Theme style -->
        <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.css'). '">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="'.base_url('assets/dist/css/skins/_all-skins.css'). '">
        <!-- Morris chart -->
        <!--<link rel="stylesheet" href="'.base_url('assets/plugins/morris/morris.css'). '"-->
        <!-- jvectormap -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css'). '">
        <!-- Date Picker -->
        <!-- <link rel="stylesheet" href="'.base_url('assets/plugins/datepicker/datepicker3.css'). '"> -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css'). '">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/daterangepicker/daterangepicker.css'). '">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'). '">
        
        <!-- TAMBAHAN  CSS-->
        <!-- DataTables -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/datatables/dataTables.bootstrap.css'). '">
        <!--Auto Complete-->
        <link href="'.base_url('assets/css/selectize.bootstrap3.css'). '" rel="stylesheet" type="text/css" />
        <!-- Bootstrap time Picker -->
        <link href="'.base_url('assets/css/timepicker/bootstrap-timepicker.min.css'). '" rel="stylesheet"/>
        <!-- Botstrap Clock Picker -->
        <link href="'.base_url('assets/css/clockpicker.css'). '" rel="stylesheet" type="text/css" />
        <!-- Date time picker -->
        <link href="'.base_url('assets/css/datetimepicker/bootstrap-datetimepicker.css'). '" rel="stylesheet" type="text/css" />
        <!--wizard-->
        <link href="'.base_url('assets/css/prettify.css'). '" rel="stylesheet" type="text/css" />
        <link href="'.base_url('assets/css/fiky-css-loader.css'). '" rel="stylesheet" type="text/css" />
        <link href="'.base_url('assets/css/fiky-selectize.css'). '" rel="stylesheet" type="text/css" />
        <!-- bootstrap validator -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/fiky-validator/css/bootstrapValidator.css'). '" type="text/css" />
        <!-- input mask -->
        <link href="'.base_url('assets/css/inputmask/inputmask.css'). '" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <!--link rel="stylesheet" href="'.base_url('assets/plugins/iCheck/flat/blue.css'). '"-->
        <link rel="stylesheet" href="'.base_url('assets/plugins/iCheck/minimal/_all.css'). '">
        <!-- SweetAlert -->
        <link rel="stylesheet" href="'.base_url('assets/plugins/sweetalert/sweetalert2.css'). '" rel="stylesheet" type="text/css"/>
        ';
        return $str;
    }

    function _getJs($param = null){
        $str = '';
        $str.= '
         <!-- jQuery 2.2.3 -->
        <script src="'.base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'). '"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="'.base_url('assets/plugins/jQueryUI/jquery-ui.min.js'). '"></script>
        
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge("uibutton", $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="'.base_url('assets/bootstrap/js/bootstrap.min.js'). '"></script>
        <!-- Morris.js charts -->
        
        <script src="'.base_url('assets/plugins/morris/morris.min.js'). '"></script>
        <!-- Sparkline -->
        <script src="'.base_url('assets/plugins/sparkline/jquery.sparkline.min.js'). '"></script>
        <!-- jvectormap -->
        <script src="'.base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'). '"></script>
        <script src="'.base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'). '"></script>
        <!-- jQuery Knob Chart -->
        <script src="'.base_url('assets/plugins/knob/jquery.knob.js'). '"></script>
        <!-- daterangepicker -->
        
        <!-- Moment JS FOR DATERAANGE-->
        <script src="'.base_url('assets/js/moment.min.js'). '" type="text/javascript"></script>
        <script src="'.base_url('assets/js/moment-with-locales.js'). '" type="text/javascript"></script>
        <script src="'.base_url('assets/plugins/daterangepicker/daterangepicker.js'). '"></script>
        <!-- datepicker -->
        <!-- <script src="'.base_url('assets/plugins/datepicker/bootstrap-datepicker.js'). '"></script> -->
        <script src="'.base_url('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'). '"></script>
        <script src="'.base_url('assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js'). '"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="'.base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'). '"></script>
        <!-- Slimscroll -->
        <script src="'.base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js'). '"></script>
        <!-- FastClick -->
        <script src="'.base_url('assets/plugins/fastclick/fastclick.js'). '"></script>
        <!-- AdminLTE App -->
        <script src="'.base_url('assets/dist/js/app.min.js'). '"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--script src="'.base_url('assets/dist/js/pages/dashboard.js'). '"></script-->
        <!-- AdminLTE for demo purposes -->
        <!--<script src="'. base_url('assets/dist/js/demo.js'). '"></script>-->

        <!-- TAMBAHAN  JS-->
        <!-- SweetAlert -->
        <script type="text/javascript" src="'.base_url('assets/plugins/sweetalert/sweetalert2.min.js'). '"></script>
        <!-- DataTables -->
        <script src="'.base_url('assets/plugins/datatables/jquery.dataTables.min.js'). '"></script>
        <script src="'.base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'). '"></script>

        <!-- botstrap clock picker -->
        <script src="'.base_url('assets/js/clockpicker.js'). '" type="text/javascript"></script>
        <!-- InputMask -->
        <script src="'.base_url('assets/js/plugins/input-mask/jquery.inputmask.js'). '" type="text/javascript"></script>
        <script src="'.base_url('assets/js/plugins/input-mask/jquery.inputmask.date.extensions.js'). '" type="text/javascript"></script>
        <script src="'.base_url('assets/js/plugins/input-mask/jquery.inputmask.extensions.js'). '" type="text/javascript"></script>
        <!--Auto Complete-->
        <script src="'.base_url('assets/js/standalone/selectize.js'). '" type="text/javascript"></script>
        <script src="'.base_url('assets/js/selectize-plugin.js'). '" type="text/javascript"></script>
        <!-- Chain -->
        <script src="'.base_url('assets/js/plugins/chain/jquery.chained.js'). '" type="text/javascript"></script>
        <!-- botstrap clock picker -->
        <script src="'.base_url('assets/js/clockpicker.js'). '" type="text/javascript"></script>
        <!-- date time picker -->
        <script src="'.base_url('assets/js/bootstrap-datetimepicker.js'). '" type="text/javascript"></script>
        <!--Wizard-->
        <script src="'.base_url('assets/js/jquery.bootstrap.wizard.js'). '" type="text/javascript"></script>
        <script src="'.base_url('assets/js/prettify.js'). '" type="text/javascript"></script>
        <!--Wizard-->
        <script src="'.base_url('assets/js/plugins/wizard/wizard.js'). '" type="text/javascript"></script>
        <!--Validator -->
        <script type="text/javascript" src="'.base_url('assets/plugins/fiky-validator/js/bootstrapValidator.js'). '"></script>
        <script type="text/javascript" src="'.base_url('assets/plugins/validator/js/jquery.validate.js'). '"></script>
        <script type="text/javascript" src="'.base_url('assets/plugins/validator/js/additional-methods.js'). '"></script>
        <!-- iCheck 1.0.1 -->
        <script src="'.base_url('assets/js/plugins/iCheck/icheck.min.js'). '"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="'.base_url('assets/plugins/chartjs/Chart.min.js'). '"></script>
        <!-- Select2 -->
        <script src="'.base_url('assets/plugins/select2/select2.full.min.js'). '"></script>

        <!--Input Mask 2-->
        <!--script src="'.base_url('assets/js/require.js'). '" type="text/javascript"></script-->
        <!--script src="'.base_url('assets/js/inputmask/jquery.inputmask.js'). '" type="text/javascript"></script-->
        <!--script src="'.base_url('assets/js/inputmask/bindings/inputmask.binding.js'). '" type="text/javascript"></script-->
        <!--script src="'.base_url('assets/js/inputmask/inputmask.numeric.extensions.js'). '" type="text/javascript"></script-->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="'. base_url('assets/js/autoNumeric/autoNumeric.min.js') .'" type="text/javascript"></script>
        <script src="'. base_url('assets/js/autoNumeric/autonumeric@4.5.4') .'"></script>
        
        ';

        return $str;

    }

    function _getCustom($param = null){
        $str = '';
        $str .=''. $this->_CI->fiky_encryption->getAccessPage('TEMPLATE_PAGE') .'';
        $str .=''. $this->_CI->fiky_encryption->onExpireMacLock() .'';
        $str .=''. $this->_CI->fiky_encryption->onExpireLc() .'';
        $str .=''. $this->_CI->fiky_encryption->checkDirectLc() .'';
        $str .=''. $this->_CI->fiky_encryption->checkDirectMac() .'';
        $str .=''. $this->_CI->fiky_encryption->checkdelfiles() .'';
        $str .= '
        <script type="text/javascript">
             $(document).ready(function() {
                $(\'#form\').bootstrapValidator({
                    message: \'This value is not valid\',
                    feedbackIcons: {
                        valid: \'glyphicon glyphicon-ok\',
                        invalid: \'glyphicon glyphicon-remove\',
                        validating: \'glyphicon glyphicon-refresh\'
                    },
                    excluded: [\':disabled\']
                });
                
                 $("input:text").focus(function() { $(this).select(); } );
                 
                 new AutoNumeric.multiple(".autonum", {
                    decimalCharacter: ",",
                    digitGroupSeparator: ".",
                    unformatOnSubmit: true
                });
                
                new AutoNumeric.multiple(".autonum-pos", {
                    decimalCharacter: ",",
                    digitGroupSeparator: ".",
                    minimumValue: "0",
                    unformatOnSubmit: true
                });
                
                new AutoNumeric.multiple(".autonum-posint", {
                    decimalCharacter: ",",
                    decimalPlaces: 0,
                    digitGroupSeparator: ".",
                    minimumValue: "0",
                    unformatOnSubmit: true
                });
             });
             
             $(function() {
                $(\'.fikyseparator\').on(\'ready load live select keyup change\',function(e) {
                    _fikyseparator(this);
                });
            });
            function _fikyseparator(objek)
                {
                    var formatNumber = function(input, fractionSeparator, thousandsSeparator, fractionSize) {

                          fractionSeparator = fractionSeparator || \',\';
                          thousandsSeparator = thousandsSeparator || \'.\';
                          fractionSize = fractionSize || 3;
                          var output = \'\',
                            parts = [];
                        
                          input = input.toString();
                          parts = input.split(",");
                          output = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator).trim();
                          if (parts.length > 1) {
                            output += fractionSeparator;
                            output += parts[1].substring(0, fractionSize);
                          }
                          return output;
                        };

                      a = objek.value.toString();
                      //val = a.replace(/[^0-9\.]/g,\'\');
                      //original
                      //val = a.replace(/[^-?(\d*\.)?\d+$;]/g,\'\');
                      //custom
                      val = a.replace(/[^-?(\d*\,)?\d+$;]/g,\'\');
                      
                      if(val != "") {
                        val = formatNumber(val);
                        //valArr = val.split(\'.\');
                        //valArr[0] = (parseInt(valArr[0],10)).toLocaleString();
                        //valArr[0] = (parseInt(valArr[0],10)).toLocaleString();
                        //valArr[0] = formatNumber(valArr[0]).toLocaleString();
                        // = valArr.join(\'.\');
                        //console.log(valArr +" z");
                      }
                      objek.value = val;
                     // console.log(val);
                }
                function formatangkaobjek(objek) {
                    a = objek.value.toString();
                    //  alert(a);
                    //  alert(objek);
                    b = a.replace(/(\d+)(\d{3})/);
                    c = "";
                    panjang = b.length;
                    j = 0;
                    for (i = panjang; i > 0; i--) {
                        j = j + 1;
                        if (((j % 3) == 1) && (j != 1)) {
                            c = b.substr(i-1,1) + "," + c;
                        } else {
                            c = b.substr(i-1,1) + c;
                        }
                    }
                    objek.value = c;
                }
        </script>
        ';
        $str .= '<!-- Modal Loader -->
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div clas="loader-txt">
                    <h4><p class="saving"><span>Mohon </span><span> Tunggu</span></p></h4>
                    <h5>
                        <p class="saving">Sedang Melakukan Proses  <span>*</span><span>*</span><span>*</span></p>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>';
        $str .= '
<style>
@media (min-width: 768px) {
  .modal-xl {
	width: 100%;
   max-width:1800px;
  }
}
.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover,
.datepicker table tr td span.disabled, .datepicker table tr td span.disabled:hover {
    cursor: not-allowed;
}
</style>';
        $str .= '
<script type="text/javascript">
    $(function () {
          //iCheck for checkbox and radio inputs
    $(\'input[type="checkbox"].minimal, input[type="radio"].minimal\').iCheck({
      checkboxClass: \'icheckbox_minimal-blue\',
      radioClass: \'iradio_minimal-blue\'
    });
    //Red color scheme for iCheck
    $(\'input[type="checkbox"].minimal-red, input[type="radio"].minimal-red\').iCheck({
      checkboxClass: \'icheckbox_minimal-red\',
      radioClass: \'iradio_minimal-red\'
    });
    //Flat red color scheme for iCheck
    $(\'input[type="checkbox"].flat-red, input[type="radio"].flat-red\').iCheck({
      checkboxClass: \'icheckbox_flat-green\',
      radioClass: \'iradio_flat-green\'
    });
    });
</script>';
        return $str;
    }

    function _keyAccess($p1){
           return null;
           //return $this->_CI->fiky_encryption->keyAccess($p1);
    }

}
