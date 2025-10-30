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
        url: "/Rental-Management-System/functions/list_invoices.php",
        dataSrc: "",
      },
      rowId: "invoice_id",
      createdRow: (row, data) => {
        const status = (data.invoice_status || "").toLowerCase();
        if (status === "overdue") {
          $(row).addClass("table-danger");
        } else if (status === "paid") {
          $(row).addClass("table-success");
        } else if (status === "pending" || status === "unpaid") {
          $(row).addClass("table-warning");
        }
      },
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "invoice_id" },
        { data: "room_title" },
        {
          data: "invoice_amount",
          render: (amount) => {
            // Format as currency (adjust locale/currency as needed)
            try {
              return new Intl.NumberFormat("en-Kenya", {
                style: "currency",
                currency: "KES",
              }).format(Number(amount));
            } catch {
              return amount;
            }
          },
        },
        { data: "invoice_date" },
        { data: "invoice_due_date" },
        {
          data: "invoice_status",
          render: (status) => {
            const s = (status || "").toString();
            const key = s.toLowerCase();
            let cls = "secondary";
            if (key === "paid") cls = "success";
            else if (key === "overdue") cls = "danger";
            else if (key === "pending" || key === "unpaid") cls = "warning";
            return `<span class="badge bg-${cls}">${s}</span>`;
          },
        },
        {
          data: null,
          orderable: false,
          render: (row) => `
           <button class="btn btn-sm btn-info"
                    data-bs-toggle="modal"
                    data-bs-target="#payinvoiceModal-${row.invoice_id}">
              Pay
            </button>
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
