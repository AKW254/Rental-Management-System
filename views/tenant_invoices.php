<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">

<?php include('../partials/head.php') ?>

<body class="sidebar-icon-only sidebar-fixed">
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
                        <h3 class="page-title">My Invoices</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="tenant_dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tenantInvoiceTable" class="table">
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
                                            <tbody id="tenantInvoiceTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
                                            </tbody>
                                        </table>
                                        <?php include '../helpers/modals/tenant_invoices.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- main-panel ends -->
            <!-- container-scroller -->
            <?php include('../functions/custom_alerts.php'); ?>

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
                                        bootstrap.Modal.getInstance(
                                            document.getElementById('payinvoiceModal-' + invoiceId)
                                        ).hide();

                                        window.tenantInvoiceTable?.ajax?.reload(null, false);
                                        showToast('success', result.message);
                                    } else {
                                        showToast('error', result.error || 'Payment failed.');
                                    }
                                } catch (err) {
                                    console.error(err);
                                    showToast('error', 'Network error');
                                }
                            });
                        });
                });
            </script>

            <?php include('../partials/scripts.php') ?>
            <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/tenant_invoice-table.js"></script>

</body>

</html>
