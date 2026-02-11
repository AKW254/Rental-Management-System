// assets/js/tenant-payment-table.js
(() => {
  if (typeof $.fn.DataTable === "undefined") {
    console.error(
      "DataTables library is not loaded. Please include the required DataTables JS and CSS files.",
    );
    return;
  }

  $(document).ready(() => {
    const $table = $("#tenantPaymentTable");
    if (!$table.length) return;

    window.tenantPaymentTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/tenant_list_payments.php",
        dataSrc: "",
      },
      rowId: "payment_id",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "invoice_id" },
        { data: "payment_method" },
        {
          data: "payment_amount",
          render: (amount) => {
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
        { data: "payment_transaction_id" },
        { data: "payment_created_at" },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "desc"]],
    });
  });
})();
