<?php
$sql = "SELECT inv.invoice_id, inv.invoice_amount
        FROM invoices AS inv
        INNER JOIN rental_agreements AS ra ON inv.agreement_id = ra.agreement_id
        WHERE ra.tenant_id = ?
        ORDER BY inv.invoice_date DESC";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    $row = [
        'invoice_id' => (int)$r['invoice_id'],
        'invoice_amount' => $r['invoice_amount']
    ];
?>
    <!--Pay Invoice Modal -->
    <div class="modal fade" id="payinvoiceModal-<?php echo $row['invoice_id']; ?>" tabindex="-1" aria-labelledby="payInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payInvoiceModalLabel">Pay Invoice #<?php echo $row['invoice_id'] ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Ã—</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="payinvoiceForm-<?php echo $row['invoice_id'] ?>">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <input type="hidden" class="form-control" name="action" value="pay_invoice" required>
                                <label for="payment_amount" class="col-form-label">Invoice Amount:</label>
                                <input type="text" class="form-control" id="payment_amount" name="payment_amount" value="<?php echo htmlspecialchars($row['invoice_amount']); ?>" readonly>
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
                                <input type="tel" class="form-control" id="mpesa_phone-<?php echo $row['invoice_id']; ?>" name="mpesa_phone" placeholder="2547XXXXXXXX" pattern="[0-9]{9,13}">
                            </div>

                            <script>
                                (function() {
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
<?php
}
?>
