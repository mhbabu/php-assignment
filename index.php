<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Info App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">

        <?php
        if (isset($myPage)) {
            switch ($myPage) {
                case 'buyerListPage':
                    require_once('pages/buyer/buyer-list.php');
                    break;
                case 'createBuyerPage':
                    require_once('pages/buyer/create-buyer.php');
                    break;
                case 'reportPage':
                    require_once('pages/report/report.php');
                    break;
                default:
                    require_once('pages/buyer/buyer-list.php');
                    break;
            }
        } else {
            require_once('pages/buyer/buyer-list.php');
        }

        ?>
       
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submissionForm').on('submit', function(e) {
                e.preventDefault();
                // Frontend Validation
                let isValid = true;
                let amount = $('#amount').val();
                let buyer = $('#buyer').val();
                let receipt_id = $('#receipt_id').val();
                let items = $('#items').val();
                let buyer_email = $('#buyer_email').val();
                let note = $('#note').val().trim();
                let city = $('#city').val();
                let phone = $('#phone').val();
                if (!/^\d+$/.test(amount)) {
                    $('#amount').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#amount').removeClass('is-invalid');
                }
                if (!/^[a-zA-Z0-9 ]{1,20}$/.test(buyer)) {
                    $('#buyer').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#buyer').removeClass('is-invalid');
                }
                if (receipt_id.trim() === "") {
                    $('#receipt_id').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#receipt_id').removeClass('is-invalid');
                }
                if (items.trim() === "") {
                    $('#items').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#items').removeClass('is-invalid');
                }
                if (!/^\S+@\S+\.\S+$/.test(buyer_email)) {
                    $('#buyer_email').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#buyer_email').removeClass('is-invalid');
                }
                if (note.split(' ').length > 30) {
                    $('#note').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#note').removeClass('is-invalid');
                }
                if (!/^[a-zA-Z ]+$/.test(city)) {
                    $('#city').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#city').removeClass('is-invalid');
                }
                if (!/^\d+$/.test(phone)) {
                    $('#phone').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#phone').removeClass('is-invalid');
                }
                if (!isValid) {
                    return;
                }
                // Check if the form was submitted in the last 24 hours
                if (document.cookie.indexOf('submitted=true') !== -1) {
                    alert('You have already submitted the form in the last 24 hours.');
                    return;
                }
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'submit.php',
                    data: formData,
                    success: function(response) {
                        if (response === 'success') {
                            alert('Form submitted successfully');
                            // Set a cookie to expire in 24 hours
                            document.cookie = "submitted=true; max-age=86400; path=/";
                        } else {
                            alert('Error submitting form: ' + response);
                        }
                    },
                    error: function() {
                        alert('Error submitting form');
                    }
                });
            });
        });
    </script>
</body>

</html>