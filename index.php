<?php 
require_once('classes/Application.php');
$application   = new Application();
$buyers = $application->getAllBuyers();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Info App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="assets/css/custom.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">

        <?php
        if (isset($myPage)) {
            switch ($myPage) {
                case 'buyerListPage':
                    require_once('pages/buyer/buyer-list-page.php');
                    break;
                case 'createBuyerPage':
                    require_once('pages/buyer/create-buyer-page.php');
                    break;
                case 'reportPage':
                    require_once('pages/report/report-page.php');
                    break;
                default:
                    require_once('pages/buyer/buyer-list-page.php');
                    break;
            }
        } else {
            require_once('pages/buyer/buyer-list-page.php');
        }

        ?>
       
    </div>
</body>

</html>