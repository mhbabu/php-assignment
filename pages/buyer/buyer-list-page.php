<div class="card mt-5">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title fw-bold mb-0">
            <i class="fa fa-users me-2"></i> Buyers List
        </h4>
        <a class="btn btn-success btn-sm fw-bold" title="Add New" href="../../create_buyer.php">
            <i class="fa fa-plus-circle"></i> Add New Buyer
        </a>
    </div>
    <div class="card-body border-top p-9">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">SL.</th>
                            <th scope="col">Buyer</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Receipt ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">IP Address</th>

                            <th scope="col">City</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Entry At</th>
                            <th scope="col">Entry By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($buyers) && !empty($buyers) && $buyers->num_rows > 0) { ?>
                            <?php foreach ($buyers as $index => $buyer) { ?>
                                <tr>
                                    <th scope="row"><?php echo ++$index; ?> .</th>
                                    <td><?php echo $buyer['buyer']; ?></td>
                                    <td><?php echo $buyer['amount']; ?></td>
                                    <td><?php echo $buyer['receipt_id']; ?></td>
                                    <td><?php echo $buyer['buyer_email']; ?></td>
                                    <td><?php echo $buyer['buyer_ip']; ?></td>
                                    <td><?php echo $buyer['city']; ?></td>
                                    <td><?php echo $buyer['phone']; ?></td>
                                    <td><?php echo $buyer['entry_at']; ?></td>
                                    <td><?php echo $buyer['entry_by']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="text-center">
                                <td colspan="10">No record found...!</td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>