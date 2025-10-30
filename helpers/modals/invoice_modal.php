<?php
$res = $mysqli->query("SELECT invoice_id,agreement_id,invoice_date,invoice_due_date,invoice_amount,invoice_status FROM invoices");
while ($r = $res->fetch_assoc()) {
    $row = ['invoice_id' => $r['invoice_id'], 'agreement_id' => $r['agreement_id'], 'invoice_date' => $r['invoice_date'], 'invoice_due_date' => $r['invoice_due_date'], 'invoice_amount' => $r['invoice_amount'], 'invoice_status' => $r['invoice_status']];
?>
    <!--Edit property details -->
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
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label for="recipient-name" class="col-form-label">
                                    <p>Are you sure you want to delete this invoice? This process cannot be undone.</p>
                                </label>
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