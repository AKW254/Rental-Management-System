<?php
$res = $mysqli->query("SELECT invoice_id,agreement_id,invoice_date,invoice_due_date,invoice_amount,invoice_status FROM invoices");
while ($r = $res->fetch_assoc()) {
    $row = ['invoice_id' => $r['invoice_id'], 'agreement_id' => $r['agreement_id'], 'invoice_date' => $r['invoice_date'], 'invoice_due_date' => $r['invoice_due_date'], 'invoice_amount' => $r['invoice_amount'], 'invoice_status' => $r['invoice_status']];
?>
<!--Pay Invoice Modal -->
    <div class="modal fade" id="payinvoiceModal-<?php echo $row['invoice_id']; ?>" tabindex="-1" aria-labelledby="payInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payInvoiceModalLabel">Pay Invoice #<?php echo $row['invoice_id'] ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="payinvoiceForm-<?php echo $row['invoice_id'] ?>">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <input type="hidden" class="form-control"  name="action" value="pay_invoice" required>
                                <label for="payment_amount" class="col-form-label">Invoice Amount:</label>
                                <input type="text" class="form-control" id="payment_amount" name="payment_amount" value="<?php echo $row['invoice_amount'] ?>" readonly>
                                <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id'] ?>" id="invoice_id-<?php echo $row['invoice_id']; ?>">
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="property-location" class="col-form-label">Mode of Payment:</label>
                                <select class="form-select" id="payment_mode-<?php echo $row['invoice_id']; ?>" name="payment_method" required>
                                    <option value="" selected disabled>Select Payment Mode</option>
                                    <option value="Mpesa">Mpesa</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-6 col-xl-6" id="mpesa_phone_group-<?php echo $row['invoice_id']; ?>" style="display:none;">
                                <label for="mpesa_phone-<?php echo $row['invoice_id']; ?>" class="col-form-label">Mpesa Phone Number:</label>
                                <input type="tel" class="form-control" id="mpesa_phone-<?php echo $row['invoice_id']; ?>" name="mpesa_phone" placeholder="2547XXXXXXXX" pattern="[0-9]{9,12}">
                            </div>

                            <script>
                            (function(){
                                var pm = document.getElementById('payment_mode-<?php echo $row['invoice_id']; ?>');
                                var phoneGroup = document.getElementById('mpesa_phone_group-<?php echo $row['invoice_id']; ?>');
                                var phone = document.getElementById('mpesa_phone-<?php echo $row['invoice_id']; ?>');

                                function toggle() {
                                    if (pm.value === 'Mpesa') {
                                        phoneGroup.style.display = '';
                                        phone.required = true;
                                    } else {
                                        phoneGroup.style.display = 'none';
                                        phone.required = false;
                                        phone.value = '';
                                    }
                                }

                                pm.addEventListener('change', toggle);
                                // initialize on load (in case a value is preselected)
                                toggle();
                            })();
                            </script>
                            

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Edit invoice details -->
    <div class="modal fade" id="editinvoiceModal-<?php echo $row['invoice_id']; ?>" tabindex="-1" aria-labelledby="editInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInvoiceModalLabel">Edit Invoice</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editinvoiceForm-<?php echo $row['invoice_id'] ?>">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <input type="hidden" class="form-control"  name="action" value="edit_invoice" required>
                                <label for="property-name" class="col-form-label">Invoice Amount:</label>
                                <input type="text" class="form-control" id="invoice_amount" name="invoice_amount" value="<?php echo $row['invoice_amount'] ?>" required>
                                <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id'] ?>" id="invoice_id-<?php echo $row['invoice_id']; ?>">
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="property-location" class="col-form-label">Invoice Due Date:</label>
                                <input type="date" class="form-control" id="invoice_due_date" name="invoice_due_date" value="<?php echo $row['invoice_due_date'] ?>" required>
                            </div>
                            
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!--Delete User details -->
    <div class="modal fade" id="deleteInvoiceModal-<?php echo $row['invoice_id']; ?>" tabindex="-1" aria-labelledby="deleteInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteInvoiceModalLabel">Delete Invoice #<?php echo $row['invoice_id'] ?> ?</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteInvoiceForm-<?php echo $row['invoice_id'] ?>" method="POST">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xl-12">
                               
                                    <p>Are you sure you want to delete this invoice? This process cannot be undone.</p>
                            
                                <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id'] ?>" id="invoice_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>