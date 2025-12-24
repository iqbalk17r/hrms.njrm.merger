<?php //echo $url ;?>
<style>
    /* Loading text animation styles */
    @keyframes pulse {
        0% {
            opacity: 0.3;
        }
        50% {
            opacity: 1;
        }
        100% {
            opacity: 0.3;
        }
    }

    .loading-text {
        text-align: center;
        margin-top: 20px;
        font-size: 30px;
        font-weight: bold;
        color: #333;
    }

    .loading-spinner {
        display: inline-block;
        width: 1em;
        height: 1em;
        margin-right: 8px;
        border-radius: 50%;
        border: 0.2em solid #3498db;
        border-top: 0.2em solid transparent;
        animation: spin 1s infinite linear, pulse 2s infinite;
    }

    /* Optional: Add a spinner animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="content-fill">
    <div id="loadingElement" style="display: none;">
        <center>
            <div id="loadingElement" class="loading-text">
                <div class="loading-spinner"></div>
                Loading...
            </div>
        </center>
    </div>
</div>

<script>
    function reloadPage(){
        $('#loadingElement').show();
        $.get('<?php echo $url ?>', function(data) {
            $('div.content-fill').html(data);
        });
    }
    $( document ).ready(function() {
        $('#loadingElement').show();
        $.get('<?php echo $url ?>', function(data) {
            $('div.content-fill').html(data);
        });
    })
</script>