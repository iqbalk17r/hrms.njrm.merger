<?php
require_once 'assets/new/stimulsoft/stimulsoft/helper.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?= $title ?></title>

    <!-- Office2013 style -->
    <link href="<?= base_url('assets/new/stimulsoft/css/stimulsoft.viewer.office2013.whiteblue.css') ?>"
          rel="stylesheet">

    <!-- Stimusloft Reports.JS -->
    <script src="<?= base_url('assets/new/stimulsoft/scripts/stimulsoft.reports.js') ?>"
            type="text/javascript"></script>
    <script src="<?= base_url('assets/new/stimulsoft/scripts/stimulsoft.reports.maps.js') ?>"
            type="text/javascript"></script>

    <!-- Stimusloft Dashboards.JS -->
    <script src="<?= base_url('assets/new/stimulsoft/scripts/stimulsoft.viewer.js') ?>" type="text/javascript"></script>

    <script type="text/javascript">
        Stimulsoft.Base.StiLicense.key = "6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHn0s4gy0Fr5YoUZ9V00Y0igCSFQzwEqYBh/N77k4f0fWXTHW5rqeBNLkaurJDenJ9o97TyqHs9HfvINK18Uwzsc/bG01Rq+x3H3Rf+g7AY92gvWmp7VA2Uxa30Q97f61siWz2dE5kdBVcCnSFzC6awE74JzDcJMj8OuxplqB1CYcpoPcOjKy1PiATlC3UsBaLEXsok1xxtRMQ283r282tkh8XQitsxtTczAJBxijuJNfziYhci2jResWXK51ygOOEbVAxmpflujkJ8oEVHkOA/CjX6bGx05pNZ6oSIu9H8deF94MyqIwcdeirCe60GbIQByQtLimfxbIZnO35X3fs/94av0ODfELqrQEpLrpU6FNeHttvlMc5UVrT4K+8lPbqR8Hq0PFWmFrbVIYSi7tAVFMMe2D1C59NWyLu3AkrD3No7YhLVh7LV0Tttr/8FrcZ8xirBPcMZCIGrRIesrHxOsZH2V8t/t0GXCnLLAWX+TNvdNXkB8cF2y9ZXf1enI064yE5dwMs2fQ0yOUG/xornE";
        var options = new Stimulsoft.Viewer.StiViewerOptions();
        options.toolbar.displayMode = Stimulsoft.Viewer.StiToolbarDisplayMode.Separated;
        options.toolbar.showSendEmailButton = false;
        options.toolbar.showAboutButton = true;
        options.toolbar.showOpenButton = false;
        options.appearance.fullScreenMode = true;
        options.appearance.scrollbarsMode = true;
        var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);
        viewer.onBeginProcessData = function (event, callback) {
            <?php StiHelper::createHandler(); ?>
        }
        viewer.onEmailReport = function (event) {
            <?php StiHelper::createHandler(); ?>
        }

        var report = new Stimulsoft.Report.StiReport();
        report.loadFile("<?=base_url($report_file)?>");
        report.reportName = '<?php echo $report_name?>';
        var dataSet = new Stimulsoft.System.Data.DataSet("Demo");
        dataSet.readJsonFile("<?= base_url($jsonfile) ?>");
        report.dictionary.databases.clear();
        report.regData("Demo", "Demo", dataSet);

        viewer.report = report;

        function onLoad() {
            viewer.renderHtml("viewerContent");
        }

    </script>
</head>
<body onload="onLoad();">
<div id="viewerContent"></div>
</body>
</html>
