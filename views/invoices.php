<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login()
//Check if user is logged in

?>
<!DOCTYPE html>
<html lang="en">

<?php include('../partials/head.php') ?>

<body>
    <div class="container-scroller">

        <!-- partial:partials/_sidebar.html -->
        <?php include('../partials/sidebar.php') ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <?php include('../partials/navbar.php') ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Invoices </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex align-items-right  flex-wrap">
                                    <div class="col-12 col-md-6 form-group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">Create Invoice Manually</button>
                                        <!--Add User Modal -->
                                        <div class="modal fade" id="createInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="createInvoiceModalLabel">Create New Invoice</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="createInvoiceForm" method="POST">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <input type="hidden" name="action" value="create_invoice">
                                                                    <label for="property_id" class="col-form-label">Property:</label>
                                                                    <select name="property_id" id="property_id" class="form-control p_input">
                                                                        <?php
                                                                        $sql = "SELECT property_id, property_name FROM properties";
                                                                        $result = $mysqli->query($sql);
                                                                        if ($result && $result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo "<option value='" . (int)$row['property_id'] . "'>" . htmlspecialchars($row['property_name']) . "</option>";
                                                                            }
                                                                        } else {
                                                                            echo "<option value=''>No properties</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="room_id" class="col-form-label">Select Room:</label>
                                                                    <select name="agreement_id" id="room_id" class="form-control p_input">
                                                                        <option value="">Select a property first</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="invoice_due_date" class="col-form-label">Invoice Due Date:</label>
                                                                    <input type="date" name="invoice_due_date" id="invoice_due_date" class="form-control p_input" required>

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
                                    </div>


                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="invoiceTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Invoice No</th>
                                                    <th>Room No</th>
                                                    <th>Amount</th>
                                                    <th>Invoice Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="invoiceTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
                                            </tbody>

                                        </table>
                                        <?php include '../helpers/modals/invoice_modal.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main-panel ends -->
                <!-- container-scroller -->
                <?php include('../functions/custom_alerts.php'); ?>
                <!-- Property selection and room filtering script -->
                <?php
                // Prepare rooms grouped by property_id for client-side filtering
                $rooms_by_property = [];
                $sql = "SELECT rm.room_id, rm.room_title, ra.agreement_id, rm.property_id FROM rental_agreements AS ra INNER JOIN rooms AS rm ON ra.room_id = rm.room_id WHERE ra.agreement_status = 'Active'";
                $res = $mysqli->query($sql);
                if ($res && $res->num_rows > 0) {
                    while ($r = $res->fetch_assoc()) {
                        $pid = (int)$r['property_id'];
                        $rooms_by_property[$pid][] = [
                            'agreement_id' => $r['agreement_id'],
                            'room_id' => $r['room_id'],
                            'room_title' => $r['room_title']
                        ];
                    }
                }
                $rooms_json = json_encode($rooms_by_property, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                ?>

                <script>
                    (function() {
                        const roomsByProperty = <?php echo $rooms_json ?: '{}'; ?>;
                        const propertySelect = document.getElementById('property_id');
                        const roomSelect = document.getElementById('room_id');

                        function populateRooms(propId) {
                            roomSelect.innerHTML = '';
                            const rooms = roomsByProperty[propId] || [];
                            if (rooms.length === 0) {
                                const opt = document.createElement('option');
                                opt.value = '';
                                opt.textContent = 'No rented rooms available';
                                roomSelect.appendChild(opt);
                                return;
                            }
                            rooms.forEach(r => {
                                const opt = document.createElement('option');
                                opt.value = r.agreement_id;
                                opt.textContent = r.room_title;

                                roomSelect.appendChild(opt);
                            });
                        }

                        // on property change
                        propertySelect.addEventListener('change', function() {
                            populateRooms(this.value);
                        });

                        // initial populate for the currently selected property (if any)
                        if (propertySelect.value) {
                            populateRooms(propertySelect.value);
                        }
                    })();
                </script>

                <!--Create Invoice Manually Script -->
                <script>
                    document.getElementById('createInvoiceForm').addEventListener('submit', async function(e) {
                        e.preventDefault();
                        const form = this;
                        const formData = new FormData(form);

                        try {
                            const res = await fetch('../functions/Manage_invoice.php', {
                                method: 'POST',
                                body: formData
                            });
                            const result = await res.json();

                            if (!result.success) {
                                return showToast('error', result.error || 'Failed to create');
                            }

                            // 1) Close the correct modal
                            const modalEl = document.getElementById(`createInvoiceModal`);
                            bootstrap.Modal.getOrCreateInstance(modalEl).hide();

                            // 2) Refresh the DataTable
                            if (window.invoiceTable && window.invoiceTable.ajax) {
                                window.invoiceTable.ajax.reload(null, false);
                            }
                            // 3) Show success message
                            showToast('success', result.message);
                        } catch (err) {
                            console.error(err);
                            showToast('error', 'Network error');
                        }
                    });
                </script>
                <!--Edit Invoice Script -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        document
                            .querySelectorAll('form[id^="editinvoiceForm-"]')
                            .forEach(form => {
                                form.addEventListener('submit', async function(e) {
                                    e.preventDefault();
                                    const formData = new FormData(this);
                                    const invoiceId = formData.get('invoice_id');
                                    try {
                                        const res = await fetch('../functions/manage_invoice.php', {
                                            method: 'POST',
                                            body: formData
                                        });
                                        const result = await res.json();

                                        if (result.success) {
                                            // Safely close the modal
                                            const modalEl = document.getElementById(`editinvoiceModal-${invoiceId}`);
                                            bootstrap.Modal.getOrCreateInstance(modalEl).hide();

                                            // Refresh DataTable
                                            window.invoiceTable?.ajax?.reload(null, false);
                                            showToast('success', result.message);
                                        } else {
                                            showToast('error', result.error);
                                        }
                                    } catch (err) {
                                        console.error(err);
                                        showToast('error', 'Network error');
                                    }
                                });
                            });
                    });
                </script>


                <!--Delete Invoice Script -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const deleteInvoiceForms = document.querySelectorAll('form[id^="deleteInvoiceForm-"]');
                        deleteInvoiceForms.forEach(form => {
                            form.addEventListener('submit', async function(e) {
                                e.preventDefault();
                                const formData = new FormData(this);
                                const invoiceId = formData.get('invoice_id');

                                try {
                                    const response = await fetch('../functions/manage_invoice.php', {
                                        method: 'POST',
                                        body: formData
                                    });

                                    const result = await response.json();

                                    if (result.success) {
                                        // Close modal
                                        bootstrap.Modal.getInstance(
                                            document.getElementById('deleteInvoiceModal-' + invoiceId)
                                        ).hide();

                                        // 2) Reload the DataTable
                                        if (window.invoiceTable && window.invoiceTable.ajax) {
                                            window.invoiceTable.ajax.reload(null, false);
                                        }
                                        showToast('success', result.message);
                                    } else {
                                        showToast('error', result.error || 'An error occurred.');
                                    }
                                } catch (error) {
                                    console.error('Fetch error:', error);
                                    showToast('error', 'A network error occurred.');
                                }
                            });
                        });
                    });
                </script>
                <!-- Pay Invoice Script -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        document
                            .querySelectorAll('form[id^="payinvoiceForm-"]')
                            .forEach(form => {
                                form.addEventListener('submit', async function(e) {
                                    e.preventDefault();
                                    const formData = new FormData(this);
                                    const invoiceId = formData.get('invoice_id');
                                    try {
                                        const res = await fetch('../functions/manage_payments.php', {
                                            method: 'POST',
                                            body: formData
                                        });
                                        const result = await res.json();

                                        if (result.success) {
                                            // Close modal
                                            bootstrap.Modal.getInstance(
                                                document.getElementById('payinvoiceModal-' + invoiceId)
                                            ).hide();

                                            // Refresh DataTable
                                            window.invoiceTable?.ajax?.reload(null, false);
                                            showToast('success', result.message);
                                        } else {
                                            showToast('error', result.error);
                                        }
                                    } catch (err) {
                                        console.error(err);
                                        showToast('error', 'Network error');
                                    }
                                });
                            });
                    });
                </script>
                <!-- Script to get the role type from the selected role -->
                <script src="../public/assets/vendors/modal/modal-demo.js"></script>
                <?php include('../partials/scripts.php') ?>
                <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/invoice-table.js"></script>



</body>



</html>