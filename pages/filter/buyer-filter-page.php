<?php 
    if(isset($_GET['filter_buyer'])){
        $filteringData = $application->getBuyersByFiltering($_GET); 
    }
?>

<link rel="stylesheet" href="../../assets/css/flatpickr.min.css">
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
                    <label for="userId" class="form-label">User (We will use EntryBy as UserID)</label>
                    <input type="text" class="form-control" id="userId" name="user_id" placeholder="Enter a single digit 1 to 5 or others">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="text" class="form-control" id="startDate" name="start_date" autocomplete="off" placeholder="YYYY-MM-DD">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="text" class="form-control date-picker" id="endDate" name="end_date" autocomplete="off" placeholder="YYYY-MM-DD">
                </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger btn-sm fw-bold" href="../../buyer_filter.php">
                    <i class="fa fa-undo"></i> Reset
                </a>
                <button type="submit" name="filter_buyer" class="btn btn-primary btn-sm">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>
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