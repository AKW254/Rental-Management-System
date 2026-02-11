// assets/js/rental_agreement_table.js
(() => {
  // Ensure DataTables library is loaded
  if (typeof $.fn.DataTable === "undefined") {
    console.error(
      "DataTables library is not loaded. Please include the required DataTables JS and CSS files.",
    );
    return;
  }

  $(document).ready(() => {
    const $table = $("#tenantrentalAgreementTable");
    if (!$table.length) return;

    // Initialize and store globally
    window.tenantrentalAgreementTable = $table.DataTable({
      ajax: {
        url: "/Rental-Management-System/functions/tenant_list_rental_agreements.php",
        dataSrc: "",
      },
      rowId: "agreement_id",
      columns: [
        {
          data: null,
          render: (_, __, ___, meta) => meta.row + 1,
        },
        { data: "room_title" },
        { data: "property_name" },
        { data: "landlord_name" },
        { data: "agreement_start_date" },
        {
          data: "agreement_end_date",
          render: (value) => (value ? value : "N/A"),
        },
        { data: "agreement_status" },
        {
          data: null,
          orderable: false,
          render: (row) => `
            <a href="room-details.php?room_id=${row.room_id}"
               class="btn btn-sm btn-primary">
              View
            </a>
          `,
        },
      ],
      responsive: true,
      pageLength: 10,
      order: [[1, "asc"]],
    });
  });
})();
