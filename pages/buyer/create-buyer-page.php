<div class="card">
    <div class="card-header">
        <h5 class="card-title fw-bold mb-0">
            <i class="fa fa-list-alt me-2"></i> Add New Buyer
        </h5>
    </div>
    <div class="card-body">
        <form id="submissionForm" method="POST">
            <div class="mb-3">
                <label for="amount" class="form-label required-star">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
                <div class="invalid-feedback">Please enter a valid amount (numbers only).</div>
            </div>
            <div class="mb-3">
                <label for="buyer" class="form-label required-star">Buyer</label>
                <input type="text" class="form-control" id="buyer" name="buyer" maxlength="20" required>
                <div class="invalid-feedback">Please enter a valid buyer name (max 20 characters, letters, spaces, and numbers only).</div>
            </div>
            <div class="mb-3">
                <label for="receipt_id" class="form-label required-star">Receipt ID</label>
                <input type="text" class="form-control required" id="receipt_id" name="receipt_id" required>
                <div class="invalid-feedback">Please enter a valid receipt ID.</div>
            </div>
            <div class="mb-3">
                <label for="items" class="form-label required-star">Items</label>
                <input type="text" class="form-control required" id="items" name="items" required>
                <div class="invalid-feedback">Please enter valid items (text only).</div>
            </div>
            <div class="mb-3">
                <label for="buyer_email" class="form-label required-star">Buyer Email</label>
                <input type="email" class="form-control required" id="buyer_email" name="buyer_email" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note" rows="3" maxlength="30"></textarea>
                <div class="invalid-feedback">Please enter a valid note (max 30 words).</div>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label required-star">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
                <div class="invalid-feedback">Please enter a valid city (letters and spaces only).</div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label required-star">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
                <div class="invalid-feedback">Please enter a valid phone number (numbers only).</div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <a class="btn btn-secondary btn-sm fw-bold" href="../../buyer_list.php">
                <i class="fa fa-backward"></i> Back
            </a>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-save"></i> Save
            </button>
        </div>
    </div>
</div>

<!-- Scripting Code Here -->
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