<div class="card">
            <div class="card-header">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title fw-bold mb-0">
                        <i class="fa fa-list-alt me-2"></i> {{ __('Holidays') }}
                    </h4>
                    <a class="btn btn-success btn-sm fw-bold" title="Create New" href="{{ route('holidays.create') }}">
                        <i class="fa fa-plus-circle"></i> Create
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="submissionForm" method="POST">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                        <div class="invalid-feedback">Please enter a valid amount (numbers only).</div>
                    </div>
                    <div class="mb-3">
                        <label for="buyer" class="form-label">Buyer</label>
                        <input type="text" class="form-control" id="buyer" name="buyer" maxlength="20" required>
                        <div class="invalid-feedback">Please enter a valid buyer name (max 20 characters, letters, spaces, and numbers only).</div>
                    </div>
                    <div class="mb-3">
                        <label for="receipt_id" class="form-label">Receipt ID</label>
                        <input type="text" class="form-control" id="receipt_id" name="receipt_id" required>
                        <div class="invalid-feedback">Please enter a valid receipt ID.</div>
                    </div>
                    <div class="mb-3">
                        <label for="items" class="form-label">Items</label>
                        <input type="text" class="form-control" id="items" name="items" required>
                        <div class="invalid-feedback">Please enter valid items (text only).</div>
                    </div>
                    <div class="mb-3">
                        <label for="buyer_email" class="form-label">Buyer Email</label>
                        <input type="email" class="form-control" id="buyer_email" name="buyer_email" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3" maxlength="30"></textarea>
                        <div class="invalid-feedback">Please enter a valid note (max 30 words).</div>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                        <div class="invalid-feedback">Please enter a valid city (letters and spaces only).</div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                        <div class="invalid-feedback">Please enter a valid phone number (numbers only).</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>