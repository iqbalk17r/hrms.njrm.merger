/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Module/App: Main Js
 */

var FullScreen = function() {
    var control = $("#btn-fullscreen"),
        handleFullScreen = function () {
            var launcFullScreen = function(element) {
                if(element.requestFullscreen) {
                    element.requestFullscreen();
                } else if(element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if(element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if(element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                }
                    control.find('i').removeClass('icon-size-fullscreen');
                    control.find('i').addClass('icon-size-actual');
                },
                exitFullScreen = function() {
                if(document.exitFullscreen) {
                    document.exitFullscreen();
                } else if(document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if(document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
                    control.find('i').removeClass('icon-size-actual');
                    control.find('i').addClass('icon-size-fullscreen');
            },
                toggle_fullscreen = function() {
                var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;
                if(fullscreenEnabled) {
                    if(!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                        launcFullScreen(document.documentElement);
                    } else{
                        exitFullScreen();
                    }
                }
            };
            control.on('click', function() {
                toggle_fullscreen();
            });
        };
        return {
            //main function to initiate the module
            init: function() {
                handleFullScreen();
            }
        };
}();

jQuery(document).ready(function() {
    FullScreen.init();
});