<div class="row">
    <div class="col-md-12">

        <!-- PAGE TITLE -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-users"></i> Member SMS Communique
                </h3>
            </div>
        </div>

        <!-- MESSAGE TEXTAREA -->
        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-12">
                <label><b>Message to Send</b></label>
                <textarea id="bulkMessage" class="form-control" rows="6"
                          placeholder="Type your message here..."
                          style="font-size:15px;"></textarea>
            </div>
        </div>

        <!-- SEND BUTTON -->
        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg" id="btnInviteAll">
                    <i class="fa fa-paper-plane"></i> Send Message to All Members
                </button>
            </div>
        </div>

        <!-- SEND MODAL -->
        <div class="modal fade" id="inviteModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fa fa-paper-plane"></i> Sending Messages
                        </h4>
                    </div>

                    <div class="modal-body">
                        <p>Sending SMS messages to all members. Please wait…</p>

                        <!-- PROGRESS BAR -->
                        <div class="progress">
                            <div id="inviteProgress" 
                                 class="progress-bar progress-bar-success" 
                                 role="progressbar" 
                                 style="width:0%">
                                0%
                            </div>
                        </div>

                        <!-- LOG AREA -->
                        <div id="inviteLog"
                             style="background:#f9f9f9; border:1px solid #ddd; padding:10px;
                                    height:250px; overflow-y:auto; margin-top:15px; font-size:13px;">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="closeInviteModal" 
                                class="btn btn-success" style="display:none;" 
                                data-dismiss="modal">
                            Done
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


<!-- JAVASCRIPT -->
<script>
$(document).ready(function() {

    $("#btnInviteAll").click(function() {

        const msg = $("#bulkMessage").val().trim();

        if (msg.length === 0) {
            alert("Please enter the SMS message before sending.");
            return;
        }

        $("#inviteModal").modal("show");
        startRealSending(msg);
    });

    function startRealSending(messageText) {

        $("#inviteLog").html("");
        $("#inviteProgress").css("width", "0%").text("0%");
        $("#closeInviteModal").hide();

        const batchSize = 200;
        let offset = 0;

        // First request: get total members
        $.ajax({
            url: "<?php echo base_url('index.php?burial/invite_batch_init'); ?>",
            method: "POST",
            dataType: "json",
            success: function(initRes) {

                if (!initRes || !initRes.total) {
                    $("#inviteLog").append("<div class='text-danger'>Failed to get total members.</div>");
                    return;
                }

                const total = parseInt(initRes.total, 10);
                $("#inviteLog").append("Total members to message: " + total + "<br>");

                // Start sending batches
                function processNextBatch() {

                    $.ajax({
                        url: "<?php echo base_url('index.php?burial/send_broadcast'); ?>",
                        method: "POST",
                        dataType: "json",
                        data: {
                            offset: offset,
                            limit: batchSize,
                            message: messageText
                        },
                        success: function(res) {

                            const processed = res.processed || 0;
                            offset += processed;

                            if (res.logs && res.logs.length > 0) {
                                res.logs.forEach(function(line) {
                                    $("#inviteLog").append(line + "<br>");
                                });
                            }

                            const percent = Math.round((offset / total) * 100);
                            $("#inviteProgress").css("width", percent + "%").text(percent + "%");

                            $("#inviteLog").scrollTop($("#inviteLog")[0].scrollHeight);

                            if (offset < total) {
                                setTimeout(processNextBatch, 200);
                            } else {
                                $("#inviteLog").append("<b>All messages sent successfully.</b><br>");
                                $("#closeInviteModal").show();
                            }
                        },
                        error: function(xhr, status, err) {
                            $("#inviteLog").append("<div class='text-danger'>Batch failed: " + err + "</div>");
                            $("#closeInviteModal").show();
                        }
                    });

                }

                // Start first batch
                processNextBatch();
            },
            error: function() {
                $("#inviteLog").append("<div class='text-danger'>Could not initialize process.</div>");
            }
        });

    }

});
</script>
