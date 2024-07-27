<?php

if (isset($_POST['save_buyer'])) {
    $response = $application->saveBuyer($_POST);
    echo $response;
}

?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title fw-bold mb-0">
            <i class="fa fa-list-alt me-2"></i> Add New Buyer
        </h5>
    </div>
    <form id="dataForm" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="buyer" class="form-label required-star">Buyer</label>
                    <input type="text" class="form-control" id="buyer" name="buyer" maxlength="20">
                    <div class="invalid-feedback" id="buyerError"></div>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="buyer_email" class="form-label required-star">Buyer Email</label>
                    <input type="email" class="form-control" id="buyer_email" name="buyer_email">
                    <div class="invalid-feedback" id="buyerEmailError"></div>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="phone" class="form-label required-star">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                    <div class="invalid-feedback" id="phoneError"></div>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="city" class="form-label required-star">City</label>
                    <input type="text" class="form-control" id="city" name="city">
                    <div class="invalid-feedback" id="cityError"></div>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="amount" class="form-label required-star">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount">
                    <div class="invalid-feedback" id="amountError"></div>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="receipt_id" class="form-label required-star">Receipt ID</label>
                    <input type="text" class="form-control" id="receipt_id" name="receipt_id">
                    <div class="invalid-feedback" id="receiptIdError"></div>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="entry_by" class="form-label required-star">Entry By</label>
                    <input type="number" class="form-control" id="entry_by" name="entry_by">
                    <div class="invalid-feedback" id="entryByError"></div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="note" class="form-label">Note</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    <div class="invalid-feedback" id="noteError"></div>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-sm item-table">
                        <tr>
                            <th class="required-star">Items</th>
                            <th>Action</th>
                        </tr>
                        <tr class="item-row">
                            <td>
                                <input type="text" name="items[]" class="form-control">
                                <div class="invalid-feedback" id="itemsError"></div>
                            </td>
                            <td>
                                <label class="btn btn-primary btn-sm add-more" title="Add More"><i class="fa fa-plus-circle"></i></label>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-secondary btn-sm fw-bold" href="../../buyer_list.php">
                    <i class="fa fa-backward"></i> Back
                </a>
                <button type="submit" name="save_buyer" class="btn btn-primary btn-sm">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Scripting Code Here -->
<script src="../../assets/js/jquery-3.6.0.min.js"></script>
<script src="../../assets/js/jquery.validate.min.js"></script>
<script src="../../assets/js/additional-methods.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataForm').validate({
            rules: {
                amount: {
                    required: true,
                    digits: true
                },
                buyer: {
                    required: true,
                    minlength: 1,
                    maxlength: 20
                },
                receipt_id: {
                    required: true,
                    alphanumeric: true
                },
                'items[]': {
                    required: true,
                    minlength: 1
                },
                buyer_email: {
                    required: true,
                    email: true
                },
                note: {
                    required: true,
                    maxlength: 30
                },
                city: {
                    required: true,
                    lettersonly: true
                },
                phone: {
                    required: true,
                    bdphone: true
                },
                entry_by: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                amount: {
                    required: "Amount is required",
                    digits: "Please enter a valid number"
                },
                buyer: {
                    required: "Buyer is required",
                    minlength: "Buyer must be at least 1 character long",
                    maxlength: "Buyer cannot exceed 20 characters"
                },
                receipt_id: {
                    required: "Receipt ID is required",
                    alphanumeric: "Receipt ID must be alphanumeric"
                },
                'items[]': {
                    required: "At least one item is required"
                },
                buyer_email: {
                    required: "Email is required",
                    email: "Please enter a valid email address"
                },
                note: {
                    required: "Note is required",
                    maxlength: "Note cannot exceed 30 characters"
                },
                city: {
                    required: "City is required",
                    lettersonly: "City must contain only letters and spaces"
                },
                phone: {
                    required: "Phone number is required",
                    bdphone: "Please enter a valid Bangladeshi phone number"
                },
                entry_by: {
                    required: "Entry By is required",
                    digits: "Entry By must be a number"
                }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') === 'items[]') {
                    error.insertAfter(element.closest('tr').find('.invalid-feedback'));
                } else {
                    error.insertAfter(element.siblings('.invalid-feedback'));
                }
            },
        });

        /**************************************
         PHONE NUMBER PREFIX CUSTOM VALIDATION 
        ***************************************/
        $.validator.addMethod('bdphone', function(value, element) {
            var cleanedValue = value.replace(/^\880/, '').replace(/\s+/g, ''); // Remove the prefix if it exists
            return this.optional(element) || /^\d{10}$/.test(cleanedValue); // Validate if cleaned value is exactly 10 digits
        }, 'Please enter a valid Bangladeshi phone number.');

        /**********************************************
         CUSTOM VALIDATION FOR ALPHANUMERIC VALUES ONLY 
        ************************************************/
        // Custom validation method for alphanumeric values
        $.validator.addMethod('alphanumeric', function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        }, 'Please enter only alphanumeric characters.');

        /*************************************
         CUSTOM VALIDATION FOR LETTERS ONLY 
        **************************************/
        $.validator.addMethod('lettersonly', function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        }, 'Please enter only letters.');

        /*************************************
         ADD MORE ITEMS SCRIPTING START HERE
        **************************************/
        $(document).on('click', '.add-more', function() {
            let row = $('.item-row').eq(0).clone();
            let rowIndex = $('.item-row').length;
            if (rowIndex >= 5) {
                alert("Maximum 5 rows allowed!");
                return false;
            }
            row.find('.add-more')
                .removeClass('add-more btn-primary is-invalid error')
                .removeAttr('title label')
                .attr('title', 'Remove')
                .addClass('btn-danger remove')
                .html('<i class="fa fa-minus-circle"></i>');

            row.find('input').val('');
            $('.item-table').append(row);
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        });
    });
</script>