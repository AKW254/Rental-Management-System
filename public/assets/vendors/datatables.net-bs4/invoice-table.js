// assets/js/property-table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === 'undefined') {
    console.error('DataTables library is not loaded. Please include the required DataTables JS and CSS files.');
    return;
  }

  $(document).ready(() => {
    const $table = $("#invoiceTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.invoiceTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/list_invoices.php", // returns JSON []
        dataSrc: "",
      },
      rowId: "invoice_id",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "invoice_id" },
        { data: "room_title" },
        { data: "invoice_amount" },
        { data: "invoice_due_date" },
        { data: "invoice_status" },
        {
          data: null,
          orderable: false,
          render: (row) => `
         
            <button class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#editinvoiceModal-${row.invoice_id}">
              Edit
            </button>
            <button class="btn btn-sm btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteInvoiceModal-${row.invoice_id}">
              Delete
            </button>
            
            `,
        },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "asc"]],
    });
  });
})();
