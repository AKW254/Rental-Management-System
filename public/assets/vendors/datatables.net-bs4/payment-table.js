// assets/js/property-table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === "undefined") {
    console.error(
      "DataTables library is not loaded. Please include the required DataTables JS and CSS files."
    );
    return;
  }

  $(document).ready(() => {
    const $table = $("#paymentTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.paymentTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/list_payments.php", // returns JSON []
        dataSrc: "",
      },
      rowId: "payment_id",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "payment_method" },
        { data: "payment_amount" },

        { data: "payment_transaction_code" },
        { data: "payment_created_at" },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "asc"]],
    });
  });
})();
