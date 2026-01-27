<div class="row">
    <div class="col-md-12">

        <!-- PAGE TITLE -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-users"></i> Member SMS Invitations
                </h3>
            </div>
        </div>

        <!-- INVITE BUTTON -->
        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg" id="btnInviteAll">
                    <i class="fa fa-paper-plane"></i> Invite All Members
                </button>
            </div>
        </div>

        <!-- INVITE MODAL -->
        <div class="modal fade" id="inviteModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fa fa-paper-plane"></i> Sending Invitations
                        </h4>
                    </div>

                    <div class="modal-body">
                        <p>Sending SMS codes to all members. Please wait…</p>

                        <!-- PROGRESS BAR -->
                        <div class="progress">
                            <div id="inviteProgress" class="progress-bar progress-bar-success" 
                                role="progressbar" style="width:0%">
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
        $("#inviteModal").modal("show");
        startRealSending();
    });

    function startRealSending() {
        $("#inviteLog").html("");
        $("#inviteProgress").css("width", "0%").text("0%");
        $("#closeInviteModal").hide();

        // config
        const batchSize = 200;           // members per AJAX call
        let offset = 0;

        // first request to get total count
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
                $("#inviteLog").append("Total members to invite: " + total + "<br>");

                // process batches sequentially
                function processNextBatch() {
                    $.ajax({
                        url: "<?php echo base_url('index.php?burial/invite_batch'); ?>",
                        method: "POST",
                        dataType: "json",
                        data: {
                            offset: offset,
                            limit: batchSize
                        },
                        success: function(res) {
                            if (!res) {
                                $("#inviteLog").append("<div class='text-danger'>Empty response from server.</div>");
                                return;
                            }

                            // update counters
                            const processed = res.processed || 0;
                            const success = res.success_count || 0;
                            offset += processed;

                            // append logs
                            if (res.logs && res.logs.length) {
                                res.logs.forEach(function(line) {
                                    $("#inviteLog").append(line + "<br>");
                                });
                            }

                            // update progress bar
                            const percent = Math.round((offset / total) * 100);
                            $("#inviteProgress").css("width", percent + "%").text(percent + "%");
                            $("#inviteLog").scrollTop($("#inviteLog")[0].scrollHeight);

                            // continue or finish
                            if (offset < total) {
                                // short delay to avoid hammering API
                                setTimeout(processNextBatch, 200);
                            } else {
                                $("#inviteLog").append("<b>All invitations processed. Sent: " + res.total_success + "</b><br>");
                                $("#closeInviteModal").show();
                            }
                        },
                        error: function(xhr, status, err) {
                            $("#inviteLog").append("<div class='text-danger'>Batch request failed: " + err + "</div>");
                            $("#closeInviteModal").show();
                        }
                    });
                }

                // start first batch
                processNextBatch();
            },
            error: function() {
                $("#inviteLog").append("<div class='text-danger'>Could not initialize invitation process.</div>");
            }
        });
    }

});
</script>
