<?php
    if (isset($_GET['filter_buyer'])) {
        $result = $application->getBuyersByFiltering($_GET);
    }
?>

<link rel="stylesheet" href="../../assets/css/flatpickr.min.css">
<?php if(isset($result) && $result['status'] === 'error'){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo $result['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php } ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-bold mb-0">
            <i class="fa fa-filter"></i> Filter Data
        </h5>
        <a class="btn btn-secondary btn-sm fw-bold" href="../../buyer_list.php">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>

    <form method="GET">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="text" class="form-control" id="startDate" name="start_date" value="<?php echo isset($result['params']['start_date']) ? $result['params']['start_date'] : null; ?>" autocomplete="off" placeholder="YYYY-MM-DD">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="text" class="form-control date-picker" id="endDate" name="end_date" value="<?php echo isset($result['params']['end_date']) ? $result['params']['end_date'] : null; ?>" autocomplete="off" placeholder="YYYY-MM-DD">
                </div>

            </div>
        </div>
        <div class="card-footer">
            <?php if(isset($result['params'])){?>
                <a class="btn btn-danger btn-sm fw-bold float-start" href="../../buyer_filter.php">
                    <i class="fa fa-undo"></i> Reset
                </a>
            <?php } ?>
            
            <button type="submit" name="filter_buyer" class="btn btn-primary btn-sm float-end">
                <i class="fa fa-filter"></i> Filter
            </button>
             <div class="clearfix"></div>
        </div>
    </form>
</div>
<?php if(isset($result['data'])){  ?>
    <div class="card mt-5 mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">
                <i class="fa fa-users"></i> Buyers Filtered List
            </h5>
        </div>
        <div class="card-body">
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
                            <?php if ($result['data']->num_rows > 0) { ?>
                                <?php foreach ($result['data'] as $index => $buyer) { ?>
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
<?php } ?>

<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script src="../../assets/js/flatpickr.js"></script>
<script>
    $(document).ready(function() {
        $("#startDate, #endDate").flatpickr({
            maxDate: new Date(),
            dateFormat: "Y-m-d"
        });
    });
</script>