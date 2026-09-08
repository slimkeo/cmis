<?php
$event = $this->db->get_where('events', array('id' => $event_id))->row();
$event_name = $event->description;
$time = $event->time;
$location = $event->location;
$date = $event->date;

// default message
$message =$event_name . " : " .date('j F Y', strtotime($date)). ", at " . $location . ". Registration : " . $time . ", Bring: Payslip/receipt and ID.";
?>

<div class="row">
    <div class="col-md-12">

        <!-- PAGE TITLE -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-users"></i> <?php echo $event_name; ?> SMS Invitations
                </h3>
            </div>
        </div>

        <!-- FORM SECTION -->
        <div id="inviteForm" class="panel panel-default">
            <div class="panel-body">

                <div class="form-group">
                    <label>SMS Message (OTP WILL BE ADDED AT THE END OF THE MESSAGE AUTOMATICALLY)</label>
                    <textarea id="smsMessage" class="form-control" rows="4"><?php echo $message; ?></textarea>
                </div>

                <button class="btn btn-primary btn-lg" id="btnInviteAll">
                    <i class="fa fa-paper-plane"></i> Send Invitations
                </button>

            </div>
        </div>

        <!-- PROGRESS SECTION (HIDDEN INITIALLY) -->
        <div id="inviteProgressSection" class="panel panel-default" style="display:none;">
            <div class="panel-heading">
                <h4><i class="fa fa-spinner fa-spin"></i> Sending Invitations...</h4>
            </div>

            <div class="panel-body">

                <div class="progress">
                    <div id="inviteProgress" class="progress-bar progress-bar-success"
                         role="progressbar" style="width:0%">
                        0%
                    </div>
                </div>

                <div id="inviteLog"
                     style="background:#f9f9f9; border:1px solid #ddd; padding:10px;
                            height:250px; overflow-y:auto; margin-top:15px; font-size:13px;">
                </div>

                <button type="button" id="doneBtn" class="btn btn-success" style="display:none;">
                    Done
                </button>

            </div>
        </div>

    </div>
</div>
<script>
$(document).ready(function() {

    $("#btnInviteAll").click(function() {

    const message = $("#smsMessage").val();
    const event_id = <?php echo json_encode($event_id); ?>;

    if (!message.trim()) {
        alert("Please enter a message.");
        return;
    }

    $("#inviteForm").hide();
    $("#inviteProgressSection").show();

    startRealSending(message, event_id);
    });

    function startRealSending(message, event_id) {

    let offset = 0;
    const batchSize = 200;

    $.ajax({
        url: "<?php echo base_url('index.php?burial/invite_batch_init'); ?>",
        method: "POST",
        dataType: "json",
        data: {
            event_id: event_id // optional if needed in init
        },
        success: function(initRes) {

            const total = parseInt(initRes.total, 10);

            function processNextBatch() {

                $.ajax({
                    url: "<?php echo base_url('index.php?burial/invite_batch'); ?>",
                    method: "POST",
                    dataType: "json",
                    data: {
                        offset: offset,
                        limit: batchSize,
                        message: message,
                        event_id: event_id // ✅ SEND IT HERE
                    },
                    success: function(res) {

                        const processed = res.processed || 0;
                        offset += processed;

                        if (res.logs) {
                            res.logs.forEach(function(line) {
                                $("#inviteLog").append(line + "<br>");
                            });
                        }

                        const percent = Math.round((offset / total) * 100);
                        $("#inviteProgress").css("width", percent + "%").text(percent + "%");

                        if (offset < total) {
                            setTimeout(processNextBatch, 200);
                        } else {
                            $("#inviteLog").append("<b>Done. Total sent: " + res.total_success + "</b><br>");
                            $("#doneBtn").show();
                        }
                    }
                });
            }

            processNextBatch();
        }
    });
    }

    // optional: reset UI
    $("#doneBtn").click(function() {
        $("#inviteProgressSection").hide();
        $("#inviteForm").show();
    });

});
</script>
