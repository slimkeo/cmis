<div class="row">
    <div class="col-md-12">

        <!-- CONTROL TABS START -->
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#list" data-toggle="tab">
                        <i class="fa fa-list"></i> 
                        <?php echo get_phrase('all_attendance'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <br>

                <!-- TABLE LISTING STARTS -->
                <div class="tab-pane box active" id="list">

                <table class="table table-bordered table-striped mb-none" id="datatable-tabletoolsw">
            <thead>
                <tr>
                                <th><div>HDR</div></th>
                                <th><div>AGM</div></th>
                                <th><div>Number</div></th>
                                <th><div>Amount</div></th>
                                <th><div>Ref</div></th>
                </tr>
            </thead>

        <tbody>
            <!-- Leave empty. DataTables will fill this -->
        </tbody>

        </table>

                </div>
                <!-- TABLE LISTING ENDS -->

            </div>
        </div>
        <!-- CONTROL TABS END -->

    </div>
</div>
<script>
$(document).ready(function() {

    $('#datatable-tabletoolsw').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 2000,
        "ajax": {
            "url": "<?php echo base_url('index.php?burial/get_attended');?>",
            "type": "POST"
        },

        // ADD THIS ↓↓↓
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy',  text: 'Copy' },
            { extend: 'excel', text: 'Excel', title: null},
            { extend: 'pdf',   text: 'PDF' },
            { extend: 'print', text: 'Print' }
        ]
    });

});
</script>