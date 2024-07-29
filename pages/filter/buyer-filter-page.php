<?php 
    if(isset($_POST['filter_buyer'])){
        $filteringData = $application->getBuyersByFiltering($_GET); 
    }

?>


<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-bold mb-0">
            <i class="fa fa-filter"></i> Filter Data
        </h5>
        <a class="btn btn-secondary btn-sm fw-bold" href="../../buyer_list.php">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>

    <form id="dataForm" method="POST">
        <div class="card-body">
            <div class="row">

                <div class="mb-3 col-md-4">
                    <label for="userId" class="form-label">User (We will use EntryBy as UserID)</label>
                    <input type="date" class="form-control" id="userId" name="user_id">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="start_date">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="end_date">
                </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger btn-sm fw-bold" href="../../buyer_filter.php">
                    <i class="fa fa-undo"></i> Reset
                </a>
                <button type="submit" name="save_buyer" class="btn btn-primary btn-sm">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>