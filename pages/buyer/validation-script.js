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
            if (element.hasClass('item-input')) {
                error.insertAfter(element.closest('.item-row').find('.invalid-feedback'));
            } else {
                error.insertAfter(element.siblings('.invalid-feedback'));
            }
        },
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