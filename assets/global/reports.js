var StimulsoftReport = function() {

    var handleStimulsoftReport = function() {
// Declare variable
        var elementviewer = $('#viewer'),
            elementdesigner = $('#designer'),
            jsonviewer = elementviewer.data('jsonfile'),
            reportviewer = elementviewer.data('reportfile'),
            jsondesigner = elementdesigner.data('jsonfile'),
            reportdesigner = elementdesigner.data('reportfile'),
            datasetviewer = new System.Data.DataSet('dataset'),
            datasetdesigner = new System.Data.DataSet('dataset'),
            viewer = null,
            designer = null;
        // Specify necessary options for the viewer
        var options = new Stimulsoft.Viewer.StiViewerOptions();
        options.height = "100%";
        options.appearance.scrollbarsMode = false;
        options.toolbar.showDesignButton = false;
        options.toolbar.showAboutButton = false;
        options.appearance.fullScreenMode = true;
		options.toolbar.showPrintButton = true;
        // Create the report viewer with custom options
        viewer = new Stimulsoft.Viewer.StiViewer(options, 'StiViewer', false);
        // Add the design button event
        viewer.onReportDesign = function (e) {
            this.visible = false;
            if (designer == null) {
                var options = new Stimulsoft.Designer.StiDesignerOptions();
                options.appearance.fullScreenMode = true;
                options.toolbar.showAboutButton = false;
                // Create an instance of the designer
                designer = new Stimulsoft.Designer.StiDesigner(options, 'StiDesigner', false);
                // Add the event for report preview
                designer.onPreviewReport = function (e) {
                    datasetdesigner.readJsonFile(base(jsondesigner));
                    // Remove all connections in report template (they are used in the first place)
                    e.report.dictionary.databases.clear();
                    // Registered JSON data specified in the report with same name
                    e.report.regData(datasetdesigner.dataSetName, null, datasetdesigner);
                }
                // Add the exit menu item event
                designer.onExit = function (e) {
                    this.visible = false;
                    viewer.visible = true;
                }
                designer.renderHtml('designer');
            }
            // Create a new report instance
            var report = new Stimulsoft.Report.StiReport();
            // Load report from url
            report.loadFile(base(reportdesigner));
            // Assign report to the designer, the report will be built automatically after rendering the designer
            designer.visible = true;
            designer.report = report;
        };
        // Assign the onGetReportData event function
        viewer.onGetReportData = function (e) {
            datasetviewer.readJsonFile(base(jsonviewer));
            e.report.dictionary.databases.clear();
            e.report.regData(datasetviewer.dataSetName, null, datasetviewer);
        }
        // Assign the onPrintReport event function
        viewer.onPrintReport = function (e) {
        }
        // Assign the onReportExport event function
        viewer.onReportExport = function (e) {
            switch (e.format) {
                case Stimulsoft.Report.StiExportFormat.Html:
                    e.settings.zoom = 1;  // Set HTML zoom factor to 200%
                    break;
            }
        }
        // Create a new report instance
        var report = new Stimulsoft.Report.StiReport();
        // Load report from url
        report.loadFile(base(reportviewer));
        // Assign report to the viewer, the report will be built automatically after rendering the viewer
        viewer.report = report;
        // Show the report viewer in the 'content' element
        viewer.renderHtml('viewer');
    }

    return {
        //main function to initiate the module
        init: function() {
            handleStimulsoftReport();
        }

    };

}();

jQuery(document).ready(function() {
    StimulsoftReport.init();
});