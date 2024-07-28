<?php

    if (isset($_POST['save_buyer'])) {
        $response = $application->saveBuyer($_POST); // response array
    }

?>
<div class="row">
    <div class="col-md-12 message-div"></div>
</div>
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
                                <input type="text" name="items[]" class="form-control item-input">
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
                    alphanumeric: "Receipt ID must be alphanumeric and no space allowed"
                },
                'items[]': {
                    required: "Fill up the item"
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
                    bdphone: "Please enter a valid phone number and enter the last 10 digits" // mobile
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
                if (element.hasClass('item-input')) {
                    error.insertAfter(element.closest('.item-row').find('.invalid-feedback'));
                } else {
                    error.insertAfter(element.siblings('.invalid-feedback'));
                }
            },
            submitHandler: function(form) {
                var formData = $(form).serialize();
                $.ajax({
                    url: '../../classes/SaveBuyerDataByAjax.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.statusCode === 200) {
                            let successHtml = ` <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Success!</strong> ${response.message}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>`;
                            $('.message-div').html(successHtml);
                            form.reset(); // Reset the form
                            $('#dataForm').find('input, textarea').removeClass('is-valid');
                            
                        }else if (response.statusCode === 400) {
                            let errorsHtml = `<div class="alert alert-danger alert-dismissible fade show" role="alert">`;
                            $.each(response.errors, function(index, error) {
                                errorsHtml += error + '<br>';
                            });
                            errorsHtml+= `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                            $('.message-div').html(errorsHtml);
                        } else if (response.statusCode === 500) {
                            let errorHtml = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> ${response.message}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>`;
                            $('.message-div').html(errorHtml);

                        } else{
                            let successHtml = ` <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <strong>Warning!</strong> ${response.message}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>`;
                            $('.message-div').html(successHtml);
                        }
                },
                error: function() {
                    $('.alert-danger').html('<strong>Error!</strong> An error occurred.').show();
                }
            });
                return false; // Prevent normal form submission
            }
        });

        /********************************************
         SET PHONE NUMBER PREFIX HANDELING SCRIPTING 
        *********************************************/
        var prefix = '880';

        function handlePhoneNumber() {
            var $phoneInput = $('#phone');

            // Function to add prefix if not already present
            function addPrefix() {
                var value = $phoneInput.val();
                if (!value.startsWith(prefix)) {
                    $phoneInput.val(prefix + value);
                }
            }

            // Remove the prefix during typing
            function removePrefix() {
                var value = $phoneInput.val();
                if (value.startsWith(prefix)) {
                    $phoneInput.val(value.replace(prefix, ''));
                }
            }

            // On input, ensure the prefix is added
            $phoneInput.on('input', function() {
                var value = $phoneInput.val();
                if (value.length > prefix.length && !value.startsWith(prefix)) {
                    addPrefix();
                }
            });

            // On focus, remove prefix for editing
            $phoneInput.on('focus', function() {
                removePrefix();
            });

            // On blur, re-add the prefix if necessary
            $phoneInput.on('blur', function() {
                addPrefix();
            });
        }

        //Initialize phone number handling
        handlePhoneNumber();

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
                alert("Maximum 5 items allowed!");
                return false;
            }
            row.find('.add-more')
                .removeClass('add-more btn-primary')
                .removeAttr('title')
                .attr('title', 'Remove')
                .addClass('btn-danger remove')
                .html('<i class="fa fa-minus-circle"></i>');

            row.find('input').removeClass('is-invalid error is-valid').removeAttr('id').attr('id', `itemsError${rowIndex}`);
            row.find('.invalid-feedback').removeAttr('id').attr('id', `itemsError${rowIndex}`);
            row.find('.error').text('');    
            row.find('input').each(function(i,input){
                input.name = input.name.replace('[0]', '[' + rowIndex + ']');
                $(input).val('');
            });
            $('.item-table').append(row);
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        });
    });
</script>