<div class="row">
    <div class="col-md-12">

        <!--- CONTROL TABS START -->

                <!-- TABLE LISTING STARTS -->
                <div class="tab-pane box active" id="list">

                    <table class="table table-bordered table-striped mb-none" id="datatable-tabletools">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('#');?></div></th>
                                <th><div><?php echo get_phrase('national_id');?></div></th>
                                <th><div><?php echo get_phrase('fullname');?></div></th>
                                <th><div><?php echo get_phrase('passbook');?></div></th>
                                <th><div><?php echo get_phrase('contact');?></div></th>
                                <th><div><?php echo get_phrase('momo');?></div></th>
                                <th><div>AGM</div></th>
                                <th><div><?php echo get_phrase('createdate');?></div></th>
                                <th><div><?php echo get_phrase('paid');?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $count = 1;
                            foreach ($attendees as $row): 
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['national_id']; ?></td>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['passbook']; ?></td>
                                <td><?php echo $row['contact']; ?></td>
                                <td><?php echo $row['momo']; ?></td>
                                <td><?php echo $this->db->get_where('agms' , array('id' =>$row['agm']))->row()->description;?></td>
                                <td><?php echo date('d M, Y', strtotime($row['createdate'])); ?></td>
                                <td>
                                    <!-- Payment DETAILS -->
                                    <?php if ($row['paid']==1) { ?>
                                        <a href=""class="btn btn-xs btn-success"><i class="fa fa-check"></i> Paid</a>
                                    <?php } else { ?>
                                        <a href=""class="btn btn-xs btn-danger"><i class="fa fa-hourglass"></i> Not Paid</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

    </div>
</div>